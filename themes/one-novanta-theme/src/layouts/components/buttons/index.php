<?php
/**
 * Component Buttons
 *
 * @component Buttons
 * @description A flexible buttons component.
 * @group UI Elements
 * @props {
 *   "content": '',
 *   "horizontal_align": '', // 'left', 'right', 'center', 'space-between'
 *   "vertical_align": '', // 'top', 'middle', 'bottom',
 * }
 * @variations {}
 * @example render_component('buttons', [
 *   'content' => '' ,
 *   'horizontal_align' => '' ,
 *   'vertical_align' => '' ,
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content          = $args['content'] ?? '';
$horizontal_align = $args['horizontal_align'] ?? '';
$vertical_align   = $args['vertical_align'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Initialize an array to store CSS classes for styling the component.
$classes = [ 'buttons' ];

// This dynamically appends the alignment class based on the $horizontal_align value.
if ( ! empty( $horizontal_align ) ) {
	$classes[] = "buttons--horizontal-align-{$horizontal_align}";
}

// This dynamically appends the alignment class based on the $vertical_align value.
if ( ! empty( $vertical_align ) ) {
	$classes[] = "buttons--vertical-align-{$vertical_align}";
}

?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php one_novanta_kses_post_e( $content ); ?>
</div>
