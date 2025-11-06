<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

if ( empty( $attributes ) || ! is_array( $attributes ) ) {
	return;
}

$custom_content = is_string( $attributes['content'] ) ? $attributes['content'] : '';
?>

<div <?php wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php one_novanta_kses_post_e( $custom_content ); ?>
</div>
