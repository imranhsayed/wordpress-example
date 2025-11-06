/**
 * ProductVariationContent Class.
 */
export default class ProductVariationContent extends HTMLElement {
	/**
	 * Constructor.
	 */
	constructor() {
		super();

		if ( ! wp || ! wp.hooks || ! wp.hooks.addAction ) {
			return;
		}

		// Register event.
		wp.hooks.addAction( 'ati_woocommerce_single_product_variation_change', 'product-variation-content', this.onVariationChange.bind( this ) );
		wp.hooks.addAction( 'ati_woocommerce_single_product_variation_data', 'product-variation-content', this.onVariationDataGet.bind( this ) );
		wp.hooks.addAction( 'ati_woocommerce_single_product_hide_variation', 'product-variation-content', this.resetContent.bind( this ) );
	}

	/**
	 * Reset content.
	 */
	resetContent() {
		this.innerHTML = '';
	}

	/**
	 * Handle variation change.
	 */
	onVariationChange() {
		this.classList.add( 'loading' );
		this.resetContent();
	}

	/**
	 * Handle variation data get.
	 *
	 * @param {Object} variation Variation.
	 * @param {Object} response  Variation data.
	 */
	onVariationDataGet( variation, response ) {
		// Check if the response is valid.
		if ( 'success' !== response.status ) {
			this.classList.remove( 'loading' );
			return;
		}

		// Check if the response data is valid.
		if ( ! response.data ) {
			this.classList.remove( 'loading' );
			return;
		}

		// Update the inner HTML.
		this.innerHTML = response.data.post_content ?? '';

		// Remove loading class.
		this.classList.remove( 'loading' );
	}
}

/**
 * Initialize.
 */
customElements.define( 'ati-product-variation-content', ProductVariationContent );
