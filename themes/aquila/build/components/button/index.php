<?php
/**
 * Component Button
 *
 * @component Button
 * @description A reusable button component with multiple variants
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Button text"},
 *   "url": {"type": "string", "description": "Button URL (optional)"},
 *   "icon": {"type": "boolean", "description": "Add button icon (optional)"},
 *   "icon_name": {"type": "string", "description": "Icon Name. Defaults to 'arrow-right'"},
 *   "variant": {"type": "string", "options": ["primary", "secondary", "primary-dark", "secondary-dark"], "description": "Button style variant (optional)"},
 *   "disabled": {"type": "boolean", "description": "Disable the button (optional)"},
 *   "wrapper_attributes": {"type": "string", "description": "Button Wrapper attributes (optional)"}
 * }
 * @variations {
 *   "primary": {"content": "Primary Button", "url": "#", "variant": "primary"},
 *   "secondary": {"content": "Secondary Button", "url": "#", "variant": "secondary"},
 *   "primary-dark": {"content": "Primary Button - Dark Background", "url": "#", "variant": "primary-dark"},
 *   "secondary-dark": {"content": "Secondary Button - Dark Background", "url": "#", "variant": "secondary-dark"}
 * }
 * @example render_component('button', [
 *   'content' => 'Click Me',
 *   'url' => 'https://example.com',
 *   'variant' => 'primary',
 * ]);
 *
 * @package Aquila\Components
 */

use Aquila\Theme\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['content'] ) ) {
	return;
}

// Default values.
$defaults = array(
	'content'            => __( 'Button', 'one-aquila-theme' ),
	'url'                => '',
	'new_window'         => false,
	'variant'            => 'primary',
	'disabled'           => false,
	'icon'               => false,
	'icon_name'          => 'arrow-right',
	'wrapper_attributes' => '',
);

// Merge arguments with defaults. Note: array_filter will automatically remove all the empty values.
$args = array_merge( $defaults, array_filter( $args ) );

// Destruct arguments.
$content            = $args['content'];
$url                = $args['url'];
$new_window         = $args['new_window'];
$variant            = $args['variant'];
$disabled           = $args['disabled'];
$icon               = $args['icon'];
$icon_name          = $args['icon_name'];
$wrapper_attributes = $args['wrapper_attributes'];

// Extra button attributes.
$extra_button_attributes = array(
	'class' => array( 'wp-one-aquila-button', 'wp-one-aquila-button--' . $variant ),
	'disabled' => array( 'false' ),
);

if ( $disabled ) {
	$extra_button_attributes['disabled'] = array( 'true' );
}

if ( empty( $url ) ) {
	$extra_button_attributes['type'] = array( 'button' );
} else {
	$extra_button_attributes['href'] = array( esc_url( $url ) );
}

if ( ! $disabled ) {
	$wrapper_attributes = 'class="' . esc_attr( implode( ' ', $extra_button_attributes['class'] ) ) . '"';
}

// Render button.
if ( ! empty( $url ) ) {
	?>
	<a
		href="<?php echo esc_url( $url ); ?>"
		<?php if( ! empty( $new_window ) && 'false' !== $new_window ): ?>
			target="_blank"
		<?php endif; ?>
	>
		<button <?php echo wp_kses_data( $wrapper_attributes ); ?>>
			<?php echo wp_kses_post( $content ); ?>
			<?php if ( $icon ) : ?>
				<span class="wp-one-aquila-button__icon">
					<?php
					// SVG arrow-right.
					Template::render_component(
						'svg',
						null,
						array( 'name' => $icon_name ),
					);
					?>
				</span>
			<?php endif; ?>
		</button>
	</a>
	<?php
} else {
	?>
	<button <?php echo wp_kses_data( $wrapper_attributes ); ?>>
		<?php echo wp_kses_post( $content ); ?>
		<?php if ( $icon ) : ?>
			<span class="wp-one-aquila-button__icon">
				<?php
				// SVG arrow-right.
				Template::render_component(
					'svg',
					null,
					array( 'name' => $icon_name ),
				);
				?>
			</span>
		<?php endif; ?>
	</button>
	<?php
}
