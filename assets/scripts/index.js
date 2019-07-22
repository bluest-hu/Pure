import LazyLoad from "./lazy-load.js";
import Prism from 'prismjs';
import '../scss/main.scss';
import '../styles/Prism.css';

document.addEventListener('DOMContentLoaded', () => {
    new LazyLoad('.post-entry img');
    Prism.highlightAll();
});
