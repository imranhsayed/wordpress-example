<?php
/**
 * Block Extensions.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme;

use OneNovanta\Theme\BlockExtensions\Gallery;
use OneNovanta\Theme\BlockExtensions\Navigation;

use OneNovanta\Traits\Singleton;

/**
 * Class BlockExtensions
 *
 * @package OneNovanta\Theme
 */
class BlockExtensions {
	use Singleton;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->load_block_extensions();
	}

	/**
	 * Load block extensions.
	 *
	 * @return void
	 */
	public function load_block_extensions() {
		// Extension for logo plate block variation.
		Gallery::get_instance();

		// Extension for Navigation block.
		Navigation::get_instance();
	}
}
