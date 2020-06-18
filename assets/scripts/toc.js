import * as tocbot from "tocbot";
import { raf } from "./raf.js";

function toc() {
  // 判断
  const tocDom = document.getElementById("jsToc");
  const titleDom = document.querySelectorAll(".post-title.entry-title")[0];

  if (!tocDom) {
    return false;
  }

  // TOC Gen
  tocbot.init({
    contentSelector: ".post-entry.entry-content",
    tocSelector: "#jsToc",
    headingSelector: "h1, h2, h3, h4, h5, h6",
    // hasInnerContainers: true,
    scrollSmooth: true,
    headingsOffset: 100,
    collapseDepth: 3
    // scrollContainer: 'html',
    // positionFixedSelector: '.post-entry.entry-content'
  });

  let shouldPassScroll = false;
  let preCalResult  = null;
  // let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

  if (window.IntersectionObserver === null) {
    
  } else {
    document.addEventListener(
      "scroll",
      () => {
        if (shouldPassScroll) {
          return false;
        }
        shouldPassScroll = true;

        raf(() => {
          shouldPassScroll = false;
          // scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
          const needFixed = titleDom.getBoundingClientRect().top <= 0;

          if (needFixed !== preCalResult) {
            needFixed ?  tocDom.classList.add("fixed") :  tocDom.classList.remove("fixed");
          }
          preCalResult = needFixed;
        });
      },
      { passive: true }
    );
  }
}

export default toc;
