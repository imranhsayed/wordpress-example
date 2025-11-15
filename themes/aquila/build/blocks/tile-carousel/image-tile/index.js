/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../../node_modules/.pnpm/@wordpress+icons@10.32.0_react@18.3.1/node_modules/@wordpress/icons/build-module/library/link.js":
/*!*********************************************************************************************************************************!*\
  !*** ../../node_modules/.pnpm/@wordpress+icons@10.32.0_react@18.3.1/node_modules/@wordpress/icons/build-module/library/link.js ***!
  \*********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);
/**
 * WordPress dependencies
 */


const link = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.Path, {
    d: "M10 17.389H8.444A5.194 5.194 0 1 1 8.444 7H10v1.5H8.444a3.694 3.694 0 0 0 0 7.389H10v1.5ZM14 7h1.556a5.194 5.194 0 0 1 0 10.39H14v-1.5h1.556a3.694 3.694 0 0 0 0-7.39H14V7Zm-4.5 6h5v-1.5h-5V13Z"
  })
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (link);
//# sourceMappingURL=link.js.map

/***/ }),

/***/ "../../node_modules/.pnpm/classnames@2.5.1/node_modules/classnames/index.js":
/*!**********************************************************************************!*\
  !*** ../../node_modules/.pnpm/classnames@2.5.1/node_modules/classnames/index.js ***!
  \**********************************************************************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = '';

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (arg) {
				classes = appendClass(classes, parseValue(arg));
			}
		}

		return classes;
	}

	function parseValue (arg) {
		if (typeof arg === 'string' || typeof arg === 'number') {
			return arg;
		}

		if (typeof arg !== 'object') {
			return '';
		}

		if (Array.isArray(arg)) {
			return classNames.apply(null, arg);
		}

		if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
			return arg.toString();
		}

		var classes = '';

		for (var key in arg) {
			if (hasOwn.call(arg, key) && arg[key]) {
				classes = appendClass(classes, key);
			}
		}

		return classes;
	}

	function appendClass (value, newClass) {
		if (!newClass) {
			return value;
		}
	
		if (value) {
			return value + ' ' + newClass;
		}
	
		return value + newClass;
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else // removed by dead control flow
{}
}());


/***/ }),

/***/ "./src/block-components/MediaControls/index.jsx":
/*!******************************************************!*\
  !*** ./src/block-components/MediaControls/index.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ MediaControls)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__);
/**
 * WordPress dependencies
 */






/**
 * Media controls component for handling image selection.
 *
 * @param {Object}   props               Component properties.
 * @param {number}   props.imageID       The ID of the selected image.
 * @param {string}   props.imageURL      The URL of the selected image.
 * @param {Function} props.onResetMedia  Function to reset block attributes.
 * @param {Function} props.onSelectMedia Callback function when media is selected.
 * @param {string}   props.noticeId      Unique identifier for error notices.
 * @param {string}   props.hasImageLabel Label for the image when present.
 * @param {string}   props.noImageLabel  Label for the image when not present.
 *
 * @return {Element} Element to render.
 */

function MediaControls({
  imageID,
  imageURL,
  hasImageLabel = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Replace image', 'one-novanta-theme'),
  noImageLabel = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Add image', 'one-novanta-theme'),
  onSelectMedia,
  onResetMedia,
  noticeId = 'media-upload-error'
}) {
  // Check if image is present
  const hasImage = Boolean(imageID) && imageID > 0;

  // Create media upload error notice
  const errorNotice = message => {
    (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.dispatch)(_wordpress_notices__WEBPACK_IMPORTED_MODULE_4__.store).createErrorNotice(message, {
      type: 'snackbar',
      id: noticeId
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToolbarGroup, {
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.MediaReplaceFlow, {
      mediaId: imageID,
      mediaURL: imageURL,
      allowedTypes: ['image'],
      accept: "image/*",
      name: hasImage ? hasImageLabel : noImageLabel,
      onSelect: onSelectMedia,
      onError: errorNotice,
      onReset: onResetMedia
    })
  });
}

/***/ }),

/***/ "./src/block-components/MediaPreview/index.jsx":
/*!*****************************************************!*\
  !*** ./src/block-components/MediaPreview/index.jsx ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ MediaPreview)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);
/**
 * WordPress dependencies
 */




function MediaPreview({
  url,
  placeholderTitle,
  onSelect,
  wrapperClassName,
  imgClassName,
  imgAlt
}) {
  const hasMedia = Boolean(url);
  const showErrorNotice = message => {
    (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.dispatch)(_wordpress_notices__WEBPACK_IMPORTED_MODULE_2__.store).createErrorNotice(message, {
      type: 'snackbar',
      id: 'media-preview-error'
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
    className: wrapperClassName,
    children: hasMedia ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("img", {
      src: url,
      alt: imgAlt || placeholderTitle,
      className: imgClassName
    }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.MediaPlaceholder, {
      icon: "format-image",
      labels: {
        title: placeholderTitle
      },
      onSelect: onSelect,
      onError: showErrorNotice,
      accept: "image/*",
      allowedTypes: ['image']
    })
  });
}

/***/ }),

/***/ "./src/blocks/tile-carousel/image-tile/block.json":
/*!********************************************************!*\
  !*** ./src/blocks/tile-carousel/image-tile/block.json ***!
  \********************************************************/
/***/ ((module) => {

"use strict";
module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"aquila/image-tile","version":"0.1.0","title":"Image Tile","category":"aquila","icon":"image-flip-horizontal","description":"A custom Image Tile Block for Aquila theme.","example":{"attributes":{"heading":"Sample Heading","imageSize":"large","imageRatio":"16:9","preHeading":"Sample Pre-Heading","showURLInput":true}},"parent":["aquila/tile-carousel"],"supports":{"inserter":false},"attributes":{"link":{"type":"string","default":""},"heading":{"type":"string","default":""},"imageID":{"type":"number","default":0},"imageURL":{"type":"string","default":""},"linkMeta":{"type":"object","default":{}},"imageAlt":{"type":"string","default":""},"preHeading":{"type":"string","default":""},"showURLInput":{"type":"boolean","default":false},"imageRatio":{"type":"string","default":""},"imageSize":{"type":"string","default":""}},"usesContext":["aquila/editMode","aquila/imageRatio","aquila/imageSize"],"textdomain":"aquila-theme","editorScript":"file:./index.js","style":"file:./style.css","render":"file:./render.php"}');

/***/ }),

/***/ "./src/blocks/tile-carousel/image-tile/edit.jsx":
/*!******************************************************!*\
  !*** ./src/blocks/tile-carousel/image-tile/edit.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! classnames */ "../../node_modules/.pnpm/classnames@2.5.1/node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/icons */ "../../node_modules/.pnpm/@wordpress+icons@10.32.0_react@18.3.1/node_modules/@wordpress/icons/build-module/library/link.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _block_components_MediaControls__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/block-components/MediaControls */ "./src/block-components/MediaControls/index.jsx");
/* harmony import */ var _block_components_MediaPreview__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @/block-components/MediaPreview */ "./src/block-components/MediaPreview/index.jsx");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__);
/**
 * External dependencies
 */


/**
 * WordPress dependencies
 */







/**
 * Internal dependencies
 */



/**
 * ArrowRightSVG JSX Component.
 */

const ArrowRightSVG = () => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)("svg", {
  width: "8",
  height: "12",
  fill: "currentColor",
  xmlns: "http://www.w3.org/2000/svg",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)("path", {
    d: "M0 10.59 4.58 6 0 1.41 1.41 0l6 6-6 6L0 10.59z",
    fill: "currentColor"
  })
});

/**
 * Editor side of the block.
 *
 * @param {Object}  props               Block Props.
 * @param {Object}  props.context       Block context.
 * @param {Object}  props.attributes    Block Attributes.
 * @param {Object}  props.setAttributes Block Attributes setter method.
 * @param {Object}  props.clientId      A unique identifier assigned to each block instance.
 *
 * @param {boolean} props.isSelected
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
function Edit({
  attributes,
  setAttributes,
  context,
  clientId,
  isSelected
}) {
  var _context$aquilaEditM, _context$aquilaImage, _context$aquilaImage2;
  // Show LinkControl near card.
  const cardRef = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useRef)();
  const {
    imageID,
    imageURL,
    imageAlt,
    link: cardLink,
    linkMeta
  } = attributes;
  const editMode = (_context$aquilaEditM = context['aquila/editMode']) !== null && _context$aquilaEditM !== void 0 ? _context$aquilaEditM : true;
  const imageRatio = (_context$aquilaImage = context['aquila/imageRatio']) !== null && _context$aquilaImage !== void 0 ? _context$aquilaImage : '';
  const imageSize = (_context$aquilaImage2 = context['aquila/imageSize']) !== null && _context$aquilaImage2 !== void 0 ? _context$aquilaImage2 : '';

  // Set image ratio and size as attributes, to be used in render.php.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useEffect)(() => {
    setAttributes({
      imageSize,
      imageRatio
    });
  }, [imageSize, imageRatio, setAttributes]);

  // Get select/dispatch functions for block operations
  const {
    getBlockParents,
    getBlockName
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useSelect)(select => ({
    getBlockParents: select(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.store).getBlockParents,
    getBlockName: select(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.store).getBlockName
  }), []);
  const {
    selectBlock
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useDispatch)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.store);

  // Move focus to parent carousel block when edit mode is disabled
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useEffect)(() => {
    if (!editMode && isSelected) {
      // Get parent block ID (should be the tile-carousel)
      const parentBlockIds = getBlockParents(clientId);
      if (parentBlockIds.length > 0) {
        const immediateParentId = parentBlockIds[parentBlockIds.length - 1];
        const parentBlockName = getBlockName(immediateParentId);

        // Only redirect if parent is the carousel block
        if (parentBlockName === 'aquila/tile-carousel') {
          // We use requestAnimationFrame to ensure this happens after the selection
          requestAnimationFrame(() => {
            selectBlock(immediateParentId);
          });
        }
      }
    }
  }, [clientId, editMode, getBlockParents, getBlockName, selectBlock, isSelected]);
  const extraClasses = [];

  // Set the image ratio classes based on the imageRatio attribute.
  switch (imageRatio) {
    case '2:1':
      extraClasses.push('image-tile--two-one');
      break;
    case '3:2':
      extraClasses.push('image-tile--three-two');
      break;
    case '16:9':
      extraClasses.push('image-tile--sixteen-nine');
      break;
    default:
      extraClasses.push('image-tile--one-one');
      break;
  }

  // Set the image size classes based on the imageSize attribute, in the blockProps itself.
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.useBlockProps)({
    className: classnames__WEBPACK_IMPORTED_MODULE_0___default()('image-tile', extraClasses)
  });
  const setMediaHandler = media => {
    var _media$id, _media$alt_text;
    // If no media is selected, return early.
    if (!media) {
      return;
    }

    /**
     * Prepare media url.
     * Note: This Media parameter only have default image sizes.
     * Custom image size are not present, therefore we are using large.
     */
    const mediaUrl = media?.sizes?.large?.url || media?.url || null;
    setAttributes({
      imageURL: mediaUrl,
      imageID: (_media$id = media?.id) !== null && _media$id !== void 0 ? _media$id : 0,
      imageAlt: (_media$alt_text = media?.alt_text) !== null && _media$alt_text !== void 0 ? _media$alt_text : ''
    });
  };
  const resetMediaHandler = () => {
    setAttributes({
      imageURL: '',
      imageID: 0,
      imageAlt: ''
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.BlockControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToolbarGroup, {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToolbarButton, {
          icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_2__["default"],
          onClick: () => setAttributes({
            showURLInput: !attributes.showURLInput
          }),
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Link for the Tile', 'aquila-theme')
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_block_components_MediaControls__WEBPACK_IMPORTED_MODULE_7__["default"], {
        imageID: imageID,
        imageURL: imageURL,
        onSelectMedia: setMediaHandler,
        onResetMedia: resetMediaHandler
      })]
    }), attributes.showURLInput && editMode && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Popover, {
      position: "bottom center",
      onClose: () => setAttributes({
        showURLInput: false
      }),
      anchor: cardRef.current,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.__experimentalLinkControl, {
        settings: [],
        value: linkMeta,
        onRemove: () => setAttributes({
          linkMeta: {},
          link: ''
        }),
        onChange: newLinkMeta => {
          var _newLinkMeta$url;
          return setAttributes({
            linkMeta: newLinkMeta,
            link: (_newLinkMeta$url = newLinkMeta?.url) !== null && _newLinkMeta$url !== void 0 ? _newLinkMeta$url : ''
          });
        }
      }, `image-tile-link-${clientId}`)
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)("div", {
      ...blockProps,
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_block_components_MediaPreview__WEBPACK_IMPORTED_MODULE_8__["default"], {
        url: imageURL,
        placeholderTitle: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Image', 'aquila-theme'),
        onSelect: setMediaHandler,
        wrapperClassName: "image-tile__image-wrap",
        imgAlt: imageAlt || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Image tile image', 'aquila-theme')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)("div", {
        className: "image-tile__content",
        ref: cardRef,
        children: imageURL && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.Fragment, {
          children: [editMode ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.RichText, {
            tagName: "p",
            value: attributes.preHeading,
            onChange: preHeading => setAttributes({
              preHeading
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pre Heading', 'aquila-theme'),
            className: "image-tile__pre_heading has-tiny-font-size",
            allowedFormats: []
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)("p", {
            className: "image-tile__pre_heading has-tiny-font-size",
            children: attributes.preHeading
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsxs)("h3", {
            className: "image-tile__heading has-large-font-size",
            children: [editMode ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.RichText, {
              tagName: "span",
              value: attributes.heading,
              onChange: heading => setAttributes({
                heading
              }),
              placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading', 'aquila-theme'),
              className: "image-tile__heading-text",
              allowedFormats: []
            }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)("span", {
              className: "image-tile__heading-text",
              children: attributes.heading
            }), cardLink && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_9__.jsx)(ArrowRightSVG, {})]
          })]
        })
      })]
    })]
  });
}

/***/ }),

/***/ "./src/blocks/tile-carousel/image-tile/editor.scss":
/*!*********************************************************!*\
  !*** ./src/blocks/tile-carousel/image-tile/editor.scss ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/blocks/tile-carousel/image-tile/save.jsx":
/*!******************************************************!*\
  !*** ./src/blocks/tile-carousel/image-tile/save.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Save)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);
/**
 * WordPress dependencies
 */


/**
 * Save component.
 */

function Save() {
  // Save inner content.
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InnerBlocks.Content, {});
}

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/notices":
/*!*********************************!*\
  !*** external ["wp","notices"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["notices"];

/***/ }),

/***/ "@wordpress/primitives":
/*!************************************!*\
  !*** external ["wp","primitives"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["primitives"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

"use strict";
module.exports = window["ReactJSXRuntime"];

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
/*!******************************************************!*\
  !*** ./src/blocks/tile-carousel/image-tile/index.js ***!
  \******************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/blocks/tile-carousel/image-tile/editor.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/blocks/tile-carousel/image-tile/edit.jsx");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/blocks/tile-carousel/image-tile/save.jsx");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ "./src/blocks/tile-carousel/image-tile/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
/**
 * WordPress dependencies
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor. All other files
 * get applied to the editor only.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
/**
 * Internal dependencies
 */





/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
const registeredBlock = (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

// Client-side debugging
// eslint-disable-next-line no-console
console.log('Aquila Notice Block Registration:', {
  blockName: _block_json__WEBPACK_IMPORTED_MODULE_4__.name,
  registered: !!registeredBlock,
  metadata: _block_json__WEBPACK_IMPORTED_MODULE_4__
});

// Check if block is available in the editor
if (typeof wp !== 'undefined' && wp.data) {
  wp.data.subscribe(() => {
    const blockTypes = wp.data.select('core/blocks').getBlockTypes();
    const ourBlock = blockTypes.find(block => block.name === _block_json__WEBPACK_IMPORTED_MODULE_4__.name);
    if (ourBlock) {
      // eslint-disable-next-line no-console
      console.log('✅ Image Tile Block is available in editor:', ourBlock);
    }
  });
}
})();

/******/ })()
;
//# sourceMappingURL=index.js.map