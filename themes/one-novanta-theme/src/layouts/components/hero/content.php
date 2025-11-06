<?php
/**
 * Component Content
 * 
 * @component Content
 * @description A reusable content component.
 * @group UI Elements
 * @props {
 *   "pre_heading": {"type": "string", "required": false, "description": "Pre heading text to display above heading"},
 *   "heading": {"type": "string", "required": true, "description": "Heading text"},
 *   "vertical_align": {"type": "string", "required": false, "options": ["top", "middle", "bottom"], "description": "Hero content's vertical alignment. Defaults to middle"},
 *   "content": {"type": "string", "required": false, "description": "Hero content"},
 * }
 * @variations {}
 * @example get_component(
 *     'hero',
 *     'content',
 *     [
 *         'vertical_align' => 'bottom',
 *         'pre_heading'    => 'Robotics & Automation',
 *         'heading'        => 'GBX Tool Changer Module',
 *         'content'        => '<p>Product code 0033</p>',
 *     ],
 * );
 * 
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$pre_heading    = $args['pre_heading'] ?? '';
$heading        = $args['heading'] ?? '';
$content        = $args['content'] ?? '';
$vertical_align = $args['vertical_align'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $heading ) ) {
	return null;
}

// Initialize an array to store CSS classes for styling the component.
$classes = [ 'hero__content' ];

// Add a CSS class for vertical alignment if a value is provided.
// This dynamically appends the alignment class based on the $vertical_align value.
if ( ! empty( $vertical_align ) ) {
	$classes[] = "hero__content--vertical-align-{$vertical_align}";
}
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="hero__content-wrap has-medium-font-size has-heading-font-family">
		<?php if ( ! empty( $pre_heading ) ) { ?>
			<p class="hero__pre-heading">
				<?php echo $pre_heading; // phpcs:ignore ?>
			</p>
		<?php } ?>

		<h1 class="hero__heading has-display-font-size">
			<?php echo $heading; // phpcs:ignore ?>
		</h1>

		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $content;
		?>
	</div>
</div>
