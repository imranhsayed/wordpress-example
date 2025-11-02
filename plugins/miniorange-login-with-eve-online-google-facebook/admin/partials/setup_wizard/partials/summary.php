<?php
/**
 * Setup Wizard Summary
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Setup wizard step 3 - show app summary
 */
function mooauth_client_summary() {

	echo '<h4>Summary <span class="mo-oauth-setup-guide"></span></h4>
  <div class="summary-form-container"><ui class="summary-wrapper">
    <li class="summary-form-row">
    <label>Display name :</label>
      <div class="mo-summary-name mo-summary-data"></div>
      <a class="mo-editstep" data-step="2"></a>
    </li><li class="summary-form-row">';
	echo '
    <label>Callback URL :</label>
      <div class="mo-summary-callback mo-summary-data">' . esc_url_raw( site_url() ) . '</div>
      <a class="mo-editstep" data-step="2" style="color:red">&nbsp[Editable in premium]</a>
    </li><li class="summary-form-row">';

	echo '<label>Client ID :</label>
      <input type="text"  style="border:none;"  class="mo-summary-id mo-summary-data" id="client_id_summary" readonly="true"></input>
      <a  class="mo-editstep" data-step="2"></a>
      </li><li class="summary-form-row">';
	echo '<label>Client Secret :</label>  <div style="position: relative;">  
      <i class="fa fa-eye" onclick="mooauth_showClientSecret(\'client_secret_summary\',\'show_button_summary\')" id="show_button_summary"></i> 
      <input type="password" style="border:none;" class="mo-summary-secret mo-summary-data" readonly="true" id ="client_secret_summary" ></input></div>
      <a class="mo-editstep" data-step="2"></a>
      </li><li class="summary-form-row">';
	echo '<label>Scopes :</label>
      <div class="mo-summary-scopes mo-summary-data"></div>
      <a class="mo-editstep" data-step="2"></a>
      </li>';
	echo '<div class="mo-summary-endpoints"></div><li class="summary-form-row">';
	echo '<label> Send client credentials in :</label>
      <div class="mo-summary-callback mo-summary-data mo-summary-flex-shrink" ><input type="checkbox" class="mo_input_checkbox" name="mo_oauth_authorization_header" id="send_header">Header</div><div class="mo-summary-callback mo-summary-data mo-summary-flex-grow"><input type="checkbox" class="mo_input_checkbox" name="mo_oauth_body" id="send_body" >Body</div>
    </li>';
	echo '<li class="summary-form-row">';
	echo '<label> SSO Test :</label>
      <div class="mo-summary-callback mo-summary-data"><input type="checkbox" class="mo_input_checkbox" name="debug" id="debug" checked>Enable Test Debugging History</div><div></div>
    </li></ui></div>
  <script type="text/javascript">
  jQuery(document.body).on("click", ".mo-editstep" ,function(e){
        mooauth_get_step(jQuery(e.target).attr("data-step"));
    });
</script>';

}

