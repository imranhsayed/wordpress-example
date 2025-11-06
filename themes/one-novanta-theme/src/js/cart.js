/**
 * Cart functionality for the One Novanta theme.
 */
document.addEventListener( 'DOMContentLoaded', () => {
	// Check if function is available or not.
	if ( 'function' !== typeof WooCommerceCart || 'function' !== typeof WooCommerceCart.get ) { // eslint-disable-line no-undef
		return;
	}

	/**
	 * Update the cart badge with the item count.
	 *
	 * @param {number} count The number of items in the cart.
	 */
	const updateCartBadge = ( count = 0 ) => {
		// Get cart count badges.
		const cartCountBadges = document.querySelectorAll( '.one-novanta-header__cart-badge' );

		// bail out if no badges found.
		if ( ! cartCountBadges.length ) {
			return;
		}

		// Update each badge with the count.
		cartCountBadges.forEach( ( badge ) => {
			if ( count ) {
				badge.classList.add( 'has-count' );
				badge.innerText = count;
			} else {
				badge.classList.remove( 'has-count' );
				badge.innerText = '';
			}
		} );
	};

	/**
	 * Update the cart data.
	 *
	 * @param {Object} response The response object.
	 */
	const updateCartData = ( response ) => {
		if ( response && Number.isInteger( response.items_count ) ) {
			updateCartBadge( response.items_count );
		}
	};

	/**
	 * Reset the cart data.
	 *
	 * @param {Object} response The response object.
	 */
	const resetCartData = ( response ) => {
		if ( ! Array.isArray( response ) || 0 !== response.length ) {
			return;
		}

		updateCartBadge( 0 );
	};

	/**
	 * Update the cart data on page load.
	 */
	WooCommerceCart.get( updateCartData ); // eslint-disable-line no-undef

	/**
	 * Update the cart data on cart updated event.
	 */
	wp.hooks.addAction( 'ati_woocommerce_cart_updated', 'cart-button', updateCartData );
	wp.hooks.addAction( 'ati_woocommerce_product_remove_all', 'cart-button', resetCartData );
} );
