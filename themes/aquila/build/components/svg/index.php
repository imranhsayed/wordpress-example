<?php
/**
 * SVG Component.
 *
 * @package AquilaTheme\Components
 *
 * @component SVG
 * @description A reusable SVG component
 * @group UI Elements
 * @props {
 *   "name": {"type": "string", "required": true, "description": "SVG file name"}
 * }
 *
 * @example render_component( 'svg', [
 *   'name' => 'arrow-right-thin',
 * ] );
 */

// Return if required parameters are missing.
if ( empty( $args ) || empty( $args['name'] ) || ! defined( 'AQUILA_THEME_DIR' ) ) {
	return;
}

// Destruct arguments.
$svg_name = $args['name'];

// Generate file path.
$file = sprintf(
	'%1$s/src/svg/%2$s.svg',
	untrailingslashit( AQUILA_THEME_DIR ),
	$svg_name,
);

// Include the file if it exists.
if ( file_exists( $file ) ) {
	require $file;
}
