<?php
/**
 * Component Product Variation Related Modules
 *
 * @component Product Variation Related Modules
 * @description A product variation content component with content.
 * @group UI Elements
 * @props {
 *     "content": {"type": "string", "require": false, "description": "Variation content."},
 * }
 *
 * @example render_component( 'product-variation-related-modules', [
 *     'content': 'Content...'
 * ] )
 *
 * @package OneNovantaTheme\Components
 */

// Get arguments.
$args = $args ?? [];

// Get content.
$content = is_string( $args['content'] ) ? $args['content'] : '';
?>

<ati-product-variation-related-modules><?php one_novanta_kses_post_e( $content ); ?></ati-product-variation-related-modules>
