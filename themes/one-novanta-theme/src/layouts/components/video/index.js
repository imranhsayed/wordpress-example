/**
 * Global variables.
 */
const { customElements, HTMLElement } = window;

/**
 * Video Class
 */
export default class Video extends HTMLElement {
	/**
	 * Constructor.
	 */
	constructor() {
		// Initialize parent.
		super();

		// Define properties
		this.mediaId = null;
		this.playButton = null;
		this.lightboxTrigger = null;
		this.thumbnailElements = null;
		this.staticThumbnail = false;

		// Pre-bind the event listener method to ensure 'this' context
		this.boundOpenLightbox = this.openLightbox.bind( this );
	}

	/**
	 * Lifecycle callback. Runs when the element is added to the DOM.
	 */
	connectedCallback() {
		// Elements.
		this.mediaId = this.getAttribute( 'media-id' );
		this.playButton = this.querySelector( '.novanta-video__play-button' );
		this.lightboxTrigger = Array.from( this.querySelectorAll( 'rt-lightbox-trigger' ) );
		this.thumbnailElements = this.querySelectorAll( '.novanta-video__dynamic-thumbnail' );
		this.staticThumbnail = this.getAttribute( 'thumbnail' ) === 'static';

		// Events.
		this.playButton?.addEventListener( 'click', this.boundOpenLightbox );

		// Set thumbnail.
		if ( this.mediaId && ! this.staticThumbnail ) {
			this.initWistiaThumbnail();
		}
	}

	/**
	 * Lifecycle callback. Runs when the element is removed from the DOM.
	 */
	disconnectedCallback() {
		// Clean up event listeners.
		this.playButton?.removeEventListener( 'click', this.boundOpenLightbox );
	}

	/**
	 * Open the lightbox.
	 */
	openLightbox() {
		// Check if lightboxTrigger is available.
		if ( ! this.lightboxTrigger || this.lightboxTrigger.length === 0 ) {
			return;
		}

		// Trigger the lightbox.
		this.lightboxTrigger[ 0 ].trigger();
	}

	/**
	 * Initialize Wistia thumbnail fetching.
	 */
	async initWistiaThumbnail() {
		if ( ! this.mediaId ) {
			return;
		}

		try {
			const thumbnailUrl = await this.fetchWistiaThumbnailData( this.mediaId );
			if ( thumbnailUrl ) {
				this.updateThumbnails( thumbnailUrl );
			}
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( 'Error fetching Wistia thumbnail:', error );
		}
	}

	/**
	 * Fetch Wistia thumbnail data from the API.
	 *
	 * @param {string} wistiaMedia - The Wistia media ID.
	 *
	 * @return {Promise<string|null>} A promise that resolves with the thumbnail URL or null.
	 */
	async fetchWistiaThumbnailData( wistiaMedia ) {
		const apiUrl = `https://fast.wistia.net/oembed?url=http://home.wistia.com/medias/${ wistiaMedia }?embedType=async&videoWidth=1024`;

		try {
			const response = await fetch( apiUrl );
			if ( ! response.ok ) {
				throw new Error( `Failed to fetch Wistia data: ${ response.status } ` );
			}

			// Parse the response as JSON.
			const data = await response.json();
			return data?.thumbnail_url || null;
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( 'Error fetching Wistia thumbnail:', error );
			return null;
		}
	}

	/**
	 * Update all thumbnail elements with the provided URL.
	 *
	 * @param {string} thumbnailUrl - The URL of the thumbnail image.
	 */
	updateThumbnails( thumbnailUrl ) {
		if ( ! thumbnailUrl ) {
			return;
		}

		// Update the dynamic thumbnail elements if they exist.
		this.thumbnailElements?.forEach( ( img ) => {
			img.src = thumbnailUrl;
			img.setAttribute( 'alt', 'Video thumbnail' );
		} );
	}
}

/**
 * Initialize.
 */
customElements.define( 'novanta-video', Video );
