<?php
/**
 * Admin Utils
 *
 * @package    admin-utils
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * [Description Handle Admin utils]
 */
class MO_OAuth_Client_Admin_Utils {

	/**
	 * Check Curl extension
	 */
	public static function curl_extension_check() {
		if ( ! in_array( 'curl', get_loaded_extensions(), true ) ) {
			echo '<p style="color:red;">(Warning: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled. Please install/enable it before you proceed.)</p>';
		}
	}
}
