<?php
/**
 * PHP file to render the block on server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

global $product;

// Return if the current page is not product page.
if ( empty( $product ) ) {
	return;
}

// Get block attributes.
$product_order = $attributes['order'] ?? 'asc';
$order_by      = $attributes['orderBy'] ?? 'title';
$limit         = isset( $attributes['numberOfItems'] ) ? (int) $attributes['numberOfItems'] : 4;

$posts_args = [
	'post_type'      => 'product',
	'posts_per_page' => $limit + 1,
	'orderby'        => $order_by,
	'order'          => $product_order,
];

// Add product category filter if Yoast or fallback found one.
if ( function_exists( 'yoast_get_primary_term_id' ) ) {
	$primary_term_id = yoast_get_primary_term_id( 'product_cat' );

	if ( $primary_term_id ) {
		$primary_term = get_term( $primary_term_id, 'product_cat' );

		if ( $primary_term && ! is_wp_error( $primary_term ) ) {
			$posts_args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Fetch primary category.
				[
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => [ $primary_term->slug ],
				],
			];
		}
	}
}

if ( empty( $posts_args['tax_query'] ) ) {
	$categories = wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'slugs' ] );

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		$posts_args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Fetch first category.
			[
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $categories,
			],
		];
	}
}

$products = one_novanta_get_posts( $posts_args );

if ( empty( $products ) ) {
	return;
}

$card_components = '';

$count = 0; // Initial count for total number of products displayed on the front-end.
foreach ( $products as $product_id ) {
	if ( $product_id === $product->get_id() ) { // Skip current product.
		continue;
	}

	if ( $count === $limit ) { // Break out the loop if the number of products displayed reaches the limit.
		break;
	}

	$product_data = one_novanta_get_product_data( $product_id );

	if ( empty( $product_data ) ) {
		continue;
	}

	$product_data['product_tag'] = has_term( 'new', 'product_tag', $product_id ) ? __( 'New', 'one-novanta-theme' ) : '';

	$card_components .= Template::get_component(
		'cards',
		'product',
		$product_data,
	);

	++$count; // Increase product displayed count.
}

Template::render_component(
	'grid',
	null,
	[
		'column_count' => 4,
		'content'      => $card_components,
	],
);
