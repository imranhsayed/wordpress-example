<?php
/**
 * PHP file to render the block on server to show on the front end.
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content    The block content.
 * @var WP_Block     $block      The block instance.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Get the button block attributes.
$unique_class       = wp_unique_id( 'latest-articles-' );
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => $unique_class ] );

$category_id    = ! empty( $attributes['categoryId'] ) ? $attributes['categoryId'] : 0;
$order_by       = $attributes['orderBy'] ?? 'date';
$post_order     = $attributes['order'] ?? 'desc';
$block_template = $attributes['template'] ?? 'tiles';
$heading_level  = $attributes['headingLevel'] ?? 'h3';
$limit          = isset( $attributes['numberOfItems'] ) ? (int) $attributes['numberOfItems'] : 4;
$column_count   = 'tiles' === $block_template ? 3 : 2;

$args = [
	'post_type'     => 'post',
	'post_status'   => 'publish',
	'orderby'       => $order_by,
	'order'         => $post_order,
	'heading_level' => $heading_level,
];

if ( 0 !== $category_id ) {
	$args['cat'] = $category_id;
}

// If the block is used on an archive page, assumes that we are showing the latest articles for that archive.
if ( is_archive() ) {
	global $wp_query;

	$query = $wp_query;
	$args  = wp_parse_args( $query->query_vars, $args );

	if ( ! $query->have_posts() ) {
		return '';
	}
}

$latest_articles = [];

$args['posts_per_page'] = $limit; // Set posts per page limit.

if ( function_exists( 'one_novanta_fetch_latest_articles' ) ) {
	$latest_articles = one_novanta_fetch_latest_articles( $args, $block_template );
}

// Storing page number for load more functionality.
$page_number = ! empty( $args['paged'] ) ? intval( $args['paged'] ) + 1 : 2;
unset( $args['paged'] ); // Remove paged to avoid pagination issues.

if ( empty( $latest_articles ) ) {
	return;
}

$card_components  = $latest_articles['content'];
$total_post_count = $latest_articles['totalResults'];

?>
<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<?php
	Template::render_component(
		'grid',
		null,
		[
			'column_count' => $column_count,
			'content'      => $card_components,
		],
	);

	// Only show load-more if total posts is greater than the post per page.
	if ( $total_post_count > $limit ) {

		// Remove this key from API before sending thet Query.
		$args['block_template'] = $block_template;

		Template::render_component(
			'load-more',
			null,
			[
				'page'                => $page_number,
				'target'              => ".$unique_class .grid",
				'numberOfPostsToLoad' => $limit,
				'source'              => rest_url( '/one-novanta/v1/latest-articles' ),
				'query'               => $args,
				'nonce'               => wp_create_nonce( 'wp_rest' ),
				'found_posts'         => $total_post_count,
			]
		);
	}
	?>
</div>
