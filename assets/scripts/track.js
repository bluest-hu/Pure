const TRACK_URL = "/wp-json/wp_theme_pure/v1/ga";

/**
 * 借助 worpdress 转发到 Measurement Protocol，解决 Google 统计容易被屏蔽的问题
 * https://developers.google.com/analytics/devguides/collection/protocol/v1
 */
class Track {
  /**
   * 初始化配置，默认发送 pageView、timing、exception
   * @param {*} config 
   */
  constructor(config = {}) {
    this.logexception = config.logexception !== false;
    this.logTiming = config.logTiming !== false;
    this.logPageView = config.logPageView !== false;

    const { value } = document.querySelector('#googleAnalyticsId');

    this.canSend = !!value;

    const self = this;

    if (this.logexception === true) {
      window.addEventListener("error", event => {
        self.doLogException(event.message);
      });
    }

    if (this.logPageView === true) {
      self.doLogView();
    }

    if (this.logTiming === true) {
      window.addEventListener("load", () => {
        self.doLogTiming();
      });
    }
  }

  /**
   * 获取 组合好的 FormData 
   * 不支持 IE
   * @param {*} data
   */
  genFormData(data) {
    const screen = window.screen;
    //基本数据，每次请求都会发送
    // https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
    const basicDataPackage = {
      v: 1,
      // z: new Date() * 1,
      ci: location.hash,
      // tid: "", // tracking id
      // cid: "", // client id
      // uid: "", // user id
      // uip: '', // user ip
      ul: navigator.language.toLowerCase(), // user language
      // t: "pageview", // “pageview”、“screenview”、“event”、“transaction”、“item”、“social”、“exception”、“timing”
      // fl: "", // flash version
      // je: 0, // java version
      // ua: navigator.userAgent, // user agent
      dh: location.host, // document host
      ds: "web",
      dp: window.location.pathname,
      // dclid: "", // 指定 Google 展示广告 ID
      dl: encodeURIComponent(location.href), // document location
      dt: encodeURIComponent(document.title),
      dr: encodeURIComponent(document.referrer), // referrer
      de: document.characterSet || document.charset || document.inputEncoding,
      // gclid: "", // 指定 Google Ads ID
      sd: screen.colorDepth + "-bit", // screen depth
      sr: `${screen.width}x${screen.height}`, // screen resolution
      vp: `${screen.availWidth}x${screen.availHeight}` // visible part
    };

    const payload = new FormData();

    Object.keys(basicDataPackage).forEach((key, index) => {
      payload.set(key, basicDataPackage[key]);
    });

    if (data && typeof data === "object") {
      Object.keys(data).forEach((key, index) => {
        payload.set(key, data[key]);
      });
    }

    return payload;
  }

  /**
   * 发送数据，如果不支持 sendBeacon 会降级到 XMLHttpRequest 
   * @param {*} data 
   */
  send(data) {
    if (!this.canSend) {
      return false;
    }

    const payload = this.genFormData(data);
    const url = `${TRACK_URL}?t=${new Date() * 1}`;

    if (navigator.sendBeacon) {
      navigator.sendBeacon(url, payload);
    } else {
      const xhr = new XMLHttpRequest();
      xhr.open('post', url);
      // xhr.onload = () => {};
      xhr.send(payload);
    }
  }

  /**
   * 获取页面性能信息
   */
  static getTimingData() {
    if (!window.performance || !window.performance.timing) {
      return null;
    }

    const t = window.performance.timing;
    let times = {};

    // 页面加载完成的时间
    // 从页面开始载入到绑定在 load 事件上的函数全部执行完毕
    times.PageLoadTime = t.loadEventEnd - t.navigationStart;
    // DOM 用时（包括资源加载和 DOM 树的解析和构建）
    times.DOMReady = t.domComplete - t.responseEnd;
    // DOM 交互用时
    times.DOMInteractiveTime = t.domInteractive - t.domLoading;
    // 重定向用时
    times.RedirectTime = t.redirectEnd - t.redirectStart;
    // DNS 用时
    times.DNSTime = t.domainLookupEnd - t.domainLookupStart;
    // TTFB 用时
    // 注意这里的 TTFB 用时包括了 TCP、SSL、DNS 时间
    times.TTFBTime = t.responseStart - t.navigationStart;
    // 服务器响应用时
    // 同时这也是 Chrome Dev Tools 的对 TTFB 的定义
    times.ServerResponseTime = t.responseStart - t.requestStart;
    // 页面下载时间
    times.PageDownloadTime = t.responseEnd - t.responseStart;
    // 从页面加载到 DOMContentLoaded 用时
    times.ContentLoadingTime = t.domContentLoadedEventStart - t.navigationStart;
    // 在 load 事件上的耗时
    times.LoadEventTime = t.loadEvent = t.loadEventEnd - t.loadEventStart;
    // 在 TCP 和 SSL 上的耗时
    times.TCPTime = t.connectEnd - t.connectStart;

    let ga_data = {
      // 这里 plt 统计的是到 load 事件开始的时间
      plt: t.loadEventStart - t.navigationStart,
      dns: times.DNSTime,
      pdt: times.PageDownloadTime,
      rrt: times.RedirectTime,
      tcp: times.TCPTime,
      srt: times.ServerResponseTime,
      dit: times.DOMInteractiveTime,
      clt: times.ContentLoadingTime
    };
    return ga_data;
  }

  doLogView() {
    const data = {
      t: "pageview"
    };
    this.send(data);
  }

  doLogTiming() {
    const timingData = Track.getTimingData();
    const data = {
      t: "timing",
      // utv: "load",
      // utc: "performance",
      // utt: 0,
      ...timingData
    };
    this.send(data);
  }

  doLogException(exd, exf = 1) {
    const data = {
      t: "exception",
      exd,
      exf
    };
    this.send(data);
  }
}
export default Track;
