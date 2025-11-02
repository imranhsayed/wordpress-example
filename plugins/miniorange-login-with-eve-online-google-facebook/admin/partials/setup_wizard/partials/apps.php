<?php
/**
 * Setup Wizard Apps
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Setup wizard step 1 - show app list
 */
function mooauth_client_setup_apps() {
	$defaultapps     = file_get_contents( dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . '/apps/partials/defaultapps.json' ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Using file_put_contents to fetch local file and not remote file.
	$defaultappsjson = json_decode( $defaultapps );
	$custom_apps     = array();

	echo '<center><h4>OAuth / OpenID Connect Providers</h4></center>
		<form id="mo_setup_wizard_form">
		<div class="_3HxD">
			<div class="q8lC">
				<span class="iconSearch _2Ysz fa fa-search"></span>
				<input type="text" name="mo_oauth_search" autofocus=true autocomplete=false value id="mo_oauth_client_default_apps_search" onkeyup="mooauth_client_default_apps_input_filter()" placeholder="' . esc_html__( 'Search Your Provider', 'miniorange-login-with-eve-online-google-facebook' ) . '">
			</div>
		</div>
	<!-- app list -->
	<div id="mo_oauth_client_search_res"></div>
	<div id="mo_oauth_client_searchable_apps">
		<ui id="mo_oauth_client_default_apps" class="mo-flex-container mo-wrap">';
	foreach ( $defaultappsjson as $app_id => $application ) {
		if ( 'other' === $app_id || 'openidconnect' === $app_id || 'oauth1' === $app_id || 'oauth2.1' === $app_id ) {
			$custom_apps[ $app_id ] = $application;
			// continue.
		}

		if ( 'oauth2.1' === $app_id || 'neoncrm' === $app_id || 'mindbody' === $app_id || 'imis' === $app_id || 'classlink' === $app_id || 'vendesta' === $app_id || 'clever' === $app_id || 'orcid' === $app_id ) {
			$image_name      = $application->image;
			$tooltip_message = 'oauth2.1' === $app_id ? 'OAuth 2.1 protocol is supported in our paid plugin versions. You can reach out to us to unlock this functionality.' : esc_html( $application->label ) . ' application is available in the Paid Version of the plugin. <a class ="skip-this" style="color:#ffd700; text-decoration:underline;" href="' . esc_url( 'https://sandbox.miniorange.com/?mo_plugin=oauth_client' ) . '" target="_blank">Try Now</a> the paid version.';
			$image_url       = plugins_url( '/partials/apps/images/' . $image_name, dirname( dirname( dirname( __FILE__ ) ) ) );
			echo '<li data-appid="' . esc_attr( $app_id ) . '" class="mo-flex-item mo_oauth_tooltip "><span class="mo_oauth_tooltiptext">' . wp_kses_post( $tooltip_message ) . '</span><a class = "mo_oauth_client_search_idp" href="#"><img class="mo_oauth_two_point_one_app_icon" src="' . esc_url( $image_url ) . '"><img class="mo_oauth_pro_icon" src="' . esc_url( plugins_url( '/partials/apps/images/pro.png', dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '">';
		} else {
			echo '<li data-appid="' . esc_attr( $app_id ) . '" class="mo-flex-item"><a class = "mo_oauth_client_search_idp" ' . ( 'cognito' === $app_id ? 'id=vip-default-app' : '' ) . ' href="#" ><img class="mo_oauth_client_default_app_icon" src=" ' . esc_url( plugins_url( '/partials/apps/images/' . $application->image, dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '">';
		}

		echo ' <br><p>' . esc_attr( $application->label ) . '</p></a><input type="hidden" value="' . esc_html( wp_json_encode( $application ) ) . '"></li>';
	}

	echo '<li class="mo-flex-item hidden-flex-item"></li><li class="mo-flex-item hidden-flex-item"></li><li class="mo-flex-item hidden-flex-item"></li><li class="mo-flex-item hidden-flex-item"></li></ui></div></form><script>
	jQuery(window).ready(function() {
        jQuery("#mo_setup_wizard_form").on("keypress", function (event) {            
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {                
                event.preventDefault();
                return false;
            }
        });
        });
	jQuery("#mo_oauth_client_default_apps li").click(function(){
				var appId = jQuery(this).data("appid");
				jQuery("#displayName").val(appId);
				jQuery("#moauth_show_desc").html("This will displayed on SSO login button as <b>\"Login with " +appId +"\"</b>. The entire button name is customizable in paid versions.");
				var selected_app_child = jQuery(this).children();
				var jsonStr = jQuery(selected_app_child[1]).val();
				if (jsonStr) {
					try {
						var selected_app = jQuery.parseJSON(jsonStr);
					} catch (e) {
						return;
					}
				} else {
					return;
				}
				var selected_app = jQuery.parseJSON(jQuery(selected_app_child[1]).val());
				var discovery = jQuery(".mo-discovery");
				jQuery("#type").val(selected_app["type"]);	
				if("oauth1" == selected_app["type"])
				  	jQuery("#mo-oauth-scope").hide();
				else
				  	jQuery("#mo-oauth-scope").show();

				var inputs = "";
				jQuery(discovery).empty();
				if(undefined != selected_app["input"]){
					for(i in selected_app["input"]){
						jQuery(discovery).append(\'<div class="field-group"><label>\'+i+\'</label><input type="text" class="mo-normal-text long-field" name="\'+i+\'" id="\'+i+\'" placeholder="\'+selected_app["input"][i]+\'"><i class="fa mo-valid-icon"></i></div>\');
						inputs = inputs+" "+i;
					}
					jQuery("#discInput").val(jQuery.trim(inputs));
					if(undefined != selected_app["avl_domain"]){
						jQuery("#Domain").val(selected_app["avl_domain"]);
					}
				}
				else{
					jQuery("#discInput").val("");
					if(undefined != selected_app["authorize"])
						jQuery(discovery).append(\'<div class="field-group"><label>Authorization Endpoint</label><input type="text" class="mo-normal-text long-field" name="authorize" id="authorize" value="\'+selected_app["authorize"]+\'" placeholder="Enter authorization endpoint"></div>\');
					if(undefined != selected_app["token"])		
						jQuery(discovery).append(\'<div class="field-group"><label>Token Endpoint</label><input type="text" class="mo-normal-text long-field" name="token" id="token" value="\'+selected_app["token"]+\'" placeholder="Enter token endpoint"></div>\');	
					if("openidconnect" != selected_app["type"] && undefined != selected_app["userinfo"])
						jQuery(discovery).append(\'<div class="field-group"><label>Userinfo Endpoint</label><input type="text" class="mo-normal-text long-field" name="userinfo" id="userinfo" value="\'+selected_app["userinfo"]+\'" placeholder="Enter userinfo endpoint"></div>\');
					if(undefined != selected_app["setup_notice"])
						jQuery(discovery).append(\'<div id= "notice" class="mo-setup-notice">Note : \'+selected_app["setup_notice"]+\' </div>\');	
					if(undefined != selected_app["requesturl"])
						jQuery(discovery).append(\'<div class="field-group"><label>Request Token Endpoint</label><input type="text" class="mo-normal-text long-field" name="requesturl" id="requesturl" value="\'+selected_app["requesturl"]+\'" placeholder="Enter request token endpoint"></div>\');	
				}
				if(undefined != selected_app["scope"] && "" != selected_app["scope"]){
					app_scopes = selected_app["scope"].split(" ");
					console.log("on app selection");
					console.log(app_scopes);
					jQuery(".ui.dropdown.fluid").dropdown({allowAdditions: true,hideAdditions: false});
					jQuery(".ui.fluid.dropdown").dropdown("clear");
					jQuery(".ui.fluid.dropdown").dropdown("set selected",app_scopes);
				}
				if(undefined != selected_app["send_header"] && "1" == selected_app["send_header"]){
					jQuery("#send_header").prop("checked",true);
				}
				if(undefined != selected_app["send_body"] && "1" == selected_app["send_body"]){
					jQuery("#send_body").prop("checked",true);
				}
				jQuery(".mo-oauth-setup-guide").empty();
				if(undefined != selected_app["guide"] && "" != selected_app["guide"]){
					jQuery(".mo-oauth-setup-guide").append(\'<a href="\'+selected_app["guide"]+\'" class="mo-oauth-setup-guide-link" target="_blank">&nbspSetup Guide</a>&nbsp\');
				}				
				if(undefined != selected_app["video"] && "" != selected_app["video"]){
					jQuery(".mo-oauth-setup-guide").append(\'<a href="\'+selected_app["video"]+\'" class="mo-oauth-setup-video-link" target="_blank">&nbspVideo Guide</a>\');
				}
				jQuery("#appId").val(appId);
				mooauth_steps_icr();
				var data= mooauth_get_data("save_draft","next");
				jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
				});					
			});
	</script>';
}


