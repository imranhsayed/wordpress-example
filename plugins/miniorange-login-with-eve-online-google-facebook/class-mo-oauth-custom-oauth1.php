<?php
/**
 * OAuth1 SSO
 *
 * @package    oauth1
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Adding required files
 */

require_once 'class-mo-oauth-custom-oauth1-flow.php';

/**
 * Handle Authorization and Token request for OAuth1.0 protocol.
 */
class MO_OAuth_Custom_OAuth1 {

	/**
	 * Handle OAuth1.0 request
	 *
	 * @param mixed $appname configured appname.
	 */
	public static function mo_oauth1_auth_request( $appname ) {
		$appslist      = maybe_unserialize( get_option( 'mo_oauth_apps_list' ) );
		$client_id     = $appslist[ $appname ]['clientid'];
		$client_secret = $appslist[ $appname ]['clientsecret'];

		$authorize_url     = $appslist[ $appname ]['authorizeurl'];
		$request_token_url = $appslist[ $appname ]['requesturl'];
		$access_token_url  = $appslist[ $appname ]['accesstokenurl'];
		$userinfo_url      = $appslist[ $appname ]['resourceownerdetailsurl'];

		$oauth1_getrequest_object = new MO_OAuth_Custom_OAuth1_Flow( $client_id, $client_secret, $request_token_url, $access_token_url, $userinfo_url );
		$request_token            = $oauth1_getrequest_object->mo_oauth1_get_request_token();
		if ( strpos( $authorize_url, '?' ) === false ) {
			$authorize_url .= '?';
		}
		$login_dialog_url = $authorize_url . 'oauth_token=' . $request_token;
		if ( '' === $request_token || null === $request_token ) {

			wp_die( 'Invalid token received. Contact to your admimistrator for more information.' );
		}
		header( 'Location: ' . $login_dialog_url );
		exit;
	}

	/**
	 * Get access token for OAuth1.0 protocol.
	 *
	 * @param mixed $appname appname for configured OAuth1.0 app.
	 */
	public static function mo_oidc1_get_access_token( $appname ) {
		$dirs                  = ! empty( $_SERVER['REQUEST_URI'] ) ? explode( '&', sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';
		$oauth_verifier        = explode( '=', $dirs[1] );
		$mo_oauth1_oauth_token = explode( '=', $dirs[0] );

		$appslist       = get_option( 'mo_oauth_apps_list' );
		$currentappname = $appname;
		$currentapp     = null;
		foreach ( $appslist as $key => $app ) {
			if ( $appname === $key ) {
				$currentapp = $app;
				break;
			}
		}

		$appslist          = maybe_unserialize( get_option( 'mo_oauth_apps_list' ) );
		$client_id         = $appslist[ $appname ]['clientid'];
		$client_secret     = $appslist[ $appname ]['clientsecret'];
		$request_token_url = $appslist[ $appname ]['requesturl'];
		$access_token_url  = $appslist[ $appname ]['accesstokenurl'];
		$userinfo_url      = $appslist[ $appname ]['resourceownerdetailsurl'];

		$mo_oauth1_getaccesstoken_object = new MO_OAuth_Custom_OAuth1_Flow( $client_id, $client_secret, $request_token_url, $access_token_url, $userinfo_url );
		$oauth_token                     = $mo_oauth1_getaccesstoken_object->mo_oauth1_get_access_token( $oauth_verifier[1], $mo_oauth1_oauth_token[1] );

		$response_parse = explode( '&', $oauth_token );

		$oa_token  = '';
		$oa_secret = '';

		foreach ( $response_parse as $key ) {
			$arg_parse = explode( '=', $key );
			if ( 'oauth_token' === $arg_parse[0] ) {
				$oa_token = $arg_parse[1];
			} elseif ( 'oauth_token_secret' === $arg_parse[0] ) {
				$oa_secret = $arg_parse[1];
			}
		}

		$mo_oauth1_get_profile_signature_object = new MO_OAuth_Custom_OAuth1_Flow( $client_id, $client_secret, $request_token_url, $access_token_url, $userinfo_url );
		$oauth_access_token1                    = isset( $oauth_access_token[1] ) ? $oauth_access_token[1] : '';
		$oauth_token_secret1                    = isset( $oauth_token_secret[1] ) ? $oauth_token_secret[1] : '';
		$screen_name1                           = isset( $screen_name[1] ) ? $screen_name[1] : '';

		$profile_json_output = $mo_oauth1_get_profile_signature_object->mo_oauth1_get_profile_signature( $oa_token, $oa_secret );
		if ( ! isset( $profile_json_output ) ) {
			wp_die( 'Invalid Configurations. Please contact to the admimistrator for more information' );
		}
		return $profile_json_output;
	}

}
