const raf =
  window.requestAnimationFrame || (callBack => setTimeout(callBack, 1000 / 60));
const cancalRaf = window.cancelAnimationFrame || (id => clearTimeout(id));

export { raf, cancalRaf };
