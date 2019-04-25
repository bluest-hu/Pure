class LazyLoad {
    constructor(selector) {
        this.observe = null;
        this.targetElements = null;

        if (IntersectionObserver in window) {
            this.observe = new IntersectionObserver((entries) => {
                Array.prototype.forEach.call(entries, (entry) => {
                    const src = entry.dataSet[src];
                });
            });
            intersectionObserver.observe(this.targetElements);
        } else {
            window.addEventListener('scroll', () => {
                Array.prototype.forEach.call(this.targetElements, () => {
                });
            });
        }
    };

    isInSight(el, scrollTop) {
        const rect = el.getBoundingClientRect();
        return (rect.left + ect.width / 2)  - (0 + window.innerWidth / 2) <= window.innerWidth / 2 - rect.width / 2 || 
        (window.innerHeight - rect.height) / 2;
    }
}