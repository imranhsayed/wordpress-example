<?php
/**
 * Custom functions.
 *
 * @package AquilaTheme
 */

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

	$accordion_web_component_args = [
		'rt-accordion'         => [
			'class' => true,
		],
		'rt-accordion-item'    => [
			'open-by-default' => true,
			'aria-expanded'   => true,
			'expanded'        => true,
			'class'           => true,
		],
		'rt-accordion-handle'  => [
			'aria-expanded' => true,
			'class'         => true,
		],
		'rt-accordion-content' => [
			'class' => true,
		],
		'button'               => [
			'aria-expanded' => true,
			'class'         => true,
			'tabindex'      => true,
			'aria-label'    => true,
			'type'          => true,
			'id'            => true,
		],
	];

	// Updated allowed HTML tags array.
	$allowed_tags = array_merge( $kses_defaults, $allowed_tags, $accordion_web_component_args );

	// Return escaped content.
	return wp_kses( $data, $allowed_tags );

}

/**
 * Generates wrapper attributes from provided attributes.
 * Appends generated wrapper attributes `$wrapper_attributes` string if provided.
 *
 * Note: Values for the keys in $extra_attributes should always be an array of strings.
 *
 * @param array<string, array<string>> $extra_attributes   Attributes from which wrapper attribute string should be generated.
 * @param string                       $wrapper_attributes Block's wrapper attributes.
 *
 * @example get_wrapper_attributes([ 'class' => [ 'class-1', 'class-2' ] ]);
 *          get_wrapper_attributes([ 'class' => [ 'class-1', 'class-2' ] ], get_block_wrapper_attributes()); // get_block_wrapper_attributes is a default WordPress function that provides block wrapper attributes.
 *
 * @return string String of generated wrapper attributes.
 */
function aquila_get_wrapper_attributes( array $extra_attributes = [], string $wrapper_attributes = '' ): string {

	// Return $wrapper_attributes if $extra_attributes are not specified.
	if ( empty( $extra_attributes ) ) {
		return $wrapper_attributes;
	}

	/**
	 * Explode default wrapper attributes.
	 *
	 * @example For button block wrapper_attributes be 'class="button-block wp-block-aquila-button-block" content="Hello World"'.
	 *          Current command will convert it to [ 'class="button-block wp-block-aquila-button-block"', 'content="Hello World"' ].
	 */
	$attributes = explode( '" ', trim( $wrapper_attributes ) );

	$normalized_attributes = [];
	$finalized_attributes  = [];

	/**
	 * Loop through an exploded wrapper attributes array i.e., $attributes and normalize them.
	 *
	 * @example [ 'class="button-block wp-block-aquila-button-block"', 'content="Hello World"' ] will be converted to
	 *          [ 'class' => [ 'button-block', 'wp-block-aquila-button-block' ], 'content' => [ 'Hello World' ] ]
	 */
	foreach ( $attributes as $attribute ) {
		$attribute = explode( '=', trim( $attribute ) );

		if ( empty( $attribute ) || 2 !== count( $attribute ) ) {
			continue;
		}

		$normalized_attributes[ trim( $attribute[0] ) ] = explode( ' ', trim( $attribute[1], ' "' ) );
	}

	/**
	 * Loop through normalized attributed and merge them with extra attributes.
	 *
	 * @example if [ 'class' => [ 'class-1', 'class-2' ] ] is passed in extra attributes,
	 *          normalized attributes array will be converted to
	 *          [
	 *              'class' => [ 'button-block', 'wp-block-aquila-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
	 *              'Content' => [ 'Hello World' ],
	 *          ]
	 */
	foreach ( $extra_attributes as $attribute_key => $attribute_value ) {

		$normalized_attributes[ $attribute_key ] = array_merge(
			array_filter( (array) ( $normalized_attributes[ $attribute_key ] ?? [] ) ),
			array_filter( (array) $attribute_value, 'is_string' )
		);
	}

	/**
	 * Merge the normalized array and create a finalized array.
	 *
	 * @example [
	 *              'class' => [ 'button-block', 'wp-block-aquila-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
	 *               'Content' => [ 'Hello World' ],
	 *          ]
	 *          will be converted to [ 'class="button-block wp-block-aquila-button-block class-1 class-2"', 'content="Hello World"' ]
	 */
	foreach ( $normalized_attributes as $attribute_key => $attribute_value ) {
		$finalized_attributes[] = $attribute_key . '="' . esc_attr( implode( ' ', $attribute_value ) ) . '"';
	}

	// Join the finalized array and return as a string.
	return implode( ' ', $finalized_attributes );
}
