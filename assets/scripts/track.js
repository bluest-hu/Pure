const TRACK_URL = "/wp-json/wp_theme_pure/v1/ga";

class Track {
  constructor(config = {}) {
    this.logexception = config.logexception === false ? false : true;
    this.logTiming = config.logTiming === false ? false : true;
    this.logPageView = config.logPageView === false ? false : true;

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
   *
   * @param {*} data
   */
  genFormData(data) {
    const screen = window.screen;
    const basicDataPackage = {
      v: 1,
      // z: new Date() * 1,
      ci: location.hash,
      // tid: "", // tracking id
      // cid: "", // client id
      // uid: "", // user id
      // uip: '', // user ip
      ul: navigator.language, // user language
      // t: "pageview", // “pageview”、“screenview”、“event”、“transaction”、“item”、“social”、“exception”、“timing”
      // fl: "", // flash version
      // je: 0, // java version
      ua: navigator.userAgent, // user agent
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

  send(data) {
    const payload = this.genFormData(data);

    if (navigator.sendBeacon) {
      navigator.sendBeacon(`${TRACK_URL}?t=${new Date() * 1}`, payload);
    }
  }

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
      utv: "load",
      utc: "Performence API",
      utt: 0,
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
