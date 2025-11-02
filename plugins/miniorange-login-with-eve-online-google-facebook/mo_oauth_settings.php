<?php //phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase -- Not changing file name because this is the main plugin file, and changing this would lead to deacivation of plugin for the active users.
/**
 * MiniOrange OAuth Client
 *
 * @package    miniOrange-oauth-client
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Plugin Name: OAuth Single Sign On - SSO (OAuth Client)
 * Plugin URI: https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook
 * Description: This WordPress Single Sign-On plugin allows login into WordPress with your Azure AD B2C, AWS Cognito, Salesforce, Keycloak, Discord, WordPress or other custom OAuth 2.0 / OpenID Connect providers. WordPress OAuth Client plugin works with any Identity provider that conforms to the OAuth 2.0 and OpenID Connect (OIDC) 1.0 standard.
 * Version: 6.26.14
 * Author: miniOrange
 * Author URI: https://www.miniorange.com
 * License: Expat
 * License URI: https://plugins.miniorange.com/mit-license
 * Text Domain: miniorange-login-with-eve-online-google-facebook
 * Domain Path: /languages
 */

/**
 * Adding required files.
 */
require 'handler' . DIRECTORY_SEPARATOR . 'class-mo-oauth-handler.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class-mooauth-widget.php';
require 'class-mo-oauth-client-customer.php';
require plugin_dir_path( __FILE__ ) . 'includes' . DIRECTORY_SEPARATOR . 'class-mo-oauth-client.php';
require 'views' . DIRECTORY_SEPARATOR . 'feedback-form.php';
require 'admin' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'setup_wizard' . DIRECTORY_SEPARATOR . 'handler' . DIRECTORY_SEPARATOR . 'class-mo-oauth-wizard-ajax.php';
require 'admin' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'notice' . DIRECTORY_SEPARATOR . 'class-mo-oauth-admin-notice.php';
require 'admin' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'setup_wizard' . DIRECTORY_SEPARATOR . 'class-mo-oauth-client-setup-wizard.php';
require 'constants.php';
require 'admin' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'mo_plugins' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once 'class-mooauth.php';
define( 'MO_OAUTH_CSS_JS_VERSION', '6.26.14' );
define( 'MO_OAUTH_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

use MO_Plugins\MO_REST_API_Advertisement;

if ( class_exists( 'MO_Plugins\MO_REST_API_Advertisement' ) ) {
	MO_REST_API_Advertisement::get_instance();
}

new MOOAuth();
/**
 * Run the plugin.
 */
function mooauth_client_run() {
	$plugin = new MO_OAuth_Client();
	$plugin->run();}
mooauth_client_run();

/**
 * Check if customer is registered.
 */
function mooauth_is_customer_registered() {
	$email        = get_option( 'mo_oauth_admin_email' );
	$customer_key = get_option( 'mo_oauth_client_admin_customer_key' );
	if ( ! $email || ! $customer_key || ! is_numeric( trim( $customer_key ) ) ) {
		return 0;
	} else {
		return 1;
	}
}

/**
 * Check if cURL is installed.
 */
function mooauth_is_curl_installed() {
	if ( in_array( 'curl', get_loaded_extensions(), true ) ) {
		return 1;
	} else {
		return 0;
	}
}
