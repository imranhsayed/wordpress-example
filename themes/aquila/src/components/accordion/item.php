<?php
/**
 * Accordion item component.
 *
 * @package Aquila\Blocks
 */

$base_class      = 'wp-aquila-accordion';
$open_by_default = empty( $args['open_by_default'] ) ? 'no' : $args['open_by_default'];
$accordion_title = $args['title'] ?? '';
$content         = $args['content'] ?? '';

// If content or title is empty, return.
if ( empty( $content ) || empty( $accordion_title ) ) {
	return;
}

?>
<rt-accordion-item
	class="<?php echo esc_attr( "{$base_class}__item" ); ?>"
	open-by-default="<?php echo esc_attr( $open_by_default ); ?>"
>
	<rt-accordion-handle class="<?php echo esc_attr( "{$base_class}__handle" ); ?>">
		<button class="<?php echo esc_attr( "{$base_class}__heading" ); ?>">
			<span class="has-heading-font-family"><?php echo esc_html( $accordion_title ); ?></span>
		</button>
	</rt-accordion-handle>
	<rt-accordion-content class="<?php echo esc_attr( "{$base_class}__content" ); ?>">
		<div class="<?php echo esc_attr( "{$base_class}__content-wrap" ); ?>">
			<?php aquila_kses_post_e( $content ); ?>
		</div>
	</rt-accordion-content>
</rt-accordion-item>
