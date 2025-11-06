<?php
/**
 * Component Accordion
 *
 * @component Accordion
 * @description A reusable accordion component
 * @group UI Elements
 * @props {
 *   "data": {"type": "array", "required": true, "description": "Accordion Data"},
 *   "background_color": {"type": "string", "required": false, "options": ["background", "secondary"], "description": "Table background color."},
 *   "wrapper_attributes": {"type": "string", "description": "Button Wrapper attributes (optional)"}
 * }
 * @example render_component( 'accordion', [
 *    'content' => get_component(
 *                     'accordion',
 *                     'item',
 *                     [
 *                         'title'           => 'Natoque himenaeos',
 *                         'open_by_default' => true,
 *                         'content'         =>  Template::get_component(
 *                                                   'accordion',
 *                                                   'item',
 *                                                   [
 *                                                       'title'           => 'Accordion component',
 *                                                       'open_by_default' => true,
 *                                                       'content'         => '<p>Lets users show and hide sections of related content on a page.</p><p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum turpis euismod.</p><p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles. Glatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivlatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam viv.</p>' .
 *                                                                                Template::get_component(
 *                                                                                    'button',
 *                                                                                    null,
 *                                                                                    [
 *                                                                                        'content'  => 'Secondary',
 *                                                                                        'url'      => '#',
 *                                                                                        'icon'     => true,
 *                                                                                        'variant'  => 'secondary',
 *                                                                                        'disabled' => 'false',
 *                                                                                        'wrapper_attributes' => '',
 *                                                                                    ]
 *                                                                                ),
 *                                                   ],
 *                                               ) . Template::get_component(
 *                                                       'accordion',
 *                                                       'item',
 *                                                       [
 *                                                           'title'           => 'Accordion component',
 *                                                           'open_by_default' => true,
 *                                                           'content'         => '<p>Lets users show and hide sections of related content on a page.</p><p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum turpis euismod.</p><p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles. Glatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivlatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam viv.</p>' .
 *                                                                                    Template::get_component(
 *                                                                                        'button',
 *                                                                                        null,
 *                                                                                        [
 *                                                                                            'content'  => 'Secondary',
 *                                                                                            'url'      => '#',
 *                                                                                            'icon'     => true,
 *                                                                                            'variant'  => 'secondary',
 *                                                                                            'disabled' => 'false',
 *                                                                                            'wrapper_attributes' => '',
 *                                                                                        ]
 *                                                                                    ),
 *                                                       ],
 *                                               ),
 *                     ],
 *                 ),
 *    'background_color' => 'secondary',
 *    'wrapper_attributes' => '',
 * ] );
 *
 * @package OneNovantaTheme\Components
 */

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['content'] ) ) {
	return;
}

// Default values.
$defaults = [
	'data'               => [],
	'background_color'   => '',
	'wrapper_attributes' => '',
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$content            = $args['content'] ?? '';

// Base class.
$base_class = 'wp-one-novanta-accordion';

$extra_attributes = [
	'class' => [
		$base_class,
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<rt-accordion class="<?php echo esc_attr( "{$base_class}__wrapper" ); ?>">

		<?php one_novanta_kses_post_e( $content ); ?>

	</rt-accordion>

</div>
