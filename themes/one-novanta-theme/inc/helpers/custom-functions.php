<?php
/**
 * Custom functions.
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

use function Novanta\Multilingual\get_languages;
use function Novanta\Multilingual\get_current_language;

/**
 * Bootstrap the theme.
 *
 * @return void
 */
function one_novanta_theme_bootstrap(): void {
	add_filter( 'wp_kses_allowed_html', 'one_novanta_kses_custom_allowed_html', 10, 2 );
}

/**
 * Add custom allowed HTML tags.
 *
 * @param mixed[] $tags    Allowed HTML tags.
 * @param string  $context Context for which the tags are allowed.
 *
 * @return mixed[] Updated allowed HTML tags.
 */
function one_novanta_kses_custom_allowed_html( array $tags = [], string $context = 'post' ): array {
	// Do this only for the post context.
	if ( 'post' === $context ) {
		$tags = array_merge(
			$tags,
			[
				'ati-add-to-cart-button'     => [
					'data-product-id' => true,
					'data-text'       => true,
					'data-added-text' => true,
				],
				'one-novanta-product-search' => [
					'class' => true,
				],
			]
		);
	}

	// Return updated kses tags.
	return $tags;
}

/**
 * Get speak to our expert URL.
 *
 * @return string Speak to our expert URL.
 */
function one_novanta_get_speak_our_expert_url(): string {
	// Get the page ID.
	$expert_page_id = absint( get_option( 'options_speak_to_expert_page', 0 ) );

	// Bail out if the page ID is empty.
	if ( empty( $expert_page_id ) ) {
		return '';
	}

	// Get the post data.
	$expert_page = one_novanta_get_post( $expert_page_id );

	// Check if the post is empty or not a WP_Post object.
	if ( ! $expert_page['post'] instanceof WP_Post ) {
		return '';
	}

	// Return the permalink.
	return $expert_page['permalink'] ?? '';
}

/**
 * Get document link.
 *
 * @param int $post_id Post ID.
 *
 * @return string Document link.
 */
function one_novanta_get_document_link( int $post_id = 0 ): string {
	// Bail out if the document is empty.
	if ( empty( $post_id ) ) {
		return '';
	}

	// Get the document post.
	$the_post = one_novanta_get_post( $post_id );

	// Check if the document is empty or not a WP_Post object.
	if ( ! $the_post['post'] instanceof WP_Post ) {
		return '';
	}

	// Check if document have attachment linked or not.
	$post_meta     = $the_post['post_meta'] ?? [];
	$document_link = $post_meta['document_link'] ?? '';

	// Check if document link is empty or not.
	if ( ! empty( $document_link ) && is_numeric( $document_link ) ) {
		$document_link = wp_get_attachment_url( absint( $document_link ) );
	}

	// Document link.
	return $document_link ?? '';
}

/**
 * Get document data.
 *
 * @param int                 $post_id Post ID.
 * @param array<string,mixed> $args Have the following supported attributes
 *          - 'current_language_override' - If current Language is overrided, old language should be passed.
 *          - 'language_anchor_class' - Add class for anchor variation.
 *
 * @return array{}|array{
 *     title: string,
 *     excerpt: string,
 *     document_types: string,
 *     languages: string[],
 *     download_link: string,
 *     post_date: string|int|false,
 * }
 */
function one_novanta_get_document_data( int $post_id = 0, $args = [] ): array {
	// Bail out if the document is empty or not numeric.
	if ( empty( $post_id ) ) {
		return [];
	}

	// Get current language.
	$current_language = \Novanta\Multilingual\get_current_language();

	if ( isset( $args['current_language_override'] ) ) {
		$current_language = $args['current_language_override'];
	}

	// Get post translations.
	$post_translations = \Novanta\Multilingual\get_post_translations( $post_id );

	// Get active document.
	$active_language_post_id = $post_id;

	if ( ! empty( $post_translations[ $current_language ] ) ) {
		$active_language_post_id = $post_translations[ $current_language ]['id'] ?? $active_language_post_id;
	}

	// Get the document post.
	$the_post = one_novanta_get_post( $active_language_post_id );

	// Check if the document is empty or not a WP_Post object.
	if ( ! $the_post['post'] instanceof WP_Post ) {
		return [];
	}

	// Get the post date.
	$date = get_the_date( '', $the_post['post']->ID );

	// Get all languages.
	$languages = \Novanta\Multilingual\get_languages();

	// Get download Types.
	$post_taxonomies                = $the_post['post_taxonomies'] ?? [];
	$download_types                 = $post_taxonomies['novanta_download_types'] ?? [];
	$download_types                 = wp_list_pluck( $download_types, 'name' );
	$current_language_download_link = '';

	// Collect documents.
	$document_languages = [];

	// Loop through the translated version.
	foreach ( $post_translations as $post_translation ) {
		$translated_post_id   = $post_translation['id'];
		$translation_language = $post_translation['language_code'];

		// Bail out if their we don't have translation.
		if ( empty( $translated_post_id ) || empty( $translation_language ) ) {
			continue;
		}

		// Get document link.
		$document_link = one_novanta_get_document_link( $translated_post_id );

		// Bail out if document link is empty.
		if ( empty( $document_link ) ) {
			continue;
		}

		// Set current language download link.
		if ( $current_language === $translation_language ) {
			$current_language_download_link = $document_link;
		}

		$add_anchor_class = '';

		if ( isset( $args['language_anchor_class'] ) ) {
			$add_anchor_class = 'class="' . $args['language_anchor_class'] . '"';
		}

		// Create document link.
		$document_languages[] = sprintf(
			'<a href="%s" target="_blank" %s>%s</a>',
			esc_url( $document_link ),
			$add_anchor_class,
			esc_html( $languages[ $translation_language ]['label'] ?? $translation_language )
		);
	}

	return [
		'title'          => $the_post['post']->post_title,
		'excerpt'        => $the_post['post']->post_excerpt,
		'download_link'  => $current_language_download_link,
		'post_date'      => $date,
		'document_types' => implode( ', ', $download_types ),
		'languages'      => $document_languages,
	];
}

/**
 * Get product data.
 *
 * @param int $post_id Post ID.
 *
 * @return array{}|array{
 *     product_id: int,
 *     image_id: int,
 *     url: string,
 *     category: string,
 *     product_tag: string,
 *     heading: string,
 *     content: string,
 *     sku: string,
 *     type: string
 * }
 */
function one_novanta_get_product_data( int $post_id = 0 ): array {
	// Bail out if the document is empty.
	if ( empty( $post_id ) ) {
		return [];
	}

	// Get post.
	$post = one_novanta_get_post( $post_id );

	// Check if the post is empty or not a WP_Post object.
	if ( ! $post['post'] instanceof WP_Post || ( 'product' !== $post['post']->post_type && 'product_variation' !== $post['post']->post_type ) ) {
		return [];
	}

	// Get Taxonomies.
	$taxonomies   = $post['post_taxonomies'] ?? [];
	$is_variation = 'product_variation' === $post['post']->post_type;

	// Get Product Category.
	$category           = '';
	$product_categories = $taxonomies['product_cat'] ?? [];

	// Add product category.
	if ( ! empty( $product_categories ) ) {
		// Get primary category.
		$primary_category_id = $post['post_meta']['_yoast_wpseo_primary_product_cat'] ?? 0;

		// Use primary category if existed.
		if ( ! empty( $primary_category_id ) ) {
			foreach ( $product_categories as $product_category ) {
				if ( $product_category['term_id'] === $primary_category_id ) {
					$category = $product_category['name'];
					break;
				}
			}
		} else {
			$category = $product_categories[0]['name'];
		}
	}

	// Add product tag.
	$product_tag  = '';
	$product_tags = $taxonomies['product_tag'] ?? [];

	if ( ! empty( $product_tags ) ) {
		$product_tag = $product_tags[0]['name'];
	}

	$product_gallery = $post['post_meta']['product_gallery'] ?? $post['post_meta']['_product_image_gallery'] ?? '';

	// Set product image.
	if ( ! empty( $product_gallery ) ) {
		if ( ! is_array( $product_gallery ) ) {
			$product_gallery = explode( ',', $product_gallery );
		}

		$product_image_id = $product_gallery[0]; // Set product's image id as initial gallery item.
	}

	if ( $is_variation && ! empty( $post['post_thumbnail'] ) ) {
		$product_image_id = $post['post_thumbnail']; // Set product's image id as thumbnail if it is a variation with thumbnail.
	}

	// Prepare product summary.
	$product_description = $post['post_meta']['summary'] ?? '';

	return [
		'product_id'  => $post['post']->ID,
		'image_id'    => $product_image_id ?? 0,
		'url'         => $post['permalink'],
		'category'    => $category,
		'product_tag' => $product_tag,
		'heading'     => $post['post']->post_title,
		'content'     => apply_filters( 'the_content', $product_description ),
		'sku'         => $post['post_meta']['_sku'] ?? __( 'N/A', 'one-novanta-theme' ),
		'type'        => $post['post']->post_type,
	];
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
function one_novanta_get_wrapper_attributes( array $extra_attributes = [], string $wrapper_attributes = '' ): string {

	// Return $wrapper_attributes if $extra_attributes are not specified.
	if ( empty( $extra_attributes ) ) {
		return $wrapper_attributes;
	}

	/**
	 * Explode default wrapper attributes.
	 *
	 * @example For button block wrapper_attributes be 'class="button-block wp-block-one-novanta-button-block" content="Hello World"'.
	 *          Current command will convert it to [ 'class="button-block wp-block-one-novanta-button-block"', 'content="Hello World"' ].
	 */
	$attributes = explode( '" ', trim( $wrapper_attributes ) );

	$normalized_attributes = [];
	$finalized_attributes  = [];

	/**
	 * Loop through an exploded wrapper attributes array i.e., $attributes and normalize them.
	 *
	 * @example [ 'class="button-block wp-block-one-novanta-button-block"', 'content="Hello World"' ] will be converted to
	 *          [ 'class' => [ 'button-block', 'wp-block-one-novanta-button-block' ], 'content' => [ 'Hello World' ] ]
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
	 *              'class' => [ 'button-block', 'wp-block-one-novanta-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
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
	 *              'class' => [ 'button-block', 'wp-block-one-novanta-button-block', 'class-1', 'class-2' ], // class-1 & class-2 are appended to the class array.
	 *               'Content' => [ 'Hello World' ],
	 *          ]
	 *          will be converted to [ 'class="button-block wp-block-one-novanta-button-block class-1 class-2"', 'content="Hello World"' ]
	 */
	foreach ( $normalized_attributes as $attribute_key => $attribute_value ) {
		$finalized_attributes[] = $attribute_key . '="' . esc_attr( implode( ' ', $attribute_value ) ) . '"';
	}

	// Join the finalized array and return as a string.
	return implode( ' ', $finalized_attributes );
}

/**
 * Utility function to merge class names.
 *
 * @param  mixed ...$args Any number of arguments to combine.
 *
 * @return string Combined class names.
 *
 * @example one_novanta_merge_classes('class1', 'class2', 'class3') => 'class1 class2 class3'
 * @example one_novanta_merge_classes('class1', [ 'class2' => true, 'class3' => false ]) => 'class1 class2'
 * @example one_novanta_merge_classes([ 'class1', 'class2' ], [ 'class3' => true, 'class4' => false ]) => 'class1 class2 class3'
 */
function one_novanta_merge_classes( ...$args ): string {
	$classes = [];

	foreach ( $args as $arg ) {
		if ( is_string( $arg ) ) {
			$classes[] = $arg;
		} elseif ( is_array( $arg ) ) {
			foreach ( $arg as $key => $value ) {
				if ( is_int( $key ) ) {
					// If numeric key, treat value as a class name.
					if ( $value ) {
						$classes[] = $value;
					}
				} elseif ( $value ) {
					// If string key, include it when the value is truthy.
					$classes[] = $key;
				}
			}
		}
	}

	// Filter out empty classes.
	$classes = array_filter( $classes );

	return implode( ' ', $classes );
}

/**
 * Extended wp_kses_post method.
 *
 * Extends wp_kses_post() by adding support for the following:
 * - SVG
 * - Accordion web component
 * - carousel web components
 *
 * Extends wp_kses_post() by removing support for the following:
 * // Add a list of removed support here.
 *
 * @param string $data Content to escape.
 *
 * @return string Escaped content.
 */
function one_novanta_kses_post( string $data ): string {

	// Fetch default allowed HTML tags.
	$kses_defaults = wp_kses_allowed_html( 'post' );

	// Allow use of SVGs.
	$svg_args = [
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
		'one-novanta-theme-locale-switcher'         => [
			'class' => true,
		],
		'one-novanta-sort-dropdown'                 => [
			'class' => true,
		],
		'one-novanta-toggle-search-filter-button'   => [
			'class'         => true,
			'expand-text'   => true,
			'collapse-text' => true,
		],
		'one-novanta-toggle-minimize-filter-button' => [
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

	$carousel_web_components_args = [
		'rt-slider'        => [
			'behavior' => true,
			'class'    => true,
			'total'    => true,
		],
		'rt-slider-track'  => [
			'class' => true,
		],
		'rt-slider-slides' => [
			'class' => true,
		],
		'rt-slider-slide'  => [
			'class' => true,
		],
		'rt-slider-arrow'  => [
			'direction' => true,
			'class'     => true,
		],
	];

	$tabs_web_components_args = array(
		'rt-tabs'          => [
			'class'            => true,
			'current-tab'      => true,
			'role'             => true,
			'aria-orientation' => true,
		],
		'rt-tabs-nav'      => [
			'class' => true,
		],
		'rt-tabs-nav-item' => [
			'class'         => true,
			'role'          => true,
			'tabindex'      => true,
			'aria-selected' => true,
			'active'        => true,
		],
		'rt-tabs-tab'      => [
			'id'     => true,
			'role'   => true,
			'hidden' => true,
			'open'   => true,
		],
	);

	$lightbox_web_components_args = [
		'rt-lightbox'          => [
			'id'                     => true,
			'class'                  => true,
			'close-on-overlay-click' => true,
			'swipe'                  => true,
			'swipe-threshold'        => true,
		],
		'rt-lightbox-close'    => [
			'class' => true,
		],
		'rt-lightbox-previous' => [
			'class' => true,
		],
		'rt-lightbox-next'     => [
			'class' => true,
		],
		'rt-lightbox-content'  => [
			'class' => true,
		],
		'rt-lightbox-count'    => [
			'class'  => true,
			'format' => true,
		],
		'rt-lightbox-trigger'  => [
			'lightbox' => true,
			'group'    => true,
			'class'    => true,
			'id'       => true,
		],
		'ati-media-lightbox'   => [
			'class' => true,
			'id'    => true,
		],
		'template'             => [
			'class' => true,
			'id'    => true,
		],
		'dialog'               => [
			'class' => true,
			'id'    => true,
		],
	];

	$product_details_elements = [
		'ati-product-gallery'     => [
			'id'    => true,
			'class' => true,
		],
		'novanta-product-tooltip' => [
			'id'    => true,
			'class' => true,
		],
	];

	$custom_tags = [
		'ati-add-to-cart-button' => [
			'data-product-id'  => true,
			'data-text'        => true,
			'data-added-text'  => true,
			'data-failed-text' => true,
			'id'               => true,
		],
	];

	$novanta_elements = [
		'novanta-video'  => [
			'url'       => true,
			'id'        => true,
			'class'     => true,
			'thumbnail' => true,
		],
		'wistia-player'  => [
			'id'        => true,
			'class'     => true,
			'media-id'  => true,
			'unique-id' => true,
		],
		'novanta-search' => [
			'id'     => true,
			'class'  => true,
			'expand' => true,
		],
	];

	$image_args = [
		'img' => [
			'width'         => true,
			'height'        => true,
			'class'         => true,
			'id'            => true,
			'src'           => true,
			'alt'           => true,
			'loading'       => true,
			'decoding'      => true,
			'fetchpriority' => true,
			'crossorigin'   => true,
			'srcset'        => true,
			'sizes'         => true,
			'style'         => true,
		],
	];

	// Updated allowed HTML tags array.
	$allowed_tags = array_merge( $kses_defaults, $svg_args, $carousel_web_components_args, $accordion_web_component_args, $tabs_web_components_args, $lightbox_web_components_args, $product_details_elements, $custom_tags, $novanta_elements, $image_args );

	// Allow tabindex on specific elements.
	if ( isset( $allowed_tags['div'] ) && is_array( $allowed_tags['div'] ) ) {
		$allowed_tags['div']['tabindex'] = true;
	}
	if ( isset( $allowed_tags['a'] ) && is_array( $allowed_tags['a'] ) ) {
		$allowed_tags['a']['tabindex'] = true;
	}

	// Return escaped content.
	return wp_kses( $data, $allowed_tags );
}

/**
 * Displays text escaped by one_novanta_kses_post method.
 *
 * @param string $data Content to escape.
 *
 * @return void
 */
function one_novanta_kses_post_e( string $data ): void {
	echo one_novanta_kses_post( $data );
}

/**
 * Get available terms.
 *
 * @param array<string, mixed> $args Query args.
 *
 * @return array<string, int[]> Available attributes.
 */
function one_novanta_get_available_terms( array $args = [] ): array {
	// Fixed query args.
	$fixed_args = [
		'posts_per_page' => 300, // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
		'post_status'    => 'publish',
	];

	// Merge fixed args with passed args.
	$args = array_merge( $args, $fixed_args );

	// Get the posts.
	$product_ids = one_novanta_get_posts( $args );

	// Initialize available attributes.
	$available_attributes = [];

	// Loop through the product IDs.
	foreach ( $product_ids as $product_id ) {
		// Get the product.
		$the_product = one_novanta_get_post( $product_id );

		// Check if the product is a WP_Post object.
		if ( ! $the_product['post'] instanceof WP_Post ) {
			continue;
		}

		// Get taxonomies.
		$post_taxonomies = $the_product['post_taxonomies'] ?? [];

		// Check if taxonomies are empty.
		if ( empty( $post_taxonomies ) ) {
			continue;
		}

		foreach ( $post_taxonomies as $slug => $taxonomy_terms ) {
			if ( empty( $taxonomy_terms ) ) {
				continue;
			}

			$term_ids = array_values( wp_list_pluck( $taxonomy_terms, 'term_id' ) );
			$term_ids = array_map( 'absint', $term_ids );
			$term_ids = array_filter( $term_ids );
			$term_ids = array_unique( $term_ids );

			$available_attributes[ $slug ] = $term_ids;
		}
	}

	return $available_attributes;
}

/**
 * Retrieves taxonomies that are supported for filtering by post type.
 *
 * @param string $post_type The post type slug.
 *
 * @return array<string, WP_Taxonomy> Array of taxonomies supported for filtering.
 */
function one_novanta_get_taxonomies_for_filter( string $post_type = '' ): array {
	// Bail out if post type is empty.
	if ( empty( $post_type ) ) {
		return [];
	}

	// List of excluded taxonomies from filtering.
	$filter_excluded_taxonomies = [
		'product_visibility',
		'product_type',
		'translation_priority',
		'product_shipping_class',
	];

	// Get all taxonomies linked to the post type.
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	if ( empty( $taxonomies ) ) {
		return [];
	}

	// Filter out taxonomies that are not supported for filtering.
	$taxonomy_list = [];

	foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
		// Skip excluded taxonomies.
		if ( in_array( $taxonomy_slug, $filter_excluded_taxonomies, true ) ) {
			continue;
		}

		// Add taxonomy to the list.
		$taxonomy_list[ $taxonomy_slug ] = $taxonomy;
	}

	return $taxonomy_list;
}

/**
 * Organizes terms into a hierarchical structure for term filter options.
 *
 * @param WP_Term[] $terms     Array of WP_Term objects to organize.
 * @param int       $parent_id Parent term ID to start organizing from.
 *
 * @return array{}|array{
 *     array{
 *         value: int,
 *         label: string,
 *         children: array{}|array<string, mixed>
 *     }
 * }
 */
function one_novanta_organize_term_filter_option_hierarchy( array $terms = [], int $parent_id = 0 ): array {
	// Bail out if terms are empty.
	if ( empty( $terms ) ) {
		return [];
	}

	// Initialize an empty array to hold organized terms.
	$organized_terms = [];

	// Get grand parent terms.
	$child_terms = array_filter(
		$terms,
		function ( $term ) use ( $parent_id ) {
			return $term instanceof WP_Term && absint( $term->parent ) === absint( $parent_id ); // @phpstan-ignore-line
		}
	);

	// Bail out if child terms are empty.
	if ( empty( $child_terms ) ) {
		return [];
	}

	foreach ( $child_terms as $child_term ) {
		$organized_terms[] = [
			'value'    => $child_term->term_id,
			'label'    => $child_term->name,
			'children' => one_novanta_organize_term_filter_option_hierarchy( $terms, $child_term->term_id ),
		];
	}

	return $organized_terms;
}

/**
 * Extract the Wistia media ID from a Wistia video URL.
 *
 * @param  string $video_url The Wistia video URL.
 * @return string The extracted Wistia media ID, or an empty string if not found.
 */
function one_novanta_extract_wistia_media_id( $video_url ) {
	// Ensure input is a non-empty string.
	if ( ! is_string( $video_url ) || trim( $video_url ) === '' ) {
		return '';
	}

	// Pattern 1: Standard Wistia embed URLs.
	// Example: https://fast.wistia.net/embed/iframe/e4a27b971d.
	if ( preg_match( '#/embed/(?:iframe|medias)/([a-zA-Z0-9]+)#', $video_url, $matches ) ) {
		return $matches[1];
	}

	// Pattern 2: URLs with 'mediaId' or 'wvideo' query parameters.
	// Example: https://example.com/page?wvideo=e4a27b971d or ...&mediaId=VIDEO_ID.
	if ( preg_match( '/[?&](?:mediaId|wvideo)=([a-zA-Z0-9]+)/', $video_url, $matches ) ) {
		return $matches[1];
	}

	// Pattern 3: Canonical Wistia media URLs on Wistia domains.
	// Example: https://myaccount.wistia.com/medias/e4a27b971d.
	if ( preg_match( '#/medias/([a-zA-Z0-9]+)#', $video_url, $matches ) ) {
		return $matches[1];
	}

	// Pattern 4: URLs with 'media' ID in the URL fragment.
	// Example: https://myaccount.wistia.com/projects/project_id#media=e4a27b971d.
	if ( preg_match( '/#media=([a-zA-Z0-9]+)/', $video_url, $matches ) ) {
		return $matches[1];
	}

	// Pattern 5: Fallback for URLs where the ID is the last path segment (with optional trailing slash).
	// This is more general and should come after more specific Wistia patterns.
	// Example: https://custom.domain.com/path/to/e4a27b971d.
	if ( preg_match( '#/([a-zA-Z0-9]+)/?$#', $video_url, $matches ) ) {
		return $matches[1];
	}

	// If no pattern matches, return empty string.
	return '';
}

/**
 * Extracts up to two taxonomy term names from a given post array.
 *
 * This function processes the 'post_taxonomies' to collect
 * term names from various taxonomies, excluding the 'translation_priority' taxonomy.
 * It stops after collecting two term names.
 * Note:- Array representing a post, returned by `one_novanta_get_post`.
 *
 * @param array<string,mixed> $curr_post Post returned by one_novanta_get_post.
 *
 * @return string[] Array of up to two term names.
 */
function one_novanta_extract_post_taxonomies( $curr_post ) {
	// Store all collected term names.
	$all_terms = [];

	// Return empty if taxonomies are missing or invalid.
	if ( empty( $curr_post['post_taxonomies'] ) || ! is_array( $curr_post['post_taxonomies'] ) ) {
		return $all_terms;
	}

	foreach ( $curr_post['post_taxonomies'] as $taxonomy_slug => $taxonomy_terms ) {

		// Skip specific taxonomy.
		if ( 'translation_priority' === $taxonomy_slug ) {
			continue;
		}

		foreach ( $taxonomy_terms as $unit_term ) {
			$all_terms[] = $unit_term['name'];

			// Stop after collecting two terms.
			if ( count( $all_terms ) === 2 ) {
				break 2;
			}
		}
	}

	return $all_terms;
}

/**
 * Fetches the latest articles based on the provided arguments and returns a template string.
 * Supported block templates are `tiles` and `article-collection`.
 *
 * @param array<string, mixed> $args Arguments for WP_Query.
 * @param string               $block_template Template for the latest articles.
 *
 * @return array<string, mixed>|null False if no results are found; otherwise, an array containing content, count, and totalResults.
 */
function one_novanta_fetch_latest_articles( $args, $block_template ): array|null {

	// Get the heading-level.
	$heading_level = $args['heading_level'] ?? 'h3';
	unset( $args['heading_level'] );

	$post_ids    = one_novanta_get_posts( $args );
	$posts_count = one_novanta_get_posts_count( $args );

	$response_content = '';

	if ( empty( $post_ids ) ) {
		return null;
	}

	foreach ( $post_ids as $the_post_id ) {

		$post_data = one_novanta_get_post( $the_post_id );

		$curr_post = $post_data['post'] ?? null;

		// Return early if post not found.
		if ( ! $curr_post instanceof WP_Post ) {
			continue;
		}

		$category        = '';
		$permalink       = $post_data['permalink'] ?? '';
		$image_id        = $post_data['post_thumbnail'] ?? 0;
		$post_meta       = $post_data['post_meta'] ?? [];
		$post_taxonomies = $post_data['post_taxonomies'] ?? [];

		// Get the post date.
		$post_date = get_the_date( '', $curr_post->ID );

		if ( 'tiles' === $block_template ) {

			$reading_time = $post_meta['_yoast_wpseo_estimated-reading-time-minutes'] ?? '';

			$description = $post_date;

			if ( $reading_time ) {
				$description .= ' · ' . sprintf(
				/* translators: %s: The estimated reading time in minutes. */
					__( '%s min read', 'one-novanta-theme' ),
					$reading_time
				);
			}

			$response_content .= Template::get_component(
				'tile',
				null,
				[
					'image_id'        => $image_id,
					'heading'         => $curr_post->post_title,
					'url'             => $permalink,
					'has_description' => true,
					'description'     => $description,
					'heading_level'   => $heading_level,
				],
			);

		} elseif ( 'article-collection' === $block_template ) {
			$category_id = isset( $args['cat'] ) ? intval( $args['cat'] ) : 0; // Get the category ID from the arguments.

			// If custom category prioritized.
			if ( $category_id > 0 ) {
				$category_obj = get_category( $category_id );
				$category     = $category_obj instanceof WP_Term ? $category_obj->name : '';
			} else {
				$category = $post_taxonomies['category'][0]['name'] ?? '';
			}

			$response_content .= Template::get_component(
				'cards',
				'article-collection',
				[
					'image_id'      => $image_id,
					'heading'       => $curr_post->post_title,
					'url'           => $permalink,
					'category'      => $category,
					'content'       => $curr_post->post_excerpt,
					'heading_level' => $heading_level,
				],
			);
		}
	}

	return [
		'content'      => $response_content,
		'count'        => count( $post_ids ),
		'totalResults' => $posts_count,
	];
}

/**
 * Retrieves the filtered block types from the shared PHP config file.
 *
 * Loads the array of allowed block types from
 * the 'filter-blocks.php' file located inside the theme's inc/helpers directory.
 *
 * @return array<string,array<string>> The array of block types.
 */
function one_novanta_get_filtered_blocks(): array {
	$file_path = get_template_directory() . '/inc/helpers/filter-blocks.php';

	if ( ! file_exists( $file_path ) ) {
		return [];
	}

	$block_map = include $file_path;
	return $block_map;
}

/**
 * Retrieves and prepares product or other post-type card data for display.
 *
 * @param int $the_post_id The ID of the post or product to retrieve.
 *
 * @return array{}|array{
 *     10?: int,
 *     product_id?: int,
 *     image_id: int,
 *     heading: string,
 *     url: string,
 *     category: string,
 *     product_tag?: string,
 *     content?: string,
 *     sku?: string,
 * }
 */
function one_novanta_get_post_card_data( int $the_post_id = 0 ): array {

	if ( empty( $the_post_id ) ) {
		return [];
	}

	// Get the product data.
	$post_data = one_novanta_get_post( $the_post_id );

	if ( ! $post_data['post'] instanceof WP_Post ) {
		return [];
	}

	$the_post = $post_data['post'];

	if ( 'product' === $the_post->post_type ) {

		$card_data = one_novanta_get_product_data( $the_post_id );

		if ( empty( $card_data ) ) {
			return [];
		}

		$card_data['content'] = apply_filters( 'the_content', $card_data['content'] );

		return $card_data;
	}

	$permalink = $post_data['permalink'] ?? '';
	$image_id  = $post_data['post_thumbnail'] ?? 0;
	$all_terms = one_novanta_extract_post_taxonomies( $post_data );

	// Use implode to create a comma-separated string of up to 2 term names.
	$category_string = implode( ', ', $all_terms );

	// Prepare attributes.
	$card_data = [
		'post_id'  => $the_post->ID,
		'image_id' => $image_id,
		'url'      => $permalink,
		'category' => $category_string,
		'heading'  => $the_post->post_title,
	];

	// Prepare content.
	$raw_excerpt = $the_post->post_excerpt;

	// Only add content if excerpt is available.
	if ( ! empty( $raw_excerpt ) ) {
		$trimmed_excerpt      = wp_html_excerpt( $raw_excerpt, 100, '' );
		$card_data['content'] = $trimmed_excerpt . __( '...[Read More]', 'one-novanta-theme' );
	}

	return $card_data;
}

/**
 * Retrieves and formats a paginated list of Novanta documents.
 *
 * This function queries documents based on filters such as page number,
 * language, document type, and search keywords. It also handles WPML language
 * switching to ensure documents are loaded in the correct language context.
 *
 * @param array<string, mixed> $param_args Array of arguments to filter documents.
 *
 * @return array{
 *     content: string,
 *     count: int,
 *     total_posts: int,
 * }
 */
function one_novanta_get_documents( $param_args ): array {
	// Get all the languages.
	$wpml_languages = get_languages();
	$all_languages  = array_column( $wpml_languages, 'language_code', 'label', );

	$language       = strval( $param_args['language'] );
	$document_type  = strval( $param_args['document_type'] );
	$search_keyword = $param_args['search_keyword'];
	$page           = max( 1, absint( $param_args['page'] ) );
	$per_page       = ( absint( $param_args['per_page'] ) > 0 ) ? absint( $param_args['per_page'] ) : 10;

	global $sitepress;
	$args = [
		'post_type'      => 'novanta_document',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
	];

	// If search_keyword is provided, add it to the query.
	if ( ! empty( $search_keyword ) ) {
		$args['s'] = $search_keyword;
	}

	// If document_type is provided, add it to the query.
	if ( ! empty( $document_type ) ) {
		$args['tax_query'][] = [
			'taxonomy' => 'novanta_download_types',
			'field'    => 'slug',
			'terms'    => $document_type,
		];
	}

	// Get the current language of the site, to restore it later.
	$original_language = function_exists( 'get_current_language' )
	? get_current_language()
	: apply_filters( 'wpml_current_language', null );

	if ( ! empty( $language ) ) {
		// Get a list of languages, map their native name to their code.
		$target_language_code = $all_languages[ $language ] ?? $original_language;

		// Switch WPML's context to the target language.
		$sitepress->switch_lang( $target_language_code );

		$args['one_novanta_cache_language'] = $target_language_code;
	} elseif ( 'en' !== $original_language ) {
		/**
		 * If not filtered by language, we need to set the default language to English.
		 * This will load English posts. Then, if posts in the current language are present, we will show the translated text..
		 */
		$args['one_novanta_cache_language'] = 'en';

		$sitepress->switch_lang( 'en' );
	}

	$document_ids = one_novanta_get_posts( $args );
	$markup       = '';

	$download_icon = Template::get_component(
		'svg',
		null,
		[
			'name' => 'download',
		]
	);

	if ( false === $download_icon ) {
		$download_icon = '';
	}

	if ( empty( $document_ids ) ) {
		// Restore the original language.
		$sitepress->switch_lang( $original_language );

		return [
			'count'       => 0,
			'total_posts' => 0,
			'content'     => $markup,
		];
	}

	// Get total number of posts for pagination.
	$total_posts = one_novanta_get_posts_count( $args );

	foreach ( $document_ids as $document_id ) {
		$document_data = one_novanta_get_document_data(
			$document_id,
			[
				'current_language_override' => $original_language,
				'language_anchor_class'     => 'wp-one-novanta__link--variation-two',
			]
		);

		if ( empty( $document_data ) ) {
			continue;
		}

		// Show title and post date in row.
		$file_name_row_data = [
			'title'     => $document_data['title'],
			'post_date' => $document_data['post_date'],
		];

		$row = [
			wp_json_encode( $file_name_row_data ),
			$document_data['document_types'],
			implode( '<br>', $document_data['languages'] ),
			sprintf(
				'<a href="%s" target="_blank" aria-label="%s">%s</a>',
				esc_url( $document_data['download_link'] ),
				esc_attr( $document_data['title'] ),
				one_novanta_kses_post( $download_icon ),
			),
		];

		// Generate HTML markup for each row using the template.
		$markup .= Template::get_component(
			'table',
			'row',
			[
				'row' => $row,
			]
		);
	}

	$current_language = get_current_language();

	if ( $original_language !== $current_language ) {
		// Restore the original language.
		$sitepress->switch_lang( $original_language );
	}

	return [
		'content'     => $markup,
		'count'       => count( $document_ids ),
		'total_posts' => $total_posts,
	];
}

/**
 * Gets the focal point coordinates for an image.
 *
 * @param int $image_id The attachment ID.
 * @return array<string, float> Focal point coordinates {x, y} or null.
 */
function get_focal_point( $image_id ) {
	// Get stored focal point for this image (the original/main focal point).
	$focal_point = get_post_meta( $image_id, 'focal_point', true );

	// If no focal point is set or it's invalid, return center point.
	if ( empty( $focal_point ) || ! isset( $focal_point['x'] ) || ! isset( $focal_point['y'] ) ) {
		return array(
			'x' => 0.5,
			'y' => 0.5,
		);
	}

	return $focal_point;
}
