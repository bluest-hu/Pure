import Prism from "prismjs";
import "../../../../../wp-includes/js/wp-embed.js";
import loadLanguages from "prismjs/components/";
import LazyLoad from "./lazy-load.js";
import Track from './track.js';
import toc from "./toc.js";
import "../scss/main.scss";

// 添加一个 tracker
new Track();

document.addEventListener("DOMContentLoaded", () => {
  // lazy load
  new LazyLoad(".post-entry img");
  // hightlight
  Prism.highlightAll();

  // gen TOC
  toc();

  
});

// window.addEventListener("load", () => {
//   if (!!window.ga && typeof window.ga === "function") {
//     // ga('send', 'timing');
//   }
// });
