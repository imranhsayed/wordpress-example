<?php
/**
 * Button Component
 *
 * @component Button
 * @description A reusable button component with multiple variants
 * @group UI Elements
 * @props {
 *   "text": {"type": "string", "required": true, "description": "Button text"},
 *   "url": {"type": "string", "description": "Button URL (optional)"},
 *   "variant": {"type": "string", "options": ["primary", "secondary", "outline"], "description": "Button style variant"},
 *   "size": {"type": "string", "options": ["small", "medium", "large"], "description": "Button size"},
 *   "icon": {"type": "string", "description": "Optional icon class (e.g. 'dashicons dashicons-arrow-right')"},
 *   "classes": {"type": "string", "description": "Additional CSS classes"}
 * }
 * @variations {
 *   "primary": {"text": "Primary Button", "variant": "primary", "size": "medium"},
 *   "secondary": {"text": "Secondary Button", "variant": "secondary", "size": "medium"},
 *   "outline": {"text": "Outline Button", "variant": "outline", "size": "medium"},
 *   "small": {"text": "Small Button", "variant": "primary", "size": "small"},
 *   "large": {"text": "Large Button", "variant": "primary", "size": "large"},
 *   "with-icon": {"text": "Button with Icon", "variant": "primary", "size": "medium", "icon": "dashicons dashicons-arrow-right"}
 * }
 * @example get_component('button', [
 *   'text' => 'Click Me',
 *   'url' => 'https://example.com',
 *   'variant' => 'primary',
 *   'size' => 'medium'
 * ]);
 *
 * @package Components
 */

// Default values.
$text    = $text ?? 'Button';
$url     = $url ?? '#';
$variant = $variant ?? 'primary';
$size    = $size ?? 'medium';
$icon    = $icon ?? '';
$classes = $classes ?? '';

// Build class list.
$button_classes = array(
	'wp-button',
	"wp-button--{$variant}",
	"wp-button--{$size}",
);

if ( $classes ) {
	$button_classes[] = $classes;
}

// Combine into string.
$button_class = implode( ' ', $button_classes );

// Render button.
if ( $url ) {
	?>
	<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $button_class ); ?>">
		<?php echo esc_html( $text ); ?>
		<?php if ( $icon ) : ?>
			<span class="wp-button__icon <?php echo esc_attr( $icon ); ?>"></span>
		<?php endif; ?>
	</a>
	<?php
} else {
	?>
	<button type="button" class="<?php echo esc_attr( $button_class ); ?>">
		<?php echo esc_html( $text ); ?>
		<?php if ( $icon ) : ?>
			<span class="wp-button__icon <?php echo esc_attr( $icon ); ?>"></span>
		<?php endif; ?>
	</button>
	<?php
}