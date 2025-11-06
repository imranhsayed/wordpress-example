<?php
/**
 * Component Filter Widget
 *
 * @component Filter Widget
 * @description A flexible product-search component.
 * @group UI Elements
 * @props {
 *     "heading": {"type": "string", "required": true, "description": "The title or heading to display"},
 *     "taxonomy": {"type": "string", "required": true, "description": "The taxonomy to filter the posts by"},
 *     "post_type": {"type": "string", "required": true, "description": "The post type of posts to query"},
 *     "minimize_filter_count": {"type": "int", "required": false, "description": "Minimize filter count. Defaults to 5"},
 *     "filter_items": { "type": "array", "required": true, "description": "List items" }
 * }
 * @default {
 *      'heading'               => '',
 *      'taxonomy'              => 'category',
 *      'post_type'             => 'post',
 *      'minimize_filter_count' => 5,
 *      'filter_items'          => [],
 * }
 * @variations {}
 * @example render_component(
 *     'product-search',
 *     'filter-widget',
 *     [
 *         'heading'      => 'Frequently viewed',
 *         'post_type'    => 'post',
 *         'taxonomy'     => 'category',
 *         'filter_items' => [
 *             [
 *                 'label' => 'Yes',
 *                 'value' => 'yes',
 *             ],
 *             [
 *                 'label' => 'No',
 *                 'value' => 'no',
 *             ],
 *         ],
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$heading               = $args['heading'] ?? '';
$minimize_filter_count = $args['minimize_filter_count'] ?? 5;
$filter_items          = $args['filter_items'] ?? [];
$filter_taxonomy       = $args['taxonomy'] ?? 'category';
$filter_post_type      = $args['post_type'] ?? 'post';

// Return null if the content is empty to prevent further processing.
if ( empty( $filter_items ) ) {
	return null;
}
?>

<div class="product-search__filter-widget">
	<?php if ( ! empty( $heading ) ) { ?>
		<p class="product-search__filter-widget-heading has-medium-font-size">
			<?php echo esc_html( $heading ); ?>
		</p>
	<?php } ?>

	<ul class="product-search__filter-list">
		<?php
		foreach ( $filter_items as $index => $item ) {
			$is_hidden_class = $index >= $minimize_filter_count ? 'is-hidden' : '';
			?>
			<li class="product-search__filter-item <?php echo esc_attr( $is_hidden_class ); ?>">
				<label class="product-search__filter-label">
					<input
						type="checkbox"
						name="filter_options[]"
						value="<?php echo esc_attr( $item['value'] ); ?>"
						data-post-type="<?php echo esc_attr( $filter_post_type ); ?>"
						data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>"
					/>
					<span><?php echo esc_html( $item['label'] ); ?></span>
				</label>

				<?php
				if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
					// Inline recursion.
					echo '<ul class="product-search__filter-list-level-one">';
					foreach ( $item['children'] as $child1 ) {
						?>
						<li class="product-search__filter-item">
							<label class="product-search__filter-label">
								<input
									type="checkbox"
									name="filter_options[]"
									value="<?php echo esc_attr( $child1['value'] ); ?>"
									data-post-type="<?php echo esc_attr( $filter_post_type ); ?>"
									data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>"
								/>
								<span><?php echo esc_html( $child1['label'] ); ?></span>
							</label>

							<?php
							if ( ! empty( $child1['children'] ) && is_array( $child1['children'] ) ) {
								echo '<ul class="product-search__filter-list-level-two">';
								foreach ( $child1['children'] as $child2 ) {
									?>
									<li class="product-search__filter-item">
										<label class="product-search__filter-label">
											<input
												type="checkbox"
												name="filter_options[]"
												value="<?php echo esc_attr( $child2['value'] ); ?>"
												data-post-type="<?php echo esc_attr( $filter_post_type ); ?>"
												data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>"
											/>
											<span><?php echo esc_html( $child2['label'] ); ?></span>
										</label>
									</li>
									<?php
								}
								echo '</ul>';
							}
							?>
						</li>
						<?php
					}
					echo '</ul>';
				}
				?>
			</li>
		<?php } ?>
	</ul>

	<?php if ( count( $filter_items ) > $minimize_filter_count ) { ?>
		<one-novanta-toggle-minimize-filter-button
			class="product-search__minimize-filters"
			expand-text="<?php echo esc_attr__( 'See All', 'one-novanta-theme' ); ?>"
			collapse-text="<?php echo esc_attr__( 'See Less', 'one-novanta-theme' ); ?>"
			>
			<button class="product-search__minimize-button" aria-controls="filters" aria-expanded="false">
				<?php echo esc_html__( 'See All', 'one-novanta-theme' ); ?>
			</button>
		</one-novanta-toggle-minimize-filter-button>
	<?php } ?>
</div>
