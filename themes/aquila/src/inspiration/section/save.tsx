/**
 * WordPress dependencies.
 */
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Save component.
 */
export default function Save() {
	// Save inner content.
	return <InnerBlocks.Content />;
}
