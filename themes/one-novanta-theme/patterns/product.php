<?php
/**
 * Pattern Product
 *
 * Title: Product Details
 * Slug: one-novanta-theme/product
 * Description: Tiles with image, heading and subheading.
 * Categories: onenovanta,homepage
 * Keywords: Product
 *
 * @package OneNovantaTheme\Patterns
 */

use OneNovanta\Controllers\Common\Template;

use function ATI\WooCommerce\get_default_variation;
use function ATI\WooCommerce\get_rest_variation_data;

// Return if required functions are not available.
if (
	! function_exists( 'ATI\WooCommerce\get_default_variation' ) ||
	! function_exists( 'ATI\WooCommerce\get_rest_variation_data' )
) {
	return;
}

// Get the current post ID.
$the_post_id = get_the_ID();

// Bail out if the post ID is not set.
if ( empty( $the_post_id ) ) {
	return;
}

// Get product data.
$the_product = one_novanta_get_post( $the_post_id );
$product     = $the_product;

// Get default variation ID.
if ( $the_product['post'] instanceof WP_Post && ! empty( $the_product['data']['default_variation_id'] ) ) {
	$default_variation_id = $the_product['data']['default_variation_id'];
	$product              = one_novanta_get_post( $default_variation_id );
}

// Check if the default variation ID is not empty.
if ( ! empty( $default_variation_id ) ) {
	$product_data = get_rest_variation_data( $default_variation_id );
} else {
	$product_data = get_rest_variation_data( $the_post_id );
}

$product_title       = $product_data['post_title'] ?? '';
$product_description = $product_data['description'] ?? '';
$gallery_markup      = $product_data['gallery_markup'] ?? '';
$pre_heading         = '';
$pre_heading_link    = '';

// Find pre heading.
$primary_term_id    = absint( $the_product['post_meta']['_yoast_wpseo_primary_product_cat'] ?? 0 );
$product_categories = $the_product['post_taxonomies']['product_cat'] ?? [];

if ( ! empty( $primary_term_id ) ) {
	foreach ( $product_categories as $category ) {
		if ( absint( $category['term_id'] ) === $primary_term_id ) {
			$pre_heading      = $category['name'];
			$pre_heading_link = get_term_link( $primary_term_id );
			break;
		}
	}
} elseif ( ! empty( $product_categories[0] ) ) { // Fallback to the first available category.
	$pre_heading      = $product_categories[0]['name'];
	$pre_heading_link = get_term_link( absint( $product_categories[0]['term_id'] ) );
}

// Check whether to show the "View all features" link.
$show_all_feature_link = '';

if ( $product['post'] instanceof WP_Post ) {
	$is_variable = 'product_variation' === $product['post']->post_type;

	// Show view-all-features only if the product is simple or if the product is variable, it has a default variation.
	if ( ! $is_variable || ! empty( $default_variation_id ) ) {

		if ( str_contains( $product['post']->post_content, 'id="one-novanta-single-product-all-features"' ) ) {
			$show_all_feature_link = '#one-novanta-single-product-all-features';
		} elseif ( str_contains( $product['post']->post_content, 'id="product-feature-heading"' ) ) {
			$show_all_feature_link = '#product-feature-heading';
		} elseif ( str_contains( $product['post']->post_content, 'id="tab-product-features-1"' ) ) {
			$show_all_feature_link = '#tab-product-features-1';
		}
	}
}

// Render product details.
Template::render_component(
	'product-details',
	null,
	[
		'content' => Template::get_component(
			'two-columns',
			null,
			[
				'content' => implode(
					"\n",
					[
						Template::get_component(
							'two-columns',
							'column',
							[
								'content' => $gallery_markup,
							],
						),
						Template::get_component(
							'two-columns',
							'column',
							[
								'content' => Template::get_component(
									'product-details',
									'description',
									[
										'pre_heading'      => $pre_heading,
										'pre_heading_link' => $pre_heading_link,
										'title'            => $product_title,
										'content'          => $product_description,
										'show_all_feature_link' => $show_all_feature_link,
									]
								),
							],
						),
					]
				),
			]
		),
	]
);
