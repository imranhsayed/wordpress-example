/**
 * Global variables.
 */
const { customElements, HTMLElement } = window;

// Create a global flag to track if we've imported the lightbox.
window.OneNovanta = window.OneNovanta || {};
window.OneNovanta.lightboxImported = window.OneNovanta.lightboxImported || false;
window.OneNovanta.lightboxStylesLoaded = window.OneNovanta.lightboxStylesLoaded || false;

/**
 * External dependencies - only import once
 */
if ( ! window.OneNovanta.lightboxImported && ! customElements.get( 'rt-lightbox' ) ) {
	window.OneNovanta.lightboxImported = true;
	require( '@rtcamp/web-components/build/lightbox' );
}

/**
 * Load the media lightbox stylesheet if not already loaded.
 */
function loadLightboxStyles() {
	if ( window.OneNovanta.lightboxStylesLoaded ) {
		return;
	}

	// Check if the stylesheet is already loaded.
	const existingStylesheet = document.querySelector( 'link[href*="media-lightbox/index.css"]' );
	if ( existingStylesheet ) {
		window.OneNovanta.lightboxStylesLoaded = true;
		return;
	}

	// Create a link element for the stylesheet.
	const stylesheet = document.createElement( 'link' );
	stylesheet.rel = 'stylesheet';
	stylesheet.type = 'text/css';

	// Get site URL (works in WordPress environment).
	const siteUrl = window.location.origin || '';

	// Set the CSS path based on the confirmed structure.
	stylesheet.href = `${ siteUrl }/wp-content/themes/one-novanta-theme/build/css/components/media-lightbox/index.css`;
	document.head.appendChild( stylesheet );
	window.OneNovanta.lightboxStylesLoaded = true;
}

/**
 * MediaLightBox Class.
 */
export default class MediaLightBox extends HTMLElement {
	/**
	 * Connected Callback.
	 */
	connectedCallback() {
		// Elements.
		this.lightbox = this.querySelector( 'rt-lightbox' );
		this.navElement = this.querySelector( '.media-lightbox__nav' );
		this.nextButtonElement = this.querySelector( 'rt-lightbox-next' );
		this.prevButtonElement = this.querySelector( 'rt-lightbox-previous' );

		// Events.
		this.lightbox?.addEventListener( 'template-set', this.addBulletsToLightbox.bind( this ) );
	}

	/**
	 * Adds dots navigation to the lightbox.
	 */
	addBulletsToLightbox() {
		// Check if lightbox is available.
		if ( ! this.lightbox ) {
			// If lightbox does not exist, bail out.
			return;
		}

		// Get total slide number.
		const total = parseInt( this.lightbox?.getAttribute( 'total' ) || '0', 10 );

		// Check if the total number of slides is less than or equal to 1.
		if ( 1 >= total ) {
			// Set the attribute hidden to next and previous buttons.
			this.nextButtonElement?.setAttribute( 'hidden', 'true' );
			this.prevButtonElement?.setAttribute( 'hidden', 'true' );

			// If the total number of slides is less than or equal to 1, bail out.
			return;
		}

		// Check if the bullet container exists.
		if ( ! this.navElement ) {
			// If bullet container does not exist, bail out.
			return;
		}

		// Get the current slide index.
		const current = parseInt( this.lightbox?.currentIndex?.toString() || '0', 10 );

		// Clear the bullet container.
		this.navElement.textContent = '';

		// Loop to create the specified number of bullets.
		for ( let i = 0; i < total; i++ ) {
			// Create a new button element for each bullet.
			const singleBullet = document.createElement( 'button' );

			// Set the button type to button.
			singleBullet.setAttribute( 'type', 'button' );

			// Set the button aria-label to indicate the slide number.
			singleBullet.setAttribute( 'aria-label', `Go to slide ${ i + 1 }` );

			// Add the appropriate class to the bullet.
			singleBullet.classList.add( 'media-lightbox__bullet' );

			// Add an event listener to the bullet.
			singleBullet.addEventListener( 'click', () => {
				// Set the current slide to the bullet index.
				if ( this.lightbox ) {
					this.lightbox.currentIndex = i + 1;
				}
			} );

			// If this bullet is the current one, mark it accordingly.
			if ( i + 1 === current ) {
				singleBullet.setAttribute( 'current', 'yes' );
			}

			// Append the bullet to the container.
			this.navElement.appendChild( singleBullet );
		}
	}
}

/**
 * Only define the custom element if it hasn't been defined already.
 */
if ( ! customElements.get( 'ati-media-lightbox' ) ) {
	customElements.define( 'ati-media-lightbox', MediaLightBox );
}

// Load the styles.
loadLightboxStyles();

/**
 * This function ensures the media-lightbox script is loaded and the custom element is registered.
 * It should be called from other components that dynamically add 'ati-media-lightbox' elements.
 *
 * Usage:
 * 1. Import this in your component file:
 * import { ensureMediaLightboxLoaded } from '../media-lightbox';
 *
 * 2. Call it before adding lightboxes to the DOM:
 * ensureMediaLightboxLoaded();
 *
 * @return {boolean} True once lightbox and it styles are loaded.
 */
export function ensureMediaLightboxLoaded() {
	// Check if the element is already defined.
	if ( ! customElements.get( 'ati-media-lightbox' ) ) {
		// If not defined, define it.
		customElements.define( 'ati-media-lightbox', MediaLightBox );
	}

	// Make sure styles are loaded too.
	loadLightboxStyles();

	return true;
}
