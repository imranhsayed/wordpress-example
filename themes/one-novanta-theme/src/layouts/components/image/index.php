<?php
/**
 * Dynamic Image Component.
 *
 * @package OneNovantaTheme\Components
 *
 * @component Image
 * @description A reusable Image component
 * @group UI Elements
 * @props {
 *   "id": {"type": "int", "required": true, "description": "Image attachment ID"},
 *   "size": {"type": "string|int[]", "required": false, "description": "Image size. Accepts any registered image size name, or an array of width and height values in pixels (in that order). Default 'thumbnail'"},
 *   "icon": {"type": "bool", "required": false, "description": "Whether the image should be treated as an icon"},
 *   "attr": {"type": "string|array", "required": false, "description": "Attributes for the image markup"}
 * }
 *
 * @example render_component( 'image', [
 *   'id'   => 230,
 *   'size' => 'thumbnail',
 *   'icon' => false,
 *   'attr' => '',
 * ] );
 */

// Return if required arguments are missing.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = array(
	'id'              => 0,
	'size'            => 'thumbnail',
	'icon'            => false,
	'attrs'           => '',
	'use_focal_point' => false, // Whether to use focal point for the image.
);

// Note: array_filter will automatically remove all the empty values.
$args = array_merge( $defaults, array_filter( $args ) );

// Destruct arguments.
$image_id = intval( $args['id'] );
$size     = $args['size'];
$icon     = $args['icon'];
$attrs    = $args['attrs'];

if ( $args['use_focal_point'] && ! empty( $image_id ) ) {
	$focal_point     = get_focal_point( $image_id );
	$style_attribute = '';

	if ( ! empty( $focal_point ) && is_array( $focal_point ) ) {
		$style_attribute = sprintf(
			'style="object-position: %s %s;"',
			$focal_point['x'] * 100 . '%',
			$focal_point['y'] * 100 . '%'
		);
	}
} else {
	$focal_point     = null;
	$style_attribute = '';
}

// Fetch image.
$image = wp_get_attachment_image( $image_id, $size, $icon, $attrs );

if ( ! empty( $image ) ) {

	// If the image is not empty, add the style attribute.
	if ( ! empty( $style_attribute ) ) {
		$image = str_replace( 'class="', 'class="one-novanta-default-image ', $image );
		$image = str_replace( '<img', '<img ' . $style_attribute, $image );
	}

	// Display fetched image.
	one_novanta_kses_post_e( $image );
	return;

}

// Return if ONE_NOVANTA_THEME_DIR is not defined.
if ( ! defined( 'ONE_NOVANTA_THEME_DIR' ) ) {
	return;
}

// Generate default image path.
$default_image = sprintf(
	'%1$s/src/img/default_image.png',
	untrailingslashit( ONE_NOVANTA_THEME_DIR )
);

// Generate default image URI.
$default_image_uri    = get_theme_file_uri( 'src/img/default_image.png' );
$default_image_width  = null;
$default_image_height = null;

// Fetch width and height if a custom size is provided.
if ( is_array( $size ) ) {
	$default_image_width  = $size[0];
	$default_image_height = $size[1];
}

// Fetch width and height if size in string is passed i.e., thumbnail, large, full, etc.
if ( is_string( $size ) ) {

	// Built-in sizes.
	if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large', 'full' ) ) ) {
		$default_image_width  = get_option( sprintf( '%s_size_w', $size ) );
		$default_image_height = get_option( sprintf( '%s_size_h', $size ) );
	} else {

		$additional_sizes = wp_get_additional_image_sizes();

		if ( isset( $additional_sizes[ $size ] ) ) {
			$default_image_width  = $additional_sizes[ $size ]['width'];
			$default_image_height = $additional_sizes[ $size ]['height'];
		}
	}
}

// Generate size from the default image if size is not provided.
if ( empty( $size ) ) {
	$default_size = wp_getimagesize( $default_image );

	if ( ! empty( $default_size ) && is_array( $default_size ) ) {
		$default_image_width  = $default_size[0];
		$default_image_height = $default_size[1];
	}
}

// If still the height is empty, update height to default height.
if ( empty( $default_image_width ) ) {
	$default_image_width = 300;
}

// If still width is empty, update width to default width.
if ( empty( $default_image_height ) ) {
	$default_image_height = 300;
}

// Render a default image file if it exists.
?>
	<img
		loading="lazy"
		src="<?php echo esc_url( $default_image_uri ); ?>"
		alt="<?php echo esc_attr__( 'Default Image', 'one-novanta-theme' ); ?>"
		class="one-novanta-default-image"
		width="<?php echo esc_attr( $default_image_width ); ?>"
		height="<?php echo esc_attr( $default_image_height ); ?>"
	/>
<?php
