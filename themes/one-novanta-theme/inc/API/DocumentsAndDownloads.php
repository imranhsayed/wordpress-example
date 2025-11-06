<?php
/**
 * API for the Documents and Downloads block.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\API;

use WP_Error;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Class DocumentsAndDownloads
 * Handles REST API endpoints for Documents and Downloads functionality
 *
 * @method static DocumentsAndDownloads get_instance() Returns the singleton instance of DocumentsAndDownloads
 */
class DocumentsAndDownloads extends RestApiBase {
	/**
	 * Register the REST API routes using base class.
	 *
	 * @return void
	 */
	public function rest_action_callback_function() {
		$this->register_custom_route(
			self::$route_namespace,
			'/documents',
			WP_REST_Server::READABLE,
			'get_documents',
			'permission_check',
			[
				'page'           => [
					'description'       => 'Current page number',
					'type'              => 'integer',
					'default'           => 1,
					'sanitize_callback' => 'absint',
				],
				'per_page'       => [
					'description'       => 'Number of items per page',
					'type'              => 'integer',
					'default'           => 10,
					'sanitize_callback' => 'absint',
				],
				'search_keyword' => [
					'description'       => 'Search keyword from filter',
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				],
				'document_type'  => [
					'description'       => 'Document type filter',
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				],
				'language'       => [
					'description'       => 'Language filter',
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				],
			],
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
	 * Get a collection of documents.
	 *
	 * @param WP_REST_Request|null $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_documents( WP_REST_Request|null $request = null ): WP_REST_Response|WP_Error {

		if ( empty( $request ) ) {
			return new WP_REST_Response(
				[ 'message' => 'Action not allowed.' ],
				403
			);
		}

		$nonce = $request->get_header( 'X-WP-Nonce' );

		if ( empty( $nonce ) || false === wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_REST_Response(
				[ 'message' => 'Action not allowed.' ],
				403
			);
		}

		global $sitepress;
		$page     = $request->get_param( 'page' );
		$per_page = $request->get_param( 'per_page' );

		// Get search_keyword, document_type, and language from the request.
		$search_keyword = $request->get_param( 'search_keyword' );
		$document_type  = $request->get_param( 'document_type' );
		$language       = $request->get_param( 'language' );
		$request_query  = $request->get_param( 'query' );

		// Get the first key from the query array, the data is in the first key of the object.
		$request_query = array_keys( wp_parse_args( $request_query ) )[0];

		// If query is provided, add it to the query.
		if ( ! empty( $request_query ) ) {
			// Convert the query string to an array.
			$request_query = json_decode( $request_query );

			$search_keyword = $request_query->search_keyword ?? null;
			$document_type  = $request_query->document_type ?? null;
			$language       = $request_query->language ?? null;
		}

		// Set default values for page and per_page if they are not provided.
		$page     = $page ? $page : 1;
		$per_page = $per_page ? $per_page : 10;

		$fetched_documents = one_novanta_get_documents(
			[
				'page'           => $page,
				'per_page'       => $per_page,
				'document_type'  => $document_type,
				'language'       => $language,
				'search_keyword' => $search_keyword,
			]
		);

		return rest_ensure_response(
			$fetched_documents
		);
	}
}
