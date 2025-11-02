<?php
/**
 * App
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Adding required files
 */
require_once 'defaultapps.php';

/**
 * Display Apps list configured in the plugin
 */
function mooauth_client_applist_page() { ?>
	<style>
		.tableborder {
			border-collapse: collapse;
			width: 100%;
			border-color:#eee;
		}

		.tableborder th, .tableborder td {
			text-align: left;
			padding: 8px;
			border-color:#eee;
		}

		.tableborder tr:nth-child(even){background-color: #f2f2f2}
	</style>
	<div id="mo_oauth_app_list" class="mo_table_layout mo_oauth_outer_div">
	<?php

	if ( isset( $_GET['action'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
		switch ( sanitize_text_field( wp_unslash( $_GET['action'] ) ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			case 'delete':
				if ( isset( $_GET['app'] ) && check_admin_referer( 'mo_oauth_delete_' . sanitize_text_field( wp_unslash( $_GET['app'] ) ) ) ) {
					$app = sanitize_text_field( wp_unslash( $_GET['app'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
					mooauth_client_delete_app( $app );
					if ( 'CognitoApp' === $app ) {
						?>
							<script>
								let url = window.location.href;
								url = url.split("&action=delete&app=CognitoApp")[0];
								window.location.replace(url);
							</script>
						<?php
						exit();
					}
				}
				mooauth_client_get_app_list();
				break;
			case 'discard':
				if ( check_admin_referer( 'mo_oauth_discard' ) ) {
					delete_option( 'mo_oauth_setup_wizard_app' );
					delete_option( 'mo_oauth_apps_list' );
				}
				mooauth_client_get_app_list();
				break;
			case 'update':
				if ( isset( $_GET['app'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
					MO_OAuth_Client_Apps::update_app( sanitize_text_field( wp_unslash( $_GET['app'] ) ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
				}
				break;
		}
	} else {
		mooauth_client_get_app_list();
	}
	?>
		</div>
	<?php
}

/**
 * Fetch Apps configured from backend
 */
function mooauth_client_get_app_list() {

	/* migration from premium plugin */
	if ( get_option( 'mo_oauth_apps_list' ) ) {
		foreach ( get_option( 'mo_oauth_apps_list' ) as $key => $app ) {
			if ( is_object( $app ) ) {
				delete_option( 'mo_oauth_apps_list' );
				break;
			}
		}
	}

	if ( get_option( 'mo_oauth_apps_list' ) || get_option( 'mo_oauth_setup_wizard_app' ) ) {
		$appslist = get_option( 'mo_oauth_apps_list' );

		if ( ( is_array( $appslist ) && count( $appslist ) > 0 ) || get_option( 'mo_oauth_setup_wizard_app' ) ) {
			echo "<a><button class='button button-primary button-large mo_oauth_disabled_btn' disabled'>Add Application</button></a>";
		} else {
			echo "<br><a href='admin.php?page=mo_oauth_settings&action=add'><button style='float:right'>" . esc_html__( 'Add Application', 'miniorange-login-with-eve-online-google-facebook' ) . '</button></a>';
		}
		echo "<h3 class='mo_app_heading' style='font-size:23px'>" . esc_html__( 'Applications List', 'miniorange-login-with-eve-online-google-facebook' ) . "</h3><hr class='mo-divider'></br>";
		if ( ( is_array( $appslist ) && count( $appslist ) > 0 ) || get_option( 'mo_oauth_setup_wizard_app' ) ) {
			echo "<p class='mo_oauth_upgrade_warning'>" . esc_html__( 'You can only add 1 application with free version. Upgrade to', 'miniorange-login-with-eve-online-google-facebook' ) . " <a href='" . esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ) . "' target='_blank'><b>enterprise</b></a> " . esc_html__( 'to add more.', 'miniorange-login-with-eve-online-google-facebook' ) . '</p>';
		}
		echo '<table class="mo_oauth_app_list" height="auto" width="100%" align="center"
			style="border-spacing: 30px 10px; font-size: 13px;">';
		echo '<tr><th>' . esc_html__( 'App Name', 'miniorange-login-with-eve-online-google-facebook' ) . '</th><th>' . esc_html__( 'SSO Protocol', 'miniorange-login-with-eve-online-google-facebook' ) . '</th><th>' . esc_html__( 'Action', 'miniorange-login-with-eve-online-google-facebook' ) . '</th></tr>';
		if ( get_option( 'mo_oauth_setup_wizard_app' ) ) {
			$app = json_decode( get_option( 'mo_oauth_setup_wizard_app' ) );
			echo "<tr><td style='background: #f2f2f2;text-transform: none;'>" . esc_html( $app->mo_oauth_app_name ) . " </td><td style='background: #f2f2f2;text-transform: none;'>" . esc_html( $app->mo_oauth_type ) . " </td><td class='mo_oauth_tooltip'><a href='" . esc_attr( admin_url( 'admin.php?option=mo_oauth_client_setup_wizard' ) ) . "'><button class='mo_oauth_instruction'>" . esc_html__( 'Continue Setup', 'miniorange-login-with-eve-online-google-facebook' ) . "</button></a> <span class='mo_oauth_warning_tooltiptext'>(Your application setup is not yet completed)</span> </td><td> <a href='" . esc_url( wp_nonce_url( 'admin.php?page=mo_oauth_settings&tab=config&action=discard', 'mo_oauth_discard' ) ) . "'><button class='mo_oauth_instruction'>" . esc_html__( 'Discard Draft', 'miniorange-login-with-eve-online-google-facebook' ) . '</button></a></td><tr>';
		} else {
			foreach ( $appslist as $key => $app ) {
				$currentapp = $app;
				echo '<tr style="text-align: center; vertical-align: middle;"><td id="mo_oauth_app_nameid" style="background: #f2f2f2;text-transform: none;">' . esc_html( $key ), ' </td><td style="background: #f2f2f2;text-transform: none;">' . esc_html( $currentapp['apptype'] ) . '</td><td><div class="mo_oauth_dropdown">
					<button class="mo_oauth_dropbtn">Select an Action | &nbsp;<i class="mo_oauth_arrow_down"></i></button>
					<div class="mo_oauth_dropdown-content">
					  <a href="admin.php?page=mo_oauth_settings&tab=config&action=update&app=' . esc_attr( $key ) . '">' . esc_html__( 'Edit Application', 'miniorange-login-with-eve-online-google-facebook' ) . '</a>
					  <a href="" onclick="return mooauth_testConfiguration();">' . esc_html__( 'Test SSO Config', 'miniorange-login-with-eve-online-google-facebook' ) . '</a>
					  <a href="admin.php?page=mo_oauth_settings&tab=attributemapping&app=' . esc_attr( $key ) . '#attribute-mapping">' . esc_html__( 'Attribute Mapping', 'miniorange-login-with-eve-online-google-facebook' ) . '</a>
					  <a onclick="return confirm(\'Are you sure you want to delete this Application?\')" href="' . esc_url( wp_nonce_url( 'admin.php?page=mo_oauth_settings&tab=config&action=delete&app=' . esc_attr( $key ), 'mo_oauth_delete_' . esc_attr( $key ) ) ) . '">' . esc_html__( 'Delete', 'miniorange-login-with-eve-online-google-facebook' ) . '</a>
					</div>
				  	</div><td> ';
				?>
					<script>
						function mooauth_testConfiguration(){
							var mo_oauth_app_name = jQuery("#mo_oauth_app_nameid").html();
							var myWindow = window.open('<?php echo esc_attr( site_url() ); ?>' + '/?option=testattrmappingconfig&app='+mo_oauth_app_name, "Test Attribute Configuration", "width=600, height=600");
							}
					</script>
					<?php
					$current_app_id = $currentapp['appId'];
					$refapp         = mooauth_client_get_app( $current_app_id );
					$ref_app_id     = array( 'other', 'openidconnect' );
					$tempappname    = ! in_array( $currentapp['appId'], $ref_app_id, true ) ? $currentapp['appId'] : 'customApp';
					$app            = mooauth_client_get_app( $tempappname );
					if ( isset( $app->guide ) ) {
						echo "<a class='mo_oauth_instruction_btn' href='" . esc_attr( $app->guide ) . "' target='_blank' rel='noopener'><button class='mo_oauth_instruction'><img class='mo_oauth_how_2_config' src='" . esc_attr( dirname( plugin_dir_url( __FILE__ ) ) ) . "/images/settings.png'/>" . esc_html__( 'How to Configure?', 'miniorange-login-with-eve-online-google-facebook' ) . '</button></a></td></tr>';
					}
			}
		}
			echo '</table>';
			echo '<br><br>';

	} else {
		if ( get_option( 'mo_oauth_setup_wizard_app' ) ) {
			$app = json_decode( get_option( 'mo_oauth_setup_wizard_app' ) );
			echo '';
		} else {
			echo '<center><div style="margin:5% 5% 5% 5%;">
					<h4 class="mo_oauth_contact_heading">
						Add new client application to implement Single Sign On into your website
					</h4>
	                <button class="button button-primary mo_oauth_configure_btn" id="mo-oauth-continue-setup">Add New Application</button>
                </div><center>
                <script>
                	jQuery("#mo-oauth-continue-setup").click(function(){
                		window.location.href = "' . esc_attr( admin_url( 'admin.php?option=mo_oauth_client_setup_wizard' ) ) . '";
                	});
                </script>';
		}
	}
}

/**
 * Delete a configured app.
 *
 * @param mixed $appname appname to be deleted.
 */
function mooauth_client_delete_app( $appname ) {
	$appslist = get_option( 'mo_oauth_apps_list' );
	if ( ! is_array( $appslist ) || empty( $appslist ) ) {
		return;
	}
	foreach ( $appslist as $key => $app ) {
		if ( $appname === $key ) {
			if ( 'wso2' === $appslist[ $appname ]['appId'] ) {
				delete_option( 'mo_oauth_client_custom_token_endpoint_no_csecret' );
			}
			unset( $appslist[ $key ] );
			delete_option( 'mo_oauth_client_disable_authorization_header' );
			delete_option( 'mo_oauth_attr_name_list' );
			delete_option( 'mo_oauth_apps_list' );
			$notices = get_option( 'mo_oauth_client_notice_messages' );
			if ( isset( $notices['attr_mapp_notice'] ) ) {
				unset( $notices['attr_mapp_notice'] );
				update_option( 'mo_oauth_client_notice_messages', $notices );
			}
		}
	}
	update_option( 'mo_oauth_apps_list', $appslist );
	?>
		<script>
			window.location.href = "<?php echo esc_attr( admin_url( 'admin.php?page=mo_oauth_settings&tab=config' ) ); ?>";
		</script>
		<?php
}
