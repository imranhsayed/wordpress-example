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

$template       = $attributes['template'] ?? '';
$heading        = $attributes['heading'] ?? '';
$description    = $attributes['description'] ?? '';
$form_alignment = $attributes['formAlignment'] ?? 'left';
$vertical_align = $attributes['verticalAlign'] ?? 'top';
$reverse_order  = $attributes['reverseMobileOrder'] ?? false;
$image_id       = $attributes['imageID'] ?? '';

$content_column = '';

// Heading and description.
if ( 'form-with-media' === $template ) {
	// Render the image using the image component.
	$content_column = Template::get_component(
		'two-columns',
		'column',
		[
			'content' => Template::get_component(
				'image',
				null,
				[
					'id'    => $image_id,
					'size'  => 'large',
					'attrs' => array(
						'class' => 'one-novanta-form-wrapper__image attachment-large size-large',
						'alt'   => esc_html__( 'Form Image', 'one-novanta-theme' ),
					),
				]
			),
		]
	);
} elseif ( 'form' === $template ) {
	// Render heading and description.
	$content_column = Template::get_component(
		'two-columns',
		'column',
		[
			'content' => implode(
				'',
				array_filter(
					[
						$heading ? sprintf( '<h2 class="one-novanta-form-wrapper__heading has-xx-large-font-size">%s</h2>', wp_kses_post( $heading ) ) : '',
						$description ? sprintf( '<p class="one-novanta-form-wrapper__description has-medium-font-size">%s</p>', wp_kses_post( $description ) ) : '',
					]
				)
			),
		]
	);
}

// Inner blocks content (form).
$form_column = Template::get_component(
	'two-columns',
	'column',
	[
		'content' => $content,
	]
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => sprintf( 'two-columns--media-align-%s', esc_attr( $form_alignment ) ) ) );

// Render using the two-columns wrapper component.
Template::render_component(
	'two-columns',
	null,
	[
		'content'              => $content_column . $form_column,
		'vertical_align'       => $vertical_align,
		'reverse_mobile_order' => $reverse_order,
		'wrapper_attributes'   => $wrapper_attributes,
	]
);
