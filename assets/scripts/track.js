(() => {
  let screen = window.screen;
  let date = new Date();

  let data = {
    v: 1,
    de: document.characterSet,
    tid: '', // traing id
    cid: '', // cliend id
    uid: '', // user id
    uip: '', // user ip
    ul: navigator.language, // user language
    z: date * 1,
    t: 'pageview', // “pageview”、“screenview”、“event”、“transaction”、“item”、“social”、“exception”、“timing”
    fl: '',  // flash version
    je: '',  // java version
    ua: navigator.userAgent, // user agent
    dh: location.host, // document host
    ds: 'web',
    dp: window.location.pathname,
    dclid: '', // 指定 Google 展示广告 ID
    dl: encodeURIComponent(location.href), // docuemt location
    dt: document.title,
    dr: document.referrer, // referrer
    de: document.characterSet || document.charset || document.inputEncoding,
    gclid: '', // 指定 Google Ads ID
    sd: screen.colorDepth, // screen depth
    sr: `${screen.width}x${screen.height}`, // screen resolution
    vp: `${screen.availWidth}x${screen.availHeight}`, // visuable part
  };
})();


