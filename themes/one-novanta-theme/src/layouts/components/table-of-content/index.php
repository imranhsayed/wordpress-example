<?php
/**
 * Component Table of Content
 *
 * @component    Table of Content
 * @description  A flexible table-of-content component.
 * @group        UI Elements
 * @props {
 *     "heading": {
 *         "type": "string",
 *         "required": false,
 *         "description": "Heading."
 *     },
 *     "list_items": {
 *         "type": "array",
 *         "required": true,
 *         "description": "List items"
 *     },
 * }
 * @variations {}
 * @example     render_component(
 *                  'table-of-content',
 *                  null,
 *                  [
 *                      'heading'    => 'Topics',
 *                      'list_items' => [
 *                          [
 *                              'id' =>"start",
 *                              'title' => 'Start'
 *                          ],
 *                          [
 *                              'id' =>"grinding",
 *                              'title' => 'Robotic Grinding System'
 *                          ],
 *                          [
 *                              'id' =>"weldbot",
 *                              'title' => 'WeldBot's system'
 *                          ],
 *                          [
 *                              'id' =>"grinder",
 *                              'title' => 'ATI's Compliant Angle Grinder'
 *                          ],
 *                          [
 *                              'id' =>"changer",
 *                              'title' => 'ATI QC-29 Robotic Tool Changer'
 *                          ],
 *                          [
 *                              'id' =>"clickable",
 *                              'title' => 'Clickable sections that autoscrolls to the section'
 *                          ],
 *                          [
 *                              'id' =>"progress",
 *                              'title' => 'This is also the scroll progress tracker'
 *                          ],
 *                          [
 *                              'id' =>"end",
 *                              'title' => 'End'
 *                          ],
 *                      ],
 *                  ]
 *              )
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$heading            = $args['heading'] ?? esc_html__( 'Topics', 'one-novanta-theme' );
$list_items         = $args['list_items'] ?? [];
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the list_items is empty to prevent further processing.
if ( empty( $list_items ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'table-of-content', 'has-small-font-size', 'has-heading-font-family' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<?php if ( ! empty( $heading ) ) { ?>
		<p class="table-of-content__label">
			<?php echo esc_html( $heading ); ?>
		</p>
	<?php } ?>

	<ul class="table-of-content__list">
		<?php foreach ( $list_items as $list_item ) { ?>
			<li class="table-of-content__list-item">
				<a href="<?php echo esc_url( '#' . $list_item['id'] ); ?>">
					<?php echo wp_strip_all_tags( $list_item['title'] ); // phpcs:ignore ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>
