<?php
/**
 * Pattern Header
 *
 * Title: Header
 * Slug: one-novanta-theme/header
 * Description: Header pattern.
 * Categories: header
 * Keywords: header
 * Viewport Width: 1280
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

// Logo.
$novanta_logo_gray_url = '';

if ( defined( 'ONE_NOVANTA_THEME_URI' ) ) {
	$novanta_logo_gray_url = trailingslashit( ONE_NOVANTA_THEME_URI ) . 'src/svg/novanta-logo-gray.svg';
}

?>

<!-- wp:group {"className":"one-novanta-header","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group one-novanta-header">

<!-- wp:group {"align":"wide","className":"one-novanta-header__top","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group alignwide one-novanta-header__top">

		<!-- wp:paragraph {"className":"one-novanta-header__company"} -->
		<p class="one-novanta-header__company"><strong>a Novanta company</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:image {"id":210,"width":"134px","height":"25px","sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large is-resized">
			<img src="<?php echo esc_url( $novanta_logo_gray_url ); ?>" alt="Novanta logo" class="wp-image-210" style="width:134px;height:25px" />
		</figure>
		<!-- /wp:image -->

	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"one-novanta-header__bottom","layout":{"type":"flex","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide one-novanta-header__bottom">

		<!-- wp:site-logo {"shouldSyncIcon":true} /-->

		<!-- wp:group {"className":"one-novanta-header__right","style":{"layout":{"flexSize":null}},"layout":{"type":"flex","justifyContent":"right"}} -->
		<div class="wp-block-group one-novanta-header__right">

			<!-- wp:group {"className":"one-novanta-header__navigation-wrap","style":{"layout":{"flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
			<div class="wp-block-group one-novanta-header__navigation-wrap">
				<!-- wp:navigation {"ref":79,"overlayMenu":"never","metadata":{"ignoredHookedBlocks":["woocommerce/customer-account","woocommerce/mini-cart"]},"className":"one-novanta-header__navigation","fontSize":"navigation","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right"}} /-->

				<!-- wp:one-novanta/header-search /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:one-novanta/locale-switcher /-->

			<!-- wp:one-novanta/cart-button /-->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
