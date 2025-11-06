<?php
/**
 * PHP file to render the block on server to show on the front end.
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content    The block content.
 * @var WP_Block     $block      The block instance.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

$category_id  = ! empty( $attributes['categoryId'] ) ? $attributes['categoryId'] : 0;
$order_by     = $attributes['orderBy'] ?? 'date';
$post_order   = $attributes['order'] ?? 'desc';
$limit        = isset( $attributes['numberOfItems'] ) ? (int) $attributes['numberOfItems'] : 4;
$column_count = 4;

$args = [
	'post_type'      => 'post',
	'posts_per_page' => $limit,
	'post_status'    => 'publish',
	'orderby'        => $order_by,
	'order'          => $post_order,
];

if ( 0 !== $category_id ) {
	$args['cat'] = $category_id;
} else {
	$post_categories = get_the_category();

	if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ) {
		$args['cat'] = (int) $post_categories[0]->term_id;
	}
}

$post_ids = one_novanta_get_posts( $args );

if ( empty( $post_ids ) ) {
	return;
}

$card_components = '';

foreach ( $post_ids as $the_post_id ) {
	$post_data = one_novanta_get_post( $the_post_id );

	$curr_post = $post_data['post'] ?? null;

	// Return early if post not found.
	if ( ! $curr_post instanceof WP_Post ) {
		continue;
	}

	$category        = '';
	$permalink       = $post_data['permalink'] ?? '';
	$image_id        = $post_data['post_thumbnail'] ?? 0;
	$post_meta       = $post_data['post_meta'] ?? [];
	$post_taxonomies = $post_data['post_taxonomies'] ?? [];

	if ( $category_id > 0 ) {
		$category_obj = get_category( $category_id );
		$category     = $category_obj instanceof WP_Term ? $category_obj->name : '';
	} else {
		$category = $post_taxonomies['category'][0]['name'] ?? '';
	}

	$card_components .= Template::get_component(
		'cards',
		'article',
		[
			'image_id' => $image_id,
			'heading'  => $curr_post->post_title,
			'url'      => $permalink,
			'category' => $category,
		],
	);
}

if ( $card_components ) {
	Template::render_component(
		'grid',
		null,
		[
			'column_count' => $column_count,
			'content'      => $card_components,
		],
	);
}
