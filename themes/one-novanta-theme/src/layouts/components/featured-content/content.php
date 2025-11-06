<?php
/**
 * Component Content
 *
 * @component Content
 * @description A content component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Media text content"},
 * }
 * @variations {}
 * @example get_component(
 *     'featured-content',
 *     'content',
 *     [
 *         'content' => '
 *             <h2>Why ATI Material Removal Tools?</h2>
 *             <p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
 *             <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
 *         ',
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

<div class="featured-content__content">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $content;
	?>
</div>
