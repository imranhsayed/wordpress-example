<?php
/**
 * Setup Wizard
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Importing required files.
 */
require 'partials' . DIRECTORY_SEPARATOR . 'client.php';
require 'partials' . DIRECTORY_SEPARATOR . 'endpoints.php';
require 'partials' . DIRECTORY_SEPARATOR . 'callback.php';
require 'partials' . DIRECTORY_SEPARATOR . 'apps.php';
require 'partials' . DIRECTORY_SEPARATOR . 'summary.php';
require 'partials' . DIRECTORY_SEPARATOR . 'test.php';
require 'partials' . DIRECTORY_SEPARATOR . 'support.php';

/**
 * [Description Handle Setup wizard]
 */
class MO_OAuth_Client_Setup_Wizard {
	/**
	 * Init setup wizard
	 */
	public function page() {
		echo '<head>
		    <meta charset="utf-8">
		    <!-- load dependencies -->';
			wp_enqueue_style( 'mo_oauth_setup_wizard_style', plugin_dir_url( __FILE__ ) . '/css/generic.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
			wp_print_styles( 'mo_oauth_setup_wizard_style' );
			wp_enqueue_style( 'mo_oauth_setup_wizard_steps_style', plugin_dir_url( __FILE__ ) . '/css/multi-step.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
			wp_print_styles( 'mo_oauth_setup_wizard_steps_style' );
			wp_enqueue_style( 'mo_oauth_setup_wizard_font_style', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/css/font-awesome.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
			wp_print_scripts( 'jquery' );
			wp_print_scripts( 'jquery-ui-tooltip' );
			wp_print_styles( 'mo_oauth_setup_wizard_font_style' );
			wp_print_styles( 'dashicons' );
			wp_enqueue_script( 'mo_oauth_setup_wizard_script', plugin_dir_url( __FILE__ ) . '/js/generic.min.js', array(), MO_OAUTH_CSS_JS_VERSION, false );
			wp_enqueue_script( 'mo_oauth_setup_wizard_troubleshooting_script', plugin_dir_url( __FILE__ ) . '/js/troubleshooting.min.js', array(), MO_OAUTH_CSS_JS_VERSION, false );
			wp_localize_script(
				'mo_oauth_setup_wizard_script',
				'mo_oauth_ajax_object',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'app'      => get_option( 'mo_oauth_setup_wizard_app' ),
					'site_url' => get_site_url(),
				)
			);
			wp_print_scripts( 'mo_oauth_setup_wizard_script' );
			wp_print_scripts( 'mo_oauth_setup_wizard_troubleshooting_script' );
		echo '</head>
		<body>
		    <div class="close"><img src="' . esc_attr( plugins_url( '/images/cross_icon.svg.png', __FILE__ ) ) . '" id="mo-btn-close"></div>
		    <!-- content header-->
			<div class="moa">
			    <h1 class="mo_oauth_h1">Setup Wizard</h1>
			        <!--multistep -->
				<div class="mo-multistepper-root" style="display:none;">
					<div class="mo-multistep-root">
						<span class="mo-multilabel-root">
							<span class="mo-multistep-icon-container">
								<div class="mo-icon-style icon-step2">
									<svg class="mo-multistep-svgicon" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
										<path d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z">
										</path>
									</svg>
									<svg class="mo-multistep-svgicon-completed" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
										<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" stroke-width="3" stroke="white">
										</path>
									</svg>
								</div>
							</span>
							<span class="mo-muisteplabel-labelcontainer mo-label-step2 mo-muisteplabel-active">
								App Configuration
							</span>
							<span class="mo-muisteplabel-label-description">
								Copy & paste callback URL at OAuth/OIDC Provider end
							</span>
						</span>
					</div>
					<div class="mo-multistep-root">
						<div class="mo-muilti-step-connector">
							<span class="mo-muilti-step-connector-span mo-muilti-step-connector3">
							</span>
						</div>					
						<span class="mo-multilabel-root">
							<span class="mo-multistep-icon-container">
								<div class="mo-icon-style icon-step4">
									<svg class="mo-multistep-svgicon" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
										<polygon transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
        								<path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
									</svg>
									<svg class="mo-multistep-svgicon-completed" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
										<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" stroke-width="3" stroke="white">
										</path>
									</svg>
								</div>
							</span>
							<span class="mo-muisteplabel-labelcontainer mo-label-step4">
								Summary
							</span>
							<span class="mo-muisteplabel-label-description">
								Confirm & Verify Client Credentials of OAUTH/OIDC Provider
							</span>
						</span>
					</div>
				</div>
		    </div>			        
		    <div class="aui-page-panel">
		    	<div class="aui-page-panel-inner">
		    		<section class="aui-page-panel-content">
				    	<div id="step1" style="display:none">';
							mooauth_client_setup_apps();
				echo '</div>
						<div id="step2" style="display:none">';
							mooauth_client_setup_callback();
							mooauth_client_setup_client();
							mooauth_client_setup_endpoints();
				echo '</div>
						<div id="step3" style="display:none">';
							mooauth_client_summary();
				echo '</div>		
						<div id="step4" style="display:none">';
							mooauth_setup_wizard_test();
				echo '</div>
					<!-- troubleshooting -->
					</br>
					<div class="mo-oauth-troubleshooting" style="display:none">
					<h3 style="display:inline-block">Troubleshooting</h3>
					<ui id="mo-oauth-troubleshooting-ul">
					</ui>
					<br>
					<h4 id="mo-oauth-unable-to-connect"></h4>
					</div>			
				 	<!-- content footer -->
				        <div class="mo-button__footer" style="display:none;">
				            <div>
				                <input type="submit" class="mo-button--secondary" id="mo-btn-back" name="back" value="Back">
				            </div>
				            <div>
				                <input type="submit" name="later" id="mo-link-draft" class="mo-oauth-save-draft" href="." value="Save draft">
				                <input type="submit" class="mo-button mo-oauth-next-setup" value="Next"  id="mo-btn-next">
				                <input type="submit" class="mo-button mo-oauth-next-setup" value="Finish"  id="mo-btn-finish">
								<input type="submit" class="mo-button mo-oauth-next-setup" value="Re-run test" id="mo-btn-test-re-run" >
				                <input type="submit" class="mo-button mo-oauth-next-setup mo-btn-test-finish_class" value="Finish"  id="mo-btn-test-finish">
				            </div>
				        </div>
				        <div class="mo-skip__footer" style="display:none;">				                
				                <input type="submit" class="mo-button mo-oauth-skip-setup" id="mo-btn-skip" value="Skip">
				        </div>
						<div class="mo-hidden">
							<input type="hidden" name="nonce" id="nonce" value="' . esc_attr( wp_create_nonce( 'mo-oauth-setup-wizard-nonce' ) ) . '">
							<input type="hidden" name="appId" id="appId">
							<input type="hidden" name="step" id="step">
							<input type="hidden" name="type" id="type">
							<input type="hidden" name="discInput" id="discInput">							
							<input type="hidden" name="scope_list" id="scope_list">
						</div>
					</section>
			    </div>    
		    </div>
		    <div>';
				mo_oauth_client_setup_support();
		echo '</div>
		    <div class="mo-logo-footer">
		    	Powered by <img src="' . esc_attr( plugin_dir_url( __FILE__ ) ) . '/images/miniorange.png" alt="miniOrange" />
		    </div>
			<script>
				mooauth_auto_fill_form();
				jQuery("#mo-btn-next, .mo-button--secondary, .mo-oauth-save-draft, .close, .mo-oauth-skip-setup, #mo-btn-finish").click(function(e){
					target = e.target.id;
					jQuery("#"+target).prop("disabled",true);
					console.log("#"+target);
					if("mo-btn-next" == target){
						var data= mooauth_get_data("save_draft","next");
					}
					if("mo-btn-back" == target){
						var data= mooauth_get_data("save_draft","back");
				    	
					}
					if("mo-link-draft" == target){
						var data= mooauth_get_data("save_draft","draft");
					}					
					if("mo-btn-finish" == target){

						var data= mooauth_get_data("save_app","finish");
					}										
					if("mo-btn-close" == target){

						var data= mooauth_get_data("save_draft","close");
					}										
					if("mo-btn-skip" == target){
						var data= mooauth_get_data("save_draft","skip");
					}
					if("mo-btn-next" == target || "mo-btn-back" == target){
						jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
							jQuery("#"+target).prop("disabled",false);
							if (undefined != response.mo_oauth_discovery_validation)
								var discovery_validation = response.mo_oauth_discovery_validation;
							else 
								var discovery_validation = "";
							if("invalid" == discovery_validation){
								jQuery(".mo-valid-icon").addClass("fa-thumbs-down");								
								jQuery(".mo-valid-icon").removeClass("fa-thumbs-up");
								jQuery(".mo-oauth-troubleshooting").show();
								mooauth_get_discovery_troubleshooting(response.mo_oauth_discovery_url,response.mo_oauth_input,response.mo_oauth_appId);
							}else{
								jQuery("#Domain").val(response.domain);
								jQuery(".mo-oauth-troubleshooting").hide();
								if(undefined != response.mo_oauth_scopes_list && "" != response.mo_oauth_scopes_list ){
									if(!Array.isArray(response.mo_oauth_scopes_list))
										var scope_list = JSON.parse(response.mo_oauth_scopes_list);
									else
										var scope_list = response.mo_oauth_scopes_list;
									jQuery(".ui.fluid.dropdown").dropdown({values:scope_list});
									jQuery("#scope_list").val(response.mo_oauth_scopes_list);
								}else{
						           	jQuery(".ui.fluid.dropdown").dropdown({values:[]});
						            jQuery("#scope_list").val("");
						        }
								if(undefined != response.mo_oauth_scopes && "" != response.mo_oauth_scopes && "[\"\"]" != response.mo_oauth_scopes  ){
									console.log("scopes in ajax response");
									console.log(response.mo_oauth_scopes);
									if(!Array.isArray(response.mo_oauth_scopes))
										var scopes = JSON.parse(response.mo_oauth_scopes);
									else
										var scopes = response.mo_oauth_scopes;
										console.log("scopes after parse");
										console.log(scopes);

									jQuery(".ui.dropdown.fluid").dropdown({allowAdditions: true,clearable:true});
									jQuery(".ui.fluid.dropdown").dropdown("clear");
									jQuery(".ui.fluid.dropdown").dropdown("set selected",scopes);
								}else{
									jQuery(".ui.dropdown.fluid").dropdown({allowAdditions: true,clearable:true});
								}	
								if("valid" == discovery_validation){
									jQuery(".mo-valid-icon").addClass("fa-thumbs-up");
									jQuery(".mo-valid-icon").removeClass("fa-thumbs-down");
								}else{									
									jQuery(".mo-valid-icon").removeClass("fa-thumbs-up");
									jQuery(".mo-valid-icon").removeClass("fa-thumbs-down");
								}
								if("mo-btn-next" == target){
								 	mooauth_steps_icr();
								}
								else{
									mooauth_steps_dcr();
								}
								console.log("removing disabling button");
							}
						});
					}
					else if("mo-btn-close" == target || "mo-link-draft" == target || "mo-btn-skip" == target){
						jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
							window.location.href = window.location.pathname + "?page=mo_oauth_settings&tab=config";
							});
					}
					else{
						var mo_response = mooauth_input_validation();
						if(mo_response == "success"){
							jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
							if("mo-btn-finish" == target){
								var site_url = "' . esc_url_raw( site_url() ) . '";
								mooauth_testConfiguration(site_url);
								mo_oauth_test_ajax_count = 0;
								mooauth_get_test_result();
								mo_oauth_trace_test_progress = setInterval(mooauth_get_test_result, 5000);
							}
							jQuery("#"+target).removeAttr("disabled");
							jQuery(".mo-oauth-test-in-progress").show();
							jQuery(".mo-oauth-test-in-failed").hide();
							jQuery(".mo-oauth-test-successed").hide();
							mooauth_steps_icr();
							});	
						}else{
							jQuery("#"+target).removeAttr("disabled");
						}
					}				
				});

				jQuery(".mo-btn-test-finish_class").click(function(){
					var data = {
						"action": "mo_outh_ajax",
        				"mo_oauth_option": "test_finish",
        				"mo_oauth_nonce" : jQuery("#nonce").val()
					}
					jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
						window.location.href = window.location.pathname + "?page=mo_oauth_settings&tab=config";
					});
				});
				jQuery("#mo-btn-test-re-run").click(function(){
					jQuery(".mo-oauth-troubleshooting").hide();
					var data= mooauth_get_data("save_app","finish");
					if("mo-btn-finish" == target || "mo-btn-next" == target){
						var site_url = "' . esc_url_raw( site_url() ) . '";
						mooauth_testConfiguration(site_url);
						mo_oauth_test_ajax_count = 0;
						mooauth_get_test_result();
						mo_oauth_trace_test_progress = setInterval(mooauth_get_test_result, 5000);
					}
					jQuery("#"+target).removeAttr("disabled");
					jQuery(".mo-oauth-test-in-progress").show();
					jQuery(".mo-oauth-test-in-failed").hide();
					jQuery(".mo-oauth-test-successed").hide();
				});
				jQuery("#mo-support-msg-hide").click(function(){
					jQuery("#help-container").hide();
				});
				jQuery("#service-btn").click(function(){
					jQuery(".support-form-container").show();
				});
				jQuery("#mo-support-form-hide").click(function(){
					jQuery(".support-form-container").hide();
					});
			</script>
		</body>';
	}
}

