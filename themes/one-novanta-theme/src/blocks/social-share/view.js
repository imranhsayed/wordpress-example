
/**
 * Copy To Clipboard components for Novanta theme.
 */

class CopyToClipboard {
	constructor() {
		this.copyButtons = document.querySelectorAll( '.novanta-social-share__link--copy' );
		this.copyButtons.forEach( ( button ) => {
			button.addEventListener(
				'click',
				this.copyToClipboard.bind( this ),
			);
		} );
	}

	copyToClipboard( event ) {
		event.preventDefault();
		const button = event.target.closest( '.novanta-social-share__link--copy' ) || event.target;
		const textToCopy = button.getAttribute( 'href' );

		if ( ! textToCopy ) {
			return;
		}

		// Try using the Clipboard API (modern approach)
		if ( navigator.clipboard && window.isSecureContext ) {
			navigator.clipboard
				.writeText( textToCopy )
				.then( () => {
					this.showFeedback( { type: 'success', target: button } );
				} )
				.catch( ( err ) => {
					// eslint-disable-next-line no-console
					console.error( 'Clipboard API failed: ', err );
					this.fallbackCopyToClipboard( textToCopy, button );
				} );
		} else {
			// Fallback for browsers without Clipboard API support or non-secure contexts
			this.fallbackCopyToClipboard( textToCopy, button );
		}
	}

	fallbackCopyToClipboard( text, button ) {
		try {
			// Create a temporary textarea element
			const textarea = document.createElement( 'textarea' );
			textarea.value = text;
			// Make it non-editable to avoid focus and ensure it's not visible
			textarea.setAttribute( 'readonly', '' );
			textarea.style.position = 'absolute';
			textarea.style.left = '-9999px';
			document.body.appendChild( textarea );

			// Select the text and copy
			textarea.select();
			const successful = document.execCommand( 'copy' );
			document.body.removeChild( textarea );

			if ( successful ) {
				this.showFeedback( { type: 'success', target: button } );
				this.updateButtonState( button, 'success' );
			} else {
				this.showFeedback( { type: 'error', target: button } );
				this.updateButtonState( button, 'error' );
			}
		} catch ( err ) {
			// eslint-disable-next-line no-console
			console.error( 'Fallback copy method failed: ', err );
			this.showFeedback( { type: 'error', target: button } );
		}
	}

	showFeedback( { type = 'success', target = null } ) {
		clearTimeout( this.feedbackTimeout );

		if ( ! target ) {
			return;
		}

		if ( type === 'success' ) {
			target.classList.add( 'copied' );

			// Hide after 2 seconds
			this.feedbackTimeout = setTimeout( () => {
				target.classList.remove( 'copied' );
			}, 2000 );
		} else if ( type === 'error' ) {
			target.classList.add( 'error' );

			// Hide after 2 seconds
			this.feedbackTimeout = setTimeout( () => {
				target.classList.remove( 'error' );
			}, 2000 );
		}
	}
}

/**
 * Social Share component class.
 */
class OneNovantaSocialShare {
	/**
	 * Constructor.
	 *
	 * @return {void}
	 */
	constructor() {
		this.socialShare = document.querySelector( '#one-novanta-blog-social-share' );
		this.setSocialShareHeight();
	}

	/**
	 * Set social share height.
	 *
	 * @return {void}
	 */
	setSocialShareHeight() {
		if ( ! this.socialShare ) {
			return;
		}

		const root = document.documentElement;
		const socialShareHeight = this.socialShare.offsetHeight;
		root?.style?.setProperty( '--one-novanta-social-share-height', `${ socialShareHeight }px` );
	}
}

document.addEventListener( 'DOMContentLoaded', () => {
	// Initialize components
	new CopyToClipboard();
	new OneNovantaSocialShare();
} );
