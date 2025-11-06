<?php
/**
 * Renders the Cart button block on the front end.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Default cart link.
$cart_link = '#';

// Check if WooCommerce is active and the function exists.
if ( function_exists( 'wc_get_cart_url' ) ) {
	$cart_link = wc_get_cart_url();
}
?>

<a href="<?php echo esc_url( $cart_link ); ?>" class="one-novanta-header__cart-link" aria-label="<?php esc_attr_e( 'Get a quote', 'one-novanta-theme' ); ?>">
	<span class="one-novanta-header__cart-badge"></span>
	<?php
	// SVG Component.
	Template::render_component(
		'svg',
		null,
		[ 'name' => 'cart' ],
	);
	?>
</a>

