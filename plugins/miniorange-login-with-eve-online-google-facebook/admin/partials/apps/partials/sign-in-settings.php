<?php
/**
 * Sign in Settings
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display Sign in Settings UI
 */
function mooauth_client_sign_in_settings_ui() {
	$mo_oauth_email_verify_config = get_option( 'mo_oauth_login_settings_option' );
	$mo_oauth_email_verify_check  = $mo_oauth_email_verify_config['mo_oauth_email_verify_check'];
	$mo_oauth_email_verify_key    = $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_key'];
	$mo_oauth_email_verify_value  = $mo_oauth_email_verify_config['mo_oauth_idp_email_verified_value'];
	?>
<div  id="wid-shortcode" class="mo_table_layout mo_oauth_attribute_page_font mo_oauth_outer_div">
<div class="mo_oauth_customization_header"><div class="mo_oauth_attribute_map_heading" style="display: inline;"><b class="mo_oauth_position"><?php esc_html_e( 'Sign in options', 'miniorange-login-with-eve-online-google-facebook' ); ?></b></div><div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_tooltiptext"  >Know how this is useful</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/login-options" rel="noopener noreferrer">
		<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_info-icon.png" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a></div></div>
	<h4><?php esc_html_e( 'Option 1: Use a Widget', 'miniorange-login-with-eve-online-google-facebook' ); ?></h4>
	<ol>
		<li><?php esc_html_e( 'Go to Appearances > Widgets.', 'miniorange-login-with-eve-online-google-facebook' ); ?></li>
		<li>Select <b>"<?php echo esc_attr( MO_OAUTH_ADMIN_MENU ); ?>"</b>.
			<?php esc_html_e( 'Drag and drop to your favourite location and save.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</li>
	</ol>

	<h4><?php esc_html_e( 'Option 2: Use a Shortcode', 'miniorange-login-with-eve-online-google-facebook' ); ?> <small><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext"  >STANDARD</span><a href="https://developers.miniorange.com/docs/oauth/wordpress/client/login-options" target="_blank"
				rel="noopener noreferrer"><span><i class="fa fa-info-circle mo_oauth_info"></i></span></a></div></small></h4>
	<ul>
		<li><?php esc_html_e( 'Place shortcode', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			<b>[mo_oauth_login]</b>
			<?php esc_html_e( 'in WordPress pages or posts.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</li>
	</ul>
</div>

<div  id="wid-shortcode" class="mo_table_layout mo_oauth_attribute_page_font mo_oauth_outer_div">
	<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings&tab=signinsettings">
		<?php wp_nonce_field( 'mo_oauth_email_verified_form', 'mo_oauth_email_verified_form_field' ); ?>
		<input type="hidden" name="option" value="mo_oauth_email_verified" />
		<table class="mo_settings_table mo_oauth_client_mapping_table">
			<tbody>
			<tr class="mo_oauth_configure_table_rows">
				<td>
				<div>
				<h3 class="mo_oauth_attribute_map_heading" style="font-size:18px;">
				<?php esc_html_e( 'Advance Security Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?></h3></div>
				</td>
			</tr>
			<tr>
			<td  style="font-size:14px;width:70%">
			<span>
				<?php esc_html_e( 'Allow login to Verified IDP Account', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			</span>
			<br>
			<?php esc_html_e( '( Allow login only to admin users who have the field below marked as verified. )', 'miniorange-login-with-eve-online-google-facebook' ); ?>
			</td>
			<td class="mo_oauth_contact_heading">
			<input type="checkbox" name="mo_oauth_email_verify_check" class="mo_input_checkbox" id="email-verified-checkbox" value ="true" 
				<?php
				if ( isset( $mo_oauth_email_verify_check ) ) {
					if ( 'true' === $mo_oauth_email_verify_check ) {
						echo 'checked';
					}
				};
				?>
				/>
			</td>
		</tr>
			</tbody></table>
			<table class="mo_settings_table mo_oauth_configure_table mo_oauth_client_mapping_table"> <tbody>
		<tr id="email-verified-keys-row" style="display:none;">
		<td >
			<label for="email-input1"><?php esc_html_e( 'Key', 'miniorange-login-with-eve-online-google-facebook' ); ?></label>
			</td> <td>
			<input 
	class="mo_oauth_input" 
	name="mo_oauth_idp_email_verified_key" 
	type="text" 
	style="width:50%;" 
	placeholder="Enter the attribute Key to be verified" 
	value="<?php echo isset( $mo_oauth_email_verify_key ) ? esc_attr( $mo_oauth_email_verify_key ) : ''; ?>" 
/>

			</td>
		</tr>
		<tr id="email-verified-values-row" style="display:none;">
		<td>
			<label for="email-input2"><?php esc_html_e( 'Value', 'miniorange-login-with-eve-online-google-facebook' ); ?></label> </td> <td>
			<input 
	name="mo_oauth_idp_email_verified_value" 
	class="mo_oauth_input" 
	type="text" 
	style="width:50%;" 
	placeholder="Enter the attribute Value to be verified" 
	value="<?php echo isset( $mo_oauth_email_verify_value ) ? esc_attr( $mo_oauth_email_verify_value ) : ''; ?>" 
/>

		</td>
		</tr>
		<script>
				document.addEventListener('DOMContentLoaded', function () {
				var checkbox = document.getElementById('email-verified-checkbox');
				var keysRow = document.getElementById('email-verified-keys-row');
				var valuesRow = document.getElementById('email-verified-values-row');

				// Function to toggle the visibility of the rows based on the checkbox state
				function toggleRows() {
					if (checkbox.checked) {
						keysRow.style.display = 'table-row';
						valuesRow.style.display = 'table-row';
					} else {
						keysRow.style.display = 'none';
						valuesRow.style.display = 'none';
					}
				}

				// Add event listener for change event on the checkbox
				checkbox.addEventListener('change', toggleRows);

				// Ensure the rows are displayed/hidden correctly when the page loads
				toggleRows();
			});
		</script>
		<tr>
			<td>
				<input type="submit" class="button button-primary button-large" value="<?php esc_html_e( 'Save Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>">
			</td>
			<td>&nbsp;</td>
		</tr>
		</tbody>
	</table>
	</form>
</div>
</div>


<div id="advanced_settings_sso" class="mo_table_layout mo_oauth_outer_div">
	<form id="signing_setting_form" name="f" method="post" action="">
		<?php wp_nonce_field( 'mo_oauth_role_mapping_form_nonce', 'mo_oauth_role_mapping_form_field' ); ?>
		<div class="mo_oauth_customization_header" style="border:none;"><div class="mo_oauth_attribute_map_heading" style="display: inline;">
							<?php esc_html_e( 'WordPress User Profile Sync-up Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?></div><div class="mo_oauth_tooltip mo_oauth_tooltip_float_right"><span class="mo_tooltiptext"  >About Auto Create Users</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/auto-register-users" rel="noopener noreferrer">
							<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/mo_oauth_info-icon.png" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a></div>
						</div>
		<table class="mo_oauth_client_mapping_table" style="width:90%; border-collapse: collapse; line-height:200%">
			<tbody>
				<tr>
					<td>
						<font style="font: size 14px;">
							<?php esc_html_e( 'Auto register Users', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font>  <small><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >STANDARD</span><a
							href="https://developers.miniorange.com/docs/oauth/wordpress/client/auto-register-users"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small>
							<br><?php esc_html_e( '(If unchecked, only existing users will be able to log-in)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled" checked></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Keep Existing Users', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >PREMIUM</span> <a href="https://developers.miniorange.com/docs/oauth/wordpress/client/account-linking#keep-existing-users"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small><br><?php esc_html_e( '(If checked, existing users\' attributes will NOT be overwritten when they log-in)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Keep Existing Email Attribute', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >PREMIUM</span> <a href="https://developers.miniorange.com/docs/oauth/wordpress/client/account-linking#keep-existing-email-attr"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small><br><?php esc_html_e( '(If checked, existing users\' only email attribute will NOT be overwritten when they log-in)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr class="mo-divider">
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<h3 class="mo_oauth_signing_heading" style="font-size:18px;">
							<?php esc_html_e( 'Login Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Custom redirect URL after login', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >STANDARD</span><a
							href="https://developers.miniorange.com/docs/oauth/wordpress/client/custom-redirection#post-login-redirection"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small><br><?php esc_html_e( '(Keep blank in case you want users to redirect to page from where SSO originated)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" class="mo_oauth_input_disabled" type="text" style="width:100%;"></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Hide & Disable WP Login / Block WordPress Login', 'miniorange-login-with-eve-online-google-facebook' ); ?>
							</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >ENTERPRISE</span><a
							href="https://developers.miniorange.com/docs/oauth/wordpress/client/hide-and-disable"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small><br><?php esc_html_e( '(Keep blank in case you want users to redirect to page from where SSO originated)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr class="mo-divider">
					<td>&nbsp;</td>

				</tr>
				<tr>
					<td>
						<h3 class="mo_oauth_signing_heading" style="font-size:18px;">
							<?php esc_html_e( 'Logout Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Custom redirect URL after logout', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >STANDARD</span><a
							href="https://developers.miniorange.com/docs/oauth/wordpress/client/custom-redirection#post-logout-redirection"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small>
					</td>
					<td><input disabled="true" class="mo_oauth_input_disabled" type="text" style="width:100%;"></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Confirm when logging out', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font>	<small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >STANDARD</span>
						<i class="fa fa-info-circle mo_oauth_info"></i></div></small><br><?php esc_html_e( '(If checked, users will be ASKED to confirm if they want to log-out, when they click the widget/shortcode logout button)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr class="mo-divider">
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<h3 class="mo_oauth_signing_heading" style="font-size:18px;">
							<?php esc_html_e( 'WordPress Site Access Control (Security Settings)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Restrict site to logged in users', 'miniorange-login-with-eve-online-google-facebook' ); ?>
							<small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >PREMIUM</span><a href="https://developers.miniorange.com/docs/oauth/wordpress/client/forced-authentication"
								target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a>
								</div></small>
						</font>
						<br><?php esc_html_e( '(Users will be auto redirected to OAuth login if not logged in)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Allowed Domains / Whitelisted Domains', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font> <small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >PREMIUM</span><a href="https://developers.miniorange.com/docs/oauth/wordpress/client/domain-restriction"
								target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a>
								</div></small><br>(Comma separated domains ex.
						domain1.com,domain2.com etc)</p>
					</td>
					<td><input disabled="true" class="mo_oauth_input_disabled" type="text" placeholder="domain1.com,domain2.com" style="width:100%;">
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Restricted Domains / Blacklisted Domains', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font> <small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >PREMIUM</span><a href="https://developers.miniorange.com/docs/oauth/wordpress/client/domain-restriction"
								target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a>
								</div></small><br>(Comma separated domains ex.
						domain1.com,domain2.com etc)</p>
					</td>
					<td><input disabled="true" class="mo_oauth_input_disabled" type="text" placeholder="domain1.com,domain2.com" style="width:100%;">
					</td>
				</tr>
				<tr class="mo-divider">
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<h3 class="mo_oauth_signing_heading" style="font-size:18px;">
							<?php esc_html_e( 'SSO Window Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Open login window in Popup', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >STANDARD</span><a
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small>
								<br><?php esc_html_e( '(Keep blank in case you want users to redirect to page from where SSO originated)', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Enable Single Login Flow', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >ENTERPRISE</span><a
							href="https://developers.miniorange.com/docs/oauth/wordpress/client/enable-single-sign-in-flow"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a></div></small>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr class="mo-divider">
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<h3 class="mo_oauth_signing_heading" style="font-size:18px;">
							<?php esc_html_e( 'User Login Audit / Login Reports', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<font style="font-size:14px;">
							<?php esc_html_e( 'Enable User login reports', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</font><small class=""><div class="mo_oauth_tooltip"  ><span class="mo_oauth_tooltiptext mo_oauth_extra_tooltip"  >ENTERPRISE</span><a href="https://developers.miniorange.com/docs/oauth/wordpress/client/user-analytics"
							target="_blank" rel="noopener"><i class="fa fa-info-circle mo_oauth_info"></i></a> 
							</div></small></p>
					</td>
					<td><input disabled="true" type="checkbox" class="mo_input_checkbox mo_oauth_input_disabled"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><input disabled type="submit" class="button button-primary button-large mo_disabled_btn"
							value="<?php esc_html_e( 'Save Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>">
					</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
	<?php
}
