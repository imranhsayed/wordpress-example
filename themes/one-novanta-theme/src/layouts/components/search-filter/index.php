<?php
/**
 * Component Search Filter
 *
 * @component Search Filter
 * @description A flexible search-filter component.
 * @group UI Elements
 * @props {
 *   "heading": '',
 *   "list_items": {"type": "array", "required": true, "description": "List items"},
 * }
 * @variations {}
 * @example render_component(
 *     'search-filter',
 *     null,
 *     [
 *         'post_types'    => ['slug'=>'title'],
 *
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$post_types         = $args['post_types'] ?? [];
$wrapper_attributes = $args['wrapper_attributes'] ?? '';


// Extra attributes.
$extra_attributes = [
	'class' => [ 'search-filter' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
$search_query       = get_search_query();
$search_query       = preg_replace( '/\s+/', '+', esc_attr( $search_query ) );
$current_post_type  = get_query_var( 'post_type' );

$search_link_query = '?s=' . esc_attr( $search_query ); // @phpstan-ignore argument.type

?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<div class="left-blur" aria-hidden="true"></div>
	<ul class="search-filter__post-types">
		<li class="search-filter__post-type">
			<a href="<?php echo esc_url( home_url( $search_link_query ) ); ?>" class="search-filter__post-type-link wp-one-novanta-button <?php echo empty( $current_post_type ) || 'any' === $current_post_type ? 'wp-one-novanta-button--primary' : 'wp-one-novanta-button--secondary'; ?>">
				<?php esc_html_e( 'All', 'one-novanta-theme' ); ?>
			</a>
		</li>

		<?php
		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $selected_post_type ) {
				$active            = false;
				$active            = isset( $current_post_type ) && ( $current_post_type === $selected_post_type['slug'] ) ? true : false;
				$search_link_query = htmlspecialchars( '?post_type=' . esc_attr( $selected_post_type['slug'] ) . '&s=' . esc_attr( $search_query ), ENT_QUOTES ); // @phpstan-ignore argument.type
				?>
				<li class="search-filter__post-type">
					<a href="<?php echo esc_url( home_url( $search_link_query ) ); ?>" class="search-filter__post-type-link wp-one-novanta-button <?php echo $active ? 'wp-one-novanta-button--primary' : 'wp-one-novanta-button--secondary'; ?>">
						<?php echo esc_html( $selected_post_type['title'] ); ?>
					</a>
				</li>
				<?php
			}
		}
		?>
	</ul>
	<div class="right-blur" aria-hidden="true"></div>
</div>
