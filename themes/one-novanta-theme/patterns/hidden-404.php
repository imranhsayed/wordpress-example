<?php
/**
 * Pattern hidden 404
 *
 * Title: 404 content
 * Slug: one-novanta-theme/hidden-404
 * Description: 404 pattern content.
 * Categories:
 * Keywords: 404, 404 error
 * Viewport Width: 1280
 * Block Types:
 * Post Types:
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

// Image 404 URL.
$image_404_url = '';

if ( defined( 'ONE_NOVANTA_THEME_URI' ) ) {
	$image_404_url = trailingslashit( ONE_NOVANTA_THEME_URI ) . 'src/svg/404.svg';
}

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|100","bottom":"var:preset|spacing|100"}}},"backgroundColor":"secondary","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--100);padding-bottom:var(--wp--preset--spacing--100)">
	<!-- wp:cover {"url":"<?php echo esc_url( $image_404_url ); ?>","dimRatio":0,"customOverlayColor":"#d7d7d7","isUserOverlayColor":false,"isDark":false,"sizeSlug":"large","align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-cover alignwide is-light">
		<img class="wp-block-cover__image-background size-large" alt="" src="<?php echo esc_url( $image_404_url ); ?>" data-object-fit="cover"/>
		<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#d7d7d7"></span>
		<div class="wp-block-cover__inner-container">
			<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"xxx-large"} -->
			<h2 class="wp-block-heading has-text-align-center has-xxx-large-font-size" id="h-sorry-we-couldn-t-find-what-you-were-looking-for" style="font-style:normal;font-weight:600">Sorry we couldn't find what you were looking for…</h2>
			<!-- /wp:heading -->
		</div>
	</div>
	<!-- /wp:cover -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"has-arrow"} -->
		<div class="wp-block-button has-arrow">
			<a class="wp-block-button__link wp-element-button" href="#">Back to homepage</a>
		</div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"has-arrow"} -->
		<div class="wp-block-button has-arrow">
			<a class="wp-block-button__link wp-element-button" href="#">Contact us</a>
		</div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
