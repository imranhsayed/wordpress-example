<?php
/**
 * Component Product Variation Content
 *
 * @component Product Variation Content
 * @description A product variation content component with content.
 * @group UI Elements
 * @props {
 *     "content": {"type": "string", "require": false, "description": "Variation content."},
 * }
 *
 * @example render_component( 'product-variation-content', [
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

<ati-product-variation-content><?php one_novanta_kses_post_e( $content ); ?></ati-product-variation-content>
