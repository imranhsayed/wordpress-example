/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/accordion/index.js":
/*!**************************************************************************************************************************!*\
  !*** ../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/accordion/index.js ***!
  \**************************************************************************************************************************/
/***/ (function(module) {

!function(t,e){if(true)module.exports=e();else // removed by dead control flow
{ var i, s; }}("undefined"!=typeof self?self:this,(()=>(()=>{"use strict";var t={d:(e,s)=>{for(var i in s)t.o(s,i)&&!t.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:s[i]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r:t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}},e={};t.r(e),t.d(e,{default:()=>l});class s extends HTMLElement{constructor(){super()}static get observedAttributes(){return["expand-all","collapse-all"]}attributeChangedCallback(t="",e="",s=""){e!==s&&(this.update(),"yes"!==s||"collapse-all"!==t&&"expand-all"!==t||this.dispatchEvent(new CustomEvent(t,{bubbles:!0})))}update(){const t=this.querySelectorAll("rt-accordion-item");if(!t.length)return;const e="yes"===this.getAttribute("expand-all")?"expand-all":"yes"===this.getAttribute("collapse-all")?"collapse-all":"";e&&t.forEach((t=>{"expand-all"===e?t.setAttribute("expanded",""):t.removeAttribute("expanded")}))}}class i extends HTMLElement{constructor(){super(),this.setAttribute("aria-expanded","false"),"yes"===this.getAttribute("open-by-default")&&(this.setAttribute("expanded",""),this.setAttribute("aria-expanded","true"))}disconnectedCallback(){this.removeAttribute("open-by-default")}static get observedAttributes(){return["expanded"]}attributeChangedCallback(t,e,s){"expanded"===t&&(this.hasAttribute("expanded")?this.open():this.close(),this.removeAttribute("open-by-default"))}open(){const t=this.querySelector("rt-accordion-content"),e=this.querySelector("rt-accordion-handle");t&&(this.dispatchEvent(new CustomEvent("before-open",{bubbles:!0})),t.style.height=`${t.scrollHeight}px`,this.setAttribute("aria-expanded","true"),e?.setAttribute("aria-expanded","true"),t.setAttribute("aria-hidden","false"),this.hasAttribute("open-by-default")&&"no"===this.getAttribute("open-by-default")&&this.removeAttribute("open-by-default"),this.hasAttribute("expanded")||this.setAttribute("expanded",""),this.dispatchEvent(new CustomEvent("open",{bubbles:!0})))}close(){const t=this.querySelector("rt-accordion-content"),e=this.querySelector("rt-accordion-handle");t&&(this.dispatchEvent(new CustomEvent("before-close",{bubbles:!0})),t.style.height=`${t.scrollHeight}px`,t.offsetHeight,t.style.height="0px",this.setAttribute("aria-expanded","false"),e?.setAttribute("aria-expanded","false"),t.setAttribute("aria-hidden","true"),this.hasAttribute("open-by-default")&&"yes"===this.getAttribute("open-by-default")&&this.removeAttribute("open-by-default"),this.hasAttribute("expanded")&&this.removeAttribute("expanded"),this.dispatchEvent(new CustomEvent("close",{bubbles:!0})))}}class n extends HTMLElement{button=null;accordionItem=null;constructor(){super(),this.button=this.querySelector("button"),this.button?.addEventListener("click",(()=>this.toggle())),this.accordionItem=this.closest("rt-accordion-item"),this.setAttribute("role","button"),"yes"===this.accordionItem?.getAttribute("open-by-default")?(this.setAttribute("aria-expanded","true"),this.button?.setAttribute("aria-expanded","true")):(this.setAttribute("aria-expanded","false"),this.button?.setAttribute("aria-expanded","false"))}disconnectedCallback(){this.button?.removeEventListener("click",(()=>this.toggle()))}toggle(){this.accordionItem?.toggleAttribute("expanded"),this.accordionItem?.hasAttribute("expanded")?(this.button?.setAttribute("aria-expanded","true"),this.accordionItem?.setAttribute("aria-expanded","true")):(this.button?.setAttribute("aria-expanded","false"),this.accordionItem?.setAttribute("aria-expanded","false"))}}class o extends HTMLElement{constructor(){super();const t=this.closest("rt-accordion-item");t?.hasAttribute("open-by-default")?this.setAttribute("aria-hidden","false"):this.setAttribute("aria-hidden","true")}}class r extends HTMLElement{button=null;constructor(){super(),this.setAttribute("role","button"),this.button=this.querySelector("button"),this.button?.addEventListener("click",(()=>this.expandAll()))}disconnectedCallback(){this.button?.removeEventListener("click",(()=>this.expandAll()))}expandAll(){const t=this.closest("rt-accordion");t?.setAttribute("expand-all","yes"),t?.removeAttribute("collapse-all")}}class a extends HTMLElement{button=null;constructor(){super(),this.setAttribute("role","button"),this.button=this.querySelector("button"),this.button?.addEventListener("click",(()=>this.collapseAll()))}disconnectedCallback(){this.button?.removeEventListener("click",(()=>this.collapseAll()))}collapseAll(){const t=this.closest("rt-accordion");t?.removeAttribute("expand-all"),t?.setAttribute("collapse-all","yes")}}customElements.define("rt-accordion",s),customElements.define("rt-accordion-item",i),customElements.define("rt-accordion-handle",n),customElements.define("rt-accordion-content",o),customElements.define("rt-accordion-expand-all",r),customElements.define("rt-accordion-collapse-all",a);const l={accordion:s,item:i,handle:n,content:o,expandAll:r,collapseAll:a};return e})()));

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";
/*!**************************************!*\
  !*** ./src/blocks/accordion/view.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _rtcamp_web_components_build_accordion__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @rtcamp/web-components/build/accordion */ "../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/accordion/index.js");
/* harmony import */ var _rtcamp_web_components_build_accordion__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_rtcamp_web_components_build_accordion__WEBPACK_IMPORTED_MODULE_0__);
/**
 * Accordion block frontend script.
 *
 * This script ensures the accordion web component is loaded when the block is rendered.
 */

/**
 * External dependencies
 */

})();

/******/ })()
;
//# sourceMappingURL=view.js.map