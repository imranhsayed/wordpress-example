<?php
/**
 * Pattern Sidebar Grid
 *
 * Title: Sidebar Grid
 * Slug: one-novanta-theme/sidebar-grid
 * Description: Sidebar Grid pattern.
 * Categories: Sidebar Grid
 * Keywords: Sidebar Grid
 * Viewport Width: 1280
 * Block Types:
 * Post Types: wp_template
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

?>

<!-- wp:group {"align":"wide","className":"sidebar-grid one-novanta-search-page-container","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide sidebar-grid one-novanta-search-page-container">
	<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"align":"wide","className":"sidebar-grid__content one-novanta-search-query-loop","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group alignwide sidebar-grid__content one-novanta-search-query-loop">
		<!-- wp:pattern {"slug":"one-novanta-theme/search-query-loop"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"sidebar-grid__sidebar","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group alignwide sidebar-grid__sidebar">
		<!-- wp:one-novanta/navigation-links {"heading":"Frequently viewed"} -->
			<!-- wp:one-novanta/navigation-links-item {"title":"Everest S Command Reference Manual","url":"#"} /-->
			<!-- wp:one-novanta/navigation-links-item {"title":"Another item remove/update","url":"#"} /-->
		<!-- /wp:one-novanta/navigation-links -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
