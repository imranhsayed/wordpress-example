<?php
/**
 * Component Media Text Cover
 *
 * @component Media Text Cover
 * @description A reusable media-text-cover component with content.
 * @group UI Elements
 * @props {
 *   "image_id": {"type": "int", "required": true, "description": "Media Text Cover Image attachment ID"},
 *   "heading": {"type": "string", "required": true, "description": "Heading text"},
 *   "content": {"type": "string", "required": false, "description": "Media Text Cover content"},
 *   "content_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Media text cover content's horizontal alignment. Defaults to left"},
 *   "vertical_align": {"type": "string", "required": false, "options": ["top", "middle", "bottom"], "description": "Media text cover content's vertical alignment. Defaults to stretch"},
 * }
 * @variations {}
 * @example render_component(
 *     'media-text-cover',
 *     null,
 *     [
 *         'image_id'      => 64,
 *         'content_align' => 'right',
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

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? '';
$content            = $args['content'] ?? '';
$heading            = $args['heading'] ?? '';
$content_align      = $args['content_align'] ?? '';
$vertical_align     = $args['vertical_align'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $image_id ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'media-text-cover alignwide',
				"media-text-cover--content-align-{$content_align}" => ! empty( $content_align ),
				"two-columns--vertical-align-{$vertical_align}" => ! empty( $vertical_align ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >

	<figure class="media-text-cover__image-wrap">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'   => $image_id,
				'size' => 'image-large',
			]
		);
		?>
	</figure>

	<?php if ( ! empty( $content ) ) { ?>
		<div class="media-text-cover__content has-medium-font-size has-heading-font-family">
			<h2 class="media-text-cover__heading has-xx-large-font-size">
				<?php echo esc_html( $heading ); ?>
			</h2>

			<?php one_novanta_kses_post_e( $content ); ?>
		</div>
	<?php } ?>
</div>
