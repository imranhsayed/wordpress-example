<?php
/**
 * Template controller.
 *
 * @package Aquila Theme
 */

namespace Aquila\Theme;

/**
 * Class Template
 */
class Template {

	/**
	 * Renders a template part with optional parameters and caching.
	 *
	 * @param string       $slug The slug name for the generic template.
	 * @param string|null  $name The name of the specialized template. Default is null.
	 * @param array<mixed> $params Optional parameters to pass to the template. Default is an empty array.
	 *
	 * @example Template::render_component( 'button', null, array( 'attributes' => $attributes, 'unique_id' => $unique_id ) );
	 * @return void
	 */
	public static function render_component( $slug, $name = null, $params = array() ) {

		$component_slug = $slug;

		if ( empty( $slug ) ) {
			return;
		}

		$component_path = 'src/components';

		$slug_parts = explode( '/', $slug );
		$slug       = sprintf( '%s/%s/%s', $component_path, $slug_parts[0], $name ?? 'index' );

		do_action( 'aquila_before_get_component', $component_slug, $name, $params );

		// @TODO: Add caching here.
		get_template_part( $slug, $name, $params );

		do_action( 'aquila_after_get_component', $component_slug, $name, $params );
	}

	/**
	 * Returns a template part with optional parameters and caching.
	 *
	 * @param string       $slug The slug name for the generic template.
	 * @param string|null  $name The name of the specialized template. Default is null.
	 * @param array<mixed> $params Optional parameters to pass to the template. Default is an empty array.
	 *
	 * @example Template::get_component( 'button', null, array( 'attributes' => $attributes, 'unique_id' => $unique_id ) );
	 * @return string|false If $should_echo is false, returns the markup as a string. Otherwise, outputs the markup directly.
	 */
	public static function get_component( $slug, $name = null, $params = array() ) {

		ob_start();

		self::render_component( $slug, $name, $params );

		$markup = ob_get_clean();

		return $markup ? $markup : '';
	}
}
