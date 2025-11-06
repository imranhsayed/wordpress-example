<?php
/**
 * Navigation block extension.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\BlockExtensions;

use OneNovanta\Traits\Singleton;

/**
 * Class Navigation
 *
 * @package OneNovanta\Theme\BlockExtensions
 */
class Navigation {
	use Singleton;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		add_filter( 'render_block_core/navigation', [ $this, 'filter_navigation_block' ], 10, 2 );
	}

	/**
	 * Add mobile menu button to navigation block.
	 *
	 * @param  string               $block_content The block content.
	 * @param array<string, mixed> $parsed_block The parsed block data.
	 * 
	 * @return string
	 */
	public function filter_navigation_block( string $block_content, array $parsed_block = [] ): string {
		// Check if the block is not in the header.
		if (
		empty( $parsed_block['attrs']['className'] ) ||
		'one-novanta-header__navigation' !== $parsed_block['attrs']['className']
		) {
			return $block_content;
		}
  
		// Set hamburger menu button markup.
		$hamburger_menu_button = '<button aria-label="Open menu" class="one-novanta-header__hamburger-menu">
			<span class="one-novanta-header__hamburger-menu-open">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 16">
					<rect width="24" height="1.895" x=".368" y=".105" fill="currentColor" rx=".947"/>
					<rect width="24" height="1.895" x=".368" y="7.053" fill="currentColor" rx=".947"/>
					<rect width="24" height="1.895" x=".368" y="14" fill="currentColor" rx=".947"/>
				</svg>
			</span>
			<span class="one-novanta-header__hamburger-menu-close">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 20">
					<rect width="24" height="1.895" x=".213" y="17.815" fill="currentColor" rx=".947" transform="rotate(-45 .213 17.815)"/>
					<rect width="24" height="1.895" x="1.553" y=".845" fill="currentColor" rx=".947" transform="rotate(45 1.553 .845)"/>
				</svg>
			</span>
		</button>';

		// Simple regex approach to insert as first child of nav element.
		preg_match( '/<nav\s[^>]*>/', $block_content, $matches );

		// Check for matches.
		if ( ! empty( $matches[0] ) ) {
			// Insert the button right after the opening nav tag.
			$block_content = str_replace(
				$matches[0],
				$matches[0] . $hamburger_menu_button,
				$block_content
			);
		}

		// Return the block content.
		return $block_content;
	}
}
