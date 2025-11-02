<?php
/**
 * App Handler
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Adding required files
 */
require 'partials' . DIRECTORY_SEPARATOR . 'sign-in-settings.php';
require 'partials' . DIRECTORY_SEPARATOR . 'customization.php';
require 'partials' . DIRECTORY_SEPARATOR . 'updateapp.php';
require 'partials' . DIRECTORY_SEPARATOR . 'app-list.php';
require 'partials' . DIRECTORY_SEPARATOR . 'attr-role-mapping.php';
require 'partials' . DIRECTORY_SEPARATOR . 'user-analytics.php';

/**
 * Manage App UI
 */
class MO_OAuth_Client_Apps {

	/**
	 * Display Sign In Settings
	 */
	public static function sign_in_settings() {
		mooauth_client_sign_in_settings_ui();
	}

	/**
	 * Display Customization tab
	 */
	public static function customization() {
		mooauth_client_customization_ui();
	}

	/**
	 * Display list of apps configured
	 */
	public static function applist() {
		mooauth_client_applist_page();
	}

	/**
	 * Display the configuration panel for the app
	 *
	 * @param mixed $appname current app for which the settings would be displayed.
	 */
	public static function update_app( $appname ) {
		mooauth_client_update_app_page( $appname );
	}

	/**
	 * Display the Attribute Mapping settings for the configured application
	 */
	public static function attribute_role_mapping() {
		mooauth_client_attribite_role_mapping_ui();
	}
	/**
	 * Display the Attribute Mapping settings for the configured application
	 */
	public static function user_analytics() {
		mooauth_client_user_analytics_ui();
	}
}
