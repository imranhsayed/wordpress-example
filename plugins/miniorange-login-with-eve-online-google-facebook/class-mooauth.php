<?php
/**
 * OAuth
 *
 * @package    oauth
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Main class for handling and processing the Front end data.
 */
class MOOAuth {

	/**
	 * Initializing required hooks
	 */
	public function __construct() {

		add_action( 'mo_oauth_auto_delete_debug_logs', array( $this, 'handle_debug_log_cleanup' ) );
		add_action( 'admin_init', array( $this, 'miniorange_oauth_save_settings' ), 11 );
		add_action( 'plugins_loaded', array( $this, 'mo_load_plugin_textdomain' ) );
		register_deactivation_hook( MO_OAUTH_PLUGIN_BASENAME, array( $this, 'mo_oauth_deactivate' ) );
		register_activation_hook( MO_OAUTH_PLUGIN_BASENAME, array( $this, 'mo_oauth_set_cron_job' ) );
		add_shortcode( 'mo_oauth_login', array( $this, 'mo_oauth_shortcode_login' ) );
		add_action( 'admin_footer', array( $this, 'mo_oauth_client_feedback_request' ) );
		add_action( 'check_if_wp_rest_apis_are_open', array( $this, 'mo_oauth_scheduled_task' ) );
		add_action( 'admin_init', array( $this, 'mo_oauth_debug_log_ajax_hook' ) );
		add_action( 'admin_init', array( $this, 'mo_oauth_client_support_script_hook' ) );
	}

	/**
	 * Handle Client support script hooks
	 */
	public function mo_oauth_client_support_script_hook() {
		if ( isset( $_REQUEST['page'] ) && 'mo_oauth_settings' === $_REQUEST['page'] ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			wp_enqueue_script( 'mo_oauth_client_support_script', plugin_dir_url( __FILE__ ) . '/admin/js/clientSupport.min.js', array(), $ver = '10.0.0', $in_footer = false );
			wp_enqueue_style( 'mo_oauth_initial_plugin_style', plugin_dir_url( __FILE__ ) . '/admin/css/mo-oauth-initial.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
		}
	}

	/**
	 * Debug log ajax hook
	 */
	public function mo_oauth_debug_log_ajax_hook() {
		add_action( 'wp_ajax_mo_oauth_debug_ajax', array( $this, 'mo_oauth_debug_log_ajax' ) );
		$mo_log_enable = get_option( 'mo_debug_enable' );
		if ( isset( $mo_log_enable ) && 'on' === $mo_log_enable && get_option( 'mo_debug_time' ) === false ) {
			$cron_exists = wp_next_scheduled( 'mo_oauth_auto_delete_debug_logs' );
			if ( ! $cron_exists ) {
				wp_schedule_single_event( time() + 604800, 'mo_oauth_auto_delete_debug_logs' );
			}
			update_option( 'mo_debug_time', time() );
		}
	}

	/**
	 * Handle debug log cleanup
	 */
	public function handle_debug_log_cleanup() {
		if ( class_exists( 'MOOAuth_Debug' ) ) {

			MOOAuth_Debug::auto_delete_old_log();
		}
	}

	/**
	 * Turn on/off debug logs.
	 */
	public function mo_oauth_debug_log_ajax() {
		if ( ! isset( $_POST['mo_oauth_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_oauth_nonce'] ) ), 'mo-oauth-Debug-logs-unique-string-nonce' ) ) {
			wp_send_json( 'error' );
		} else {
			$option = ! empty( $_POST['mo_oauth_option'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_option'] ) ) : '';
			switch ( $option ) {
				case 'mo_oauth_reset_debug':
					$this->mo_oauth_reset_debug();
					break;
			}
		}
	}

	// wp_once_field configuration by ajax call submition.

	/**
	 * Reset debug logs.
	 */
	public function mo_oauth_reset_debug() {
		if (
		isset( $_POST['mo_oauth_option'] ) &&
		sanitize_text_field( wp_unslash( $_POST['mo_oauth_option'] ) ) === 'mo_oauth_reset_debug' &&
		isset( $_REQUEST['mo_oauth_nonce'] ) &&
		wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_nonce'] ) ), 'mo-oauth-Debug-logs-unique-string-nonce' )
		) {
			$debug_enable = false;
			if ( isset( $_POST['mo_oauth_mo_oauth_debug_check'] ) ) {
				$debug_enable = sanitize_text_field( wp_unslash( $_POST['mo_oauth_mo_oauth_debug_check'] ) );
			}
			update_option( 'mo_debug_enable', $debug_enable );

			$upload_dir   = wp_upload_dir();
			$log_filename = get_option( 'mo_oauth_debug' );

			if ( 'on' === $debug_enable ) {
				update_option( 'mo_debug_check', 1 );

				if ( ! $log_filename ) {
					// Create a new debug filename if none exists.
					update_option( 'mo_oauth_debug', 'mo_oauth_debug' . uniqid() );
					$log_filename = get_option( 'mo_oauth_debug' );
				}
				$mo_file_path = MOOAuth_Debug::get_log_file_path();

				// Create the file if it doesn't exist.
				if ( ! file_exists( $mo_file_path ) ) {
					if ( ! function_exists( 'request_filesystem_credentials' ) ) {
						require_once ABSPATH . 'wp-admin/includes/file.php';
					}
					$credentials = request_filesystem_credentials( site_url() );
					if ( WP_Filesystem( $credentials ) ) {
						global $wp_filesystem;
						$log_content = 'This is the miniOrange OAuth plugin Debug Log file';
						$wp_filesystem->put_contents( $mo_file_path, $log_content, FS_CHMOD_FILE );
						$wp_filesystem->chmod( $mo_file_path, 0644 );
					}
				}
				if ( ! wp_next_scheduled( 'mo_oauth_auto_delete_debug_logs' ) ) {
					wp_schedule_single_event( time() + 604800, 'mo_oauth_auto_delete_debug_logs' );
				}
				$mo_curr_time = time();
				update_option( 'mo_debug_time', $mo_curr_time );

				update_option( 'mo_debug_check', 0 );
			}

			if ( 'off' === $debug_enable ) {
				if ( wp_next_scheduled( 'mo_oauth_auto_delete_debug_logs' ) ) {
					wp_clear_scheduled_hook( 'mo_oauth_auto_delete_debug_logs' );
				}

				if ( $log_filename ) {
					$mo_file_path = MOOAuth_Debug::get_log_file_path();
					delete_option( 'mo_oauth_debug' );
					if ( file_exists( $mo_file_path ) ) {
						wp_delete_file( $mo_file_path );
					}
					delete_option( 'mo_debug_time' );

				}
			}
			$response['switch_status'] = get_option( 'mo_debug_enable' );
			wp_send_json( $response );
		} else {
			echo 'error';
		}
	}




	/**
	 * Load text domain.
	 */
	public function mo_load_plugin_textdomain() {
		load_plugin_textdomain(
			'miniorange-login-with-eve-online-google-facebook',
			false,
			basename( __DIR__ ) . DIRECTORY_SEPARATOR . 'languages'
		);
	}

	/**
	 * Display success message.
	 */
	public function mo_oauth_success_message() {
		$class   = 'error';
		$message = get_option( 'message' );
		echo "<div style='display:flex; margin:15px 19px 0px 0px; border-radius:5px;' class='" . esc_attr( $class ) . "'><div><img style='margin-bottom:-12px' src='" . esc_url( plugin_dir_url( __FILE__ ) ) . "/images/mo_oauth_error.png' ></div><div><p> &nbsp;&nbsp;" . esc_attr( $message ) . '</p></div></div>';
	}

	/**
	 * Handle feedback request.
	 */
	public function mo_oauth_client_feedback_request() {
		mooauth_client_display_feedback_form();
	}

	/**
	 * Dispaly error message.
	 */
	public function mo_oauth_error_message() {
		$class   = 'updated';
		$message = get_option( 'message' );
		echo "<div style='display:flex; margin:15px 19px 0px 0px; border-radius:5px;' class='" . esc_attr( $class ) . "'><div><img style='margin-bottom:-12px' src='" . esc_url( plugin_dir_url( __FILE__ ) ) . "/images/mo_oauth_success.png' ></div><div><p> &nbsp;&nbsp;" . esc_attr( $message ) . '</p></div></div>';
	}

	/*
		*   Custom Intervals
		*   Name             dispname                Interval
		*   three_minutes    Every Three minutes     3  * MINUTE_IN_SECONDS (3 * 60)
		*   five_minutes     Every Five minutes      5  * MINUTE_IN_SECONDS (5 * 60)
		*   ten_minutes      Every Ten minutes       10 * MINUTE_IN_SECONDS (10 * 60)
		*   three_days       Every Three days        3  * 24 * 60 * MINUTE_IN_SECONDS
		*   five_days        Every Five days         5  * 24 * 60 * MINUTE_IN_SECONDS
		*
		*
		*   Default Intervals
		*   Name         dispname        Interval (in sec)
		*   hourly       Once Hourly     3600 (1 hour)
		*   twicedaily   Twice Daily     43200 (12 hours)
		*   daily        Once Daily      86400 (1 day)
		*   weekly       Once Weekly     604800 (1 week)
	*/

	/**
	 * Set cron job
	 */
	public function mo_oauth_set_cron_job() {
		if ( ! wp_next_scheduled( 'check_if_wp_rest_apis_are_open' ) ) {
			wp_schedule_event( time() + 604800, 'weekly', 'check_if_wp_rest_apis_are_open' ); // update timestamp and name according to interval.
		}
		$mo_log_enable = get_option( 'mo_debug_enable' );
		if ( isset( $mo_log_enable ) && 'on' === $mo_log_enable && ! wp_next_scheduled( 'mo_oauth_auto_delete_debug_logs' ) ) {
			wp_schedule_single_event( time() + 604800, 'mo_oauth_auto_delete_debug_logs' );
		}
	}

	/**
	 * Delete options after plugin deactivation.
	 */
	public function mo_oauth_deactivate() {
		if ( class_exists( 'MOOAuth_Debug' ) ) {
			$log_file_path = MOOAuth_Debug::get_log_file_path();
			if ( file_exists( $log_file_path ) ) {
				wp_delete_file( $log_file_path );
			}
		}
		delete_option( 'host_name' );
		delete_option( 'mo_oauth_client_new_registration' );
		delete_option( 'mo_oauth_client_admin_phone' );
		delete_option( 'mo_oauth_client_verify_customer' );
		delete_option( 'mo_oauth_client_admin_customer_key' );
		delete_option( 'mo_oauth_client_admin_api_key' );
		delete_option( 'mo_oauth_client_new_customer' );
		delete_option( 'mo_oauth_client_customer_token' );
		delete_option( 'message' );
		delete_option( 'mo_oauth_client_registration_status' );
		delete_option( 'mo_oauth_client_show_mo_server_message' );
		delete_option( 'mo_oauth_log' );
		delete_option( 'mo_oauth_debug' );
		delete_option( 'mo_debug_time' );
		wp_clear_scheduled_hook( 'check_if_wp_rest_apis_are_open' );
		wp_clear_scheduled_hook( 'mo_oauth_auto_delete_debug_logs' );
	}


	/**
	 * Add cron schedules.
	 *
	 * @param mixed $schedules cron schedules.
	 */
	public function add_cron_interval( $schedules ) {

		if ( isset( $schedules['three_minutes'] ) ) {
			$schedules['three_minutes'] = array(
				'interval' => 3 * MINUTE_IN_SECONDS,
				'display'  => esc_html__( 'Every Three minutes', 'miniorange-login-with-eve-online-google-facebook' ),
			);
		} elseif ( isset( $schedules['five_minutes'] ) ) {
			$schedules['five_minutes'] = array(
				'interval' => 5 * MINUTE_IN_SECONDS,
				'display'  => esc_html__( 'Every Five minutes', 'miniorange-login-with-eve-online-google-facebook' ),
			);
		} elseif ( isset( $schedules['ten_minutes'] ) ) {
			$schedules['ten_minutes'] = array(
				'interval' => 10 * MINUTE_IN_SECONDS,
				'display'  => esc_html__( 'Every Ten minutes', 'miniorange-login-with-eve-online-google-facebook' ),
			);
		} elseif ( isset( $schedules['three_days'] ) ) {
			$schedules['three_days'] = array(
				'interval' => 3 * 24 * 60 * MINUTE_IN_SECONDS,
				'display'  => esc_html__( 'Every Three days', 'miniorange-login-with-eve-online-google-facebook' ),
			);
		} elseif ( isset( $schedules['five_days'] ) ) {
			$schedules['five_days'] = array(
				'interval' => 5 * 24 * 60 * MINUTE_IN_SECONDS,
				'display'  => esc_html__( 'Every Five days', 'miniorange-login-with-eve-online-google-facebook' ),
			);
		}

		return $schedules;
	}

	/**
	 * Check REST APIs.
	 */
	public function mo_oauth_scheduled_task() {
		$url      = site_url() . '/wp-json/wp/v2/posts';
		$response = wp_remote_get(
			$url,
			array(
				'method'      => 'GET',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => 1.0,
				'blocking'    => true,
				'headers'     => array(),
				'cookies'     => array(),
				'sslverify'   => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			if ( is_object( $response ) ) {
				error_log( print_r( sanitize_text_field( $response->errors ), true ) ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r, WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Used for debugging purposes
			}
			return;
		}
		$code = wp_remote_retrieve_response_code( $response );
		if ( isset( $code ) && 200 === $code ) {
			if ( isset( $response ) ) {
				update_option( 'mo_oauth_client_show_rest_api_message', true );
			}
		}
	}


	/**
	 * Handle widget text domain.
	 */
	public function mo_login_widget_text_domain() {
		load_plugin_textdomain( 'miniorange-login-with-eve-online-google-facebook', false, basename( __DIR__ ) . DIRECTORY_SEPARATOR . 'languages' );
	}

	/**
	 * Display success message.
	 */
	private function mo_oauth_show_success_message() {
		remove_action( 'admin_notices', array( $this, 'mo_oauth_success_message' ) );
		add_action( 'admin_notices', array( $this, 'mo_oauth_error_message' ) );
	}

	/**
	 * Display error message.
	 */
	private function mo_oauth_show_error_message() {
		remove_action( 'admin_notices', array( $this, 'mo_oauth_error_message' ) );
		add_action( 'admin_notices', array( $this, 'mo_oauth_success_message' ) );
	}

	/**
	 * Check if a variable is null.
	 *
	 * @param mixed $value variable to check if null.
	 */
	public function mo_oauth_check_empty_or_null( $value ) {
		if ( ! isset( $value ) || empty( $value ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Save settings in DB.
	 */
	public function miniorange_oauth_save_settings() {
		if ( isset( $_GET['option'] ) && 'mo_oauth_client_setup_wizard' === sanitize_text_field( wp_unslash( $_GET['option'] ) ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				$setup_wizard = new MO_OAuth_Client_Setup_Wizard();
				$setup_wizard->page();
				return;
			} else {
				wp_die( 'Sorry, you are not allowed to access this page.' );
			}
		}
		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_client_mo_server_message' && isset( $_REQUEST['mo_oauth_mo_server_message_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_mo_server_message_form_field'] ) ), 'mo_oauth_mo_server_message_form' ) ) {
			update_option( 'mo_oauth_client_show_mo_server_message', 1 );
			return;
		}
		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_client_rest_api_message' && isset( $_REQUEST['mo_oauth_client_rest_api_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_client_rest_api_form_field'] ) ), 'mo_oauth_client_rest_api_form' ) ) {

			delete_option( 'mo_oauth_client_show_rest_api_message' );
			wp_clear_scheduled_hook( 'check_if_wp_rest_apis_are_open' );
			return;
		}

		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'clear_pointers' && isset( $_REQUEST['mo_oauth_clear_pointers_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_clear_pointers_form_field'] ) ), 'mo_oauth_clear_pointers_form' ) ) {
			update_user_meta( get_current_user_id(), 'dismissed_wp_pointers', '' );
			return;
		}

		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'change_miniorange' && isset( $_REQUEST['mo_oauth_goto_login_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_goto_login_form_field'] ) ), 'mo_oauth_goto_login_form' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				$this->mo_oauth_deactivate();
				return;
			}
		}

		if (
		isset( $_POST['option'] ) &&
		sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_clear_debug' &&
		isset( $_REQUEST['mo_oauth_clear_debug_nonce'] ) &&
		wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_clear_debug_nonce'] ) ), 'mo_oauth_clear_debug' )
		) {
			// Get uploads directory and log folder path.
			$upload_dir = wp_upload_dir();

			$mo_filepath = MOOAuth_Debug::get_log_file_path();
			if ( ! is_file( $mo_filepath ) ) {
					echo '404 File not found!';
					exit();
			}
			// Load WP Filesystem API if not loaded.
			if ( ! function_exists( 'request_filesystem_credentials' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			$credentials = request_filesystem_credentials( site_url() );
			if ( ! WP_Filesystem( $credentials ) ) {
				return;
			}

			global $wp_filesystem;

			// Clear the file contents.
			$wp_filesystem->put_contents( $mo_filepath, '', FS_CHMOD_FILE );
			// Write a default message to the log file.
			$wp_filesystem->put_contents( $mo_filepath, 'This is the miniOrange OAuth plugin Debug Log file', FS_CHMOD_FILE );

			update_option( 'message', 'Debug Logs cleared successfully.' );
			$this->mo_oauth_show_success_message();
		}
		if (
		isset( $_POST['option'] ) &&
		sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_enable_debug_download' &&
		isset( $_REQUEST['mo_oauth_enable_debug_download_nonce'] ) &&
		wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_enable_debug_download_nonce'] ) ), 'mo_oauth_enable_debug_download' )
		) {
			// Prevent any extra output.
			while ( ob_get_level() ) {
				ob_end_clean();
			}

			$upload_dir   = wp_upload_dir();
			$log_filename = get_option( 'mo_oauth_debug' );
			$mo_filepath  = MOOAuth_Debug::get_log_file_path();
			if ( ! file_exists( $mo_filepath ) ) {
				wp_die( '404 File not found!' );
			}

			if ( ! function_exists( 'request_filesystem_credentials' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			$credentials = request_filesystem_credentials( site_url() );
			if ( ! WP_Filesystem( $credentials ) ) {
				wp_die( 'Could not initialize filesystem.' );
			}
			global $wp_filesystem;

			header( 'Content-Description: File Transfer' );
			header( 'Content-Type: text/plain' );
			header( 'Content-Disposition: attachment; filename="' . basename( $mo_filepath ) . '"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			header( 'Content-Length: ' . filesize( $mo_filepath ) );

			// Output the file contents using WP_Filesystem.
			echo esc_html( $wp_filesystem->get_contents( $mo_filepath ) );
			ob_flush();
			flush();
			exit;
		}

		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_register_customer' && isset( $_REQUEST['mo_oauth_register_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_register_form_field'] ) ), 'mo_oauth_register_form' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				$email            = '';
				$phone            = '';
				$password         = '';
				$confirm_password = '';
				$fname            = '';
				$lname            = '';
				$company          = '';
				if ( ( empty( $_POST['email'] ) || empty( $_POST['password'] ) || empty( $_POST['confirmPassword'] ) ) || $this->mo_oauth_check_empty_or_null( sanitize_text_field( wp_unslash( $_POST['email'] ) ) ) || $this->mo_oauth_check_empty_or_null( wp_unslash( $_POST['password'] ) ) || $this->mo_oauth_check_empty_or_null( wp_unslash( $_POST['confirmPassword'] ) ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization.
					update_option( 'message', 'All the fields are required. Please enter valid entries.' );
					$this->mo_oauth_show_error_message();
					return;
				} elseif ( strlen( wp_unslash( $_POST['password'] ) ) < 8 || strlen( wp_unslash( $_POST['confirmPassword'] ) ) < 8 ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization.
					update_option( 'message', 'Choose a password with minimum length 8.' );
					$this->mo_oauth_show_error_message();
					return;
				} else {
					$email            = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
					$phone            = ! empty( $_POST['phone'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['phone'] ) ) ) : '';
					$password         = isset( $_POST['password'] ) ? wp_unslash( $_POST['password'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Passwords are intentionally not sanitized to preserve special characters.
					$confirm_password = isset( $_POST['confirmPassword'] ) ? wp_unslash( $_POST['confirmPassword'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
					$fname            = ! empty( $_POST['fname'] ) ? sanitize_text_field( wp_unslash( $_POST['fname'] ) ) : '';
					$lname            = ! empty( $_POST['lname'] ) ? sanitize_text_field( wp_unslash( $_POST['lname'] ) ) : '';
					$company          = ! empty( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
				}

				update_option( 'mo_oauth_admin_email', $email );
				update_option( 'mo_oauth_client_admin_phone', $phone );
				update_option( 'mo_oauth_admin_fname', $fname );
				update_option( 'mo_oauth_admin_lname', $lname );
				update_option( 'mo_oauth_admin_company', $company );

				if ( mooauth_is_curl_installed() === 0 ) {
					return $this->mo_oauth_show_curl_error();
				}

				if ( strcmp( $password, $confirm_password ) === 0 ) {
					$customer = new MO_OAuth_Client_Customer();
					$email    = get_option( 'mo_oauth_admin_email' );
					$content  = json_decode( $customer->check_customer(), true );
					if ( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND' ) === 0 ) {
						$response = json_decode( $customer->create_customer( $password ), true );
						if ( strcasecmp( $response['status'], 'SUCCESS' ) === 0 ) {
							$this->mo_oauth_get_current_customer( $password );
							wp_safe_redirect( admin_url( '/admin.php?page=mo_oauth_settings&tab=account' ), 301 );
							exit;
						} if ( strcasecmp( $response['status'], 'FAILED' ) === 0 && strcasecmp( $response['message'], 'Email is not enterprise email.' ) === 0 ) {
							update_option( 'message', 'Please use your Enterprise email for registration.' );
						} elseif ( strcasecmp( $response['status'], 'TRANSACTION_LIMIT_EXCEEDED' ) === 0 ) {
							update_option( 'message', 'The registration limit of plugin has been exceeded. Please send your query to oauthsupport@xecurify.com.' );
						} else {
							update_option( 'message', 'Failed to create customer. Try again.' );
						}
						$this->mo_oauth_show_error_message();
					} else {
						$this->mo_oauth_get_current_customer( $password );
					}
				} else {
					update_option( 'message', 'Passwords do not match.' );
					delete_option( 'mo_oauth_client_verify_customer' );
					$this->mo_oauth_show_error_message();
				}
			}
		}

		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_client_goto_login' && isset( $_REQUEST['mo_oauth_goto_login_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_goto_login_form_field'] ) ), 'mo_oauth_goto_login_form' ) ) {
			delete_option( 'mo_oauth_client_new_registration' );
			update_option( 'mo_oauth_client_verify_customer', 'true' );
		}

		if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_verify_customer' && isset( $_REQUEST['mo_oauth_verify_password_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_verify_password_form_field'] ) ), 'mo_oauth_verify_password_form' ) ) {   // register the admin to miniOrange.
			if ( current_user_can( 'manage_options' ) ) {
				if ( mooauth_is_curl_installed() === 0 ) {
					return $this->mo_oauth_show_curl_error();
				}
				// validation and sanitization.
				$email    = '';
				$password = '';
				if ( $this->mo_oauth_check_empty_or_null( sanitize_text_field( wp_unslash( $_POST['email'] ) ) ) || $this->mo_oauth_check_empty_or_null( wp_unslash( $_POST['password'] ) ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization.
					update_option( 'message', 'All the fields are required. Please enter valid entries.' );
					$this->mo_oauth_show_error_message();
					return;
				} else {
					$email    = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
					$password = ! empty( $_POST['password'] ) ? wp_unslash( $_POST['password'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Passwords are not sanitized to preserve special characters.
				}
				update_option( 'mo_oauth_admin_email', $email );
				$customer     = new MO_OAuth_Client_Customer();
				$content      = $customer->get_customer_key( $password );
				$customer_key = json_decode( $content, true );
				if ( json_last_error() === JSON_ERROR_NONE ) {
					update_option( 'mo_oauth_client_admin_customer_key', $customer_key['id'] );
					update_option( 'mo_oauth_client_admin_api_key', $customer_key['apiKey'] );
					update_option( 'mo_oauth_client_customer_token', $customer_key['token'] );
					if ( isset( $customer_key['phone'] ) ) {
						update_option( 'mo_oauth_client_admin_phone', $customer_key['phone'] );
					}
					update_option( 'message', 'Customer retrieved successfully' );
					delete_option( 'mo_oauth_client_verify_customer' );
					delete_option( 'mo_oauth_client_new_registration' );
					$this->mo_oauth_show_success_message();
				} else {
					update_option( 'message', 'Invalid username or password. Please try again.' );
					$this->mo_oauth_show_error_message();
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_add_app' && isset( $_REQUEST['mo_oauth_add_app_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_add_app_form_field'] ) ), 'mo_oauth_add_app_form' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				$scope        = '';
				$clientid     = ! empty( $_POST['mo_oauth_client_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_client_id'] ) ) : '';
				$clientsecret = ! empty( $_POST['mo_oauth_client_secret'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_client_secret'] ) ) : '';
				if ( $this->mo_oauth_check_empty_or_null( $clientid ) || $this->mo_oauth_check_empty_or_null( $clientsecret ) ) {
					update_option( 'message', 'Please enter valid Client ID and Client Secret.' );
					$this->mo_oauth_show_error_message();
					return;
				} else {
					$callback_url       = site_url();
					$scope              = isset( $_POST['mo_oauth_scope'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_scope'] ) ) ) : '';
					$clientid           = stripslashes( $_POST['mo_oauth_client_id'] ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- Adding PHPCS ignore as there are special chars in client id.
					$clientsecret       = stripslashes( $_POST['mo_oauth_client_secret'] ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- Adding PHPCS ignore as there are special chars in client secret.
					$appname            = isset( $_POST['mo_oauth_custom_app_name'] ) ? rtrim( stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_custom_app_name'] ) ) ), ' ' ) : '';
					$ssoprotocol        = isset( $_POST['mo_oauth_app_type'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_app_type'] ) ) ) : '';
					$selectedapp        = isset( $_POST['mo_oauth_app_name'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_app_name'] ) ) ) : '';
					$send_headers       = isset( $_POST['mo_oauth_authorization_header'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_authorization_header'] ) ) : '0';
					$send_body          = isset( $_POST['mo_oauth_body'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_body'] ) ) : '0';
					$send_state         = isset( $_POST['mo_oauth_state'] ) ? (int) filter_var( sanitize_text_field( wp_unslash( $_POST['mo_oauth_state'] ) ), FILTER_SANITIZE_NUMBER_INT ) : 0;
					$show_on_login_page = isset( $_POST['mo_oauth_show_on_login_page'] ) ? (int) filter_var( sanitize_text_field( wp_unslash( $_POST['mo_oauth_show_on_login_page'] ) ), FILTER_SANITIZE_NUMBER_INT ) : 0;
					$allow_admin_sso    = isset( $_POST['mo_oauth_allow_admin_sso'] ) ? (int) filter_var( sanitize_text_field( wp_unslash( $_POST['mo_oauth_allow_admin_sso'] ) ), FILTER_SANITIZE_NUMBER_INT ) : 0;

					if ( 'wso2' === $selectedapp ) {
						update_option( 'mo_oauth_client_custom_token_endpoint_no_csecret', true );
					}

					if ( get_option( 'mo_oauth_apps_list' ) ) {
						$appslist = get_option( 'mo_oauth_apps_list' );
					} else {
						$appslist = array();
					}

					$email_attr = '';
					$name_attr  = '';
					$newapp     = array();

					$isupdate = false;
					foreach ( $appslist as $key => $currentapp ) {
						if ( $appname === $key ) {
							$newapp   = $currentapp;
							$isupdate = true;
							break;
						}
					}

					if ( ! $isupdate && count( $appslist ) > 0 ) {
						update_option( 'message', 'You can only add 1 application with free version. Upgrade to enterprise version if you want to add more applications.' );
						$this->mo_oauth_show_error_message();
						return;
					}

					$newapp['clientid']           = $clientid;
					$newapp['clientsecret']       = $clientsecret;
					$newapp['scope']              = $scope;
					$newapp['redirecturi']        = $callback_url;
					$newapp['ssoprotocol']        = $ssoprotocol;
					$newapp['send_headers']       = $send_headers;
					$newapp['send_body']          = $send_body;
					$newapp['send_state']         = $send_state;
					$newapp['show_on_login_page'] = $show_on_login_page;
					$newapp['allow_admin_sso']    = $allow_admin_sso;

					if ( 'oauth1' === $appname || 'twitter' === $appname ) {
						$newapp['requesturl'] = isset( $_POST['mo_oauth_requesturl'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_requesturl'] ) ) ) : '';
					}

					if ( isset( $_POST['mo_oauth_app_type'] ) ) {
						$newapp['apptype'] = stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_app_type'] ) ) );
					} else {
						$newapp['apptype'] = stripslashes( 'oauth' );
					}

					if ( isset( $_POST['mo_oauth_app_name'] ) ) {
						$newapp['appId'] = sanitize_text_field( wp_unslash( $_POST['mo_oauth_app_name'] ) );
					}

					if ( isset( $_POST['mo_oauth_discovery'] ) && '' !== $_POST['mo_oauth_discovery'] ) {
						add_option( 'mo_existing_app_flow', true );
						$newapp['existing_app_flow'] = true;
						$discovery_endpoint          = sanitize_text_field( wp_unslash( $_POST['mo_oauth_discovery'] ) );
						if ( isset( $_POST['mo_oauth_provider_domain'] ) ) {
							$domain             = stripslashes( rtrim( sanitize_text_field( wp_unslash( $_POST['mo_oauth_provider_domain'], '/' ) ) ) );
							$discovery_endpoint = str_replace( 'domain', $domain, $discovery_endpoint );
							$newapp['domain']   = $domain;
						} elseif ( isset( $_POST['mo_oauth_provider_tenant'] ) ) {
							$tenant             = stripslashes( trim( sanitize_text_field( wp_unslash( $_POST['mo_oauth_provider_tenant'] ) ) ) );
							$discovery_endpoint = str_replace( 'tenant', $tenant, $discovery_endpoint );
							$newapp['tenant']   = $tenant;
						}

						if ( isset( $_POST['mo_oauth_provider_policy'] ) ) {
							$policy             = stripslashes( trim( sanitize_text_field( wp_unslash( $_POST['mo_oauth_provider_policy'] ) ) ) );
							$discovery_endpoint = str_replace( 'policy', $policy, $discovery_endpoint );
							$newapp['policy']   = $policy;
						} elseif ( isset( $_POST['mo_oauth_provider_realm'] ) ) {
							$realm              = stripslashes( trim( sanitize_text_field( wp_unslash( $_POST['mo_oauth_provider_realm'] ) ) ) );
							$discovery_endpoint = str_replace( 'realmname', $realm, $discovery_endpoint );
							$newapp['realm']    = $realm;
						}

						$provider_se = null;

						if ( ( filter_var( $discovery_endpoint, FILTER_VALIDATE_URL ) ) ) {
							$content = wp_remote_get( $discovery_endpoint, array( 'sslverify' => false ) );
							if ( ! empty( $newapp['realm'] ) && wp_remote_retrieve_response_code( $content ) !== 200 ) {
								$discovery_endpoint = str_replace( '/auth', '', $discovery_endpoint );
								$content            = wp_remote_get( $discovery_endpoint, array( 'sslverify' => false ) );
							}
							$provider_se = array();
							if ( ! is_wp_error( $content ) && wp_remote_retrieve_response_code( $content ) === 200 ) {
								$content     = wp_remote_retrieve_body( $content );
								$provider_se = json_decode( $content );
								$scope1      = isset( $provider_se->scopes_supported[0] ) ? $provider_se->scopes_supported[0] : '';
								$scope2      = isset( $provider_se->scopes_supported[1] ) ? $provider_se->scopes_supported[1] : '';
								$openid      = '';
								if ( 'openid' !== $scope1 && 'openid' !== $scope2 && in_array( 'openid', $provider_se->scopes_supported, true ) ) {
									$openid = 'openid';
								}
								if ( '' !== $openid ) {
									$pscope = $openid . ' ' . stripslashes( $scope1 ) . ' ' . stripslashes( $scope2 );
								} else {
									$pscope = stripslashes( $scope1 ) . ' ' . stripslashes( $scope2 );
								}

								$newapp['scope']                   = ( isset( $scope ) && '' !== $scope ) ? $scope : $pscope;
								$newapp['authorizeurl']            = isset( $provider_se->authorization_endpoint ) ? stripslashes( $provider_se->authorization_endpoint ) : '';
								$newapp['accesstokenurl']          = isset( $provider_se->token_endpoint ) ? stripslashes( $provider_se->token_endpoint ) : '';
								$newapp['resourceownerdetailsurl'] = isset( $provider_se->userinfo_endpoint ) ? stripslashes( $provider_se->userinfo_endpoint ) : '';
								$newapp['discovery']               = $discovery_endpoint;
							} else {
								$newapp['scope']                   = isset( $scope ) ? $scope : '';
								$newapp['authorizeurl']            = '';
								$newapp['accesstokenurl']          = '';
								$newapp['resourceownerdetailsurl'] = '';
							}
						}
					} else {
						update_option( 'mo_oc_valid_discovery_ep', true );
						$newapp['authorizeurl']            = isset( $_POST['mo_oauth_authorizeurl'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_authorizeurl'] ) ) ) : '';
						$newapp['accesstokenurl']          = isset( $_POST['mo_oauth_accesstokenurl'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_accesstokenurl'] ) ) ) : '';
						$newapp['resourceownerdetailsurl'] = isset( $_POST['mo_oauth_resourceownerdetailsurl'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_resourceownerdetailsurl'] ) ) ) : '';
					}

					$appslist[ $appname ] = $newapp;
					update_option( 'mo_oauth_apps_list', $appslist );

					if ( isset( $_POST['mo_oauth_discovery'] ) && ! $provider_se ) {
						update_option( 'message', 'Error: Incorrect Domain/Tenant/Policy/Realm. Please configure with correct values and try again.' );
						update_option( 'mo_discovery_validation', 'invalid' );
						$this->mo_oauth_show_error_message();
					} else {
						update_option( 'message', 'Your settings are saved successfully.' );
						update_option( 'mo_discovery_validation', 'valid' );
						$this->mo_oauth_show_success_message();
						// }
						if ( ! isset( $newapp['username_attr'] ) || empty( $newapp['username_attr'] ) && get_option( 'mo_oauth_apps_list' ) ) {
							$notices = get_option( 'mo_oauth_client_notice_messages' );
							if ( ! is_array( $notices ) ) {
								$notices = array();
							}
							$notices['attr_mapp_notice'] = 'Please map the attributes by going to the <a href="' . admin_url( 'admin.php?page=mo_oauth_settings&tab=attributemapping' ) . '">Attribute/Role Mapping</a> Tab.';
							update_option( 'mo_oauth_client_notice_messages', $notices );
						}
					}
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_email_verified' && isset( $_REQUEST['mo_oauth_email_verified_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_email_verified_form_field'] ) ), 'mo_oauth_email_verified_form' ) ) {
			$email_verify_check                              = isset( $_POST['mo_oauth_email_verify_check'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_email_verify_check'] ) ) ) : '';
			$email_verify_key                                = isset( $_POST['mo_oauth_idp_email_verified_key'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_idp_email_verified_key'] ) ) ) : '';
			$email_verify_value                              = isset( $_POST['mo_oauth_idp_email_verified_value'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_idp_email_verified_value'] ) ) ) : '';
			$app_config['mo_oauth_email_verify_check']       = $email_verify_check;
			$app_config['mo_oauth_idp_email_verified_key']   = $email_verify_key;
			$app_config['mo_oauth_idp_email_verified_value'] = $email_verify_value;
			update_option( 'mo_oauth_login_settings_option', $app_config );

		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_attribute_mapping' && isset( $_REQUEST['mo_oauth_attr_role_mapping_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_attr_role_mapping_form_field'] ) ), 'mo_oauth_attr_role_mapping_form' ) ) {

			if ( current_user_can( 'manage_options' ) ) {
				$appname       = isset( $_POST['mo_oauth_app_name'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_app_name'] ) ) ) : '';
				$username_attr = isset( $_POST['mo_oauth_username_attr'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_username_attr'] ) ) ) : '';
				$email_attr    = isset( $_POST['mo_oauth_email_attr'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_email_attr'] ) ) ) : '';
				$attr_option   = isset( $_POST['mo_attr_option'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_attr_option'] ) ) ) : '';
				if ( empty( $appname ) ) {
					update_option( 'message', 'You MUST configure an application before you map attributes.' );
					$this->mo_oauth_show_error_message();
					return;
				}
				if ( ! empty( $email_attr ) ) {
					$mo_oauth_attr_name_list = get_option( 'mo_oauth_attr_name_list' );
					$email                   = mooauth_client_getnestedattribute( $mo_oauth_attr_name_list, $email_attr );
					if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
						update_option( 'message', 'Invalid email attribute entered. Please ensure it is a valid email format.' );
						$this->mo_oauth_show_error_message();
						return;
					}
				}
				$appslist = get_option( 'mo_oauth_apps_list' );
				foreach ( $appslist as $key => $currentapp ) {
					if ( $appname === $key ) {
						$currentapp['username_attr'] = $username_attr;
						$currentapp['email_attr']    = $email_attr;
						$appslist[ $key ]            = $currentapp;
						break;
					}
				}

				update_option( 'mo_oauth_apps_list', $appslist );
				update_option( 'message', 'Your settings are saved successfully.' );
				update_option( 'mo_attr_option', $attr_option );
				$this->mo_oauth_show_success_message();
				$notices = get_option( 'mo_oauth_client_notice_messages' );
				if ( isset( $notices['attr_mapp_notice'] ) ) {
					unset( $notices['attr_mapp_notice'] );
					update_option( 'mo_oauth_client_notice_messages', $notices );
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_contact_us_query_option' && isset( $_REQUEST['mo_oauth_support_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_support_form_field'] ) ), 'mo_oauth_support_form' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				if ( mooauth_is_curl_installed() === 0 ) {
					return $this->mo_oauth_show_curl_error();
				}
				// Contact Us query.
				$email       = ! empty( $_POST['mo_oauth_contact_us_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_oauth_contact_us_email'] ) ) : '';
				$phone       = ! empty( $_POST['mo_oauth_contact_us_phone'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_contact_us_phone'] ) ) ) : '';
				$query       = ! empty( $_POST['mo_oauth_contact_us_query'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_contact_us_query'] ) ) ) : '';
				$send_config = isset( $_POST['mo_oauth_send_plugin_config'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_send_plugin_config'] ) ) : '0';
				$customer    = new MO_OAuth_Client_Customer();
				if ( $this->mo_oauth_check_empty_or_null( $email ) || $this->mo_oauth_check_empty_or_null( $query ) ) {
					update_option( 'message', 'Please fill up Email and Query fields to submit your query.' );
					$this->mo_oauth_show_error_message();
				} else {
					$mo_call_setup           = array_key_exists( 'oauth_setup_call', $_POST );
					$mo_call_setup_validated = false;
					$issue_description       = null;

					if ( true === $mo_call_setup ) {
						$issue             = isset( $_POST['mo_oauth_setup_call_issue'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_setup_call_issue'] ) ) : ''; // select.
						$call_date         = isset( $_POST['mo_oauth_setup_call_date'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_setup_call_date'] ) ) : '';
						$issue_description = isset( $_POST['mo_oauth_issue_description'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_issue_description'] ) ) : '';
						$time_diff         = isset( $_POST['mo_oauth_time_diff'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_time_diff'] ) ) : '';  // timezone offset.
						$call_time         = isset( $_POST['mo_oauth_setup_call_time'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_setup_call_time'] ) ) : ''; // time input.

						if ( ! ( $this->mo_oauth_check_empty_or_null( $email ) || $this->mo_oauth_check_empty_or_null( $issue ) || $this->mo_oauth_check_empty_or_null( $call_date ) || $this->mo_oauth_check_empty_or_null( $time_diff ) || $this->mo_oauth_check_empty_or_null( $call_time ) ) ) {
							// Please modify the $time_diff to test for the different timezones.
							// Note - $time_diff for IST is -330.
							$hrs  = floor( abs( $time_diff ) / 60 );
							$mins = fmod( abs( $time_diff ), 60 );
							if ( 0 === $mins ) {
								$mins = '00';
							}
							$sign = '+';
							if ( $time_diff > 0 ) {
								$sign = '-';
							}
							$call_time_zone = 'UTC ' . $sign . ' ' . $hrs . ':' . $mins;
							$call_date      = gmdate( 'jS F', strtotime( $call_date ) );

							// code to convert local time to IST.
							$local_hrs      = explode( ':', $call_time )[0];
							$local_mins     = explode( ':', $call_time )[1];
							$call_time_mins = ( $local_hrs * 60 ) + $local_mins;
							$ist_time       = $call_time_mins + $time_diff + 330;
							$ist_date       = $call_date;
							if ( $ist_time > 1440 ) {
								$ist_time = fmod( $ist_time, 1440 );
								$ist_date = gmdate( 'jS F', strtotime( '1 day', strtotime( $call_date ) ) );
							} elseif ( $ist_time < 0 ) {
								$ist_time = 1440 + $ist_time;
								$ist_date = gmdate( 'jS F', strtotime( '-1 day', strtotime( $call_date ) ) );
							}
							$ist_hrs = floor( $ist_time / 60 );
							$ist_hrs = sprintf( '%02d', $ist_hrs );

							$ist_mins = fmod( $ist_time, 60 );
							$ist_mins = sprintf( '%02d', $ist_mins );

							$ist_time                = $ist_hrs . ':' . $ist_mins;
							$mo_call_setup_validated = true;
						}
					}
					if ( $mo_call_setup && $mo_call_setup_validated ) {
						$submited = $customer->submit_setup_call( $email, $issue, $issue_description, $query, $call_date, $call_time_zone, $call_time, $ist_date, $ist_time, $phone, $send_config );
					} elseif ( $mo_call_setup || $mo_call_setup_validated ) {
						$submited = false;
					} else {
						$submited = $customer->submit_contact_us( $email, $phone, $query, $send_config );
					}

					if ( false === $submited ) {
						update_option( 'message', 'Your query could not be submitted. Please fill up all the required fields and try again.' );
						$this->mo_oauth_show_error_message();
					} else {
						update_option( 'message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						$this->mo_oauth_show_success_message();
					}
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_client_demo_request_form' && isset( $_REQUEST['mo_oauth_client_demo_request_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_client_demo_request_field'] ) ), 'mo_oauth_client_demo_request_form' ) ) {

			if ( current_user_can( 'manage_options' ) ) {
				if ( mooauth_is_curl_installed() === 0 ) {
					return $this->mo_oauth_show_curl_error();
				}
				// Demo Request.
				$email     = ! empty( $_POST['mo_auto_create_demosite_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_auto_create_demosite_email'] ) ) : '';
				$demo_plan = ! empty( $_POST['mo_auto_create_demosite_demo_plan'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_auto_create_demosite_demo_plan'] ) ) ) : '';
				$query     = ! empty( $_POST['mo_auto_create_demosite_usecase'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_auto_create_demosite_usecase'] ) ) ) : '';

				if ( $this->mo_oauth_check_empty_or_null( $email ) || $this->mo_oauth_check_empty_or_null( $demo_plan ) || $this->mo_oauth_check_empty_or_null( $query ) ) {
					update_option( 'message', 'Please fill up Usecase, Email field and Requested demo plan to submit your query.' );
					$this->mo_oauth_show_error_message();
				} else {
					$response        = wp_remote_get( 'https://demo.miniorange.com', array( 'timeout' => 5 ) );
					$demosite_status = ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200;
					$addons          = MO_OAuth_Client_Addons::$all_addons;
					$addons_selected = '';
					foreach ( $addons as $key => $value ) {
						if ( isset( $_POST[ $value['tag'] ] ) && sanitize_text_field( wp_unslash( $_POST[ $value['tag'] ] ) ) === 'true' ) {
							$addons_selected .= $value['title'] . ', ';
						}
					}
					$addons_selected = rtrim( $addons_selected, ', ' );
					if ( empty( $addons_selected ) || is_null( $addons_selected ) ) {
						$addons_selected = 'No Add-ons selected';
					}
					if ( $demosite_status && 'Not Sure' !== $demo_plan ) {
						$url = 'https://demo.miniorange.com/wordpress-oauth/';

						$headers = array(
							'Content-Type' => 'application/x-www-form-urlencoded',
							'charset'      => 'UTF - 8',
						);
						$args    = array(
							'method'      => 'POST',
							'body'        => array(
								'option' => 'mo_auto_create_demosite',
								'mo_auto_create_demosite_email' => $email,
								'mo_auto_create_demosite_usecase' => $query,
								'mo_auto_create_demosite_demo_plan' => $demo_plan,
								'mo_auto_create_demosite_plugin_name' => MO_OAUTH_PLUGIN_SLUG,
								'mo_auto_create_demosite_addons' => $addons_selected,
							),
							'timeout'     => '20',
							'redirection' => '5',
							'httpversion' => '1.0',
							'blocking'    => true,
							'headers'     => $headers,

						);

						$response = wp_remote_post( $url, $args );

						if ( is_wp_error( $response ) ) {
							$error_message = $response->get_error_message();
							echo 'Something went wrong: ' . esc_attr( $error_message );
							exit();
						}
						$output = wp_remote_retrieve_body( $response );
						$output = json_decode( $output );
						if ( is_null( $output ) ) {
							$customer = new MO_OAuth_Client_Customer();
							$customer->mo_oauth_send_demo_alert( $email, $demo_plan, $query, $addons_selected, 'WP OAuth Client On Demo Request - ' . $email );
							update_option( 'message', 'Thanks for getting in touch! We shall get back to you shortly.' );
							$this->mo_oauth_show_success_message();
						} elseif ( 'SUCCESS' === $output->status ) {

							if ( isset( $output->demo_credentials ) ) {
								$demo_credentials = array();

								$site_url           = esc_url_raw( $output->demo_credentials->site_url );
								$email              = sanitize_email( $output->demo_credentials->email );
								$temporary_password = $output->demo_credentials->temporary_password;
								$password_link      = esc_url_raw( $output->demo_credentials->password_link );

								$sanitized_demo_credentials = array(
									'site_url'           => $site_url,
									'email'              => $email,
									'temporary_password' => $temporary_password,
									'password_link'      => $password_link,
									'validity'           => gmdate( 'd F, Y', strtotime( '+10 day' ) ),
								);

								update_option( 'mo_oauth_demo_creds', $sanitized_demo_credentials );

								$output->message = 'Your trial has been generated successfully. Please use the below credentials to access the trial.';
							}
								update_option( 'message', $output->message );
								$this->mo_oauth_show_success_message();
						} else {
							update_option( 'message', $output->message );
							$this->mo_oauth_show_error_message();
						}
					} else {
						$customer = new MO_OAuth_Client_Customer();
						$customer->mo_oauth_send_demo_alert( $email, $demo_plan, $query, $addons_selected, 'WP OAuth Client On Demo Request - ' . $email );
						update_option( 'message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						$this->mo_oauth_show_success_message();
					}
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_client_video_demo_request_form' && isset( $_REQUEST['mo_oauth_client_video_demo_request_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_client_video_demo_request_field'] ) ), 'mo_oauth_client_video_demo_request_form' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				if ( mooauth_is_curl_installed() === 0 ) {
					return $this->mo_oauth_show_curl_error();
				}

				// video demo request.
				$email     = ! empty( $_POST['mo_oauth_video_demo_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_oauth_video_demo_email'] ) ) : '';
				$call_date = isset( $_POST['mo_oauth_video_demo_request_date'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_date'] ) ) : '';
				$time_diff = isset( $_POST['mo_oauth_video_demo_time_diff'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_time_diff'] ) ) : ''; // timezone offset.
				$call_time = isset( $_POST['mo_oauth_video_demo_request_time'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_time'] ) ) : ''; // time input.
				$query     = ! empty( $_POST['mo_oauth_video_demo_request_usecase_text'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_usecase_text'] ) ) ) : '';
				$customer  = new MO_OAuth_Client_Customer();

				if ( $this->mo_oauth_check_empty_or_null( $email ) || $this->mo_oauth_check_empty_or_null( $call_date ) || $this->mo_oauth_check_empty_or_null( $query ) || $this->mo_oauth_check_empty_or_null( $time_diff ) || $this->mo_oauth_check_empty_or_null( $call_time ) ) {
					update_option( 'message', 'Please fill up Usecase, Email field and Requested demo plan to submit your query.' );
					$this->mo_oauth_show_error_message();
				} else {

					$mo_oauth_video_demo_request_validated = false;
					$email                                 = ! empty( $_POST['mo_oauth_video_demo_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_oauth_video_demo_email'] ) ) : '';
					$call_date                             = isset( $_POST['mo_oauth_video_demo_request_date'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_date'] ) ) : '';
					$time_diff                             = isset( $_POST['mo_oauth_video_demo_time_diff'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_time_diff'] ) ) : ''; // timezone offset.
					$call_time                             = isset( $_POST['mo_oauth_video_demo_request_time'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_time'] ) ) : ''; // time input.
					$query                                 = ! empty( $_POST['mo_oauth_video_demo_email'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['mo_oauth_video_demo_request_usecase_text'] ) ) ) : '';

					if ( ! ( $this->mo_oauth_check_empty_or_null( $email ) || $this->mo_oauth_check_empty_or_null( $query ) || $this->mo_oauth_check_empty_or_null( $call_date ) || $this->mo_oauth_check_empty_or_null( $time_diff ) || $this->mo_oauth_check_empty_or_null( $call_time ) ) ) {
						// Please modify the $time_diff to test for the different timezones.
						// Note - $time_diff for IST is -330.
						$hrs      = floor( abs( $time_diff ) / 60 );
							$mins = fmod( abs( $time_diff ), 60 );
						if ( 0 === $mins ) {
							$mins = '00';
						}
							$sign = '+';
						if ( $time_diff > 0 ) {
							$sign = '-';
						}
							$call_time_zone = 'UTC ' . $sign . ' ' . $hrs . ':' . $mins;
							$call_date      = gmdate( 'jS F', strtotime( $call_date ) );

							// code to convert local time to IST.
							$local_hrs      = explode( ':', $call_time )[0];
							$local_mins     = explode( ':', $call_time )[1];
							$call_time_mins = ( $local_hrs * 60 ) + $local_mins;
							$ist_time       = $call_time_mins + $time_diff + 330;
							$ist_date       = $call_date;
						if ( $ist_time > 1440 ) {
							$ist_time = fmod( $ist_time, 1440 );
							$ist_date = gmdate( 'jS F', strtotime( '1 day', strtotime( $call_date ) ) );
						} elseif ( $ist_time < 0 ) {
							$ist_time = 1440 + $ist_time;
							$ist_date = gmdate( 'jS F', strtotime( '-1 day', strtotime( $call_date ) ) );
						}
							$ist_hrs = floor( $ist_time / 60 );
							$ist_hrs = sprintf( '%02d', $ist_hrs );

							$ist_mins = fmod( $ist_time, 60 );
							$ist_mins = sprintf( '%02d', $ist_mins );

							$ist_time                              = $ist_hrs . ':' . $ist_mins;
							$mo_oauth_video_demo_request_validated = true;
					}

					if ( $mo_oauth_video_demo_request_validated ) {
						$customer->mo_oauth_send_video_demo_alert( $email, $ist_date, $query, $ist_time, 'WP OAuth Client Video Demo Request - ' . $email, $call_time_zone, $call_time, $call_date );
						update_option( 'message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						$this->mo_oauth_show_success_message();
					} else {
						update_option( 'message', 'Your query could not be submitted. Please fill up all the required fields and try again.' );
						$this->mo_oauth_show_error_message();
					}
				}
			}
		} elseif ( isset( $_POST ['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_forgot_password_form_option' && isset( $_REQUEST['mo_oauth_forgotpassword_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_forgotpassword_form_field'] ) ), 'mo_oauth_forgotpassword_form' ) ) {

			if ( current_user_can( 'manage_options' ) ) {
				if ( ! mooauth_is_curl_installed() ) {
					update_option( 'mo_oauth_message', 'ERROR: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP cURL extension</a> is not installed or disabled. Resend OTP failed.' );
					$this->mo_oauth_show_error_message();
					return;
				}

				$email = get_option( 'mo_oauth_admin_email' );

				$customer = new MO_OAuth_Client_Customer();
				$content  = json_decode( $customer->mo_oauth_forgot_password( $email ), true );

				if ( strcasecmp( $content ['status'], 'SUCCESS' ) === 0 ) {
					update_option( 'message', 'Your password has been reset successfully. Please enter the new password sent to ' . $email . '.' );
					$this->mo_oauth_show_success_message();
				}
			}
		} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_oauth_change_email' && isset( $_REQUEST['mo_oauth_change_email_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_change_email_form_field'] ) ), 'mo_oauth_change_email_form' ) ) {
			// Adding back button.
			update_option( 'mo_oauth_client_verify_customer', '' );
			update_option( 'mo_oauth_client_registration_status', '' );
			update_option( 'mo_oauth_client_new_registration', 'true' );
		} elseif ( isset( $_POST['mo_oauth_client_feedback'] ) && sanitize_text_field( wp_unslash( $_POST['mo_oauth_client_feedback'] ) ) === 'true' && isset( $_REQUEST['mo_oauth_feedback_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_oauth_feedback_form_field'] ) ), 'mo_oauth_feedback_form' ) ) {

			if ( current_user_can( 'manage_options' ) ) {
				$user = wp_get_current_user();

				$message = 'Plugin Deactivated:';
				if ( isset( $_POST['deactivate_reason_select'] ) ) {
					$deactivate_reason = sanitize_text_field( wp_unslash( $_POST['deactivate_reason_select'] ) );
					$message          .= ': ' . $deactivate_reason;
				}

				$deactivate_reason_message = array_key_exists( 'query_feedback', $_POST ) ? sanitize_text_field( wp_unslash( $_POST['query_feedback'] ) ) : false;

				if ( isset( $deactivate_reason_message ) ) {
					$message .= ': ' . $deactivate_reason_message;
				}

				if ( isset( $_POST['rate'] ) ) {
					$rate_value = ! empty( $_POST['rate'] ) ? htmlspecialchars( sanitize_text_field( wp_unslash( $_POST['rate'] ) ) ) : '';
				}

				$rating = '[Rating: ' . $rate_value . ']';

				$email = ! empty( $_POST['query_mail'] ) ? sanitize_text_field( wp_unslash( $_POST['query_mail'] ) ) : '';
				if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
					$email = get_option( 'mo_oauth_admin_email' );
				}

				$reply_required = '';
				if ( isset( $_POST['get_reply'] ) ) {
					$reply_required = sanitize_text_field( wp_unslash( $_POST['get_reply'] ) );
				}
				if ( empty( $reply_required ) ) {
					$reply_required = 'No';
					$reply          = '[Reply :' . $reply_required . ']';
				} else {
					$reply_required = 'Yes';
					$reply          = '[Reply :' . $reply_required . ']';
				}
				$reply = $rating . ' ' . $reply;

				$feedback_reasons = new MO_OAuth_Client_Customer();
				if ( isset( $_POST['miniorange_feedback_skip'] ) && sanitize_text_field( wp_unslash( $_POST['miniorange_feedback_skip'] ) ) === 'Skip' ) {
						$feedback_reasons->mo_oauth_send_skipped_feedback_notice( 'Skipped Feedbacks: WordPress OAuth SSO ' );
						deactivate_plugins( __DIR__ . DIRECTORY_SEPARATOR . 'mo_oauth_settings.php' );
					if ( ! array_key_exists( 'mo_oauth_keep_settings_intact', $_POST ) ) {
						$this->delete_options_on_deactivation();
					}
						update_option( 'message', 'Plugin deactivated successfully' );
						$this->mo_oauth_show_success_message();
						wp_safe_redirect( self_admin_url( 'plugins.php?deactivate=true' ) );
				} elseif ( ! empty( $deactivate_reason ) && ! empty( $email ) ) {
						$submited = json_decode( $feedback_reasons->mo_oauth_send_email_alert( $email, $reply, $message, 'Feedback: WordPress ' . MO_OAUTH_PLUGIN_NAME ), true );
						deactivate_plugins( __DIR__ . DIRECTORY_SEPARATOR . 'mo_oauth_settings.php' );
					if ( ! array_key_exists( 'mo_oauth_keep_settings_intact', $_POST ) ) {
						$this->delete_options_on_deactivation();
					}
						update_option( 'message', 'Thank you for the feedback.' );
						$this->mo_oauth_show_success_message();
						wp_safe_redirect( self_admin_url( 'plugins.php?deactivate=true' ) );
				} elseif ( empty( $deactivate_reason ) ) {
					update_option( 'message', 'Please select one of the reasons, if your reason is not mentioned please select "Other Reasons" ' );
					$this->mo_oauth_show_error_message();
				} else {
					update_option( 'message', 'Please enter your email address.' );
					$this->mo_oauth_show_error_message();
				}
			}
		}
	}

	/**
	 * Get customer
	 *
	 * @param mixed $password miniOrange password.
	 */
	public function mo_oauth_get_current_customer( $password ) {
		$customer     = new MO_OAuth_Client_Customer();
		$content      = $customer->get_customer_key( $password );
		$customer_key = json_decode( $content, true );
		if ( json_last_error() === JSON_ERROR_NONE ) {
			update_option( 'mo_oauth_client_admin_customer_key', $customer_key['id'] );
			update_option( 'mo_oauth_client_admin_api_key', $customer_key['apiKey'] );
			update_option( 'mo_oauth_client_customer_token', $customer_key['token'] );
			update_option( 'password', '' );
			update_option( 'message', 'Customer retrieved successfully' );
			delete_option( 'mo_oauth_client_verify_customer' );
			delete_option( 'mo_oauth_client_new_registration' );
			$this->mo_oauth_show_success_message();
		} else {
			update_option( 'message', 'You already have an account with miniOrange. Please enter a valid password.' );
			update_option( 'mo_oauth_client_verify_customer', 'true' );
			$this->mo_oauth_show_error_message();

		}
	}

	/**
	 * Show curl error
	 */
	public function mo_oauth_show_curl_error() {
		if ( mooauth_is_curl_installed() === 0 ) {
			update_option( 'message', '<a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled. Please enable it to continue.' );
			$this->mo_oauth_show_error_message();
			return;
		}
	}

	/**
	 * Login via Shortcode
	 */
	public function mo_oauth_shortcode_login() {
		if ( mooauth_migrate_customers() || ! mooauth_is_customer_registered() ) {
			return '<div class="mo_oauth_premium_option_text" style="text-align: center;border: 1px solid;margin: 5px;padding-top: 25px;"><p>This feature is supported only in standard and higher versions.</p>
				<p><a href="' . esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ) . '" target="_blank">Click Here</a> to see our full list of Features.</p></div>';
		}
		$mowidget = new MOOAuth_Widget();
		return $mowidget->mo_oauth_login_form();
	}

	/**
	 * Export Plugin config.
	 *
	 * @param bool $share_with export client_id/client_secret.
	 */
	public function mo_oauth_export_plugin_config( $share_with = false ) {
		$appslist          = get_option( 'mo_oauth_apps_list' );
		$currentapp_config = null;
		if ( is_array( $appslist ) ) {
			foreach ( $appslist as $key => $value ) {
				$currentapp_config = $value;
				break;
			}
		}
		if ( $share_with ) {
			unset( $currentapp_config['clientid'] );
			unset( $currentapp_config['clientsecret'] );
		}
		return $currentapp_config;
	}

	/**
	 * Delete options on deactivation.
	 */
	public function delete_options_on_deactivation() {
		$this->mo_oauth_deactivate();
		delete_option( 'mo_oauth_admin_email' );
		delete_option( 'password' );
		delete_option( 'mo_oauth_admin_fname' );
		delete_option( 'mo_oauth_admin_lname' );
		delete_option( 'mo_oauth_admin_company' );
		if ( get_option( 'mo_oauth_apps_list' ) ) {
			$appslist = get_option( 'mo_oauth_apps_list' );
			foreach ( $appslist as $key => $currentapp ) {
				$name = $key;
				if ( isset( $name ) ) {
					delete_option( 'mo_oauth_' . $name . '_scope' );
					delete_option( 'mo_oauth_' . $name . '_client_id' );
					delete_option( 'mo_oauth_' . $name . '_client_secret' );
				}
			}
		}
		delete_option( 'mo_oauth_apps_list' );
		delete_option( 'mo_oauth_icon_width' );
		delete_option( 'mo_oauth_icon_height' );
		delete_option( 'mo_oauth_icon_margin' );
		delete_option( 'mo_oauth_icon_configure_css' );
		delete_option( 'mo_oauth_redirect_url' );
		delete_option( 'mo_oauth_attr_name_list' );
		delete_option( 'mo_oauth_authorizations' );
		delete_option( 'mo_oauth_set_val' );
		delete_option( 'mo_debug_enable' );
		delete_option( 'mo_debug_check' );
		delete_option( 'mo_oauth_client_show_rest_api_message' );
		delete_option( 'mo_oauth_setup_wizard_app' );
		delete_option( 'mo_oauth_client_custom_token_endpoint_no_csecret' );
		delete_option( 'mo_existing_app_flow' );
		delete_option( 'mo_oauth_transactionId' );
		delete_option( 'mo_oauth_message' );
		delete_option( 'mo_debug_time' );
		delete_option( 'mo_oauth_client_notice_messages' );
		delete_option( 'mo_oauth_client_disable_authorization_header' );
		delete_option( 'mo_attr_option' );
		delete_option( 'mo_oc_valid_discovery_ep' );
		delete_option( 'mo_discovery_validation' );
		delete_option( 'mo_oauth_activation_time' );
		delete_option( 'mo_oauth_login_icon_space' );
		delete_option( 'mo_oauth_login_icon_custom_width' );
		delete_option( 'mo_oauth_login_icon_custom_height' );
		delete_option( 'mo_oauth_login_icon_custom_size' );
		delete_option( 'mo_oauth_login_icon_custom_color' );
		delete_option( 'mo_oauth_login_icon_custom_boundary' );
	}
}
