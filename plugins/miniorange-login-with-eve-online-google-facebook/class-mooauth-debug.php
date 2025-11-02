<?php
/**
 * Debug
 *
 * @package    debug
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Handle SSO debug logs
 */
class MOOAuth_Debug {

	/**
	 * Delete the debug log file if it is older than 7 days, using WordPress options for time tracking.
	 */
	public static function auto_delete_old_log() {
		$mo_log_enable  = ( null !== get_option( 'mo_debug_enable' ) ) ? get_option( 'mo_debug_enable' ) : '';
		$mo_oauth_debug = ( null !== get_option( 'mo_oauth_debug' ) ) ? get_option( 'mo_oauth_debug' ) : '';

		$log_file_path = self::get_log_file_path();

		if ( 'on' === $mo_log_enable ) {
			$key            = 604800; // 7 days in seconds (7 * 24 * 60 * 60)
			$mo_debug_times = ( null !== get_option( 'mo_debug_time' ) ) ? get_option( 'mo_debug_time' ) : '';
			$mo_curr_time   = time();

			if ( ! $mo_debug_times ) {
				update_option( 'mo_debug_time', $mo_curr_time );
				return;
			}

			$mo_oauth_var = (int) ( ( $mo_curr_time - $mo_debug_times ) / ( $key ) );
			if ( $mo_oauth_var >= 1 ) {
				update_option( 'mo_debug_enable', 0 );
				if ( file_exists( $log_file_path ) ) {
					wp_delete_file( $log_file_path );
				}
			}
		}
	}
	/**
	 * Get the log file path
	 *
	 * @return string
	 */
	public static function get_log_file_path() {

		return MO_OAUTH_LOG_DIR . DIRECTORY_SEPARATOR . get_option( 'mo_oauth_debug' ) . '.log';
	}

	/**
	 * Handle Debug log.
	 *
	 * @param mixed $mo_message message to be logged.
	 */
	public static function mo_oauth_log( $mo_message ) {
		// Only log if debug is enabled and a log file exists.
		if ( get_option( 'mo_debug_enable' ) !== 'on' ) {
			return;
		}
		$mo_pluginlog = self::get_log_file_path();
		if ( ! file_exists( $mo_pluginlog ) ) {
			return;
		}
		$mo_time = time();
		$mo_log  = '[' . gmdate( 'Y-m-d H:i:s', $mo_time ) . ' UTC] : ' . print_r( $mo_message, true ) . PHP_EOL; //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r, WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Used for debugging purposes

			// Only write the message if it's not empty or if it's not the initial check.
		if ( ! get_option( 'mo_debug_check' ) && ! empty( $mo_message ) ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( $mo_log . PHP_EOL, 3, $mo_pluginlog );
		}

	}
}
