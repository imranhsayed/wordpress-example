<?php
/**
 * Component: Media Cover
 *
 * @component Media Cover
 * @description A reusable media-cover component with content.
 * @group UI Elements
 * @props {
 *   "image_id": {"type": "int", "required": true, "description": "Media Text Cover Image attachment ID."},
 *   "heading": {"type": "string", "required": true, "description": "Heading text."},
 *   "content": {"type": "string", "required": false, "description": "Media Text Cover content."},
 *   "content_width": {"type": "string", "required": false, "options": ["wide", "narrow"], "description": "Layout width. Defaults to wide."},
 *   "content_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Media text cover content's horizontal alignment. Defaults to left."},
 *   "wrapper_attributes": {"type": "string", "required": "false", "description": "Component's wrapper attributes"}
 * }
 * @variations {}
 * @example render_component(
 *     'media-cover',
 *     null,
 *     [
 *         'image_id'      => 64,
 *         'heading'       => 'Quis nostrud exercitation',
 *         'content_align' => 'right',
 *         'content_align' => 'right',
 *         'content_width' => 'narrow',
 *         'content'       => '
 *             <p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
 *             ' .
 *             get_component(
 *                 'buttons',
 *                 null,
 *                 [
 *                     'content' => get_component(
 *                     'button',
 *                     null,
 *                     [
 *                         'content' => 'Contact us',
 *                         'icon'    => true,
 *                         'url'     => '#',
 *                         'variant' => 'primary-dark',
 *                     ],
 *                 ),
 *             ]
 *         ),
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the Template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['image_id'] ) ) {
	return;
}

// Default args.
$defaults = [
	'image_id'           => 0,
	'heading'            => '',
	'content'            => '',
	'content_width'      => 'wide',
	'content_align'      => 'left',
	'wrapper_attributes' => '',
];

// Merge args with default args.
$args = wp_parse_args( $args, $defaults );

// Retrieve attributes from the argument array, providing default values if not set.
$image_id           = is_int( $args['image_id'] ) ? $args['image_id'] : $defaults['image_id'];
$heading            = is_string( $args['heading'] ) ? $args['heading'] : $defaults['heading'];
$content            = is_string( $args['content'] ) ? $args['content'] : $defaults['content'];
$content_width      = is_string( $args['content_width'] ) ? $args['content_width'] : $defaults['content_width'];
$content_align      = is_string( $args['content_align'] ) ? $args['content_align'] : $defaults['content_align'];
$wrapper_attributes = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'one-novanta-media-cover alignfull is-layout-constrained',
				"one-novanta-media-cover--content-width-{$content_width}",
				"one-novanta-media-cover--content-align-{$content_align}" => ! empty( $content_align ),
			],
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<figure class="one-novanta-media-cover__image-wrap alignfull">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'   => $image_id,
				'size' => [ 1920, 640 ],
			],
		);
		?>
	</figure>

	<?php if ( ! empty( $content ) ) { ?>
		<div class="one-novanta-media-cover__content alignwide">
			<div class="one-novanta-media-cover__content-wrap">
				<h3 class="one-novanta-media-cover__heading">
					<?php echo esc_html( $heading ); ?>
				</h3>

				<?php one_novanta_kses_post_e( $content ); ?>
			</div>
		</div>
	<?php } ?>
</div>
