<?php
/**
 * OEmbeds
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme;

use OneNovanta\Traits\Singleton;
use OneNovanta\Controllers\Common\Template;

/**
 * Class OEmbeds
 *
 * @package OneNovanta\Theme
 */
class OEmbeds {
	use Singleton;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->add_providers();
		add_filter( 'render_block_core/embed', [ $this, 'render_wistia_embed_with_lightbox' ], 10, 2 );
	}

	/**
	 * Add OEmbed providers.
	 *
	 * @return void
	 */
	public function add_providers() {
		// Add oembed support for Wistia.
		wp_oembed_add_provider( '/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true );
	}

	/**
	 * Render Wistia embed with lightbox.
	 *
	 * @param  string               $block_content The block content.
	 * @param  array<string, mixed> $block         The block data.
	 * @return string|null
	 */
	public function render_wistia_embed_with_lightbox( string $block_content, array $block ): ?string {
		// Early return if not a Wistia embed block.
		if ( 'core/embed' !== $block['blockName'] || empty( $block['attrs']['url'] ) || 'wistia-inc' !== ( $block['attrs']['providerNameSlug'] ?? '' ) ) {
			return $block_content;
		}

		$caption = $this->extract_caption_with_dom( $block['innerContent'][0] ?? '' );

		$output = $this->render_video_component(
			[
				'video_url'      => $block['attrs']['url'],
				'cover_image_id' => $block['attrs']['posterImageId'] ?? '',
				'caption'        => $caption,
			]
		);

		return $output;
	}

	/**
	 * Extract caption using DOM parsing
	 *
	 * @param  string $inner_content The inner content to parse.
	 * @return string
	 */
	private function extract_caption_with_dom( string $inner_content ): string {
		// Return early if inner content is empty.
		if ( empty( $inner_content ) ) {
			return '';
		}

		$dom = new \DOMDocument();

		// Disable error reporting for HTML parsing.
		$use_errors = libxml_use_internal_errors( true );
		libxml_clear_errors();

		$loaded = $dom->loadHTML( $inner_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

		// Restore previous error reporting state.
		libxml_use_internal_errors( $use_errors );
		
		if ( ! $loaded ) {
			return '';
		}

		$figcaptions = $dom->getElementsByTagName( 'figcaption' );
		if ( 0 === $figcaptions->length ) {
			return '';
		}

		$caption_html = $dom->saveHTML( $figcaptions->item( 0 ) );
		if ( false === $caption_html ) {
			return '';
		}

		$result = preg_replace( '/<\/?figcaption[^>]*>/', '', $caption_html );
		return is_string( $result ) ? $result : '';
	}

	/**
	 * Render video component and return output.
	 *
	 * @param  array<string, mixed> $args Component arguments.
	 * @return string|null
	 */
	private function render_video_component( array $args ): ?string {
		ob_start();
		Template::render_component( 'video', null, $args );
		$output = ob_get_clean();

		return is_string( $output ) ? $output : null;
	}
}
