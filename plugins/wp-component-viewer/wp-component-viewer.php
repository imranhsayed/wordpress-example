<?php
/**
 * Plugin Name: WP Component Viewer
 * Description: A WordPress package for building and viewing components in one place
 * Version: 1.0.0
 * Author: rtCamp
 * License: GPL-2.0+
 * Text Domain: wp-component-viewer
 * Domain Path: /languages
 *
 * @package WPComponentViewer
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin constants.
define( 'WP_COMPONENT_VIEWER_VERSION', '1.0.0' );
define( 'WP_COMPONENT_VIEWER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_COMPONENT_VIEWER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once __DIR__ . '/src/Helpers/autoloader.php';

// Initialize the plugin.
WPComponentViewer\Plugin::get_instance()->init();
