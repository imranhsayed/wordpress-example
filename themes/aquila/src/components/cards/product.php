<?php
/**
 * Component Product Card
 *
 * @component Product Card
 * @description A reusable product-card component with content.
 * @group UI Elements
 * @props {
 *     "image_id": {"type": "int", "required": true, "description": "Product Card Image attachment ID"},
 *     "heading": {"type": "string", "required": false, "description": "Product  Card heading text"},
 *     "url": {"type": "string", "description": "Card URL (optional)"},
 *     "category": {"type": "string", "required": false, "description": "Product category"},
 *     "product_tag": {"type": "string", "required": false, "description": "product tag"},
 *     "content": {"type": "string", "required": false, "description": "Product Card content"},
 *     "heading_level": {"type": "string", "required": false, "description": "Use custom heading level", "options": ["h1", "h2", "h3", "h4", "h5", "h6"]},
 * }
 * @variations {}
 * @example get_component(
 *     'cards',
 *     'product',
 *     [
 *         'image_id' => 21,
 *         'category' => 'Product Category',
 *         'product_tag' => 'New',
 *         'content'  => '
 *             <h3>Axia Force/Torque Sensors ECAT-AXIA80-M50</h3>
 *         ',
 *     ],
 * );
 *
 * @package Aquila\Components
 */

// Import the Template class from the Aquila\Theme\ namespace.
use Aquila\Theme\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$product_id         = $args['post_id'] ?? 0;
$has_cta            = $args['has_cta'] ?? false;
$image_id           = $args['image_id'] ?? '';
$heading_level      = $args['heading_level'] ?? 'h3';
$heading            = $args['heading'] ?? '';
$url                = $args['url'] ?? '';
$category           = $args['category'] ?? '';
$product_tag        = $args['product_tag'] ?? '';
$content            = $args['content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $heading ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'product-card' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >

	<div class="product-card__content-wrap">
		<?php if ( ! empty( $category ) || ! empty( $product_tag ) ) { ?>
			<div class="product-card__meta">
				<?php if ( ! empty( $category ) ) { ?>
					<span class="product-card__category has-small-font-size">
						<?php echo esc_html( $category ); ?>
					</span>
				<?php } ?>

				<?php if ( ! empty( $product_tag ) ) { ?>
					<span class="product-card__product-tag has-tiny-font-size">
						<?php echo esc_html( $product_tag ); ?>
					</span>
				<?php } ?>
			</div>
		<?php } ?>

		<figure class="product-card__image-wrap">
			<?php
			// Image Component.
			Template::render_component(
				'image',
				null,
				[
					'id'              => $image_id,
					'size'            => [ 400, 400 ],
					'use_focal_point' => true, // Use focal point for the image.
				]
			);
			?>
		</figure>

		<<?php echo esc_html( $heading_level ); ?> class="product-card__heading has-large-font-size">
			<?php if ( ! empty( $url ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>" class="stretched-link product-card__link">
			<?php endif; ?>

				<?php echo esc_html( $heading ); ?>

			<?php if ( ! empty( $url ) ) : ?>
				</a>
			<?php endif; ?>
		</<?php echo esc_html( $heading_level ); ?>>

	</div>

	<?php if ( ! empty( $content ) || ! empty( $product_id ) ) { ?>
		<div class="product-card__content">
			<div class="product-card__content-inner-wrap">
				<?php aquila_kses_post_e( $content ); ?>
			</div>

			<?php
			if ( $has_cta && ! empty( $product_id ) ) {
				Template::render_component(
					'add-to-cart-button',
					null,
					[
						'product_id' => $product_id,
					]
				);
			}
			?>
		</div>
	<?php } ?>
</div>
