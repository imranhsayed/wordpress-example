<?php
/**
 * Product Details Options
 *
 * @package OneNovantaTheme\Blocks
 */

$content = $args['content'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}
?>

<div class="product-details__options">
	<?php one_novanta_kses_post_e( $content ); ?>
</div>
