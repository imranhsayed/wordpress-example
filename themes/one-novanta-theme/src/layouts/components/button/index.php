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
 *   "primary": {"content": "Primary Button", "variant": "primary"},
 *   "secondary": {"content": "Secondary Button", "variant": "secondary"},
 *   "primary-dark": {"content": "Primary Button - Dark Background", "variant": "primary-dark"},
 *   "secondary-dark": {"content": "Secondary Button - Dark Background", "variant": "secondary-dark"},
 * }
 * @example render_component('button', [
 *   'content' => 'Click Me',
 *   'url' => 'https://example.com',
 *   'variant' => 'primary',
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['content'] ) ) {
	return;
}

// Default values.
$defaults = [
	'content'            => __( 'Button', 'one-novanta-theme' ),
	'url'                => '',
	'variant'            => 'primary',
	'disabled'           => false,
	'icon'               => false,
	'icon_name'          => 'arrow-right',
	'wrapper_attributes' => '',
];

// Merge arguments with defaults. Note: array_filter will automatically remove all the empty values.
$args = array_merge( $defaults, array_filter( $args ) );

// Destruct arguments.
$content            = $args['content'];
$url                = $args['url'];
$variant            = $args['variant'];
$disabled           = $args['disabled'];
$icon               = $args['icon'];
$icon_name          = $args['icon_name'];
$wrapper_attributes = $args['wrapper_attributes'];

// Extra button attributes.
$extra_button_attributes = [
	'class' => [ 'wp-one-novanta-button', 'wp-one-novanta-button--' . $variant ],
];

if ( $disabled ) {
	$extra_button_attributes['disabled'] = [ 'true' ];
}

if ( empty( $url ) ) {
	$extra_button_attributes['type'] = [ 'button' ];
} else {
	$extra_button_attributes['href'] = [ esc_url( $url ) ];
}

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_button_attributes, $wrapper_attributes );

// Render button.
if ( ! empty( $url ) ) {
	?>
	<a <?php echo wp_kses_data( $wrapper_attributes ); ?> >
		<?php one_novanta_kses_post_e( $content ); ?>
		<?php if ( $icon ) : ?>
			<span class="wp-one-novanta-button__icon">
				<?php
				// SVG arrow-right.
				Template::render_component(
					'svg',
					null,
					[ 'name' => $icon_name ],
				);
				?>
			</span>
		<?php endif; ?>
	</a>
	<?php
} else {
	?>
	<button <?php echo wp_kses_data( $wrapper_attributes ); ?>>
		<span class="text"><?php one_novanta_kses_post_e( $content ); ?></span>
		<?php if ( $icon ) : ?>
			<span class="wp-one-novanta-button__icon">
				<?php
				// SVG arrow-right.
				Template::render_component(
					'svg',
					null,
					[ 'name' => $icon_name ],
				);
				?>
			</span>
		<?php endif; ?>
	</button>
	<?php
}
