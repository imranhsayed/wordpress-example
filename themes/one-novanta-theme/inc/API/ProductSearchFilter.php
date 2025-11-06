<?php
/**
 * Class to handle loading custom posts via REST API.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\API;

use WP_REST_Request;
use WP_REST_Response;
use OneNovanta\Controllers\Common\Template;
use WP_Post;
use const ATI\WooCommerce\ALLOWED_PRODUCT_TYPES;

/**
 * Class ProductSearchFilter handling product search filter block API requests.
 */
class ProductSearchFilter extends RestApiBase {
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
			'/load-product-posts',
			self::$method,
			'handle_product_filter_request',
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
	 * Handle the load posts API request.
	 *
	 * @param WP_REST_Request $request The REST API request.
	 *
	 * @return WP_REST_Response
	 */
	public function handle_product_filter_request( WP_REST_Request $request ): WP_REST_Response {
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
			'post_type'       => 'product',
			'post_status'     => 'publish',
			'posts_per_page'  => $number_of_posts,
			'paged'           => $page,
			'has_add_to_cart' => false,
		];

		if ( is_string( $custom_query ) ) {
			$custom_query = json_decode( urldecode( $custom_query ), true );
		}

		$args = wp_parse_args( $custom_query ?? [], $default_query );


		// Get the heading-level.
		$heading_level = $args['heading_level'] ?? 'h3';
		unset( $args['heading_level'] );

		$post_ids    = one_novanta_get_posts( $args );
		$posts_count = one_novanta_get_posts_count( $args );

		$response_content = '';

		// Return early if no posts found.
		if ( empty( $post_ids ) ) {
			return rest_ensure_response(
				[
					'count'        => 0,
					'totalResults' => $posts_count,
					'content'      => $response_content,
				]
			);
		}

		foreach ( $post_ids as $the_post_id ) {

			$card_data = one_novanta_get_post_card_data( $the_post_id );

			if ( empty( $card_data ) ) {
				continue;
			}

			$card_data = array_merge(
				$card_data,
				[
					'heading_level'   => $heading_level,
					'post_type'       => $args['post_type'],
					'has_add_to_cart' => $custom_query['has_add_to_cart'],
				]
			);

			$response_content .= Template::get_component(
				'cards',
				'product',
				$card_data,
			);
		}

		return rest_ensure_response(
			[
				'content'      => $response_content,
				'count'        => count( $post_ids ),
				'totalResults' => $posts_count,
			]
		);
	}
}
