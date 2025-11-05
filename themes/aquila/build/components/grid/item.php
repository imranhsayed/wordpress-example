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
 * @variations {
 *   "default": {"content": "<p><strong>Grid Item Title</strong></p><p>This is a grid item with some sample content to demonstrate the component's appearance and functionality.</p>"},
 *   "with-list": {"content": "<p><strong>Key Features</strong></p><ul><li>Easy to use</li><li>Highly customizable</li><li>Responsive design</li></ul>"}
 * }
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
 * @package Aquila\Components
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
