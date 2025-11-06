<?php
/**
 * Server-side rendering of the `one-novanta/listing` block.
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

// If the block is not set or the content is not set or the attributes are not set, return.
if ( ! isset( $block ) || ! isset( $content ) || ! isset( $attributes ) ) {
	return;
}

// Render the template.
Template::render_component(
	'grid',
	null,
	[
		'column_count' => 2,
		'content'      => $content,
	]
);
