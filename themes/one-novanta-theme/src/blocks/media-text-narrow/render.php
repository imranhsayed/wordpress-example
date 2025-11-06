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

// Get the section block attributes.
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'alignwide' ] );

Template::render_component(
	'media-text-narrow',
	null,
	[
		'wrapper_attributes' => $wrapper_attributes,
		'media_align'        => $attributes['mediaPosition'],
		'vertical_align'     => $attributes['verticalAlign'],
		'content'            => Template::get_component(
			'media-text-narrow',
			'media',
			[
				'content' => Template::get_component(
					'image',
					null,
					[
						'id'   => $attributes['imageID'],
						'size' => 'image-large',
					]
				),
			],
		) .
		Template::get_component(
			'media-text-narrow',
			'content',
			[
				'overline' => $attributes['overline'],
				'heading'  => $attributes['heading'],
				'content'  => $content,
			],
		),
	]
);
