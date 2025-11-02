<?php
/**
 * Support
 *
 * @package    support
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * [Description Handle Customer Support]
 */
class MO_OAuth_Client_Support {

	/**
	 * Call internal functions
	 */
	public static function support() {
		self::mo_usecase_page();
		self::support_page();
		self::mo_download_log();
	}

	/**
	 * Display Use cases UI
	 */
	public static function mo_usecase_page() {
		$configuredapp              = get_option( 'mo_oauth_apps_list' ) ? array_key_first( get_option( 'mo_oauth_apps_list' ) ) : '';
		$usecasejson                = wp_json_file_decode( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'mo_oauth_usecase.json' );
		$current_usecases           = array();
		$link                       = '';
		$config_app_usecase_present = false;

		foreach ( $usecasejson as $application => $usecase ) {
			if ( $application === $configuredapp ) {
				$current_usecases           = $usecase;
				$config_app_usecase_present = true;
			}
		}
		if ( $config_app_usecase_present ) {?>
		<div id="mo_support_layout" class="mo_support_layout mo_oauth_outer_div">
		<div class="mo_oauth_usecase_discription_container">
				<div class="mo_oauth_usecase_discription_main_card" style="padding:5px 10px;"> 
					<button onclick="mo_oauth_show_usecases()" class="mo_oauth_usecase_discription_title">
					<h2 style="margin:5px;color:#012970;"><u>
					<?php
					echo esc_html( 'Checkout our popular usecases for ' . ucwords( $configuredapp ) );
					?>
					</u>
					</h2>
					<i class="fa fa-chevron-down" style="margin:10px 5px" id="mo_oauth_usecase_down_arrow"></i>
					</button>
					<div id="mo_oauth_usecase" style="display:none" class="mo_oauth_usecase">
					<?php
					foreach ( $current_usecases as $key => $usecase ) {
						?>
						<p>
						<?php
						if ( 'link' !== $key ) {
							echo( '<p class="mo_oauth_usecase_para"><span class="mo_oauth_usecase_tick">✓</span><span class="mo_oauth_usecase_text">' . esc_attr( $usecase ) . '</span><p>' );
						} else {
							$link = $usecase;
						}
						?>
						</p>
						<?php
					}
					?>
					<div class="mo_oauth_usecase_link_container" id="mo_oauth_usecase_link_container">    
					<a class="mo_oauth_instruction_btn" id="mo_oauth_usecase_link" href="<?php echo esc_attr( $link ); ?>" target="_blank"><button class='mo_oauth_instruction mo_oauth_usecase_btn'>KNOW MORE</button></a>
					<a class="mo_oauth_instruction_btn" ><button onclick="mo_oauth_show_usecases()" class='mo_oauth_instruction mo_oauth_usecase_btn'>CLOSE</button></a>
					</div>
				</div>
				</div>
			</div>
				</div>
		<script>
			function mo_oauth_show_usecases(){
				var usecase=document.getElementById("mo_oauth_usecase");
				var arrow=document.getElementById("mo_oauth_usecase_down_arrow");
				if(usecase.style.display==="none"){
					usecase.style.display = "block";
					arrow.style.transform="rotate(180deg)";
				} else {
				usecase.style.display = "none";
				arrow.style.transform="rotate(0deg)";
				} 
			}
		</script>
			<?php
		}
	}

	/**
	 * Display Contact Us Form.
	 */
	public static function support_page() {
		?>
<div id="mo_support_layout" class="mo_support_layout mo_oauth_outer_div">
	<div>
		<h3 class="mo_oauth_contact_heading" >
			<?php esc_html_e( 'Contact Us', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</h3>
		<div style="display: flex;align-items: center;gap:6px;">
			<div><img src=" <?php echo esc_url( plugin_dir_url( __FILE__ ) ) . 'call.png'; ?>">
			</div>
			<div style="font-size:13px;">
				<?php esc_html_e( 'Need any help? Just give us a call at', 'miniorange-login-with-eve-online-google-facebook' ); ?><b class="mo_oauth_contact_heading">
					+1
					978 658 9387</b>
			</div>
		</div>
		<p><?php esc_html_e( 'Couldn\'t find an answer in ', 'miniorange-login-with-eve-online-google-facebook' ); ?><a
				href="https://faq.miniorange.com/kb/oauth-openid-connect" target="_blank">FAQ</a>?<br>
			<?php esc_html_e( 'Just send us a query and we will get back to you soon.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</p>
		<form method="post" action="">
			<?php wp_nonce_field( 'mo_oauth_support_form', 'mo_oauth_support_form_field' ); ?>
			<input type="hidden" name="option" value="mo_oauth_contact_us_query_option" />
	<div class="mo_oauth_contact">
			<table class="mo_settings_table" style="display: none;">
				<input type="email" class="mo_oauth_contact-input-fields" placeholder="Enter your email"
					name="mo_oauth_contact_us_email" id="mo_oauth_contact_us_email" value="<?php echo esc_attr( get_option( 'mo_oauth_admin_email' ) ); ?>"
					required maxlength="254"/>
				<input type="tel" id="contact_us_phone" class="mo_settings_table mo_oauth_contact-input-fields" type="tel" id="contact_us_phone"
					placeholder="Enter your phone number" name="mo_oauth_contact_us_phone"
					value="<?php echo esc_attr( get_option( 'mo_oauth_client_admin_phone' ) ); ?>"
					pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}|[\+]\d{1,4}[\s]" />
				<textarea cols="30" rows="6"
					placeholder="<?php esc_attr_e( 'Enter your query...', 'miniorange-login-with-eve-online-google-facebook' ); ?>"
					name="mo_oauth_contact_us_query" onkeypress="mo_oauth_valid_query(this)"
					onkeyup="mo_oauth_valid_query(this)" rows="4" style="resize: vertical;" onblur="mo_oauth_valid_query(this)" required></textarea>

				<div class="mo_oauth_checkbox-pair">
					<input id="mo_oauth_send_plugin_config" class="mo_oauth_checkbox" type="checkbox" class="mo_input_checkbox"
						name="mo_oauth_send_plugin_config" checked />
					<div class="mo_oauth_checkbox-content">
						<span class="mo_oauth_checkbox-info">
							<?php esc_html_e( 'Send Plugin Configuration', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</span>
						<span class="mo_oauth_checkbox-disclaimer">
							<?php esc_html_e( 'We will not be sending your Client IDs or Client Secrets.', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</span>
					</div>
				</div>
			</table>
				<div class="mo_oauth_setup-call">
					<label class="mo_oauth_switch">
						<input id="oauth_setup_call" type="checkbox" class="mo_input_checkbox" style="background: #dcdad1"
							name="oauth_setup_call" />
						<span class="mo_oauth_slider round"></span>
					</label>
					<p>
						<b>
							<label for="oauth_setup_call"></label>
							<?php esc_html_e( 'Setup a Call/ Screen-share session', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</b>
					</p>

				</div>
				<div id="mo_oauth_setup_call_div">
					<table class="mo_settings_table" cellpadding="2" cellspacing="2">
						<tr>
							<td><strong class="mo_strong">
									<font color="#FF0000">*</font>
									<?php esc_html_e( 'Issue:', 'miniorange-login-with-eve-online-google-facebook' ); ?></td>
							</strong></td>
							<td><select id="issue_dropdown" class="mo_callsetup_table_textbox"
									name="mo_oauth_setup_call_issue">
									<option disabled selected>--------Select Issue type--------</option>
									<option id="sso_setup_issue">SSO Setup Issue</option>
									<option>Custom requirement</option>
									<option id="other_issue">Other</option>
								</select></td>
						</tr>
						<tr id="setup_guide_link" style="display: none;">
							<td colspan="2">
								<?php esc_html_e( 'Have you checked the setup guide ', 'miniorange-login-with-eve-online-google-facebook' ); ?><a
									href="https://plugins.miniorange.com/wordpress-single-sign-on-sso-with-oauth-openid-connect"
									target="_blank">here</a>?</td>
						</tr>
						<tr id="required_mark" style="display: none;">
								<td><strong class="mo_strong"><font color="#FF0000">*</font><?php esc_html_e( 'Description:', 'miniorange-login-with-eve-online-google-facebook' ); ?></td></strong></td>
									<td><textarea id="issue_description" class="mo_oauth_issue_description" onkeypress="mo_oauth_valid_query(this)" placeholder="<?php esc_html_e( 'Enter your issue description here', 'miniorange-login-with-eve-online-google-facebook' ); ?>" onkeyup="mo_oauth_valid_query(this)" onblur="mo_oauth_valid_query(this)" name="mo_oauth_issue_description" rows="2" style="resize: vertical;"></textarea></td>								
						</tr>
						<tr>
							<td><strong class="mo_strong">
									<font color="#FF0000">*</font>
									<?php esc_html_e( 'Date:', 'miniorange-login-with-eve-online-google-facebook' ); ?></td>
							</strong></td>
							<td><input class="mo_callsetup_table_textbox" name="mo_oauth_setup_call_date" type="text"
									id="calldate"></td>
						</tr>
						<tr>
							<td><strong class="mo_strong">
									<font color="#FF0000">*</font>
									<?php esc_html_e( 'Local Time:', 'miniorange-login-with-eve-online-google-facebook' ); ?>
							</td></strong></td>
							<td><input class="mo_callsetup_table_textbox" name="mo_oauth_setup_call_time" type="time"
									id="mo_oauth_setup_call_time"></td>
						</tr>
					</table>
					<p><?php esc_html_e( 'We are available from 3:30 to 18:30 UTC', 'miniorange-login-with-eve-online-google-facebook' ); ?>
					</p>
					<input type="hidden" name="mo_oauth_time_diff" id="mo_oauth_time_diff">
				</div>
				<div>
					<input type="submit" name="submit" class="mo_submit-btn"value="Submit" />
				</div>
			</div>
		</form>
	</div>
</div>


		<?php
	}

	/**
	 * Download Debug Logs
	 */
	public static function mo_download_log() {
		?>

<div class="mo_enable_logs_wrapper mo_support_layout mo_oauth_outer_div">
	<div class="mo_oauth_support_layout mo_enable_logs">
		<div class="mo_debug">
		<div class="mo_oauth_setup-call">
		<form id="mo_oauth_enable_debug_log_form" method="post">
			<input type="hidden" name="option" value="mo_oauth_reset_debug" />
				<?php wp_nonce_field( 'mo-oauth-Debug-logs-unique-string-nonce', 'mo_oauth_reset_debug' ); ?>
					<label class="mo_oauth_switch">
						<input id="mo_oauth_debug_check" style="background: #dcdad1"  type="checkbox" class="mo_input_checkbox" name="mo_oauth_debug_check" 
						<?php
						if ( get_option( 'mo_debug_enable' ) ) {
							echo get_option( 'mo_debug_enable' ) === 'on' ? 'checked' : 'unchecked';}
						?>
						/>
						<span class="mo_oauth_slider round"></span>
					</label>

		</form>
					<p>
						<b>
							<label for="oauth_enable_logs"></label>
							<?php esc_html_e( 'Enable Debug Log', 'miniorange-login-with-eve-online-google-facebook' ); ?>
						</b>
					</p>

				</div>
				<p class="mo_oauth_logs-disclaimer">
					The error logs will be cleared on a weekly basis
				</p>

				<div id="mo_oauth_enable" >
			<form id="mo_oauth_debug_download_form" method="post">
				<input type="hidden" name="option" value="mo_oauth_enable_debug_download" />
				<?php wp_nonce_field( 'mo_oauth_enable_debug_download', 'mo_oauth_enable_debug_download_nonce' ); ?>
				<input type="submit" name="submit" value="Download Logs" class="mo_oauth_download-logs-btn" />
			</form>

			<form id="mo_oauth_clear_debug_log_form" method="post">
			<input type="hidden" name="option" value="mo_oauth_clear_debug" />
			<?php wp_nonce_field( 'mo_oauth_clear_debug', 'mo_oauth_clear_debug_nonce' ); ?>
				<div class="mo_oauth_checkbox-pair">                   
				</div>
				<input type="submit" name="submit" id="submit_clear" value="Clear Logs" class="mo_oauth_download-logs-btn" />
			</form>

			</div>
		</div>
	</div>
</div>
		<?php
	}

}
