// check_webp_feature:
//   'feature' can be one of 'lossy', 'lossless', 'alpha' or 'animation'.
//   'callback(feature, result)' will be passed back the detection result (in an asynchronous way!)
const check_webp_feature = (feature, callback = () => {}) => {
  const key = 'wp_theme_pure_webp_support_result';
  let resultCache = {};
  try {
    resultCache = JSON.parse(localStorage.getItem(key)) || {};
  } catch(e) {
    resultCache = {};
  }

  return new Promise((reslove, reject) => {
    if (resultCache[feature] !== undefined) {
      if (resultCache[feature]) {
        reslove(feature) 
      } else {
        reject(feature); 
      }
      return false;
    }

    var kTestImages = {
      lossy: "UklGRiIAAABXRUJQVlA4IBYAAAAwAQCdASoBAAEADsD+JaQAA3AAAAAA",
      lossless: "UklGRhoAAABXRUJQVlA4TA0AAAAvAAAAEAcQERGIiP4HAA==",
      alpha: "UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAARBxAR/Q9ERP8DAABWUDggGAAAABQBAJ0BKgEAAQAAAP4AAA3AAP7mtQAAAA==",
      animation: "UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA"
    };

    var img = new Image();
    img.onload = function () {
        var result = (img.width > 0) && (img.height > 0);
        resultCache[feature] = result;
        try {
          resultCache = localStorage.setItem(key, JSON.stringify(resultCache));
        } catch(e) {
          resultCache = {};
        }
        reslove(feature);
        callback(feature);
        img = null;
    };

    img.onerror = function () {
      resultCache[feature] = false;
      try {
        resultCache = localStorage.setItem(key, JSON.stringify(resultCache));
      } catch(e) {
        resultCache = {};
      }

      reject(feature);
      callback(false);
      img = null;
    };
    img.src = "data:image/webp;base64," + kTestImages[feature];
  });
}

export default check_webp_feature;
