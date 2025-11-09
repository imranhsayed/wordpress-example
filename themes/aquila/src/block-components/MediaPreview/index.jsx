/**
 * WordPress dependencies
 */
import { MediaPlaceholder } from '@wordpress/block-editor';
import { dispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

export default function MediaPreview( {
  url,
  placeholderTitle,
  onSelect,
  wrapperClassName,
  imgClassName,
  imgAlt,
} ) {
	const hasMedia = Boolean( url );
	
	const showErrorNotice = ( message ) => {
		dispatch( noticesStore ).createErrorNotice( message, {
			type: 'snackbar',
			id: 'media-preview-error',
		} );
	};
	
	return (
		<div className={ wrapperClassName }>
			{ hasMedia ? (
				<img
					src={ url }
					alt={ imgAlt || placeholderTitle }
					className={ imgClassName }
				/>
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
