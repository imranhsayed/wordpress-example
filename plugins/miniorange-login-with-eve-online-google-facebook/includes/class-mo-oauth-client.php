<?php
/**
 * OAuth Client plugin
 *
 * @package    plugin-loader
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * [Description MO_OAuth_Client]
 */
class MO_OAuth_Client {

	/**
	 * Loader to load hooks
	 *
	 * @var loader load actions/filters.
	 */
	protected $loader;

	/**
	 * Plugin name
	 *
	 * @var plugin_name name of the plugin installed.
	 */
	protected $plugin_name;

	/**
	 * Version
	 *
	 * @var plugin_name version of the plugin installed.
	 */
	protected $version;

	/**
	 * Initialize plugin settings.
	 */
	public function __construct() {
		$this->plugin_name = 'miniOrange ' . MO_OAUTH_PLUGIN_NAME;
		$this->version     = '1.0.1';
		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	/**
	 * Load dependencies.
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes' . DIRECTORY_SEPARATOR . 'class-mo-oauth-client-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin' . DIRECTORY_SEPARATOR . 'class-mo-oauth-client-admin.php';
		$this->loader = new MO_OAuth_Client_Loader();
	}
	/**
	 * Define admin hooks.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new MO_OAuth_Client_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
		$this->loader->add_action( 'admin_enqueue_scripts', '', 'mooauth_client_plugin_settings_style' );
		$this->loader->add_action( 'admin_enqueue_scripts', '', 'mooauth_client_plugin_settings_script' );
	}

	/**
	 * Run loader
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Initialize plugin name
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Initialize loader
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Initialize version
	 */
	public function get_version() {
		return $this->version;
	}

}
