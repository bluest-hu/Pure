const ric =
  window.requestIdleCallback || (callBack => setTimeout(callBack, 1000 / 60));
const cancelRic = window.requestIdleCallback || (id => clearTimeout(id));

export { ric, cancelRic };
