<?php
/**
 * Section Product Details
 *
 * @package OneNovantaTheme\Components
 *
 * @component Product Details
 * @description A reusable product details component
 * @group UI Elements
 * @props {}
 */

// Import the template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$content            = $args['content'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'product-details',
			]
		),
	],
];

// Combine the extra attributes with the wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<div class="product-details__wrapper">
		<?php one_novanta_kses_post_e( $content ); ?>
	</div>
</div>
