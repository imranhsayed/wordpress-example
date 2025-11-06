/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { MediaPlaceholder } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { ALLOWED_IMAGE_TYPE } from './constants';

/**
 * Media Section component
 *
 * @param {Object}   props               - Component props
 * @param {boolean}  props.hasImage      - Flag indicating if an image is present
 * @param {string}   props.imageURL      - URL of the image
 * @param {string}   props.imageAlt      - Alt text for the image
 * @param {Function} props.onSelectMedia - Function to handle media selection
 * @param {Object}   props.notices       - Notices object
 * @param {Function} props.handleError   - Function to handle errors
 *
 * @return {JSX.Element} MediaSection component
 */
const MediaSection = ( { hasImage, imageURL, imageAlt, onSelectMedia, notices, handleError } ) => {
	return (
		<div className="media-text-narrow__media">
			{ hasImage ? (
				<img
					src={ imageURL }
					alt={ imageAlt }
					className="media-text-narrow__media-image"
				/>
			) : (
				<MediaPlaceholder
					icon="format-image"
					className="media-text-narrow__media-placeholder"
					onSelect={ onSelectMedia }
					labels={ {
						title: __( 'Media Text Narrow', 'one-novanta-theme' ),
						instructions: __( 'Upload an image or select one from your library.', 'one-novanta-theme' ),
					} }
					accept="image/*"
					allowedTypes={ ALLOWED_IMAGE_TYPE }
					multiple={ false }
					notices={ notices }
					onError={ handleError }
				/>
			) }
		</div>
	);
};

export default MediaSection;
