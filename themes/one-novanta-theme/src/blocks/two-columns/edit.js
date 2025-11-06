/**
 * WordPress dependencies
 */
import {
	useBlockProps,
	BlockControls,
	InspectorControls,
	useInnerBlocksProps,
	BlockVerticalAlignmentToolbar,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, ToggleControl } from '@wordpress/components';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
// import { Section } from '../../js/block-components/section';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// Block props.
	const blockProps = useBlockProps( {
		className: classnames(
			'two-columns',
			`two-columns--vertical-align-${ attributes.verticalAlign }`,
			{
				'two-columns--reverse-order': attributes.reverseMobileOrder,
			},
		),
	} );

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps(
		{ ...blockProps },
		{
			template: [
				[ 'one-novanta/two-columns-column', { templateLock: false } ],
				[ 'one-novanta/two-columns-column', { templateLock: false } ],
			],
			templateLock: 'insert',
			orientation: 'horizontal',
		},
	);

	return (
		<>
			<BlockControls>
				<BlockVerticalAlignmentToolbar
					value={ attributes.verticalAlign }
					onChange={ ( value ) => setAttributes( { verticalAlign: value } ) }
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Two Columns Option', 'one-novanta-theme' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Reverse column order on mobile', 'one-novanta-theme' ) }
						help={
							attributes.reverseMobileOrder
								? __( 'Second column will appear first on mobile.', 'one-novanta-theme' )
								: __( 'Default column order will be preserved.', 'one-novanta-theme' )
						}
						checked={ attributes.reverseMobileOrder }
						onChange={ ( value ) =>
							setAttributes( { reverseMobileOrder: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}
