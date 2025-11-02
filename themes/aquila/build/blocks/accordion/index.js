(function() {
'use strict';
const { registerBlockType: t } = wp.blocks;const { jsx: o, Fragment: r } = ReactJSXRuntime;const { useBlockProps: a, InnerBlocks: e } = wp.blockEditor;function c(){const n=a();return o(r,{children:o("div",{...n,children:o(e,{template:[["one-novanta/accordion-item"]],allowedBlocks:["one-novanta/accordion-item"],templateLock:!1,renderAppender:()=>o(e.ButtonBlockAppender,{})})})})}function i(){return o(e.Content,{})}const m="one-novanta/accordion",d={name:m};t(d.name,{edit:c,save:i});

})();