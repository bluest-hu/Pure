import { raf } from "./raf.js";
class LazyLoad {
  constructor(selector) {
    this.targetElements = Array.from(document.querySelectorAll(selector));
    this.shouldPass = false;
    // 默认不开启浏览器自带的 lazy loading
    this.nativeLazyLoadingFlag = false;

    if ('loading' in HTMLImageElement.prototype && this.nativeLazyLoadingFlag) {
      this.targetElements.forEach(image => {
        image.removeAttribute('src');
        const { src } = image.dataset;
        image.src = src;
      });
    } else if (window.IntersectionObserver) {
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
          rootMargin: "0px 0px 0px 0px"
          // threshold: 0.01
        }
      );

      this.targetElements.forEach(image => {
        io.observe(image);
      });
    } else {
      window.addEventListener("scroll", this.doCheck.bind(this), { passive: true });
      window.addEventListener('resize', this.doCheck.bind(this), { passive: true });
      this.doCheck();
    }
  }

  check() {
    const self = this;
    this.targetElements.forEach((image, index) => {
      if (self.isInSight(image)) {
        const { src } = image.dataset;
        image.src = src;
        this.targetElements.splice(index, 1);
        if (this.targetElements.length <= 0) {
          window.removeEventListener("scroll", self.doCheck);
          window.removeEventListener('resize', self.doCheck);
        }
      }
    });
  }

  isInSight(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <=
        (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  doCheck() {
    if (this.shouldPass) {
      return false;
    }
    const self = this;
    this.shouldPass = true;
    raf(() => {
      self.shouldPass = false;
      self.check();
    });
  };
}

export default LazyLoad;
