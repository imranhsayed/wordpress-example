<?php
/**
 * Component Article Card
 *
 * @component Article Card
 * @description A reusable article-card component with content.
 * @group UI Elements
 * @props {
 *     "image_id": {"type": "int", "required": true, "description": "Article Card Image attachment ID"},
 *     "heading": {"type": "string", "required": false, "description": "Article Card heading text"},
 *     "url": {"type": "string", "description": "Card URL (optional)"},
 *     "category": {"type": "string", "required": false, "description": "category"},
 * }
 * @variations {}
 * @example get_component(
 *     'cards',
 *     'article',
 *     [
 *         'image_id' => 21,
 *         'url' => '#',
 *         'category' => 'Category',
 *         'content'  => '
 *             <h3>Magnis arcu habitant congue magnis arcu habitant congue</h3>
 *         ',
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the Template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? '';
$heading            = $args['heading'] ?? '';
$url                = $args['url'] ?? '';
$category           = $args['category'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Extra attributes.
$extra_attributes = [
	'class' => [ 'article-card' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<figure class="article-card__image-wrap">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'              => $image_id,
				'size'            => [ 800, 600 ],
				'use_focal_point' => true, // Use focal point for the image.
			]
		);
		?>
	</figure>

	<div class="article-card__content">
		<?php if ( ! empty( $category ) ) { ?>
			<div class="article-card__category has-tiny-font-size">
				<?php echo esc_html( $category ); ?>
			</div>
		<?php } ?>

		<h3 class="article-card__heading">
			<?php if ( ! empty( $url ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>" class="stretched-link article-card__link">
			<?php endif; ?>

				<?php echo esc_html( $heading ); ?>

			<?php if ( ! empty( $url ) ) : ?>
				</a>
			<?php endif; ?>
		</h3>
	</div>
</div>
