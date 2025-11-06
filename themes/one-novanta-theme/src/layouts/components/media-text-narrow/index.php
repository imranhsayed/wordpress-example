<?php
/**
 * Component Media Text Narrow
 *
 * @component Media Text Narrow
 * @description A reusable media text component with narrow content.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Media text narrow content"},
 *   "media_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Media horizontal alignment. Defaults to left"},
 *   "vertical_align": {"type": "string", "required": false, "options": ["top", "middle", "bottom"], "description": "Column content's vertical alignment. Defaults to middle"},
 * }
 * @variations {}
 * @example render_component(
 *     'media-text-narrow',
 *     null,
 *     [
 *         'content' => get_component(
 *             'media-text-narrow',
 *             'media',
 *             [
 *                 'content' => get_component(
 *                     'image',
 *                     null,
 *                     [
 *                         'id'   => 21,
 *                         'size' => 'large',
 *                     ]
 *                 ),
 *             ],
 *        ) .
 *        get_component(
 *            'media-text-narrow',
 *            'content',
 *            [
 *                'overline' => 'Industry 01',
 *                'heading'  => 'Automotive',
 *                'content'  => '
 *                    <p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos peha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequaue himenaeos elementum vestibulum dui malesuada interrpis euismod.</p>
 *                    <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
 *                ',
 *            ],
 *        ),
 *    ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? '';
$media_align        = $args['media_align'] ?? '';
$vertical_align     = $args['vertical_align'] ?? '';
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
				'media-text-narrow',
				"media-text-narrow--media-align-{$media_align}" => ! empty( $media_align ),
				"media-text-narrow--vertical-align-{$vertical_align}" => ! empty( $vertical_align ),
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
