<?php
/**
 * Custom functions.
 *
 * @package AquilaTheme
 */

use Aquila\Controllers\Common\Template;

/**
 * Displays text escaped by aquila_kses_post method.
 *
 * @param string $data Content to escape.
 *
 * @return void
 */
function aquila_kses_post_e( string $data ): void {
	echo aquila_kses_post( $data );
}

/**
 * Extended wp_kses_post method.
 *
 * Extends wp_kses_post() by adding support for other components:
 *
 * Extends wp_kses_post() by removing support for the following:
 * // Add a list of removed support here.
 *
 * @param string $data Content to escape.
 *
 * @return string Escaped content.
 */
function aquila_kses_post( string $data ): string {
	// Fetch default allowed HTML tags.
	$kses_defaults = wp_kses_allowed_html( 'post' );

	// Allow use of SVGs.
	$allowed_tags = [
		'form'                                      => [
			'id'                      => true,
			'class'                   => true,
			'method'                  => true,
			'action'                  => true,
			'data-action'             => true,
			'novalidate'              => true,
			'enctype'                 => true,
			'data-product_id'         => true,
			'data-product_variations' => true,
		],
		'select'                                    => [
			'name'     => true,
			'class'    => true,
			'id'       => true,
			'form'     => true,
			'multiple' => true,
			'disabled' => true,
		],
		'option'                                    => [
			'value'    => true,
			'selected' => true,
		],
		'input'                                     => [
			'class'          => true,
			'type'           => true,
			'autocomplete'   => true,
			'name'           => true,
			'placeholder'    => true,
			'required'       => true,
			'checked'        => true,
			'value'          => true,
			'disabled'       => true,
			'data-taxonomy'  => true,
			'data-post-type' => true,
		],
		'textarea'                                  => [
			'id'          => true,
			'class'       => true,
			'placeholder' => true,
			'name'        => true,
			'rows'        => true,
			'disabled'    => true,
			'cols'        => true,
		],
		'svg'                                       => [
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
			'fill'            => true,
			'stroke'          => true,
		],
		'g'                                         => [ 'fill' => true ],
		'defs'                                      => true,
		'clipPath'                                  => [ 'id' => true ],
		'title'                                     => [ 'title' => true ],
		'path'                                      => [
			'd'               => true,
			'fill'            => true,
			'fill-rule'       => true,
			'clip-rule'       => true,
			'stroke'          => true,
			'stroke-linejoin' => true,
			'stroke-width'    => true,
			'opacity'         => true,
			'class'           => true,
		],
		'animatetransform'                          => [
			'attributename' => true,
			'attributetype' => true,
			'type'          => true,
			'from'          => true,
			'to'            => true,
			'begin'         => true,
			'dur'           => true,
			'repeatcount'   => true,
			'fill'          => true,
			'values'        => true,
		],
		'circle'                                    => [
			'r'            => true,
			'cx'           => true,
			'cy'           => true,
			'stroke'       => true,
			'stroke-width' => true,
		],
		'line'                                      => [
			'id'     => true,
			'x1'     => true,
			'y1'     => true,
			'x2'     => true,
			'y2'     => true,
			'stroke' => true,
		],
		'one-aquila-theme-locale-switcher'         => [
			'class' => true,
		],
		'one-aquila-sort-dropdown'                 => [
			'class' => true,
		],
		'one-aquila-toggle-search-filter-button'   => [
			'class'         => true,
			'expand-text'   => true,
			'collapse-text' => true,
		],
		'one-aquila-toggle-minimize-filter-button' => [
			'class'         => true,
			'expand-text'   => true,
			'collapse-text' => true,
		],
	];

	// Updated allowed HTML tags array.
	$allowed_tags = array_merge( $kses_defaults, $allowed_tags );

	// Return escaped content.
	return wp_kses( $data, $allowed_tags );

}
