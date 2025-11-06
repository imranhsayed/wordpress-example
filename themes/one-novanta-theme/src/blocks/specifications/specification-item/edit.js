/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const baseClass = 'wp-one-novanta-table';

	// Get the block props with custom class names.
	const blockProps = useBlockProps( {
		className: baseClass + '__body-row',
	} );

	return (
		<tr { ...blockProps } >
			<RichText
				tagName="td"
				value={ attributes.label }
				onChange={ ( label ) =>
					setAttributes( { label } )
				}
				placeholder={ __( 'Set Label', 'one-novanta-theme' ) }
				className={ `${ baseClass }__body-cell` }
				allowedFormats={ [] }
			/>
			<RichText
				tagName="td"
				value={ attributes.valueMetric }
				onChange={ ( valueMetric ) =>
					setAttributes( { valueMetric } )
				}
				placeholder={ __( 'Set Value', 'one-novanta-theme' ) }
				className={ `${ baseClass }__body-cell` }
				allowedFormats={ [] }
			/>
		</tr>
	);
}
