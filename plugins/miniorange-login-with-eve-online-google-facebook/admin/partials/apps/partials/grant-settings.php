<?php
/**
 * Grant Settings
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display Grant Settings
 */
function mooauth_client_grant_type_settings() {
	?>
	</div>
	<div class="mo_table_layout mo_oauth_contact_heading mo_oauth_outer_div" id="mo_grant_settings" style="position: relative;">
	<div class="mo_oauth_customization_header"><div class="mo_oauth_attribute_map_heading" style="display: inline;"><b class="mo_oauth_position"><?php esc_html_e( 'Grant Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?></b> <small><div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_oauth_tooltiptext"  >PREMIUM</span><a href="<?php echo esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ); ?>" target="_blank" rel="noopener noreferrer"><span style="border:none"><img class="mo_oauth_premium-label" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_premium-label.png" alt="miniOrange Premium Plans Logo"></span></a></div></small></div>
	<div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_tooltiptext"  >Know how this is useful</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/multiple-grant-support" rel="noopener noreferrer">
		<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_info-icon.png" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a></div></div>
		<div class="grant_types mo_oauth_grant_setting ">
			<h4><?php esc_html_e( 'Select Grant Type:', 'miniorange-login-with-eve-online-google-facebook' ); ?></h4>
			<input checked disabled type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled">&emsp;<strong class="mo_strong"><?php esc_html_e( 'Authorization Code Grant', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>&emsp;<code style="background-color: #e4eeff; border-radius:5px;"><small>DEFAULT</small></code>
			<blockquote class="mo_oauth_blackquote">
				<?php esc_html_e( 'The Authorization Code grant type is used by web and mobile apps.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
				<?php esc_html_e( 'It requires the client to exchange authorization code with access token from the server. ', 'miniorange-login-with-eve-online-google-facebook' ); ?>
				<small>(<?php esc_html_e( 'If you have doubt on which settings to use, you can leave this checked and disable all others.', 'miniorange-login-with-eve-online-google-facebook' ); ?>)</small>
			</blockquote>
			<input disabled type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled">&emsp;<strong class="mo_strong"><?php esc_html_e( 'Implicit Grant', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
			<blockquote class="mo_oauth_blackquote">
				<?php esc_html_e( 'The Implicit grant type is a simplified version of the Authorization Code Grant flow. ', 'miniorange-login-with-eve-online-google-facebook' ); ?><?php esc_html_e( 'OAuth providers directly offer access token when using this grant type.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			</blockquote>
			<input disabled type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled">&emsp;<strong class="mo_strong"><?php esc_html_e( 'Password Grant', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
			<blockquote class="mo_oauth_blackquote">
				<?php esc_html_e( 'Password grant is used by application to exchange user\'s credentials for access token. ', 'miniorange-login-with-eve-online-google-facebook' ); ?>
				<?php esc_html_e( 'This, generally, should be used by internal applications.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			</blockquote>
			<input disabled type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled">&emsp;<strong class="mo_strong"><?php esc_html_e( 'Refresh Token Grant', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
			<blockquote class="mo_oauth_blackquote">
				<?php esc_html_e( 'The Refresh Token grant type is used by clients.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
				<?php esc_html_e( 'This can help in keeping user session persistent.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			</blockquote>
		</div>
		<hr>
		<div class="mo_oauth_customization_header"><div class="mo_oauth_attribute_map_heading" style="display: inline;"><b class="mo_oauth_position"><?php esc_html_e( 'JWT Validation & PKCE', 'miniorange-login-with-eve-online-google-facebook' ); ?></b> <small><div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_oauth_tooltiptext"  >ENTERPRISE</span><a href="<?php echo esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ); ?>" target="_blank" rel="noopener noreferrer"><span style="border:none"><img class="mo_oauth_premium-label" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_premium-label.png" alt="miniOrange Premium Plans Logo"></span></a></div></small></div>
	<div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_tooltiptext"  >Know how this is useful</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/multiple-grant-support#configure-pkce-flow" rel="noopener noreferrer">
		<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_info-icon.png" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a></div></div>
				<div>
					<table class="mo_settings_table mo_oauth_grant_setting">
						<tr>
							<td><strong class="mo_strong"><?php esc_html_e( 'Enable JWT Verification:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong></td>
							<td><input type="checkbox" class="mo_input_checkbox" value="" disabled/></td>
						</tr>
						<tr>
							<td><strong class="mo_strong"><?php esc_html_e( 'JWT Signing Algorithm:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong></td>
							<td><select disabled>
									<option>HSA</option>
									<option>RSA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td><strong class="mo_strong"><?php esc_html_e( 'PKCE (Proof Key for Code Exchange):', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong></td>
							<td><input id="pkce_flow" type="checkbox" class="mo_input_checkbox" name="pkce_flow" value="0" disabled/></td>
						</tr>
					</table>
					<p class="mo_oauth_upgrade_warning" style="font-size:12px"><strong class="mo_strong">*NOTE: </strong><?php esc_html_e( 'PKCE can be used with Authorization Code Grant and users aren\'t required to provide a client_secret.', 'miniorange-login-with-eve-online-google-facebook' ); ?></p>
				</div>
			<br><br>
		<div class="notes">
			<hr />
			<?php esc_html_e( 'Grant Type Settings and JWT Validation & PKCE are configurable in ', 'miniorange-login-with-eve-online-google-facebook' ); ?><a href="<?php echo esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ); ?>" target="_blank" rel="noopener noreferrer">premium and enterprise</a><?php esc_html_e( ' versions of the plugin.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</div>
	</div>
	<div>
	<?php
}
