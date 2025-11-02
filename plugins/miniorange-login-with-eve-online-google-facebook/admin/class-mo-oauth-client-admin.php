<?php
/**
 * Admin Menu
 *
 * @package    admin-menu
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Add required files.
 */
require 'partials' . DIRECTORY_SEPARATOR . 'class-mo-oauth-client-admin-menu.php';

/**
 * [Description Handle admin menu]
 */
class MO_OAuth_Client_Admin {

	/**
	 * Name of the plugin installed.
	 *
	 * @var plugin_name name of the plugin.
	 */
	private $plugin_name;
	/**
	 * Version of the plugin installed
	 *
	 * @var version version of the plugin installed.
	 */
	private $version;

	/**
	 * Initilaize plugin name and version for the class object
	 *
	 * @param mixed $plugin_name name of the plugin installed.
	 * @param mixed $version plugin version.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_filter( 'plugin_action_links_' . MO_OAUTH_PLUGIN_BASENAME, array( $this, 'add_action_links' ) );
	}

	// Function to add the Premium settings in Plugin's section.

	/**
	 * Handle URL actions.
	 *
	 * @param mixed $actions handle actions.
	 * @return [array]
	 */
	public function add_action_links( $actions ) {

		$url            = esc_url(
			add_query_arg(
				'page',
				'mo_oauth_settings',
				get_admin_url() . 'admin.php'
			)
		);
		$url           .= '&tab=config';
		$url2           = MO_OAUTH_CLIENT_PRICING_PLAN;
		$settings_link  = "<a href='$url'>Configure</a>";
		$settings_link2 = "<a href='$url2' target='_blank'>Premium Plans</a>";
		array_push( $actions, $settings_link2 );
		array_push( $actions, $settings_link );
		return array_reverse( $actions );
	}

	/**
	 * Add Plugin menu in WordPress nav bar.
	 */
	public function admin_menu() {
		$slug = 'mo_oauth_settings';
		add_menu_page(
			'MO OAuth Settings  ' . esc_html__( 'Configure OAuth', 'mo_oauth_settings' ),
			MO_OAUTH_ADMIN_MENU,
			'administrator',
			$slug,
			array( $this, 'menu_options' ),
			plugin_dir_url( __FILE__ ) . 'images/miniorange.png'
		);
		add_submenu_page(
			$slug,
			MO_OAUTH_ADMIN_MENU,
			'Plugin Configuration',
			'administrator',
			'mo_oauth_settings'
		);
		add_submenu_page(
			'mo_oauth_settings',
			'Trials',
			'<div style="color:#fff;display: flex;font-size: 13px;font-weight:500"> ' . __( 'Free Trial', 'miniorange-login-with-eve-online-google-facebook' ) . '</div>',
			'administrator',
			'?page=mo_oauth_settings&tab=requestfordemo'
		);
		add_submenu_page(
			$slug,
			'Add-ons',
			'Add-ons',
			'administrator',
			'?page=mo_oauth_settings&tab=addons'
		);
	}

	/**
	 * Set host name and display the main plugin page.
	 */
	public function menu_options() {
		global $wpdb;
		update_option( 'host_name', 'https://login.xecurify.com' );
		mooauth_client_main_menu();
	}
}
