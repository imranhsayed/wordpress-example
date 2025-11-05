<?php
/**
 * Admin page UI
 *
 * @package WPComponentViewer\UI
 */

namespace WPComponentViewer\UI;

use WPComponentViewer\Scanner\ComponentScanner;

/**
 * AdminPage class
 */
class AdminPage {
	/**
	 * Render the admin page
	 *
	 * @return void
	 */
	public function render() {
		$components = ComponentScanner::scan_components();
		$groups     = $this->group_components( $components );

		$selected_component = isset( $_GET['component_name'] ) ? sanitize_text_field( wp_unslash( $_GET['component_name'] ) ) : null;
		?>
		<div class="wrap wp-component-viewer">
			<div class="wp-component-viewer__header">
				<h1 class="wp-component-viewer__header-title"><?php esc_html_e( 'Component Viewer', 'wp-component-viewer' ); ?></h1>
				<div class="wp-component-viewer__actions">
					<a href="
					<?php
					echo esc_url(
						wp_nonce_url(
							admin_url( 'admin.php?page=wp-component-viewer&wp-component-viewer-refresh=1' ),
							'wp_component_viewer_refresh'
						)
					);
					?>
					" class="wp-component-viewer__refresh-btn">
						<?php esc_html_e( 'Refresh', 'wp-component-viewer' ); ?>						
					</a>
				</div>
			</div>

			<div class="wp-component-viewer__container">
				<div class="wp-component-viewer__sidebar">
					<div class="wp-component-viewer__search">
						<input type="text" id="component-search" placeholder="<?php esc_attr_e( 'Search components...', 'wp-component-viewer' ); ?>" />
					</div>

					<ul class="wp-component-viewer__groups">
						<?php foreach ( $groups as $group_name => $group_components ) : ?>
							<li class="wp-component-viewer__group">
								<h3><?php echo esc_html( $group_name ); ?></h3>
								<ul class="wp-component-viewer__components">
									<?php foreach ( $group_components as $component ) : ?>
										<li class="wp-component-viewer__component">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=wp-component-viewer&component_name=' . rawurlencode( sanitize_title( $component['slug'] ) ) ) ); ?>"
												class="<?php echo $selected_component === $component['slug'] ? 'active' : ''; ?>">
												<?php echo esc_html( $component['name'] ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="wp-component-viewer__content">
					<!-- Loading indicator -->
					<div id="admin-component-loading" class="wp-component-viewer__loading" style="display:none;">
						<div class="wp-component-viewer__loading-spinner"></div>
						<p><?php esc_html_e( 'Loading component...', 'wp-component-viewer' ); ?></p>
					</div>

					<div id="admin-component-content">
						<?php if ( $selected_component && isset( $components[ $selected_component ] ) ) : ?>
							<?php
							$_GET['component_name'] = $selected_component;
							\WPComponentViewer\UI\AjaxHandler::get_admin_component_details();
							?>
						<?php else : ?>
							<div class="wp-component-viewer__empty-state">
								<h2><?php esc_html_e( 'Select a component from the sidebar', 'wp-component-viewer' ); ?></h2>
								<p><?php esc_html_e( 'Or create a new component with the @component docblock tag in your theme files.', 'wp-component-viewer' ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Group components by their group metadata
	 *
	 * @param array $components Components array.
	 * @return array
	 */
	private function group_components( $components ) {
		$groups = array();

		foreach ( $components as $component ) {
			$group = $component['group'] ?? 'Uncategorized';

			if ( ! isset( $groups[ $group ] ) ) {
				$groups[ $group ] = array();
			}

			$groups[ $group ][] = $component;
		}

		// Sort groups alphabetically.
		ksort( $groups );

		// Move "Uncategorized" to the end.
		if ( isset( $groups['Uncategorized'] ) ) {
			$uncategorized = $groups['Uncategorized'];
			unset( $groups['Uncategorized'] );
			$groups['Uncategorized'] = $uncategorized;
		}

		return $groups;
	}
}
