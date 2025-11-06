<?php
/**
 * Render callback for static variation of 'one-novanta/featured-banner' block.
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content    The block content.
 * @var WP_Block     $block      The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Return if required parameters are not available.
if ( empty( $attributes ) || ! is_array( $attributes ) ) {
	return;
}

$image_id        = $attributes['imageID'];
$heading         = $attributes['heading'] ?? '';
$pre_heading     = $attributes['preHeading'] ?? '';
$description     = $attributes['description'] ?? '';
$vertical_align  = $attributes['verticalAlign'] ?? 'middle';
$content_width   = $attributes['contentWidth'] ?? 'wide';
$height          = $attributes['height'] ?? 'small';
$has_description = $attributes['hasDescription'] ?? true;
$has_buttons     = $attributes['hasButtons'] ?? true;
$overlay         = $attributes['overlay'] ?? 'dark';

// Render block.
Template::render_component(
	'hero',
	null,
	[
		'image_id' => $image_id,
		'layout'   => $content_width,
		'height'   => $height,
		'overlay'  => $overlay,
		'content'  => Template::get_component(
			'hero',
			'content',
			[
				'pre_heading'    => $pre_heading,
				'heading'        => $heading,
				'vertical_align' => $vertical_align,
				'content'        => sprintf(
					'<p>%1$s</p>%2$s',
					$has_description ? $description : '',
					$has_buttons ? $content : '',
				),
			],
		),
	]
);
