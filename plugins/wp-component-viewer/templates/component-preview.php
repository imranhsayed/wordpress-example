<?php
/**
 * Front-end template for component preview
 *
 * @package WPComponentViewer
 */

use WPComponentViewer\Renderer\ComponentRenderer;
use WPComponentViewer\Scanner\ComponentScanner;

// Get header.
wp_head();

// Make sure components are scanned and registered.
$components = ComponentScanner::scan_components();

// Get the requested component name and variation.
$component_slug      = get_query_var( 'component_name' );
$component_variation = get_query_var( 'component_variation', '' );

if ( $component_slug ) {
	?>
		<div style="align-items: center; margin: 10vh; overflow: auto; padding: 10vh;">
	<?php
		ComponentRenderer::render_variation_preview( $component_slug, $component_variation );
	?>
		</div>
	<?php
} else {
	esc_html_e( 'No component specified.', 'wp-component-viewer' );
}

// Get footer.
wp_footer();
