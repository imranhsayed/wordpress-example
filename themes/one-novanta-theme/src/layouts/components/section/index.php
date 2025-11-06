<?php
/**
 * Section Component.
 *
 * @package OneNovantaTheme\Components
 *
 * @component Section
 * @description A reusable section component
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "require": true, "description": "Section content."},
 *   "heading": {"type": "string", "required": false, "description": "Section title."},
 *   "has_heading": { "type": "boolean", "require": false, "description": "Show title. Default is true." },
 *   "heading_level": { "type": "string", "require": false, "options": ["1", "2", "3", "4", "5", "6"], "description": "Level of heading. Defaults to 2." },
 *   "heading_alignment": { "type": "string", "require": false, "options": ["left", "center", "right"], "description": "Align heading. Defaults to left." },
 *   "description": { "type": "string", "required": false, "description": "Section description. Default is true." },
 *   "has_description": { "type": "boolean", "required": false, "description": "Show description. Defaults to true." },
 *   "wrapper_attributes": { "type": "string", "required": false, "description": "Block's wrapper attributes" },
 *   "background_color": { "type": "string", "require": false, "options": ["background", "secondary"], "description": "Background color." },
 *   "has_spacing": { "type": "boolean", "require": false, "description": "Does section has spacing. Defaults to true." },
 *   "spacing": { "type": "string", "require": false, "options": ["small", "medium", "large"], "description": "Section's top and bottom spacing. Defaults to large." },
 *   "width": { "type": "string", "require": false, "options": ["narrow", "wide", "full"], "description": "Section alignment. Defaults to wide." }
 * }
 *
 * @example render_component( 'section', [
 *      'has_heading': true,
 *      'has_description': true,
 *      'heading': 'Heading...',
 *      'description': 'Description...',
 *      'content': 'Content...'
 * ] )
 */

if ( empty( $args ) || ! is_array( $args ) || empty( $args['content'] ) ) {
	return;
}

// Default values.
$defaults = [
	'heading'            => '',
	'description'        => '',
	'content'            => '',
	'hasHeading'         => true,
	'headingLevel'       => '2',
	'headingAlignment'   => 'left',
	'hasDescription'     => true,
	'wrapper_attributes' => '',
	'backgroundColor'    => '',
	'hasSpacing'         => true,
	'spacing'            => 'large',
	'width'              => 'wide',
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

// Destruct arguments.
$heading            = is_string( $args['heading'] ) ? $args['heading'] : $defaults['heading'];
$description        = is_string( $args['description'] ) ? $args['description'] : $defaults['description'];
$content            = is_string( $args['content'] ) ? $args['content'] : $defaults['content'];
$has_heading        = is_bool( $args['hasHeading'] ) ? $args['hasHeading'] : $defaults['hasHeading'];
$heading_level      = is_string( $args['headingLevel'] ) ? $args['headingLevel'] : $defaults['headingLevel'];
$heading_alignment  = is_string( $args['headingAlignment'] ) ? $args['headingAlignment'] : $defaults['headingAlignment'];
$has_description    = is_bool( $args['hasDescription'] ) ? $args['hasDescription'] : $defaults['hasDescription'];
$wrapper_attributes = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];
$background_color   = is_string( $args['backgroundColor'] ) ? $args['backgroundColor'] : $defaults['backgroundColor'];
$spacing            = is_string( $args['spacing'] ) ? $args['spacing'] : $defaults['spacing'];
$width              = is_string( $args['width'] ) ? $args['width'] : $defaults['width'];

$base_class = 'one-novanta-section';

$extra_attributes = [
	'class' => [
		one_novanta_merge_classes(
			[
				"$base_class alignfull is-layout-constrained",
				"$base_class--spacing--$spacing" => ! empty( $spacing ),
				"$base_class--has-background $base_class--background--$background_color" => ! empty( $background_color ),
			]
		),
	],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<?php
	if ( ( $has_heading || $has_description ) && ( ! empty( $heading ) || ! empty( $description ) ) ) :
		$heading_width = 'full' === $width ? 'wide' : $width;
		?>

		<div class="<?php echo esc_attr( "{$base_class}__header {$base_class}__header--align-$heading_alignment align$heading_width" ); ?>">
			<?php if ( $has_heading ) : ?>
				<h<?php echo esc_attr( $heading_level ); ?> class="<?php echo esc_attr( "{$base_class}__heading" ); ?> has-xx-large-font-size">
					<?php one_novanta_kses_post_e( $heading ); ?>
				</h<?php echo esc_attr( $heading_level ); ?>>
			<?php endif; ?>

			<?php if ( $has_description ) : ?>
				<p class="<?php echo esc_attr( "{$base_class}__description" ); ?>">
					<?php one_novanta_kses_post_e( $description ); ?>
				</p>
			<?php endif; ?>
		</div>

	<?php endif; ?>

	<div class="<?php echo esc_attr( "{$base_class}__content align$width" ); ?>"><?php one_novanta_kses_post_e( $content ); ?></div>
</div>
