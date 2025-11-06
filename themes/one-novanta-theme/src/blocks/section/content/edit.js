/**
 * WordPress dependencies
 */
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props            Block properties.
 * @param {string} props.className  Block class name.
 * @param {Object} props.attributes Block attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { attributes, className } ) {
	// Destructure attributes.
	const { templateLock } = attributes;

	// Block props.
	const blockProps = useBlockProps(
		{
			className: classnames(
				'one-novanta-section__content alignwide',
				className,
			),
		},
	);
	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			templateLock,
			renderAppender: () => <InnerBlocks.ButtonBlockAppender />,
		},
	);

	return (
		<div { ...innerBlocksProps } />
	);
}
