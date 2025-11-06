<?php
/**
 * Server-side rendering of the `one-novanta/listing-item` block.
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

// If the block is not set or the content is not set or the attributes are not set, return.
if ( ! isset( $block ) || ! isset( $content ) || ! isset( $attributes ) ) {
	return;
}

Template::render_component(
	'grid',
	'item',
	[
		'content' => Template::get_component(
			'cards',
			'listing',
			[
				'content'  => $content,
				'image_id' => $attributes['imageID'] ?? 0,
			]
		),
	],
);
