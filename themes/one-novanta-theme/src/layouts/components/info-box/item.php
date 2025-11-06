<?php
/**
 * Component Info-box item.
 *
 * @component Info Box Item
 * @description A flexible info-box-item component.
 * @group UI Elements
 * @props {
 * "title": "string",
 * "url": "string",
 * "target": "string",
 * }
 * @variations {}
 * @example render_component(
 *      'info-box',
 *      null,
 *      [
 *          'title' => 'Everest S Command Reference Manual',
 *          'url' => '#',
 *          'target' => '',
 *      ]
 * )
 *
 * @package OneNovantaTheme\Components
 */

$list_title  = esc_html( $args['title'] ?? '' );
$list_url    = esc_url( $args['url'] ?? '#' );
$list_target = ! empty( $args['target'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

// If title is empty, return.
if ( empty( $list_title ) ) {
	return;
}

?>
<li class="info-box__list-item has-heading-font-family">
	<a href="<?php echo esc_url( $list_url ); ?>"<?php echo esc_attr( $list_target ); ?> title="<?php echo esc_attr( $list_title ); ?>">
		<?php echo esc_html( $list_title ); ?>
	</a>
</li>
