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
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

Template::render_component(
	'tile',
	null,
	[
		'image_id'         => $attributes['imageID'] ?? '',
		'heading'          => $attributes['heading'] ?? '',
		'subheading'       => $attributes['subheading'] ?? '',
		'description'      => $attributes['description'] ?? '',
		'has_description'  => $attributes['hasDescription'] ?? false,
		'url'              => $attributes['url'] ?? '',
		'background_color' => $attributes['backgroundColor'] ?? '',
	],
);
