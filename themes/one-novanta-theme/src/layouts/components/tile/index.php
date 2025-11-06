<?php
/**
 * Component: Tile
 *
 * @component Tile
 * @description A flexible tile component.
 * @group UI Elements
 * @props {
 *   "image_id": {"type": "int", "required": true, "description": "Tile Image attachment ID"},
 *   "heading": {"type": "string", "required": false, "description": "Tile heading text"},
 *   "subheading": {"type": "string", "required": false, "description": "Tile subheading text"},
 *   "description": {"type": "string", "required": false, "description": "Tile description text"},
 *   "url": {"type": "string", "required": false, "default": "", "description": "Tile URL"},
 *   "has_description": {"type": "boolean", "required": false, "default": false, "description": "If tile will has description", "options": [true, false]},
 *   "background_color": {"type": "string", "required": false, "options": ["secondary", "background"] "description": "Tile background color"},
 *   "heading_level": {"type": "string", "required": false, "description": "Use custom heading level", "options": ["h1", "h2", "h3", "h4", "h5", "h6"]},
 * }
 * @variations {}
 * @example render_component(
 *     'tile',
 *     null,
 *     [
 *         'image_id'         => 21,
 *         'heading'          => 'Tool changers',
 *         'subheading'       => 'Automatic/Robotic',
 *         'url'              => '',
 *         'background_color' => 'background',
 *         'has_description'  => false,
 *     ],
 * );
 * @package OneNovantaTheme\Components
 */

// Import the template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? 0;
$heading            = $args['heading'] ?? '';
$heading_tag        = $args['heading_tag'] ?? 'h3';
$subheading         = $args['subheading'] ?? '';
$description        = $args['description'] ?? '';
$url                = $args['url'] ?? '';
$background_color   = $args['background_color'] ?? 'secondary';
$has_description    = $args['has_description'] ?? false;
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$heading_level      = $args['heading_level'] ?? 'h3';

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'tile',
				"has-{$background_color}-background-color" => ! empty( $background_color ),
				'tile--has-description'                    => ! empty( $has_description ),
			]
		),
	],
];

// Combine the extra attributes with the wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<figure class="tile__figure">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'              => $image_id,
				'size'            => [ 800, 600 ],
				'attrs'           => array(
					'class' => 'tile__image',
				),
				'use_focal_point' => true, // Use focal point for the image.
			]
		);
		?>
	</figure>
	<div class="tile__content-wrapper">
		<div class="tile__content">
			<?php if ( ! empty( $subheading ) && empty( $has_description ) ) : ?>
				<p class="tile__subheading has-heading-font-family has-tiny-font-size">
					<?php echo esc_html( $subheading ); ?>
				</p>
			<?php endif; ?>

			<?php if ( ! empty( $heading ) ) : ?>
				<<?php echo esc_html( $heading_level ); ?> class="tile__heading has-large-font-size">
					<?php if ( ! empty( $url ) ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" class="stretched-link tile__link">
					<?php endif; ?>

						<?php echo $heading; // phpcs:ignore ?>

					<?php if ( ! empty( $url ) ) : ?>
						</a>
					<?php endif; ?>
				</<?php echo esc_html( $heading_level ); ?>>
			<?php endif; ?>

			<?php if ( ! empty( $has_description ) && ! empty( $description ) ) : ?>
				<p class="tile__description has-heading-font-family has-medium-font-size">
					<?php echo esc_html( $description ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php
		if ( ! empty( $url ) ) {
			// SVG arrow-right-thin.
			Template::render_component(
				'svg',
				null,
				[ 'name' => 'arrow-right-thin' ],
			);
		}
		?>
	</div>
</div>
