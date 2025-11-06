<?php
/**
 * One Novanta Theme.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme;

// Define theme constants.
define( 'ONE_NOVANTA_THEME_VERSION', '1.0.0' );
define( 'ONE_NOVANTA_THEME_DIR', get_template_directory() );
define( 'ONE_NOVANTA_THEME_URI', get_template_directory_uri() );
define( 'ONE_NOVANTA_THEME_BUILD_DIR', get_template_directory() . '/build' );
define( 'ONE_NOVANTA_THEME_BUILD_URI', get_template_directory_uri() . '/build' );

require_once untrailingslashit( ONE_NOVANTA_THEME_DIR ) . '/inc/helpers/custom-functions.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

// Load theme classes.
one_novanta_theme_bootstrap();

// Load autoloader if it exists.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $autoloader ) ) {
	require_once $autoloader;
}

// Load theme classes.
OneNovantaTheme::get_instance();
