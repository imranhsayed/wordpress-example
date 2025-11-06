/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InnerBlocks,
} from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { TEMPLATE } from './constants';
import BlockControls from './block-controls';
import InspectorControls from './inspector-controls';
import { MediaPreview } from './media-preview';

export default function Edit( { attributes, setAttributes } ) {
	const { mediaType, mediaURL, mediaAlignment, videoThumbnailURL } =
		attributes;

	const blockProps = useBlockProps( {
		className: 'alignfull',
	} );

	const onSelectMedia = ( media ) => {
		setAttributes( {
			imageID: media?.id || 0,
			mediaURL: media?.url || '',
		} );
	};

	const onSelectVideoThumbnail = ( media ) => {
		setAttributes( {
			videoThumbnailID: media?.id || 0,
			videoThumbnailURL: media?.url || '',
		} );
	};

	return (
		<div { ...blockProps }>
			<BlockControls
				attributes={ attributes }
				setAttributes={ setAttributes }
				onSelectMedia={ onSelectMedia }
				onSelectVideoThumbnail={ onSelectVideoThumbnail }
			/>

			<InspectorControls
				mediaType={ mediaType }
				mediaURL={ mediaURL }
				setAttributes={ setAttributes }
			/>

			<div
				className={ `featured-content featured-content--media-align-${ mediaAlignment }` }
			>
				<div className="featured-content__media">
					{ mediaType === 'image' && (
						<MediaPreview
							type="image"
							url={ mediaURL }
							placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
							onSelect={ ( media ) =>
								setAttributes( {
									mediaURL: media.url,
									imageID: media.id,
								} )
							}
						/>
					) }

					{ mediaType === 'wistia' && (
						<MediaPreview
							type="wistia"
							url={ videoThumbnailURL }
							placeholderTitle={ __( 'Video Thumbnail', 'one-novanta-theme' ) }
							onSelect={ ( media ) =>
								setAttributes( {
									videoThumbnailURL: media.url,
									videoThumbnailID: media.id,
								} )
							}
							showPlayIcon
						/>
					) }
				</div>

				<div className="featured-content__content">
					<InnerBlocks template={ TEMPLATE } templateLock={ false } allowedBlocks={ [ 'core/paragraph', 'core/list', 'core/buttons', 'core/heading' ] } />
				</div>
			</div>
		</div>
	);
}
