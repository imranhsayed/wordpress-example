<?php
/**
 * Notice
 *
 * @package    Notice
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Notice
 */
class MO_OAuth_Admin_Notice {
	/**
	 * Notice key
	 *
	 * @var [string]
	 */
	private $notice_key = 'mo_oauth_admin_notice_dismissed';

	/**
	 * Initializing required hooks
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'dismiss_admin_notice' ) );
		add_action( 'wp_ajax_mo_dismiss_admin_notice', array( $this, 'ajax_dismiss_admin_notice' ) );
	}

	/**
	 * Checks if the current admin page is the plugin settings page.
	 *
	 * This function checks if the 'page' query parameter is set and if its value contains the string 'mo_oauth_settings'.
	 * If both conditions are met, the function returns true, indicating that the current admin page is the plugin settings page.
	 * Otherwise, it returns false.
	 *
	 * @return bool True if the current admin page is the plugin settings page, false otherwise.
	 */
	private function is_plugin_page() {
		if ( ! isset( $_GET['page'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			return false;
		}
		return strpos( sanitize_text_field( wp_unslash( $_GET['page'] ) ), 'mo_oauth_settings' ) !== false; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
	}


	/**
	 * Retrieves the name of the plugin.
	 *
	 * This function retrieves the name of the plugin from the 'mo_oauth_apps_list' option.
	 * The name is stored in the 'name' key of the array.
	 *
	 * @return string The name of the plugin.
	 */
	private function get_app_name() {
		$appslist = get_option( 'mo_oauth_apps_list' );
		if ( ! empty( $appslist ) ) {
			$app_name = array_key_first( $appslist );
			return $app_name;
		}
		return '';

	}

	/**
	 * Checks if the admin notice for SSO configuration is dismissed.
	 *
	 * This function retrieves the value of the 'mo_oauth_admin_notice_dismissed' option and checks if it is set to 'true'.
	 * If the option is set to 'true', it means the admin notice has been dismissed, and the function returns true.
	 * Otherwise, it returns false.
	 *
	 * @return bool True if the admin notice is dismissed, false otherwise.
	 */
	private function is_notice_dismissed() {
		return get_option( $this->notice_key ) === 'true';
	}


	/**
	 * Handles the AJAX request to dismiss the admin notice.
	 *
	 * This function is called when the admin user clicks the "Dismiss" button on the admin notice.
	 * It verifies the AJAX request using the 'mo_dismiss_notice' nonce and then updates the 'mo_oauth_admin_notice_dismissed' option to 'true'.
	 * Finally, it terminates the script execution using wp_die().
	 *
	 * @return void
	 */
	public function ajax_dismiss_admin_notice() {
		check_ajax_referer( 'mo_dismiss_notice', 'security' );
		update_option( $this->notice_key, 'true' );
		wp_die();
	}


	/**
	 * Handles the dismissal of the admin notice.
	 *
	 * This function checks if the 'mo_dismiss_notice' and '_wpnonce' parameters are set in the $_GET superglobal.
	 * If both parameters are present, it verifies the nonce using the 'mo_dismiss_notice' action.
	 * If the nonce is verified, it updates the 'mo_oauth_admin_notice_dismissed' option to 'true'.
	 *
	 * @return void
	 */
	public function dismiss_admin_notice() {
		if ( isset( $_GET['mo_dismiss_notice'] ) && isset( $_GET['_wpnonce'] ) ) {
			if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'mo_dismiss_notice' ) ) {
				update_option( $this->notice_key, 'true' );
			}
		}
	}

	/**
	 * Displays an admin notice on the WordPress dashboard when SSO for the admin user is not enabled.
	 * The notice provides a link to enable SSO and another link to map the email attribute.
	 * The notice can be dismissed by clicking the "Dismiss" button.
	 *
	 * @return void
	 */
	public function show_notice_message() {
		$app_name = $this->get_app_name();
		$app_url  = get_site_url() . DIRECTORY_SEPARATOR . 'wp-admin' . DIRECTORY_SEPARATOR . 'admin.php?page=mo_oauth_settings&tab=config';
		if ( isset( $app_name ) && ! empty( $app_name ) ) {
			$app_url = 'admin.php?page=mo_oauth_settings&tab=config&action=update&app=' . esc_attr( $app_name );
		}
		if ( ! $this->is_plugin_page() || $this->is_notice_dismissed() ) {
			return;
		}
		$currenttab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		if ( 'licensing' !== $currenttab ) {
			?>
				<form name="f" method="post" action="" id="mo_oauth_client_admin_notice_form">
				<?php wp_nonce_field( 'mo_oauth_client_admin_notice_form', 'mo_oauth_client_admin_notice_form_field' ); ?>
				<input type="hidden" name="option" value="mo_oauth_client_rest_api_message" />
				<div class="notice notice-info mo-oauth-notice">
					<h4>
					<i class="fa fa-info-circle"></i>
					<span>
						<strong>SSO Configuration: </strong>
						<?php esc_html_e( 'SSO for the admin user is disabled by default. You can enable it here.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						<a href="<?php echo esc_attr( $app_url ); ?>">
						<?php esc_html_e( 'Enable SSO for Admin', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</a>
					</span>
					</h4>
					<h4>
					<i class="fa fa-cogs"></i>
					<span>
						<strong>Attribute Mapping: </strong>
						<?php esc_html_e( 'You can now map the email attribute with user profile. Click here to ', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						<a href="admin.php?page=mo_oauth_settings&tab=attributemapping">
						<?php esc_html_e( 'Map Attribute.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</a>
					</span>
					</h4>
					<button type="button" class="notice-dismiss" id="mo_oauth_client_disable_admin_notice">
					<span class="screen-reader-text">Dismiss this notice.</span>
					</button>
				</div>
				</form>
			<script>
			jQuery("#mo_oauth_client_disable_admin_notice").click(function() {
				jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'mo_dismiss_admin_notice',
						security: '<?php echo esc_attr( wp_create_nonce( 'mo_dismiss_notice' ) ); ?>'
					},
					success: function(response) {
						jQuery('#mo_oauth_client_admin_notice_form').fadeOut();
					}
				});
			});
			</script>
			<?php
		}
	}
}
new MO_OAuth_Admin_Notice();
