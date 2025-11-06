<?php
/**
 * Component Hero
 *
 * @component Hero
 * @description A reusable hero component with content.
 * @group UI Elements
 * @props {
 *   "image_id": {"type": "int", "required": true, "description": "Hero Image attachment ID"},
 *   "content": {"type": "string", "required": false, "description": "Hero content"},
 *   "layout": {"type": "string", "required": false, "options": ["default", "narrow"], "description": "Hero layout. Defaults to default"},
 *   "height": {"type": "string", "required": false, "options": ["default", "large"], "description": "Hero height. Defaults to default"},
 * }
 * @variations {}
 * @example render_component(
 *     'hero',
 *     null,
 *     [
 *         'image_id' => 64,
 *         'content'  => get_component(
 *             'hero',
 *             'content',
 *             [
 *                 'vertical_align' => 'bottom',
 *                 'pre_heading'    => 'Robotics & Automation',
 *                 'heading'        => 'GBX Tool Changer Module',
 *                 'content'        => '<p>Product code 0033</p>',
 *             ],
 *         ),
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the Template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? '';
$content            = $args['content'] ?? '';
$layout             = $args['layout'] ?? '';
$height             = $args['height'] ?? '';
$overlay            = $args['overlay'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'hero alignfull',
				"hero--{$layout}"        => ! empty( $layout ),
				"hero--{$height}"        => ! empty( $height ),
				"has-overlay-{$overlay}" => ! empty( $overlay ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >

	<figure class="hero__image-wrap">
		<?php
		if ( ! empty( $image_id ) ) {
			// Image Component.
			Template::render_component(
				'image',
				null,
				[
					'id'   => $image_id,
					'size' => 'large',
				]
			);
		}
		?>
	</figure>

	<?php one_novanta_kses_post_e( $content ); ?>
</div>
