/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/slider/index.js":
/*!***********************************************************************************************************************!*\
  !*** ../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/slider/index.js ***!
  \***********************************************************************************************************************/
/***/ (function(module) {

!function(t,e){if(true)module.exports=e();else // removed by dead control flow
{ var i, s; }}("undefined"!=typeof self?self:this,(()=>(()=>{"use strict";var t={d:(e,s)=>{for(var i in s)t.o(s,i)&&!t.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:s[i]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r:t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}},e={};t.r(e),t.d(e,{default:()=>h});class s{allowedResponsiveKeys=["flexible-height","infinite","swipe","behavior","auto-slide-interval","pause-on-hover","slides-to-show"];settings;responsiveSettings=[];element;originalAttributes=new Map;constructor(t){this.element=t,this.settings={infinite:!1,swipe:!1,behavior:"fade",autoSlideInterval:0,flexibleHeight:!1,pauseOnHover:!1,slidesToShow:1,responsiveSettings:[]},this.storeOriginalAttributes(),this.initializeResponsiveSettings(),this.parseAttributes()}storeOriginalAttributes(){this.allowedResponsiveKeys.forEach((t=>{this.originalAttributes.set(t,this.element.getAttribute(t))}))}getSettings(){return{...this.settings}}initializeResponsiveSettings(){const t=this.element.getAttribute("responsive");if(t)try{this.responsiveSettings=JSON.parse(t)}catch(t){console.error("Invalid responsive settings JSON",t),this.responsiveSettings=[]}}parseAttributes(){const t=t=>"yes"===this.element.getAttribute(t);this.settings.infinite=t("infinite"),this.settings.swipe=t("swipe"),this.settings.flexibleHeight=t("flexible-height");const e=this.element.getAttribute("behavior");this.settings.behavior="slide"===e?"slide":"fade";const s=this.element.getAttribute("auto-slide-interval");if(s){const t=parseInt(s);t>0&&(this.settings.autoSlideInterval=t)}const i=this.element.getAttribute("slides-to-show");if(i){const t=parseInt(i);this.settings.slidesToShow=t>0?t:1}this.settings.pauseOnHover=t("pause-on-hover"),this.settings.responsiveSettings=[...this.responsiveSettings]}applyResponsiveSettings(){if(!this.responsiveSettings.length)return;const t=this.responsiveSettings.find((t=>window.matchMedia(t.media).matches));if(t)this.allowedResponsiveKeys.forEach((e=>{const s=t[e];void 0!==s&&this.element.setAttribute(e,s)}));else for(const[t,e]of this.originalAttributes.entries())null!=e?this.element.setAttribute(t,e):this.element.removeAttribute(t);this.parseAttributes()}}class i extends HTMLElement{slides=[];currentSlideIndex=0;touchStartX=0;touchEndX=0;touchListenersActive=!1;autoSlideTimeoutId=null;touchStartHandler=()=>{};touchEndHandler=()=>{};settingsManager;constructor(){super(),this.settingsManager=new s(this)}static get observedAttributes(){return["infinite","swipe","behavior","auto-slide-interval","responsive","flexible-height","pause-on-hover","slides-to-show"]}connectedCallback(){this.settingsManager.initializeResponsiveSettings(),this.settingsManager.parseAttributes(),this.setupSlides(),this.setupNavigation(),this.setupSwipe(),this.setupAutoSlide(),this.setupHoverPause(),this.settingsManager.applyResponsiveSettings(),this.updateHeight(),this.setCurrentSlide(0),this.updateArrows(),this.updateCount(),window.addEventListener("resize",this.handleResize.bind(this))}disconnectedCallback(){this.clearAutoSlideTimeout()}attributeChangedCallback(t,e,s){if(e!==s){if("responsive"===t)return this.settingsManager.initializeResponsiveSettings(),this.settingsManager.applyResponsiveSettings(),this.setupSwipe(),this.setupAutoSlide(),void this.setupHoverPause();this.settingsManager.parseAttributes(),"infinite"===t&&this.updateArrows(),"auto-slide-interval"===t&&this.setupAutoSlide()}}setupSlides(){const t=this.querySelector("rt-slider-slides");t&&(this.slides=Array.from(t.querySelectorAll("rt-slider-slide")),this.slides.forEach(((t,e)=>{if(t.setAttribute("aria-hidden",0!==e?"true":"false"),t.setAttribute("role","group"),t.setAttribute("aria-roledescription","slide"),!t.hasAttribute("aria-label")){const s=e+1,i=this.slides.length;t.setAttribute("aria-label",`${s} / ${i}`)}0===e?t.classList.add("active"):t.classList.remove("active")})),this.updateArrows())}getSlideElements(){const t=this.querySelector("rt-slider-slides"),e=t?.querySelectorAll(":scope > rt-slider-slide");return e}setupNavigation(){const t=this.querySelector("rt-slider-nav"),e=this.querySelectorAll("rt-slider-nav-item");t?.setAttribute("role","tablist"),t?.setAttribute("aria-label","Slide navigation"),e?.forEach(((t,e)=>{t.hasAttribute("index")||t.setAttribute("index",e.toString()),0===e?t.classList.add("active"):t.classList.remove("active"),t.hasAttribute("role")||t.setAttribute("role","tab");const s=t.querySelector("button");if(s){const t=e+1;s.hasAttribute("aria-label")||s.setAttribute("aria-label",`Go to slide ${t}`)}})),this.addEventListener("slide-set",(t=>{const s=t.detail.currentSlide;e?.forEach(((t,e)=>{t.classList.toggle("active",e===s)}))}))}setupSwipe(){const t=this.querySelector("rt-slider-track");if(!t)return;this.touchListenersActive&&(t.removeEventListener("touchstart",this.touchStartHandler),t.removeEventListener("touchend",this.touchEndHandler),this.touchListenersActive=!1);this.settingsManager.getSettings().swipe&&(this.touchStartHandler=t=>{const e=t;this.touchStartX=e.changedTouches[0].screenX},this.touchEndHandler=t=>{const e=t;this.touchEndX=e.changedTouches[0].screenX,this.handleSwipe()},t.addEventListener("touchstart",this.touchStartHandler,{passive:!0}),t.addEventListener("touchend",this.touchEndHandler,{passive:!0}),this.touchListenersActive=!0)}handleSwipe(){const t=this.touchEndX-this.touchStartX;Math.abs(t)<50||(t>0?this.previous():this.next())}setupAutoSlide(){this.clearAutoSlideTimeout();this.settingsManager.getSettings().autoSlideInterval<=0?this.setAttribute("aria-live","polite"):(this.setAttribute("aria-live","off"),this.setAttribute("aria-atomic","false"),this.scheduleNextSlide())}setupHoverPause(){const t=this.settingsManager.getSettings();t.autoSlideInterval<=0||t.pauseOnHover&&(this.addEventListener("mouseenter",(()=>{this.pauseAutoSlide()})),this.addEventListener("mouseleave",(()=>{this.resumeAutoSlide()})))}pauseAutoSlide(){this.settingsManager.getSettings().autoSlideInterval>0&&this.clearAutoSlideTimeout()}resumeAutoSlide(){this.settingsManager.getSettings().autoSlideInterval>0&&(this.clearAutoSlideTimeout(),this.scheduleNextSlide())}scheduleNextSlide(){const t=this.settingsManager.getSettings();this.autoSlideTimeoutId=window.setTimeout((()=>{this.next(),this.dispatchEvent(new CustomEvent("auto-slide-complete",{bubbles:!0,detail:{currentSlide:this.currentSlideIndex}})),this.scheduleNextSlide()}),t.autoSlideInterval)}clearAutoSlideTimeout(){null!==this.autoSlideTimeoutId&&(window.clearTimeout(this.autoSlideTimeoutId),this.autoSlideTimeoutId=null)}handleResize(){this.setAttribute("resizing","yes");this.settingsManager.getSettings().responsiveSettings.length>0&&(this.settingsManager.applyResponsiveSettings(),this.setupSwipe(),this.setupAutoSlide(),this.setupHoverPause(),this.updateArrows()),this.updateHeight(),this.updateSlideVisibility(!1),this.removeAttribute("resizing")}updateHeight(){const t=this.getSlideElements();if(!t||0===t.length)return;const e=this.querySelector("rt-slider-slides");if(!e)return;const s=this.settingsManager.getSettings();if(s.flexibleHeight){const s=t[this.currentSlideIndex];if(!s)return;return void(e.style.height=`${s.scrollHeight}px`)}let i=0;Array.from(t).forEach((t=>{if("fade"===s.behavior){const e=t.style.visibility;t.style.visibility="visible";const s=t.scrollHeight;i=Math.max(i,s),t.style.visibility=e}else{const e=t.scrollHeight;i=Math.max(i,e)}})),i>0&&(e.style.height=`${i}px`)}next(){if(this.slides.length<=1)return;const t=this.settingsManager.getSettings();let e=this.currentSlideIndex+1;if(e>this.slides.length-t.slidesToShow){if(!t.infinite)return;e=0}this.setCurrentSlide(e)}previous(){if(this.slides.length<=1)return;const t=this.settingsManager.getSettings();let e=this.currentSlideIndex-1;if(e<0){if(!t.infinite)return;e=this.slides.length-t.slidesToShow}this.setCurrentSlide(e)}getCurrentSlide(){return this.currentSlideIndex}getTotalSlides(){return this.slides.length}setCurrentSlide(t){if(t<0||t>=this.getTotalSlides())return;const e=this.currentSlideIndex;this.dispatchEvent(new CustomEvent("slide-set",{bubbles:!0,detail:{currentSlide:t,previousSlide:e}})),this.currentSlideIndex=t,this.updateSlideVisibility(),this.updateCount(),this.updateArrows(),this.updateHeight(),this.dispatchEvent(new CustomEvent("slide-complete",{bubbles:!0,detail:{currentSlide:this.currentSlideIndex}})),this.updateArrows(),this.updateCount()}updateSlideVisibility(t=!0){const e=this.settingsManager.getSettings();this.slides.forEach(((t,e)=>{const s=e===this.currentSlideIndex;t.classList.toggle("active",s),t.setAttribute("aria-hidden",s?"false":"true")}));const s=this.querySelector("rt-slider-slides");if(s&&"slide"===e.behavior&&this.slides[this.currentSlideIndex]){e.slidesToShow>1?this.slides.forEach((t=>{const s=100/e.slidesToShow;t.style.flex=`0 0 ${s}%`,t.style.maxWidth=`${s}%`})):this.slides.forEach((t=>{t.style.flex="0 0 100%",t.style.maxWidth="100%"}));const i=this.slides[this.currentSlideIndex].offsetLeft;if(t)s.style.left=`-${i}px`;else{const t=s.style.transition;s.style.transition="none",s.style.left=`-${i}px`,s.offsetWidth,s.style.transition=t}}}updateArrows(){const t=this.settingsManager.getSettings(),e=this.querySelector('rt-slider-arrow[direction="previous"]'),s=this.querySelector('rt-slider-arrow[direction="next"]'),i=e?.querySelector("button"),r=s?.querySelector("button");if(i?.setAttribute("aria-label","Previous slide"),r?.setAttribute("aria-label","Next slide"),this.slides.length<=1)return e?.setAttribute("disabled","yes"),void s?.setAttribute("disabled","yes");if(t.infinite)return e?.removeAttribute("disabled"),void s?.removeAttribute("disabled");if(e&&(0===this.currentSlideIndex?e.setAttribute("disabled","yes"):e.removeAttribute("disabled")),s){const e=this.slides.length-t.slidesToShow;this.currentSlideIndex>=e?s.setAttribute("disabled","yes"):s.removeAttribute("disabled")}}updateCount(){const t=this.querySelector("rt-slider-count");if(!t)return;const e=t.getAttribute("format")||"$current / $total",s=this.getCurrentSlide()+1,i=this.getTotalSlides(),r=e.replace("$current",s.toString()).replace("$total",i.toString());t.textContent=r,t.setAttribute("current",s.toString()),t.setAttribute("total",i.toString())}}class r extends HTMLElement{constructor(){super()}}class n extends HTMLElement{constructor(){super()}}class l extends HTMLElement{constructor(){super(),"ResizeObserver"in window&&new ResizeObserver(this.handleHeightChange.bind(this)).observe(this)}handleHeightChange(){const t=this.closest("rt-slider");t&&setTimeout((()=>{t.handleResize()}),0)}}class o extends HTMLElement{constructor(){super()}connectedCallback(){const t=this.querySelector("button");this.updateButtonState(t),t?.addEventListener("click",(()=>this.handleClick()));new MutationObserver((e=>{e.forEach((e=>{"disabled"===e.attributeName&&this.updateButtonState(t)}))})).observe(this,{attributes:!0,attributeFilter:["disabled"]})}updateButtonState(t){if(!t)return;const e="yes"===this.getAttribute("disabled");t.disabled=e,t.setAttribute("aria-disabled",e?"true":"false")}handleClick(){if("yes"===this.getAttribute("disabled"))return;const t=this.closest("rt-slider");if(!t)return;const e=this.getAttribute("direction");"previous"===e?t.previous():"next"===e&&t.next()}}class a extends HTMLElement{constructor(){super()}}class d extends HTMLElement{constructor(){super()}connectedCallback(){const t=this.querySelector("button");t?.addEventListener("click",(()=>this.handleClick())),this.updateActiveState()}updateActiveState(){const t=this.closest("rt-slider");if(t){const e=t.getCurrentSlide(),s=this.getIndex();this.classList.toggle("active",e===s)}}handleClick(){const t=this.closest("rt-slider");t&&t.setCurrentSlide(this.getIndex())}getIndex(){const t=this.getAttribute("index");if(t)return parseInt(t,10);const e=this.closest("rt-slider-nav");return e?Array.from(e.children).indexOf(this):0}}class u extends HTMLElement{static get observedAttributes(){return["format"]}get format(){return this.getAttribute("format")??"$current / $total"}set format(t){this.setAttribute("format",t)}attributeChangedCallback(){const t=this.closest("rt-slider");t?.updateCount()}}customElements.define("rt-slider",i),customElements.define("rt-slider-track",r),customElements.define("rt-slider-slides",n),customElements.define("rt-slider-slide",l),customElements.define("rt-slider-arrow",o),customElements.define("rt-slider-nav",a),customElements.define("rt-slider-nav-item",d),customElements.define("rt-slider-count",u);const h={slider:i,track:r,slides:n,slide:l,arrow:o,nav:a,navItem:d,count:u};return e})()));

/***/ }),

/***/ "./src/components/tile-carousel/index.scss":
/*!*************************************************!*\
  !*** ./src/components/tile-carousel/index.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/*!***********************************************!*\
  !*** ./src/components/tile-carousel/index.js ***!
  \***********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.scss */ "./src/components/tile-carousel/index.scss");
/* harmony import */ var _rtcamp_web_components_build_slider__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @rtcamp/web-components/build/slider */ "../../node_modules/.pnpm/@rtcamp+web-components@1.1.6/node_modules/@rtcamp/web-components/build/slider/index.js");
/* harmony import */ var _rtcamp_web_components_build_slider__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_rtcamp_web_components_build_slider__WEBPACK_IMPORTED_MODULE_1__);
/**
 * Tile carousel entry
 *
 * Imports SCSS for compilation and web components
 */


})();

/******/ })()
;
//# sourceMappingURL=index.js.map