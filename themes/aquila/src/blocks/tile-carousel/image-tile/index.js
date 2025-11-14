/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

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
import './editor.scss';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
const registeredBlock = registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save: Save,
} );

// Client-side debugging
// eslint-disable-next-line no-console
console.log('Aquila Notice Block Registration:', {
	blockName: metadata.name,
	registered: !!registeredBlock,
	metadata,
});

// Check if block is available in the editor
if (typeof wp !== 'undefined' && wp.data) {
	wp.data.subscribe(() => {
		const blockTypes = wp.data.select('core/blocks').getBlockTypes();
		const ourBlock = blockTypes.find(
			(block) => block.name === metadata.name
		);
		if (ourBlock) {
			// eslint-disable-next-line no-console
			console.log(
				'✅ Image Tile Block is available in editor:',
				ourBlock
			);
		}
	});
}
