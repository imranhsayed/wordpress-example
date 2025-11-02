/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { useBlockProps, useInnerBlocksProps, RichText, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {Object}   props.attributes    Block Attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// Accordion item state.
	const [ isOpen, setIsOpen ] = useState( attributes.openByDefault );

	// Block props.
	const blockProps = useBlockProps( {
		className: classnames( 'aquila-accordion__item' ),
		...( isOpen && { open: 'yes' } ),
	} );

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps(
		{
			className: classnames( 'aquila-accordion__content', 'aquila-accordion__content-info' ),
			style: {
				display: isOpen ? 'block' : 'none',
			},
		},
		{
			template: [ [ 'core/paragraph', { placeholder: __( 'Add content…', 'aquila-theme' ) } ] ],
			renderAppender: () => <InnerBlocks.DefaultBlockAppender />,
		},
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings' ) }>
					<ToggleControl
						label={ __( 'Open by default' ) }
						help={ __( 'Open the accordion item by default.' ) }
						checked={ attributes.openByDefault }
						onChange={ ( openByDefault ) => setAttributes( { openByDefault } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="aquila-accordion__handle">
					<div
						className="aquila-accordion__handle-btn"
						onClick={ () => setIsOpen( ! isOpen ) }
						aria-hidden="true"
					>
						<RichText
							tagName="span"
							className="aquila-accordion__title"
							value={ attributes.title }
							onChange={ ( title ) => setAttributes( { title } ) }
							placeholder={ __( 'Add Accordion title…', 'aquila-theme' ) }
							allowedFormats={ [] }
						/>
					</div>
				</div>
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}
