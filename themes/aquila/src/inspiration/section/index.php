<?php
/**
 * Block: Section.
 *
 * @package leboat
 */

namespace LeBoat\Theme\Blocks\Section;

const BLOCK_NAME = 'leboat/section';
const COMPONENT  = 'section';

/**
 * Bootstrap this block.
 *
 * @return void
 */
function bootstrap(): void {
	// Register the block.
	register_block_type_from_metadata(
		__DIR__,
		[
			'render_callback' => __NAMESPACE__ . '\\render',
		]
	);

	// Translation.
	add_filter( 'lb_translation_block_attributes', __NAMESPACE__ . '\\block_attributes_to_translate' );
}

/**
 * Render this block.
 *
 * @param mixed[] $attributes The block attributes.
 * @param string  $content    The block default content.
 *
 * @return string
 */
function render( array $attributes = [], string $content = '' ): string {
	// Build component attributes.
	$component_attributes = [
		'id'               => $attributes['anchor'],
		'title'            => '',
		'title_align'      => $attributes['titleAlignment'],
		'background'       => $attributes['hasBackground'],
		'background_color' => $attributes['backgroundColor'],
		'padding'          => $attributes['hasPadding'],
		'narrow'           => $attributes['isNarrow'],
		'slot'             => '',
	];

	// Set title if it exists.
	if ( ( $attributes['hasTitle'] ?? true ) && ! empty( $attributes['title'] ) ) {
		$component_attributes['title'] = $attributes['title'];
	}

	// Set heading level if it exists.
	if ( ! empty( $attributes['headingLevel'] ) ) {
		$component_attributes['heading_level'] = $attributes['headingLevel'];
	}

	// Set heading style if it exists.
	if ( ! empty( $attributes['headingStyle'] ) ) {
		$component_attributes['heading_style'] = $attributes['headingStyle'];
	}

	// Check if the block has a description.
	if ( $attributes['hasDescription'] && ! empty( $attributes['description'] ) ) {
		$component_attributes['slot'] .= leboat_get_component(
			COMPONENT . '.description',
			[
				'slot' => $attributes['description'],
			]
		);
	}

	// Set CTA if it exists.
	if ( ( $attributes['hasCta'] ?? false ) && ! empty( $attributes['ctaButton'] ) ) {
		$component_attributes['cta_button'] = [
			'url'        => $attributes['ctaButton']['url'] ?? '',
			'text'       => $attributes['ctaButton']['text'] ?? '',
			'new_window' => $attributes['ctaButton']['newWindow'] ?? '',
			'class'      => '',
		];

		// If background is dark, then add dark context class.
		if (
			! empty( $attributes['hasBackground'] ) &&
			( ! empty( $attributes['backgroundColor'] ) && 'black' === $attributes['backgroundColor'] )
		) {
			$component_attributes['cta_button']['class'] = 'color-context--dark';
		}
	}

	// Add content to the slot.
	$component_attributes['slot'] .= $content;

	// Return rendered component.
	return leboat_get_component( COMPONENT, $component_attributes );
}

/**
 * Block attributes that need to be translatable.
 *
 * @param mixed[] $blocks_and_attributes Blocks and attributes.
 *
 * @return mixed[]
 */
function block_attributes_to_translate( array $blocks_and_attributes = [] ): array {
	// Add data to translate.
	$blocks_and_attributes[ BLOCK_NAME ] = [
		'text'   => [ 'title', 'description' ],
		'object' => [ 'ctaButton' => [ 'text' ] ],
	];

	// Return blocks and attributes.
	return $blocks_and_attributes;
}
