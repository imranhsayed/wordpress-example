<?php
/**
 * Component Two Columns
 *
 * @component Two Columns
 * @description A flexible two-columns layout component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Column as content"},
 *   "content_align": {"type": "string", "required": false, "options": ["left", "right"], "description": "Column content's horizontal alignment. Defaults to left"},
 *   "vertical_align": {"type": "string", "required": false, "options": ["top", "middle", "bottom"], "description": "Column content's vertical alignment. Defaults to stretch"},
 * }
 * @variations {}
 * @example render_component(
 *    'two-columns',
 *    null,
 *    [
 *       'content' => get_component(
 *           'two-columns',
 *           'column',
 *              [
 *                  'content' => '<h2 class="has-xx-large-font-size">How we can help the automotive industry?</h2>',
 *              ],
 *          ) .
 *          get_component(
 *              'two-columns',
 *              'column',
 *              [
 *                  'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
 *                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *                      <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
 *                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *                      ',
 *              ],
 *          )
 *    ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content              = $args['content'] ?? '';
$content_align        = $args['content_align'] ?? '';
$vertical_align       = $args['vertical_align'] ?? '';
$reverse_mobile_order = $args['reverse_mobile_order'] ?? '';
$wrapper_attributes   = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'two-columns',
				"two-columns--content-align-{$content_align}" => ! empty( $content_align ),
				"two-columns--vertical-align-{$vertical_align}" => ! empty( $vertical_align ),
				'two-columns--reverse-order' => ! empty( $reverse_mobile_order ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<?php echo $content; // phpcs:ignore -- This is a wrapper element child components are responsible for escaping the content. ?>
</div>
