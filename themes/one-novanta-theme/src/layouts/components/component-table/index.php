<?php
/**
 * Component Table
 *
 * @component Component Table
 * @description A reusable table component
 * @group UI Elements
 * @props {
 *   "headers": {"type": "array", "required": true, "description": "Table headers."},
 *   "rows": { "type": "array", "required": true, "description": "Table rows." },
 *   "wrapper_attributes": { "type": "string", "require": false, "description": "Component's wrapper attributes." }
 * }
 *
 * @example
 * render_component('table', [
 *   'headers' => [ 'Part Number', 'Description', '' ],
 *   'rows' => [
 *     [
 *       [
 *         'label'   => 'Part Number',
 *         'content' => '9120-CV10P-T',
 *       ],
 *       [
 *         'label'   => 'Description',
 *         'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.
 *                       Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
 *       ],
 *       [
 *         'label'   => '',
 *         'content' => Template::get_component(
 *           'button',
 *           null,
 *           [
 *             'content' => 'Add to Quote',
 *             'icon'    => true,
 *             'url'     => '#',
 *           ]
 *         ),
 *       ],
 *     ],
 *     [
 *       [
 *         'label'   => 'Part Number',
 *         'content' => '9120-CV10P-T',
 *       ],
 *       [
 *         'label'   => 'Description',
 *         'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.
 *                       Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
 *       ],
 *       [
 *         'label'   => '',
 *         'content' => Template::get_component(
 *           'button',
 *           null,
 *           [
 *             'content' => 'Add to Quote',
 *             'icon'    => true,
 *             'url'     => '#',
 *           ]
 *         ),
 *       ],
 *     ],
 *   ],
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

	// Return if required arguments are not available.
if (
	empty( $args ) ||
	! is_array( $args ) ||
	empty( $args['headers'] ) ||
	empty( $args['rows'] )
	) {
	return;
}

	// Default values.
	$defaults = [
		'headers'            => [],
		'rows'               => [],
		'wrapper_attributes' => '',
	];

	// Merge arguments with defaults.
	$args = wp_parse_args( $args, $defaults );

	// Destructure arguments.
	$headers            = $args['headers'];
	$rows               = $args['rows'];
	$wrapper_attributes = $args['wrapper_attributes'];

	// Extra attributes.
	$extra_attributes = [
		'class' => [
			'component-table',
			'alignwide',
			'typography-spacing',
			'has-medium-font-size',
		],
	];

	// Combine extra attributes into wrapper attributes.
	$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
	?>

<table <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<thead class="component-table__head">
		<tr>
			<?php foreach ( $headers as $header_text ) : ?>
				<?php if ( ! empty( $header_text ) ) : ?>
					<th><?php echo esc_html( $header_text ); ?></th>
				<?php else : ?>
					<th></th>
				<?php endif; ?>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $rows as $row ) : ?>
			<tr class="component-table__row">
				<?php foreach ( $row as $row_item ) : ?>
					<td>
						<?php if ( ! empty( $row_item['label'] ) ) : ?>
							<p class="component-table__label"><?php echo esc_html( $row_item['label'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $row_item['content'] ) ) : ?>
							<div class="component-table__text">
								<?php one_novanta_kses_post_e( $row_item['content'] ); ?>
							</div>
						<?php endif; ?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
