<?php
/**
 * Component Content
 *
 * @component Content
 * @description A reusable content component.
 * @group UI Elements
 * @props {
 *   "overline": {"type": "string", "required": false, "description": "Overline text to display above heading"},
 *   "heading": {"type": "string", "required": false, "description": "Heading text"},
 *   "content": {"type": "string", "required": true, "description": "Media text content"},
 * }
 * @variations {}
 * @example get_component(
 *     'media-text-narrow',
 *     'content',
 *     [
 *         'overline' => 'Industry 01',
 *         'heading'  => 'Automotive',
 *         'content'  => '
 *             <p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos peha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequaue himenaeos elementum vestibulum dui malesuada interrpis euismod.</p>
 *             <p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
 *         ',
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$overline = $args['overline'] ?? '';
$heading  = $args['heading'] ?? '';
$content  = $args['content'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}
?>

<div class="media-text-narrow__content">
	<?php if ( ! empty( $overline ) ) { ?>
		<p class="media-text-narrow__overline has-small-font-size has-heading-font-family">
			<?php echo $overline; // phpcs:ignore ?>
		</p>
	<?php } ?>

	<?php if ( ! empty( $heading ) ) { ?>
		<h3 class="media-text-narrow__custom-title has-x-large-font-size">
			<?php echo $heading; // phpcs:ignore ?>
		</h3>
	<?php } ?>

	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $content;
	?>
</div>
