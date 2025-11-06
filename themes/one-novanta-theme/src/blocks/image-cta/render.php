<?php
/**
 * Media Text Column Block Render.
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

// If the block is not set or the content is not set or the attributes are not set, return.
if ( ! isset( $block ) || ! isset( $content ) || ! isset( $attributes ) ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'alignwide' ] );

Template::render_component(
	'media-text',
	null,
	[
		'image_id'           => $attributes['imageID'] ?? 0,
		'media_align'        => $attributes['mediaAlign'] ?? 'left',
		'content'            => $content,
		'background_color'   => $attributes['backgroundColor'],
		'wrapper_attributes' => $wrapper_attributes,
	],
);
