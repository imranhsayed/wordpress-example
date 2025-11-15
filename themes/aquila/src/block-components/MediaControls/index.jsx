/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { MediaReplaceFlow } from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';
import { dispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

/**
 * Media controls component for handling image selection.
 *
 * @param {Object}   props               Component properties.
 * @param {number}   props.imageID       The ID of the selected image.
 * @param {string}   props.imageURL      The URL of the selected image.
 * @param {Function} props.onResetMedia  Function to reset block attributes.
 * @param {Function} props.onSelectMedia Callback function when media is selected.
 * @param {string}   props.noticeId      Unique identifier for error notices.
 * @param {string}   props.hasImageLabel Label for the image when present.
 * @param {string}   props.noImageLabel  Label for the image when not present.
 *
 * @return {Element} Element to render.
 */
export default function MediaControls({
	imageID,
	imageURL,
	hasImageLabel = __('Replace image', 'one-novanta-theme'),
	noImageLabel = __('Add image', 'one-novanta-theme'),
	onSelectMedia,
	onResetMedia,
	noticeId = 'media-upload-error',
}) {
	// Check if image is present
	const hasImage = Boolean(imageID) && imageID > 0;

	// Create media upload error notice
	const errorNotice = (message) => {
		dispatch(noticesStore).createErrorNotice(message, {
			type: 'snackbar',
			id: noticeId,
		});
	};

	return (
		<ToolbarGroup>
			<MediaReplaceFlow
				mediaId={imageID}
				mediaURL={imageURL}
				allowedTypes={['image']}
				accept="image/*"
				name={hasImage ? hasImageLabel : noImageLabel}
				onSelect={onSelectMedia}
				onError={errorNotice}
				onReset={onResetMedia}
			/>
		</ToolbarGroup>
	);
}
