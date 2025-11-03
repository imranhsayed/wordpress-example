<?php
/**
 * Component Article Collection Card
 *
 * @component Article Collection Card
 * @description A reusable article-collection-card component with content.
 * @group UI Elements
 * @props {
 *     "image_id": {"type": "int", "required": true, "description": "Article Collection Card Image attachment ID"},
 *     "heading": {"type": "string", "required": false, "description": "Article Collection Card heading text"},
 *     "url": {"type": "string", "description": "Card URL (optional)"},
 *     "category": {"type": "string", "required": false, "description": "category"},
 *     "content": {"type": "string", "required": false, "description": "Listing Card content"},
 *     "heading_level": {"type": "string", "required": false, "description": "Use custom heading level", "options": ["h1", "h2", "h3", "h4", "h5", "h6"]},
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
 * @package Aquila\Components
 */

// Import the Template class from the Aquila\Theme\ namespace.
use Aquila\Theme\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id       = $args['image_id'] ?? '';
$heading        = $args['heading'] ?? '';
$url            = $args['url'] ?? '';
$category       = $args['category'] ?? '';
$content        = $args['content'] ?? '';
$heading_level  = $args['heading_level'] ?? 'h2';
$read_more_text = $args['read_more_text'] ?? __( 'Read more', 'one-aquila-theme' );

$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Extra attributes.
$extra_attributes = [
	'class' => [ 'article-collection-card' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<figure class="article-collection-card__image-wrap">
		<?php if ( ! empty( $url ) ) : ?>
			<a href="<?php echo esc_url( $url ); ?>" class="article-collection-card__link">
		<?php endif; ?>

		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'              => $image_id,
				'size'            => [ 820, 410 ],
				'use_focal_point' => true, // Use focal point for the image.
			]
		);
		?>

		<?php if ( ! empty( $url ) ) : ?>
			</a>
		<?php endif; ?>
	</figure>

	<div class="article-collection-card__content-wrap">
		<div class="article-collection-card__heading-wrap">
			<?php if ( ! empty( $category ) ) { ?>
				<div class="article-collection-card__category has-tiny-font-size">
					<?php echo esc_html( $category ); ?>
				</div>
			<?php } ?>

			<<?php echo esc_html( $heading_level ); ?> class="article-collection-card__heading has-medium-font-size">
				<?php if ( ! empty( $url ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="article-collection-card__link">
				<?php endif; ?>

					<?php echo esc_html( $heading ); ?>

				<?php if ( ! empty( $url ) ) : ?>
					</a>
				<?php endif; ?>
			</<?php echo esc_html( $heading_level ); ?>>
		</div>

		<?php if ( ! empty( $content ) ) { ?>
			<div class="article-collection-card__content">
				<?php aquila_kses_post_e( $content ); ?>

				<?php if ( ! empty( $url ) ) : ?>
					<?php
						Template::render_component(
							'button',
							null,
							[
								'content' => $read_more_text,
								'variant' => 'secondary',
							],
						);
					?>
				<?php endif; ?>
			</div>
		<?php } ?>
	</div>
</div>
