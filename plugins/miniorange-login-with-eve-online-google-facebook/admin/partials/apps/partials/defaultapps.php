<?php
/**
 * Default Apps
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display deafult OAuth/OpenID applications list
 */
function mooauth_client_show_default_apps() { ?>
	<input type="text" id="mo_oauth_client_default_apps_input" onkeyup="mooauth_client_default_apps_input_filter()" placeholder="<?php esc_html_e( 'Select application', 'miniorange-login-with-eve-online-google-facebook' ); ?>" title="Type in a Application Name">

	<h3><?php esc_html_e( 'OAuth / OpenID Connect Providers', 'miniorange-login-with-eve-online-google-facebook' ); ?></h3>
	<hr />
	<h4><?php esc_html_e( 'Pre-Configured Applications', 'miniorange-login-with-eve-online-google-facebook' ); ?>&emsp;<div class="mo-oauth-tooltip">&#x1F6C8;<div class="mo-oauth-tooltip-text mo-tt-right"><?php esc_html_e( 'By selecting pre-configured applications, the configuration would already be half-done!', 'miniorange-login-with-eve-online-google-facebook' ); ?></div> </div></h4>
	<ul id="mo_oauth_client_default_apps">
		<div id="mo_oauth_client_searchable_apps">
		<?php
			$defaultapps = wp_remote_get( plugin_dir_url( __FILE__ ) . 'defaultapps.json' );
			$defaultapps = json_decode( wp_remote_retrieve_body( $defaultapps ) );
			$custom_apps = array();
		foreach ( $defaultapps as $app_id => $application ) {
			if ( 'other' === $app_id || 'openidconnect' === $app_id || 'oauth1' === $app_id ) {
				$custom_apps[ $app_id ] = $application;
				continue;
			}
			echo '<li data-appid="' . esc_attr( $app_id ) . '"><a ' . ( 'cognito' === $app_id ? 'id=vip-default-app' : '' ) . ' href="#"><img class="mo_oauth_client_default_app_icon" src="' . esc_attr( plugins_url( '../images/' . $application->image, __FILE__ ) ) . '"><br>' . esc_html( $application->label ) . '</a></li>';
		}
		?>
		</div>
		<div id="mo_oauth_client_search_res"></div>
		<hr>
		<h4><?php esc_html_e( 'Custom Applications', 'miniorange-login-with-eve-online-google-facebook' ); ?>&emsp;<div class="mo-oauth-tooltip">&#x1F6C8;<div class="mo-oauth-tooltip-text mo-tt-right"><?php esc_html_e( 'Your provider is not in the list? You can select the type of your provider and configure it yourself!', 'miniorange-login-with-eve-online-google-facebook' ); ?></div> </div></h4>
		<div id="mo_oauth_client_custom_apps">
			<?php
			foreach ( $custom_apps as $app_id => $application ) {
				echo '<li data-appid="' . esc_attr( $app_id ) . '"><a href="#"><img class="mo_oauth_client_default_app_icon" src="' . esc_attr( plugins_url( '../images/' . $application->image, __FILE__ ) ) . '"><br>' . esc_html( $application->label ) . '</a></li>';
			}
			?>
		</div>
	</ul>
	<script>

		jQuery("#mo_oauth_client_default_apps li").click(function(){
			var appId = jQuery(this).data("appid");
				window.location.href += "&appId="+appId;
		});

	</script>

<?php }


/**
 * Get details of an app from deafults apps list.
 *
 * @param mixed $current_app_id current app.
 */
function mooauth_client_get_app( $current_app_id ) {
	$defaultapps = wp_json_file_decode( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'defaultapps.json' );
	foreach ( $defaultapps as $app_id => $application ) {
		if ( $app_id === $current_app_id ) {
			$application->appId = $app_id; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- Ignoring camel case because it is not a variable but the key inside JSON file which is in snake case.
			return $application;
		}
	}
	return false;
}
?>
