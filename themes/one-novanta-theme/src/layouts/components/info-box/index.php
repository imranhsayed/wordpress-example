<?php
/**
 * Component Info Box
 *
 * @component Info Box
 * @description A flexible info-box component.
 * @group UI Elements
 * @props {
 *   "heading": '',
 *   "list_items": {"type": "array", "required": true, "description": "List items"},
 * }
 * @variations {}
 * @example render_component(
 *     'info-box',
 *     null,
 *     [
 *         'heading'    => 'Frequently viewed',
 *         'list_items' => [
 *                             'content' => Template::get_component(
 *                                 'info-box',
 *                                 'item '
 *                                 [
 *                                  'title' => 'Everest S Command Reference Manual',
 *                                  'url' => '#',
 *                                  'target' => '',
 *                                 ]
 *                              ) . Template::get_component(
 *                                'info-box',
 *                                'item '
 *                                [
 *                                   'title' => 'Everest S XCR Command Reference Manual',
 *                                   'url' => '#',
 *                                   'target' => '',
 *                               ]
 *                              ) . Template::get_component(
 *                              'info-box',
 *                              'item '
 *                               [
 *                                   'title' => 'Everest S NET Product Manual',
 *                                   'url' => '#',
 *                                   'target' => '',
 *                               ]
 *                              ) . Template::get_component(
 *                              'info-box',
 *                              'item '
 *                               [
 *                                   'title' => 'Everest S XCR Product Manual',
 *                                   'url' => '#',
 *                                   'target' => '',
 *                               ]
 *                              ) . Template::get_component(
 *                              'info-box',
 *                              'item '
 *                               [
 *                                   'title' => 'Communication using SDO',
 *                                   'url' => '#',
 *                                   'target' => '',
 *                               ]
 *                              ) . Template::get_component(
 *                              'info-box',
 *                              'item '
 *                               [
 *                                   'title' => 'Denali Product Manual',
 *                                   'url' => '#',
 *                                   'target' => '',
 *                               ]
 *                              )
 *                          ],
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$list_items         = $args['list_items'] ?? [];
$heading            = $args['heading'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $list_items ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'info-box' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<?php if ( ! empty( $heading ) ) { ?>
		<h2 class="info-box__heading">
			<?php echo esc_html( $heading ); ?>
		</h2>
	<?php } ?>

	<ul class="info-box__list has-medium-font-size">
		<?php one_novanta_kses_post_e( $list_items ); ?>
	</ul>
</div>
