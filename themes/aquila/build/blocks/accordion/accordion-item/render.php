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
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use Aquila\Theme\Template;

$open_by_default = empty( $attributes['openByDefault'] ) ? 'no' : 'yes';
$accordion_title = $attributes['title'] ?? '';
$content         = $content ?? '';
echo '<pre/>';
print_r('accordion-item-rendereds');

Template::render_component(
	'accordion',
	'item',
	[
		'open_by_default' => $open_by_default,
		'title'           => $accordion_title,
		'content'         => $content,
	]
);
