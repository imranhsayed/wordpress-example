<?php
/**
 * User Analytics
 *
 * @package    apps
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Display User Analytics
 */
function mooauth_client_user_analytics_ui() { ?>
	<div class="mo_table_layout" id="mo_oauth_user_analytics">
			<div class="mo_wpns_small_layout">
					<table>
						<tr>
							<td style="width: 100%"><div class="mo_oauth_attribute_map_heading" style="display: inline;"><b class="mo_oauth_position"><?php esc_html_e( 'User Transactions Report ', 'miniorange-login-with-eve-online-google-facebook' ); ?></b> <small><div class="mo_oauth_tooltip" ><span class="mo_oauth_tooltiptext" >ENTERPRISE</span><a href="<?php echo esc_url( MO_OAUTH_CLIENT_PRICING_PLAN ); ?>" target="_blank" rel="noopener noreferrer"><span style="border:none"><img class="mo_oauth_premium-label" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/images/mo_oauth_premium-label.png' ); ?>" alt="miniOrange Standard Plans Logo"></span></a></div></small></div></td><td></td><td style="text-align:right"><div class="mo_oauth_tooltip"><span class="mo_tooltiptext">Know how this is useful</span><a style="text-decoration: none;" target="_blank" href="https://developers.miniorange.com/docs/oauth/wordpress/client/user-analytics" rel="noopener noreferrer">
		<img class="mo_oauth_guide_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/images/mo_oauth_info-icon.png' ); ?>" alt="miniOrange Premium Plans Logo" aria-hidden="true"></a><br><br></div></td></tr><tr><td></td>
							<td>
								<input disabled type="submit" value="<?php esc_html_e( 'Refresh', 'miniorange-login-with-eve-online-google-facebook' ); ?>" class="button button-primary button-large mo_disabled_btn" />
							</td>
							<td>
								<input disabled type="submit" value="<?php esc_html_e( 'Clear Reports', 'miniorange-login-with-eve-online-google-facebook' ); ?>" class="button button-primary button-large mo_disabled_btn" />
							</td>
						</tr>
					</table><br>
				<table id="reports_table" class="display mo_oauth_client_user_analytics" cellspacing="0" style="text-align:center !important" width="100%" border="1px">
					<thead>
						<tr>
							<td><strong>testuser</strong></td>
							<td><strong>Status</strong></td>
							<td><strong>Application</strong></td>
							<td><strong>Created Date</strong></td>
							<td><strong>Email</strong></td>
							<td><strong>Client IP</strong></td>
							<td><strong>Navigation URL</strong></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>testuser1</td>
							<td style="color:red"><strong>FAILED. Invalid Email Received</strong></td>
							<td>-</td>
							<td>Mar 20,2024 1:53:10 pm</td>
							<td>-</td>
							<td>124.0.1</td>
							<td>-</td>
						</tr>
						<tr>
							<td>-</td>
							<td style="color:red"><strong>FAILED. Invalid Username Received.</strong></td>
							<td>-</td>
							<td>Mar 20,2024 1:58:31 pm</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>testuser3</td>
							<td style="color:green"><strong>SUCCESS</strong></td>
							<td>localserver</td>
							<td>Mar 20,2024 2:01:10 pm</td>
							<td>testuser3@test.com</td>
							<td>124.0.1</td>
							<td><?php echo esc_url( home_url( '/' ) ); ?></td>
						</tr>
						<tr>
							<td>testuser4</td>
							<td style="color:green"><strong>SUCCESS</strong></td>
							<td>localserver</td>
							<td>Mar 20,2024 2:07:15 pm</td>
							<td>testuser4@test.com</td>
							<td>124.0.1</td>
							<td><?php echo esc_url( home_url( '/' ) ); ?></td>
						</tr>
						<tr>
							<td>-</td>
							<td style="color:red"><strong>FAILED. Invalid Username Received.</strong></td>
							<td>-</td>
							<td>Mar 20,2024 2:25:18 pm</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
}
