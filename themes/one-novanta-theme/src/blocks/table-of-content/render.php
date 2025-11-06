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

// Extract the tile data from the attributes.
$titles          = $attributes['tocList'] ?? [];
$current_post_id = get_the_ID() ?? null;

if ( empty( $current_post_id ) ) {
	return;
}

$show_toc = get_post_meta( $current_post_id, 'show_table_of_content', true );

if ( empty( $show_toc ) ) {
	return;
}

// Get current post content.
$post_content = get_post_field( 'post_content', $current_post_id );

// Get the h2 headings from the post content along with their id attributes.
preg_match_all( '/<h2\s+([^>]*)>(.*?)<\/h2>/', $post_content, $heading_matches );

// If there are no headings, return.
if ( empty( $heading_matches[2] ) ) {
	return;
}

$heading_texts = $heading_matches[2]; // Heading texts, checked above for existence.
$heading_attrs = $heading_matches[1] ? $heading_matches[1] : [];
$heading_ids   = [];

// Extract IDs from attributes.
foreach ( $heading_attrs as $attrs ) {
	// Search for the ID attribute in the tag.
	if ( preg_match( '/id=[\'"](.*?)[\'"]/', $attrs, $id_match ) ) {
		$heading_ids[] = $id_match[1];
	} else {
		$heading_ids[] = ''; // Empty if no ID found.
	}
}

foreach ( $heading_texts as $index => $heading_text ) {
	// Use the existing ID if available, otherwise create one from the heading text.
	$heading_id = ! empty( $heading_ids[ $index ] ) ? $heading_ids[ $index ] : sanitize_title( $heading_text );

	$titles[] = [
		'title' => $heading_text,
		'id'    => $heading_id,
	];
}

Template::render_component(
	'table-of-content',
	null,
	[
		'list_items' => $titles,
		'heading'    => ! empty( $attributes['heading'] ) ? $attributes['heading'] : esc_html__( 'Topics', 'one-novanta-theme' ),
	],
);
