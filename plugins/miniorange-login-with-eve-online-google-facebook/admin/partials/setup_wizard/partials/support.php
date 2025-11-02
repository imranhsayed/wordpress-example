<?php
/**
 * Setup Wizard Support
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Support form
 */
function mo_oauth_client_setup_support() {
	echo '<div class="support-icon" style="display: block;">
			<div class="help-container" id="help-container" style="display: block;">
			  	<span class="span1">
					<div class="need">
					  <span class="span2"></span>
						<div id="mo-support-msg">Need Help? We are right here!</div>
						<span class="fa fa-times fa-1x " id="mo-support-msg-hide" style="cursor:pointer;float:right;disply:inline;">
					</span>
					</div>
			  	</span>
			</div>

			<div class="service-btn" id="service-btn">
				<div class="service-icon">
					<img src="' . esc_attr( plugins_url( '/images/mail.png', dirname( __FILE__ ) ) ) . '" class="service-img" alt="support">
				</div>
			</div>
		</div>';

	echo '<div class="support-form-container" style="display: none;">
 			<div class="widget-header">
				Contact miniOrange Support
				<div class="widget-header-close-icon">
					<span class="fa fa-times fa-1x" style="cursor: pointer;float:right;" id="mo-support-form-hide">
					</span>
				</div>
		  	</div>
		  	<div class="support-form top-label" style="display: block;">
		  			<label for="email">
						Your Contact E-mail
		  			</label>
		 	 		<input type="email" class="field-label-text" name="email" id="person_email" dir="auto" required="true" title="Enter a valid email address." placeholder="Enter valid email">
		  			<label>
						How can we help you?
		  			</label>
		  			<textarea rows="5" id="person_query" name="description" dir="auto" required="true" class="field-label-textarea" placeholder="You will get reply via email"></textarea>
		  			<button id="mo-oauth-submit-support" type="submit" class="mo-button" value="Submit" aria-disabled="false">Submit</button>
	  		</div>
		</div>';
	echo '<script>
			jQuery("#mo-oauth-submit-support").click(function(){
			    var data={
			        "action"			: "mo_outh_ajax",
			        "mo_oauth_option"	: "query_submit",
			        "mo_oauth_email" 	: jQuery("#person_email").val(),
			        "mo_oauth_query"  	: jQuery("#person_query").val(),
			        "mo_oauth_nonce" 	: jQuery("#nonce").val()
			    };			    
				jQuery("#mo-support-msg").empty();
				jQuery("#mo-support-msg").append("We are processing your request. Please wait!!");
				jQuery("#help-container").show();
			      	jQuery(".support-form-container").hide();
				jQuery.post(mo_oauth_ajax_object.ajax_url, data, function(response){
					console.log(response);
					jQuery("#mo-support-msg").empty();
					jQuery("#mo-support-msg").append(response);
				});
			});
	</script>';
}

