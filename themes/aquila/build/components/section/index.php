<?php
/**
 * Component Section
 *
 * @component Section
 * @description A reusable section component with title, background, padding and CTA options
 * @group UI Elements
 * @props {
 *   "title": {"type": "string", "description": "Section title (optional)"},
 *   "title_align": {"type": "string", "options": ["center", "left"], "description": "Title alignment (optional)"},
 *   "heading_level": {"type": "string", "options": ["1", "2", "3"], "description": "Heading level (optional)"},
 *   "heading_style": {"type": "string", "options": ["", "1", "2", "3"], "description": "Heading style override (optional)"},
 *   "class": {"type": "string", "description": "Additional CSS classes (optional)"},
 *   "id": {"type": "string", "description": "Element ID (optional)"},
 *   "seamless": {"type": "boolean", "description": "Remove default margins (optional)"},
 *   "narrow": {"type": "boolean", "description": "Use narrow width (optional)"},
 *   "background": {"type": "boolean", "description": "Add background color (optional)"},
 *   "background_color": {"type": "string", "options": ["black", "gray"], "description": "Background color (optional)"},
 *   "padding": {"type": "boolean", "description": "Add padding (optional)"},
 *   "cta_button": {"type": "array", "description": "CTA button configuration (optional)"},
 *   "description": {"type": "string", "description": "Section description (optional)"}
 * }
 * @example render_component('section', [
 *   'title' => 'Section Title',
 *   'heading_level' => '2',
 *   'background' => true,
 *   'background_color' => 'gray',
 * ]);
 *
 * @package Aquila\Components
 */

use Aquila\Theme\Template;

// Return if slot is empty.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Default values.
$defaults = array(
	'title'            => '',
	'title_align'      => 'center',
	'heading_level'    => '2',
	'heading_style'    => '',
	'class'            => '',
	'id'               => '',
	'seamless'         => false,
	'narrow'           => false,
	'background'       => false,
	'background_color' => 'gray',
	'padding'          => false,
	'cta_button'       => array(),
	'description'      => '',
);

// Merge arguments with defaults.
$args = array_merge( $defaults, array_filter( $args ) );

// Destruct arguments.
$title            = $args['title'];
$title_align      = $args['title_align'];
$heading_level    = $args['heading_level'];
$heading_style    = $args['heading_style'];
$class            = $args['class'];
$id               = $args['id'];
$seamless         = $args['seamless'];
$narrow           = $args['narrow'];
$background       = $args['background'];
$background_color = $args['background_color'];
$padding          = $args['padding'];
$cta_button       = $args['cta_button'];
$description      = $args['description'];

// Determine tag name - section if has title, div otherwise.
$tag_name = ! empty( $title ) ? 'section' : 'div';

// Build classes array.
$classes = array( 'section' );

if ( ! empty( $class ) ) {
	$classes[] = $class;
}

if ( $seamless || $background ) {
	$classes[] = 'section--seamless';
}

if ( $narrow ) {
	$classes[] = 'section--narrow';
}

if ( $background ) {
	$classes[] = 'section--has-background';
	$classes[] = 'section--seamless-with-padding';
	$classes[] = 'full-width';

	// Add background color class.
	$allowed_colors = array( 'black', 'gray' );
	if ( ! empty( $background_color ) && in_array( $background_color, $allowed_colors, true ) ) {
		$classes[] = sprintf( 'section--has-background-%s', $background_color );
	}
}

if ( $padding ) {
	$classes[] = 'section--seamless-with-padding';
}

// Section title classes.
$section_title_tag_name = sprintf( 'h%s', $heading_level );
$section_title_classes  = array( 'section__title' );

if ( ! empty( $heading_style ) ) {
	$section_title_classes[] = sprintf( 'h%s', $heading_style );
}

if ( ! empty( $title_align ) && 'left' === $title_align ) {
	$section_title_classes[] = 'section__title--left';
}
?>

<<?php echo esc_html( $tag_name ); ?>
	<?php if ( ! empty( $id ) ) : ?>
		id="<?php echo esc_attr( $id ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
>
	<?php if ( $background ) : ?>
		<div class="wrap">
	<?php endif; ?>

	<?php if ( ! empty( $title ) && ! empty( $cta_button ) ) : ?>
		<div class="section__title-and-cta">
			<<?php echo esc_html( $section_title_tag_name ); ?> class="<?php echo esc_attr( implode( ' ', $section_title_classes ) ); ?>">
				<?php echo esc_html( $title ); ?>
			</<?php echo esc_html( $section_title_tag_name ); ?>>
		</div>
	<?php elseif ( ! empty( $title ) ) : ?>
		<<?php echo esc_html( $section_title_tag_name ); ?> class="<?php echo esc_attr( implode( ' ', $section_title_classes ) ); ?>">
			<?php echo esc_html( $title ); ?>
		</<?php echo esc_html( $section_title_tag_name ); ?>>
	<?php endif; ?>

	<?php if ( ! empty( $description ) ) : ?>
		<p class="section__description"><?php echo esc_html( $description ); ?></p>
	<?php endif; ?>

	<?php
	// Render slot content.
	if ( ! empty( $args['slot'] ) ) {
		echo wp_kses_post( $args['slot'] );
	}
	?>
	<?php
	// Render CTA button.
	Template::render_component(
		'button',
		null,
		array(
			'content'    => $cta_button['text'] ?? '',
			'url'        => $cta_button['url'] ?? '',
			'new_window' => $cta_button['new_window'] ?? false,
			'variant'    => $cta_button['variant'] ?? 'primary',
		)
	);
	?>
	<?php if ( $background ) : ?>
		</div>
	<?php endif; ?>
</<?php echo esc_html( $tag_name ); ?>>
