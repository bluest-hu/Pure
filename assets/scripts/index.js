import LazyLoad from "./lazy-load.js";
import Prism from 'prismjs';
import '../scss/main.scss';
import '../styles/Prism.css';


// document.addEventListener('DOMContentLoaded', function () {
//     LazyLoad(document.querySelectorAll(".post-entry img"));
// }, false);


document.addEventListener('DOMContentLoaded', function () {
    Prism.highlightAll();
}, false);

document.addEventListener('DOMContentLoaded', () => {
    new LazyLoad('.post-entry img');
});