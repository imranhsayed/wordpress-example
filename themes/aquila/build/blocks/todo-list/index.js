(function() {
'use strict';
const { registerBlockType: e } = wp.blocks;const { jsx: o } = ReactJSXRuntime;const { __: r } = wp.i18n;const { useBlockProps: t } = wp.blockEditor;function i(){return o("p",{...t(),children:r("Todo List – hello from the editor!","todo-list")})}function n(){return o("p",{...t.save(),children:"Todo List – hello from the saved content!"})}const m="create-block/todo-list",s={name:m};e(s.name,{edit:i,save:n});

})();