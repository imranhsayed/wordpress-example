/**
 * WordPress dependencies
 */
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

/**
 * Save component.
 */
export default function Save() {
	// Block props.
	const blockProps = useBlockProps.save();

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps.save( blockProps );

	// Save inner content.
	return (
		<div { ...innerBlocksProps } />
	);
}
