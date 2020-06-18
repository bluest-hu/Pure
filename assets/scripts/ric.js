import { raf, cancelRaf } from './raf';

const ric = window.requestIdleCallback || raf;
const cancelRic = window.requestIdleCallback || cancelRaf;

export { ric, cancelRic };
