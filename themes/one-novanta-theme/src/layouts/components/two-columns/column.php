<?php
/**
 * Component Column
 *
 * @component Column
 * @description A reusable column component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Column content"},
 * }
 * @variations {}
 * @example get_component(
 *    'two-columns',
 *    'column',
 *    [
 *        'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
 *        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *        <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
 *        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 *        ',
 *    ]
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

<div class="two-columns__column">
	<?php
		echo $content; // phpcs:ignore -- This is a wrapper element child components are responsible for escaping the content.
	?>
</div>
