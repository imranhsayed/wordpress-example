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

$media_type         = $attributes['mediaType'] ?? 'image';
$image_id           = $attributes['imageID'] ?? '';
$video_thumbnail_id = $attributes['videoThumbnailID'] ?? '';
$media_url          = $attributes['mediaURL'] ?? '';
$media_alignment    = $attributes['mediaAlignment'] ?? 'left';

$media_content = '';

if ( 'image' === $media_type ) {
	$media_content = Template::get_component(
		'image',
		null,
		[
			'id'   => $image_id,
			'size' => 'large',
		]
	);
} elseif ( 'wistia' === $media_type ) {
	$media_content = Template::get_component(
		'video',
		null,
		[
			'video_url'      => $media_url,
			'cover_image_id' => $video_thumbnail_id,
		]
	);
} 

Template::render_component(
	'featured-content',
	null,
	[
		'content'     => Template::get_component(
			'featured-content',
			'media',
			[
				'content' => $media_content,
			],
		) .
	Template::get_component(
		'featured-content',
		'content',
		[
			'content' => $content,
		],
	),
		'media_align' => $media_alignment,
	]
);
