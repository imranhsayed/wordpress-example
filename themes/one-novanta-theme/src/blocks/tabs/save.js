/**
 * WordPress dependencies
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

/**
 * Save component.
 */
export default function save() {
	// We are using PHP rendering, so save only needs to output the InnerBlocks content.
	// The PHP render callback will reconstruct the full rt-tabs structure.
	const blockProps = useBlockProps.save();

	return (
		<div { ...blockProps }>
			<InnerBlocks.Content />
		</div>
	);
}
