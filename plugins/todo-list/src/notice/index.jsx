/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import './style.scss';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';

/**
 * Register the block.
 */
const blockSettings = {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save: Save,
};

// Register the block
const registeredBlock = registerBlockType( metadata.name, blockSettings );

// Client-side debugging
console.log('Aquila Notice Block Registration:', {
	blockName: metadata.name,
	registered: !!registeredBlock,
	metadata: metadata,
	blockSettings: blockSettings
});

// Check if block is available in the editor
if (typeof wp !== 'undefined' && wp.data) {
	wp.data.subscribe(() => {
		const blockTypes = wp.data.select('core/blocks').getBlockTypes();
		const ourBlock = blockTypes.find(block => block.name === metadata.name);
		if (ourBlock) {
			console.log('✅ Aquila Notice Block is available in editor:', ourBlock);
		}
	});
}
