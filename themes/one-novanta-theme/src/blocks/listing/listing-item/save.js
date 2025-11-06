/**
 * WordPress dependencies
 */
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Save component.
 *
 * @return {string} Markup for display or distribution.
 */
export default function save() {
	return (
		<InnerBlocks.Content />
	);
}
