/**
 * WordPress dependencies
 */
import { RichText, useBlockProps } from '@wordpress/block-editor';

import { __ } from '@wordpress/i18n';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// Get all the attributes.
	const {
		content,
	} = attributes;

	// Get the block props with custom class names.
	const blockProps = useBlockProps(
		{
			className: 'novanta-notice',
		},
	);

	return (
		<>
			<div { ...blockProps } >
				<RichText
					tagName="p"
					placeholder={ __( 'Add your content here', 'one-novanta-theme' ) }
					value={ content }
					onChange={ ( value ) => setAttributes( { content: value } ) }
					keepPlaceholderOnFocus
					className="novanta-notice__content"
					allowedFormats={ [ 'core/bold', 'core/link' ] }
				/>
			</div>
		</>
	);
}
