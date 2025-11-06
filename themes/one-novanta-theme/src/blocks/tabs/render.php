<?php
/**
 * Server-side rendering of the `one-novanta/tabs` block.
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

// If the block is not set or the content is not set or the attributes are not set, return.
if ( ! isset( $block ) || ! isset( $content ) || ! isset( $attributes ) ) {
	return;
}

if ( ! $block instanceof WP_Block
		|| ! $block->inner_blocks instanceof WP_Block_List
	) {
		return $content;
}

// Initialize tab index and tabs.
static $tab_index = 1;
$formatted_tabs   = [];
$active_tab_id    = 'tab-1';

// Loop through inner blocks.
while ( $block->inner_blocks->valid() ) {
	$inner_block = $block->inner_blocks->current();

	// If inner block is not a WP_Block instance or not a tab item block, skip it.
	if ( ! $inner_block instanceof WP_Block || 'one-novanta/tab-item' !== $inner_block->name ) {
		$block->inner_blocks->next();
		continue;
	}

	$tab_title = $inner_block->parsed_block['attrs']['title'] ?? '';

	// Set the tab id. Tab id is tab + sanitized tab title + tab index for uniqueness.
	$tab_id = sprintf(
		'tab-%s-%s',
		sanitize_title( $tab_title ),
		$tab_index
	);

	// If the inner block is the active tab, set the active tab id.
	if ( $attributes['defaultTabIndex'] === $block->inner_blocks->key() + 1 ) {
		$active_tab_id = $tab_id;
	}

	// Add tab to tabs.
	$formatted_tabs[] = [
		'id'      => $tab_id,
		'title'   => $inner_block->parsed_block['attrs']['title'] ?? '',
		'content' => implode(
			'',
			array_map(
				'render_block',
				$inner_block->parsed_block['innerBlocks']
			)
		),
	];

	// Increment tab index.
	++$tab_index;

	// Move to next inner block.
	$block->inner_blocks->next();
}

$args = array(
	'tabs'          => $formatted_tabs,
	'active_tab_id' => $active_tab_id,
);

Template::render_component( 'tabs', null, $args );
