<?php
/**
 * Translations for the block.
 *
 * @package OneNovantaTheme\Blocks
 */

add_filter( 'novanta_multilingual_block_translation', 'one_novanta_product_search_block_translation', 10, 4 );

/**
 * Translate the block attributes.
 *
 * @param array<string, string> $translations  Translated strings.
 * @param array<string, mixed>  $parsed_block  Parsed block.
 * @param string                $to_language   Language to translate to.
 * @param string                $from_language Language to translate from.
 *
 * @return array{}|array{
 *     array{
 *         source: string,
 *         translation: string,
 *     }
 * } Translated strings.
 */
function one_novanta_product_search_block_translation( array $translations = [], array $parsed_block = [], string $to_language = '', string $from_language = 'en' ): array {
	// Bail out if translation is not for current block.
	if ( empty( $parsed_block ) || 'one-novanta/product-search' !== $parsed_block['blockName'] ) {
		return $translations;
	}

	// Get attributes.
	$attributes = $parsed_block['attrs'] ?? [];

	// Bail out if no attributes.
	if (
		empty( $attributes ) ||
		empty( $attributes['taxQuery'] ) ||
		! is_array( $attributes['taxQuery'] )
	) {
		return $translations;
	}

	// Get Taxonomy query.
	$tax_query = $attributes['taxQuery'];

	// Loop through taxonomies.
	foreach ( $tax_query as $taxonomy => $term_ids ) {
		// Bail out if taxonomy is not translatable.
		if ( ! is_taxonomy_translated( $taxonomy ) ) {
			continue;
		}

		// Check if the attribute value is empty.
		$translated_value = Novanta\Multilingual\translate_value_by_type( $term_ids, 'taxonomy', $to_language, $from_language );

		// Update the attribute value.
		if ( is_array( $translated_value ) ) {
			$translated_value = array_filter( $translated_value );
			$translated_value = array_map( 'absint', $translated_value );

			$translations[] = [
				'source'      => $taxonomy . '":[' . implode( ',', array_map( 'absint', $term_ids ) ) . ']',
				'translation' => $taxonomy . '":[' . implode( ',', array_map( 'absint', $translated_value ) ) . ']',
			];
		} else {
			$translations[] = [
				'source'      => $taxonomy . '":' . $term_ids,
				'translation' => $taxonomy . '":' . $translated_value,
			];
		}
	}

	// Return translations.
	return $translations;
}
