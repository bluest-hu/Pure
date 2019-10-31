import Prism from 'prismjs';
import LazyLoad from "./lazy-load.js";
import Track from './track.js';
import '../scss/main.scss';
import '../styles/Prism.css';

document.addEventListener('DOMContentLoaded', () => {
  new LazyLoad('.post-entry img');
  Prism.highlightAll();
});

window.addEventListener('load', () => {
  if (!!window.ga && typeof window.ga === 'function') {
    // ga('send', 'timing');
  }
});
