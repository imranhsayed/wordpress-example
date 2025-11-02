<?php
/**
 * FAQ
 *
 * @package    faq
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Class for handling FAQ
 */
class MO_OAuth_Client_Troubleshoot {

	/**
	 * Display Troubleshooting page
	 */
	public static function troubleshooting() {
		$appslist    = get_option( 'mo_oauth_apps_list' );
		$errorjson   = wp_json_file_decode( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'mo_oauth_errorcode.json' );
		$faqjson     = wp_json_file_decode( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'mo_oauth_faq.json' );
		$esc_allowed = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'style'  => array(
				'table',
				'tr',
				'td',
				'th',
			),
			'br'     => array(),
			'th'     => array( 'style' ),
			'strong' => array(),
			'b'      => array(),
			'table'  => array(),
			'h2'     => array(),
			'h3'     => array(),
			'h4'     => array(),
			'tr'     => array(),
			'h6'     => array(),
			'tbody'  => array(),
			'div'    => array(),
			'td'     => array(),
		);
		?>
		<div class="mo_table_layout mo_oauth_outer_div">
		<div>
		<h3 class='mo_app_heading' style='font-size:23px'>
		<?php esc_html_e( 'Troubleshooting', 'miniorange-login-with-eve-online-google-facebook' ); ?>
		</h3>
		<hr class='mo-divider'><br>
		</div>
		<div class="mo_oauth_error_faq_option">
			<div class="mo_oauth__errorcodes_options">
				<h3 class='mo_app_heading'><?php esc_html_e( 'Error Codes', 'miniorange-login-with-eve-online-google-facebook' ); ?></h3>
			</div>
			<div class="mo_oauth_faq_options">
				<h3 class='mo_app_heading'><?php esc_html_e( 'FAQs', 'miniorange-login-with-eve-online-google-facebook' ); ?></h3>
			</div>
		</div>
		<br><br>
		<div class="mo_oauth_errorcodes">

		<?php
		if ( empty( $appslist ) || ! isset( $appslist ) ) {
			?>
			<blockquote class="mo_oauth_blackquote mo_oauth_paragraph_div" style="  margin-bottom: 0px;">No Applications is configured. Please configure the application in the <b><a style="cursor: pointer" href="<?php echo ! empty( $_SERVER['REQUEST_URI'] ) ? esc_attr( add_query_arg( array( 'tab' => 'config' ), sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) ) : ''; ?>"><?php esc_html_e( 'Configure OAuth', 'miniorange-login-with-eve-online-google-facebook' ); ?></a></b> tab. </blockquote>
			<?php
		} else {
			$configuredapp = get_option( 'mo_oauth_apps_list' ) ? array_key_first( get_option( 'mo_oauth_apps_list' ) ) : '';
			$app_name      = $appslist[ $configuredapp ]['appId'];
			if ( isset( $errorjson->$app_name ) ) {
				?>
				<table class="mo_oauth_troubleshoot_table">
				<tr class='mo_troubleshoot_heading'>
					<td style='width:30%'>Error</td>
					<td>Description</td>
				</tr>
				<?php
				foreach ( $errorjson->$app_name as  $error ) {
						echo '<tr>';
							echo ' <td>' . esc_attr( $error->error ) . '</td>';
							echo '<td>' . wp_kses( $error->desc, $esc_allowed ) . '</td>';
						echo '</tr>';
				}
				?>
				</table>
				<?php
			} else {
				?>
				<blockquote class="mo_oauth_blackquote mo_oauth_paragraph_div" style="  margin-bottom: 0px;">We will address error codes for your identity provider in the future. Please contact <a href="mailto:oauthsupport@xecurify.com">oauthsupport@xecurify.com</a> for a quick resolution of the error.</blockquote>
				<?php
			}
		}
		?>
			</div>
			<div class="mo_oauth_faq">
			<table class="mo_oauth_troubleshoot_table">
				<tr class='mo_troubleshoot_heading'>
					<td style='width:40%'>Error</td>
					<td>Description</td>
				</tr>
				<?php
				foreach ( $faqjson as  $faq => $desc ) {

						echo '<tr>';
							echo ' <td>' . esc_attr( $faq ) . '</td>';
							echo '<td>' . wp_kses( $desc, $esc_allowed ) . '</td>';
						echo '</tr>';
				}
				?>
				</table>

				Please refer to this for more <b><a href = 'https://faq.miniorange.com/kb/oauth-openid-connect/' target = '_blank'>FAQs</a></b>.
			</div>
		</div>
		<script>
			jQuery(document).ready(function () {
				jQuery(".mo_oauth_errorcodes").css("display","block");
				jQuery(".mo_oauth_faq").css("display","none");
				jQuery(".mo_oauth__errorcodes_options").css("background-color", "rgb(237 243 255 / 61%)");

				jQuery(".mo_oauth__errorcodes_options").click(function (){
				jQuery(".mo_oauth__errorcodes_options").css("background-color", "rgb(237 243 255 / 61%)");
				jQuery(".mo_oauth_faq_options").css("background-color","white");
				jQuery(".mo_oauth_faq_options").css("border","none");
				jQuery(".mo_oauth_faq").css("display","none");
				jQuery(".mo_oauth_errorcodes").css("display","block");
			});

				jQuery(".mo_oauth_faq_options").click(function (){
				jQuery(".mo_oauth__errorcodes_options").css("border","none");
				jQuery(".mo_oauth__errorcodes_options").css("background-color","white");
				jQuery(".mo_oauth_faq_options").css("background-color", "rgb(237 243 255 / 61%)");
				jQuery(".mo_oauth_faq").css("display","block");
				jQuery(".mo_oauth_errorcodes").css("display","none");
			});

			});

		</script>
		<?php
	}
}
