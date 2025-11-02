(function() {
'use strict';
const { registerBlockType: n } = wp.blocks;const { jsx: e, Fragment: r } = ReactJSXRuntime;const { useBlockProps: a, InnerBlocks: o } = wp.blockEditor;function c(){const t=a();return e(r,{children:e("div",{...t,children:e(o,{template:[["aquila/accordion-item"]],allowedBlocks:["aquila/accordion-item"],templateLock:!1,renderAppender:()=>e(o.ButtonBlockAppender,{})})})})}function i(){return e(o.Content,{})}const l="aquila/accordion",m={name:l};n(m.name,{edit:c,save:i});

})();