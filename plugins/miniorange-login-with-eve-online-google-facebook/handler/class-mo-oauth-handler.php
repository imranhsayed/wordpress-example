<?php
/**
 * OAuth Handler
 *
 * @package    oauth-handler
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * [Description Handle OAuth token, and resource_owner_info API]
 */
class MO_OAuth_Handler {

	/**
	 * Get Access Token
	 *
	 * @param mixed $tokenendpoint token endpoint of OAuth/OpendID provider.
	 * @param mixed $grant_type grant type of OAuth/OpendID provider.
	 * @param mixed $clientid client ID of OAuth/OpendID provider.
	 * @param mixed $clientsecret client secret of OAuth/OpendID provider.
	 * @param mixed $code authorization code obtained from OAuth/OpendID provider.
	 * @param mixed $redirect_url redirect URL configured in the plugin.
	 * @param mixed $send_headers sending information in Header of API request.
	 * @param mixed $send_body sending information in Body of API request.
	 *
	 * @return [string]
	 */
	public function get_access_token( $tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url, $send_headers, $send_body ) {

		$response = $this->get_token( $tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url, $send_headers, $send_body );
		$content  = json_decode( $response, true );

		if ( isset( $content['access_token'] ) ) {
			return $content['access_token'];
		} else {
			MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ERROR : Invalid response received from OAuth Provider. Contact your administrator for more details. ' . esc_html( $response ) );
			echo 'Invalid response received from OAuth Provider. Contact your administrator for more details.<br><br><b>Response : </b><br>' . esc_html( $response );
			exit;
		}
	}

	/**
	 * Fetch Access Token
	 *
	 * @param mixed $tokenendpoint token endpoint of OAuth/OpendID provider.
	 * @param mixed $grant_type grant type of OAuth/OpendID provider.
	 * @param mixed $clientid client ID of OAuth/OpendID provider.
	 * @param mixed $clientsecret client secret of OAuth/OpendID provider.
	 * @param mixed $code authorization code obtained from OAuth/OpendID provider.
	 * @param mixed $redirect_url redirect URL configured in the plugin.
	 * @param mixed $send_headers sending information in Header of API request.
	 * @param mixed $send_body sending information in Body of API request.
	 * @return [string]
	 */
	public function get_token( $tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url, $send_headers, $send_body ) {

		MOOAuth_Debug::mo_oauth_log( 'Token request content => ' );

		$clientsecret = html_entity_decode( $clientsecret );
		$body         = array(
			'grant_type'    => $grant_type,
			'code'          => $code,
			'client_id'     => $clientid,
			'client_secret' => $clientsecret,
			'redirect_uri'  => $redirect_url,
		);
		$headers      = array(
			'Accept'        => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic ' . base64_encode( $clientid . ':' . $clientsecret ), //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 encoding of client id and secret will be required for sending Authentication header in Token request.
			'Content-Type'  => 'application/x-www-form-urlencoded',
		);
		if ( $send_headers && ! $send_body ) {
				unset( $body['client_id'] );
				unset( $body['client_secret'] );
		} elseif ( ! $send_headers && $send_body ) {
				unset( $headers['Authorization'] );
		}
		MOOAuth_Debug::mo_oauth_log( 'Token Request Sent => ' . $tokenendpoint );
		MOOAuth_Debug::mo_oauth_log( 'body =>' );
		MOOAuth_Debug::mo_oauth_log( $body );
		MOOAuth_Debug::mo_oauth_log( 'headers =>' );
		MOOAuth_Debug::mo_oauth_log( $headers );

		$response = wp_remote_post(
			$tokenendpoint,
			array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'body'        => $body,
				'cookies'     => array(),
				'sslverify'   => false,
			)
		);
		if ( is_wp_error( $response ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ERROR : Invalid response recieved while fetching token' );
			MOOAuth_Debug::mo_oauth_log( 'Invalid response recieved while fetching token' );
			MOOAuth_Debug::mo_oauth_log( $response );
			wp_die( $response ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $response is escaped before being passed in.
		}
		$response = $response['body'];
		MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ' . $response );
		if ( ! is_array( json_decode( $response, true ) ) ) {
			echo '<b>Response : </b><br>' . esc_html( $response );
			echo '<br><br>';
			MOOAuth_Debug::mo_oauth_log( 'Invalid response received.' );
			if ( isset( $response['body'] ) ) {
				MOOAuth_Debug::mo_oauth_log( $response['body'] );
			}
			exit( 'Invalid response received.' );
		}

		$content = json_decode( $response, true );
		if ( isset( $content['error_description'] ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ERROR : ' . $content['error_description'] );
			exit( esc_html( $content['error_description'] ) );
		} elseif ( isset( $content['error'] ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ERROR : ' . $content['error'] );
			exit( esc_html( $content['error'] ) );
		}

		return $response;
	}

	/**
	 * Fetch ID token of OpenID provider.
	 *
	 * @param mixed $tokenendpoint token endpoint of OAuth/OpendID provider.
	 * @param mixed $grant_type grant type of OAuth/OpendID provider.
	 * @param mixed $clientid client ID of OAuth/OpendID provider.
	 * @param mixed $clientsecret client secret of OAuth/OpendID provider.
	 * @param mixed $code authorization code obtained from OAuth/OpendID provider.
	 * @param mixed $redirect_url redirect URL configured in the plugin.
	 * @param mixed $send_headers sending information in Header of API request.
	 * @param mixed $send_body sending information in Body of API request.
	 * @return [string]
	 */
	public function get_id_token( $tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url, $send_headers, $send_body ) {
		MOOAuth_Debug::mo_oauth_log( 'Token Request Sent' );
		$response = $this->get_token( $tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url, $send_headers, $send_body );
		$content  = json_decode( $response, true );
		if ( isset( $content['id_token'] ) || isset( $content['access_token'] ) ) {
			return $content;
		} else {
			MOOAuth_Debug::mo_oauth_log( 'Token Response Received => ERROR : Invalid response received from OpenId Provider. Contact your administrator for more details. Response : ' . esc_html( $response ) );
			echo 'Invalid response received from OpenId Provider. Contact your administrator for more details.<br><br><b>Response : </b><br>' . esc_html( $response );
			exit;
		}
	}

	/**
	 * Get user information from id_token obtained from OpenID provider.
	 *
	 * @param mixed $id_token id_token obtained from OpenID provider.
	 * @return [array]
	 */
	public function get_resource_owner_from_id_token( $id_token ) {
		$id_array = explode( '.', $id_token );
		if ( isset( $id_array[1] ) ) {
			$id_body = base64_decode( str_pad( strtr( $id_array[1], '-_', '+/' ), strlen( $id_array[1] ) % 4, '=', STR_PAD_RIGHT ) ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- base64 will be required for getting contents from JWT token.
			if ( is_array( json_decode( $id_body, true ) ) ) {
				return json_decode( $id_body, true );
			}
		}
		MOOAuth_Debug::mo_oauth_log( 'Invalid response received while fetching Id token from the Resource Owner. Id_token : ' . esc_html( $id_token ) );
		echo 'Invalid response received.<br><b>Id_token : </b>' . esc_html( $id_token );
		exit;
	}

	/**
	 * Get user information from id_token obtained from OAuth/OpenID provider
	 *
	 * @param mixed $resourceownerdetailsurl endpoint to fetch user information from OAuth/OpenID provider.
	 * @param mixed $access_token access token obtained from OAuth/OpenID provider.
	 * @return [array|string]
	 */
	public function get_resource_owner( $resourceownerdetailsurl, $access_token ) {
		$headers                  = array();
		$headers['Authorization'] = 'Bearer ' . $access_token;

		MOOAuth_Debug::mo_oauth_log( 'Resource Owner request content => ' );
		MOOAuth_Debug::mo_oauth_log( 'headers =>' );
		MOOAuth_Debug::mo_oauth_log( $headers );
		MOOAuth_Debug::mo_oauth_log( 'Resource Owner Endpoint: ' . $resourceownerdetailsurl );

		$response = wp_remote_post(
			$resourceownerdetailsurl,
			array(
				'method'      => 'GET',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'cookies'     => array(),
				'sslverify'   => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Invalid response recieved while fetching resource owner details' );
			MOOAuth_Debug::mo_oauth_log( $response );
			wp_die( esc_html( $response ) );
		}

		$response = $response['body'];

		if ( ! is_array( json_decode( $response, true ) ) ) {
			$response = addcslashes( $response, '\\' );
			if ( ! is_array( json_decode( $response, true ) ) ) {
				echo '<b>Response : </b><br>' . esc_html( $response );
				echo '<br><br>';
				MOOAuth_Debug::mo_oauth_log( 'Invalid response received.' );
				exit( 'Invalid response received.' );
			}
		}

		$content = json_decode( $response, true );
		if ( isset( $content['error_description'] ) ) {
			MOOAuth_Debug::mo_oauth_log( $content['error_description'] );
			exit( esc_html( $content['error_description'] ) );
		} elseif ( isset( $content['error'] ) ) {
			MOOAuth_Debug::mo_oauth_log( $content['error'] );
			exit( esc_html( $content['error'] ) );
		}
		return $content;
	}
}
