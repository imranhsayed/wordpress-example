<?php
/**
 * Component Add to Cart button
 *
 * @component Add to Cart
 * @description A reusable Add to Cart
 * @group UI Elements
 * @props {
 *   "product_id": {"type": "number", "required": true, "description": "Product ID."},
 *   "text": {"type": "string", "required": false, "description": "Button text"},
 *   "added_text": {"type": "string", "required": false, "description": "Button text when product is added."},
 *   "icon": {"type": "boolean", "required": false, "description": "Should button have icon. Defaults to true"},
 *   "icon_name": {"type": "boolean", "required": "false", "description": "Icon Name. defaults to 'arrow-right'"},
 *   "wrapper_attributes": {"type": "string", "description": "Button Wrapper attributes (optional)"}
 * }
 * @example render_component('add-to-cart-button', [
 *   'product_id' => 101,
 *   'text' => 'Add to Quote',
 *   'added_text' => 'Added to Quote'
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Default values.
$defaults = [
	'product_id'         => 0,
	'text'               => __( 'Add to quote', 'one-novanta-theme' ),
	'added_text'         => __( 'Added to quote', 'one-novanta-theme' ),
	'failed_text'        => __( 'Failed', 'one-novanta-theme' ),
	'variation'          => [],
	'icon'               => true,
	'icon_name'          => 'arrow-right',
	'wrapper_attributes' => '',
];

// Merge arguments with defaults. Note: array_filter will automatically remove all the empty values.
$args = array_merge( $defaults, array_filter( $args ) );

if ( ! $args['product_id'] ) {
	return;
}

$extra_attributes = [
	'data-product-id'  => [ sprintf( '%d', absint( $args['product_id'] ) ) ],
	'data-text'        => [ sprintf( '%s', esc_attr( $args['text'] ) ) ],
	'data-added-text'  => [ sprintf( '%s', esc_attr( $args['added_text'] ) ) ],
	'data-failed-text' => [ sprintf( '%s', esc_attr( $args['failed_text'] ) ) ],
];

// Combine extra attributes into wrapper attributes.
$args['wrapper_attributes'] = one_novanta_get_wrapper_attributes( $extra_attributes, $args['wrapper_attributes'] );
?>

<ati-add-to-cart-button <?php echo wp_kses_data( $args['wrapper_attributes'] ); ?>>
	<?php
	Template::render_component(
		'button',
		null,
		[
			'content'   => $args['text'],
			'icon'      => $args['icon'],
			'icon_name' => $args['icon_name'],
			'variant'   => 'primary',
		]
	);
	?>
</ati-add-to-cart-button>
