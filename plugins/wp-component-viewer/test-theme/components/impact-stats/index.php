<?php
/**
 * Component: Impact Stats
 *
 * @component Impact Stats
 * @description Animated counters to display impact numbers with labels.
 * @group UI Elements
 * @props {
 *   "stats": {
 *     "type": "array",
 *     "description": "Array of stats objects, each with 'number' and 'label' keys",
 *     "required": true
 *   }
 * }
 * @variations {
 *   "default": {
 *     "stats": [
 *       {"number": 5000, "label": "Meals Served"},
 *       {"number": 1200, "label": "Volunteers"},
 *       {"number": 35, "label": "Projects Completed"}
 *     ]
 *   }
 * }
 * @example render_component('impact-stats', [
 *   'stats' => [
 *     ['number' => 10000, 'label' => 'Trees Planted'],
 *     ['number' => 2500, 'label' => 'Donors'],
 *     ['number' => 50, 'label' => 'Communities Reached']
 *   ]
 * ]);
 */

if ( empty( $args['stats'] ) || ! is_array( $args['stats'] ) ) {
	return;
}

$stats = $args['stats'];
?>

<div class="impact-stats">
	<?php foreach ( $stats as $stat ) : ?>
		<div class="impact-stats__item">
			<span class="impact-stats__number" data-target="<?php echo intval( $stat['number'] ); ?>">0</span>
			<span class="impact-stats__label"><?php echo esc_html( $stat['label'] ); ?></span>
		</div>
	<?php endforeach; ?>
</div>
