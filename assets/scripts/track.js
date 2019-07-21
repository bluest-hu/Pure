(() => {
    let screen = window.screen;
    let date = new Date();

    let data =  {
        v: 1,
        tid: '', // traing id
        cid: '', // cliend id
        uid: '', // user id
        uip: '', // user ip
        z: date * 1,
        t: 'pageview', // “pageview”、“screenview”、“event”、“transaction”、“item”、“social”、“exception”、“timing”
        fl: '',  // flash version
        je: '',  // java version
        ua: navigator.userAgent, // user agent
        dr: document.referrer, // referrer
        de: document.characterSet || document.charset || document.inputEncoding,
        ul: navigator.language, // user language
        gclid: '',
        dclid: '',
        sd: screen.colorDepth, // screen depth
        sr: `${screen.width}x${screen.height}`, // screen resolution
        vp: `${screen.availWidth}x${screen.availHeight}`, // visuable part
        dl: encodeURIComponent(location.href), // docuemt location
        dh: location.host, // document host
        // ds: 'web'
    };
})();
