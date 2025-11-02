<?php
/**
 * Setup Wizard Client
 *
 * @package    setup-wizard
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Setup wizard step 2 - get client credentials and set scopes
 */
function mooauth_client_setup_client() {
	wp_enqueue_style( 'mo_oauth_setup_wizard_dropdown_style', dirname( plugin_dir_url( __FILE__ ) ) . '/ui-dropdown-master/dropdown.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
	wp_print_styles( 'mo_oauth_setup_wizard_dropdown_style' );
	wp_enqueue_style( 'mo_oauth_setup_wizard_trans_style', dirname( plugin_dir_url( __FILE__ ) ) . '/ui-dropdown-master/transition.min.css', array(), MO_OAUTH_CSS_JS_VERSION );
	wp_print_styles( 'mo_oauth_setup_wizard_trans_style' );
	wp_enqueue_script( 'mo_oauth_setup_wizard_dropdown_script', dirname( plugin_dir_url( __FILE__ ) ) . '/ui-dropdown-master/dropdown.min.js', array(), MO_OAUTH_CSS_JS_VERSION, false );
	wp_print_scripts( 'mo_oauth_setup_wizard_dropdown_script' );
	wp_enqueue_script( 'mo_oauth_setup_wizard_trans_script', dirname( plugin_dir_url( __FILE__ ) ) . '/ui-dropdown-master/transition.min.js', array(), MO_OAUTH_CSS_JS_VERSION, false );
	wp_print_scripts( 'mo_oauth_setup_wizard_trans_script' );
	echo '	<!-- content main -->
			<div class="field-group">
	        <label>Client ID:</label>
	        <input title="Client ID"
	        type="text" class="mo-normal-text long-field" name="clientId" id="clientId" value="" placeholder="Provide your client id">
	      </div>
	      <div class="field-group">
	        <label>Client Secret:</label>
	        <input title="Client Secret"
	        type="password" style="padding-right:8%"class="mo-normal-text long-field" name="clientSecret" id="clientSecret" value="" autocomplete="off" placeholder="Provide your client secret"><i class="fa fa-eye" onclick="mooauth_showClientSecret(\'clientSecret\',\'show_button\')" id="show_button"></i>
	      </div>';
		echo '<div class="field-group" id="mo-oauth-scope">
		        <label>Scopes</label>
		        <div class="long-field-scope">
			        <div name="scopes" class="ui fluid multiple selection search dropdown" multiple="" id="multi-select">
			        	<div class="text"></div>
  						<i class="dropdown icon"></i>
					</div>
				</div>
		        <div class="description">
		          <p>
		            Set scopes to request desired user data from your OAuth/OIDC Provider.
		            If your required scope is not in the list, write your own and <b> hit enter </b> button.
		          </p>
		        </div>
	      	</div>
	      	<script>
					jQuery(".ui.dropdown.fluid")
					  .dropdown({
					    allowAdditions: true,
					    hideAdditions: false,
					    clearable:true
					  });

			</script>';
}

