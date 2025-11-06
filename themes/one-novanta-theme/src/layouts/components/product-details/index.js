/**
 * Internal dependencies
 */
import { ProductDetails } from './product-details';
import './js/tooltip';

/**
 * Import media lightbox component to ensure it's loaded.
 */
import { ensureMediaLightboxLoaded } from '../media-lightbox';

/**
 * Global variables.
 */
const { customElements, HTMLElement } = window;

/**
 * ProductGallery Class.
 */
export default class ProductGallery extends HTMLElement {
	/**
	 * Connected Callback.
	 */
	connectedCallback() {
		// Ensure media lightbox is loaded.
		ensureMediaLightboxLoaded();

		// Elements.
		this.slider = this.querySelector( '.product-details__gallery-slider' );
		this.slides = this.querySelectorAll( '.product-details__gallery-slide' );
		this.thumbnails = this.querySelector( '.product-details__gallery-thumbnails' );
		this.thumbnailItems = this.querySelectorAll( '.product-details__gallery-thumbnail' );
		this.lightboxTrigger = Array.from( this.querySelectorAll( 'rt-lightbox-trigger' ) );
		this.viewAllButton = this.querySelector( '.product-details__gallery-thumbnail-overlay' );
		this.VIEW_ALL_INDEX = 3;

		// Find the active slide index (default to 0)
		this.currentIndex = 0;
		this.slides.forEach( ( slide, index ) => {
			if ( slide.getAttribute( 'data-active' ) === 'true' ) {
				this.currentIndex = index;
			}
		} );

		// Initialize the gallery
		this.init();

		// Events.
		this.viewAllButton?.addEventListener( 'click', this.handleButtonClick.bind( this ) );
	}

	/**
	 * Initialize the gallery.
	 */
	init() {
		// Initialize the slider position based on the active slide
		if ( this.currentIndex > 0 ) {
			this.updateSliderPosition( this.currentIndex );
		}

		// Add click event listeners to thumbnails
		this.thumbnailItems.forEach( ( thumbnail, index ) => {
			thumbnail.addEventListener( 'click', () => {
				this.goToSlide( index );
			} );
		} );
	}

	/**
	 * Update the slider position.
	 *
	 * @param {number} index The slide index.
	 */
	updateSliderPosition( index ) {
		// Set a CSS custom property for the position
		this.slider.style.setProperty( '--slide-position', `-${ index * 100 }%` );
	}

	/**
	 * Go to a specific slide.
	 *
	 * @param {number} index The slide index.
	 */
	goToSlide( index ) {
		// Don't do anything if it's the current slide or the last slide
		if ( index === this.currentIndex || this.VIEW_ALL_INDEX === index ) {
			return;
		}

		// Remove active attribute from all thumbnails and slides
		this.thumbnailItems.forEach( ( item ) => item.removeAttribute( 'data-active' ) );
		this.slides.forEach( ( slide ) => slide.removeAttribute( 'data-active' ) );

		// Add active attribute to the selected thumbnail and slide
		this.thumbnailItems[ index ].setAttribute( 'data-active', 'true' );
		this.slides[ index ].setAttribute( 'data-active', 'true' );

		// Update the slider position
		this.updateSliderPosition( index );

		// Update the current index
		this.currentIndex = index;
	}

	/**
	 * Handle button click.
	 *
	 * @param {Event} event The click event.
	 */
	handleButtonClick( event ) {
		// Prevent default action
		event.preventDefault();

		// Check if lightboxTrigger is available.
		if ( ! this.lightboxTrigger ) {
			// If lightboxTrigger does not exist, bail out.
			return;
		}

		// Trigger the lightbox for the 3rd thumbnail.
		this.lightboxTrigger[ this.VIEW_ALL_INDEX ].trigger();
	}
}

/**
 * Initialize.
 */
customElements.define( 'ati-product-gallery', ProductGallery );
ProductDetails.init();
