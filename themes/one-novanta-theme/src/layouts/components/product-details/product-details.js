/**
 * Component: Product Details.
 */

/**
 * Internal dependencies
 */
import { ensureMediaLightboxLoaded } from '../media-lightbox'; // Import the media lightbox component to ensure it's loaded.
import { convertStringToHTML } from '../../../js/utils';
import OneNovantaTabs from '../tabs';
import { OneNovantaLoadMore } from '../load-more/load-more';
import OneNovantaTableFilter from '../filter-dropdown';
import OneNovantaCompareModelTable from '../compare-model-table';
import OneNovantaTable from '../table';

/**
 * Product Details component.
 *
 * @type {Object}
 */
export const ProductDetails = {

	/**
	 * Initialize.
	 *
	 * @return {void}
	 */
	init() {
		// Bind functions.
		this.bindEvents = this.bindEvents.bind( this );
		this.bindAttributes = this.bindAttributes.bind( this );
		this.onVariationChange = this.onVariationChange.bind( this );
		this.mayBeShowViewAllFeatures = this.mayBeShowViewAllFeatures.bind( this );
		this.handleDefaultVariationLoad = this.handleDefaultVariationLoad.bind( this );

		// Bind events.
		this.bindEvents();
	},

	/**
	 * Bind Attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		this.productDetailsTitle = document.querySelector( '.product-details__title' );
		this.productDetailsContent = document.querySelector( '.product-details__content' );
		this.productDetailsGallery = document.querySelector( '.product-details__gallery' );
		this.viewAllFeatures = document.querySelector( '.product-details__link' );
		this.addToCartButton = document.querySelector( 'ati-add-to-cart-button#single-product-add-to-cart-button' );
		this.skuField = document.querySelector( '.product-details .single_variation_wrap .wp-block-woocommerce-product-meta .product-details__meta .sku' );
	},

	/**
	 * Bind events.
	 *
	 * @return {void}
	 */
	bindEvents() {
		// Bind Attributes.
		this.bindAttributes();

		wp?.hooks?.addAction( 'ati_woocommerce_single_product_variation_data', 'product-details', ( variation, response ) => {
			if ( ! response || 'success' !== response?.status ) {
				return;
			}

			this.onVariationChange( variation, response?.data );
		}, 12 );

		// Add variation change event listener for default variations to set product ID on add to cart button.
		jQuery( '.variations_form' ).one( 'found_variation', this.handleDefaultVariationLoad );

		// Initialize content load events.
		document.addEventListener( 'DOMContentLoaded', () => {
			this.mayBeShowViewAllFeatures();
		} );
	},

	/**
	 * Handle default variation load.
	 *
	 * @param {Event}  event     Event listener.
	 * @param {Object} variation Variation data.
	 *
	 * @return {void}
	 */
	handleDefaultVariationLoad( event, variation ) {
		if ( ! variation ) {
			return;
		}

		this.mayBeShowViewAllFeatures( variation.variation_is_active );

		this.addToCartButton?.setAttribute( 'data-product-id', variation.variation_id ?? 0 );
		if ( this.skuField ) {
			this.skuField.innerText = variation.sku;
		}
	},

	/**
	 * Conditionally displays and sets the href and visibility for the "View All Features" link
	 * based on the presence of specific feature section elements in the DOM.
	 *
	 * Logic:
	 * - If the element with ID '#one-novanta-single-product-all-features' exists, show the link and set its href to that section.
	 * - Else if '#product-feature-heading' exists, show the link and set href to that.
	 * - Otherwise, hide the link and set href to a default '#'.
	 *
	 * @param {boolean} variationIsActive Is variation active.
	 *
	 * @return {void}
	 */
	mayBeShowViewAllFeatures( variationIsActive = false ) {
		const isSimpleProduct = document.querySelector( 'form.variations_form.is_simple' );

		// Hide if variable product has no active variation.
		if ( ! isSimpleProduct && ! variationIsActive ) {
			this.viewAllFeatures?.classList?.add( 'hidden' );
			this.viewAllFeatures?.setAttribute( 'href', '#' );
			return;
		}

		if ( document.querySelector( '#one-novanta-single-product-all-features' ) ) {
			this.viewAllFeatures?.classList?.remove( 'hidden' );
			this.viewAllFeatures.setAttribute( 'href', '#one-novanta-single-product-all-features' );
		} else if ( document.querySelector( '#product-feature-heading' ) ) {
			this.viewAllFeatures?.classList?.remove( 'hidden' );
			this.viewAllFeatures?.setAttribute( 'href', '#product-feature-heading' );
		} else if ( document.querySelector( '#tab-product-features-1' ) ) {
			this.viewAllFeatures?.classList?.remove( 'hidden' );
			this.viewAllFeatures?.setAttribute( 'href', '#tab-product-features-1' );
		} else {
			this.viewAllFeatures?.classList?.add( 'hidden' );
			this.viewAllFeatures?.setAttribute( 'href', '#' );
		}
	},

	/**
	 * Fires when product variation is changed.
	 *
	 * @param {Object} variationData Product variation data.
	 * @param {Object} productData   Product Data.
	 *
	 * @return {void}
	 */
	onVariationChange( variationData, productData ) {
		if ( ! productData ) {
			return;
		}

		// Update product title.
		this.productDetailsTitle.innerText = productData?.post_title ?? '';

		// Update product content.
		this.productDetailsContent?.replaceChildren();
		this.productDetailsContent?.appendChild( convertStringToHTML( productData?.description ?? '', 'div' ) ?? '' );

		// Ensure media lightbox component is loaded before adding gallery markup.
		ensureMediaLightboxLoaded();

		if ( ! productData?.gallery_markup || 0 === productData.gallery_markup.trim().length ) {
			productData.gallery_markup = '<div class="product-details__gallery"></div>';
		}

		// Update product gallery.
		this.productDetailsGallery?.replaceWith( convertStringToHTML( productData.gallery_markup ) ?? '' );

		this.addToCartButton?.setAttribute( 'data-product-id', productData?.ID ?? 0 );

		if ( this.skuField && productData?.sku ) {
			this.skuField.innerText = productData.sku;
		}

		this.mayBeShowViewAllFeatures( variationData?.variation_is_active );

		// Re-bind tab events.
		OneNovantaTabs.bindEvents();

		// Re-bind Load More events.
		OneNovantaLoadMore.bindEvents();

		// Re-bind Filter events.
		OneNovantaTableFilter.bindEvents();

		// Re-bind Table events.
		OneNovantaTable.bindEvents();

		// Re-bind table loading observer.
		OneNovantaTable.registerIsLoadingObserver();

		// Re-bind Compare Model Table events.
		OneNovantaCompareModelTable.bindEvents();

		// Re-bind Attributes.
		this.bindAttributes();
	},
};
