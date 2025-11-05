<?php
/**
 * Component: YouTube Video
 *
 * @component YouTube Video
 * @description Embeds a responsive YouTube video.
 * @group Media & Visuals
 * @props {
 *   "video_id": { "type": "string", "required": true, "description": "YouTube video ID" },
 *   "title": { "type": "string", "description": "Video title for accessibility (optional)" },
 *   "autoplay": { "type": "boolean", "description": "Autoplay the video (optional)" },
 *   "aspect_ratio": { "type": "string", "options": ["16:9", "4:3"], "description": "Aspect ratio (optional)" },
 *   "wrapper_attributes": { "type": "string", "description": "Wrapper element attributes (optional)" }
 * }
 * @variations {
 *   "default": {
 *     "video_id": "jNQXAC9IVRw",
 *     "title": "Sample Video"
 *   }
 * }
 * @example render_component('youtube-video', [
 *   'video_id' => 'jNQXAC9IVRw',
 *   'title' => 'Me at the zoo',
 *   'autoplay' => false
 * ]);
 * @extra_allowed_tags { "iframe": { "src": true, "title": true, "frameborder": true, "allow": true, "allowfullscreen": true } }
 *
 * @package Components
 */

if (empty($args) || ! is_array($args) || empty($args['video_id'])) {
	return;
}

$defaults = array(
	'title'             => 'YouTube Video',
	'autoplay'          => false,
	'aspect_ratio'      => '16:9',
	'wrapper_attributes' => '',
);

$args = array_merge($defaults, array_filter($args));

$video_id           = $args['video_id'];
$title              = $args['title'];
$autoplay           = $args['autoplay'] ? 1 : 0;
$aspect_ratio_class = $args['aspect_ratio'] === '4:3' ? 'aspect-4-3' : 'aspect-16-9';
$wrapper_attributes = $args['wrapper_attributes'];

$iframe_src = sprintf(
	'https://www.youtube.com/embed/%s?autoplay=%d',
	$video_id,
	$autoplay
);

?>
<div class="wp-test-theme-video-wrapper <?php echo $aspect_ratio_class; ?>" <?php echo $wrapper_attributes; ?>>
	<iframe
		src="<?php echo $iframe_src; ?>"
		title="<?php echo $title; ?>"
		frameborder="0"
		allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
		allowfullscreen></iframe>
</div>
