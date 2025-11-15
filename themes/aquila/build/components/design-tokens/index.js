/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/design-tokens/index.scss":
/*!*************************************************!*\
  !*** ./src/components/design-tokens/index.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
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
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!***********************************************!*\
  !*** ./src/components/design-tokens/index.js ***!
  \***********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.scss */ "./src/components/design-tokens/index.scss");
/**
 * Design Tokens Component
 *
 * This component displays all design system tokens
 */



// Copy to clipboard functionality
document.addEventListener('DOMContentLoaded', function () {
  const copyButtons = document.querySelectorAll('.design-tokens__copy-btn');
  copyButtons.forEach(button => {
    // Add copy message element dynamically if it doesn't exist
    let messageElement = button.nextElementSibling;
    if (!messageElement || !messageElement.classList.contains('design-tokens__copy-message')) {
      messageElement = document.createElement('span');
      messageElement.className = 'design-tokens__copy-message';
      messageElement.textContent = 'Copied to clipboard';
      button.parentNode.appendChild(messageElement);
    }
    button.addEventListener('click', function () {
      const textToCopy = this.getAttribute('data-copy');

      // Use the Clipboard API
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(textToCopy).then(() => {
          showCopiedState(this, messageElement);
        }).catch(err => {
          console.error('Failed to copy:', err);
          fallbackCopy(textToCopy, this, messageElement);
        });
      } else {
        // Fallback for older browsers
        fallbackCopy(textToCopy, this, messageElement);
      }
    });
  });
  function showCopiedState(button, messageElement) {
    // Add copied class for visual feedback
    button.classList.add('copied');

    // Show the message
    messageElement.classList.add('show');

    // Remove the message after 300ms and button state after 2 seconds
    setTimeout(() => {
      messageElement.classList.remove('show');
    }, 300);
    setTimeout(() => {
      button.classList.remove('copied');
    }, 2000);
  }
  function fallbackCopy(text, button, messageElement) {
    // Create a temporary textarea
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
      document.execCommand('copy');
      showCopiedState(button, messageElement);
    } catch (err) {
      console.error('Fallback copy failed:', err);
    }
    document.body.removeChild(textarea);
  }
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map