<?php
/**
 * Class to handle loading latest articles block related posts via REST API.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\API;

use WP_REST_Request;
use WP_REST_Response;
use OneNovanta\Controllers\Common\Template;
use WP_Post;
use WP_Term;

/**
 * Class ProductSearchFilter handling latest-articles block API requests.
 */
class LatestArticles extends RestApiBase {
	/**
	 * HTTP Method i.e. GET|POST|PUT|DELETE|...
	 *
	 * @var string $method
	 */
	private static $method = 'GET';

	/**
	 * Register the custom REST endpoint.
	 *
	 * @return void
	 */
	public function rest_action_callback_function(): void {
		$this->register_custom_route(
			self::$route_namespace,
			'/latest-articles',
			self::$method,
			'handle_latest_articles_request',
			'permission_check'
		);
	}

	/**
	 * Permission callback for the route.
	 *
	 * @return bool
	 */
	public function permission_check(): bool {
		return true;
	}

	/**
	 * Handle the Latest Articles API request.
	 *
	 * @param WP_REST_Request $request The REST API request.
	 *
	 * @return WP_REST_Response
	 */
	public function handle_latest_articles_request( WP_REST_Request $request ): WP_REST_Response {
		$nonce = $request->get_header( 'X-WP-Nonce' );

		if ( empty( $nonce ) || false === wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_REST_Response(
				[ 'message' => 'Action not allowed.' ],
				403
			);
		}

		$page            = (int) ( $request->get_param( 'page' ) ?? 1 );
		$number_of_posts = (int) ( $request->get_param( 'numberOfPostsToLoad' ) ?? 5 );
		$custom_query    = $request->get_param( 'query' );

		$default_query = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $number_of_posts,
			'paged'          => $page,
		];

		if ( is_string( $custom_query ) ) {
			$custom_query = json_decode( urldecode( $custom_query ), true );
		}

		// Get the block template from custom query, and remove it for final args.
		$block_template = $custom_query['block_template'] ?? 'tiles';
		unset( $custom_query['block_template'] );

		$args = wp_parse_args( $custom_query ?? [], $default_query );

		$latest_articles = [];

		if ( function_exists( 'one_novanta_fetch_latest_articles' ) ) {
			$latest_articles = one_novanta_fetch_latest_articles( $args, $block_template );
		}

		if ( empty( $latest_articles ) ) {
			return rest_ensure_response(
				[
					'content'      => '',
					'count'        => 0,
					'totalResults' => 0,
				]
			);
		}

		return rest_ensure_response( [ ...$latest_articles ] );
	}
}
