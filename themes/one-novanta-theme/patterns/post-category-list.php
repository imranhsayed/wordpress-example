<?php
/**
 * Post Category List
 *
 * Title: Post Category List
 * Slug: one-novanta-theme/post-category-list
 * Description: Lists posts on post category archive.
 * Categories:
 * Keywords: post category archive, post category list, post category
 * Viewport Width: 1280
 * Block Types:
 * Post Types:
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

$category = get_queried_object(); // WP_Term object.

if ( ! $category instanceof \WP_Term ) {
	return;
}

$category_id = $category->term_id;
?>

<!-- wp:one-novanta/section {"showTitle":false,"showDescription":false,"template":"latest-articles-tiles"} -->
<div
	class="alignfull"
	style="
			padding-top: var(--wp--preset--spacing--80);
			padding-bottom: var(--wp--preset--spacing--80);
		"
>
	<!-- wp:one-novanta/section-content {"templateLock":"all"} -->
	<div class="wp-block-one-novanta-section-content alignwide">
		<!-- wp:one-novanta/latest-articles {"order":"desc","orderBy":"date","numberOfItems":6,"categoryId":"<?php echo esc_attr( (string) $category_id ); ?>","headingLevel":"h2"} /-->
	</div>
	<!-- /wp:one-novanta/section-content -->
</div>
<!-- /wp:one-novanta/section -->
