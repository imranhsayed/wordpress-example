/**
 * AddToCartButton class.
 *
 * @description Add to card Button component
 */

class AddToCartButton extends HTMLElement {
	/**
	 * Button element.
	 *
	 * @type {HTMLElement}
	 */
	button = null;

	/**
	 * Product ID.
	 *
	 * @type {number}
	 */
	productID = 0;

	/**
	 * Quantity.
	 *
	 * @type {number}
	 */
	quantity = 1;

	/**
	 * Button text.
	 *
	 * @type {string}
	 */
	buttonText = '';

	/**
	 * Button added text.
	 *
	 * @type {string}
	 */
	buttonAddedText = '';

	/**
	 * Failed text.
	 *
	 * @type {string}
	 */
	failedText = '';

	/**
	 * Should add variation data in request.
	 *
	 * @type {boolean}
	 */
	shouldAddVariation = false;

	/**
	 * Constructor.
	 */
	constructor() {
		super();

		// Check if the wp object is available.
		if ( ! wp || ! wp.hooks || ! wp.hooks.addAction ) {
			return;
		}

		// Get button element.
		this.button = this.querySelector( 'button' );
		this.productID = parseInt( this.dataset.productId || 0 );

		// Bail out if button or product ID is not available.
		if ( ! this.button || ! this.productID ) {
			return;
		}

		// Get button text.
		this.buttonText = this.dataset.text || '';
		this.buttonAddedText = this.dataset.addedText || '';
		this.failedText = this.dataset.failedText || '';

		// If it's a single product add to cart button, set shouldAddVariation to true.
		if ( 'single-product-add-to-cart-button' === this.getAttribute( 'id' ) ) {
			this.shouldAddVariation = true;
		}

		// Register event.
		this.button.addEventListener( 'click', this.onClick.bind( this ) );
	}

	/**
	 * Handle button click.
	 *
	 * @param {Object} event Event object.
	 */
	onClick( event ) {
		// Prevent default action.
		event.preventDefault();

		// Check if function is available or not.
		if ( 'function' !== typeof WooCommerceCart || ! WooCommerceCart.add ) { // eslint-disable-line no-undef
			return;
		}

		// Disable button.
		this.button.disabled = true;

		// Fetch product ID.
		this.productID = parseInt( this.dataset.productId || 0 );

		const variation = [];

		if ( this.shouldAddVariation ) {
			document.querySelectorAll( '.variations_form select' ).forEach( ( element ) => {
				const attributeName = element.dataset.attributeName || element.name;
				const attributeValue = element.value;
				if ( attributeName && attributeValue ) {
					variation.push(
						{
							attribute: attributeName,
							value: attributeValue,
						},
					);
				}
			} );
		}

		// Add product to cart.
		WooCommerceCart.add( this.productID, this.quantity, variation, ( response ) => { // eslint-disable-line no-undef
			// Enabled button.
			this.button.disabled = false;
			const buttonTextElement = this.button.querySelector( '.text' );

			if ( ! buttonTextElement ) {
				// Restore button text.
				setTimeout( () => {
					this.button.innerText = this.buttonText;
				}, 2000 );
				return;
			}

			if ( response.items_count && 'number' === typeof response.items_count ) {
				// Update button text.
				buttonTextElement.innerText = this.buttonAddedText || this.buttonText;
			} else {
				buttonTextElement.innerText = this.failedText || this.buttonText;
			}

			// Restore button text.
			setTimeout( () => {
				buttonTextElement.innerText = this.buttonText;
			}, 2000 );
		} );
	}
}

/**
 * Initialize.
 */
customElements.define( 'ati-add-to-cart-button', AddToCartButton );
