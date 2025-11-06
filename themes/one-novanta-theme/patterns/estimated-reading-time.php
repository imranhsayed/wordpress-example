<?php
/**
 * Estimated Reading Time for Single Posts
 *
 * Title: Estimated Reading Time for Single Posts
 * Slug: one-novanta-theme/estimated-reading-time
 * Description: Estimated Reading Time for Single Posts pattern.
 * Keywords: single, post, single post, estimated reading time, reading time
 * Viewport Width: 1280
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

?>

<!-- wp:group {"layout":{"type":"constrained"}, "className":"post-reading-time"} -->
<div class="wp-block-group post-reading-time">
	<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"}}} -->
	<p style="letter-spacing:0.08em;text-transform:uppercase"><strong><?php esc_html_e( 'Reading time', 'one-novanta-theme' ); ?></strong></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|10"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","layout":{"type":"constrained"}} -->
	<div class="wp-block-group has-foreground-color has-text-color has-link-color" style="margin-top:var(--wp--preset--spacing--10)">
		<!-- wp:one-novanta/estimated-reading-time /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
