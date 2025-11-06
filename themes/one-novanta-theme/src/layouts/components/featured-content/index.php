<?php
/**
 * Component Featured Content
 *
 * @component Featured Content
 * @description A reusable component with content and image.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Media text content"},
 *   "media_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Media horizontal alignment. Defaults to left"},
 * }
 * @variations {}
 * @example render_component(
 *     'featured-content',
 *     null,
 *     [
 *         'content' => get_component(
 *              'featured-content',
 *              'media',
 *              [
 *                  'content' => get_component(
 *                       'image',
 *                       null,
 *                       [
 *                           'id'   => 21,
 *                           'size' => 'large',
 *                        ]
 *                  ),
 *              ],
 *          ) .
 *          get_component(
 *              'featured-content',
 *              'content',
 *              [
 *                  'content' => '
 *                      <h2>Why ATI Material Removal Tools?</h2>
 *                      <p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
 *                      <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
 *                  ',
 *              ],
 *          ),
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? '';
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
				'featured-content',
				"featured-content--media-align-{$media_align}" => ! empty( $media_align ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<?php one_novanta_kses_post_e( $content ); ?>
</div>
