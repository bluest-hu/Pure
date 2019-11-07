import * as tocbot from 'tocbot';
import { raf } from "./raf.js";

console.log(raf);

function toc () {
  // TOC Gen
  tocbot.init({
    contentSelector: '.post-entry.entry-content',
    tocSelector: '#jsToc',
    headingSelector: 'h1, h2, h3, h4, h5, h6',
    // hasInnerContainers: true,
    scrollSmooth: true,
    headingsOffset: 100,
    collapseDepth: 3,
    // scrollContainer: 'html',
    // positionFixedSelector: '.post-entry.entry-content'
  });

  // 判断
  const tocDom = document.getElementById('jsToc');
  const titleDom = document.querySelectorAll('.post-title.entry-title')[0];

  if (!tocDom) {
    return false;
  }

  let shouldPassScroll = false;
  let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

  if (window.IntersectionObserver === null) {

  } else {
    document.addEventListener('scroll', () => {
      if (shouldPassScroll) {
        return false;
      }
      shouldPassScroll = true;

      raf(() => {
        shouldPassScroll = false;
        // scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if (titleDom.getBoundingClientRect().top <= 0) {
          tocDom.classList.add('fixed');
        } else {
          tocDom.classList.remove('fixed');
        }
      });
    }, {passive: true})
  }
  
}

export default toc;
