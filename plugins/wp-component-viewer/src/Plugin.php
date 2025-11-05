<?php
/**
 * Plugin initialization
 *
 * @package WPComponentViewer
 */

namespace WPComponentViewer;

use WPComponentViewer\Scanner\ComponentScanner;
use WPComponentViewer\UI\AssetsHandler;
use WPComponentViewer\UI\AjaxHandler;

/**
 * Plugin class
 */
class Plugin {
	/**
	 * Plugin instance
	 *
	 * @var Plugin
	 */
	private static $instance;

	/**
	 * Get the plugin instance
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize plugin
	 *
	 * @return void
	 */
	public function init() {
		// Register activation and deactivation hooks.
		register_activation_hook( WP_COMPONENT_VIEWER_PLUGIN_DIR . 'wp-component-viewer.php', array( $this, 'activate' ) );
		register_deactivation_hook( WP_COMPONENT_VIEWER_PLUGIN_DIR . 'wp-component-viewer.php', array( $this, 'deactivate' ) );

		// Initialize components.
		ComponentViewer::get_instance();
		ComponentScanner::init();
		AssetsHandler::init();
		AjaxHandler::init();

		// Register uninstall hook.
		register_uninstall_hook( WP_COMPONENT_VIEWER_PLUGIN_DIR . 'wp-component-viewer.php', array( __CLASS__, 'uninstall' ) );

		// Add settings link to plugins page.
		add_filter( 'plugin_action_links_wp-component-viewer/wp-component-viewer.php', array( $this, 'add_settings_link' ) );
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		// Create custom rewrite rules.
		ComponentViewer::get_instance()->register_custom_route();

		// Clear components cache.
		ComponentScanner::clear_cache();

		// Flush rewrite rules.
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation
	 *
	 * @return void
	 */
	public function deactivate() {
		// Clear components cache.
		ComponentScanner::clear_cache();

		// Flush rewrite rules.
		flush_rewrite_rules();
	}

	/**
	 * Plugin uninstall
	 *
	 * @return void
	 */
	public static function uninstall() {
		// Delete any stored options or transients.
		delete_transient( 'wp_component_viewer_components' );
	}

	/**
	 * Add settings link to plugin page
	 *
	 * @param array $links Plugin action links.
	 * @return array
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'admin.php?page=wp-component-viewer' ) . '">' . __( 'View Components', 'wp-component-viewer' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}
