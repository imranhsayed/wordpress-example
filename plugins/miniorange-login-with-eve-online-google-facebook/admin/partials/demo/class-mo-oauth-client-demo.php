<?php
/**
 * Demo
 *
 * @package    demo
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Handle demo requests
 */
class MO_OAuth_Client_Demo {

	/**
	 * Request for demo
	 */
	public static function requestfordemo() {
		self::demo_request();
	}

	/**
	 * Display UI to make demo request
	 */
	public static function demo_request() {
		$democss = 'width: 325px; height:35px;';

		// Get WordPress version.
		global $wp_version;

		$wp_version_trim = substr( $wp_version, 0, 3 );
		?>
			<div class="mo_demo_layout mo_oauth_contact_heading mo_oauth_outer_div">
			<div class="mo_oauth_request_demo_header">
				<div class="mo_oauth_attribute_map_heading"> <?php esc_html_e( 'Request for Demo/ Trial', 'miniorange-login-with-eve-online-google-facebook' ); ?></div>
			</div>
					</br><blockquote class="mo_oauth_blackquote mo_oauth_paragraph_div" style="  margin-bottom: 0px;"><?php esc_html_e( 'Want to try out the paid features before purchasing the license? Simply complete the form provided below, specify your preferred add-ons, get access to the trial of All-Inclusive plan, giving you unrestricted access to test all our top-tier features.', 'miniorange-login-with-eve-online-google-facebook' ); ?></blockquote>
					<form method="post" action="">
					<input type="hidden" name="option" value="mo_oauth_client_demo_request_form" />
			<?php wp_nonce_field( 'mo_oauth_client_demo_request_form', 'mo_oauth_client_demo_request_field' ); ?>
					<div style="display:flex"><div>
					<table class="mo_demo_table_layout">
						<tr><td>
							<div><strong class="mo_strong">Email id <p style="display:inline;color:red;">*</p>: </strong></div>
							<div><input class="mo_oauth_request_demo_inputs" required type="email" style="<?php echo esc_attr( $democss ); ?>" name="mo_auto_create_demosite_email" placeholder="We will use this email to setup the demo for you" value="<?php echo esc_attr( get_option( 'mo_oauth_admin_email' ) ); ?>" /></div></td>
						</tr>
						<tr><td>
							<div><strong class="mo_strong"><?php esc_html_e( 'Usecase', 'miniorange-login-with-eve-online-google-facebook' ); ?><p style="display:inline;color:red;">*</p> : </strong></div>
							<div>
							<textarea class="mo_oauth_request_demo_inputs" type="text" minlength="15" name="mo_auto_create_demosite_usecase" style="resize: vertical; width:325px; height:130px;" rows="4" placeholder="<?php esc_html_e( 'Example. Login into WordPress using Cognito, SSO into WordPress with my company credentials, Restrict gmail.com accounts to my WordPress site etc.', 'miniorange-login-with-eve-online-google-facebook' ); ?>" required value=""></textarea>
							</div></td>
						</tr> 
						</table></div><div>
						<table class="mo_demo_table_layout">
						<tr id="add-on-list">
							<td colspan="2">
							<p><strong class="mo_strong"><?php esc_html_e( 'Select the Add-ons you are interested in (Optional)', 'miniorange-login-with-eve-online-google-facebook' ); ?> :</strong></p>
							<blockquote class="mo_oauth_blackquote"><i><strong class="mo_strong">(<?php esc_html_e( 'Note', 'miniorange-login-with-eve-online-google-facebook' ); ?>: </strong> <?php esc_html_e( 'All-Inclusive plan entitles all the addons in the license cost itself.', 'miniorange-login-with-eve-online-google-facebook' ); ?> )</i></blockquote>
							<table>
					<?php
					$count = 0;
					foreach ( MO_OAuth_Client_Addons::$all_addons as $key => $value ) {
						if ( 0 !== $key && 0 !== $value && true === $value['in_allinclusive'] ) {
							if ( 0 === $count ) {
								?>
											<tr>
												<td>
													<input type="checkbox" class="mo_input_checkbox mo_oauth_demo_form_checkbox" style="margin:7px 5px 7px 5px" name="<?php echo esc_attr( $value['tag'] ); ?>" value="true"> <?php echo esc_html( $value['title'] ); ?><br/>
												</td>
									<?php
									++$count;
							} elseif ( 1 === $count ) {
								?>
											<td>
												<input type="checkbox" class="mo_input_checkbox mo_oauth_demo_form_checkbox" style="margin:7px 5px 7px 5px" name="<?php echo esc_attr( $value['tag'] ); ?>" value="true"> <?php echo esc_html( $value['title'] ); ?><br/>
											</td>
											</tr>
									<?php
									$count = 0;
							}
						}
					}
					?>
								</table>
							</td>
						</tr>	
							</table></div></div><table style="padding-left:25px">
						<!-- New WordPress sandbox demo trail -->
						<tr>
							<td>
								<button id="mo_oauth_sandbox_btn" name="mo_oauth_sandbox_btn" class="button button-large mo_oauth_demo_request_btn">Submit Demo Request</button>
							</td>
						</tr>

					</table>
			</form>
			</div>
						<!-- VIDEO DEMO DOWN -->
			<div class="mo_demo_layout mo_oauth_contact_heading mo_oauth_outer_div">
			<div class="mo_oauth_request_demo_header"><div class="mo_oauth_attribute_map_heading"> <?php esc_html_e( 'Request for Video Demo', 'miniorange-login-with-eve-online-google-facebook' ); ?></div></div>
					<div style="display:flex">
						<div class="mo_oauth_video_demo_container_form">
							<form method="post" action="">
								<input type="hidden" name="option" value="mo_oauth_client_video_demo_request_form" />
								<?php wp_nonce_field( 'mo_oauth_client_video_demo_request_form', 'mo_oauth_client_video_demo_request_field' ); ?>
								<table class="mo_demo_table_layout">
								<tr><td>
										<div><strong class="mo_strong">Email id <p style="display:inline;color:red;">*</p>: </strong></div>
										<div><input type="text" class="mo_oauth_video_demo_email" style="<?php echo esc_attr( $democss ); ?>" placeholder="We will use this email to setup the demo for you" name="mo_oauth_video_demo_email" ></div>
							</tr></td>
								<tr>
									<td><div><strong class="mo_strong">Date<p style="display:inline;color:red;">*</p>: </strong></div>
									<div><input type="date" class="mo_oauth_video_demo_date" style="<?php echo esc_attr( $democss ); ?>" name="mo_oauth_video_demo_request_date" placeholder="Enter the date for demo"></div>
								</td>	
								</tr>
								<tr>
									<td>
									<div><strong class="mo_strong">Local Time<p style="display:inline;color:red;">*</p>: </strong></div>
									<div><input type="time" class="mo_oauth_video_demo_time" placeholder="Enter your time" style="<?php echo esc_attr( $democss ); ?>" name="mo_oauth_video_demo_request_time">
										<input type="hidden" name="mo_oauth_video_demo_time_diff" id="mo_oauth_video_demo_time_diff"></div>
									</td>
								</tr>
								<tr>
									<td style="color:grey;">Eg:- 12:56, 18:30, etc.</td>
								</tr>
									<tr><td><div>
										<strong class="mo_strong">Usecase/ Any comments:<p style="display:inline;color:red;">*</p>: </strong></div>
										<div><textarea name="mo_oauth_video_demo_request_usecase_text" class="mo_oauth_video_demo_form_usecase" style="resize: vertical; width:325px; height:150px;" minlength="15" placeholder="Example. Login into WordPress using Cognito, SSO into WordPress with my company credentials, Restrict gmail.com accounts to my WordPress site etc."></textarea>
									</div></td></tr>
									</table>
								</div>
						<div class="mo_oauth_demo_container_gif_section mo_demo_table_layout">
							<div class="mo_oauth_video_demo_message">
								Your overview <a style="color:#012970"><strong class="mo_strong">Video Demo</strong></a> will include
							</div>
							<div class="mo_oauth_video_demo_bottom_message">
								<img class="mo_oauth_video_demo_gif" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . '/img/setup-gif.jpg'; ?>" alt="mo-demo-jpg">
							</div>
							<div class="mo_oauth_video_demo_bottom_message" >
									<strong class="mo_strong">You can set up a screen share meeting with our developers to walk you through our plugin featuers.</strong>
								<div class="mo_oauth_video_demo_bottom_message">
									<img class="mo_oauth_video_demo_icon" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . '/img/check.png'; ?>"  alt="">
									Overview of all Premium Plugin features.
								</div>	
								<div style="margin-top:10px">
									<img class="mo_oauth_video_demo_icon" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . '/img/support.png'; ?>"  alt="">
									Get a guided demo from a Developer via screen share meeting.
								</div>
							</div>
						</div>
					</div>
					<table style="padding-left:25px;">
						<tr>
							<td>
								<input type="submit" name="submit" value="<?php esc_html_e( 'Submit Demo Request', 'miniorange-login-with-eve-online-google-facebook' ); ?>" class="button button-large mo_oauth_demo_request_btn" />
							</td>
						</tr>
					</table>	
					</form>					
				</div>	
			<script>
				var d = new Date();
				var n = d.getTimezoneOffset();
				document.getElementById("mo_oauth_video_demo_time_diff").value = n;

				document.addEventListener("DOMContentLoaded", () => {
					const mo_oauth_sandbox_btn = document.getElementById('mo_oauth_sandbox_btn');
					mo_oauth_sandbox_btn.addEventListener('click', (e) => {
						e.preventDefault();
						// Do the validation for required fields.

						const mo_oauth_sandbox_email = document.querySelector('input[name="mo_auto_create_demosite_email"]').value;
						const mo_oauth_sandbox_usecase = document.querySelector('textarea[name="mo_auto_create_demosite_usecase"]').value;

						// Get name of all the addons selected.
						const mo_oauth_sandbox_addons = document.querySelectorAll('.mo_oauth_demo_form_checkbox');
						let mo_oauth_sandbox_addons_list = '';
						mo_oauth_sandbox_addons.forEach((addon) => {
							if (addon.checked) {
								// mo_oauth_sandbox_addons_list += addon.name + ', ';
								mo_oauth_sandbox_addons_list += addon.parentElement.innerText + ', ';
							}
						});

						// Append the addons list to the usecase.
						const mo_oauth_sandbox_usecase_with_addons = 'Usecase: \n'
							+ mo_oauth_sandbox_usecase 
							+ '\n' 
							+ 'Addons selected: \n' 
							+ mo_oauth_sandbox_addons_list;

						// Href to the sandbox demo website.
						const mo_oauth_sandbox_href = 'https://sandbox.miniorange.com/?email=' + mo_oauth_sandbox_email 
							+ '&mo_plugin=mo_oauth_client&wordpress_version=<?php echo esc_attr( $wp_version_trim ); ?>&usecase=' 
							+ encodeURIComponent(mo_oauth_sandbox_usecase_with_addons)
							+ '&referer=<?php echo esc_url( get_site_url() ); ?>';

						// Open the sandbox demo website in a new tab.
						window.open(mo_oauth_sandbox_href, '_blank');

					});

				});
			</script>	
			<?php
	}
}
