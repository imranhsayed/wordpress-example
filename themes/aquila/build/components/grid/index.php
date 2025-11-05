<?php
/**
 * Component Grid
 *
 * @component Grid
 * @description A flexible grid component.
 * @group UI Elements
 * @props {
 *   "gap": {"type": "string", "required": false, "options": ["none", "default", "small", "large"], "description": "Grid Gap. Defaults to default"},
 *   "column_count": {"type": "int", "required": false, "description": "Column count. Defaults to 1"},
 *   "content": {"type": "string", "required": true, "description": "Grid content"},
 * }
 * @variations {
 *   "two-columns": {"column_count": 2, "content": "<div class=\"grid__item\"><p><strong>What is grid layout?</strong></p><p>Grid layout is a powerful CSS layout system that allows you to create complex responsive layouts with ease.</p></div><div class=\"grid__item\"><p><strong>Why use grid?</strong></p><p>Grid provides better control over layout structure, making it easier to create responsive designs that work across all devices.</p></div>"},
 *   "three-columns": {"column_count": 3, "content": "<div class=\"grid__item\"><p><strong>Feature One</strong></p><p>Advanced functionality for modern web applications.</p></div><div class=\"grid__item\"><p><strong>Feature Two</strong></p><p>Responsive design that adapts to any screen size.</p></div><div class=\"grid__item\"><p><strong>Feature Three</strong></p><p>Optimized performance for fast loading times.</p></div>"}
 * }
 * @example Template::render_component(
 *     'grid',
 *     null,
 *     [
 *         'column_count' => 2,
 *         'content'      => get_component(
 *             'grid',
 *             'item',
 *             [
 *                 'content' => '
 *                     <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
 *                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *                     <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
 *                 ',
 *             ],
 *         ) . get_component(
 *             'grid',
 *             'item',
 *             [
 *                 'content' => '
 *                     <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
 *                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *                     <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
 *                 ',
 *             ],
 *         ),
 *     ]
 * );
 *
 * @package Aquila\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$gap                = $args['gap'] ?? '';
$column_count       = $args['column_count'] ?? 1;
$content            = $args['content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		aquila_merge_classes(
			[
				'grid alignwide',
				"grid--cols-{$column_count}" => ! empty( $column_count ),
				"grid--gap-{$gap}"           => ! empty( $gap ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<?php aquila_kses_post_e( $content ); ?>
</div>
