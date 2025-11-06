<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 * The following variables are exposed to the file:
 *    $attributes (array): The block attributes.
 *    $content (string): The block default content.
 *    $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string $content The block content.
 * @var WP_Block $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

if ( empty( $attributes ) || empty( $attributes['title'] ) ) {
	return;
}

$list_title  = esc_html( $attributes['title'] ?? '' );
$list_url    = esc_url( $attributes['url'] ?? '#' );
$list_target = ! empty( $attributes['opensInNewTab'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';


// Render the block.
Template::render_component(
	'info-box',
	'item',
	[
		'title'  => $list_title,
		'url'    => $list_url,
		'target' => $list_target,
	],
);
