<?php
/**
 * Filter Dropdown
 *
 * @component Filter Dropdown
 * @description A reusable filter-dropdown component
 * @group UI Elements
 * @props {
 *   "base_class": {"type": "string", "required": true, "description": "Base Class."},
 *   "filter_options": {"type": "array", "required": true, "description": "Filter Options."},
 *   "default_filter_text": {"type": "string", "required": "true", "description": "Filter's default option."},
 *   "filter_prefix": {"type": "string", "required": "false", "description": "Filter's prefix."},
 *   "filter_by": {"type": "integer", "required": false, "description": "Table column number by which table should be filtered. Defaults to 0."},
 *   "dropdown_list_position": {"type": "string", "required": false, "options": ["left", "right"], "description": "Position of dropdown relative to select button. Defaults to left."},
 *   "wrapper_attributes": {"type": "string", "required": false, "description": "Component's wrapper attributes. Defaults to ''."}
 * }
 *
 * @example render_component( 'filter-dropdown', [
 *    'base_class' => 'one-novanta-table',
 *    'filter_options' => [ 'Electronic Data Sheet (EDS)', 'Catalog', 'Product Flyer', 'Manual' ],
 *    'filter_by' => 2,
 *    'default_filter_text' => 'Filter By Type',
 * ] );
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if (
	empty( $args ) ||
	! is_array( $args ) ||
	empty( $args['base_class'] ) ||
	empty( $args['filter_options'] ) ||
	empty( $args['default_filter_text'] )
) {
	return;
}

// Default values.
$defaults = [
	'base_class'             => '',
	'filter_options'         => [],
	'default_filter_text'    => '',
	'filter_prefix'          => '',
	'wrapper_attributes'     => '',
	'filter_by'              => 0,
	'dropdown_list_position' => 'left',
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

// Destruct arguments.
$base_class             = is_string( $args['base_class'] ) ? $args['base_class'] : $defaults['base_class'];
$filter_options         = is_array( $args['filter_options'] ) ? $args['filter_options'] : $defaults['filter_options'];
$default_filter_text    = is_string( $args['default_filter_text'] ) ? $args['default_filter_text'] : $defaults['default_filter_text'];
$filter_prefix          = is_string( $args['filter_prefix'] ) ? $args['filter_prefix'] : $defaults['filter_prefix'];
$wrapper_attributes     = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];
$filter_by              = is_int( $args['filter_by'] ) ? $args['filter_by'] : $defaults['filter_by'];
$dropdown_list_position = is_string( $args['dropdown_list_position'] ) ? $args['dropdown_list_position'] : $defaults['dropdown_list_position'];

$filter_button_content = sprintf(
	'<span class="one-novanta-filter-dropdown__selected"><span class="has-medium-font-size one-novanta-filter-dropdown__selected-value-prefix">%1$s</span><span class="has-medium-font-size one-novanta-filter-dropdown__selected-value">%2$s</span></span>',
	esc_html( empty( $filter_prefix ) ? '' : $filter_prefix ),
	esc_html( $default_filter_text ),
);
?>

<div
	class="<?php echo esc_attr( "{$base_class}__filter one-novanta-filter-dropdown" ); ?>"
	<?php echo wp_kses_data( $wrapper_attributes ); ?>
	<?php if ( ! empty( $filter_by ) ) : ?>
		data-filter-column="<?php echo esc_attr( strval( $filter_by ) ); ?>"
	<?php endif; ?>
>

	<?php
		Template::render_component(
			'button',
			null,
			[
				'content'            => $filter_button_content,
				'variant'            => 'secondary',
				'icon'               => true,
				'icon_name'          => 'arrow-down',
				'wrapper_attributes' => one_novanta_get_wrapper_attributes(
					[
						'class'         => [ 'one-novanta-filter-dropdown__button' ],
						'aria-expanded' => [ 'false' ],
						'aria-haspopup' => [ 'listbox' ],
					],
				),
			],
		);
		?>

	<ul class="<?php echo esc_attr( "one-novanta-filter-dropdown__dropdown-list is-hidden one-novanta-filter-dropdown__dropdown-list--{$dropdown_list_position}" ); ?>" role="listbox">
		<!-- Default option -->
		<li aria-selected="true" role="option" class="<?php echo esc_attr( "selected {$base_class}__filter__option--default" ); ?>"><?php echo esc_html( $default_filter_text ); ?></li>

		<!-- Options from column. -->
		<?php
		foreach ( $filter_options as $filter_value => $filter_option ) :
			$filter_slug_attribute = '';

			if ( ! is_numeric( $filter_value ) ) {
				$filter_slug_attribute = "data-filter-slug={$filter_value}";
			}

			?>
			<li aria-selected="false" role="option" <?php echo esc_attr( $filter_slug_attribute ); ?>><?php echo esc_html( $filter_option ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>
