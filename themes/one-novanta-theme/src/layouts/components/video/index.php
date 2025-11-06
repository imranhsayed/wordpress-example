<?php
/**
 * Component Video
 *
 * @component Video
 * @description A component to display a video.
 * @group UI Elements
 * @props {
 *   "video_url": {"type": "string", "required": true, "description": "Column as content"},
 *   "cover_image_id": {"type": "string", "required": false, "options": ["left", "right"], "description": "Column content's horizontal alignment. Defaults to left"},
 * }
 * @variations {}
 * @example render_component(
 *    'video',
 *    null,
 *    [
 *      'video_url'      => 'https://fast.wistia.net/embed/iframe/26sk4lmiix',
 *      'cover_image_id' => '123',
 *    ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['cover_image_id'] ?? '';
$video_url          = $args['video_url'] ?? '';
$caption            = $args['caption'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the url is empty to prevent further processing.
if ( empty( $video_url ) ) {
	return null;
}

$media_id = one_novanta_extract_wistia_media_id( $video_url );

// Extra attributes.
$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				'novanta-video',
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$unique_id          = uniqid( 'video_' );
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
$thumbnail_content  = ! empty( $image_id )
	? Template::get_component(
		'image',
		null,
		[
			'id'              => $image_id,
			'size'            => 'large',
			'attrs'           => array(
				'class' => 'novanta-video__static-thumbnail',
			),
			'use_focal_point' => true, // Use focal point for the image.
		]
	) : '<img class="novanta-video__dynamic-thumbnail" width="100%" height="576" />';
?>

<novanta-video
	<?php echo wp_kses_data( $wrapper_attributes ); ?>
	media-id="<?php echo esc_attr( $media_id ); ?>"
	thumbnail="<?php echo ! empty( $image_id ) ? 'static' : 'dynamic'; ?>"
	id="<?php echo esc_attr( $unique_id ); ?>"
	>
	<figure class="novanta-video__thumbnail">
		<?php
		Template::render_component(
			'media-lightbox',
			null,
			[
				'name'       => 'videolightbox_' . $unique_id,
				'group'      => 'video-gallery-' . $unique_id,
				'show_count' => false,
				'content'    => $thumbnail_content,
				'media_id'   => $media_id,
			],
		);
		?>

		<?php if ( ! empty( $caption ) ) : ?>
			<figcaption class="novanta-video__caption">
				<?php one_novanta_kses_post_e( $caption ); ?>
			</figcaption>
		<?php endif; ?>

		<button class="novanta-video__play-button" aria-label="<?php echo esc_attr__( 'Video play button', 'one-novanta-theme' ); ?>" type="button">
			<?php
			// Play SVG Icon.
			Template::render_component(
				'svg',
				null,
				[ 'name' => 'play' ],
			);
			?>
		</button>
	</figure>
</novanta-video>
