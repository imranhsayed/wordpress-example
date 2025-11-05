<?php
/**
 * AJAX handler for component rendering
 *
 * @package WPComponentViewer\UI
 */

namespace WPComponentViewer\UI;

use WPComponentViewer\Scanner\ComponentScanner;
use WPComponentViewer\Renderer\ComponentRenderer;
use WPComponentViewer\Admin\AccessControl;

/**
 * AjaxHandler class
 */
class AjaxHandler {
	/**
	 * Initialize the AJAX handler
	 *
	 * @return void
	 */
	public static function init() {

		// Admin AJAX action for loading component details.
		add_action( 'wp_ajax_get_admin_component_details', array( __CLASS__, 'get_admin_component_details' ) );
	}

	/**
	 * Get component details for admin
	 *
	 * @return void
	 */
	public static function get_admin_component_details() {
		// Check user capabilities.
		if ( ! AccessControl::user_has_access() ) {
			wp_send_json_error( 'Insufficient permissions' );
		}

		$component_name = isset( $_GET['component_name'] ) ? sanitize_text_field( wp_unslash( $_GET['component_name'] ) ) : '';

		if ( empty( $component_name ) ) {
			wp_send_json_error( 'No component specified' );
		}

		$components = ComponentScanner::scan_components();

		if ( ! isset( $components[ $component_name ] ) ) {
			wp_send_json_error( 'Component not found' );
		}

		$component          = $components[ $component_name ];
		$extra_allowed_tags = $component['extra_allowed_tags'] ?? array();

		// Buffer the output.
		ob_start();
		self::render_admin_component_details( $component );
		$html = ob_get_clean();

		$allowed_tags         = wp_kses_allowed_html( 'post' );
		$allowed_tags['svg']  = array(
			'xmlns'       => true,
			'viewbox'     => true,
			'fill'        => true,
			'width'       => true,
			'height'      => true,
			'role'        => true,
			'class'       => true,
			'aria-hidden' => true,
		);
		$allowed_tags['rect'] = array(
			'x'       => true,
			'y'       => true,
			'width'   => true,
			'height'  => true,
			'rx'      => true,
			'fill'    => true,
			'opacity' => true,
		);
		$allowed_tags['path'] = array(
			'd'               => true,
			'fill'            => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
		);
		$allowed_tags         = array_replace_recursive( $allowed_tags, $extra_allowed_tags );
		echo wp_kses( $html, $allowed_tags );
	}

	/**
	 * Render component details for admin
	 *
	 * @param array $component Component data.
	 * @return void
	 */
	private static function render_admin_component_details( $component ) {
		?>
		<div class="wp-component-viewer__component-details">
			<header class="wp-component-viewer__component-header">
				<h2 class="wp-component-viewer__component-title"><?php echo esc_html( $component['name'] ); ?></h2>
			</header>
			<?php if ( ! empty( $component['description'] ) ) : ?>
				<p class="wp-component-viewer__component-description">
					<?php echo esc_html( $component['description'] ); ?>
				</p>
			<?php endif; ?>

			<div class="wp-component-viewer__tabs">
				<div class="wp-component-viewer__tab-nav">
					<button class="wp-component-viewer__tab-btn active" data-tab="preview">
						<?php esc_html_e( 'Preview', 'wp-component-viewer' ); ?>
					</button>
					<button class="wp-component-viewer__tab-btn" data-tab="props">
						<?php esc_html_e( 'Props', 'wp-component-viewer' ); ?>
					</button>
					<button class="wp-component-viewer__tab-btn" data-tab="code">
						<?php esc_html_e( 'Code', 'wp-component-viewer' ); ?>
					</button>
					<button class="wp-component-viewer__tab-btn" data-tab="usage">
						<?php esc_html_e( 'Usage', 'wp-component-viewer' ); ?>
					</button>
					<!-- Width toggle dropdown on the right -->
					<div class="wp-component-viewer__tab-width-dropdown" style="margin-left:auto; position:relative;">
						<button type="button" class="wp-component-viewer__tab-width-toggle" aria-haspopup="listbox" aria-expanded="false">
							<span class="wp-component-viewer__tab-width-toggle-icon">
							</span>
							<svg class="wp-component-viewer__tab-width-toggle-caret" width="16" height="16" viewBox="0 0 16 16">
								<path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" />
							</svg>
						</button>
						<ul class="wp-component-viewer__tab-width-menu" tabindex="-1" role="listbox" style="display:none;">
							<li class="wp-component-viewer__tab-width-menu-item active" data-width="desktop" role="option" aria-selected="true">
								Desktop
							</li>
							<li class="wp-component-viewer__tab-width-menu-item" data-width="tablet" role="option">
								Tablet
							</li>
							<li class="wp-component-viewer__tab-width-menu-item" data-width="mobile" role="option">
								Mobile
							</li>
							<li class="wp-component-viewer__tab-width-menu-divider" aria-hidden="true"></li>
							<li class="wp-component-viewer__tab-width-menu-item wp-component-viewer__tab-width-menu-preview">
								<a class="wp-component-viewer__preview-link" href="<?php echo esc_url( home_url( 'components/' . urlencode( $component['slug'] ) . '/preview/' . urlencode( array_key_first( $component['variations'] ) ) ) ); ?>"
									target="_blank" rel="noopener noreferrer">
									<?php esc_html_e( 'Preview in new tab', 'wp-component-viewer' ); ?>
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
										<path d="M19.5 4.5h-7V6h4.44l-5.97 5.97 1.06 1.06L18 7.06v4.44h1.5v-7Zm-13 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-3H17v3a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h3V5.5h-3Z">
										</path>
									</svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="wp-component-viewer__tab-content active" data-tab="preview">
				<?php if ( ! empty( $component['variations'] ) ) : ?>
					<?php $variations = ComponentRenderer::render_variations( $component['slug'], $component['variations'] ); ?>

					<div class="wp-component-viewer__preview-header">
						<div class="wp-component-viewer__variation-tabs">
							<?php $first = true; ?>
							<?php foreach ( $variations as $variation_name => $variation ) : ?>
								<button class="wp-component-viewer__variation-tab <?php echo $first ? 'active' : ''; ?>"
									data-variation="<?php echo esc_attr( $variation_name ); ?>"
									data-component="<?php echo esc_attr( $component['slug'] ); ?>">
									<?php echo esc_html( $variation_name ); ?>
								</button>
								<?php $first = false; ?>
							<?php endforeach; ?>
						</div>
						<!-- Column toggle -->
						<div class="wp-component-viewer__preview-columns-toggle" title="Change preview columns">
							<button type="button" class="active" data-cols="1" aria-label="1 column">
								<svg fill="none">
									<rect x="2" y="2" width="16" height="16" rx="2" fill="#007cba" opacity="0.7" />
									<rect x="4" y="4" width="12" height="12" rx="1" fill="#fff" />
								</svg>
							</button>
							<button type="button" data-cols="2" aria-label="2 columns">
								<svg fill="none">
									<rect x="2" y="2" width="16" height="16" rx="2" fill="#007cba" opacity="0.7" />
									<rect x="4" y="4" width="5" height="12" rx="1" fill="#fff" />
									<rect x="11" y="4" width="5" height="12" rx="1" fill="#fff" />
								</svg>
							</button>
							<button type="button" data-cols="3" aria-label="3 columns">
								<svg fill="none">
									<rect x="2" y="2" width="16" height="16" rx="2" fill="#007cba" opacity="0.7" />
									<rect x="4" y="4" width="3" height="12" rx="1" fill="#fff" />
									<rect x="8.5" y="4" width="3" height="12" rx="1" fill="#fff" />
									<rect x="13" y="4" width="3" height="12" rx="1" fill="#fff" />
								</svg>
							</button>
						</div>
					</div>

					<div class="wp-component-viewer__preview-columns-wrapper wp-component-viewer__preview-columns-1">
						<div class="wp-component-viewer__preview-box">
							<?php $first = true; ?>
							<?php foreach ( $variations as $variation_name => $variation ) : ?>
								<div class="wp-component-viewer__variation <?php echo $first ? 'active' : ''; ?>"
									data-variation="<?php echo esc_attr( $variation_name ); ?>">
									<?php
									echo $variation['output']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
								</div>
								<?php $first = false; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<div class="wp-component-viewer__preview-columns-wrapper wp-component-viewer__preview-columns-1">
						<div class="wp-component-viewer__preview-box">
							<?php
							echo ComponentRenderer::render( $component['slug'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="wp-component-viewer__tab-content" data-tab="props">
				<?php if ( ! empty( $component['props'] ) ) : ?>
					<table class="wp-component-viewer__props-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Name', 'wp-component-viewer' ); ?></th>
								<th><?php esc_html_e( 'Type', 'wp-component-viewer' ); ?></th>
								<th><?php esc_html_e( 'Required', 'wp-component-viewer' ); ?></th>
								<th><?php esc_html_e( 'Default', 'wp-component-viewer' ); ?></th>
								<th><?php esc_html_e( 'Description', 'wp-component-viewer' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $component['props'] as $prop_name => $prop ) : ?>
								<tr>
									<td><code><?php echo esc_html( $prop_name ); ?></code></td>
									<td><code><?php echo esc_html( $prop['type'] ?? 'any' ); ?></code></td>
									<td><?php echo isset( $prop['required'] ) && $prop['required'] ? '✓' : '–'; ?></td>
									<td>
										<?php if ( isset( $prop['default'] ) ) : ?>
											<code><?php echo esc_html( $prop['default'] ); ?></code>
										<?php else : ?>
											–
										<?php endif; ?>
									</td>
									<td>
										<?php if ( isset( $prop['description'] ) ) : ?>
											<?php echo esc_html( $prop['description'] ); ?>
										<?php endif; ?>

										<?php if ( isset( $prop['options'] ) && is_array( $prop['options'] ) ) : ?>
											<div class="options">
												<strong><?php esc_html_e( 'Options:', 'wp-component-viewer' ); ?></strong>
												<?php echo esc_html( implode( ', ', $prop['options'] ) ); ?>
											</div>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else : ?>
					<p><?php esc_html_e( 'No props documented for this component.', 'wp-component-viewer' ); ?></p>
				<?php endif; ?>
			</div>

			<div class="wp-component-viewer__tab-content" data-tab="code">
				<div class="wp-component-viewer__code-block">
					<div class="wp-component-viewer__code-header">
						<?php esc_html_e( 'Component Source Code', 'wp-component-viewer' ); ?>
					</div>
					<pre><code class="wp-component-viewer__code-content language-php"><?php echo esc_html( ComponentRenderer::get_source_code( $component['slug'] ) ); ?></code></pre>
				</div>
			</div>

			<div class="wp-component-viewer__tab-content" data-tab="usage">
				<?php if ( ! empty( $component['example'] ) ) : ?>
					<div class="wp-component-viewer__code-block">
						<div class="wp-component-viewer__code-header">
							<?php esc_html_e( 'Example Usage', 'wp-component-viewer' ); ?>
						</div>
						<pre><code class="wp-component-viewer__code-content language-php"><?php echo esc_html( $component['example'] ); ?></code></pre>
					</div>
				<?php endif; ?>

				<div class="wp-component-viewer__code-block">
					<div class="wp-component-viewer__code-header">
						<?php esc_html_e( 'Basic Usage', 'wp-component-viewer' ); ?>
					</div>
					<pre><code class="wp-component-viewer__code-content language-php"><?php echo esc_html( "<?php echo get_component('{$component['slug']}', [\n    // props\n]); ?>" ); ?></code></pre>
				</div>
			</div>
		</div>
		<?php
	}
}
