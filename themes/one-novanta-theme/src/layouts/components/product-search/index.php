<?php
/**
 * Component Product Search
 *
 * @component Product Search
 * @description A reusable product-search component with content.
 * @group UI Elements
 * @props {
 *     "content": {"type": "string", "required": true, "description": "Content content"},
 *     "sidebar_content": {"type": "string", "required": false, "description": "Sidebar content"},
 *     "count": {"type": "int", "required": false, "description": "Sidebar content"},
 *     "filter_post_type": {"type": "string", "required": true, "description": "Post type to filter for"},
 *     "post_per_page": {"type": "int", "required": false, "description": "Number of posts per page"},
 *     "default_tax_query": {"type": "array", "required": false, "description": "Default taxonomy query array"},
 * }
 * @variations {}
 * @example render_component(
 *     'product-search',
 *     null,
 *     [
 *         'sidebar_content' => Template::get_component(
 *             'product-search',
 *             'filter-widget',
 *             [
 *                 'heading'      => 'Solid State Switch',
 *                 'filter_items' => [
 *                     [
 *                         'label' => 'Yes',
 *                         'value' => 'yes',
 *                     ],
 *                     [
 *                         'label' => 'No',
 *                         'value' => 'no',
 *                     ],
 *                 ],
 *             ]
 *         ),
 *         'content' => Template::get_component(
 *             'grid',
 *             null,
 *             [
 *                 'column_count' => 3,
 *                 'content'      =>
 *                     Template::get_component(
 *                         'cards',
 *                         'product',
 *                         [
 *                             'image_id' => 21,
 *                             'url'      => '#',
 *                             'category' => 'Product Category',
 *                             'heading'  => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
 *                             'content'  => '
 *                                 <h3>Axia Force/Torque Sensors ECAT-AXIA80-M50</h3>
 *                             ',
 *                         ]
 *                     ) .
 *                     Template::get_component(
 *                         'cards',
 *                         'product',
 *                         [
 *                             'image_id'    => 21,
 *                             'url'         => '#',
 *                             'category'    => 'Product Category',
 *                             'product_tag' => 'New',
 *                             'heading'     => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
 *                             'content'     => '
 *                                 <h3>Axia Force/Torque Sensors ECAT-AXIA80-M50</h3>
 *                             ',
 *                         ]
 *                     ),
 *             ]
 *         ),
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the Template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$unique_id             = wp_unique_id( 'product-search' );
$count                 = absint( $args['count'] ?? 0 );
$content               = $args['content'] ?? '';
$sidebar_content       = $args['sidebar_content'] ?? '';
$filter_post_type      = $args['post_type'] ?? 'post';
$heading_level         = $args['heading_level'] ?? 'h3';
$post_per_page         = $args['post_per_page'] ?? 10;
$default_tax_query     = $args['default_tax_query'] ?? [];
$wrapper_attributes    = $args['wrapper_attributes'] ?? '';
$rest_endpoint         = $args['rest_endpoint'] ?? rest_url( '/one-novanta/v1/load-product-posts' );
$additional_query_args = $args['additional_query_args'] ?? [];

$load_more_wrapper_classes = [ 'product-search__button-load-more-wrapper' ];

// Hide load-more, do not remove - The attributes maybe used.
if ( $count <= $post_per_page ) {
	$load_more_wrapper_classes[] = 'button-load-more-wrapper--hidden';
}

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

$load_more_query = [
	'heading_level' => $heading_level,
	'post_type'     => $filter_post_type,
];

if ( ! empty( $default_tax_query ) ) {
	$load_more_query['tax_query'] = $default_tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason we need to filter taxonomy based on the taxonomies.
}

if ( ! empty( $additional_query_args ) ) {
	$load_more_query = array_merge( $load_more_query, $additional_query_args );
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'product-search', $unique_id ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<one-novanta-product-search <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<div class="product-search__header">
		<?php if ( ! empty( $count ) ) { ?>
			<div class="product-search__results-count has-medium-font-size">
				<?php
					// Display the number of results found.
					printf(
						/* translators: %d: Number of results */
						esc_html( _n( '%d Result', '%d Results', $count, 'one-novanta-theme' ) ),
						absint( $count )
					);
				?>
			</div>
			<?php
		}
		// TODO: Add filter once functionality is finalized.
		?>
	</div>

	<div class="product-search__grid">
		<?php
		if ( ! empty( $sidebar_content ) ) :
			?>
		<div class="product-search__sidebar">
			<one-novanta-toggle-search-filter-button
				class="product-search__toggle-filters"
				expand-text="<?php echo esc_attr__( 'Show Filters', 'one-novanta-theme' ); ?>"
				collapse-text="<?php echo esc_attr__( 'Hide Filters', 'one-novanta-theme' ); ?>"
			>
				<button class="product-search__toggle-button" aria-controls="filters" aria-expanded="false">
					<?php echo esc_html__( 'Show Filters', 'one-novanta-theme' ); ?>
				</button>
			</one-novanta-toggle-search-filter-button>

			<div class="product-search__sidebar-inner">
				<?php one_novanta_kses_post_e( $sidebar_content ); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="product-search__content">
			<div class="product-search__is-loading hidden">
				<?php
				Template::render_component(
					'svg',
					null,
					[
						'name' => 'spinner',
					]
				);
				?>
			</div>
			<?php one_novanta_kses_post_e( $content ); ?>

			<?php
			// Render the button load more component.
			Template::render_component(
				'load-more',
				null,
				[
					'page'                => 2, // Page 1 is already loaded.
					'query'               => $load_more_query,
					'source'              => $rest_endpoint,
					'target'              => ".product-search.{$unique_id} .grid.alignwide.grid--cols-3",
					'numberOfPostsToLoad' => $post_per_page,
					'found_posts'         => $count,
					'nonce'               => wp_create_nonce( 'wp_rest' ),
					'wrapper_attributes'  => one_novanta_get_wrapper_attributes( [ 'class' => $load_more_wrapper_classes ] ),
				]
			);
			?>
		</div>
	</div>
</one-novanta-product-search>
