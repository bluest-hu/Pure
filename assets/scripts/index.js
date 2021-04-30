import "../../../../../wp-includes/js/wp-embed.js";
import LazyLoad from "./lazyLoad.js";
import Track from './track.js';
// import toc from "./toc.js";
import "../scss/main.scss";
// import loader from './auto-loader';

// 添加一个 tracker
new Track();
// lazy load
new LazyLoad(".post-entry img");
document.addEventListener("DOMContentLoaded", () => {
  const codeBlocks = document.querySelectorAll('.h-entry pre code');

  if (codeBlocks && codeBlocks.length > 0) {
    import(
      /* webpackPrefetch: 0 */
      /* webpackPreload: 0 */
      /* webpackChunkName: "prism" */
      /* webpackMode: "lazy" */
      'prismjs'
      ).then(Prism => {
      /* webpackPrefetch: 0 */
      /* webpackPreload: 0 */
      /* webpackChunkName: "prismloader" */
      /* webpackMode: "lazy" */
      import('prismjs/plugins/autoloader/prism-autoloader.js').then(() => {
        Prism.plugins.autoloader.languages_path = '/wp-content/themes/pure/dist/prism-lan/';
        Prism.highlightAll();
      });
    });
  }

  // 判断
  const tocDom = document.getElementById("jsToc");

  if (tocDom) {
    /* webpackPrefetch: 0 */
    /* webpackPreload: 0 */
    /* webpackChunkName: "toc" */
    /* webpackMode: "lazy" */
    import('./toc').then(({default: toc}) => {
      toc();
    });
  }
});
