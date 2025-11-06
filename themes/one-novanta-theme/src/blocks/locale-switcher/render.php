<?php
/**
 * Renders the Locale Switcher block on the front end.
 *
 * This template determines the current page (post or taxonomy term),
 * fetches its available translations, builds translated URLs,
 * and passes them to the locale-switcher component.
 *
 * Translations are only included if a valid permalink exists.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Get languages.
$languages = apply_filters( 'wpml_active_languages', null, [ 'skip_missing' => 1 ] );

// If no languages are available, exit early.
if ( empty( $languages ) ) {
	return;
}

// Initialize variables.
$current_language_data = [];
$other_languages_data  = [];

// Loop through the languages to find the current active language.
foreach ( $languages as $language ) {
	if ( ! empty( $language['active'] ) ) {
		$current_language_data = [
			'label'     => $language['translated_name'] ?? $language['display_name'],
			'locale'    => $language['default_locale'],
			'flag_url'  => $language['country_flag_url'],
			'is_active' => true,
			'url'       => $language['url'],
		];
	} else {
		$other_languages_data[] = [
			'label'     => $language['translated_name'] ?? $language['display_name'],
			'locale'    => $language['default_locale'],
			'flag_url'  => $language['country_flag_url'],
			'is_active' => false,
			'url'       => $language['url'],
		];
	}
}

// Render the locale switcher component.
Template::render_component(
	'locale-switcher',
	null,
	[
		'current_language_data' => $current_language_data,
		'other_languages_data'  => $other_languages_data,
		'wrapper_attributes'    => get_block_wrapper_attributes(),
	]
);
