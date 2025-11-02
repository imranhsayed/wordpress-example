<?php
/**
 * Customization
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display Customizations options for login button
 */
function mooauth_client_customization_ui() {
	wp_enqueue_script( 'mo_oauth_customize_icon_tab', esc_url( plugins_url( 'customization.min.js', __FILE__ ) ), array(), MO_OAUTH_CSS_JS_VERSION, false );
	?>
		<div id="mo_oauth_customiztion" class="mo_table_layout mo_oauth_app_customization">
		<div class="mo_oauth_customization_header"><div class="mo_oauth_attribute_map_heading" style="display: inline;"><b class="mo_oauth_position"><?php esc_html_e( 'Customize Icons ', 'miniorange-login-with-eve-online-google-facebook' ); ?></b> <small><div class="mo_oauth_tooltip" ><span class="mo_oauth_tooltiptext" >STANDARD</span><a href="<?php echo esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ); ?>"  target="_blank" rel="noopener noreferrer"><span style="border:none"><img class="mo_oauth_premium-label" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/images/mo_oauth_premium-label.png' ); ?>" alt="miniOrange Standard Plans Logo"></span></a></div></small></div><div class="mo_oauth_tooltip"><span class="mo_tooltiptext">Know how this is useful</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/login-button-customization" rel="noopener noreferrer">
		<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/images/mo_oauth_info-icon.png' ); ?>" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a></div></div>
	<form id="form-common" name="form-common" class="mo_oauth_customization_font" method="" action="admin.php?page=mo_oauth_settings&tab=customization">
		<div style="display: flex;text-align:center"><h2 id="mo_oauth_customize_icon" class="mo_oauth_switching_tab mo_active_div_css"><?php esc_html_e( 'Customize SSO button', 'miniorange-login-with-eve-online-google-facebook' ); ?></h2><h2 id="mo_oauth_write_custom_code" class="mo_oauth_switching_tab" style="border-bottom: 1px solid rgb(51, 122, 183);"><?php esc_html_e( 'Write your custom code', 'miniorange-login-with-eve-online-google-facebook' ); ?></h2></div>
		<div class="mo_oauth_custom_tab mo_oauth_customize_SSO_buttons">
		<div class="mo_oauth_custom_tab_item mo_oauth_custom_tab_flex_grow">
				<div style="display:flex;margin: 1%;">
					<div class="mo_oauth_custom_tab_item_2">
						<h3 class="mo_oauth_h3_heading"> THEME </h3>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_default" name="mo_oauth_icon_theme" value="default" onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Default</span></label>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_custom" name="mo_oauth_icon_theme" value="custom"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Custom</span><br>
							<input type="color" class="mo_oauth_custom_tab_margin_2 " style="margin: 10px 25px 20px !important;" id="mo_oauth_icon_color" name="mo_oauth_icon_color"  onclick="moOauthIconsPreview(getArg())">
						</label>

						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_white" name="mo_oauth_icon_theme" value="white"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">White</span></label>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_hover" name="mo_oauth_icon_theme" value="hover"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Hover</span></label>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_custom_hover" name="mo_oauth_icon_theme" value="customhover"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Custom Hover</span><br>
							<input type="color" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_custom_color" style="margin: 10px 25px 20px !important;" name="mo_oauth_icon_custom_color" value="#008ec2" onclick="moOauthIconsPreview(getArg())">
						</label>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_smart" name="mo_oauth_icon_theme" value="smart"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())" checked="checked"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Smart</span><br>
							<input type="color" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_smart_color_1" style="margin: 10px 5px 20px 25px !important" name="mo_oauth_icon_smart_color_1" value="#ff1f4b"  onclick="moOauthIconsPreview(getArg())">
							<input type="color" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_smart_color_2" style="margin: 10px 15px 20px !important;" name="mo_oauth_icon_smart_color_2" value="#2008ff" onclick="moOauthIconsPreview(getArg())">
						</label>
						<label>
							<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_theme_previous" name="mo_oauth_icon_theme" value="previous"  onclick="moOauthIconsPreview(getArg()),moOauthThemeSelector(selectLoginTheme())"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Previous</span></label>
						</label>
					</div>

					<div class="mo_oauth_custom_tab_item_2">
				<h3 class="mo_oauth_h3_heading"> SHAPE </h3>
				<label>
					<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_shape_round" name="mo_oauth_icon_shape" value="circle"  onclick="moOauthIconsPreview(getArg()),moOauthShapeHandler()"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Round</span></label>
				<label>
					<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_shape_oval" name="mo_oauth_icon_shape" value="oval"  onclick="moOauthIconsPreview(getArg()),moOauthShapeHandler()"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Round Edge</span></label>
				<label>
					<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_shape_square" name="mo_oauth_icon_shape" value="square"  onclick="moOauthIconsPreview(getArg()),moOauthShapeHandler()"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Square</span></label>
				<label>
					<input type="radio" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_shape_longbutton" name="mo_oauth_icon_shape" value="longbutton"  onclick="moOauthIconsPreview(getArg()),moOauthShapeHandler()" checked="checked"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Long Button</span></label>
				<hr>
				<h3 class="mo_oauth_h3_heading"> Effect </h3>
				<label>
					<input type="checkbox" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_effect_scale" name="mo_oauth_icon_effect_scale" value="scale"  onclick="moOauthIconsPreview(getArg())" checked="checked"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Transform</span></label>
				<label>
					<input type="checkbox" class="mo_oauth_custom_tab_margin_2 " id="mo_oauth_icon_effect_shadow" name="mo_oauth_icon_effect_shadow" value="shadow"  onclick="moOauthIconsPreview(getArg())" checked="checked"><span style="font-size: 1.1em;font-weight: 600; margin:5px 0px 0px 5px;">Shadow</span></label>

					</div>

				</div>
				<div style="display:flex;margin: 1%; ">
					<div id="mo_oauth_longbutton_parameter" class="mo_oauth_custom_tab_item_3">
						<h3 class="mo_oauth_h3_heading"> Size of the Icons </h3>
						<label class="mo_oauth_custom_tab_margin_3"><span style="font-size: 1.1em;font-weight: 600;">Height&nbsp;: </span>
						<input type="text" id="mo_oauth_icon_height" name="mo_oauth_icon_height" value="35" style="width: 30%;margin-left: 5px;">
							<input type="button" id="mo_oauth_height_plus" class="mo_oauth_icon_dimension" style="margin-left: 2px;" value="+" onclick=" moOauthIconsPreview(getArg())">&nbsp;<input type="button" id="mo_oauth_height_minus" class="mo_oauth_icon_dimension" value="-" onclick="moOauthIconsPreview(getArg())">
						</label>
						<label class="mo_oauth_custom_tab_margin_3"><span style="font-size: 1.1em;font-weight: 600;">Width&nbsp;&nbsp;: </span>
						<input type="text" id="mo_oauth_icon_width" name="mo_oauth_icon_width" value="260" style="width: 30%;margin-left: 5px;">
							<input type="button" id="mo_oauth_width_plus" class="mo_oauth_icon_dimension" value="+" onclick="moOauthIconsPreview(getArg())">&nbsp;<input type="button" id="mo_oauth_width_minus" class="mo_oauth_icon_dimension" value="-" onclick="moOauthIconsPreview(getArg())">
						</label>
						<label class="mo_oauth_custom_tab_margin_3"><span style="font-size: 1.1em;font-weight: 600;">Curve &nbsp;&nbsp;: </span>
						<input type="text" id="mo_oauth_icon_curve" name="mo_oauth_icon_curve" value="6" style="width: 30%;margin-left: 5px;">
							<input type="button" id="mo_oauth_curve_plus" class="mo_oauth_icon_dimension" value="+" onclick=" moOauthIconsPreview(getArg())">&nbsp;<input type="button" id="mo_oauth_curve_minus" class="mo_oauth_icon_dimension" value="-" onclick="moOauthIconsPreview(getArg())">
						</label>
						</div>
					<div id="mo_oauth_button_parameter" class="mo_oauth_custom_tab_item_3" style="display: none">
						<h3 class="mo_oauth_h3_heading"> Size of the Icons </h3>
						<label><span style="font-size: 1.1em;font-weight: 600;">Icon Size : </span>
							<input type="text" id="mo_oauth_icon_size" name=" mo_oauth_icon_size" value="40" style="width: 30%; margin-left: 5px;">
							<input type="button" id="mo_oauth_icon_plus" class="mo_oauth_icon_dimension" value="+" onclick="moOauthIconsPreview(getArg())">&nbsp;<input type="button" id="mo_oauth_icon_minus" class="mo_oauth_icon_dimension" value="-" onclick="moOauthIconsPreview(getArg())">

						</label>
					</div>
							<div class="mo_oauth_custom_tab_item_3">
						<h3 class="mo_oauth_h3_heading"> Space Between the Icons </h3>
								<label class="mo_oauth_custom_tab_margin_2">
									<input type="text" id="mo_oauth_icon_margin" name=" mo_oauth_icon_margin" value="10" style="width: 30%;margin-left: 5px;">
									<input type="button" id="mo_oauth_space_icon_plus" class="mo_oauth_icon_dimension" value="+" onclick="moOauthIconsPreview(getArg())">&nbsp;<input type="button" id="mo_oauth_space_icon_minus" class="mo_oauth_icon_dimension" value="-" onclick="moOauthIconsPreview(getArg())">
								</label>
							</div>
				</div>
			</div>
			<div class="mo_oauth_custom_tab_item mo_oauth_custom_tab_item_color">
				<?php
				$active_app = get_option( 'mo_oauth_apps_list' );
				if ( ! get_option( 'mo_oauth_apps_list' ) ) {
					?>
					<p>Please setup a SSO application.</p>
					<?php
				} else {
					?>
					<p class="mo_oauth_customization_tab_notice"><strong>Note:-</strong>This feature is available in Standard and above plans.</p>
					<?php
					$app_details = get_option( 'mo_oauth_apps_list' );
					$app_id      = array_key_first( $app_details );
					$displayname = 'Login with ' . $app_id;
					$appname     = $app_id;
					$icons       = $appname;
					if ( 'vkontakte' === $appname ) {
						$icons = 'vk';
					}if ( 'oauth1' === $appname || 'other' === $appname || 'openidconnect' === $appname || 'miniorange' === $appname ) {
						$icons = 'lock';
					}if ( 'gapps' === $appname ) {
						$appname = 'google';
						$icons   = 'google';
					}if ( 'fbapps' === $appname ) {
						$appname = 'facebook';
						$icons   = 'facebook-square';
					}if ( 'Freja eID' === $appname ) {
						$appname = 'frejaeid';
					}if ( 'swiss rx login' === $appname ) {
						$appname = 'swissrx';
						$icons   = 'lock';
					}if ( 'azureb2c' === $appname ) {
						$appname = 'azure';
					}
					if ( 'slack' === $appname || 'google' === $appname || 'facebook' === $appname || 'apple' === $appname || 'github' === $appname || 'gitlab' === $appname || 'reddit' === $appname || 'paypal' === $appname || 'yahoo' === $appname || 'spotify' === $appname || 'vimeo' === $appname || 'vkontakte' === $appname || 'pinterest' === $appname || 'deviantart' === $appname || 'twitch' === $appname || 'linkedin' === $appname || 'WordPress' === $appname ) {
						?>
				<i id="mo_oauth_default_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_default_icon_preview mo_oauth_def_btn_<?php echo esc_attr( $appname ); ?>"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_custom_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_custom_icon_preview"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_white_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_white_icon_preview mo_oauth_white_btn_<?php echo esc_attr( $appname ); ?>"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_hover_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_hover_icon_preview mo_oauth_hov_btn_<?php echo esc_attr( $appname ); ?>"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_custom_hover_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_custom_hover_icon_preview"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_smart_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_smart_icon_preview"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_previous_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo 'lock'; ?> mo_oauth_previous_icon_preview"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
						<?php
					} elseif ( 'oauth1' === $appname || 'other' === $appname || 'openidconnect' === $appname || 'miniorange' === $appname || 'swissrx' === $appname ) {
						?>
					<i id="mo_oauth_default_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_default_icon_preview mo_oauth_def_btn_<?php echo esc_attr( $appname ); ?> mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_custom_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_custom_icon_preview mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_white_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_white_icon_preview mo_oauth_white_btn_<?php echo esc_attr( $appname ); ?> mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_hover_icon_preview_<?php echo esc_attr( $appname ); ?> mo_oauth_lock_pad" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_hover_icon_preview mo_oauth_hov_btn_<?php echo esc_attr( $appname ); ?> mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_custom_hover_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_custom_hover_icon_preview mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_smart_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo esc_attr( $icons ); ?> mo_oauth_smart_icon_preview mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
					<i id="mo_oauth_previous_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo 'lock'; ?> mo_oauth_previous_icon_preview mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
						<?php
					} else {
						?>
					<i id="mo_oauth_default_icon_preview_<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?>" class=" fa mo_oauth_default_icon_preview mo_oauth_def_btn_<?php echo esc_attr( $appname ); ?>" ><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_img"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_custom_icon_preview_<?php echo esc_attr( $appname ); ?>" class=" fa mo_oauth_custom_icon_preview " ><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_img"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_white_icon_preview_<?php echo esc_attr( $appname ); ?>" class=" fa mo_oauth_white_icon_preview mo_oauth_white_btn_<?php echo esc_attr( $appname ); ?>" > <img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $icons . '.png' ); ?> class="mo_oauth_login_but_img"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_hover_icon_preview_<?php echo esc_attr( $appname ); ?>" class=" fa mo_oauth_hover_icon_preview mo_oauth_hov_btn_<?php echo esc_attr( $appname ); ?>"><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . '.png' ); ?> class="mo_oauth_login_but_img without_hover"><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_img with_hover" style="display: none"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_custom_hover_icon_preview_<?php echo esc_attr( $appname ); ?>" class=" fa mo_oauth_custom_hover_icon_preview "><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_custom_img without_hover"><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_custom_img with_hover" style="display: none"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_smart_icon_preview_<?php echo esc_attr( $appname ); ?>" class=" fa mo_oauth_smart_icon_preview " ><img src=<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/' . $appname . 's.png' ); ?> class="mo_oauth_login_but_img"><span  class="mo_oauth_login_button_font mo_oauth_login_but_img_span"><?php echo esc_attr( $displayname ); ?></span></i>
				<i id="mo_oauth_previous_icon_preview_<?php echo esc_attr( $appname ); ?>" class="fa fa-<?php echo 'lock'; ?> mo_oauth_previous_icon_preview mo_oauth_lock_pad"><span  class="mo_oauth_login_button_font"><?php echo esc_attr( $displayname ); ?></span></i>
						<?php
					}
				}
				?>
			</div>
		</div>
<div class="mo_oauth_write_custom_code_tab mo_oauth_customize_SSO_buttons"><p style="font-weight: 600;color:red;text-align:center;font-size:initial"><?php esc_html_e( 'Save the settings to see the preview of the Custom CSS', 'miniorange-login-with-eve-online-google-facebook' ); ?> </p>
		<table  class="mo_settings_table" >

			<tr>
				<td><strong><?php esc_html_e( 'Custom CSS:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong></td>
				<td>
	</br>
					<textarea disabled type="text" class="mo_oauth_input_disabled" id="mo_oauth_icon_configure_css" style="resize: vertical; width:400px; height:150px;  margin:5% auto;" rows="6" name="mo_oauth_icon_configure_css"></textarea>
					<br/>
					<strong><?php esc_html_e( 'Example CSS:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
<pre >
		background: #7272dc;
		height:40px;
		width:300px;
		padding:8px;
		text-align:center;
		color:#fff;
</pre>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'Logout Button Text:', 'miniorange-login-with-eve-online-google-facebook' ); ?> </strong>
				</td>
				<td>
					<input disabled style="width:300px" type="text" class="mo_oauth_input_disabled" id="mo_oauth_custom_logout_text" name="mo_oauth_custom_logout_text" placeholder="Howdy, ##user##  ##Logout##">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<br><strong><?php esc_html_e( 'Example:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
<pre>
		Text you enter: Howdy ##user## ##Sign Out##
		Text displayed: Howdy (username)  <u>Sign Out</u>
</pre>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
			</tr>
		</table></div>
	<div class="mo_oauth_outer_padding" style="padding: 15px;">

	<table class="mo_oauth_custom_settings_table">
		<div class="mo_oauth_notice_label">
				<h4 style="font-size: 1.2em"><?php esc_html_e( 'Apply above customized settings to the wp-admin SSO buttons:', 'miniorange-login-with-eve-online-google-facebook' ); ?>
				<label class="mo_oauth_switch" style="margin-top:-15px">
							<input value="1" type="checkbox" style="background: #dcdad1"
								name="mo_apply_customized_setting_on_wp_admin" />
							<span class="mo_oauth_slider round "></span>
				</label></h4>
		</div>
	</table>
	<table class="mo_oauth_custom_settings_table">
			<tr>
				<h4 style="font-size: 1.2em"><?php esc_html_e( 'Customize display name (special charactors are allowed.)', 'miniorange-login-with-eve-online-google-facebook' ); ?></h4>
	</tr>
	<?php
	$appslist    = is_array( get_option( 'mo_oauth_apps_list' ) ) ? get_option( 'mo_oauth_apps_list' ) : array();
	$displayname = '';
	foreach ( $appslist as $key => $val ) {
		$displayname = $key;
	}
	?>
	<tr>
		<td>
				<strong><label class="mo_oauth_fix_fontsize"><?php esc_html_e( 'Enter text to display on your login buttons:', 'miniorange-login-with-eve-online-google-facebook' ); ?></label>&nbsp;&nbsp;<?php echo esc_attr( $displayname ); ?></strong></td>
				<td><input class="mo_oauth_textfield_css mo_oauth_input_disabled" style="border: 1px solid ; width: 350px;" type="text" placeholder="SSO with : "/></td>
			   
	</tr>
</table>    
<hr>
<table class="mo_oauth_custom_settings_table" id="mo_custom_icon_table">
<tr>
			<h4 style="font-size: 1.2em">Upload Custom Icons :</h4>
</tr>
	<?php
	$displayname = 'No App Configured';
	foreach ( $appslist as $key => $val ) {
		$displayname = $key;
	}
	?>
<tr>
	<td><strong> Application </strong></td>
	<td><strong> Custom Image for Icon</strong></td>
</tr>
<tr id="mo_custom_icon" class="rows">
	<td>
	<select style="width: 55%;" name="<?php echo 'mo_custom_icon_file'; ?>" id="wp_icon_list" ><option value="">Select App from List</option><option value=""><?php echo esc_attr( $displayname ); ?></option></select></td>
	<td><input  type="file" id="mo_custom_icon" name="custom_icon[]" class="mo_oauth_input_disabled"></td>
	</tr>
	<tr><td><h4><a class="mo_oauth_input_disabled" style="cursor:not-allowed" id="add_icon">Add More Icons</a></h4></td><td>&nbsp;</td></tr>
</table>
<hr>
	<table class="mo_oauth_custom_settings_table">
			<tr>
				<h4 style="font-size: 1.2em"><?php esc_html_e( 'Customize Connect with text on WP Login page', 'miniorange-login-with-eve-online-google-facebook' ); ?></h4>
	</tr><tr>
						<div style="width: 100%;"><td>
							<strong><label class="mo_oauth_fix_fontsize"><?php esc_html_e( 'Enter text to show above login widget:', 'miniorange-login-with-eve-online-google-facebook' ); ?></label><strong></td>
							<td><input class="mo_oauth_textfield_css mo_oauth_input_disabled" style="border: 1px solid ; width: 350px;"  type="text" name="mo_oauth_widget_customize_text" Placeholder="Connect with :" /></td>
						</div>
					</div>
	</tr>
	</table><hr>
	<table class="mo_oauth_custom_settings_table"> 
	<tr>
					<h4 style="font-size: 1.2em"><?php esc_html_e( 'Customize Text to show user after Login', 'miniorange-login-with-eve-online-google-facebook' ); ?></h4>
				<td>
					<strong><?php esc_html_e( 'Customize Logout Text: (Anchor tags are allowed)', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
				</td>
				<td>
					<input class="mo_oauth_input_disabled" style="width:350px; border: 1px solid" type="text" id="mo_oauth_custom_logout_text" name="mo_oauth_custom_logout_text" placeholder="Howdy, ##user##  ##Logout##" value="">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<strong><?php esc_html_e( 'Example:', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong>
<pre>
		Text you enter: Howdy ##user## ##Sign Out##
		Text displayed: Howdy (username)  <u>Sign Out</u>
</pre>
				</td>
			</tr>
			<tr>
				<td><strong><?php esc_html_e( 'With Logout Link: (If unchecked, remove logout link)', 'miniorange-login-with-eve-online-google-facebook' ); ?></strong></td>
				<td><input type="checkbox" name="mo_custom_html_with_logout_link" value="1"></td>
			</tr>
				</table>

				<table class="mo_oauth_custom_settings_table">
			<tr>
			<td></td>
		<td><input type="submit" id="button_submit"name="submit" value="<?php esc_html_e( 'Save Settings', 'miniorange-login-with-eve-online-google-facebook' ); ?>" style="margin:20px 0px; padding:2px 25px;"
		class="button button-primary button-large mo_disabled_btn" /></td>
	</tr></table>			
	</div>
	</form>
	</div>

	<script>
		jQuery(document).ready(function () {
			jQuery(".mo_oauth_custom_tab").css("display","flex");
			jQuery(".mo_oauth_write_custom_code_tab").css("display","none");
			jQuery(".mo_oauth_outer_padding input").prop("disabled", true);
			jQuery("#mo_oauth_customize_icon").click(function (){
				jQuery(".mo_oauth_custom_tab").css("display","flex");
				jQuery(".mo_oauth_write_custom_code_tab").css("display","none");
				jQuery("#mo_oauth_customize_icon").addClass("mo_active_div_css");
				jQuery("#mo_oauth_write_custom_code").removeClass("mo_active_div_css");
				jQuery("#mo_oauth_write_custom_code").css("border-bottom","1px solid rgb(51, 122, 183)");
			});

			jQuery("#mo_oauth_write_custom_code").click(function (){
				jQuery(".mo_oauth_custom_tab").css("display","none");
				jQuery(".mo_oauth_write_custom_code_tab").css("display","block");			
				jQuery("#mo_oauth_customize_icon").css("border-bottom","1px solid rgb(51, 122, 183)");
				jQuery("#mo_oauth_write_custom_code").addClass("mo_active_div_css");
				jQuery("#mo_oauth_customize_icon").removeClass("mo_active_div_css");
			});	
		});

	</script>
	<?php
}
