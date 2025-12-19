<?php
/**
 * Component Section
 *
 * @component Section
 * @description A flexible section wrapper component with various layout options.
 * @group Layout
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Section content"},
 *   "class": {"type": "string", "description": "Additional CSS classes"},
 *   "id": {"type": "string", "description": "Section ID attribute"},
 *   "seamless": {"type": "boolean", "description": "Remove section padding"},
 *   "full_width": {"type": "boolean", "description": "Make section full width"},
 *   "background": {"type": "boolean", "description": "Add background to section"},
 *   "background_color": {"type": "string", "required": false, "options": ["grey-900","grey-200"], "description": "Background color. Defaults to gray"},
 *   "padding": {"type": "boolean", "description": "Add padding to seamless section"},
 *   "wrap": {"type": "boolean", "description": "Wrap content in div.wrap"}
 * }
 *
 * @variations {
 *   "default": {
 *     "content": "<p>This is a default section with standard padding and width.</p>"
 *   },
 *   "seamless": {
 *     "content": "<p>This is a seamless section without padding.</p>",
 *     "seamless": true
 *   },
 *   "full-width": {
 *     "content": "<p>This is a full-width section that spans the entire viewport.</p>",
 *     "full_width": true
 *   },
 *   "with-background": {
 *     "content": "<p>This section has a gray background.</p>",
 *     "background": true,
 *     "wrap": true
 *   },
 *   "with-background-black": {
 *     "content": "<p style='color: white;'>This section has a black background.</p>",
 *     "background": true,
 *     "background_color": "grey-900",
 *     "wrap": true
 *   },
 *   "seamless-with-padding": {
 *     "content": "<p>This is a seamless section but with padding added back.</p>",
 *     "seamless": true,
 *     "padding": true
 *   }
 * }
 * @example Template::render_component(
 *     'section',
 *     [
 *         'content'    => '<p>Section content here</p>',
 *         'background' => true,
 *         'wrap'       => true,
 *     ]
 * );
 *
 * @package Aquila
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? '';
$class              = $args['class'] ?? '';
$id                 = $args['id'] ?? '';
$seamless           = $args['seamless'] ?? false;
$full_width         = $args['full_width'] ?? false;
$background         = $args['background'] ?? false;
$background_color   = $args['background_color'] ?? 'grey-50';
$padding            = $args['padding'] ?? false;
$wrap               = $args['wrap'] ?? false;
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// If background is enabled, set wrap to true and validate background color.
if ( ! empty( $background ) && true === boolval( $background ) ) {
	$wrap = true;

	// Validate background color.
	$background_colors = array( 'grey-900', 'grey-200' );
	if ( ! in_array( $background_color, $background_colors, true ) ) {
		$background_color = 'gray-50';
	}
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		postmedia_merge_classes(
			[
				'section',
				$class                                                      => ! empty( $class ),
				'section--seamless'                                         => ! empty( $seamless ) && true === boolval( $seamless ),
				'section--has-background'                                   => ! empty( $background ) && true === boolval( $background ),
				'section--seamless-with-padding'                            => ( ! empty( $background ) && true === boolval( $background ) ) || ( ! empty( $padding ) && true === boolval( $padding ) ),
				"section--has-background-{$background_color}"               => ! empty( $background ) && true === boolval( $background ),
				'full-width'                                                => ( ! empty( $background ) && true === boolval( $background ) ) || ( ! empty( $full_width ) && true === boolval( $full_width ) ),
			]
		),
	],
];

// Add ID attribute if provided.
if ( ! empty( $id ) ) {
	$extra_attributes['id'] = $id;
}

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = postmedia_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<section <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<?php if ( ! empty( $wrap ) ) : ?>
		<div class="wrap">
	<?php endif; ?>

	<?php postmedia_kses_post_e( $content ); ?>

	<?php if ( ! empty( $wrap ) ) : ?>
		</div>
	<?php endif; ?>
</section>
