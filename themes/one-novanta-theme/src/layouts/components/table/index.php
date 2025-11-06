<?php
/**
 * Component Table
 *
 * @component Table
 * @description A reusable table component
 * @group UI Elements
 * @props {
 *   "headers": {"type": "array", "required": true, "description": "Table headers."},
 *   "rows": { "type": "array", "required": true, "description": "Table rows." },
 *   "caption": {"type": "string", "required": false, "description": "Table caption" },
 *   "background_color": { "type": "string", "required": false, "options": ["background", "secondary"], "description": "Table background color. Defaults to 'background' i.e., white." },
 *   "header_background_color": { "type": "string", "required": false, "options": ["mid-gray", "secondary"], "description": "Table header background color. Defaults to 'mid-gray' },
 *   "filter_by": { "type": "integer", "required": false, "description": "Column index (starting with 1) using which table can be filtered." },
 *   "filter_title": { "type": "string", "required": false, "description": "Table filter title. Defaults to current column's title." },
 *   "wrapper_attributes": { "type": "string", "require": false, "description": "Component's wrapper attributes." }
 *   "table_title": { "type": "string", "required": false, "description": "Table title." }
 *   "load_more_attributes": { "type": "array", "required": false, "description": "Load more component attributes." }
 *   "is_loading": { "type": "boolean", "required": false, "description": "Whether the table is in loading state. Defaults to false." }
 * }
 *
 * @example render_component('table', [
 *   'headers' => [ 'Part Number', 'Value (Metric)', 'Value (Imperial)' ],
 *   'rows' => [
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *        [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
 *   ],
 *   'caption' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.',
 *   'background_color' => 'secondary',
 *   'filter_title' => 'Metric',
 *   'filter_by' => 1,
 *   'title' => 'Table title',
 *   'load_more_attributes' => [
 *      'page'                => 1,
 *      'target'              => '.wp-one-novanta-table__body',
 *      'numberOfPostsToLoad' => 10,
 *    ]
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['headers'] ) || ( empty( $args['rows'] ) && empty( $args['is_loading'] ) ) ) {
	return;
}

// Default values.
$defaults = [
	'headers'                 => [],
	'rows'                    => [],
	'caption'                 => '',
	'background_color'        => 'background',
	'header_background_color' => 'mid-gray',
	'wrapper_attributes'      => '',
	'filter_by'               => 0,
	'filter_title'            => '',
	'table_title'             => '',
	'load_more_attributes'    => [],
	'is_loading'              => false,
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

// Destruct arguments.
$headers                 = is_array( $args['headers'] ) ? $args['headers'] : $defaults['headers'];
$rows                    = is_array( $args['rows'] ) ? $args['rows'] : $defaults['rows'];
$caption                 = is_string( $args['caption'] ) ? $args['caption'] : $defaults['caption'];
$background_color        = is_string( $args['background_color'] ) ? $args['background_color'] : $defaults['background_color'];
$header_background_color = is_string( $args['header_background_color'] ) ? $args['header_background_color'] : $defaults['header_background_color'];
$wrapper_attributes      = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];
$filter_by               = is_int( $args['filter_by'] ) ? $args['filter_by'] : $defaults['filter_by'];
$filter_title            = is_string( $args['filter_title'] ) ? $args['filter_title'] : $defaults['filter_title'];
$table_title             = is_string( $args['table_title'] ) ? $args['table_title'] : $defaults['table_title'];
$load_more_attributes    = is_array( $args['load_more_attributes'] ) ? $args['load_more_attributes'] : $defaults['load_more_attributes'];
$is_loading              = isset( $args['is_loading'] ) ? (bool) $args['is_loading'] : $defaults['is_loading'];

/**
 * When row's content is called from a block.
 * We should directly render it out.
 */
$block_rows_content = ( isset( $args['rows'] ) && is_string( $args['rows'] ) ) ? $args['rows'] : '';

// Base table class.
$base_class = 'wp-one-novanta-table';

$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				$base_class,
				"$base_class--has-background--$background_color",
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
					return wp_strip_all_tags( $row[ $filter_by - 1 ] ?? '', true );
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

	<div class="<?php echo esc_attr( "{$base_class}__header" ); ?>">
		<?php	if ( ! empty( $table_title ) ) : ?>
			<h2 class="<?php echo esc_attr( "{$base_class}__header__title" ); ?>"><?php echo esc_html( $table_title ); ?></h2>
		<?php endif; ?>

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
	</div>

	<figure data-is-loading="<?php echo esc_attr( $is_loading ? 'true' : 'false' ); ?>">

		<table class="<?php echo esc_attr( "{$base_class}__wrapper" ); ?>">

			<thead class="<?php echo esc_attr( "{$base_class}__head" ); ?>">
				<tr class="<?php echo esc_attr( "{$base_class}__head-row" ); ?>">
					<?php foreach ( $headers as $header ) : ?>
						<th class="<?php echo esc_attr( "{$base_class}__head-cell {$base_class}__head-cell__background-{$header_background_color}" ); ?>"><?php echo esc_html( $header ); ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody class="<?php echo esc_attr( "{$base_class}__body" ); ?>">
			<?php
			if ( ! empty( $rows ) ) {
				foreach ( $rows as $row ) {
					Template::render_component(
						'table',
						'row',
						[
							'row' => $row,
						]
					);
				}
			} elseif ( ! empty( $block_rows_content ) ) {
				one_novanta_kses_post_e( $block_rows_content );
			}
			?>
			</tbody>

		</table>

		<?php if ( ! empty( $caption ) ) : ?>
			<figcaption class="<?php echo esc_attr( "{$base_class}__caption" ); ?>"><?php one_novanta_kses_post_e( $caption ); ?></figcaption>
		<?php endif; ?>

	<div class="
		<?php
		echo esc_attr(
			one_novanta_merge_classes(
				[
					"{$base_class}__is-loading",
					'hidden' => ! $is_loading,
				]
			)
		);
		?>
	">
		<?php
		Template::render_component(
			'svg',
			null,
			[
				'name' => 'spinner',
			]
		);
		?>
	</div>

	</figure>

	<?php
	if ( ! empty( $load_more_attributes ) ) {
		Template::render_component(
			'load-more',
			null,
			$load_more_attributes
		);
	}
	?>

</div>
