<?php
/**
 * Component Tabs
 *
 * @component Tabs
 * @description A reusable tabs component that displays content in tabbed interface.
 * @group UI Elements
 * @props {
 *   "tabs": {
 *     "type": "array",
 *     "required": true,
 *     "description": "Array of tab objects",
 *     "items": {
 *       "type": "object",
 *       "properties": {
 *         "id": {"type": "string", "required": true, "description": "Unique ID for the tab"},
 *         "title": {"type": "string", "required": true, "description": "Text to display in the tab navigation"},
 *         "content": {"type": "string", "required": true, "description": "HTML content for the tab panel"}
 *       }
 *     }
 *   },
 *   "active_tab_id": {"type": "string", "required": false, "description": "ID of the tab to be active by default"}
 * }
 * @variations {}
 * @example Template::render_component(
 *     'tabs',
 *     null,
 *     [
 *         'tabs' => [
 *             [
 *                 'id'      => 'tab-features',
 *                 'title'   => esc_html__('Features', 'one-novanta-theme'),
 *                 'content' => '<p>' . esc_html__('Content for the features tab.', 'one-novanta-theme') . '</p>',
 *             ],
 *             [
 *                 'id'      => 'tab-specs',
 *                 'title'   => esc_html__('Specifications', 'one-novanta-theme'),
 *                 'content' => '<p>' . esc_html__('Content for the specifications tab.', 'one-novanta-theme') . '</p>',
 *             ],
 *             [
 *                 'id'      => 'tab-reviews',
 *                 'title'   => esc_html__('Reviews', 'one-novanta-theme'),
 *                 'content' => '<p>' . esc_html__('Content for the reviews tab.', 'one-novanta-theme') . '</p>',
 *             ],
 *         ],
 *         'active_tab_id' => 'tab-reviews'
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Ensure $args are passed and contain the 'tabs' key with valid data.
if ( empty( $args['tabs'] ) || ! is_array( $args['tabs'] ) ) {
	return;
}

$component_tabs = $args['tabs'];
$active_tab_id  = $args['active_tab_id'] ?? ( ! empty( $component_tabs[0]['id'] ) ? esc_attr( $component_tabs[0]['id'] ) : 'tab1' );

$tabs_content = '';
?>

<rt-tabs class="novanta-tabs-wrapper" current-tab="<?php echo esc_attr( $active_tab_id ); ?>">

	<rt-tabs-nav class="novanta-tabs-nav">
		<?php foreach ( $component_tabs as $index => $current_tab ) : ?>
			<?php
			// Check if 'title' and 'content' are provided. If not, skip rendering this tab.
			if ( empty( $current_tab['title'] || empty( $current_tab['content'] ) ) ) {
				continue;
			}

			// Sanitize and escape the tab title.
			$tab_title = esc_html( $current_tab['title'] );
			// Check if 'id' is provided. If not, generate a default ID.
			if ( empty( $current_tab['id'] ) ) {
				$current_tab['id'] = 'tab-' . sanitize_title_with_dashes( $tab_title );
			}
			$tab_id = esc_attr( $current_tab['id'] );

			$is_active = ! empty( $tab_id ) ? ( $active_tab_id === $tab_id ) : ( 0 === $index );
			?>
			<rt-tabs-nav-item class="has-medium-font-size" <?php echo $is_active ? ' active="yes"' : ''; ?>>
				<a class="has-foreground-color" href="#<?php echo esc_attr( $tab_id ); ?>"><?php echo esc_html( $tab_title ); ?></a>
			</rt-tabs-nav-item>

			<?php ob_start(); ?>
				<rt-tabs-tab id="<?php echo esc_attr( $tab_id ); ?>" <?php echo $is_active ? ' open="yes"' : ''; ?>>
					<?php one_novanta_kses_post_e( $current_tab['content'] ); ?>
				</rt-tabs-tab>

			<?php $tabs_content .= ob_get_clean(); ?>
		<?php endforeach; ?>
	</rt-tabs-nav>

	<?php echo $tabs_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Content already sanitized with one_novanta_kses_post ?>

</rt-tabs>
