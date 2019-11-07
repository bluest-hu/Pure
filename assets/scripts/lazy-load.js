import { raf } from "./raf.js";
class LazyLoad {
  constructor(selector) {
    this.targetElements = Array.from(document.querySelectorAll(selector));
    
    if (window.IntersectionObserver) {
      const io = new IntersectionObserver(
        changes => {
          changes.forEach(change => {
            if (change.intersectionRatio > 0) {
              const image = change.target;
              const { src } = image.dataset;
              if (image && src) {
                image.src = src;
              }
              io.unobserve(image);
            }
          });
        },
        {
          rootMargin: "0px 0px 0px 0px",
          // threshold: 0.01
        }
      );

      this.targetElements.forEach(image => {
        io.observe(image);
      });
    } else {
      let shouldPass = false;
      window.addEventListener("scroll", () => {
        if (shouldPass) {
          return false;
        }
        shouldPass = true;
        raf(() => {
          shouldPass = false;
          this.check();
        });
      }, {passive: true});
      this.check();
    }
  }

  check() {
    const self = this;
    this.targetElements.forEach((image, index) => {
      if (self.isInSight(image)) {
        const { src } = image.dataset;
        image.src = src;
        this.targetElements.splice(index, 1);
      }
    });
  }

  isInSight(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && 
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
}

export default LazyLoad;
