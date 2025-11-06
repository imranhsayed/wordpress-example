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
 * @var string $content The block content.
 * @var WP_Block $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

$current_post_id = get_the_ID();

// If the post ID is not set, return early.
if ( ! $current_post_id ) {
	return;
}

// Get the estimated reading time (make sure this variable is defined before using it).
$estimated_reading_time_minutes = get_post_meta( $current_post_id, '_yoast_wpseo_estimated-reading-time-minutes', true );
$time_unit                      = _n( 'minute', 'minutes', $estimated_reading_time_minutes, 'one-novanta-theme' );

if ( ! $estimated_reading_time_minutes ) {
	// If no reading time is set, return early.
	return;
}

$block_content = sprintf(
	'<!-- wp:yoast-seo/estimated-reading-time {"showDescriptiveText":false,"showIcon":false,"estimatedReadingTime":%d} -->
		<p class="yoast-reading-time__wrapper">
			<span class="yoast-reading-time__reading-time">
				%d
			</span>
			<span class="yoast-reading-time__time-unit">
				%s
			</span>
		</p>
		<!-- /wp:yoast-seo/estimated-reading-time -->',
	esc_attr( $estimated_reading_time_minutes ),
	esc_html( $estimated_reading_time_minutes ),
	esc_html( ' ' . $time_unit )
);

$parsed_block = parse_blocks( $block_content );

// Render the block content.
echo render_block( $parsed_block[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
