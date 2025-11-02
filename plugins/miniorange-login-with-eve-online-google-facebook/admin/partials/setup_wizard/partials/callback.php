<?php
/**
 * Setup Wizard Callback
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Setup wizard step 2 - show callback URL
 */
function mooauth_client_setup_callback() {
	echo '	<!-- content main --> 
	        <h4>Setting up a Relying Party<span class="mo-oauth-setup-guide"></span></h4>
	        <p>
    	        <span class="mo-oauth-highlight-guide-notice" >Keep the setup guide handy or open it in a new window before proceeding with the setup</span><br>
	        </p>
			<div class="field-group">
			    <label>App name</label>
			    <input title="Display Name"
			    type="text" class="mo-normal-text" name="displayName" id="displayName" value="" placeholder="Company Name" onkeyup="mooauth_update_display_name_description(this)" >
			    <div class="description">
			      <p id="moauth_show_warning"></p>
			    </div>
				<div class="description">
			      <p id="moauth_show_desc"> </p>
			    </div>
			</div>

	        <div class="field-group">
	            <label>Callback URL</label> 
	            <input title="Copy this Redirect URI and provide to your provider"
				 type="text" class="mo-normal-text" id="callbackurl" name="url" value="' . esc_url_raw( site_url() ) . '" readonly="true"> 
	           <div class="mo_oauth_tooltip" style="display: inline;"><span class="mo_tooltiptext" style="position: absolute;top: -2rem" id="moTooltip"></span><i class="fa fa-clipboard fa-border" style="font-size:20px; align-items: center;vertical-align: middle; cursor:pointer" aria-hidden="true" onclick="mooauth_copyUrl()" onmouseout="mooauth_outFunc()"></i></div>
	            <div class="description">
	                <p>
						"Copy below Callback URL (Redirect URI) and configure it in your OAuth/OIDC Provider.
	                </p>                
	            </div>
	        </div>';?>
			<script type="text/javascript">
			function mooauth_outFunc() {
				var tooltip = document.getElementById("moTooltip");
				setTimeout(function() {
				tooltip.innerText = "";
				}, 3000);
			}

			function mooauth_copyUrl() {
				var copyText = document.getElementById("callbackurl");
				mooauth_outFunc();
				copyText.select();
				copyText.setSelectionRange(0, 99999); 
				document.execCommand("copy");
				var tooltip = document.getElementById("moTooltip");
				tooltip.innerText  = "Copied";

			}
		</script>
	<?php
}

?>
