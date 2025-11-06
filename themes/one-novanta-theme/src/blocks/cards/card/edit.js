/**
 * WordPress dependencies
 */
import { BlockControls, InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import MediaControls from '../../../js/block-components/media-controls';
import MediaPreview from '../../../js/block-components/media-preview';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.attributes    Block attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// Get all the attributes.
	const {
		imageID,
		imageURL,
		imageAlt,
		heading,
		headingTag,
		content,
	} = attributes;

	// Get the block props with custom class names.
	const blockProps = useBlockProps(
		{
			className: 'card',
		},
	);

	// Set media handler
	const onSelectMedia = ( media ) => {
		// If no media is selected, return early
		if ( ! media || ! media.id ) {
			return;
		}

		// Pick the large media URL if available, otherwise use the default URL
		const mediaURL = media.sizes?.large?.url || media.url;

		// Set imageID, imageURL, and imageAlt attributes
		setAttributes( {
			imageID: media.id,
			imageURL: mediaURL,
			imageAlt: media.alt,
		} );
	};

	const onResetMedia = () => {
		setAttributes( {
			imageID: 0,
			imageURL: '',
			imageAlt: '',
		} );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Cards Settings', 'one-novanta-theme' ) }>
					<SelectControl
						label={ __( 'Heading Tag', 'one-novanta-theme' ) }
						value={ headingTag }
						options={ [
							{ label: 'H3', value: 'h3' },
							{ label: 'H4', value: 'h4' },
						] }
						onChange={ ( updatedTag ) => setAttributes( { headingTag: updatedTag } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<BlockControls>
				<MediaControls
					imageID={ imageID }
					imageURL={ imageURL }
					onResetMedia={ onResetMedia }
					onSelectMedia={ onSelectMedia }
					noticeId="card-media-upload-error"
				/>
			</BlockControls>

			<div { ...blockProps }>
				<MediaPreview
					url={ imageURL }
					onSelect={ onSelectMedia }
					placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
					wrapperClassName="card__image"
					imgClassName="attachment-default-card size-default-card"
					imgAlt={ imageAlt || __( 'Card image', 'one-novanta-theme' ) }
				/>
				<RichText
					tagName={ headingTag }
					className="card__heading has-heading-font-family has-medium-font-size"
					value={ heading }
					onChange={ ( updatedHeading ) => setAttributes( { heading: updatedHeading } ) }
					placeholder={ __( 'Add Card Title', 'one-novanta-theme' ) }
					allowedFormats={ [] }
				/>
				<div className="card__content">
					<RichText
						tagName="p"
						value={ content }
						onChange={ ( updatedContent ) => setAttributes( { content: updatedContent } ) }
						placeholder={ __( 'Add card content', 'one-novanta-theme' ) }
						allowedFormats={ [] }
					/>
				</div>
			</div>
		</>
	);
}
