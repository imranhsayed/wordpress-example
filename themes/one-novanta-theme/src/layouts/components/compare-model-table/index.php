<?php
/**
 * Component Compare Model Table
 *
 * @component Compare Model Table
 * @description A reusable compare model table component
 * @group UI Elements
 * @props {
 *   "headers": {"type": "array", "required": true, "description": "Table headers."},
 *   "rows": { "type": "array", "required": true, "description": "Table rows." },
 *   "filter_by": { "type": "integer", "required": false, "description": "Column index (starting with 1) using which table can be filtered." },
 *   "filter_title": { "type": "string", "required": false, "description": "Table filter title. Defaults to current column's title." },
 *   "cta_button_text": { "type": "string", "required": false, "description": "CTA button text" },
 *   "wrapper_attributes": { "type": "string", "require": false, "description": "Component's wrapper attributes." },
 *   "variant": { "type": "string", "require": false, "options": ["accessories", "quick-compare-models"], "description": "Table variation. Defaults to 'accessories'" }
 * }
 *
 * @example render_component('table', [
 *   'headers' => [ 'Description', 'Suggested Payload Limit', 'Static Movement Capacity (X & Y)', 'Static Movement Capacity (Z)' ],
 *   'rows' => [
 *        [
 *            'image_id' => 64,
 *            'content' => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
 *        ],
 *        [
 *            'image_id' => 64,
 *            'content' => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
 *        ],
 *        [
 *            'image_id' => 64,
 *            'content' => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
 *        ],
 *        [
 *            'image_id' => 64,
 *            'content' => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
 *        ],
 *   ],
 *   'filter_title' => 'Type',
 *   'filter_by' => 0,
 *   'cta_button_text' => 'Add to quote',
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['headers'] ) || empty( $args['rows'] ) ) {
	return;
}

// Default values.
$defaults = [
	'headers'            => [],
	'rows'               => [],
	'wrapper_attributes' => '',
	'filter_by'          => 0,
	'filter_title'       => '',
	'show_cta_button'    => true,
	'cta_button_text'    => __( 'Add to quote', 'one-novanta-theme' ),
	'variant'            => 'accessories',
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

// Destruct arguments.
$headers            = is_array( $args['headers'] ) ? $args['headers'] : $defaults['headers'];
$rows               = is_array( $args['rows'] ) ? $args['rows'] : $defaults['rows'];
$wrapper_attributes = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];
$filter_by          = is_int( $args['filter_by'] ) ? $args['filter_by'] : $defaults['filter_by'];
$filter_title       = is_string( $args['filter_title'] ) ? $args['filter_title'] : $defaults['filter_title'];
$cta_button_text    = is_string( $args['cta_button_text'] ) ? $args['cta_button_text'] : $defaults['cta_button_text'];
$variant            = is_string( $args['variant'] ) ? $args['variant'] : $defaults['variant'];
$show_cta_button    = $args['show_cta_button'];

// Base table class.
$base_class = 'wp-one-novanta-compare-model-table';

$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				$base_class,
				"$base_class--variant--$variant",
			],
		),
	],
];

// Generate filter options from rows.
if ( ! empty( $filter_by ) ) {
	$default_filter_text = sprintf( '%1$s %2$s', __( 'Filter by', 'one-novanta-theme' ), empty( $filter_title ) ? $headers[ $filter_by - 1 ] : $filter_title );
	$filter_options      = array_filter( // Remove empty values.
		array_unique( // Remove duplicates.
			array_map(
				function ( $row ) use ( $filter_by ) {
					return wp_strip_all_tags( $row['content'][ $filter_by - 1 ], true );
				},
				$rows,
			),
		)
	);
}

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<?php
	if ( ! empty( $filter_by ) ) {
		Template::render_component(
			'filter-dropdown',
			null,
			[
				'base_class'          => $base_class,
				'filter_options'      => $filter_options,
				'filter_by'           => $filter_by,
				'default_filter_text' => $default_filter_text,
			],
		);
	}
	?>

	<table class="<?php echo esc_attr( "{$base_class}__wrapper" ); ?>">

		<thead class="<?php echo esc_attr( "{$base_class}__head" ); ?>">
			<tr class="<?php echo esc_attr( "{$base_class}__head-row" ); ?>">
				<th class="<?php echo esc_attr( "{$base_class}__head-cell {$base_class}__head-image" ); ?>"></th>

				<?php foreach ( $headers as $header ) : ?>
					<th class="<?php echo esc_attr( "{$base_class}__head-cell" ); ?>"><?php echo esc_html( $header ); ?></th>
				<?php endforeach; ?>

				<?php if ( true === $show_cta_button ) : ?>
					<th class="<?php echo esc_attr( "{$base_class}__head-cell {$base_class}__head-cta" ); ?>"></th>
				<?php endif; ?>
			</tr>
		</thead>

		<tbody class="<?php echo esc_attr( "{$base_class}__body" ); ?>">

			<?php foreach ( $rows as $row ) : ?>
				<?php
				if ( empty( $row['content'] ) ) {
					continue;
				}
				?>

				<tr class="<?php echo esc_attr( "{$base_class}__body-row" ); ?>">
					<td class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-image" ); ?>">
						<?php
						// Image Component.
						Template::render_component(
							'image',
							null,
							[
								'id'   => $row['image_id'],
								'size' => [ 180, 180 ],
							]
						);
						?>
					</td>

					<?php foreach ( $row['content'] as $index => $cell ) : ?>
						<td
							class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-content" ); ?>"
							data-head="<?php echo esc_attr( $headers[ $index ] ); ?>"
						>
							<?php one_novanta_kses_post_e( $cell ); ?>
						</td>
					<?php endforeach; ?>

					<?php if ( true === $show_cta_button ) : ?>
						<td class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-cta" ); ?>">
							<?php
							if ( ! empty( $cta_button_text ) ) {
								Template::render_component(
									'button',
									null,
									[
										'content' => $cta_button_text,
										'icon'    => true,
									],
								);
							}
							?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
</div>
