/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Edit Component.
 * @param {Object} props            Block Props.
 * @param {Object} props.attributes Block Attributes.
 */
export default function Edit( { attributes } ) {
	const { allowedBlocks, templateLock } = attributes;

	// Block props.
	const blockProps = useBlockProps( {
		className: classnames( 'two-columns__column' ),
	} );

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps(
		{ ...blockProps },
		{
			template: [
				[
					'core/paragraph',
					{
						placeholder: __( 'Add content here…', 'one-novanta-theme' ),
					},
				],
			],
			templateLock,
			allowedBlocks,
		},
	);

	// Return block.
	return <div { ...innerBlocksProps } />;
}
