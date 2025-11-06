<?php
/**
 * Component Item
 *
 * @component Item
 * @description A reusable grid item component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Grid item content"},
 * }
 * @variations {}
 * @example get_component(
 *     'grid',
 *     'item',
 *     [
 *         'content' => get_component(
 *             'grid',
 *             'item',
 *             [
 *                 'content' => '
 *                     <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
 *                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *                     <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
 *                 ',
 *             ],
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

<div class="grid__item">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $content;
	?>
</div>
