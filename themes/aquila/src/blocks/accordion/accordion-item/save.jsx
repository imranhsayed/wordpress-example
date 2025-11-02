/**
 * WordPress dependencies
 */
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Save component.
 *
 * For dynamic blocks (server-side rendered), we still need to save
 * inner blocks content so it's available in render.php via $content variable.
 * The block wrapper itself is rendered server-side via render.php.
 */
export default function Save() {
	// Save inner blocks content (paragraphs, headings, etc.)
	// This content will be available in render.php via the $content variable
	return <InnerBlocks.Content />;
}
