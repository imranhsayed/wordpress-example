<?php
/**
 * Account
 *
 * @package    account
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Adding required files
 */
require 'partials' . DIRECTORY_SEPARATOR . 'register.php';
require 'partials' . DIRECTORY_SEPARATOR . 'verify-password.php';

/**
 * Create new user/Login existing user using miniOrange credentials.
 */
class MO_OAuth_Client_Admin_Account {

	/**
	 * Show UI to register users / display logged in user information
	 */
	public static function register() {
		if ( ! mooauth_is_customer_registered() ) {
			mooauth_client_register_ui();
		} else {
			mooauth_client_show_customer_info();
		}
	}

	/**
	 * Verify miniOrange credentials of the user
	 */
	public static function verify_password() {
		mooauth_client_verify_password_ui();
	}

}


