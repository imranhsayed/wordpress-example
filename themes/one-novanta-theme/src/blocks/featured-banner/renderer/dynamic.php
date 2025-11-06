<?php
/**
 * Render callback for dynamic variation of 'one-novanta/featured-banner' block.
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content    The block content.
 * @var WP_Block     $block      The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Return if required parameters are not available.
if ( empty( $attributes ) || ! is_array( $attributes ) ) {
	return;
}

$pre_heading_term = null;
$pre_heading      = $attributes['preHeading'] ?? '';
$image_id         = $attributes['imageID'] ?? 0;

if ( is_archive() ) {
	$description     = '';
	$current_post_id = get_queried_object_id(); // Will be 0 on CPT archives.
	$image_id        = $current_post_id ? get_term_meta( $current_post_id, 'thumbnail_id', true ) : false;

	/**
	 * Only fetch the Archive Title, and remove Taxonomy Prefix.
	 * Eg: From Category: ABC this removes `Category:`.
	 */
	add_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );
	$heading = get_the_archive_title();
	remove_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );

	/**
	 * Pre-heading on CPT archive will be same as it's heading. So remove or use if it's coming from attributes.
	 */
	if ( ! is_post_type_archive() ) {
		$curr_post_type = get_post_type();
		$post_type_obj  = $curr_post_type ? get_post_type_object( $curr_post_type ) : null;

		if ( $post_type_obj ) {
			$default_pre_heading = $post_type_obj->labels->singular_name;

			// Avoid showing if it matches archive title (e.g., both are "Product").
			if ( $heading !== $default_pre_heading ) {
				$pre_heading = $default_pre_heading;
			}
		}
	}
} else {
	$current_post_id = get_the_ID();
	$image_id        = get_post_thumbnail_id();
	$heading         = get_the_title();
	$description     = sprintf( '<p>%1$s %2$s</p>', __( 'Published on', 'one-novanta-theme' ), get_the_date() );
}

$vertical_align  = $attributes['verticalAlign'] ?? 'middle';
$content_width   = $attributes['contentWidth'] ?? 'wide';
$height          = $attributes['height'] ?? 'small';
$has_description = $attributes['hasDescription'] ?? true;
$dynamic_tax     = $attributes['taxonomy'] ?? '';
$request_context = ! empty( $_REQUEST['context'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['context'] ) ) : ''; // phpcs:ignore

// Only exit early if we're on a single post/page and still don't have an ID.
if ( ! is_archive() && empty( $current_post_id ) && 'edit' !== $request_context ) {
	return;
}

// TODO: Update pre-heading for dynamic archive pages on pre-heading meta is added.
if ( ! empty( $dynamic_tax ) && ! empty( $current_post_id ) ) {
	// Fetch pre-heading term using Yoast SEO.
	if ( function_exists( 'yoast_get_primary_term_id' ) ) {
		$primary_term_id  = yoast_get_primary_term_id( $dynamic_tax, $current_post_id );
		$pre_heading_term = get_term( $primary_term_id );
	}

	// Fetch pre-heading term.
	if ( empty( $pre_heading_term ) ) {
		$pre_heading_terms = wp_get_post_terms( $current_post_id, $dynamic_tax );

		if ( ! empty( $pre_heading_terms ) && ! is_wp_error( $pre_heading_terms ) ) {
			$pre_heading_term = $pre_heading_terms[0];
		}
	}

	if ( ! empty( $pre_heading_term ) && ! is_wp_error( $pre_heading_term ) ) {
		$pre_heading = $pre_heading_term->name;
	}
}

// If we are in the admin area or editing context, set default values for pre-heading, heading, and content.
// This is to ensure that the block has meaningful content when rendered in the editor.
if ( is_admin() || 'edit' === $request_context ) {
	$pre_heading = ! empty( $pre_heading ) ? $pre_heading : __( 'Pre Heading', 'one-novanta-theme' );
	$heading     = ! empty( $heading ) ? $heading : __( 'Featured Banner', 'one-novanta-theme' );
	$content     = ! empty( $description ) ? $description : __( 'This is a featured banner block.', 'one-novanta-theme' );
}

// Render block.
Template::render_component(
	'hero',
	null,
	[
		'image_id' => $image_id ? intval( $image_id ) : $attributes['imageID'] ?? 0,
		'layout'   => $content_width,
		'height'   => $height,
		'content'  => Template::get_component(
			'hero',
			'content',
			[
				'pre_heading'    => $pre_heading,
				'heading'        => $heading,
				'content'        => $has_description ? $description : '',
				'vertical_align' => $vertical_align,
			],
		),
	]
);
