import "../../../../../wp-includes/js/wp-embed.js";
import LazyLoad from "./lazyLoad.js";
import Track from './track.js';
import toc from "./toc.js";
import "../scss/main.scss";
import loader from './auto-loader';



// 添加一个 tracker
new Track();
// lazy load
new LazyLoad(".post-entry img");
document.addEventListener("DOMContentLoaded", () => {
  const codeBlocks = document.querySelectorAll('.h-entry pre code');

  if (codeBlocks && codeBlocks.length > 0) {
    import(
      /* webpackPrefetch: true */
      /* webpackPreload: true */
      /* webpackChunkName: "prism" */
      /* webpackMode: "lazy" */
      'prismjs'
      ).then(Prism => {
       
        console.log(Prism)
        Prism.hooks.add('complete', function (env) {
          loader(env.language);
        });
    });
  }
  // gen TOC
  toc();
});
