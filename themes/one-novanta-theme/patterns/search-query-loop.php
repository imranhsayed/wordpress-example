<?php
/**
 * Pattern Search Query Loop
 *
 * Title: Search Query Loop
 * Slug: one-novanta-theme/search-query-loop
 * Description: Search results/query loop pattern.
 * Categories: Search results
 * Keywords: search, query, loop
 * Viewport Width: 1280
 * Block Types:
 * Post Types: wp_template
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

?>

<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"metadata":{"categories":["posts"],"patternName":"core/query-standard-posts","name":"Standard"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template -->
			<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"className":"alignfull","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}}} -->
			<div class="wp-block-group alignfull">
				<!-- wp:post-title {"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"lineHeight":"1.1"},"spacing":{"margin":{"bottom":"0"}}},"textColor":"foreground","fontSize":"medium"} /-->
				<!-- wp:post-excerpt {"moreText":"read more","showMoreOnNewLine":false,"style":{"color":{"text":"#555050"},"typography":{"lineHeight":"1.4"}}} /-->
				<!-- wp:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"top":"var:preset|spacing|10"}}},"textColor":"foreground"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- wp:query-no-results -->
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size has-text-align-left">
			<?php
				esc_html_e( 'Sorry, but nothing was found. Please try a search with different keywords.', 'one-novanta-theme' );
			?>
		</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

	<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide one-novanta-query-pagination-desktop">
		<!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"align":"wide","layout":{"type":"flex","justifyContent":"left"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers {"midSize":1} /-->
		<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide one-novanta-query-pagination-mobile">
		<!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"align":"wide","layout":{"type":"flex","justifyContent":"left"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers {"midSize":0} /-->
		<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->
	</div>
	<!-- /wp:group -->
<!-- /wp:query -->
