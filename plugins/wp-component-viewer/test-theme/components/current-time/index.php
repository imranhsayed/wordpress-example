<?php
/**
 * Component Current Time
 *
 * @component Current Time
 * @description Displays the current time with optional design variants
 * @group Utility
 * @props {
 *   "format": {
 *     "type": "string",
 *     "default": "H:i:s",
 *     "description": "PHP-compatible time format (e.g. H:i, h:i A)"
 *   },
 *   "variant": {
 *     "type": "string",
 *     "default": "default",
 *     "description": "Visual variant: default, minimal, boxed"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "format": "H:i:s",
 *     "variant": "default"
 *   },
 *   "minimal": {
 *     "format": "h:i A",
 *     "variant": "minimal"
 *   },
 *   "boxed": {
 *     "format": "H:i",
 *     "variant": "boxed"
 *   }
 * }
 * @example render_component('current-time', [
 *   'format' => 'h:i A',
 *   'variant' => 'boxed'
 * ]);
 *
 * @package Components
 */

$format             = $args['format'] ?? 'H:i:s';
$variant            = $args['variant'] ?? 'default';
$wrapper_attributes = $args['wrapper_attributes'] ?? 'class="current-time-component variant-' . esc_attr($variant) . '"';
?>

<div <?php echo wp_kses_data($wrapper_attributes); ?> data-time-format="<?php echo esc_attr($format); ?>">
	<span class="current-time-component__clock">--:--:--</span>
</div>
