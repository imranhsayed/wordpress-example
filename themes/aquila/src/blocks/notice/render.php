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

$notice_content = isset( $attributes['content'] ) && ! empty( $attributes['content'] ) ? $attributes['content'] : '';

// If no content, don't render the block
if ( empty( $notice_content ) ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'aquila-notice',
	]
);
?>

<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<p class="aquila-notice__content">
		<?php echo wp_kses_post( $notice_content ); ?>
	</p>
</div>
