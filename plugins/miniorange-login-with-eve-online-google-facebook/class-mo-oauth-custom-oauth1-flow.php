<?php
/**
 * OAuth1 Custom flow
 *
 * @package    oauth1
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Handle OAuth1.0 SSO flow.
 */
class MO_OAuth_Custom_OAuth1_Flow {

	/**
	 * Private key of the configured application.
	 *
	 * @var string private key for the configured app.
	 */
	private $key = '';
	/**
	 * Client secret of the configured application
	 *
	 * @var string client secret for the configured app.
	 */
	private $secret = '';

	/**
	 * Request Token URL
	 *
	 * @var string request token url of the configured app.
	 */
	private $request_token_url = '';
	/**
	 * Access token url
	 *
	 * @var string access token url of the configured app.
	 */
	private $access_token_url = '';
	/**
	 * User info URL
	 *
	 * @var string userinfo URL of the configured app.
	 */
	private $userinfo_url = '';

	/**
	 * Initialize OAuth1.0 app.
	 *
	 * @param mixed $client_key private key for the configured app.
	 * @param mixed $client_secret client secret for the configured app.
	 * @param mixed $request_token_url request token url of the configured app.
	 * @param mixed $access_token_url access token url of the configured app.
	 * @param mixed $userinfo_url userinfo URL of the configured app.
	 */
	public function __construct( $client_key, $client_secret, $request_token_url, $access_token_url, $userinfo_url ) {
		$this->key               = $client_key; // consumer key.
		$this->secret            = $client_secret; // secret.
		$this->request_token_url = $request_token_url;
		$this->access_token_url  = $access_token_url;
		$this->userinfo_url      = $userinfo_url;
	}

	/**
	 * Get request token
	 */
	public function mo_oauth1_get_request_token() {
		// Default params.
		$params = array(
			'oauth_version'          => '1.0',
			'oauth_nonce'            => time(),
			'oauth_timestamp'        => time(),
			'oauth_consumer_key'     => $this->key,
			'oauth_signature_method' => 'HMAC-SHA1',
		);

		if ( strpos( $this->request_token_url, '?' ) !== false ) {
				$temp                    = explode( '?', $this->request_token_url );
				$this->request_token_url = $temp[0];
				$param                   = explode( '&', $temp[1] );
			foreach ( $param as $arr ) {
				$pair               = explode( '=', $arr );
				$params[ $pair[0] ] = $pair[1];
			}
		}
		// BUILD SIGNATURE
		// encode params keys, values, join and then sort.
		$keys   = $this->mo_oauth1_url_encode_rfc3986( array_keys( $params ) );
		$values = $this->mo_oauth1_url_encode_rfc3986( array_values( $params ) );
		$params = array_combine( $keys, $values );
		uksort( $params, 'strcmp' );

		foreach ( $params as $k => $v ) {
			$pairs[] = $this->mo_oauth1_url_encode_rfc3986( $k ) . '=' . $this->mo_oauth1_url_encode_rfc3986( $v );
		}
		$concatenated_params = implode( '&', $pairs );

		$base_string = ( $concatenated_params );
		// form secret (second key).
		$base_string = str_replace( '=', '%3D', $base_string );
		$base_string = str_replace( '&', '%26', $base_string );
		$base_string = 'GET&' . $this->mo_oauth1_url_encode_rfc3986( $this->request_token_url ) . '&' . $base_string;

		$secret = $this->mo_oauth1_url_encode_rfc3986( $this->secret ) . '&';
		// make signature and append to params.
		$params['oauth_signature'] = $this->mo_oauth1_url_encode_rfc3986( base64_encode( hash_hmac( 'sha1', $base_string, $secret, true ) ) ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- base64 encoding will be required for encoding client_id and secret.

		// BUILD URL
		// Resort.
		uksort( $params, 'strcmp' );
		// convert params to string.
		foreach ( $params as $k => $v ) {
			$url_pairs[] = $k . '=' . $v;}
		$concatenated_url_params = implode( '&', $url_pairs );
		// form url.
		$url = $this->request_token_url . '?' . $concatenated_url_params;
		// Send to cURL.
		$response = $this->mo_oauth1_https( $url );

		$respone_parse = explode( '&', $response );

		$oauth_token_ret = '';

		foreach ( $respone_parse as $key ) {
			$arg_parse = explode( '=', $key );
			if ( 'oauth_token' === $arg_parse[0] ) {
				$oauth_token_ret = $arg_parse[1];
			} elseif ( 'oauth_token_secret' === $arg_parse[0] ) {
				setcookie( 'mo_ts', $arg_parse[1], time() + 30, null, null, true, true );
			}
		}

		return $oauth_token_ret;
	}

	/**
	 * Get access token.
	 *
	 * @param mixed $oauth_verifier oauth verifier string.
	 * @param mixed $mo_oauth1_oauth_token oauth token.
	 */
	public function mo_oauth1_get_access_token( $oauth_verifier, $mo_oauth1_oauth_token ) {
		$params = array(
			'oauth_version'          => '1.0',
			'oauth_nonce'            => time(),
			'oauth_timestamp'        => time(),
			'oauth_consumer_key'     => $this->key,
			'oauth_token'            => $mo_oauth1_oauth_token,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_verifier'         => $oauth_verifier,
		);

		$keys   = $this->mo_oauth1_url_encode_rfc3986( array_keys( $params ) );
		$values = $this->mo_oauth1_url_encode_rfc3986( array_values( $params ) );
		$params = array_combine( $keys, $values );
		uksort( $params, 'strcmp' );

		foreach ( $params as $k => $v ) {
			$pairs[] = $this->mo_oauth1_url_encode_rfc3986( $k ) . '=' . $this->mo_oauth1_url_encode_rfc3986( $v );
		}
		$concatenated_params = implode( '&', $pairs );

		$base_string = ( $concatenated_params );
		// form secret (second key).
		$base_string = str_replace( '=', '%3D', $base_string );
		$base_string = str_replace( '&', '%26', $base_string );

		$base_string = 'GET&' . $this->mo_oauth1_url_encode_rfc3986( $this->access_token_url ) . '&' . $base_string;

		$mo_ts                     = isset( $_COOKIE['mo_ts'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['mo_ts'] ) ) : '';
		$secret                    = $this->mo_oauth1_url_encode_rfc3986( $this->secret ) . '&' . $mo_ts;
		$params['oauth_signature'] = $this->mo_oauth1_url_encode_rfc3986( base64_encode( hash_hmac( 'sha1', $base_string, $secret, true ) ) ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 will be required for encoding base string and secret.

		uksort( $params, 'strcmp' );
		foreach ( $params as $k => $v ) {
			$url_pairs[] = $k . '=' . $v;}
		$concatenated_url_params = implode( '&', $url_pairs );
		$url                     = $this->access_token_url . '?' . $concatenated_url_params;

		$response = $this->mo_oauth1_https( $url );
		return $response;
	}

	/**
	 * Get profile signature.
	 *
	 * @param mixed  $oauth_token OAuth token.
	 * @param mixed  $oauth_token_secret oauth token secret.
	 * @param string $screen_name screen name.
	 */
	public function mo_oauth1_get_profile_signature( $oauth_token, $oauth_token_secret, $screen_name = '' ) {
		$params = array(
			'oauth_version'          => '1.0',
			'oauth_nonce'            => time(),
			'oauth_timestamp'        => time(),
			'oauth_consumer_key'     => $this->key,
			'oauth_token'            => $oauth_token,
			'oauth_signature_method' => 'HMAC-SHA1',
		);

		if ( strpos( $this->userinfo_url, '?' ) !== false ) {
			$temp               = explode( '?', $this->userinfo_url );
			$this->userinfo_url = $temp[0];
			$param              = explode( '&', $temp[1] );
			foreach ( $param as $arr ) {
				$pair               = explode( '=', $arr );
				$params[ $pair[0] ] = $pair[1];
			}
		}

		$keys   = $this->mo_oauth1_url_encode_rfc3986( array_keys( $params ) );
		$values = $this->mo_oauth1_url_encode_rfc3986( array_values( $params ) );
		$params = array_combine( $keys, $values );
		uksort( $params, 'strcmp' );

		foreach ( $params as $k => $v ) {
			$pairs[] = $this->mo_oauth1_url_encode_rfc3986( $k ) . '=' . $this->mo_oauth1_url_encode_rfc3986( $v );
		}
		$concatenated_params = implode( '&', $pairs );

		$base_string = 'GET&' . $this->mo_oauth1_url_encode_rfc3986( $this->userinfo_url ) . '&' . $this->mo_oauth1_url_encode_rfc3986( $concatenated_params );

		$secret                    = $this->mo_oauth1_url_encode_rfc3986( $this->secret ) . '&' . $this->mo_oauth1_url_encode_rfc3986( $oauth_token_secret );
		$params['oauth_signature'] = $this->mo_oauth1_url_encode_rfc3986( base64_encode( hash_hmac( 'sha1', $base_string, $secret, true ) ) ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 will be required for encoding base string and secret.

		uksort( $params, 'strcmp' );
		foreach ( $params as $k => $v ) {
			$url_pairs[] = $k . '=' . $v;}
		$concatenated_url_params = implode( '&', $url_pairs );
		$url                     = $this->userinfo_url . '?' . $concatenated_url_params;

		$args = array();

		$get_response        = wp_remote_get( $url, $args );
		$profile_json_output = json_decode( $get_response['body'], true );

		return $profile_json_output;
	}

	/**
	 * Handle API requests.
	 *
	 * @param mixed $url API url.
	 * @param null  $post_data request body of API call.
	 */
	public function mo_oauth1_https( $url, $post_data = null ) {
		if ( isset( $post_data ) ) {
			$args = array(
				'method'      => 'POST',
				'body'        => $post_data,
				'timeout'     => '15',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
			);

			$post_response = wp_remote_post( $url, $args );
			return $post_response['body'];
		}
		$args = array();

		$get_response = wp_remote_get( $url, $args );

		if ( is_wp_error( $get_response ) ) {
			MOOAuth_Debug::mo_oauth_log( 'Invalid response recieved. Please contact your administrator for more information.' );
			MOOAuth_Debug::mo_oauth_log( $get_response );
			wp_die( esc_html( $get_response ) );
		}

		$response = $get_response['body'];
		return $response;
	}

	/**
	 * URL encode.
	 *
	 * @param mixed $input variable for url encode.
	 */
	public function mo_oauth1_url_encode_rfc3986( $input ) {
		if ( is_array( $input ) ) {
			return array_map( array( 'MO_OAuth_Custom_OAuth1_Flow', 'mo_oauth1_url_encode_rfc3986' ), $input );
		} elseif ( is_scalar( $input ) ) {
			return str_replace( '+', ' ', str_replace( '%7E', '~', rawurlencode( $input ) ) );
		} else {
			return '';
		}
	}
}
