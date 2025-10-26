<?php
/**
 * PHP file to render the block on server to show on the front end.
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
 * @package Aquila\Blocks
 */

if ( empty( $attributes ) || ! is_array( $attributes ) ) {
	return;
}

$notice_content = is_string( $attributes['content'] ) ? $attributes['content'] : '';

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'novanta-notice',
	]
);
?>

<div <?php aquila_kses_post_e( $wrapper_attributes ); ?>>
	<p class="novanta-notice__content">
		<?php aquila_kses_post_e( $notice_content ); ?>
	</p>
</div>
