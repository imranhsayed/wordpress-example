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
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package AquilaTheme\Blocks
 */

use Aquila\Theme\Template;

// Build component attributes.
$component_attributes = [
	'id'               => $attributes['anchor'] ?? '',
	'title'            => '',
	'title_align'      => $attributes['titleAlignment'] ?? 'center',
	'background'       => $attributes['hasBackground'] ?? false,
	'background_color' => $attributes['backgroundColor'] ?? 'gray',
	'padding'          => $attributes['hasPadding'] ?? false,
	'narrow'           => $attributes['isNarrow'] ?? false,
	'slot'             => '',
];

// Set title if it exists.
if ( ( $attributes['hasTitle'] ?? true ) && ! empty( $attributes['title'] ) ) {
	$component_attributes['title'] = $attributes['title'];
}

// Set heading level if it exists.
if ( ! empty( $attributes['headingLevel'] ) ) {
	$component_attributes['heading_level'] = $attributes['headingLevel'];
}

// Set heading style if it exists.
if ( ! empty( $attributes['headingStyle'] ) ) {
	$component_attributes['heading_style'] = $attributes['headingStyle'];
}

// Check if the block has a description.
if ( ( $attributes['hasDescription'] ?? false ) && ! empty( $attributes['description'] ) ) {
	$component_attributes['description'] = $attributes['description'];
}

// Set CTA if it exists.
if ( ( $attributes['hasCta'] ?? false ) && ! empty( $attributes['ctaButton'] ) ) {
	$component_attributes['cta_button'] = [
		'url'        => $attributes['ctaButton']['url'] ?? '',
		'text'       => $attributes['ctaButton']['text'] ?? '',
		'variant'    => $attributes['ctaButton']['variant'] ?? 'primary',
		'new_window' => true === $attributes['ctaButton']['newWindow'] ?? '',
	];
}

// Add content to the slot.
$component_attributes['slot'] = $content;

// Return rendered component.
Template::render_component( 'section', null, $component_attributes );
