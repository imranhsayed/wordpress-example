/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { BlockControls as BaseBlockControls } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import AlignmentToolbar from '../../js/block-components/alignment-toolbar';
import MediaControls from '../../js/block-components/media-controls';

export default function BlockControls( {
	attributes,
	setAttributes,
	onSelectMedia,
	onSelectVideoThumbnail,
} ) {
	const { imageID, mediaType, mediaAlignment, mediaURL, videoThumbnailID, videoThumbnailURL } =
		attributes;

	return (
		<BaseBlockControls>
			<AlignmentToolbar
				value={ mediaAlignment }
				onChange={ ( newVal ) => setAttributes( { mediaAlignment: newVal } ) }
				labels={ {
					left: __( 'Align Media Left', 'one-novanta-theme' ),
					right: __( 'Align Media Right', 'one-novanta-theme' ),
				} }
			/>

			{ mediaType === 'image' && (
				<MediaControls
					imageID={ imageID }
					imageURL={ mediaURL }
					onSelectMedia={ onSelectMedia }
					onResetMedia={ () => onSelectMedia( undefined ) }
					noticeId="form-media-upload-error"
				/>
			) }
			{ mediaType === 'wistia' && (
				<MediaControls
					imageID={ videoThumbnailID }
					imageURL={ videoThumbnailURL }
					onSelectMedia={ onSelectVideoThumbnail }
					onResetMedia={ () => onSelectVideoThumbnail( undefined ) }
					noticeId="form-media-upload-error"
					hasImageLabel={ __(
						'Replace video thumbnail',
						'one-novanta-theme',
					) }
					noImageLabel={ __(
						'Add video thumbnail',
						'one-novanta-theme',
					) }
				/>
			) }
		</BaseBlockControls>
	);
}
