<?php
/**
 * Aquila Theme.
 *
 * @package Aquila
 */

namespace Aquila\Theme;

// Define theme constants.
define( 'AQUILA_THEME_VERSION', '1.0.0' );
define( 'AQUILA_THEME_DIR', get_template_directory() );
define( 'AQUILA_THEME_URI', get_template_directory_uri() );
define( 'AQUILA_THEME_BUILD_DIR', get_template_directory() . '/build' );
define( 'AQUILA_THEME_BUILD_URI', get_template_directory_uri() . '/build' );

/**
 * Register autoloader for all classes under /inc/.
 */
spl_autoload_register( function( $class ) {
	$namespaces = [
		'Aquila\\Theme\\'  => __DIR__ . '/inc/',
		'Aquila\\Traits\\' => __DIR__ . '/inc/traits/',
	];

	foreach ( $namespaces as $prefix => $base_dir ) {
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			continue;
		}

		$relative_class = substr( $class, $len );
		$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
});

// Load helper functions.
require_once __DIR__ . '/inc/helpers/custom-functions.php';

// Load theme classes.
AquilaTheme::get_instance();
