<?php
/**
 * Widget
 *
 * @package    widget
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Adding required files.
 */
require 'class-mooauth-debug.php';

/**
 * [Add Widget Functionality]
 */
class MOOAuth_Widget extends WP_Widget {

	/**
	 * Initialzie widget parameters.
	 */
	public function __construct() {
		update_option( 'host_name', 'https://login.xecurify.com' );
		add_action( 'wp_enqueue_scripts', array( $this, 'mo_oauth_register_plugin_styles' ) );
		add_action( 'init', array( $this, 'mo_oauth_start_session' ) );
		add_action( 'init', array( $this, 'mo_oauth_add_email_verification_option' ) );
		add_action( 'wp_logout', array( $this, 'mo_oauth_end_session' ) );
		add_action( 'login_form', array( $this, 'mo_oauth_wplogin_form_button' ) );
		parent::__construct( 'mooauth_widget', MO_OAUTH_ADMIN_MENU, array( 'description' => __( 'Login to Apps with OAuth', 'miniorange-login-with-eve-online-google-facebook' ) ) );

	}

	/**
	 * Handle migration for Email verification.
	 */
	public function mo_oauth_add_email_verification_option() {
		$is_first_setup = get_option( 'mo_oauth_email_verification_option_initialized' );
		if ( false === $is_first_setup ) {
			$app_config = array();

			$app_config['mo_oauth_email_verify_check']       = 'true';
			$app_config['mo_oauth_idp_email_verified_key']   = 'email_verified';
			$app_config['mo_oauth_idp_email_verified_value'] = '1';

			update_option( 'mo_oauth_login_settings_option', $app_config );
			update_option( 'mo_oauth_email_verification_option_initialized', true );
		}
	}

	/**
	 * Enqueue CSS for widget
	 */
	public function mo_oauth_wplogin_form_style() {

		wp_enqueue_style( 'mo_oauth_fontawesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ), array(), '4.7.0' );
		wp_enqueue_style( 'mo_oauth_wploginform', plugins_url( 'css/login-page.min.css', __FILE__ ), array(), MO_OAUTH_CSS_JS_VERSION );
	}

	/**
	 * Display Login widget
	 */
	public function mo_oauth_wplogin_form_button() {
		$appslist = get_option( 'mo_oauth_apps_list' );
		if ( is_array( $appslist ) && count( $appslist ) > 0 ) {
			$this->mo_oauth_load_login_script();
			foreach ( $appslist as $key => $app ) {

				if ( isset( $app['show_on_login_page'] ) && 1 === $app['show_on_login_page'] ) {

					$this->mo_oauth_wplogin_form_style();

					echo '<br>';
					echo '<h4>Connect with :</h4><br>';
					echo '<div class="row">';

					$logo_class = $this->mo_oauth_client_login_button_logo( $app['appId'] );

					echo '<a style="text-decoration:none" href="javascript:void(0)" onClick="moOAuthLoginNew(\'' . esc_attr( $key ) . '\');"><div class="mo_oauth_login_button mo_oauth_login_button_text"><i class="' . esc_attr( $logo_class ) . ' mo_oauth_login_button_icon"></i>Login with ' . esc_attr( ucwords( $key ) ) . '</div></a>';
					echo '</div><br><br>';
				}
			}
		}
	}

	/**
	 * Get logo class for the configured app.
	 *
	 * @param mixed $current_app_id current app for which the logo needs to be displayed.
	 */
	public function mo_oauth_client_login_button_logo( $current_app_id ) {
		$currentapp = mooauth_client_get_app( $current_app_id );
		$logo_class = $currentapp->logo_class;
		return $logo_class;
	}

	/**
	 * Redirect to SSO after clicking on button
	 */
	public function mo_oauth_start_session() {
		if ( ! session_id() && ! mooauth_client_is_ajax_request() && ! mooauth_client_is_rest_api_call() ) {
			session_start();
		}

		if ( isset( $_REQUEST['option'] ) && sanitize_text_field( wp_unslash( $_REQUEST['option'] ) ) === 'testattrmappingconfig' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			$mo_oauth_app_name = ! empty( $_REQUEST['app'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['app'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			wp_safe_redirect( site_url() . '?option=oauthredirect&app_name=' . rawurlencode( $mo_oauth_app_name ) . '&test=true' );
			exit();
		}

	}

	/**
	 * Destroy user session.
	 */
	public function mo_oauth_end_session() {
		if ( ! session_id() ) {
			session_start();
		}
		session_destroy();
	}

	/**
	 * Echoes the widget content.
	 *
	 * @param mixed $args Display arguments including 'before_title', 'after_title',
	 *                         'before_widget', and 'after_widget'..
	 * @param mixed $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$wid_title = '';
		if ( ! empty( $instance['wid_title'] ) ) {
			$wid_title = $instance['wid_title'];
		}
		$wid_title = apply_filters( 'widget_title', $wid_title );
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $args['before_widget'] is html that needs to render on dom escaping will not render html.
		if ( ! empty( $wid_title ) ) {
			echo esc_attr( $args['before_title'] ) . esc_html( $wid_title ) . esc_attr( $args['after_title'] );
		}
		$this->mo_oauth_login_form();
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $args['after_widget'] is html that needs to render on dom escaping will not render html.
	}

	/**
	 * MiniOrange method to override parent method to update a particular instance of a widget.
	 *
	 * @param mixed $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param mixed $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( isset( $new_instance['wid_title'] ) ) {
			$instance['wid_title'] = wp_strip_all_tags( $new_instance['wid_title'] );
		}

		return $instance;
	}

	/**
	 * Display login widget content.
	 */
	public function mo_oauth_login_form() {
		global $post;
		$appslist = get_option( 'mo_oauth_apps_list' );
		if ( $appslist && count( $appslist ) > 0 ) {
			$apps_configured = true;
		}

		if ( ! is_user_logged_in() ) {

			if ( isset( $apps_configured ) && $apps_configured ) {

				$this->mo_oauth_wplogin_form_style();
				$this->mo_oauth_load_login_script();

				$style      = get_option( 'mo_oauth_icon_width' ) ? 'width:' . get_option( 'mo_oauth_icon_width' ) . ';' : '';
				$style     .= get_option( 'mo_oauth_icon_height' ) ? 'height:' . get_option( 'mo_oauth_icon_height' ) . ';' : '';
				$style     .= get_option( 'mo_oauth_icon_margin' ) ? 'margin:' . get_option( 'mo_oauth_icon_margin' ) . ';' : '';
				$custom_css = get_option( 'mo_oauth_icon_configure_css' );
				if ( empty( $custom_css ) ) {
					echo '<style>.oauthloginbutton{background: #7272dc;height:40px;padding:8px;text-align:center;color:#fff;}</style>';
				} else {
					echo '<style>' . esc_html( $custom_css ) . '</style>';
				}

				if ( is_array( $appslist ) ) {
					foreach ( $appslist as $key => $app ) {
						$logo_class = $this->mo_oauth_client_login_button_logo( $app['appId'] );

						echo '<a style="text-decoration:none" href="javascript:void(0)" onClick="moOAuthLoginNew(\'' . esc_attr( $key ) . '\');"><div class="mo_oauth_login_button_widget"><i class="' . esc_attr( $logo_class ) . ' mo_oauth_login_button_icon_widget"></i><h3 class="mo_oauth_login_button_text_widget">Login with ' . esc_attr( ucwords( $key ) ) . '</h3></div></a>';
					}
				}
			} else {
				echo '<div>No apps configured.</div>';
			}
		} else {
			$current_user       = wp_get_current_user();
			$link_with_username = __( 'Howdy, ', 'miniorange-login-with-eve-online-google-facebook' ) . $current_user->display_name;
			echo '<div id="logged_in_user" class="login_wid">
			<li>' . esc_attr( $link_with_username ) . ' | <a href="' . esc_url( wp_logout_url( site_url() ) ) . '" >Logout</a></li>
		</div>';

		}
	}

	/**
	 * Load login script
	 */
	private function mo_oauth_load_login_script() {
		?>
	<script type="text/javascript">

		function HandlePopupResult(result) {
			window.location.href = result;
		}

		function moOAuthLoginNew(app_name) {
			window.location.href = '<?php echo esc_attr( site_url() ); ?>' + '/?option=oauthredirect&app_name=' + app_name;
		}
	</script>
		<?php
	}



	/**
	 * Register Plugin styles.
	 */
	public function mo_oauth_register_plugin_styles() {
		wp_enqueue_style( 'style_login_widget', plugins_url( 'css/style_login_widget.min.css', __FILE__ ), array(), MO_OAUTH_CSS_JS_VERSION );
	}


}

/**
 * Update email as username attribute.
 *
 * @param mixed $currentappname Current SSO app name.
 */
function mooauth_update_email_to_username_attr( $currentappname ) {
	$appslist                                     = get_option( 'mo_oauth_apps_list' );
	$appslist[ $currentappname ]['username_attr'] = $appslist[ $currentappname ]['email_attr'];
	update_option( 'mo_oauth_apps_list', $appslist );
}

/**
 * Main SSO flow.
 */
function mooauth_login_validate() {

	/* Handle Authorize request */
	if ( isset( $_REQUEST['option'] ) && strpos( sanitize_text_field( wp_unslash( $_REQUEST['option'] ) ), 'oauthredirect' ) !== false ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		$appname  = ! empty( $_REQUEST['app_name'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['app_name'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		$appslist = get_option( 'mo_oauth_apps_list' );
		if ( isset( $_REQUEST['redirect_url'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			update_option( 'mo_oauth_redirect_url', sanitize_text_field( wp_unslash( $_REQUEST['redirect_url'] ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		}

		if ( isset( $_REQUEST['test'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			setcookie( 'mo_oauth_test', true, time() + 3600, '/', '', true, true );
		} else {
			setcookie( 'mo_oauth_test', false, time() + 3600, '/', '', true, true );
		}

		if ( false === $appslist ) {
			MOOAuth_Debug::mo_oauth_log( 'ERROR : Looks like you have not configured OAuth provider, please try to configure OAuth provider first' );
			exit( 'Looks like you have not configured OAuth provider, please try to configure OAuth provider first' );
		}

		foreach ( $appslist as $key => $app ) {

			if ( $appname === $key && ( isset( $app['send_state'] ) !== true || $app['send_state'] | 'oauth1' === $app['appId'] || 'twitter' === $app['appId'] ) ) {

				if ( 'twitter' === $app['appId'] || 'oauth1' === $app['appId'] ) {
					include 'class-mo-oauth-custom-oauth1.php';
					setcookie( 'tappname', $appname, time() + 3600, '/', '', true, true );
					$setcookie = ! empty( $_COOKIE['tappname'] ) ? MO_OAuth_Custom_OAuth1::mo_oauth1_auth_request( sanitize_text_field( wp_unslash( $_COOKIE['tappname'] ) ) ) : '';
					exit();
				}

				$timestamp           = time();
				$client_ip           = mooauth_get_client_ip();
				$hmac_secret         = wp_salt( 'auth' );
				$timestamp_hmac      = hash_hmac( 'sha256', $timestamp, $hmac_secret );
				$state_nonce         = bin2hex( \openssl_random_pseudo_bytes( 32 ) );
				$state_nonce_hmac    = hash_hmac( 'sha256', $state_nonce, $timestamp_hmac );
				$ip_hmac             = hash_hmac( 'sha256', $client_ip, $timestamp_hmac );
				$state_string        = $appname . '|' . $timestamp . '|' . $ip_hmac . '|' . $state_nonce_hmac;
				$state_string_cookie = $appname . '|' . $timestamp . '|' . $ip_hmac . '|' . $state_nonce;
				$state_cookie        = base64_encode( $state_string_cookie );//phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 encode will be required for fetching appname from state.
				$state               = base64_encode( $state_string ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 encode will be required for fetching appname from state.
				$authorization_url   = $app['authorizeurl'];

				if ( strpos( $authorization_url, '?' ) !== false ) {
					$authorization_url = $authorization_url . '&client_id=' . $app['clientid'] . '&scope=' . $app['scope'] . '&redirect_uri=' . $app['redirecturi'] . '&response_type=code&state=' . $state;
				} else {
					$authorization_url = $authorization_url . '?client_id=' . $app['clientid'] . '&scope=' . $app['scope'] . '&redirect_uri=' . $app['redirecturi'] . '&response_type=code&state=' . $state;
				}

				setcookie(
					'mo_oauth_sso_state',
					$state_cookie,
					array(
						'expires'  => time() + 300,   // 5 minutes
						'httponly' => true,
						'secure'   => is_ssl(),
						'samesite' => 'Lax',
						'path'     => COOKIEPATH,
						'domain'   => COOKIE_DOMAIN,
					)
				);

				if ( strpos( $authorization_url, 'apple' ) !== false ) {
					$authorization_url = str_replace( 'response_type=code', 'response_type=code+id_token', $authorization_url );
					$authorization_url = $authorization_url . '&response_mode=form_post';
				}

				if ( 'steam' === $app['appId'] ) {
					$return    = null;
					$alt_realm = null;

					$authorization_url = $app['authorizeurl'];

					$use_https = ! empty( $_SERVER['HTTPS'] ) || ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $sub_param2 === $_SERVER['HTTP_X_FORWARDED_PROTO'] );

					$sub_param1 = null;
					$sub_param2 = null;

					if ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['SCRIPT_NAME'] ) ) {
						$sub_param1 .= sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
						$sub_param2 .= sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) );
					}

					$return = ( $use_https ? 'https' : 'http' ) . '://' . $sub_param1 . $sub_param2;

					$params = array(
						'openid.ns'         => 'http://specs.openid.net/auth/2.0',
						'openid.mode'       => 'checkid_setup',
						'openid.return_to'  => $return,
						'openid.realm'      => null !== $alt_realm ? $alt_realm : ( ( $use_https ? 'https' : 'http' ) . '://' . $sub_param1 ),
						'openid.identity'   => 'http://specs.openid.net/auth/2.0/identifier_select',
						'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
					);

					$authorization_url = $authorization_url . '?' . http_build_query( $params );
				}

				if ( session_id() === '' || ! isset( $_SESSION ) ) {
					session_start();
				}
				$_SESSION['oauth2state'] = $state_cookie;
				$_SESSION['appname']     = $appname;

				MOOAuth_Debug::mo_oauth_log( 'Authorization Request Sent => ' . $authorization_url );
				header( 'Location: ' . $authorization_url );
				exit;
			} else {
				$state             = null;
				$authorization_url = $app['authorizeurl'];
				if ( strpos( $authorization_url, '?' ) !== false ) {
					$authorization_url = $authorization_url . '&client_id=' . $app['clientid'] . '&scope=' . $app['scope'] . '&redirect_uri=' . $app['redirecturi'] . '&response_type=code';
				} else {
					$authorization_url = $authorization_url . '?client_id=' . $app['clientid'] . '&scope=' . $app['scope'] . '&redirect_uri=' . $app['redirecturi'] . '&response_type=code';
				}
				setcookie(
					'mo_oauth_sso_state',
					$state_cookie,
					array(
						'expires'  => time() + 300,   // 5 minutes
						'httponly' => true,
						'secure'   => is_ssl(),
						'samesite' => 'Lax',
						'path'     => COOKIEPATH,
						'domain'   => COOKIE_DOMAIN,
					)
				);
				if ( session_id() === '' || ! isset( $_SESSION ) ) {
					session_start();
				}
				$_SESSION['oauth2state'] = $state_cookie;
				$_SESSION['appname']     = $appname;

				MOOAuth_Debug::mo_oauth_log( 'Authorization Request Sent => ' . $authorization_url );
				header( 'Location: ' . $authorization_url );
				exit;
			}
		}
	} elseif ( ( ! empty( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'openidcallback' ) !== false ) || ( strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'oauth_token' ) !== false ) && ( strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'oauth_verifier' ) ) ) {
		$appslist        = get_option( 'mo_oauth_apps_list' );
		$username_attr   = '';
		$email_attr      = '';
		$currentapp      = false;
		$allow_admin_sso = '';
		foreach ( $appslist as $key => $app ) {
			if ( $key === $_COOKIE['tappname'] ) {
						include 'class-mo-oauth-custom-oauth1.php';
						$currentapp = $app;
				if ( isset( $app['username_attr'] ) ) {
					$username_attr = $app['username_attr'];
				}
				if ( isset( $app['email_attr'] ) ) {
					if ( ! isset( $app['username_attr'] ) ) {
						mooauth_update_email_to_username_attr( sanitize_text_field( wp_unslash( $_COOKIE['tappname'] ) ) );
						$username_attr = $app['email_attr'];

					}

					$email_attr = $app['email_attr'];
				}
				if ( isset( $app['allow_admin_sso'] ) ) {
					$allow_admin_sso = $app['allow_admin_sso '];
				}
			}
		}

		$resource_owner = MO_OAuth_Custom_OAuth1::mo_oidc1_get_access_token( sanitize_text_field( wp_unslash( $_COOKIE['tappname'] ) ) );
		$username       = '';
		$email          = '';
		update_option( 'mo_oauth_attr_name_list', $resource_owner );
		// Test Configuration.
		if ( isset( $_COOKIE['mo_oauth_test'] ) && sanitize_text_field( wp_unslash( $_COOKIE['mo_oauth_test'] ) ) ) {
			setcookie( 'mo_oauth_test', false, time() + 3600, '/', '', true, true );
			echo '<div style="font-family:Calibri;padding:0 3%;color:012970;">';
			echo '<style>table{border-collapse:collapse;color:#012970;}th{background-color: #c6d8f6bd; text-align: center; padding: 8px; border-width:1px; border-style:solid; border-color:#012970;}tr:nth-child(odd) {background-color: #e4eeff;}td{padding:8px;border-width:1px; border-style:solid; border-color:#012970;word-break: break-all;}</style>';
			echo '<h2>Test Configuration</h2><table><tr><th>Attribute Name</th><th>Attribute Value</th></tr>';
			mooauth_client_testattrmappingconfig( '', $resource_owner );
			echo '</table>';
			echo '<div style="padding: 10px;"></div><input style="padding:7px 12px;width:100px;background: #012970 none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA; inset;color: #FFF;"type="button" value="Done" onClick="self.close();">&emsp;';
			echo '</div>';
			exit();
		}

		if ( ! empty( $username_attr ) ) {
			$username = mooauth_client_getnestedattribute( $resource_owner, $username_attr );
			MOOAuth_Debug::mo_oauth_log( 'Username received.=>' . $username );
		}

		if ( empty( $username ) || '' === $username ) {
					MOOAuth_Debug::mo_oauth_log( 'Username not received. Check your Attribute Mapping configuration.' );
					exit( 'Username not received. Check your <b>Attribute Mapping</b> configuration.' );
		}

		if ( ! is_string( $username ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Username is not a string. It is ' . mooauth_client_get_proper_prefix( gettype( $username ) ) );
			wp_die( 'Username is not a string. It is ' . esc_html( mooauth_client_get_proper_prefix( gettype( $username ) ) ) );
		}
		if ( ! empty( $email_attr ) ) {
			$email = mooauth_client_getnestedattribute( $resource_owner, $email_attr );
			MOOAuth_Debug::mo_oauth_log( 'email received.=>' . $email );
		}

		$user = get_user_by( 'login', $username );
		if ( ! $user && ! empty( $email_attr ) ) {
			$user = get_user_by( 'email', $email );
		}

		if ( $user ) {
			$user_id = $user->ID;

			if ( in_array( 'administrator', $user->roles, true ) ) {
				if ( ! $allow_admin_sso ) {
					MOOAuth_Debug::mo_oauth_log( 'WPO004: Invalid Login attempt. Please login using email and password.' );
					wp_die( 'WPO004: Invalid Login attempt. Please login using email and password.' );
				} else {
					$current_admin_email          = $user->user_email;
					$mo_oauth_email_verify_config = get_option( 'mo_oauth_login_settings_option' );
					$mo_oauth_email_verify_check  = $mo_oauth_email_verify_config['mo_oauth_email_verify_check'];

					if ( strtolower( $current_admin_email ) !== strtolower( $email ) ) {
						MOOAuth_Debug::mo_oauth_log( 'Error : WPO01 Invalid login attempt.' );
						wp_die( 'Error : WPO01 Invalid login attempt.' );
					}

					if ( $mo_oauth_email_verify_check ) {

						$idp_email_verified_key = isset( $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key'] ) && '' !== $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key']
						? $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key']
						: 'email_verified';

						$idp_email_verified_value = isset( $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value'] ) && '' !== $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value']
						? $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value']
						: '1';

						if ( isset( $resource_owner[ $idp_email_verified_key ] ) ) {
							$email_verified = $resource_owner[ $idp_email_verified_key ];
							if ( (string) $email_verified !== (string) $idp_email_verified_value ) {
								MOOAuth_Debug::mo_oauth_log( 'Error: wpoauth:002 - Email verification failed. Please log in using your WordPress username and password.' );
								wp_die( 'Error: wpoauth:002 - Email verification failed. Please log in using your WordPress username and password.' );
							}
						}
					}
				}
			}

			if ( ! empty( $email_attr ) ) {
				wp_update_user(
					array(
						'ID'         => $user_id,
						'user_email' => $email,
					)
				);
			}
		} else {
			if ( mooauth_migrate_customers() ) {
				$user = mooauth_looped_user( $username );
			} else {
				$user = mooauth_handle_user_registration( $username, $email );
			}
		}

		if ( $user ) {
			wp_set_current_user( $user->ID );
			wp_set_auth_cookie( $user->ID );
			$user = get_user_by( 'ID', $user->ID );
			do_action( 'wp_login', $user->user_login, $user );
			MOOAuth_Debug::mo_oauth_log( 'User logged-in.' );

			$redirect_to = get_option( 'mo_oauth_redirect_url' );

			if ( false === $redirect_to ) {
				$redirect_to = home_url();
			}

			wp_safe_redirect( $redirect_to );
			exit;
		}
	} elseif ( ( strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), '/wp-json/moserver/token' ) === false && ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), '/oauthcallback' ) !== false || isset( $_REQUEST['code'] ) ) ) || ( ! empty( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'openid.ns' ) !== false ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		if ( session_id() === '' || ! isset( $_SESSION ) ) {
			session_start();
		}
		MOOAuth_Debug::mo_oauth_log( 'OAuth plugin catched the flow, $_REQUEST array=>' );
		MOOAuth_Debug::mo_oauth_log( $_REQUEST ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL.

		// checking addiional condition for steam application.
		if ( isset( $_REQUEST['code'] ) || isset( $_REQUEST['openid_ns'] ) ) {  //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			// exit from our control when user is already logged in. This it to prevent the issue with Ecwid Ecommerce plugin.
			if ( is_user_logged_in() && ! isset( $_COOKIE['mo_oauth_test'] ) ) {
				return;
			}

			try {

				$currentappname = '';

				if ( isset( $_SESSION['appname'] ) && ! empty( $_SESSION['appname'] ) ) {
					$currentappname = sanitize_text_field( $_SESSION['appname'] );
				}
				if ( isset( $_REQUEST['state'] ) && ! empty( $_REQUEST['state'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
					$state_encoded  = sanitize_text_field( wp_unslash( $_REQUEST['state'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
					$state_data     = mooauth_validate_state( $state_encoded );
					$currentappname = $state_data['appname'];
				} else {
					$appslist       = get_option( 'mo_oauth_apps_list' );
					$state_required = false;
					foreach ( $appslist as $key => $app ) {
						MOOAuth_Debug::mo_oauth_log( 'Send State Value: ' );
						MOOAuth_Debug::mo_oauth_log( $app['send_state'] );
						if ( isset( $app['send_state'] ) && $app['send_state'] == true ) {
							$state_required = true;
							break;
						}
					}
					if ( $state_required ) {
						MOOAuth_Debug::mo_oauth_log( 'ERROR : State parameter is required but not found in request.' );
						wp_die( 'Authentication failed. State parameter is required.' );
					}
				}

				if ( empty( $currentappname ) ) {
					MOOAuth_Debug::mo_oauth_log( 'ERROR : No request found for this application.' );
					return;
				}
				$appslist        = get_option( 'mo_oauth_apps_list' );
				$username_attr   = '';
				$email_attr      = '';
				$currentapp      = false;
				$allow_admin_sso = '';
				foreach ( $appslist as $key => $app ) {
					if ( $key === $currentappname ) {
						$currentapp = $app;
						if ( isset( $app['username_attr'] ) ) {
							$username_attr = $app['username_attr'];
						}
						if ( isset( $app['email_attr'] ) ) {
							if ( ! isset( $app['username_attr'] ) ) {
								mooauth_update_email_to_username_attr( sanitize_text_field( wp_unslash( $_COOKIE['tappname'] ) ) );
								$username_attr = $app['email_attr'];

							}
							$email_attr = $app['email_attr'];
						}
						if ( isset( $app['allow_admin_sso'] ) ) {
							$allow_admin_sso = $app['allow_admin_sso'];
						}
					}
				}

				if ( ! $currentapp ) {
					MOOAuth_Debug::mo_oauth_log( 'Authorization Response Recieved => ERROR : Application not configured.' );
					exit( 'Application not configured.' );
				}
				$resource_owner_details_url = $currentapp['resourceownerdetailsurl'];
				$mo_oauth_handler           = new MO_OAuth_Handler();
				MOOAuth_Debug::mo_oauth_log( 'Authorization Response Received' );
				if ( isset( $currentapp['apptype'] ) && 'openidconnect' === $currentapp['apptype'] ) {
					// OpenId connect.
					MOOAuth_Debug::mo_oauth_log( 'OpenId Flow' );

					// If configured Steam application.
					if ( isset( $_REQUEST['openid_op_endpoint'] ) && isset( $_REQUEST['openid_claimed_id'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
						MOOAuth_Debug::mo_oauth_log( 'Applciation selecetd: Steam' );
						$str         = sanitize_text_field( wp_unslash( $_REQUEST['openid_claimed_id'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
						$extract     = ( explode( '/', $str ) );
						$mo_steam_id = $extract[5];

						$access_token_url = $currentapp['accesstokenurl'];
						$client_id        = $currentapp['clientid'];

						$profile_url = $access_token_url . $client_id . '&steamids=' . $mo_steam_id;

						$resource_owner = $mo_oauth_handler->get_resource_owner( $profile_url, '' );
					} else { // Openid flow.
						$code = ! empty( $_GET['code'] ) ? sanitize_text_field( wp_unslash( $_GET['code'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
						if ( ! isset( $currentapp['send_headers'] ) ) {
							$currentapp['send_headers'] = false;
						}
						if ( ! isset( $currentapp['send_body'] ) ) {
							$currentapp['send_body'] = false;
						}
						$token_response = $mo_oauth_handler->get_id_token(
							$currentapp['accesstokenurl'],
							'authorization_code',
							$currentapp['clientid'],
							$currentapp['clientsecret'],
							$code,
							$currentapp['redirecturi'],
							$currentapp['send_headers'],
							$currentapp['send_body']
						);

						$id_token = isset( $token_response['id_token'] ) ? $token_response['id_token'] : $token_response['access_token'];
						MOOAuth_Debug::mo_oauth_log( 'ID Token => ' );
						MOOAuth_Debug::mo_oauth_log( $id_token );
						$resource_owner = $mo_oauth_handler->get_resource_owner_from_id_token( $id_token );
						MOOAuth_Debug::mo_oauth_log( 'Resource Owner Response => ' . wp_json_encode( $resource_owner ) );
					}
				} else {
					MOOAuth_Debug::mo_oauth_log( 'OAuth Flow' );
					$access_token_url = $currentapp['accesstokenurl'];
					if ( ! isset( $currentapp['send_headers'] ) ) {
						$currentapp['send_headers'] = false;
					}
					if ( ! isset( $currentapp['send_body'] ) ) {
						$currentapp['send_body'] = false;
					}

					$access_token = $mo_oauth_handler->get_access_token( $access_token_url, 'authorization_code', $currentapp['clientid'], $currentapp['clientsecret'], sanitize_text_field( wp_unslash( $_GET['code'] ) ), $currentapp['redirecturi'], $currentapp['send_headers'], $currentapp['send_body'] ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.

					if ( ! $access_token ) {
						MOOAuth_Debug::mo_oauth_log( 'Access Token Response => ERROR : Invalid token received.' );
						exit( 'Invalid token received.' );
					}

					if ( substr( $resource_owner_details_url, -1 ) === '=' ) {
						$resource_owner_details_url .= $access_token;
					}
					MOOAuth_Debug::mo_oauth_log( 'Token Response Recieved => ' . $access_token );
					$resource_owner = $mo_oauth_handler->get_resource_owner( $resource_owner_details_url, $access_token );
					MOOAuth_Debug::mo_oauth_log( 'Resource Owner Response => ' );
					MOOAuth_Debug::mo_oauth_log( $resource_owner );
				}

				$username = '';
				$email    = '';
				update_option( 'mo_oauth_attr_name_list', $resource_owner );
				// Test Configuration.
				if ( isset( $_COOKIE['mo_oauth_test'] ) && sanitize_text_field( wp_unslash( $_COOKIE['mo_oauth_test'] ) ) ) {
					setcookie( 'mo_oauth_test', false, time() + 3600, '/', '', true, true );
					echo '<div style="font-family:Calibri;padding:0 3%;color:012970;">';
					echo '<style>table{border-collapse:collapse;color:#012970;}th{background-color: #c6d8f6bd; text-align: center; padding: 8px; border-width:1px; border-style:solid; border-color:#012970;}tr:nth-child(odd) {background-color: #e4eeff;}td{padding:8px;border-width:1px; border-style:solid; border-color:#012970;word-break: break-all;}</style>';
					echo '<h2>' . esc_html__( 'Test Configuration', 'miniorange-login-with-eve-online-google-facebook' ) . '</h2><table><tr><th>' . esc_attr__( 'Attribute Name', 'miniorange-login-with-eve-online-google-facebook' ) . '</th><th>' . esc_attr__( 'Attribute Value', 'miniorange-login-with-eve-online-google-facebook' ) . '</th></tr>';
					mooauth_client_testattrmappingconfig( '', $resource_owner );
					$app = array_values( get_option( 'mo_oauth_apps_list' ) )[0];
					if ( isset( $app['username_attr'] ) ) {
						$username_attr_mapping = $app['username_attr'];
					} else {
						$username_attr_mapping = false;
					}
					echo '</table>';
					echo '<div style="padding: 10px;"></div><input style="padding:7px 12px;width:100px;background: #012970 none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA; inset;color: #FFF;"type="button" value="Done" onClick="self.close();">&emsp;';
					echo '</div>';

					exit();
				}

				if ( ! empty( $username_attr ) ) {
					$username = mooauth_client_getnestedattribute( $resource_owner, $username_attr );
					MOOAuth_Debug::mo_oauth_log( 'Username received.=>' . $username );
				}

				if ( empty( $username ) || '' === $username ) {
					MOOAuth_Debug::mo_oauth_log( 'Username not received. Check your Attribute Mapping configuration.' );
					exit( 'Username not received. Check your <b>Attribute Mapping</b> configuration.' );
				}

				if ( ! empty( $email_attr ) ) {
					$email = mooauth_client_getnestedattribute( $resource_owner, $email_attr );
					MOOAuth_Debug::mo_oauth_log( 'Email received.=>' . $email );
				}
				$user = get_user_by( 'login', $username );
				if ( ! $user && ! empty( $email_attr ) ) {
					$user = get_user_by( 'email', $email );
				}

				if ( $user ) {
					$user_id = $user->ID;

					if ( in_array( 'administrator', $user->roles, true ) ) {
						if ( ! $allow_admin_sso ) {
							MOOAuth_Debug::mo_oauth_log( 'WPO005: Invalid Login attempt. Please login using email and password.' );
							wp_die( 'WPO005: Invalid Login attempt. Please login using email and password.' );
						} else {
							$current_admin_email          = $user->user_email;
							$mo_oauth_email_verify_config = get_option( 'mo_oauth_login_settings_option' );
							$mo_oauth_email_verify_check  = $mo_oauth_email_verify_config['mo_oauth_email_verify_check'];

							if ( strtolower( $current_admin_email ) !== strtolower( $email ) ) {
								MOOAuth_Debug::mo_oauth_log( 'Error : WPO01 Invalid login attempt.' );
								wp_die( 'Error : WPO01 Invalid login attempt.' );
							}

							if ( $mo_oauth_email_verify_check ) {

								$idp_email_verified_key = isset( $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key'] )
								? $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key']
								: 'email_verified';

								$idp_email_verified_value = isset( $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value'] )
								? $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value']
								: '1';

								if ( isset( $resource_owner[ $idp_email_verified_key ] ) ) {
									$email_verified = $resource_owner[ $idp_email_verified_key ];
									if ( (string) $email_verified !== (string) $idp_email_verified_value ) {
										MOOAuth_Debug::mo_oauth_log( 'Error: wpoauth:002 - Email verification failed. Please log in using your WordPress username and password.' );
										wp_die( 'Error: wpoauth:002 - Email verification failed. Please log in using your WordPress username and password.' );
									}
								}
							}
						}
					}

					if ( ! empty( $email_attr ) ) {
						wp_update_user(
							array(
								'ID'         => $user_id,
								'user_email' => $email,
							)
						);
					}
				} else {
					if ( mooauth_migrate_customers() ) {
						$user = mooauth_looped_user( $username );
					} else {
						$user = mooauth_handle_user_registration( $username, $email );
					}
				}
				if ( $user ) {
					wp_set_current_user( $user->ID );
					wp_set_auth_cookie( $user->ID );

					$redirect_to = get_option( 'mo_oauth_redirect_url' );
					if ( has_action( 'mo_hack_login_session_redirect' ) ) {
						$token    = mooauth_gen_rand_str();
						$password = mooauth_gen_rand_str();
						$config   = array(
							'user_id'       => $user->ID,
							'user_password' => $password,
						);
						set_transient( $token, $config );
						do_action( 'mo_hack_login_session_redirect', $user, $password, $token, $redirect_to );
					}
					$user = get_user_by( 'ID', $user->ID );
					do_action( 'wp_login', $user->user_login, $user );
					MOOAuth_Debug::mo_oauth_log( 'User logged in, login cookie setted.' );

					if ( false === $redirect_to ) {
						$redirect_to = home_url();
					}

					wp_safe_redirect( $redirect_to );
					exit;
				}
			} catch ( Exception $e ) {

				// Failed to get the access token or user details.

				MOOAuth_Debug::mo_oauth_log( $e->getMessage() );
				exit( esc_attr( $e->getMessage() ) );

			}
		} else { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			if ( isset( $_REQUEST['error_description'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
				MOOAuth_Debug::mo_oauth_log( 'Authorization Response Recieved => ERROR : ' . sanitize_text_field( wp_unslash( $_REQUEST['error_description'] ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
				exit( esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['error_description'] ) ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			} elseif ( isset( $_REQUEST['error'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
				MOOAuth_Debug::mo_oauth_log( 'Authorization Response Recieved => ERROR : ' . sanitize_text_field( wp_unslash( $_REQUEST['error'] ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
				exit( esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['error'] ) ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			}
			MOOAuth_Debug::mo_oauth_log( 'Authorization Response Recieved => ERROR : Invalid response' );
			exit( 'Invalid response' );
		}
	}
}

/**
 * Handle user registration.
 *
 * @param mixed $username username for the current user.
 * @param mixed $email email for the current user.
 */
function mooauth_handle_user_registration( $username, $email = null ) {
	$random_password = wp_generate_password( 10, false );

	if ( strlen( $username ) > 60 ) {
		MOOAuth_Debug::mo_oauth_log( 'ERROR : The username received has a length greater than 60 characters.' );
		wp_die( 'You are not allowed to login. Please contact your administrator' );
	}

	if ( preg_match( '/[+,\/~!#$%^&*():={}|;">?\/\\\\\/\\\\\']/', $username ) ) {
		MOOAuth_Debug::mo_oauth_log( 'ERROR : The username received has a special character' );
		wp_die( 'You are not allowed to login. Please contact your administrator' );
	}

	$user_create_response = wp_create_user( $username, $random_password, $email );
	if ( is_wp_error( $user_create_response ) ) {
		wp_die( esc_attr( $user_create_response ) );
	}

	$user = get_user_by( 'login', $username );
	wp_update_user( array( 'ID' => $user_create_response ) );
	return $user;
}

/**
 * Handler User registration.
 *
 * @param mixed $temp_var temp var.
 */
function mooauth_looped_user( $temp_var ) {
	return mooauth_looped_redirect( $temp_var );
}

/**
 * Display attribute mapping in Test Configuration.
 *
 * @param mixed  $nestedprefix nested prefix.
 * @param mixed  $resource_owner_details resource owner details of the current user.
 * @param string $tr_class_prefix prefix for tr class.
 */
function mooauth_client_testattrmappingconfig( $nestedprefix, $resource_owner_details, $tr_class_prefix = '' ) {

	$username_value = '';
	foreach ( $resource_owner_details as $key => $resource ) {
		if ( is_array( $resource ) || is_object( $resource ) ) {
			if ( ! empty( $nestedprefix ) ) {
				$nestedprefix .= '.';
			}
			mooauth_client_testattrmappingconfig( $nestedprefix . $key, $resource, $tr_class_prefix );
			$nestedprefix = rtrim( $nestedprefix, '.' );
		} else {
			echo '<tr class="' . esc_attr( $tr_class_prefix ) . 'tr"><td class="' . esc_attr( $tr_class_prefix ) . 'td">';
			if ( ! empty( $nestedprefix ) ) {
				$key = $nestedprefix . '.' . $key;
			}
			echo esc_html( $key ) . '</td><td class="' . esc_attr( $tr_class_prefix ) . 'td">' . esc_html( $resource ) . '</td></tr>';

			$appslist       = get_option( 'mo_oauth_apps_list' );
			$currentapp     = null;
			$currentappname = null;
			if ( is_array( $appslist ) ) {
				foreach ( $appslist as $currentappname => $currentapp ) {
					break;
				}
			}
			if ( strpos( $username_value, 'username' ) === false ) {
				if ( strpos( $key, 'username' ) !== false ) {
					$username_value = $key;
				} elseif ( strpos( $key, 'email' ) !== false && filter_var( $resource, FILTER_VALIDATE_EMAIL ) ) {
					$username_value = $key;
				}
			}
		}
	}

	if ( ! isset( $currentapp['username_attr'] ) && $username_value ) {
		$currentapp['username_attr'] = $username_value;
		$appslist[ $currentappname ] = $currentapp;
		update_option( 'mo_oauth_apps_list', $appslist );
	}
}

/**
 * Get nested attribute.
 *
 * @param mixed $resource resource owner info.
 * @param mixed $key attriubte key.
 */
function mooauth_client_getnestedattribute( $resource, $key ) {
	if ( '' === $key ) {
		return '';
	}

	// Check if the key exists directly in the resource.
	if ( isset( $resource[ $key ] ) ) {
		return $resource[ $key ];
	}

	// Handle nested keys.
	if ( strpos( $key, '.' ) !== false ) {
		$keys        = explode( '.', $key );
		$current_key = array_shift( $keys );

		if ( count( $keys ) > 0 ) {
			if ( isset( $resource[ $current_key ] ) ) {
				return mooauth_client_getnestedattribute( $resource[ $current_key ], implode( '.', $keys ) );
			}
		} else {
			if ( isset( $resource[ $current_key ] ) ) {
				return $resource[ $current_key ];
			}
		}
	}
	return null;
}

/**
 * Handle user registration.
 *
 * @param mixed $ejhi temp var.
 */
function mooauth_looped_redirect( $ejhi ) {
	$user = mooauth_handle_user_registration( $ejhi );
	return $user;
}

/**
 * Get prefix.
 *
 * @param mixed $type type of variable.
 * @return array
 */
function mooauth_client_get_proper_prefix( $type ) {
	$letter = substr( $type, 0, 1 );
	$vowels = array( 'a', 'e', 'i', 'o', 'u' );
	return ( in_array( $letter, $vowels, true ) ) ? ' an ' . $type : ' a ' . $type;
}

/**
 * Register widget.
 */
function mooauth_register_widget() {
	register_widget( 'mooauth_widget' );
}

/**
 * Check if DOING_AJAX is defined.
 */
function mooauth_client_is_ajax_request() {
	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

/**
 * Valid html
 *
 * Helper function for escaping.
 *
 * @param array $args HTML to add to valid args.
 *
 * @return array valid html.
 **/
function mo_oauth_get_valid_html( $args = array() ) {
	$retval = array(
		'strong' => array(),
		'em'     => array(),
		'b'      => array(),
		'i'      => array(),
		'a'      => array(
			'href'   => array(),
			'target' => array(),
		),
	);
	if ( ! empty( $args ) ) {
		return array_merge( $args, $retval );
	}
	return $retval;
}

/**
 * Check for REST API call.
 *
 * @return [type]
 */
function mooauth_client_is_rest_api_call() {
	return ! empty( $_SERVER['REQUEST_URI'] ) ? strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), '/wp-json' ) === false : '';
}

/**
 * Generate random string.
 *
 * @param int $length length of the string to be generated.
 * @return string
 */
function mooauth_gen_rand_str( $length = 10 ) {
	$characters        = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characters_length = strlen( $characters );
	$random_string     = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$random_string .= $characters[ wp_rand( 0, $characters_length - 1 ) ];
	}
	return $random_string;
}

	add_action( 'widgets_init', 'mooauth_register_widget' );
	add_action( 'init', 'mooauth_login_validate' );

/**
 * Get client IP address
 *
 * @return string Client IP address
 */
function mooauth_get_client_ip() {
	$ipaddress = '';
	if ( getenv( 'HTTP_CLIENT_IP' ) ) {
		$ipaddress = getenv( 'HTTP_CLIENT_IP' );
	} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
		$ipaddress = getenv( 'HTTP_X_FORWARDED_FOR' );
	} elseif ( getenv( 'HTTP_X_FORWARDED' ) ) {
		$ipaddress = getenv( 'HTTP_X_FORWARDED' );
	} elseif ( getenv( 'HTTP_FORWARDED_FOR' ) ) {
		$ipaddress = getenv( 'HTTP_FORWARDED_FOR' );
	} elseif ( getenv( 'HTTP_FORWARDED' ) ) {
		$ipaddress = getenv( 'HTTP_FORWARDED' );
	} elseif ( getenv( 'REMOTE_ADDR' ) ) {
		$ipaddress = getenv( 'REMOTE_ADDR' );
	} else {
		$ipaddress = 'UNKNOWN';
	}
	return $ipaddress;
}

/**
 * Validate OAuth state parameter
 * Expected format: appname|timestamp|ip_hmac
 *
 * @param string $state_encoded Base64 encoded state parameter.
 * @return array Decoded state data or wp_die() if invalid
 */
function mooauth_validate_state( $state_encoded ) {
	$state_string = base64_decode( $state_encoded ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Base64 decode will be required for fetching appname from state.

	if ( ! $state_string ) {
		MOOAuth_Debug::mo_oauth_log( 'ERROR : Invalid state parameter format.' );
		wp_die( 'Authentication failed. Please try again.' );
	}

	$state_parts = explode( '|', $state_string );

	if ( count( $state_parts ) !== 4 ) {
		MOOAuth_Debug::mo_oauth_log( 'ERROR : Invalid state parameter structure.' );
		wp_die( 'Authentication failed. Please try again.' );
	}

	$appname                  = $state_parts[0];
	$timestamp                = $state_parts[1];
	$ip_hmac                  = $state_parts[2];
	$state_nonce_hmac_request = $state_parts[3];

	$hmac_secret = wp_salt( 'auth' );

	$current_time = time();
	$state_time   = intval( $timestamp );
	$time_diff    = $current_time - $state_time;

	if ( $time_diff > 300 ) { // 5 minutes = 300 seconds
		MOOAuth_Debug::mo_oauth_log( 'ERROR : State parameter expired. Time difference: ' . $time_diff . ' seconds.' );
		wp_die( 'Authentication failed. Please try again.' );
	}

	$timestamp_hmac = hash_hmac( 'sha256', $timestamp, $hmac_secret );
	$cookie_name    = 'mo_oauth_sso_state';
	$cookie_state   = sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ?? '' ) );
	$current_ip     = mooauth_get_client_ip();
	if ( ! empty( $cookie_state ) ) {
		$state_string            = base64_decode( $cookie_state ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Base64 decode will be required for fetching appname from state.
		$state_parts             = explode( '|', $state_string );
		$state_nonce_cookie      = $state_parts[3];
		$state_nonce_hmac_cookie = hash_hmac( 'sha256', $state_nonce_cookie, $timestamp_hmac );
		if ( $state_nonce_hmac_request !== $state_nonce_hmac_cookie ) {
			MOOAuth_Debug::mo_oauth_log( 'ERROR : State parameter mismatch. Expected: ' . $cookie_state . ', Got: ' . $state_encoded );
			wp_die( 'Authentication failed. Please try again.' );
		}
	} else {
		$current_ip_hmac = hash_hmac( 'sha256', $current_ip, $timestamp_hmac );

		if ( $current_ip_hmac !== $ip_hmac ) {
			MOOAuth_Debug::mo_oauth_log( 'ERROR : IP address mismatch. Expected: ' . $ip_hmac . ', Got: ' . $current_ip_hmac );
			wp_die( 'Authentication failed. Please try again.' );
		}
	}
	return array(
		'appname'   => $appname,
		'timestamp' => $state_time,
		'ip'        => $current_ip,
	);
}
?>
