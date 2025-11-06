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

$number_of_posts = isset( $attributes['numberOfPosts'] ) ? intval( $attributes['numberOfPosts'] ) : 3;

$args = [
	// Fetch additional posts if to exclude posts that does not have a featured image.
	'posts_per_page' => 10,
];

$collage_posts = one_novanta_get_posts( $args );

// Check if there are any posts to display.
if ( empty( $collage_posts ) ) {
	return;
}

$content = [];

foreach ( $collage_posts as $unit_post ) {
	$post_data = one_novanta_get_post( $unit_post );

	$curr_post = $post_data['post'] ?? null;

	// Return early if post not found or image is not present.
	if ( ! $curr_post instanceof WP_Post || empty( $post_data['post_thumbnail'] ) ) {
		continue;
	}

	$all_terms = one_novanta_extract_post_taxonomies( $post_data );

	$content[] = [
		'pre_heading' => wp_trim_words( implode( ', ', $all_terms ), 10 ),
		'heading'     => $curr_post->post_title,
		'image_id'    => $post_data['post_thumbnail'],
		'link'        => $post_data['permalink'],
	];
}

// Slice the content array to get the desired number of posts.
$content = array_slice( $content, 0, $number_of_posts );

Template::render_component(
	'collage',
	null,
	array(
		'content' => $content,
	),
);
