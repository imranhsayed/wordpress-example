<?php
/**
 * Main class for WP Component Viewer
 *
 * @package WPComponentViewer
 */

namespace WPComponentViewer;

use WPComponentViewer\Admin\AccessControl;
use WPComponentViewer\Scanner\ComponentScanner;
use WPComponentViewer\UI\AdminPage;

/**
 * ComponentViewer class
 */
class ComponentViewer {
	/**
	 * Instance of ComponentViewer
	 *
	 * @var ComponentViewer
	 */
	private static $instance = null;

	/**
	 * Get instance of ComponentViewer
	 *
	 * @return ComponentViewer
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'register_custom_route' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_action( 'admin_init', array( $this, 'set_query_var_admin_page' ) );
	}

	/**
	 * Register custom route for components
	 *
	 * @return void
	 */
	public function register_custom_route() {
		add_rewrite_rule(
			'^components/([^/]+)/preview/([^/]+)/?$',
			'index.php?component_preview=1&component_name=$matches[1]&component_variation=$matches[2]',
			'top'
		);

		add_filter(
			'query_vars',
			function ( $query_vars ) {
				$query_vars[] = 'component_preview';
				$query_vars[] = 'component_name';
				$query_vars[] = 'component_variation';
				return $query_vars;
			}
		);

		add_filter( 'template_include', array( $this, 'component_template' ) );
	}

	/**
	 * Handle component template
	 *
	 * @param string $template Template path.
	 * @return string
	 */
	public function component_template( $template ) {
		if ( get_query_var( 'component_preview' ) ) {
			if ( ! AccessControl::user_has_access() ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wp-component-viewer' ) );
			}
			return plugin_dir_path( __DIR__ ) . 'templates/component-preview.php';
		}

		return $template;
	}

	/**
	 * Register admin page
	 *
	 * @return void
	 */
	public function register_admin_page() {
		add_menu_page(
			__( 'Component Viewer', 'wp-component-viewer' ),
			__( 'Components', 'wp-component-viewer' ),
			'manage_options',
			'wp-component-viewer',
			array( new AdminPage(), 'render' ),
			'dashicons-layout',
			30
		);
	}

	/**
	 * Set query variable for admin page
	 *
	 * @return void
	 */
	public function set_query_var_admin_page() {
		if ( isset( $_GET['component_name'] ) ) {
			$component_name = sanitize_text_field( wp_unslash( $_GET['component_name'] ) );
			set_query_var( 'component_name', $component_name );
		}
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public static function init() {
		$instance = self::get_instance();

		// Initialize component scanner.
		ComponentScanner::init();

		// Flush rewrite rules on activation.
		register_activation_hook( dirname( __DIR__ ) . '/wp-component-viewer.php', array( __CLASS__, 'activate' ) );
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public static function activate() {
		self::get_instance()->register_custom_route();
		flush_rewrite_rules();
	}
}
