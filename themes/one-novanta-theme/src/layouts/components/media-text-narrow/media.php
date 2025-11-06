<?php
/**
 * Component Media
 *
 * @component Media
 * @description A reusable media component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Media content"},
 * }
 * @variations {}
 * @example get_component(
 *     'media-text-narrow',
 *     'media',
 *     [
 *         'content' => get_component(
 *             'image',
 *             null,
 *             [
 *                 'id'   => 21,
 *                 'size' => 'large',
 *             ]
 *         ),
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content = $args['content'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}
?>

<div class="media-text-narrow__media">
	<?php one_novanta_kses_post_e( $content ); ?>
</div>
