<?php
/**
 * SVG Component.
 *
 * @package OneNovantaTheme\Components
 *
 * @component SVG
 * @description A reusable SVG component
 * @group UI Elements
 * @props {
 *   "name": {"type": "string", "required": true, "description": "SVG file name"}
 * }
 *
 * @example render_component( 'svg', [
 *   'name' => 'arrow-right',
 * ] );
 */

// Return if required parameters are missing.
if ( empty( $args ) || empty( $args['name'] ) || ! defined( 'ONE_NOVANTA_THEME_DIR' ) ) {
	return;
}

// Destruct arguments.
$svg_name = $args['name'];

// Generate file path.
$file = sprintf(
	'%1$s/src/svg/%2$s.svg',
	untrailingslashit( ONE_NOVANTA_THEME_DIR ),
	$svg_name,
);

// Include the file if it exists.
if ( file_exists( $file ) ) {
	require $file;
}
