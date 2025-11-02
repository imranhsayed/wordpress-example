<?php
/**
 * Feedback Form
 *
 * @package    feedback-form
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display Feedback form.
 */
function mooauth_client_display_feedback_form() {
	if ( ! empty( $_SERVER['PHP_SELF'] ) && 'plugins.php' !== basename( sanitize_text_field( wp_unslash( $_SERVER['PHP_SELF'] ) ) ) ) {
		return;
	}
	$deactivate_reasons = array(
		' Issues with SSO Setup',
		' Upgrading to Paid version',
		' My OAuth Server is not listed',
		' Would like to go on a call with expert',
		' Would like to test a premium plugin',
		' Other Reasons',
	);
	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );
	wp_enqueue_script( 'utils' );
	wp_enqueue_style( 'mo_oauth_admin_settings_style', plugin_dir_url( dirname( __FILE__ ) ) . '/admin/css/style_settings.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
	wp_enqueue_style( 'mo_oauth_admin_settings_font_awesome', plugin_dir_url( dirname( __FILE__ ) ) . 'css/font-awesome.min.css', array(), '4.6.2' );
	$keep_settings_intact = true;
	?>

	</head>
	<body>
	<div id="oauth_client_feedback_modal" class="mo_oauth_modal" style="margin: auto; text-align: center;">
		<div class="mo_oauth_modal-content">
			<h3 style="text-align: center; margin-top: 1.5%;"><b style="font-size: 1.2em; position:relative;"> <span style="visibility:hidden;">midd</span>Feedback Form 
			</b><span class="mo_close" id="mo_oauth_client_close">&times;</span></h3>
			<img class="mo_oauth_feedback_img" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/Feedback_img.png'; ?>" />
			<div class="mo_oauth_div_inside_model">
			<form name="f" method="post" action="" id="mo_oauth_client_feedback">
				<?php wp_nonce_field( 'mo_oauth_feedback_form', 'mo_oauth_feedback_form_field' ); ?>
				<input type="hidden" name="mo_oauth_client_feedback" value="true"/>
				<div class="mo-oauth-idp-keep-conf-intact" id="mo_idp_keep_configuration_intact">
						<b style="color:var(--main-color-dark-blue);">Keep Configuration Intact</b>
						<label class="mo-oauth-switch">
							<input type="checkbox" class="mo_input_checkbox" name="mo_oauth_keep_settings_intact" id="keepSettingsIntact" <?php echo esc_attr( $keep_settings_intact ) ? 'checked' : ''; ?>>
							<span class="mo-oauth-slider mo-oauth-round"></span>
						</label>
						<p style="margin:0px;" class="mo_idp_keep_configuration_intact_descr">Enabling this would keep your settings intact when plugin is uninstalled. Please enable this option when you are updating to a Premium version.</p>
					</div>
				<div>
					<h4 style="margin: 2%; text-align:center; font-weight: 600; font-size: 1.2em;">How satisfied are you with our product/service?</h4>
					<div align="center">
					<div id="mo_oauth_smi_rate" style="text-align:center" >
					<input class="mo_oauth_rating_face mo_oauth_radio_type" type="radio" name="rate" id="mo_oauth_angry" value="1"/>
						<label for="mo_oauth_angry"><img class="mo_oauth_feedback_face" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/angry.png'; ?>" />
						</label>
					<input class="mo_oauth_rating_face mo_oauth_radio_type" type="radio" name="rate" id="mo_oauth_sad" value="2"/>
						<label for="mo_oauth_sad"><img class="mo_oauth_feedback_face" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/sad.png'; ?>" />
						</label>
					<input class="mo_oauth_rating_face mo_oauth_radio_type" type="radio" name="rate" id="mo_oauth_neutral" value="3"/>
						<label for="mo_oauth_neutral"><img class="mo_oauth_feedback_face" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/normal.png'; ?>" />
						</label>
					<input class="mo_oauth_rating_face mo_oauth_radio_type" type="radio" name="rate" id="mo_oauth_smile" value="4"/>
						<label for="mo_oauth_smile">
						<img class="mo_oauth_feedback_face" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/smile.png'; ?>" />
						</label>
					<input class="mo_oauth_rating_face mo_oauth_radio_type" type="radio" name="rate" id="mo_oauth_happy" value="5" checked/>
						<label for="mo_oauth_happy"><img class="mo_oauth_feedback_face" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . 'images/happy.png'; ?>" />
						</label>
					</div>

					<div style="margin: auto;">
					<h4 style="margin: 1.5%; font-weight: 600; font-size: 1.1em; color:#000;">Tell us what heppened?<br></h4>

					<fieldset>
					<table style="width:85%;">
				<?php
					$count = 0;
				foreach ( $deactivate_reasons as $deactivate_reason ) {
					if ( 0 === $count ) {
						echo '<tr>';
						echo '<td class="mo_reason"><input type="radio" class="mo_oauth_radio_type" name="deactivate_reason_select" id = "' . esc_attr( $deactivate_reason ) . '" value="' . esc_attr( $deactivate_reason ) . '" style="text-align:center; text-align-last: center;"><label for="' . esc_attr( $deactivate_reason ) . '">' . esc_attr( $deactivate_reason ) . '</label></td>';
						++$count;
					} elseif ( 1 === $count ) {
						echo '<td class="mo_reason"><input type="radio" class="mo_oauth_radio_type" name="deactivate_reason_select" id = "' . esc_attr( $deactivate_reason ) . '" value="' . esc_attr( $deactivate_reason ) . '" style="text-align:center; text-align-last: center;"';
						echo checked( esc_attr( $deactivate_reason ) === ' Other Reasons' ) . ' ';
						echo ' ><label for="' . esc_attr( $deactivate_reason ) . '">' . esc_attr( $deactivate_reason ) . '</label></td>';
						echo '</tr>';
						$count = 0;
					}
				}
				?>
					</table>
					</fieldset>
					<textarea id="mo_oauth_query_feedback" name="query_feedback" rows="3" style="margin: 10px -5px; width: 80%;" placeholder="Write your query here.."></textarea>
					<?php
					$email = get_option( 'mo_oauth_admin_email' );
					if ( empty( $email ) ) {
						$user  = wp_get_current_user();
						$email = $user->user_email;
					}
					?>
					<div>
						<input type="email" id="mo_oauth_query_mail" name="query_mail" style="margin-bottom: 10px; text-align:center; border:0px solid black; background:#f0f3f7; width:60%;" placeholder="your email address" required value="<?php echo esc_attr( $email ); ?>" readonly="readonly"/>
						<i class="fa fa-pencil" onclick="mooauth_editName()" style="margin-left: -3%; cursor:pointer;"></i>
						</div>
						<div style="color: #012970; font-style: oblique; width: 100%; margin-bottom: 2%;">
						<input type="checkbox" class="mo_input_checkbox" name="get_reply" value="reply" checked>miniOrange representative will reach out to you at the email-address entered above.</input>
						</div>
					</div></div>
					<div class="mo_modal-footer">
						<div style="width: 80%; margin: 0 auto;">
						<input id="mo_skip_oauth_client" type="submit" onclick="remove_skip_required()" name="miniorange_feedback_skip"
							class="button" style="float: left; font-weight:700; width: 20%; color:#012970;" value="Skip"/>
						<input type="submit" name="miniorange_feedback_submit"
							class="button button-primary button-large mo_oauth_feedback_btn" value="Submit"/></div>
					</div>
				</div>
			</form>
			</div>
			<form name="f" method="post" action="" id="mo_oauth_client_feedback_form_close">
				<?php wp_nonce_field( 'mo_oauth_skip_feedback_form', 'mo_oauth_skip_feedback_form_field' ); ?>
				<input type="hidden" name="option" value="mo_oauth_client_skip_feedback"/>
			</form>
		</div>
	</div>
	<script>

		function mooauth_editName(){
			document.querySelector('#mo_oauth_query_mail').removeAttribute('readonly');
			document.querySelector('#mo_oauth_query_mail').focus();
			return false;
		}

		function remove_skip_required(){
			document.querySelector( '#deactivate_reason_select' ).removeAttribute( 'required' );
			return false;
		}

		jQuery('a[aria-label="Deactivate OAuth Single Sign On - SSO (OAuth Client)"]').click(function () {
			var mo_oauth_client_modal = document.getElementById('oauth_client_feedback_modal');
			var mo_skip_oauth_client = document.getElementById('mo_skip_oauth_client');
			var mo_oauth_client_close = document.getElementById("mo_oauth_client_close");
			mo_oauth_client_modal.style.display = "block";

			mo_oauth_client_close.onclick = function () {
				mo_oauth_client_modal.style.display = "none";
				jQuery('#mo_oauth_client_feedback_form_close').close();
			}

			window.onclick = function (event) {
				if (event.target == mo_oauth_client_modal) {
					mo_oauth_client_modal.style.display = "none";
				}
			}
			return false;

		});
	</script>
	<?php
}

?>
