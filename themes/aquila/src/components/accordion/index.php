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
 * @variations {
 *   "default": {"content": "<rt-accordion-item class=\"wp-aquila-accordion__item\" open-by-default=\"yes\"><rt-accordion-handle class=\"wp-aquila-accordion__handle\"><button class=\"wp-aquila-accordion__heading\"><span class=\"has-heading-font-family\">What is an accordion component?</span></button></rt-accordion-handle><rt-accordion-content class=\"wp-aquila-accordion__content\"><div class=\"wp-aquila-accordion__content-wrap\"><p>An accordion is a vertically stacked list of items. Each item can be expanded or collapsed to reveal the content associated with that item.</p></div></rt-accordion-content></rt-accordion-item>", "background_color": "", "wrapper_attributes": ""},
 *   "multiple-items": {"content": "<rt-accordion-item class=\"wp-aquila-accordion__item\" open-by-default=\"yes\"><rt-accordion-handle class=\"wp-aquila-accordion__handle\"><button class=\"wp-aquila-accordion__heading\"><span class=\"has-heading-font-family\">First Accordion Item</span></button></rt-accordion-handle><rt-accordion-content class=\"wp-aquila-accordion__content\"><div class=\"wp-aquila-accordion__content-wrap\"><p>This is the content of the first accordion item. It can contain any HTML content.</p></div></rt-accordion-content></rt-accordion-item><rt-accordion-item class=\"wp-aquila-accordion__item\"><rt-accordion-handle class=\"wp-aquila-accordion__handle\"><button class=\"wp-aquila-accordion__heading\"><span class=\"has-heading-font-family\">Second Accordion Item</span></button></rt-accordion-handle><rt-accordion-content class=\"wp-aquila-accordion__content\"><div class=\"wp-aquila-accordion__content-wrap\"><p>This is the content of the second accordion item with more details about the component functionality.</p></div></rt-accordion-content></rt-accordion-item>", "background_color": "", "wrapper_attributes": ""}
 * }
 * @extra_allowed_tags {
 *   "rt-accordion": {"class": true},
 *   "rt-accordion-item": {"open-by-default": true, "aria-expanded": true, "expanded": true, "class": true},
 *   "rt-accordion-handle": {"aria-expanded": true, "class": true},
 *   "rt-accordion-content": {"class": true}
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
 * @package Aquila\Components
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
$base_class = 'wp-aquila-accordion';

$extra_attributes = [
	'class' => [
		$base_class,
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<rt-accordion class="<?php echo esc_attr( "{$base_class}__wrapper" ); ?>">

		<?php aquila_kses_post_e( $content ); ?>

	</rt-accordion>

</div>
