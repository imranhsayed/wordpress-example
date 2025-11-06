<?php
/**
 * Component Sidebar Grid
 *
 * @component Sidebar Grid
 * @description A reusable sidebar-grid component with content.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "Content content"},
 *   "sidebar_content": {"type": "string", "required": false, "description": "Sidebar content"},
 * }
 * @variations {}
 * @example render_component(
 *     'sidebar-grid',
 *     null,
 *     [
 *         'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
 *         'content'            => '
 *             <h3>Disambiguation on current values and naming for Ingenia Drives</h3>
 *             <p>This document explains and clarifies how current is measured and expressed at Ingenia documentation, tools and drives. For reference next is a simplified electrical drawing of a typical 3 phase servo drive system using sinusoidal commutation. On a permanent magnet brushless motor AC that is rotating at a constant speed, read more.</p>
 *             <br />
 *             <h3>Disambiguation on current values and naming for Ingenia Drives</h3>
 *             <p>This document explains and clarifies how current is measured and expressed at Ingenia documentation, tools and drives. For reference next is a simplified electrical drawing of a typical 3 phase servo drive system using sinusoidal commutation. On a permanent magnet brushless motor AC that is rotating at a constant speed, read more.</p>
 *         ',
 *         'sidebar_content'    => '
 *             <h2>Frequently viewed</h2>
 *             <ul>
 *                 <li>Everest S Command Reference Manual</li>
 *                 <li>Everest S XCR Command Reference Manual</li>
 *                 <li>Everest S NET Product Manual</li>
 *                 <li>Everest S XCR Product Manual</li>
 *                 <li>Communication using SDO</li>
 *                 <li>Denali Product Manual</li>
 *             </ul>
 *         ',
 *     ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? '';
$sidebar_content    = $args['sidebar_content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $content ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'sidebar-grid' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<div class="sidebar-grid__content">
		<?php one_novanta_kses_post_e( $content ); ?>
	</div>

	<?php if ( ! empty( $sidebar_content ) ) { ?>
		<div class="sidebar-grid__sidebar">
			<?php one_novanta_kses_post_e( $sidebar_content ); ?>
		</div>
	<?php } ?>
</div>
