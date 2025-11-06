<?php
/**
 * Component Attribute
 *
 * @component Attribute
 * @description A flexible Attributes component.
 * @group UI Elements
 * @props {
 *     "attributes": { "type": "array", "required": true, "description": "List items" }
 * }
 * @variations {}
 * @example render_component(
 *     'product-search',
 *     'attributes',
 *     [
 *         'attributes' => [
 *             [
 *                 'heading' => 'Yes',
 *                 'content' => 'yes',
 *             ],
 *             [
 *                 'heading' => 'No',
 *                 'content' => 'no',
 *             ],
 *         ],
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default contents if not set.
$attributes = $args['attributes'] ?? [];

// Return null if the content is empty to prevent further processing.
if ( empty( $attributes ) ) {
	return null;
}
?>

<ul class="product-search__attributes">
	<?php foreach ( $attributes as $attribute ) { ?>
		<li class="product-search__attribute">
			<strong class="product-search__attribute-heading"><?php echo esc_html( $attribute['heading'] ); ?></strong>
			<div class="product-search__attribute-content"><?php one_novanta_kses_post_e( $attribute['content'] ); ?></div>
		</li>
	<?php } ?>
</ul>
