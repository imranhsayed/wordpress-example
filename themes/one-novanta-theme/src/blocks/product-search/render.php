<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string $content The block content.
 * @var WP_Block $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Get the button block attributes.
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'product-search-block' ] );

// Queries the current object.
$queried_object = get_queried_object();

// Attributes.
$attributes = array_merge(
	[
		'postType'     => 'product',
		'perPage'      => 6,
		'taxQuery'     => [],
		'hasAddToCart' => false,
		'headingLevel' => 'h3',
	],
	$attributes
);

$heading_level = $attributes['headingLevel'] ?? 'h3';

// Post query.
$query_args = [
	'post_type'      => $attributes['postType'],
	'posts_per_page' => $attributes['perPage'],
	'tax_query'      => $attributes['taxQuery'], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	'heading_level'  => $heading_level,
];

if ( ! empty( $queried_object ) && $queried_object instanceof WP_Term ) {
	$query_args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		[
			'field'    => 'term_id',
			'operator' => 'IN',
			'taxonomy' => $queried_object->taxonomy,
			'terms'    => $queried_object->term_taxonomy_id,
		],
	];
}

/**
 * Prepare Product cards.
 */
// Get result count.
$result_count = one_novanta_get_posts_count( $query_args );

// Get posts.
$post_ids = one_novanta_get_posts( $query_args );

// Initialize variables.
$product_cards = [];

// Loop through the posts.
foreach ( $post_ids as $the_post_id ) {

	$card_data = one_novanta_get_post_card_data( $the_post_id );

	if ( empty( $card_data ) ) {
		continue;
	}

	$card_data = array_merge(
		$card_data,
		[
			'heading_level'   => $heading_level,
			'post_type'       => $query_args['post_type'],
			'has_add_to_cart' => $attributes['hasAddToCart'],
		]
	);

	// Add product card markup.
	$product_cards[] = Template::get_component( 'cards', 'product', $card_data );
}

/**
 * Prepare Product filter items.
 */
$filter_markups           = [];
$available_taxonomy_terms = [];

// Get available taxonomies for filter.
$taxonomies = function_exists( 'one_novanta_get_taxonomies_for_filter' ) ? one_novanta_get_taxonomies_for_filter( $query_args['post_type'] ) : [];

/**
 * If it's taxonomy term archive page then remove the current taxonomy filter.
 */
if ( ! empty( $queried_object ) && $queried_object instanceof WP_Term ) {

	// Remove current taxonomy from filter.
	unset( $taxonomies[ $queried_object->taxonomy ] );

	$available_taxonomy_terms = one_novanta_get_available_terms( $query_args );
	$available_taxonomies     = array_keys( $available_taxonomy_terms );

	foreach ( $taxonomies as $taxonomy_slug => $taxonomy_data ) {
		if ( ! in_array( $taxonomy_slug, $available_taxonomies, true ) ) {
			// Skip if the taxonomy is a product attribute but not available.
			unset( $taxonomies[ $taxonomy_slug ] );
		}
	}
}

foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
	// Bail out if the taxonomy object is not an instance of WP_Taxonomy.
	if ( ! $taxonomy_object instanceof WP_Taxonomy ) {
		continue;
	}

	// Get all terms.
	$all_terms = one_novanta_get_terms(
		[
			'taxonomy' => $taxonomy_slug,
		]
	);

	if ( empty( $all_terms ) ) {
		continue;
	}

	$terms = [];

	if ( ! empty( $available_taxonomy_terms[ $taxonomy_slug ] ) ) {
		// Filter terms based on available attributes.
		foreach ( $all_terms as $the_term ) {
			if ( in_array( $the_term->term_id, $available_taxonomy_terms[ $taxonomy_slug ], true ) ) {
				$terms[] = $the_term;
			}
		}
	} else {
		// Use all terms if no available attributes are set.
		$terms = $all_terms;
	}

	$filter_options = [];

	if ( $taxonomy_object->hierarchical ) {
		// Organize terms for hierarchical taxonomies.
		$filter_options = one_novanta_organize_term_filter_option_hierarchy( $terms, 0 );
	} else {
		// Prepare filter items for non-hierarchical taxonomies.
		$filter_options = array_map(
			function ( $term ) {
				return [
					'label' => $term->name,
					'value' => $term->term_id,
				];
			},
			$terms
		);
	}

	if ( empty( $filter_options ) ) {
		continue;
	}

	$taxonomy_label = $taxonomy_object->label;

	if ( function_exists( 'ATI\WooCommerce\update_attribute_label_language' ) ) {
		// Update the taxonomy label with the translated version if available.
		$taxonomy_label = \ATI\WooCommerce\update_attribute_label_language( $taxonomy_label, $taxonomy_slug );
	}

	// Add markup for filter items.
	$filter_markups[] = Template::get_component(
		'product-search',
		'filter-widget',
		[
			'heading'      => $taxonomy_label,
			'post_type'    => $query_args['post_type'],
			'taxonomy'     => $taxonomy_slug,
			'filter_items' => $filter_options,
		]
	);
}

/**
 * Render Product-search inside section component.
 */
Template::render_component(
	'section',
	null,
	[
		'has_heading'        => false,
		'has_description'    => false,
		'wrapper_attributes' => $wrapper_attributes,
		'content'            => Template::get_component(
			'product-search',
			null,
			[
				'post_per_page'         => $query_args['posts_per_page'],
				'post_type'             => $query_args['post_type'],
				'count'                 => absint( $result_count ),
				'heading_level'         => $heading_level,
				'default_tax_query'     => $query_args['tax_query'] ?? [],
				'sidebar_content'       => implode( "\n", $filter_markups ),
				'additional_query_args' => [ 'has_add_to_cart' => empty( $attributes['hasAddToCart'] ) ? false : $attributes['hasAddToCart'] ],
				'content'               => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 3,
						'content'      => implode( "\n", $product_cards ),
					],
				),
			],
		),
	],
);
