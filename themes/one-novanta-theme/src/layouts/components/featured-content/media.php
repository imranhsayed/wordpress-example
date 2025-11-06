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
 *     'featured-content',
 *     'media',
 *     [
 *         'content' => Template::get_component(
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

<div class="featured-content__media">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $content;
	?>
</div>
