<?php
/**
 * Component Media Text
 *
 * @component Media Text
 * @description A reusable media text component with content.
 * @group UI Elements
 * @props {
 *     "image_id": {"type": "int", "required": true, "description": "Media Text Image attachment ID"},
 *     "content": {"type": "string", "required": true, "description": "Media text content"},
 *     "background_color": { "type": "string", "require": false, "options": ["background", "secondary"], "description": "Background color." },
 *     "media_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Media horizontal alignment. Defaults to left"},
 * }
 * @variations {}
 * @example render_component(
 *     'media-text',
 *     null,
 *     [
 *         'image_id'         => 21,
 *         'background_color' => 'secondary',
 *         'content'          => '
 *             <h2 class="has-xxx-large-font-size">Fill Out an Application Worksheet</h2>
 *             <p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
 *             ' .
 *             Template::get_component(
 *                 'buttons',
 *                 null,
 *                 [
 *                     'content' =>
 *                         // Primary Button.
 *                         Template::get_component(
 *                             'button',
 *                             null,
 *                             [
 *                                 'content' => 'About us',
 *                                 'icon'    => true,
 *                                 'url'     => '#',
 *                             ]
 *                         ) .
 *                         // Secondary Button.
 *                         Template::get_component(
 *                             'button',
 *                             null,
 *                             [
 *                                 'content' => 'Talk to an expert',
 *                                 'icon'    => false,
 *                                 'url'     => '#',
 *                                 'variant' => 'secondary',
 *                             ]
 *                         ),
 *                 ]
 *             ),
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
$background_color   = $args['background_color'] ?? '';
$media_align        = $args['media_align'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'media-text',
				"media-text--media-align-{$media_align}"   => ! empty( $media_align ),
				"has-{$background_color}-background-color" => ! empty( $background_color ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<figure class="media-text__media">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'   => $image_id,
				'size' => 'large',
			]
		);
		?>
	</figure>

	<div class="media-text__content has-medium-font-size has-heading-font-family">
		<?php echo $content; // phpcs:ignore -- This is a wrapper element child components are responsible for escaping the content. ?>
	</div>
</div>
