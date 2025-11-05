<?php
/**
 * Component Loading Indicator
 *
 * @component Loading Indicator
 * @description A centered loading spinner with optional text and visibility toggle
 * @group UI Elements
 * @props {
 *   "visible": {
 *     "type": "boolean",
 *     "default": true,
 *     "description": "Whether the loader is visible on initial render"
 *   },
 *   "text": {
 *     "type": "string",
 *     "description": "Optional loading text"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "visible": true,
 *     "text": "Loading..."
 *   },
 *   "no-text": {
 *     "visible": true
 *   }
 * }
 * @example render_component('loading-indicator', [
 *   'text' => 'Please wait...',
 *   'visible' => true
 * ]);
 *
 * @package Components
 */

$visible            = $args['visible'] ?? true;
$text               = $args['text'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? 'class="loading-indicator-component' . ( ! $visible ? ' is-hidden' : '' ) . '"';
?>

<div <?php echo wp_kses_data($wrapper_attributes); ?>>
	<div class="loading-indicator-component__spinner" aria-hidden="true"></div>
	<?php if ($text) : ?>
		<div class="loading-indicator-component__text"><?php echo esc_html($text); ?></div>
	<?php endif; ?>
</div>
