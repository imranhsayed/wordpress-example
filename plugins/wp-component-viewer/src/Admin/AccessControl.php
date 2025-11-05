<?php
/**
 * Admin access control
 *
 * @package WPComponentViewer\Admin
 */

namespace WPComponentViewer\Admin;

/**
 * AccessControl class
 */
class AccessControl {
	/**
	 * Check if user has access to component viewer
	 *
	 * @return bool
	 */
	public static function user_has_access() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Verify nonce for AJAX requests
	 *
	 * @param string $nonce Nonce value.
	 * @return bool
	 */
	public static function verify_nonce( $nonce ) {
		return wp_verify_nonce( $nonce, 'wp_component_viewer_nonce' );
	}
}
