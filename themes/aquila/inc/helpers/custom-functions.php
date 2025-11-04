<?php
/**
 * Custom functions.
 *
 * @package AquilaTheme
 */

// Constant.
const AQUILA_POST_CACHE_KEY        = 'aquila_post_cache';
const AQUILA_POST_CACHE_GROUP      = 'aquila_post';
const AQUILA_POSTS_CACHE_KEY       = 'aquila_posts_cache';
const AQUILA_POSTS_COUNT_CACHE_KEY = 'aquila_posts_count';
const AQUILA_POSTS_CACHE_GROUP     = 'aquila_posts';
const AQUILA_POSTS_EXPIRE_IN       = 60 * 60;

/**
 * Displays text escaped by aquila_kses_post method.
 *
 * @param string $data Content to escape.
 *
 * @return void
 */
function aquila_kses_post_e( string $data ): void {
	echo aquila_kses_post( $data );
}

/**
 * Extended wp_kses_post method.
 *
 * Extends wp_kses_post() by adding support for other components:
 *
 * Extends wp_kses_post() by removing support for the following:
 * // Add a list of removed support here.
 *
 * @param string $data Content to escape.
 *
 * @return string Escaped content.
 */
function aquila_kses_post( string $data ): string {
	// Fetch default allowed HTML tags.
	$kses_defaults = wp_kses_allowed_html( 'post' );

	// Allow use of SVGs.
	$allowed_tags = [
		'form'                                      => [
			'id'                      => true,
			'class'                   => true,
			'method'                  => true,
			'action'                  => true,
			'data-action'             => true,
			'novalidate'              => true,
			'enctype'                 => true,
			'data-product_id'         => true,
			'data-product_variations' => true,
		],
		'select'                                    => [
			'name'     => true,
			'class'    => true,
			'id'       => true,
			'form'     => true,
			'multiple' => true,
			'disabled' => true,
		],
		'option'                                    => [
			'value'    => true,
			'selected' => true,
		],
		'input'                                     => [
			'class'          => true,
			'type'           => true,
			'autocomplete'   => true,
			'name'           => true,
			'placeholder'    => true,
			'required'       => true,
			'checked'        => true,
			'value'          => true,
			'disabled'       => true,
			'data-taxonomy'  => true,
			'data-post-type' => true,
		],
		'textarea'                                  => [
			'id'          => true,
			'class'       => true,
			'placeholder' => true,
			'name'        => true,
			'rows'        => true,
			'disabled'    => true,
			'cols'        => true,
		],
		'svg'                                       => [
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
			'fill'            => true,
			'stroke'          => true,
		],
		'g'                                         => [ 'fill' => true ],
		'defs'                                      => true,
		'clipPath'                                  => [ 'id' => true ],
		'title'                                     => [ 'title' => true ],
		'path'                                      => [
			'd'               => true,
			'fill'            => true,
			'fill-rule'       => true,
			'clip-rule'       => true,
			'stroke'          => true,
			'stroke-linejoin' => true,
			'stroke-width'    => true,
			'opacity'         => true,
			'class'           => true,
		],
		'animatetransform'                          => [
			'attributename' => true,
			'attributetype' => true,
			'type'          => true,
			'from'          => true,
			'to'            => true,
			'begin'         => true,
			'dur'           => true,
			'repeatcount'   => true,
			'fill'          => true,
			'values'        => true,
		],
		'circle'                                    => [
			'r'            => true,
			'cx'           => true,
			'cy'           => true,
			'stroke'       => true,
			'stroke-width' => true,
		],
		'line'                                      => [
			'id'     => true,
			'x1'     => true,
			'y1'     => true,
			'x2'     => true,
			'y2'     => true,
			'stroke' => true,
		],
		'one-aquila-theme-locale-switcher'         => [
			'class' => true,
		],
		'one-aquila-sort-dropdown'                 => [
			'class' => true,
		],
		'one-aquila-toggle-search-filter-button'   => [
			'class'         => true,
			'expand-text'   => true,
			'collapse-text' => true,
		],
		'one-aquila-toggle-minimize-filter-button' => [
			'class'         => true,
			'expand-text'   => true,
			'collapse-text' => true,
		],
	];

	$accordion_web_component_args = [
		'rt-accordion'         => [
			'class' => true,
		],
		'rt-accordion-item'    => [
			'open-by-default' => true,
			'aria-expanded'   => true,
			'expanded'        => true,
			'class'           => true,
		],
		'rt-accordion-handle'  => [
			'aria-expanded' => true,
			'class'         => true,
		],
		'rt-accordion-content' => [
			'class' => true,
		],
		'button'               => [
			'aria-expanded' => true,
			'class'         => true,
			'tabindex'      => true,
			'aria-label'    => true,
			'type'          => true,
			'id'            => true,
		],
	];

	// Updated allowed HTML tags array.
	$allowed_tags = array_merge( $kses_defaults, $allowed_tags, $accordion_web_component_args );

	// Return escaped content.
	return wp_kses( $data, $allowed_tags );

}

/**
 * Generates wrapper attributes from provided attributes.
 * Appends generated wrapper attributes `$wrapper_attributes` string if provided.
 *
 * Note: Values for the keys in $extra_attributes should always be an array of strings.
 *
 * @param array<string, array<string>> $extra_attributes   Attributes from which wrapper attribute string should be generated.
 * @param string                       $wrapper_attributes Block's wrapper attributes.
 *
 * @example get_wrapper_attributes([ 'class' => [ 'class-1', 'class-2' ] ]);
 *          get_wrapper_attributes([ 'class' => [ 'class-1', 'class-2' ] ], get_block_wrapper_attributes()); // get_block_wrapper_attributes is a default WordPress function that provides block wrapper attributes.
 *
 * @return string String of generated wrapper attributes.
 */
function aquila_get_wrapper_attributes( array $extra_attributes = [], string $wrapper_attributes = '' ): string {

	// Return $wrapper_attributes if $extra_attributes are not specified.
	if ( empty( $extra_attributes ) ) {
		return $wrapper_attributes;
	}

	/**
	 * Explode default wrapper attributes.
	 *
	 * @example For button block wrapper_attributes be 'class="button-block wp-block-aquila-button-block" content="Hello World"'.
	 *          Current command will convert it to [ 'class="button-block wp-block-aquila-button-block"', 'content="Hello World"' ].
	 */
	$attributes = explode( '" ', trim( $wrapper_attributes ) );

	$normalized_attributes = [];
	$finalized_attributes  = [];

	/**
	 * Loop through an exploded wrapper attributes array i.e., $attributes and normalize them.
	 *
	 * @example [ 'class="button-block wp-block-aquila-button-block"', 'content="Hello World"' ] will be converted to
	 *          [ 'class' => [ 'button-block', 'wp-block-aquila-button-block' ], 'content' => [ 'Hello World' ] ]
	 */
	foreach ( $attributes as $attribute ) {
		$attribute = explode( '=', trim( $attribute ) );

		if ( empty( $attribute ) || 2 !== count( $attribute ) ) {
			continue;
		}

		$normalized_attributes[ trim( $attribute[0] ) ] = explode( ' ', trim( $attribute[1], ' "' ) );
	}

	/**
	 * Loop through normalized attributed and merge them with extra attributes.
	 *
	 * @example if [ 'class' => [ 'class-1', 'class-2' ] ] is passed in extra attributes,
	 *          normalized attributes array will be converted to
	 *          [
	 *              'class' => [ 'button-block', 'wp-block-aquila-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
	 *              'Content' => [ 'Hello World' ],
	 *          ]
	 */
	foreach ( $extra_attributes as $attribute_key => $attribute_value ) {

		$normalized_attributes[ $attribute_key ] = array_merge(
			array_filter( (array) ( $normalized_attributes[ $attribute_key ] ?? [] ) ),
			array_filter( (array) $attribute_value, 'is_string' )
		);
	}

	/**
	 * Merge the normalized array and create a finalized array.
	 *
	 * @example [
	 *              'class' => [ 'button-block', 'wp-block-aquila-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
	 *               'Content' => [ 'Hello World' ],
	 *          ]
	 *          will be converted to [ 'class="button-block wp-block-aquila-button-block class-1 class-2"', 'content="Hello World"' ]
	 */
	foreach ( $normalized_attributes as $attribute_key => $attribute_value ) {
		$finalized_attributes[] = $attribute_key . '="' . esc_attr( implode( ' ', $attribute_value ) ) . '"';
	}

	// Join the finalized array and return as a string.
	return implode( ' ', $finalized_attributes );
}

/**
 * Get posts.
 *
 * @param array<string, mixed> $args  Arguments for WP_Query.
 * @param bool                 $force Force a new query.
 *
 * @return int[] List of Post IDs.
 */
function aquila_get_posts( array $args = [], bool $force = false ): array {
	// Check if the arguments are empty.
	if ( empty( $args ) ) {
		return [];
	}

	// Get current language.
	$current_language = apply_filters( 'wpml_current_language', null );

	// Check if the current language is empty.
	if ( empty( $current_language ) ) {
		// Then use default language.
		$current_language = 'en';
	}

	// Default args.
	$default_args = [
		'post_status'    => 'publish',
		'posts_per_page' => 10,
	];

	// Fixed args.
	$fixed_args = [
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'cache_results'          => true,
		'ignore_sticky_posts'    => true,
	];

	// Prepare the arguments.
	$args = array_merge(
		$default_args,
		$args,
		$fixed_args
	);

	// Cache keys.
	$cache_key    = sprintf( '%s_%s_%s', AQUILA_POSTS_CACHE_KEY, $current_language, md5( strval( wp_json_encode( $args ) ) ) );
	$cached_value = wp_cache_get( $cache_key, AQUILA_POSTS_CACHE_GROUP );

	// Check for cached value.
	if ( false === $force && is_array( $cached_value ) && ! empty( $cached_value ) ) {
		return array_map( 'absint', $cached_value );
	}

	// Execute query.
	$query = new WP_Query( $args );

	// Get post.
	$post_ids = $query->posts;

	// @phpstan-ignore-next-line
	$post_ids = array_map( 'absint', $post_ids );
	$post_ids = array_filter( $post_ids );

	// Set cache to store the data.
	if ( ! empty( $post_ids ) ) {
		// @TODO: Add mechanism to clear the cache.
		wp_cache_set( $cache_key, $post_ids, AQUILA_POSTS_CACHE_GROUP, AQUILA_POSTS_EXPIRE_IN ); // phpcs:ignore WordPressVIPMinimum.Performance.LowExpiryCacheTime.CacheTimeUndetermined
	}

	return $post_ids;
}

/**
 * Get post data.
 *
 * @param int $post_id Post ID.
 *
 * @return array{
 *     post: WP_Post|null,
 *     permalink: string,
 *     post_thumbnail: int,
 *     post_meta: mixed[],
 *     post_taxonomies: mixed[],
 *     data: mixed[]
 * }
 */
function aquila_get_post( int $post_id = 0 ): array {
	// Get post ID.
	if ( 0 === $post_id ) {
		$post_id = absint( get_the_ID() );
	}

	// Check for cached version.
	$cache_key    = sprintf( '%s_%d', AQUILA_POST_CACHE_KEY, $post_id );
	$cached_value = wp_cache_get( $cache_key, AQUILA_POST_CACHE_GROUP );

	// Check for cached value.
	if ( is_array( $cached_value ) && ! empty( $cached_value['post'] ) && $cached_value['post'] instanceof WP_Post ) {
		return [
			'post'            => $cached_value['post'],
			'permalink'       => $cached_value['permalink'] ?? '',
			'post_thumbnail'  => $cached_value['post_thumbnail'] ?? 0,
			'post_meta'       => $cached_value['post_meta'] ?? [],
			'post_taxonomies' => $cached_value['post_taxonomies'] ?? [],
			'data'            => $cached_value['data'] ?? [],
		];
	}

	// Get post.
	$post = get_post( $post_id );

	// Check for post.
	if ( ! $post instanceof WP_Post ) {
		return [
			'post'            => null,
			'permalink'       => '',
			'post_thumbnail'  => 0,
			'post_meta'       => [],
			'post_taxonomies' => [],
			'data'            => [],
		];
	}

	$post->post_title = html_entity_decode( $post->post_title );

	// Build data.
	$data = [
		'post'            => $post,
		'permalink'       => strval( get_permalink( $post ) ),
		'post_thumbnail'  => absint( get_post_thumbnail_id( $post ) ),
		'post_meta'       => [],
		'post_taxonomies' => [],
		'data'            => [],
	];

	// Get all post meta.
	$meta = get_post_meta( $post->ID );
	if ( ! empty( $meta ) && is_array( $meta ) ) {
		$data['post_meta'] = array_filter(
			array_map(
				fn( $value ) => maybe_unserialize( $value[0] ?? '' ),
				$meta
			),
			fn( $key ) => ! str_starts_with( $key, '__' ),
			ARRAY_FILTER_USE_KEY
		);
	}

	// Taxonomy terms.
	global $wpdb; // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
	$taxonomy_terms = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$wpdb->prepare(
			"
			SELECT
				t.*,
				tt.taxonomy,
				tt.description,
				tt.parent
			FROM
				$wpdb->term_relationships AS tr
			LEFT JOIN
				$wpdb->term_taxonomy AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			LEFT JOIN
				$wpdb->terms AS t ON t.term_id = tt.term_taxonomy_id
			WHERE
				tr.object_id = %d
			ORDER BY
				t.name ASC
			",
			[
				$post->ID,
			]
		),
		ARRAY_A
	);

	// Check if taxonomy terms are not empty, and fill the data.
	if ( ! empty( $taxonomy_terms ) ) {
		foreach ( $taxonomy_terms as $taxonomy_term ) {
			if ( ! array_key_exists( $taxonomy_term['taxonomy'], $data['post_taxonomies'] ) ) {
				$data['post_taxonomies'][ $taxonomy_term['taxonomy'] ] = [];
			}
			$data['post_taxonomies'][ $taxonomy_term['taxonomy'] ][] = $taxonomy_term;
		}
	}

	// Apply filters to the data.
	$data['data'] = (array) apply_filters( 'one_novanta_get_post_data', $data['data'], $data, $post_id );

	// Set cache to store the data.
	wp_cache_set( $cache_key, $data, AQUILA_POST_CACHE_GROUP );

	// Return data.
	return $data;
}

/**
 * Utility function to merge class names.
 *
 * @param  mixed ...$args Any number of arguments to combine.
 *
 * @return string Combined class names.
 *
 * @example aquila_merge_classes('class1', 'class2', 'class3') => 'class1 class2 class3'
 * @example aquila_merge_classes('class1', [ 'class2' => true, 'class3' => false ]) => 'class1 class2'
 * @example aquila_merge_classes([ 'class1', 'class2' ], [ 'class3' => true, 'class4' => false ]) => 'class1 class2 class3'
 */
function aquila_merge_classes( ...$args ): string {
	$classes = [];

	foreach ( $args as $arg ) {
		if ( is_string( $arg ) ) {
			$classes[] = $arg;
		} elseif ( is_array( $arg ) ) {
			foreach ( $arg as $key => $value ) {
				if ( is_int( $key ) ) {
					// If numeric key, treat value as a class name.
					if ( $value ) {
						$classes[] = $value;
					}
				} elseif ( $value ) {
					// If string key, include it when the value is truthy.
					$classes[] = $key;
				}
			}
		}
	}

	// Filter out empty classes.
	$classes = array_filter( $classes );

	return implode( ' ', $classes );
}

/**
 * Displays the post thumbnail.
 *
 * Wraps WordPress core's the_post_thumbnail() function with a custom wrapper.
 *
 * @return void
 */
function aquila_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php
	} else {
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>
		<?php
	}
}
