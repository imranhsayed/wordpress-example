/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { MediaPlaceholder } from '@wordpress/block-editor';
import { dispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

/**
 * Internal dependencies
 */
import { ReactComponent as Play } from '../../svg/play.svg';

export function MediaPreview( {
	url,
	placeholderTitle,
	onSelect,
	showPlayIcon = false,
} ) {
	const hasMedia = Boolean( url );

	const showErrorNotice = ( message ) => {
		dispatch( noticesStore ).createErrorNotice( message, {
			type: 'snackbar',
			id: 'media-preview-error',
		} );
	};

	return (
		<div className="featured-content__media-placeholder has-background-disabled-background-color">
			{ hasMedia ? (
				<div className={ showPlayIcon ? 'novanta-video__thumbnail' : '' }>
					<img
						src={ url }
						alt={ placeholderTitle }
						className="featured-content__media-placeholder__image"
					/>
					{ showPlayIcon && (
						<button className="novanta-video__play-button" aria-label={ __( 'Video play button', 'one-novanta-theme' ) } type="button">
							<Play />
						</button>
					) }
				</div>
			) : (
				<MediaPlaceholder
					icon="format-image"
					labels={ { title: placeholderTitle } }
					onSelect={ onSelect }
					onError={ showErrorNotice }
					accept="image/*"
					allowedTypes={ [ 'image' ] }
				/>
			) }
		</div>
	);
}
