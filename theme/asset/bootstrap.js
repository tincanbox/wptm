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
/******/ 	__webpack_require__.p = ".";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./asset/bootstrap.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./asset/bootstrap.js":
/*!****************************!*\
  !*** ./asset/bootstrap.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_base_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style/base.scss */ "./asset/style/base.scss");
/* harmony import */ var _style_base_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_style_base_scss__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_theme_default_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style/theme/default.scss */ "./asset/style/theme/default.scss");
/* harmony import */ var _style_theme_default_scss__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_style_theme_default_scss__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _script_main_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./script/main.js */ "./asset/script/main.js");
//$ = global.$ = require('jquery');




jquery__WEBPACK_IMPORTED_MODULE_0___default()(function () {
  _script_main_js__WEBPACK_IMPORTED_MODULE_3__["default"].init(jquery__WEBPACK_IMPORTED_MODULE_0___default.a);
  console.log("bootstrap");
});

/***/ }),

/***/ "./asset/script/main.js":
/*!******************************!*\
  !*** ./asset/script/main.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  init: function init($) {
    var HUMBLE_HEIGHT = screen.height / 3;
    $("body").on("click", ".gototop", function () {
      $("html,body").animate({
        scrollTop: 0
      });
    });
    setTimeout(function () {
      $(".invisible-onload").addClass("loaded");
    }, 1400);
    window.onbeforeunload = null;
    $(window).on("beforeunload", function (event) {
      event.preventDefault();
      $(".invisible-onload").removeClass("loaded");
    });

    function init_header() {
      var scroll_top = $(window).scrollTop();
      var target = $('.wait-humble');

      if (scroll_top > HUMBLE_HEIGHT) {
        target.addClass('humble');

        if (scroll_top > HUMBLE_HEIGHT * 3 * 1.2) {
          target.filter('.more-humble').addClass('d-none');
        } else {
          target.filter('.more-humble').removeClass('d-none');
        }
      } else {
        $('.wait-humble').removeClass('humble');
      }
    }

    $(window).on("scroll", function () {
      init_header();
    });
    init_header();
    return this;
  }
});

/***/ }),

/***/ "./asset/style/base.scss":
/*!*******************************!*\
  !*** ./asset/style/base.scss ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./asset/style/theme/default.scss":
/*!****************************************!*\
  !*** ./asset/style/theme/default.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ })

/******/ });
//# sourceMappingURL=bootstrap.js.map