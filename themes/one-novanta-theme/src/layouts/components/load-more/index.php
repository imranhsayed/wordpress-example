<?php
/**
 * Component Load More.
 *
 * @component Load More
 * @description A reusable load-more component.
 * @group UI Elements
 * @props {
 *   "numberOfPostsToLoad": {"type": "number", "required": true, "description": "The number of posts to fetch per request."},
 *   "source": {"type": "string", "required": true, "description": "The API endpoint from which to fetch posts."},
 *   "page": {"type": "number", "required": false, "description": "The current page number for pagination."},
 *   "query": {"type": "object", "required": false, "description": "Meta queries to filter the results based on specific criteria."},
 *   "target": {"type": "string", "required": true, "description": "A unique CSS selector (starting with '.' or '#') that identifies the container element where fetched posts will be appended. `wp_unique_id` Can be used to create a unique id."},
 *   "nonce": {"type": "string", "required": false, "description": "A nonce for security purposes."},
 *   "found_posts": {"type": "int", "required": true, "description": "Total number of posts."},
 * }
 * @default {
 *  "numberOfPostsToLoad": 10,
 *  "source": "",
 *  "page": 1,
 *  "query": [],
 *  "target": ""
 *  "nonce": ""
 * }
 * @example Template::render_component(
 *     'load-more',
 *     'null',
 *     [
 *         'page' => 1,
 *         'target' => '#post-list'
 *         'numberOfPostsToLoad' => 10,
 *         'source' => '/wp-json/wp/v2/posts',
 *         'query' => ['post_type' => 'post'],
 *         'nonce' => wp_create_nonce( 'wp_rest' ),
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Check if the arguments are missing, then return early.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Retrieve attributes from the arguments array, providing default values if not set.
$page_number        = $args['page'] ?? 1;
$query              = $args['query'] ?? [];
$source             = $args['source'] ?? '';
$target             = $args['target'] ?? '';
$nonce              = $args['nonce'] ?? '';
$number_of_posts    = $args['numberOfPostsToLoad'] ?? 10;
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$found_posts        = absint( $args['found_posts'] ?? 0 );

// Additional attributes for the wrapper.
$extra_attributes = [
	'class'                        => [
		one_novanta_merge_classes(
			[
				'button-load-more-wrapper',
				// If initially there are not enough posts, hide the load-more.
				'button-load-more-wrapper--hidden' => $number_of_posts >= $found_posts,
			]
		),
	],
	'data-page'                    => [ strval( $page_number ) ],
	'data-query'                   => [ strval( wp_json_encode( $query ) ) ],
	'data-source'                  => [ strval( $source ) ],
	'data-nonce'                   => [ strval( $nonce ) ],
	'data-target'                  => [ strval( $target ) ],
	'data-found-posts'             => [ strval( $found_posts ) ],
	'data-number-of-posts-to-load' => [ strval( $number_of_posts ) ],
];

// Get final wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<button class="button-load-more" aria-label="<?php echo esc_attr__( 'Load more results', 'one-novanta-theme' ); ?>" tabindex="0">
		<?php
			// SVG Component.
			Template::render_component(
				'svg',
				null,
				[ 'name' => 'load-more' ]
			);
			?>
			<span class="button-load-more-text"><?php echo esc_html__( 'Load more', 'one-novanta-theme' ); ?></span>
			<span  class="button-load-more-text--loading"><?php echo esc_html__( 'Loading...', 'one-novanta-theme' ); ?></span>
	</button>
</div>
