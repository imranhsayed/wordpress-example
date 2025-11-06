<?php
/**
 * Filter search results by Post Type selected in filter on Search page class.
 *
 * @package rt-blocks
 */

namespace OneNovanta\Theme\Classes;

use OneNovanta\Traits\Singleton;

/**
 * Class Search Post Type Filter
 */
class Search_Post_Type_Filter {

	/**
	 * Singleton instance.
	 */
	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 */
	protected function setup_hooks(): void {

		/**
		 * Actions.
		 */
		add_action( 'pre_get_posts', array( $this, 'filter_posts' ) );
	}

	/**
	 * Filter search results by post type selected in filter.
	 *
	 * @param \WP_Query $query Query object.
	 *
	 * @return void
	 */
	public function filter_posts( $query ): void {

		// Check if it's admin or not main query.
		if ( is_admin()
			|| ! $query->is_main_query()
			|| ! $query->is_search() ) {
			return;
		}

		// Check if is_post_type_filter, post_type and taxonomy is set in query string.
		if ( isset( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			$post_type = sanitize_text_field( wp_unslash( $_GET['post_type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( ! empty( $post_type ) ) {
				$query->set( 'post_type', $post_type );
			}
		}

		// Get current language.
		$current_language = apply_filters( 'wpml_current_language', null );

		// Check if the current language is empty.
		if ( empty( $current_language ) ) {
			// Then use default language.
			$current_language = 'en';
		}

		$meta_query = $query->get( 'meta_query', [] );

		$meta_query[] = [
			'key'     => 'novanta_language',
			'value'   => $current_language,
			'compare' => '=',
		];

		$query->set( 'meta_query', $meta_query );
	}
}
