/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/block-components/PostRelationShipControl/index.jsx":
/*!****************************************************************!*\
  !*** ./src/block-components/PostRelationShipControl/index.jsx ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ PostRelationShipControl)
/* harmony export */ });
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _Relationship__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Relationship */ "./src/block-components/Relationship/index.jsx");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__);
/**
 * WordPress dependencies
 */





/**
 * Internal dependencies
 */


/**
 * PostRelationShipControl Component
 *
 * A component that allows users to search and select multiple posts via a modal
 *
 * @param {Object}   props               - Component props
 * @param {Array}    props.selectedPosts - Array of selected post IDs
 * @param {Function} props.onChange      - Callback when selection changes
 * @param {string}   props.postType      - Post type to search (default: 'post')
 * @param {number}   props.maxPosts      - Maximum number of posts that can be selected
 * @param {string}   props.label         - Label for the control
 * @param {string}   props.buttonLabel   - Label for the select button
 * @param {string}   props.modalTitle    - Title for the modal
 * @return {JSX.Element} The component
 */

function PostRelationShipControl({
  selectedPosts = [],
  onChange,
  postType = 'post',
  maxPosts = 20,
  label = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Posts', 'aquila-theme'),
  buttonLabel = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Select Posts', 'aquila-theme'),
  modalTitle = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Select Posts', 'aquila-theme')
}) {
  // Get the selected posts details
  const initialItems = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_0__.useSelect)(select => {
    if (!selectedPosts || selectedPosts.length === 0) {
      return [];
    }
    return selectedPosts.map(postId => {
      const post = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).getEntityRecord('postType', postType, postId);
      if (!post) {
        return null;
      }
      return {
        id: post.id,
        value: post.id,
        label: post.title.rendered || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('(no title)', 'aquila-theme')
      };
    }).filter(Boolean);
  }, [selectedPosts, postType]);

  // Search query function for posts
  const searchQuery = (query = '') => {
    return new Promise(resolve => {
      // WordPress REST API uses plural form for post types
      const restBase = postType === 'post' ? 'posts' : postType + 's';
      const searchParam = query ? `&search=${encodeURIComponent(query)}` : '';
      _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default()({
        path: `/wp/v2/${restBase}?per_page=20&_fields=id,title${searchParam}`
      }).then(posts => {
        const results = posts.map(post => ({
          id: post.id,
          value: post.id,
          label: post.title.rendered || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('(no title)', 'aquila-theme')
        }));
        resolve(results);
      }).catch(() => {
        resolve([]);
      });
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_Relationship__WEBPACK_IMPORTED_MODULE_4__["default"], {
    initialItems: initialItems,
    label: label,
    searchQuery: searchQuery,
    buttonLabel: buttonLabel,
    modalTitle: modalTitle,
    max: maxPosts,
    onSelect: onChange
  });
}

/***/ }),

/***/ "./src/block-components/Relationship/SearchItems.jsx":
/*!***********************************************************!*\
  !*** ./src/block-components/Relationship/SearchItems.jsx ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SearchItems)
/* harmony export */ });
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);
/**
 * WordPress dependencies
 */



/**
 * SearchItems Component
 *
 * Displays search results that can be added to selection
 *
 * @param {Object}   props            - Component props
 * @param {boolean}  props.disabled   - Whether adding items is disabled
 * @param {Array}    props.items      - Search result items
 * @param {boolean}  props.loading    - Whether search is in progress
 * @param {Array}    props.selected   - Currently selected items
 * @param {Function} props.onSelected - Callback when an item is selected
 * @return {JSX.Element} The component
 */

function SearchItems({
  disabled,
  items,
  loading,
  selected,
  onSelected
}) {
  const ulClasses = ['aquila-relationship__items', 'aquila-relationship__items--search', loading ? 'aquila-relationship__items--loading' : '', disabled ? 'aquila-relationship__items--disabled' : ''].filter(Boolean).join(' ');
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("ul", {
    className: ulClasses,
    children: [loading && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Spinner, {}), items.map(item => {
      const itemSelected = selected.find(sel => sel.id === item.id);
      const liClasses = ['aquila-relationship__item', itemSelected ? 'aquila-relationship__item--selected' : ''].filter(Boolean).join(' ');
      const handleSelect = () => {
        if (!itemSelected) {
          onSelected(item);
        }
      };
      return (
        /*#__PURE__*/
        // eslint-disable-next-line jsx-a11y/no-noninteractive-element-interactions, jsx-a11y/click-events-have-key-events
        (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("li", {
          className: liClasses,
          tabIndex: 0,
          onClick: handleSelect,
          onKeyPress: e => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              handleSelect();
            }
          },
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
            className: "aquila-relationship__item-label",
            children: item.label !== '' ? item.label : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('(no title)', 'aquila-theme')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
            className: "aquila-relationship__item-action",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Icon, {
              icon: "arrow-right-alt2"
            })
          })]
        }, item.id)
      );
    })]
  });
}

/***/ }),

/***/ "./src/block-components/Relationship/SelectedItems.jsx":
/*!*************************************************************!*\
  !*** ./src/block-components/Relationship/SelectedItems.jsx ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SelectedItems)
/* harmony export */ });
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);
/**
 * WordPress dependencies
 */



/**
 * SelectedItems Component
 *
 * Displays selected items that can be removed
 *
 * @param {Object}   props              - Component props
 * @param {Array}    props.items        - Selected items
 * @param {Function} props.onUnselected - Callback when an item is removed
 * @return {JSX.Element} The component
 */

function SelectedItems({
  items,
  onUnselected
}) {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("ul", {
    className: "aquila-relationship__items",
    children: items.map((item, index) => {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("li", {
        className: "aquila-relationship__item",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "aquila-relationship__item-label",
          children: item.label !== '' ? item.label : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('(no title)', 'aquila-theme')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "aquila-relationship__item-action",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Tooltip, {
            text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Remove', 'aquila-theme'),
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Button, {
              onClick: () => onUnselected(item),
              icon: "dismiss"
            })
          })
        })]
      }, item.id || index);
    })
  });
}

/***/ }),

/***/ "./src/block-components/Relationship/Selector.jsx":
/*!********************************************************!*\
  !*** ./src/block-components/Relationship/Selector.jsx ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Selector)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _SearchItems__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SearchItems */ "./src/block-components/Relationship/SearchItems.jsx");
/* harmony import */ var _SelectedItems__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./SelectedItems */ "./src/block-components/Relationship/SelectedItems.jsx");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);
/**
 * WordPress dependencies
 */



/**
 * Internal dependencies
 */



const typingDelay = 300;
let typingDelayTimeout = null;

/**
 * Selector Component
 *
 * Displays search interface and selected items in a two-panel layout
 *
 * @param {Object}   props             - Component props
 * @param {number}   props.maxItems    - Maximum number of items that can be selected
 * @param {Function} props.onSelect    - Callback when selection changes
 * @param {Array}    props.items       - Currently selected items
 * @param {Function} props.searchQuery - Function to search for items
 * @return {JSX.Element} The component
 */
function Selector({
  maxItems,
  onSelect,
  items,
  searchQuery
}) {
  const [results, setResults] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [searching, setSearching] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    triggerSearch();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);
  const triggerTyping = e => {
    clearTimeout(typingDelayTimeout);
    typingDelayTimeout = setTimeout(triggerSearch, typingDelay, e.target.value);
  };
  const triggerSearch = (query = '') => {
    setSearching(true);
    searchQuery(query).then(newResults => {
      setSearching(false);
      setResults(newResults);
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
    className: "aquila-relationship",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
      className: "aquila-relationship__search-container",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("input", {
        type: "text",
        className: "aquila-relationship__search",
        placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search', 'aquila-theme'),
        onChange: triggerTyping
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: "aquila-relationship__panel",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
        className: "aquila-relationship__panel__search-items",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_SearchItems__WEBPACK_IMPORTED_MODULE_2__["default"], {
          disabled: maxItems > 0 && items.length >= maxItems,
          items: results,
          loading: searching,
          selected: items,
          onSelected: item => onSelect([...items, item])
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
        className: "aquila-relationship__panel__selected-items",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_SelectedItems__WEBPACK_IMPORTED_MODULE_3__["default"], {
          items: items,
          onUpdated: newItems => onSelect(newItems),
          onUnselected: item => onSelect(items.filter(thing => thing.value !== item.value))
        })
      })]
    })]
  });
}

/***/ }),

/***/ "./src/block-components/Relationship/index.jsx":
/*!*****************************************************!*\
  !*** ./src/block-components/Relationship/index.jsx ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Relationship)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Selector__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Selector */ "./src/block-components/Relationship/Selector.jsx");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/block-components/Relationship/style.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__);
/**
 * WordPress dependencies
 */




/**
 * Internal dependencies
 */



/**
 * Relationship Component
 *
 * A reusable component that displays a button to open a modal for selecting items
 *
 * @param {Object}   props              - Component props
 * @param {Array}    props.initialItems - Initial selected items
 * @param {string}   props.label        - Label for the control
 * @param {Function} props.searchQuery  - Function to search for items
 * @param {string}   props.help         - Help text
 * @param {string}   props.buttonLabel  - Label for the button
 * @param {string}   props.modalTitle   - Title for the modal
 * @param {boolean}  props.minimal      - Whether to show selected items or not
 * @param {number}   props.max          - Maximum number of items that can be selected
 * @param {Function} props.onSelect     - Callback when items are selected
 * @return {JSX.Element} The component
 */

function Relationship({
  initialItems = [],
  label,
  searchQuery,
  help,
  buttonLabel = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Posts', 'aquila-theme'),
  modalTitle = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Posts', 'aquila-theme'),
  minimal = false,
  max = -1,
  onSelect
}) {
  const [items, setItems] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [userSelection, setUserSelection] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [loading, setLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(true);
  const [modalOpen, setModalOpen] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    setItems(initialItems);
    setLoading(false);
  }, [initialItems]);
  const selectItems = () => {
    setItems(userSelection);
    setModalOpen(false);
    if (onSelect) {
      onSelect(userSelection.map(item => item.value));
    }
  };
  const openModal = () => {
    setUserSelection(items);
    setModalOpen(true);
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.BaseControl, {
    id: "aquila-relationship-control",
    label: label,
    help: help,
    className: "aquila-relationship",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
      variant: "secondary",
      isBusy: minimal && loading,
      onClick: openModal,
      children: buttonLabel
    }), !minimal && items.length > 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("ul", {
      className: `aquila-relationship__selected-items${loading ? ' aquila-relationship__selected-items--loading' : ''}`,
      children: [loading && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("li", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, {})
      }), !loading && items.length > 0 && items.map((item, index) => {
        if (index === 3) {
          return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("li", {
            children: ["... ", items.length - 3, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('more', 'aquila-theme')]
          }, 4);
        } else if (index > 3) {
          return null;
        }
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("li", {
          children: ["\u2713 ", item.label]
        }, index);
      })]
    }), modalOpen && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Modal, {
      title: modalTitle,
      className: "aquila-relationship__modal",
      onRequestClose: () => setModalOpen(false),
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_Selector__WEBPACK_IMPORTED_MODULE_3__["default"], {
        maxItems: max,
        onSelect: newItems => setUserSelection(newItems),
        items: userSelection,
        searchQuery: searchQuery
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("div", {
        className: "aquila-relationship__modal__actions",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
          variant: "primary",
          onClick: selectItems,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select', 'aquila-theme')
        })
      })]
    })]
  });
}

/***/ }),

/***/ "./src/block-components/Relationship/style.scss":
/*!******************************************************!*\
  !*** ./src/block-components/Relationship/style.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/blocks/related-articles/block.json":
/*!************************************************!*\
  !*** ./src/blocks/related-articles/block.json ***!
  \************************************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"aquila/related-articles","version":"0.1.0","title":"Related Articles","category":"aquila","icon":"grid-view","description":"Displays 4 latest posts from a selected category.","textdomain":"aquila-theme","editorScript":"file:./index.js","style":"file:./style.css","render":"file:./render.php","supports":{"html":false,"inserter":true},"attributes":{"mode":{"type":"string","default":"automatic"},"selectedPosts":{"type":"array","default":[]},"categoryId":{"type":"number","default":0},"order":{"type":"string","default":"asc"},"orderBy":{"type":"string","default":"title"},"numberOfItems":{"type":"number","default":4}}}');

/***/ }),

/***/ "./src/blocks/related-articles/edit.jsx":
/*!**********************************************!*\
  !*** ./src/blocks/related-articles/edit.jsx ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _inspector_controls__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./inspector-controls */ "./src/blocks/related-articles/inspector-controls.jsx");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__);
/**
 * WordPress dependencies
 */





/**
 * Internal dependencies
 */


function Edit({
  attributes,
  setAttributes
}) {
  const baseClassName = 'related-articles-block';
  const {
    mode = 'automatic',
    selectedPosts = []
  } = attributes;
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps)({
    className: `${baseClassName} alignfull`
  });

  // Show placeholder if manual mode is selected but no posts are selected
  const showPlaceholder = mode === 'manual' && selectedPosts.length === 0;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
    ...blockProps,
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_inspector_controls__WEBPACK_IMPORTED_MODULE_4__["default"], {
      attributes: attributes,
      setAttributes: setAttributes
    }), showPlaceholder ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Placeholder, {
      icon: "grid-view",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Related Articles', 'aquila-theme'),
      instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select posts from the block settings to display them here.', 'aquila-theme')
    }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)((_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default()), {
      block: "aquila/related-articles",
      attributes: attributes
    })]
  });
}

/***/ }),

/***/ "./src/blocks/related-articles/editor.scss":
/*!*************************************************!*\
  !*** ./src/blocks/related-articles/editor.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/blocks/related-articles/inspector-controls.jsx":
/*!************************************************************!*\
  !*** ./src/blocks/related-articles/inspector-controls.jsx ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InspectorControls)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _block_components_PostRelationShipControl__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../block-components/PostRelationShipControl */ "./src/block-components/PostRelationShipControl/index.jsx");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__);
/**
 * WordPress dependencies
 */






/**
 * Internal dependencies
 */


function InspectorControls({
  attributes,
  setAttributes
}) {
  const {
    mode = 'automatic',
    selectedPosts = [],
    categoryId,
    order = 'asc',
    orderBy = 'title',
    numberOfItems = 4
  } = attributes;
  const categories = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const query = {
      per_page: -1,
      hide_empty: false
    };
    return select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_4__.store).getEntityRecords('taxonomy', 'category', query);
  }, []);
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InspectorControls, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Settings', 'aquila-theme'),
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Mode', 'aquila-theme'),
        value: mode,
        options: [{
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Automatic', 'aquila-theme'),
          value: 'automatic'
        }, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Manual', 'aquila-theme'),
          value: 'manual'
        }],
        onChange: newMode => {
          setAttributes({
            mode: newMode
          });
        },
        help: mode === 'automatic' ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Automatically fetch latest posts based on criteria below', 'aquila-theme') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Manually select posts to display', 'aquila-theme')
      })
    }), mode === 'automatic' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Query Settings', 'aquila-theme'),
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.QueryControls, {
        categoriesList: categories,
        selectedCategoryId: categoryId,
        onCategoryChange: id => {
          if (!id) {
            setAttributes({
              categoryId: 0
            });
            return;
          }
          setAttributes({
            categoryId: parseInt(id, 10)
          });
        },
        order: order,
        orderBy: orderBy,
        onOrderChange: newOrder => setAttributes({
          order: newOrder
        }),
        onOrderByChange: newOrderBy => setAttributes({
          orderBy: newOrderBy
        }),
        numberOfItems: numberOfItems,
        onNumberOfItemsChange: newCount => setAttributes({
          numberOfItems: newCount
        })
      })
    }), mode === 'manual' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Manual Selection', 'aquila-theme'),
      initialOpen: true,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_block_components_PostRelationShipControl__WEBPACK_IMPORTED_MODULE_5__["default"], {
        selectedPosts: selectedPosts,
        onChange: newSelectedPosts => {
          setAttributes({
            selectedPosts: newSelectedPosts
          });
        },
        postType: "post",
        maxPosts: 20,
        label: "",
        buttonLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Posts', 'aquila-theme'),
        modalTitle: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Posts', 'aquila-theme')
      })
    })]
  });
}

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/server-side-render":
/*!******************************************!*\
  !*** external ["wp","serverSideRender"] ***!
  \******************************************/
/***/ ((module) => {

module.exports = window["wp"]["serverSideRender"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

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
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************************************!*\
  !*** ./src/blocks/related-articles/index.js ***!
  \**********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/blocks/related-articles/editor.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/blocks/related-articles/edit.jsx");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./src/blocks/related-articles/block.json");
/**
 * WordPress dependencies
 */


/**
 * Internal dependencies
 */



(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"]
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map