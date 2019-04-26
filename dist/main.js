/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/scripts/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/scripts/index.js":
/*!*********************************!*\
  !*** ./assets/scripts/index.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _lazy_load_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lazy-load.js */ \"./assets/scripts/lazy-load.js\");\n/* harmony import */ var _lazy_load_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_lazy_load_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../scss/main.scss */ \"./assets/scss/main.scss\");\n/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_scss_main_scss__WEBPACK_IMPORTED_MODULE_1__);\n\n\n\n//# sourceURL=webpack:///./assets/scripts/index.js?");

/***/ }),

/***/ "./assets/scripts/lazy-load.js":
/*!*************************************!*\
  !*** ./assets/scripts/lazy-load.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("class LazyLoad {\n    constructor(selector) {\n        this.observe = null;\n        this.targetElements = null;\n\n        if (IntersectionObserver in window) {\n            this.observe = new IntersectionObserver((entries) => {\n                Array.prototype.forEach.call(entries, (entry) => {\n                    const src = entry.dataSet[src];\n                });\n            });\n            intersectionObserver.observe(this.targetElements);\n        } else {\n            window.addEventListener('scroll', () => {\n                Array.prototype.forEach.call(this.targetElements, () => {\n                });\n            });\n        }\n    };\n\n    isInSight(el, scrollTop) {\n        const rect = el.getBoundingClientRect();\n        return (rect.left + ect.width / 2)  - (0 + window.innerWidth / 2) <= window.innerWidth / 2 - rect.width / 2 || \n        (window.innerHeight - rect.height) / 2;\n    }\n}\n\n//# sourceURL=webpack:///./assets/scripts/lazy-load.js?");

/***/ }),

/***/ "./assets/scss/main.scss":
/*!*******************************!*\
  !*** ./assets/scss/main.scss ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\\nModuleBuildError: Module build failed (from ./node_modules/postcss-loader/src/index.js):\\n/Applications/MAMP/htdocs/wp-content/themes/pure/assets/scss/main.scss:1\\n(function (exports, require, module, __filename, __dirname) { @charset \\\"UTF-8\\\";\\n                                                              ^\\n\\nSyntaxError: Invalid or unexpected token\\n    at new Script (vm.js:85:7)\\n    at NativeCompileCache._moduleCompile (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/v8-compile-cache/v8-compile-cache.js:226:18)\\n    at Module._compile (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/v8-compile-cache/v8-compile-cache.js:172:36)\\n    at Object.exec (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/webpack/lib/NormalModule.js:181:12)\\n    at Promise.resolve.then.then (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/postcss-loader/src/index.js:129:18)\\n    at runLoaders (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/webpack/lib/NormalModule.js:301:20)\\n    at /Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/loader-runner/lib/LoaderRunner.js:367:11\\n    at /Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/loader-runner/lib/LoaderRunner.js:233:18\\n    at context.callback (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\\n    at Promise.resolve.then.then.catch (/Applications/MAMP/htdocs/wp-content/themes/pure/node_modules/postcss-loader/src/index.js:208:9)\");\n\n//# sourceURL=webpack:///./assets/scss/main.scss?");

/***/ })

/******/ });