import { runInThisContext } from "vm";

class LazyLoad {
  constructor(selector) {
    this.targetElements = Array.from(document.querySelectorAll(selector));

    if (window.IntersectionObserver) {
      const io = new IntersectionObserver((changes) => {
        changes.forEach((change) => {
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
        rootMargin: '50px 0px',
        threshold: 0.01
      });

      this.targetElements.forEach((image) => {
        io.observe(image);
      });
    } else {
      let timer = null;
      window.addEventListener('scroll', () => {
        clearTimeout(timer);
        timer = setTimeout(() => {
          this.check();
        }, 100);
      });

      this.check();
    }
  };

  check() {
    this.targetElements.forEach((image, index) => {
      if (this.isInSight(image)) {
        const { src } = image.dataset;
        image.src = src;
        this.targetElements.splice(index, 1);
      }
    });
  }

  isInSight(el) {
    const rect = el.getBoundingClientRect();
    return (rect.left + rect.width / 2) - (0 + window.innerWidth / 2) <= window.innerWidth / 2 - rect.width / 2 ||
      (window.innerHeight - rect.height) / 2;
  }
}

export default LazyLoad;
