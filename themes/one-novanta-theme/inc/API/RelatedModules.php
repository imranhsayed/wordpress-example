<?php
/**
 * REST endpoint to fetch related modules data.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\API;

use WP_Error;
use WP_REST_Response;
use WP_REST_Request;
use WP_REST_Server;
use WP_Post;
use OneNovanta\Controllers\Common\Template;

/**
 * Class to handle loading related modules via REST API.
 */
class RelatedModules extends RestApiBase {

	/**
	 * Register the custom REST endpoint.
	 *
	 * @return void
	 */
	public function rest_action_callback_function(): void {
		$this->register_custom_route(
			self::$route_namespace,
			'/product/related-modules/(?P<id>[\d]+)',
			WP_REST_Server::READABLE,
			'get_item',
			'permission_check'
		);
	}

	/**
	 * Get related modules data.
	 *
	 * @return bool
	 */
	public function permission_check(): bool {
		return true;
	}

	/**
	 * Handle the get related modules API request.
	 *
	 * @param WP_REST_Request|null $request The REST API request.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function get_item( ?WP_REST_Request $request = null ): WP_REST_Response|WP_Error {
		// Check if the request is valid.
		if ( ! $request instanceof WP_REST_Request ) {
			return new WP_Error( 'rest_invalid_request', 'Invalid request.', [ 'status' => 400 ] );
		}

		// Product or Variation ID.
		$object_id = absint( $request->get_param( 'id' ) );

		// Check if the object ID is valid.
		if ( empty( $object_id ) ) {
			return new WP_Error( 'rest_invalid_object_id', 'Invalid object ID.', [ 'status' => 400 ] );
		}

		// Get the object data.
		$object = one_novanta_get_post( $object_id );

		// Check if the object is valid.
		if ( ! $object['post'] instanceof WP_Post ) {
			return new WP_Error( 'rest_object_not_found', 'Object not found.', [ 'status' => 404 ] );
		}

		// Check if the object type is valid.
		if ( ! in_array( $object['post']->post_type, [ 'product', 'product_variation' ], true ) ) {
			return new WP_Error( 'rest_invalid_object_type', 'Invalid object type.', [ 'status' => 400 ] );
		}

		// Get the request parameters.
		$page            = absint( $request->get_param( 'page' ) ?? 1 );
		$number_of_posts = absint( $request->get_param( 'numberOfPostsToLoad' ) ?? 6 );
		$query           = $request->get_param( 'query' );

		// Prepare the query.
		if ( ! empty( $query ) && is_string( $query ) ) {
			$query = json_decode( urldecode( $query ), true );
		}

		// Get Related Modules.
		$related_modules = $object['post_meta']['related_modules'] ?? [];

		// Check if related modules are empty.
		if ( empty( $related_modules ) ) {
			return new WP_Error( 'rest_no_related_modules', 'No related modules found.', [ 'status' => 404 ] );
		}

		// Prepare the query.
		$query = array_merge(
			$query,
			[
				'posts_per_page' => $number_of_posts,
				'paged'          => $page,
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'post__in'       => $related_modules,
			]
		);

		// Get the results.
		$total_results = one_novanta_get_posts_count( $query );
		$post_ids      = one_novanta_get_posts( $query );
		$product_cards = [];

		foreach ( $post_ids as $the_post_id ) {
			// Get product data.
			$product_data = one_novanta_get_product_data( $the_post_id );

			// Check if the product data is empty.
			if ( empty( $product_data ) ) {
				continue;
			}

			// Add "Add to Quote" button.
			$product_data['has_cta'] = true;
			$product_data['post_id'] = $the_post_id;

			// Get the product image.
			$product_cards[] = Template::get_component(
				'cards',
				'product',
				$product_data
			);
		}

		// Send the response.
		return rest_ensure_response(
			[
				'count'        => count( $post_ids ),
				'totalResults' => $total_results,
				'content'      => implode( "\n", $product_cards ),
			]
		);
	}
}
