<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Determine if we are serving a REST request.
$is_rest_request = wp_is_serving_rest_request();

// Initialize default variation ID.
$default_variation_id = 0;

// Get post ID.
$the_post_id = $attributes['post_id'] ?? get_the_ID();

// Bail out if the post ID is not set.
if ( empty( $the_post_id ) ) {
	return;
}

// Get the post data.
$the_post = one_novanta_get_post( $the_post_id );

// Check if the post data is empty.
if ( ! $the_post['post'] instanceof WP_Post ) {
	return;
}

// Get Product data.
$post_data = $the_post['data'] ?? [];
$post_meta = $the_post['post_meta'] ?? [];

// Product Type.
$product_type = $post_data['product_type'] ?? '';

// If we are using global Post ID and the product type is variable, we need to get the default variation data.
if ( ! $is_rest_request && 'variable' === $product_type ) {
	// Get the default variation ID.
	$default_variation_id = $post_data['default_variation_id'] ?? 0;

	if ( ! empty( $default_variation_id ) ) {
		// Get the default variation data.
		$the_variation = one_novanta_get_post( $default_variation_id );

		// Check if the variation data is empty.
		if ( $the_variation['post'] instanceof WP_Post ) {
			// Update post ID.
			$the_post_id = $default_variation_id;

			// Get post meta from the variation.
			$post_meta = $the_variation['post_meta'] ?? [];
		}
	}
}

// Get Related Modules.
$related_modules = $post_meta['related_modules'] ?? [];

// Sanitize the field value.
$related_modules = array_filter( array_map( 'absint', (array) $related_modules ) );

if ( empty( $related_modules ) ) {
	// If no related modules, return early.
	return;
}

// Initialize variables.
$posts_per_page = 6;
$the_post_type  = 'product';
$result_count   = 0;
$product_cards  = [];

// Filter items.
$product_category_filter_items = [];
$product_tag_filter_items      = [];

// Loop through the rows and display the data.
foreach ( $related_modules as $related_module ) {
	// Get the product data.
	$the_post = one_novanta_get_post( $related_module );

	// Check if the product data is empty.
	if ( ! $the_post['post'] instanceof WP_Post ) {
		continue;
	}

	++$result_count;

	// Get Taxonomies.
	$taxonomies = $the_post['post_taxonomies'] ?? [];

	// Get product category and tags.
	$product_categories = $taxonomies['product_cat'] ?? [];
	$product_tags       = $taxonomies['product_tag'] ?? [];

	// Get product category filter items.
	foreach ( $product_categories as $product_category ) {
		// Get term ID.
		$term_id = $product_category['term_id'];

		if ( empty( $term_id ) || ! empty( $product_category_filter_items[ $term_id ] ) ) {
			continue;
		}

		$product_category_filter_items[ $term_id ] = [
			'label' => $product_category['name'],
			'value' => $term_id,
		];
	}

	// Get product tag filter items.
	foreach ( $product_tags as $product_tag ) {
		// Get term ID.
		$term_id = $product_tag['term_id'];

		if ( empty( $term_id ) || ! empty( $product_tag_filter_items[ $term_id ] ) ) {
			continue;
		}

		$product_tag_filter_items[ $term_id ] = [
			'label' => $product_tag['name'],
			'value' => $term_id,
		];
	}
}

/**
 * Generate and Add Product card data.
 *
 * Do query for product instead of directly using related modules. to prevent duplication of posts.
 */
$product_ids = one_novanta_get_posts(
	[
		'posts_per_page' => 6,
		'paged'          => 1,
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'post__in'       => $related_modules,
	]
);

foreach ( $product_ids as $product_id ) {
	// Get product data.
	$product_data = one_novanta_get_product_data( $product_id );

	// Check if the product data is empty.
	if ( empty( $product_data ) ) {
		continue;
	}

	$product_data['content'] = apply_filters( 'the_content', $product_data['content'] );

	// Add "Add to Quote" button.
	$product_data['has_cta'] = true;
	$product_data['post_id'] = $product_id;

	// Add product card markup.
	$product_cards[] = Template::get_component(
		'cards',
		'product',
		$product_data
	);
}

// Generate filter markup.
$filter_markups = [
	Template::get_component(
		'product-search',
		'filter-widget',
		[
			'heading'      => __( 'Product Category', 'one-novanta-theme' ),
			'post_type'    => $the_post_type,
			'taxonomy'     => 'product_cat',
			'filter_items' => array_values( $product_category_filter_items ),
		]
	),
	Template::get_component(
		'product-search',
		'filter-widget',
		[
			'heading'      => __( 'Product Tag', 'one-novanta-theme' ),
			'post_type'    => $the_post_type,
			'taxonomy'     => 'product_tag',
			'filter_items' => array_values( $product_tag_filter_items ),
		]
	),
];

/**
 * Render final the component.
 */
$product_search_component_arguments = [
	'post_type'       => $the_post_type,
	'post_per_page'   => $posts_per_page,
	'rest_endpoint'   => rest_url( '/one-novanta/v1/product/related-modules/' . $the_post_id ),
	'count'           => $result_count,
	'sidebar_content' => implode( "\n", $filter_markups ),
	'content'         => Template::get_component(
		'grid',
		null,
		[
			'column_count' => 3,
			'content'      => implode( "\n", $product_cards ),
		],
	),
];

/**
 * If we are using global Post ID, we need to render the component with product variation related modules component.
 */
if ( $is_rest_request ) {
	Template::render_component( 'product-search', null, $product_search_component_arguments );
} else {
	Template::render_component(
		'product-variation-related-modules',
		null,
		[
			'content' => Template::get_component( 'product-search', null, $product_search_component_arguments ),
		]
	);
}
