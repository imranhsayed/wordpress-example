<?php
/**
 * Product Details Description
 *
 * @package OneNovantaTheme\Blocks
 */

$product_title         = $args['title'] ?? '';
$product_content       = $args['content'] ?? '';
$pre_heading           = $args['pre_heading'] ?? '';
$pre_heading_link      = $args['pre_heading_link'] ?? '';
$show_all_feature_link = $args['show_all_feature_link'] ?? '';

?>
<div class="product-details__description">
	<?php if ( ! empty( $pre_heading ) && ! empty( $pre_heading_link ) ) : ?>
		<div class="taxonomy-product_cat product-details__category">
			<a href="<?php echo esc_url( $pre_heading_link ); ?>" rel="tag"><?php echo esc_html( $pre_heading ); ?></a>
		</div>
	<?php endif; ?>

	<h2 class="product-details__title"><?php one_novanta_kses_post_e( $product_title ); ?></h2>

	<div class="product-details__content">
		<?php one_novanta_kses_post_e( $product_content ); ?>
	</div>

	<a
		class="
		<?php
		echo esc_attr(
			one_novanta_merge_classes(
				[
					'product-details__link',
					'hidden' => empty( $show_all_feature_link ),
				],
			),
		);
		?>
		"
		href="<?php echo esc_url( $show_all_feature_link ); ?>"
	>
		<?php esc_html_e( 'View all features', 'one-novanta-theme' ); ?>
	</a>

	<novanta-product-tooltip class="product-details__tooltip">
		<!-- wp:woocommerce/add-to-cart-form {"className": "product-details__add-to-cart-form"} /-->
	</novanta-product-tooltip>
</div>
