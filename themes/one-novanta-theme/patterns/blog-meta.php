<?php
/**
 * Pattern Blog Meta
 *
 * Title: Blog Meta
 * Slug: one-novanta-theme/blog-meta
 * Description: Blog meta widget.
 * Categories: one-novanta-theme
 * Keywords: meta
 * Inserter: true
 *
 * @package OneNovantaTheme\Patterns
 */

?>

<!-- wp:group {"metadata":{"patternName":"one-novanta-theme/blog-meta","name":"Blog Meta","categories":["one-novanta-theme"]},"className":"blog-meta","style":{"border":{"radius":"10px"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"backgroundColor":"quaternary","fontSize":"small","layout":{"type":"constrained"}} -->
<div class="wp-block-group blog-meta has-quaternary-background-color has-background has-small-font-size" style="border-radius:10px;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"}}} -->
		<p style="letter-spacing:0.08em;text-transform:uppercase"><strong>Published</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-date {"style":{"spacing":{"margin":{"top":"var:preset|spacing|10"}}}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"}}} -->
		<p style="letter-spacing:0.08em;text-transform:uppercase"><strong>Reading time</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|10"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-foreground-color has-text-color has-link-color" style="margin-top:var(--wp--preset--spacing--10)">
			<!-- wp:yoast-seo/estimated-reading-time {"showDescriptiveText":false,"showIcon":false} -->
			<p class="yoast-reading-time__wrapper">
				<span class="yoast-reading-time__reading-time">0</span>
				<span class="yoast-reading-time__time-unit"> minutes</span>
			</p>
			<!-- /wp:yoast-seo/estimated-reading-time -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"}}} -->
		<p style="letter-spacing:0.08em;text-transform:uppercase"><strong>Category</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-terms {"term":"category","style":{"spacing":{"margin":{"top":"var:preset|spacing|10"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"textDecoration":"none"}}} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
