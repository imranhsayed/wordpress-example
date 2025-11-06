<?php
/**
 * PHP file to render the block on server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

if ( ! is_search() ) {
	return '';
}

$search_query = get_search_query();
$found_posts  = $GLOBALS['wp_query']->found_posts;

// Plural and singular handling if there are only one result.
$results = _n( 'result', 'results', absint( $found_posts ), 'one-novanta-theme' );

if ( ! empty( $search_query ) ) {
	echo '<div class="wp-block-group alignwide search-results-title-count"><h1 class="wp-block-heading search-results-title-count__title has-display-font-size">';
	echo wp_kses_post(
		sprintf(
			// translators: %1$d: number of results, %2$s: plural or singular form of 'result', %3$s: search term.
			__( 'Search results <sub class="has-large-font-size search-results-title-count__count">%1$1d %2$2s for "%3$3s"</sub>', 'one-novanta-theme' ),
			number_format_i18n( $found_posts ),
			esc_html( $results ),
			esc_html( $search_query )
		)
	);
	echo '</h1></div>';
}
