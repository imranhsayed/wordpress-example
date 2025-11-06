document.addEventListener( 'DOMContentLoaded', function() {
	document.querySelectorAll( '.featured-media-placeholder' ).forEach( ( wrapper ) => {
		const thumbnail = wrapper.querySelector( '.video-thumbnail' );
		const video = wrapper.querySelector( '.wistia-video' );

		if ( thumbnail && video ) {
			thumbnail.addEventListener( 'click', function() {
				thumbnail.remove();
				video.style.display = 'block';
			} );
		}
	} );
} );
