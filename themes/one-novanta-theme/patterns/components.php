<?php
/**
 * Title: Novanta Components
 * Slug: one-novanta/components
 *
 * Description: Components pattern.
 *
 * @package OneNovantaTheme\Patterns
 */

use OneNovanta\Controllers\Common\Template;

/**
 * Render tiles.
 *
 * @param array<array<mixed>> $tiles_array Array of items to render.
 *
 * @return string Rendered markup.
 */
function render_tiles( $tiles_array = [] ) {
	$markup = '';

	foreach ( $tiles_array as $item ) {
		$markup .= Template::get_component(
			'tile-carousel',
			'item',
			[
				...$item,
			]
		);
	}

	return $markup;
}

?>

<main class="wp-block-group is-layout-constrained wp-block-group-is-layout-constrained">
	<div class="entry-content alignfull wp-block-post-content is-layout-constrained wp-block-post-content-is-layout-constrained">
		<?php
		Template::render_component(
			'hero',
			null,
			[
				'image_id' => 103,
				'layout'   => 'narrow',
				'height'   => 'large',
				'content'  => Template::get_component(
					'hero',
					'content',
					[
						'pre_heading' => 'Robotics & Automation',
						'heading'     => 'Any Robot. Many Tasks.',
						'content'     => '<p>World class motion and robotic technologies for mission critical applications.</p>' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Discover',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'secondary-dark',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Watch Video',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary-dark',
											],
										),
								]
							),
					],
				),
			]
		);
		?>

		<br /><hr /><br />

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Product Search',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'product-search',
					null,
					[
						'sidebar_content' => Template::get_component(
							'product-search',
							'filter-widget',
							[
								'heading'      => 'Solid State Switch',
								'filter_items' => [
									[
										'label' => 'Yes',
										'value' => 'yes',
									],
									[
										'label' => 'No',
										'value' => 'no',
									],
								],
							]
						) .
						Template::get_component(
							'product-search',
							'filter-widget',
							[
								'heading'      => 'Angular Displacement',
								'filter_items' => [
									[
										'label' => '±8°',
										'value' => '8',
									],
									[
										'label' => '±10°',
										'value' => '10',
									],
									[
										'label' => '±11°',
										'value' => '11',
									],
									[
										'label' => '±12°',
										'value' => '12',
									],
									[
										'label' => '±13°',
										'value' => '13',
									],
								],
							]
						) .
						Template::get_component(
							'product-search',
							'filter-widget',
							[
								'heading'      => 'Axial Displacement',
								'filter_items' => [
									[
										'label' => '5.1 mm',
										'value' => '5-1-mm',
									],
									[
										'label' => '5.6 mm',
										'value' => '5-6-mm',
									],
									[
										'label' => '8.6 mm',
										'value' => '8-6-mm',
									],
									[
										'label' => '10 mm',
										'value' => '10-mm',
									],
									[
										'label' => '12 mm',
										'value' => '12-mm',
									],
									[
										'label' => '16 mm',
										'value' => '16-mm',
									],
								],
							]
						),
						'content'         => Template::get_component(
							'grid',
							null,
							[
								'column_count' => 3,
								'content'      => Template::get_component(
									'cards',
									'product',
									[
										'image_id' => 21,
										'url'      => '#',
										'category' => 'Product Category',
										'heading'  => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
										'content'  => '
											<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability.</p>
										' .
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Add to quote',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary',
											],
										),
									],
								) .
								Template::get_component(
									'cards',
									'product',
									[
										'image_id'    => 21,
										'url'         => '#',
										'category'    => 'Product Category',
										'product_tag' => 'New',
										'heading'     => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
										'content'     => '
											<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability.</p>
										' .
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Add to quote',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary',
											],
										),
									],
								) .
								Template::get_component(
									'cards',
									'product',
									[
										'image_id' => 21,
										'category' => 'Product Category',
										'heading'  => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
										'content'  => '
											<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability.</p>
										' . Template::get_component(
											'product-search',
											'attributes',
											[
												'attributes' => [
													[
														'heading' => 'Attribute 1',
														'content' => 'Lorem ipsum dolor set amit',
													],
													[
														'heading' => 'Attribute 2',
														'content' => 'Lorem ipsum dolor set amit',
													],
													[
														'heading' => 'Attribute 3',
														'content' => 'Lorem ipsum dolor set amit',
													],
												],
											]
										),
									],
								) .
								Template::get_component(
									'cards',
									'product',
									[
										'image_id'    => 21,
										'category'    => 'Product Category',
										'product_tag' => 'New',
										'heading'     => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
										'content'     => '
											<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability.</p>
										' .
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Add to quote',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary',
											],
										),
									],
								),
							],
						),
					],
				),
			],
		);
		?>

		<br /><hr /><br />

		<?php
		Template::render_component(
			'grid',
			null,
			[
				'column_count' => 2,
				'content'      => Template::get_component(
					'grid',
					'item',
					[
						'content' => Template::get_component(
							'table-of-content',
							null,
							[
								'heading'    => 'Topics',
								'list_items' => [
									[
										'id'    => 'start',
										'title' => 'Start',
									],
									[
										'id'    => 'grinding',
										'title' => 'Robotic Grinding System',
									],
									[
										'id'    => 'weldbot',
										'title' => "WeldBot's system",
									],
									[
										'id'    => 'grinder',
										'title' => "ATI's Compliant Angle Grinder",
									],
									[
										'id'    => 'changer',
										'title' => 'ATI QC-29 Robotic Tool Changer',
									],
									[
										'id'    => 'clickable',
										'title' => 'Clickable sections that autoscrolls to the section',
									],
									[
										'id'    => 'progress',
										'title' => 'This is also the scroll progress tracker',
									],
									[
										'id'    => 'end',
										'title' => 'End',
									],
								],
							],
						),
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '
								<h3 id="start">Start Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="grinding">Grinding Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="weldbot">WeldBot Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="grinder">Angle Grinder Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="changer">Tool Changer Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="clickable">Clickable Section</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="progress">Progress Tracker</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
							<br><br>
								<h3 id="end">End Content</h3>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>
						',
					],
				),
			]
		);
		?>

		<br /><hr /><br />

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component Card',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 2,
						'content'      => Template::get_component(
							'cards',
							null,
							[
								'image_id'    => 21,
								'heading'     => 'Extremely High Repeatability',
								'heading_tag' => 'h4',
								'content'     => '
									<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing, at rated load, shows that the typical repeatability is much better than the guaranteed values.</p>'
									,
							],
						) .
							Template::get_component(
								'cards',
								null,
								[
									'image_id'    => 21,
									'heading'     => 'Extremely High Repeatability',
									'heading_tag' => 'h4',
									'content'     => '
									<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing, at rated load, shows that the typical repeatability is much better than the guaranteed values.</p>'
									,
								],
							),
					],
				),
			],
		);
		?>

		<br /><hr /><br />
		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Article Collection Card',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 2,
						'content'      => Template::get_component(
							'cards',
							'article-collection',
							[
								'image_id' => 103,
								'url'      => '#',
								'heading'  => 'GBX Tool Changer Module for 10Gb Industry 4.0 Applications',
								'category' => 'Product Category',
								'content'  => '
									<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores lor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et et justo duo dolores et ea rebbum.</p>'
								,
							],
						) .
							Template::get_component(
								'cards',
								'article-collection',
								[
									'image_id' => 103,
									'url'      => '#',
									'heading'  => 'MassRobotics Healthcare Robotics Catalyst Program Opens',
									'category' => 'Product Category',
									'content'  => '
										<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing, at rated load, shows that the typical repeatability is much better than the guaranteed values.</p>'
									,
								],
							),
					],
				),
			],
		);
		?>

		<br /><hr /><br />
		<div class="has-text-align-center">
			<?php
			// SVG Component.
			Template::render_component(
				'locale-switcher',
				null,
			);
			?>
		</div>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Sidebar Grid</h2>

		<?php
		// Component: Sidebar Grid.
		Template::render_component(
			'sidebar-grid',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content'            => '
						<h3>Disambiguation on current values and naming for Ingenia Drives</h3>
						<p>This document explains and clarifies how current is measured and expressed at Ingenia documentation, tools and drives. For reference next is a simplified electrical drawing of a typical 3 phase servo drive system using sinusoidal commutation. On a permanent magnet brushless motor AC that is rotating at a constant speed, read more.</p>
						<br />
						<h3>Disambiguation on current values and naming for Ingenia Drives</h3>
						<p>This document explains and clarifies how current is measured and expressed at Ingenia documentation, tools and drives. For reference next is a simplified electrical drawing of a typical 3 phase servo drive system using sinusoidal commutation. On a permanent magnet brushless motor AC that is rotating at a constant speed, read more.</p>
					',
				'sidebar_content'    => '
						<h2>Frequently viewed</h2>
						<ul>
							<li>Everest S Command Reference Manual</li>
							<li>Everest S XCR Command Reference Manual</li>
							<li>Everest S NET Product Manual</li>
							<li>Everest S XCR Product Manual</li>
							<li>Communication using SDO</li>
							<li>Denali Product Manual</li>
						</ul>
					',
			]
		);
		?>

		<br /><hr /><br />

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Article Cards',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 4,
						'content'      => Template::get_component(
							'cards',
							'article',
							[
								'image_id' => 21,
								'heading'  => 'Magnis arcu habitant congue magnis arcu habitant congue',
								'category' => 'Article',
								'url'      => '#',
							],
						) .
							Template::get_component(
								'cards',
								'article',
								[
									'image_id' => 21,
									'heading'  => 'Magnis arcu habitant congue magnis arcu habitant congue',
									'category' => 'Category',
									'url'      => '#',
								],
							) .
							Template::get_component(
								'cards',
								'article',
								[
									'image_id' => 21,
									'heading'  => 'Magnis arcu habitant congue magnis arcu habitant congue',
									'category' => 'Article',
									'url'      => '#',
								],
							) .
							Template::get_component(
								'cards',
								'article',
								[
									'image_id' => 21,
									'heading'  => 'Magnis arcu habitant congue magnis arcu habitant congue',
									'category' => 'Category',
									'url'      => '#',
								],
							),
					],
				),
			],
		);
		?>

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Product Cards',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 4,
						'content'      => Template::get_component(
							'cards',
							'product',
							[
								'image_id' => 21,
								'url'      => '#',
								'category' => 'Product Category',
								'heading'  => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
							],
						) .
							Template::get_component(
								'cards',
								'product',
								[
									'image_id'    => 21,
									'url'         => '#',
									'category'    => 'Product Category',
									'product_tag' => 'New',
									'heading'     => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
								],
							) .
							Template::get_component(
								'cards',
								'product',
								[
									'image_id' => 21,
									'category' => 'Product Category',
									'heading'  => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
								],
							) .
							Template::get_component(
								'cards',
								'product',
								[
									'image_id'    => 21,
									'category'    => 'Product Category',
									'product_tag' => 'New',
									'heading'     => 'Axia Force/Torque Sensors ECAT-AXIA80-M50',
								],
							),
					],
				),
			],
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Table</h2>

		<?php
		// Typography.
		Template::render_component(
			'component-table',
			null,
			[
				'headers' => [ 'Part Number', 'Description', '' ],
				'rows'    => [
					[
						[
							'label'   => 'Part Number',
							'content' => '9120-CV10P-T',
						],
						[
							'label'   => 'Description',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
						],
						[
							'label'   => '',
							'content' => Template::get_component(
								'button',
								null,
								[
									'content' => 'Add to Quote',
									'icon'    => true,
									'url'     => '#',
								],
							),
						],
					],
					[
						[
							'label'   => 'Part Number',
							'content' => '9120-CV10P-T',
						],
						[
							'label'   => 'Description',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
						],
						[
							'label'   => '',
							'content' => Template::get_component(
								'button',
								null,
								[
									'content' => 'Add to Quote',
									'icon'    => true,
									'url'     => '#',
								],
							),
						],
					],
				],
			],
		);
		?>

		<br /><br />
		<h2 class="has-text-align-center">Component: Typography</h2>
		<?php
		// Typography.
		Template::render_component( 'typography' );
		?>

		<br /><hr />

		<h2 class="has-text-align-center">Component: Color Palette</h2>
		<?php
		// Color Palette.
		Template::render_component( 'color-palette' );
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Buttons (Wrapper)</h2>

		<h3>Horizontal - Left</h3>
		<?php
		// Buttons.
		Template::render_component(
			'buttons',
			null,
			[
				'content' =>
				// Primary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Primary',
							'icon'    => false,
							'url'     => '#',
						],
					) .
					// Secondary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Secondary',
							'icon'    => false,
							'variant' => 'secondary',
							'url'     => '#',
						],
					),
			]
		);
		?>

		<br /><hr /><br />
		<h3>Horizontal - Right</h3>
		<?php
		// Buttons.
		Template::render_component(
			'buttons',
			null,
			[
				'horizontal_align' => 'right',
				'content'          =>
				// Primary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Primary',
							'icon'    => false,
							'url'     => '#',
						],
					) .
					// Secondary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Secondary',
							'icon'    => false,
							'variant' => 'secondary',
							'url'     => '#',
						],
					),
			]
		);
		?>

		<br /><hr /><br />
		<h3>Horizontal - Center</h3>
		<?php
		// Buttons.
		Template::render_component(
			'buttons',
			null,
			[
				'horizontal_align' => 'center',
				'content'          =>
				// Primary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Primary',
							'icon'    => false,
							'url'     => '#',
						],
					) .
					// Secondary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Secondary',
							'icon'    => false,
							'variant' => 'secondary',
							'url'     => '#',
						],
					),
			]
		);
		?>

		<br /><hr /><br />
		<h3>Horizontal - Space Between</h3>
		<?php
		// Buttons.
		Template::render_component(
			'buttons',
			null,
			[
				'horizontal_align' => 'space-between',
				'content'          =>
				// Primary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Primary',
							'icon'    => false,
							'url'     => '#',
						],
					) .
					// Secondary Button.
					Template::get_component(
						'button',
						null,
						[
							'content' => 'Secondary',
							'icon'    => false,
							'variant' => 'secondary',
							'url'     => '#',
						],
					),
			]
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Button (Single)</h2>

		<div class="grid grid--cols-2">
			<div>
				<h3>Primary</h3>
				<div style="margin: 16px 0;">
					<?php
					// Primary Button.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Primary',
							'icon'    => true,
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Secondary</h3>
				<div style="margin: 16px 0;">
					<?php
					// Secondary Button.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Secondary',
							'icon'    => true,
							'variant' => 'secondary',
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Primary with URL</h3>
				<div style="margin: 16px 0;">
					<?php
					// Primary Button with URL.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Primary with URL',
							'icon'    => true,
							'url'     => '#',
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Secondary with URL</h3>
				<div style="margin: 16px 0;">
					<?php
					// Secondary Button with URL.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Secondary with URL',
							'icon'    => true,
							'url'     => '#',
							'variant' => 'secondary',
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Primary - Disabled</h3>
				<div style="margin: 16px 0;">
					<?php
					// Primary Button - Disabled.
					Template::render_component(
						'button',
						null,
						[
							'content'  => 'Primary - Disabled',
							'icon'     => true,
							'disabled' => true,
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Secondary - Disabled</h3>
				<div style="margin: 16px 0;">
					<?php
					// Secondary Button - Disabled.
					Template::render_component(
						'button',
						null,
						[
							'content'  => 'Secondary - Disabled',
							'icon'     => true,
							'variant'  => 'secondary',
							'disabled' => true,
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Primary with URL - Disabled</h3>
				<div style="margin: 16px 0;">
					<?php
					// Primary Button with URL - Disabled.
					Template::render_component(
						'button',
						null,
						[
							'content'  => 'Primary with URL - Disabled',
							'icon'     => true,
							'url'      => '#',
							'disabled' => true,
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Secondary with URL - Disabled</h3>
				<div style="margin: 16px 0;">
					<?php
					// Secondary Button with URL - Disabled.
					Template::render_component(
						'button',
						null,
						[
							'content'  => 'Secondary with URL - Disabled',
							'icon'     => true,
							'url'      => '#',
							'variant'  => 'secondary',
							'disabled' => true,
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Primary without an Icon</h3>
				<div style="margin: 16px 0;">
					<?php
					// Primary Button without an Icon.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Primary without Icon',
						],
					);
					?>
				</div>
			</div>

			<div>
				<h3>Secondary without an Icon</h3>
				<div style="margin: 16px 0;">
					<?php
					// Secondary Button without an Icon.
					Template::render_component(
						'button',
						null,
						[
							'content' => 'Secondary without Icon',
							'variant' => 'secondary',
						],
					);
					?>
				</div>
			</div>
		</div>

		<br />
		<div>
			<h3>Multiple Buttons</h3>
			<div style="display: flex; flex-flow: row wrap; gap: 20px;">
				<?php
				// Primary Button.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Primary',
						'icon'    => true,
					],
				);
				?>

				<?php
				// Secondary Button.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Secondary',
						'icon'    => true,
						'variant' => 'secondary',
					],
				);
				?>

				<?php
				// Primary Button without an Icon.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Primary without Icon',
					],
				);
				?>

				<?php
				// Secondary Button without an Icon.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Secondary without Icon',
						'variant' => 'secondary',
					],
				);
				?>

				<?php
				// Button - Disabled.
				Template::render_component(
					'button',
					null,
					[
						'content'  => 'Disabled',
						'icon'     => true,
						'disabled' => true,
					],
				);
				?>
			</div>
		</div>

		<br />
		<!-- Dark Background Variants -->
		<div class="has-foreground-background-color typography-spacing" style="padding: 50px;">

			<div class="grid grid--cols-2">
				<div>
					<h3 style="color: #fff;">Primary Dark</h3>
					<div style="margin: 16px 0;">
						<?php
						// Primary Button Dark.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Primary',
								'icon'    => true,
								'variant' => 'primary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Secondary Dark</h3>
					<div style="margin: 16px 0;">
						<?php
						// Secondary Button Dark.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Secondary',
								'icon'    => true,
								'variant' => 'secondary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Primary Dark with URL</h3>
					<div style="margin: 16px 0;">
						<?php
						// Primary Button Dark with URL.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Primary with URL',
								'icon'    => true,
								'url'     => '#',
								'variant' => 'primary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Secondary Dark with URL</h3>
					<div style="margin: 16px 0;">
						<?php
						// Secondary Button Dark with URL.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Secondary with URL',
								'icon'    => true,
								'url'     => '#',
								'variant' => 'secondary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Primary Dark - Disabled</h3>
					<div style="margin: 16px 0;">
						<?php
						// Primary Button Dark - Disabled.
						Template::render_component(
							'button',
							null,
							[
								'content'  => 'Primary - Disabled',
								'icon'     => true,
								'disabled' => true,
								'variant'  => 'primary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Secondary Dark - Disabled</h3>
					<div style="margin: 16px 0;">
						<?php
						// Secondary Button Dark - Disabled.
						Template::render_component(
							'button',
							null,
							[
								'content'  => 'Secondary - Disabled',
								'icon'     => true,
								'variant'  => 'secondary-dark',
								'disabled' => true,
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Primary Dark with URL - Disabled</h3>
					<div style="margin: 16px 0;">
						<?php
						// Primary Button Dark with URL - Disabled.
						Template::render_component(
							'button',
							null,
							[
								'content'  => 'Primary with URL - Disabled',
								'icon'     => true,
								'url'      => '#',
								'variant'  => 'primary-dark',
								'disabled' => true,
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Secondary Dark with URL - Disabled</h3>
					<div style="margin: 16px 0;">
						<?php
						// Secondary Button Dark with URL - Disabled.
						Template::render_component(
							'button',
							null,
							[
								'content'  => 'Secondary with URL - Disabled',
								'icon'     => true,
								'url'      => '#',
								'variant'  => 'secondary-dark',
								'disabled' => true,
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Primary Dark without an Icon</h3>
					<div style="margin: 16px 0;">
						<?php
						// Primary Dark without an Icon.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Primary without Icon',
								'variant' => 'primary-dark',
							],
						);
						?>
					</div>
				</div>

				<div>
					<h3 style="color: #fff;">Secondary Dark without an Icon</h3>
					<div style="margin: 16px 0;">
						<?php
						// Secondary Dark without an Icon.
						Template::render_component(
							'button',
							null,
							[
								'content' => 'Secondary without Icon',
								'variant' => 'secondary-dark',
							],
						);
						?>
					</div>
				</div>
			</div>

			<br />
			<h3 style="color: #fff;">Multiple Buttons</h3>
			<div style="display: flex; flex-flow: row wrap; gap: 20px;">
				<?php
				// Primary Button Dark.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Primary',
						'icon'    => true,
						'variant' => 'primary-dark',
					],
				);
				?>

				<?php
				// Secondary Button Dark.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Secondary',
						'icon'    => true,
						'variant' => 'secondary-dark',
					],
				);
				?>

				<?php
				// Primary Button Dark without an Icon.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Primary without Icon',
						'variant' => 'primary-dark',
					],
				);
				?>

				<?php
				// Secondary Button Dark without an Icon.
				Template::render_component(
					'button',
					null,
					[
						'content' => 'Secondary without Icon',
						'variant' => 'secondary-dark',
					],
				);
				?>

				<?php
				// Button Dark - Disabled.
				Template::render_component(
					'button',
					null,
					[
						'content'  => 'Disabled',
						'icon'     => true,
						'disabled' => true,
					],
				);
				?>
			</div>
		</div>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Grid</h2>
		<?php
		Template::render_component(
			'grid',
			null,
			[
				'column_count' => 2,
				'content'      => Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				),
			]
		);

		Template::render_component(
			'grid',
			null,
			[
				'column_count' => 3,
				'content'      => Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				),
			]
		);

		Template::render_component(
			'grid',
			null,
			[
				'column_count' => 4,
				'content'      => Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				) . Template::get_component(
					'grid',
					'item',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								',
					],
				),
			]
		);
		?>

		<br /><hr /><br />

		<h2 class="has-text-align-center">Component: Two Columns</h2>

		<?php
		// Two Columns.
		Template::render_component(
			'two-columns',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content'            => Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<h2 class="has-xx-large-font-size">How we can help the automotive industry?</h2>',
					],
				) . Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								',
					],
				),
			]
		);

		Template::render_component(
			'two-columns',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'vertical_align'     => 'middle',
				'content'            => Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								',
					]
				) . Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<h2 class="has-xx-large-font-size">How we can help?</h2>',
					],
				),
			]
		);

		Template::render_component(
			'two-columns',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content'            => Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								',
					],
				),
			]
		);

		Template::render_component(
			'two-columns',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content_align'      => 'right',
				'content'            => Template::get_component(
					'two-columns',
					'column',
					[
						'content' => '<p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing?</strong></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								',
					],
				),
			]
		);
		?>

		<br /><hr /><br />

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Featured Content',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'featured-content',
					null,
					[
						'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
						'content'            => Template::get_component(
							'featured-content',
							'media',
							[
								'content' => Template::get_component(
									'image',
									null,
									[
										'id'   => 21,
										'size' => 'large',
									]
								),
							],
						) .
							Template::get_component(
								'featured-content',
								'content',
								[
									'content' => '
									<h2>Why ATI Material Removal Tools?</h2>
									<p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
									' .
										Template::get_component(
											'buttons',
											null,
											[
												'content' =>
												// Primary Button.
													Template::get_component(
														'button',
														null,
														[
															'content' => 'About us',
															'icon' => true,
															'url'  => '#',
															'variant' => 'secondary',
														],
													) .
													// Secondary Button.
													Template::get_component(
														'button',
														null,
														[
															'content' => 'Talk to an expert',
															'icon' => false,
															'url'  => '#',
														],
													),
											]
										),
								],
							),
					]
				),
			],
		);
		?>

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Featured Content',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'featured-content',
					null,
					[
						'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
						'media_align'        => 'right',
						'content'            => Template::get_component(
							'featured-content',
							'media',
							[
								'content' => Template::get_component(
									'image',
									null,
									[
										'id'   => 21,
										'size' => 'large',
									]
								),
							],
						) .
							Template::get_component(
								'featured-content',
								'content',
								[
									'content' => '
									<h2>Why ATI Material Removal Tools?</h2>
									<p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
									<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
									' .
										Template::get_component(
											'buttons',
											null,
											[
												'content' =>
												// Primary Button.
													Template::get_component(
														'button',
														null,
														[
															'content' => 'About us',
															'icon' => false,
															'url'  => '#',
															'variant' => 'secondary',
														],
													) .
													// Secondary Button.
													Template::get_component(
														'button',
														null,
														[
															'content' => 'Talk to an expert',
															'icon' => false,
															'url'  => '#',
														],
													),
											]
										),
								],
							),
					]
				),
			],
		);
		?>

		<br /><hr />
		<h2 class="has-text-align-center">Component Hero</h2>
		<br />

		<?php
		Template::render_component(
			'hero',
			null,
			[
				'image_id' => 64,
				'content'  => Template::get_component(
					'hero',
					'content',
					[
						'pre_heading' => 'Robotics & Automation',
						'heading'     => 'WeldBot Releases Robotic
								Grinding System using
								Novanta Technology',
						'content'     => '<p>Published on July 26, 2024</p>',
					],
				),
			]
		);
		?>
		<br /><br />

		<?php
		Template::render_component(
			'hero',
			null,
			[
				'image_id' => 64,
				'content'  => Template::get_component(
					'hero',
					'content',
					[
						'vertical_align' => 'bottom',
						'pre_heading'    => 'Robotics & Automation',
						'heading'        => 'GBX Tool Changer Module',
						'content'        => '<p>Product code 0033</p>',
					],
				),
			]
		);
		?>
		<br /><br />

		<?php
		Template::render_component(
			'hero',
			null,
			[
				'image_id' => 103,
				'layout'   => 'narrow',
				'content'  => Template::get_component(
					'hero',
					'content',
					[
						'pre_heading' => 'Robotics & Automation',
						'heading'     => 'Any Robot. Many Tasks.',
						'content'     => '<p>World class motion and robotic technologies for mission critical applications.</p>' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Discover',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'secondary-dark',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Watch Video',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary-dark',
											],
										),
								],
							),
					],
				),
			],
		);
		?>

		<br /><br />

		<?php
		Template::render_component(
			'hero',
			null,
			[
				'image_id' => 103,
				'layout'   => 'narrow',
				'height'   => 'large',
				'content'  => Template::get_component(
					'hero',
					'content',
					[
						'pre_heading' => 'Robotics & Automation',
						'heading'     => 'Any Robot. Many Tasks.',
						'content'     => '<p>World class motion and robotic technologies for mission critical applications.</p>' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Discover',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'secondary-dark',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Watch Video',
												'icon'    => true,
												'url'     => '#',
												'variant' => 'primary-dark',
											],
										),
								]
							),
					],
				),
			]
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Media Text Narrow</h2>

		<?php
		Template::render_component(
			'media-text-narrow',
			null,
			[
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content'            => Template::get_component(
					'media-text-narrow',
					'media',
					[
						'content' => Template::get_component(
							'image',
							null,
							[
								'id'   => 21,
								'size' => 'large',
							]
						),
					],
				) .
					Template::get_component(
						'media-text-narrow',
						'content',
						[
							'overline' => 'Industry 01',
							'heading'  => 'Automotive',
							'content'  => '
								<p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos peha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequaue himenaeos elementum vestibulum dui malesuada interrpis euismod.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
							',
						],
					),
			]
		);

		Template::render_component(
			'media-text-narrow',
			null,
			[
				'vertical_align'     => 'top',
				'media_align'        => 'right',
				'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
				'content'            => Template::get_component(
					'media-text-narrow',
					'media',
					[
						'content' => Template::get_component(
							'image',
							null,
							[
								'id'   => 21,
								'size' => 'large',
							]
						),
					],
				) .
					Template::get_component(
						'media-text-narrow',
						'content',
						[
							'overline' => 'Industry 01',
							'heading'  => 'Automotive',
							'content'  => '
								<p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos peha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequaue himenaeos elementum vestibulum dui malesuada interrpis euismod.</p>
								<p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augueaeos magna lobortis soda arius quam vivamles.</p>
							',
						],
					),
			]
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Media Text Cover</h2>

		<?php
		Template::render_component(
			'media-text-cover',
			null,
			[
				'image_id' => 103,
				'heading'  => 'Talk to one of our application engineers',
				'content'  => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Contact us',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								),
						]
					),
			]
		);
		?>

		<?php
		Template::render_component(
			'media-text-cover',
			null,
			[
				'image_id'      => 64,
				'content_align' => 'right',
				'heading'       => 'Talk to one of our application engineers',
				'content'       => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Contact us',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								),
						]
					),
			]
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: SVG</h2>
		<div>
			<?php
			// SVG Component.
			Template::render_component(
				'svg',
				null,
				[ 'name' => 'arrow-right' ],
			);
			?>
		</div>

		<br /><hr /><br />

		<h2>Image Component</h2>
		<div>
			<?php
			// Image Component.
			Template::render_component(
				'image',
				null,
				[ 'id' => false ],
			);
			?>
		</div>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Info Box</h2>

		<?php
		// Image Component.
		Template::render_component(
			'info-box',
			null,
			[
				'heading'    => 'Frequently viewed',
				'list_items' => '<li class="info-box__list-item "><a href="#">Everest S Command Reference Manual</a></li><li class="info-box__list-item "><a href="#">Everest S XCR Command Reference Manual</a></li><li class="info-box__list-item "><a href="#">Everest S NET Product Manual</a></li><li class="info-box__list-item "><a href="#">Everest S XCR Product Manualv</a></li><li class="info-box__list-item "><a href="#">Communication using SDO</a></li><li class="info-box__list-item "><a href="#">Denali Product Manual</a></li>',
			],
		);
		?>

		<br /><hr /><br />

		<?php
		// Image Component.
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Media Text',
				'description'       => '',
				'heading_alignment' => 'center',
				'content'           => Template::get_component(
					'media-text',
					null,
					[
						'image_id' => 21,
						'content'  => '
								<h2 class="has-xxx-large-font-size">Fill Out an Application Worksheet</h2>
								<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
							' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'About us',
												'icon'    => true,
												'url'     => '#',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Talk to an expert',
												'icon'    => false,
												'url'     => '#',
												'variant' => 'secondary',
											],
										),
								]
							),
					],
				),
			],
		);
		?>

		<?php
		// Image Component.
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Media Text',
				'description'       => '',
				'heading_alignment' => 'center',
				'content'           => Template::get_component(
					'media-text',
					null,
					[
						'image_id'         => 21,
						'background_color' => 'secondary',
						'content'          => '
								<h2 class="has-xxx-large-font-size">Fill Out an Application Worksheet</h2>
								<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
							' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'About us',
												'icon'    => true,
												'url'     => '#',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Talk to an expert',
												'icon'    => false,
												'url'     => '#',
												'variant' => 'secondary',
											],
										),
								]
							),
					],
				),
			],
		);
		?>

		<?php
		// Image Component.
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Media Text',
				'description'       => '',
				'heading_alignment' => 'center',
				'content'           => Template::get_component(
					'media-text',
					null,
					[
						'image_id'         => 21,
						'background_color' => 'secondary',
						'media_align'      => 'right',
						'content'          => '
								<h2 class="has-xxx-large-font-size">Fill Out an Application Worksheet</h2>
								<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
							' .
							Template::get_component(
								'buttons',
								null,
								[
									'content' =>
									// Primary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'About us',
												'icon'    => true,
												'url'     => '#',
											],
										) .
										// Secondary Button.
										Template::get_component(
											'button',
											null,
											[
												'content' => 'Talk to an expert',
												'icon'    => false,
												'url'     => '#',
												'variant' => 'secondary',
											],
										),
								]
							),
					],
				),
			],
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Image Text</h2>
		<?php
		// Image Text Component.
		Template::render_component(
			'section',
			null,
			[
				'heading'          => 'View our other industry sectors',
				'hasDescription'   => false,
				'headingAlignment' => 'center',
				'content'          => Template::get_component(
					'cards',
					'image-text',
					array(
						'cards_content' =>
						'<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
						<figure class="image-tile__image-wrap">
						<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
						</figure>
						<div class="image-tile__content">
						<p class="image-tile__pre_heading has-tiny-font-size">Industry 01</p>
						<h3 class="image-tile__heading has-large-font-size">
							<span class="image-tile__heading-text">Electronics</span>
							<svg width="8" height="12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 10.59 4.58 6 0 1.41 1.41 0l6 6-6 6L0 10.59z" fill="currentColor"/>
							</svg>
						</h3>
						</div>
						<a href="#" class="stretched-link image-tile__link" aria-label="Electronics" tabindex="0" >Electronics</a>
						</div>
						<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
							<figure class="image-tile__image-wrap">
							<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
							</figure>
							<div class="image-tile__content">
							<p class="image-tile__pre_heading has-tiny-font-size">Industry 02</p>
							<h3 class="image-tile__heading has-large-font-size">
								<span class="image-tile__heading-text">Construction</span>
							</h3>
							</div>
						</div>
						<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
							<figure class="image-tile__image-wrap">
							<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
							</figure>
							<div class="image-tile__content">
							<p class="image-tile__pre_heading has-tiny-font-size">Industry 03</p>
							<h3 class="image-tile__heading has-large-font-size">
								<span class="image-tile__heading-text">Computer Science</span>
								<svg width="8" height="12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 10.59 4.58 6 0 1.41 1.41 0l6 6-6 6L0 10.59z" fill="currentColor"/>
								</svg>
							</h3>
							</div>
							<a href="#" class="stretched-link image-tile__link" aria-label="Computer Science" tabindex="0" >Computer Science</a>
						</div>
						<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
							<figure class="image-tile__image-wrap">
							<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
							</figure>
							<div class="image-tile__content">
							<p class="image-tile__pre_heading has-tiny-font-size">Industry 04</p>
							<h3 class="image-tile__heading has-large-font-size">
								<span class="image-tile__heading-text">Automotive</span>
							</h3>
							</div>
						</div>
						<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
							<figure class="image-tile__image-wrap">
							<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
							</figure>
							<div class="image-tile__content">
							<p class="image-tile__pre_heading has-tiny-font-size">Industry 05</p>
							<h3 class="image-tile__heading has-large-font-size">
								<span class="image-tile__heading-text">Healthcare</span>
							</h3>
							</div>
						</div>
						<div class="image-tile wp-block-one-novanta-image-tile image-tile image-tile--three-two">
							<figure class="image-tile__image-wrap">
							<img width="800" height="520" src="https://placehold.co/800x520" class="attachment-text-card size-text-card" alt="" />
							</figure>
							<div class="image-tile__content">
							<p class="image-tile__pre_heading has-tiny-font-size">Industry 06</p>
							<h3 class="image-tile__heading has-large-font-size">
								<span class="image-tile__heading-text">Space</span>
								<svg width="8" height="12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 10.59 4.58 6 0 1.41 1.41 0l6 6-6 6L0 10.59z" fill="currentColor"/>
								</svg>
							</h3>
							</div>
							<a href="#" class="stretched-link image-tile__link" aria-label="Space" tabindex="0" >Space</a>
						</div>',
					),
				),
			]
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Tile Carousel</h2>
		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Component: Tiles Carousel',
				'has_description'   => false,
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'tile-carousel',
					null,
					array(
						'heading' => 'View our other industry sectors',
						'content' => render_tiles(
							array(
								array(
									'preHeading' => 'Industry 01',
									'heading'    => 'Electronics',
									'imageID'    => 99999,
									'link'       => 'google.com',
								),
								array(
									'preHeading' => 'Industry 02',
									'heading'    => 'Construction',
									'imageID'    => 99999,
									'link'       => 'google.com',
								),
								array(
									'preHeading' => 'Industry 03',
									'heading'    => 'Computer Science',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 04',
									'heading'    => 'Automotive',
									'imageID'    => 99999,
									'link'       => 'google.com',
								),
								array(
									'preHeading' => 'Industry 05',
									'heading'    => 'Healthcare',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 06',
									'heading'    => 'Energy',
									'link'       => 'google.com',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 07',
									'link'       => 'google.com',
									'heading'    => 'Agriculture',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 08',
									'link'       => 'google.com',
									'heading'    => 'Retail',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 09',
									'heading'    => 'Finance',
									'imageID'    => 99999,
								),
								array(
									'preHeading' => 'Industry 10',
									'heading'    => 'Telecommunications',
									'imageID'    => 99999,
									'link'       => 'google.com',
								),
							),
						),
					),
				),
			]
		);

		Template::render_component(
			'section',
			null,
			[
				'heading'          => 'Component: Tiles (Variation one white background)',
				'description'      => '',
				'headingAlignment' => 'center',
				'backgroundColor'  => 'background',
				'content'          => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 4,
						'content'      => Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'secondary',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'secondary',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'secondary',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'secondary',
							],
						),
					],
				),
			],
		);

		Template::render_component(
			'section',
			null,
			[
				'heading'          => 'Component: Tiles (Variation one gray background)',
				'description'      => '',
				'headingAlignment' => 'center',
				'backgroundColor'  => 'secondary',
				'content'          => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 4,
						'content'      => Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'background',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'background',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'background',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'subheading'       => 'Automatic/Robotic',
								'url'              => '#',
								'background_color' => 'background',
							],
						),
					],
				),
			],
		);

		Template::render_component(
			'section',
			null,
			[
				'heading'          => 'Component: Tiles (Variation two white background)',
				'description'      => '',
				'headingAlignment' => 'center',
				'backgroundColor'  => 'background',
				'content'          => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 3,
						'content'      => Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'secondary',
								'size'             => 'large',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'secondary',
								'size'             => 'large',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 1478,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'secondary',
								'size'             => 'large',
							],
						),
					],
				),
			],
		);

		Template::render_component(
			'section',
			null,
			[
				'heading'          => 'Component: Tiles (Variation two gray background)',
				'description'      => '',
				'headingAlignment' => 'center',
				'backgroundColor'  => 'secondary',
				'content'          => Template::get_component(
					'grid',
					null,
					[
						'column_count' => 3,
						'content'      => Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 89,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'background',
								'size'             => 'large',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 89,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'background',
								'size'             => 'large',
							],
						) . Template::get_component(
							'tile',
							null,
							[
								'image_id'         => 89,
								'heading'          => 'Tool changers',
								'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								'has_description'  => true,
								'url'              => '#',
								'background_color' => 'background',
								'size'             => 'large',
							],
						),
					],
				),
			],
		);
		?>

		<?php
		Template::render_component(
			'section',
			null,
			[
				'heading'           => 'Listing Cards',
				'description'       => '',
				'heading_alignment' => 'center',
				'background_color'  => 'background',
				'content'           => Template::get_component(
					'grid',
					null,
					[
						'gap'          => 'none',
						'column_count' => 2,
						'content'      => Template::get_component(
							'cards',
							'listing',
							[
								'image_id' => 21,
								'content'  => '
										<h3>High Rigidity</h3>
										<p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
									',
							],
						) .
							Template::get_component(
								'cards',
								'listing',
								[
									'image_id' => 21,
									'content'  => '
										<h3>High Rigidity</h3>
										<p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
									',
								],
							),
					],
				),
			],
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Collage</h2>
		<?php
		// Collage Component.
		Template::render_component(
			'collage',
			null,
			array(
				'content' => array(
					array(
						'pre_heading' => 'Industry 01',
						'heading'     => 'Electronics',
						'link'        => 'google.com',
						'image_id'    => 99999,
					),
					array(
						'pre_heading' => 'Industry 02',
						'heading'     => 'Construction',
						'image_id'    => 99999,
					),
					array(
						'pre_heading' => 'Industry 03',
						'heading'     => 'Computer Science',
						'image_id'    => 99999,
					),
					array(
						'pre_heading' => 'Industry 04',
						'heading'     => 'Automotive',
						'image_id'    => 99999,
					),
					array(
						'pre_heading' => 'Industry 05',
						'heading'     => 'Healthcare',
						'image_id'    => 99999,
					),
				),
			),
		);
		?>

		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Tabs</h2>

		<?php
		Template::render_component(
			'tabs',
			null,
			[
				'tabs'          => [
					[
						'id'      => 'tab-features',
						'title'   => 'Features',
						'content' => '<p>Content for the features tab.</p>',
					],
					[
						'id'      => 'tab-specs',
						'title'   => 'Specifications',
						'content' => '<p>Content for the specifications tab.</p>',
					],
					[
						'id'      => 'tab-reviews',
						'title'   => 'Reviews',
						'content' => '<p>Content for the reviews tab.</p>',
					],
				],
				'active_tab_id' => 'tab-reviews',
			]
		);
		?>

		<br /><hr /><br />

		<h2>Accordion</h2>
		<div class="alignwide">
			<?php
			// Accordion Component.
			Template::render_component(
				'accordion',
				null,
				[
					'content' => Template::get_component(
						'accordion',
						'item',
						[
							'title'           => 'Natoque himenaeos',
							'open_by_default' => true,
							'content'         => '<p>Lets users show and hide sections of related content on a page.</p><p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum turpis euismod.</p><p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles. Glatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivlatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam viv.</p>' .
								Template::get_component(
									'button',
									null,
									[
										'content'  => 'Secondary',
										'url'      => '#',
										'icon'     => true,
										'variant'  => 'secondary',
										'disabled' => 'false',
										'wrapper_attributes' => '',
									]
								),
						],
					) . Template::get_component(
						'accordion',
						'item',
						[
							'title'           => 'Accordion component',
							'open_by_default' => true,
							'content'         => '<p>Lets users show and hide sections of related content on a page.</p><p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum turpis euismod.</p><p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles. Glatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivlatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam viv.</p>' .
								Template::get_component(
									'button',
									null,
									[
										'content'  => 'Secondary',
										'url'      => '#',
										'icon'     => true,
										'variant'  => 'secondary',
										'disabled' => 'false',
										'wrapper_attributes' => '',
									]
								),
						],
					) . Template::get_component(
						'accordion',
						'item',
						[
							'title'           => 'Congue cursus ridiculus',
							'open_by_default' => true,
							'content'         => '<p>Lets users show and hide sections of related content on a page.</p><p>Consectetur adipiscing elit, sed do eiusmod tempor didunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nosrbimus himenaeos per ha trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum turpis euismod.</p><p>Cubilia metus tellus cursus suscipit libero nam. Imperdiet platea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivamles. Glatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam vivlatea purus eget iaculis sed elit. Litora mollis natoque molestie finibus elit augue neque. Himenaeos magna lobortis soda arius quam viv.</p>' .
								Template::get_component(
									'button',
									null,
									[
										'content'  => 'Secondary',
										'url'      => '#',
										'icon'     => true,
										'variant'  => 'secondary',
										'disabled' => 'false',
										'wrapper_attributes' => '',
									]
								),
						],
					),
				],
			);
			?>
		</div>

		<br /><hr /><br />
		<h2>Media Cover</h2>

		<?php
		Template::render_component(
			'media-cover',
			null,
			[
				'image_id'      => 64,
				'heading'       => 'Quis nostrud exercitation',
				'content_align' => 'left',
				'content_width' => 'wide',
				'content'       => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Primary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								) .
								// Secondary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Secondary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'secondary-dark',
									],
								),
						]
					),
			]
		);

		Template::render_component(
			'media-cover',
			null,
			[
				'image_id'      => 64,
				'heading'       => 'Quis nostrud exercitation',
				'content_align' => 'right',
				'content_width' => 'wide',
				'content'       => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Primary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								) .
								// Secondary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Secondary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'secondary-dark',
									],
								),
						]
					),
			]
		);

		Template::render_component(
			'media-cover',
			null,
			[
				'image_id'      => 64,
				'heading'       => 'Quis nostrud exercitation',
				'content_align' => 'left',
				'content_width' => 'narrow',
				'content'       => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Primary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								) .
								// Secondary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Secondary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'secondary-dark',
									],
								),
						]
					),
			]
		);

		Template::render_component(
			'media-cover',
			null,
			[
				'image_id'      => 64,
				'heading'       => 'Quis nostrud exercitation',
				'content_align' => 'right',
				'content_width' => 'narrow',
				'content'       => '
									<p>To expedite an educated response, lorem ipsum eleifend aenean dolor bibendum torquent suspendisse. Ico laboris nisi ut aliquip ex ea commodo consequat. Natoque himenaeos elementum vestibulum dui malesuada interdum.</p>
								' .
					Template::get_component(
						'buttons',
						null,
						[
							'content' =>
							// Primary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Primary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'primary-dark',
									],
								) .
								// Secondary Button.
								Template::get_component(
									'button',
									null,
									[
										'content' => 'Secondary',
										'icon'    => true,
										'url'     => '#',
										'variant' => 'secondary-dark',
									],
								),
						]
					),
			]
		);
		?>


		<br /><hr /><br />
		<h2 class="has-text-align-center">Component: Featured Media Slider</h2>
		<?php
		// Featured Media Slider Component.
		Template::render_component(
			'featured-media-slider',
			null,
			array(
				'content' => array(
					array(
						'imageID' => 99999,
						'caption' => 'Lorem ipsum dolor sit amet',
					),
					array(
						'imageID' => 99999,
						'caption' => 'Lorem ipsum dolor sit amet',
					),
					array(
						'imageID' => 99999,
						'caption' => 'Lorem ipsum dolor sit amet',
					),
					array(
						'imageID' => 99999,
						'caption' => 'Lorem ipsum dolor sit amet',
					),
					array(
						'imageID' => 99999,
						'caption' => 'Lorem ipsum dolor sit amet',
					),
				),
			),
		);
		?>

		<br /><hr /><br />

		<h2>Table Component</h2>

		<h3>Variant: Specifications Table, White Background</h3>
		<!-- Three-column table, with a background white. -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers' => [ 'Part Number', 'Value (Metric)', 'Value (Imperial)' ],
					'rows'    => [
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
					],
					'caption' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Variant: Specifications Table, White Gray</h3>
		<!-- Three-column table, with a background secondary (gray). -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers'          => [ 'Part Number', 'Value (Metric)', 'Value (Imperial)' ],
					'rows'             => [
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
						[ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32' ],
					],
					'caption'          => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
					'background_color' => 'secondary',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Variant: Download Table, White Background</h3>
		<!-- Three-column table, with filter and background white. -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers'      => [ 'Download', 'Download Type', 'Language' ],
					'rows'         => [
						[ 'OC-5, OC-11, OC-20, OC-21, OC-27 Installation/Operation Manual', 'Electronic Data Sheet (EDS)', 'English, Chinese' ],
						[ 'ATI Industrial Automation Overview Catalog', 'Catalog', 'English' ],
						[ 'QC-29 Product Flyer', 'Product Flyer', 'English' ],
						[ 'QC-40Q Series Base Tool Changer Manual', 'Manual', 'English' ],
					],
					'filter_by'    => 2,
					'filter_title' => 'Type',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Variant: Download Table, Gray Background</h3>
		<!-- Three-column table, with filter and background secondary (gray). -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers'          => [ 'Download', 'Download Type', 'Language' ],
					'rows'             => [
						[ 'OC-5, OC-11, OC-20, OC-21, OC-27 Installation/Operation Manual', 'Electronic Data Sheet (EDS)', 'English, Chinese' ],
						[ 'ATI Industrial Automation Overview Catalog', 'Catalog', 'English' ],
						[ 'QC-29 Product Flyer', 'Product Flyer', 'English' ],
						[ 'QC-40Q Series Base Tool Changer Manual', 'Manual', 'English' ],
					],
					'background_color' => 'secondary',
					'filter_by'        => 2,
					'filter_title'     => 'Type',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Variant: 3D CAD Table, White Background</h3>
		<!-- Two-column table, with a background white. -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers' => [ 'Download', 'Description' ],
					'rows'    => [
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Tool">QC-46 Tool</a>', 'Lorem ipsum dolor set' ],
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Master-Euro">QC-46 Master-Euro</a>', 'Lorem ipsum dolor set' ],
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Master">QC-46 Master</a>', 'Lorem ipsum dolor set' ],
					],
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Variant: 3D CAD Table, Gray Background</h3>
		<!-- Two-column table, with a background secondary (gray). -->
		<div class="alignwide">
			<?php
			// Table Component.
			Template::render_component(
				'table',
				null,
				[
					'headers'          => [ 'Download', 'Description' ],
					'rows'             => [
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Tool">QC-46 Tool</a>', 'Lorem ipsum dolor set' ],
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Master-Euro">QC-46 Master-Euro</a>', 'Lorem ipsum dolor set' ],
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Master">QC-46 Master</a>', 'Lorem ipsum dolor set' ],
						[ '<a href="https://www.3dcontentcentral.com/Model-Preview-Resp.aspx?catalogId=201&name=QC-46+Master-Euro">QC-46 Master-Euro</a>', 'Lorem ipsum dolor set' ],
					],
					'background_color' => 'secondary',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h2>Compare Model Table</h2>

		<h3>Accessories, White Background</h3>
		<!-- Accessories table, with a background white. -->
		<div class="alignwide">
			<?php
			Template::render_component(
				'compare-model-table',
				null,
				[
					'headers'      => [ 'Part Number', 'Description' ],
					'rows'         => [
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-T', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-T', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-T', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-T', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-T', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ '9120-CV10P-P', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod' ],
						],
					],
					'filter_by'    => 1,
					'filter_title' => 'Type',
				],
			);
			?>
		</div>

		<br /><hr /><br />

		<h3>Quick Compare Models, White Background</h3>
		<!-- Quick Compare Models, with a background white. -->
		<div class="alignwide">
			<?php
			Template::render_component(
				'compare-model-table',
				null,
				[
					'headers'      => [ 'Description', 'Suggested Payload Limit', 'Static Movement Capacity (X & Y)', 'Static Movement Capacity (Z)' ],
					'rows'         => [
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '55 lbs', '500 lbf-in', '800 lbf-in' ],
						],
						[
							'image_id' => 1768,
							'content'  => [ 'Axia Force/Torque Sensors ECAT-AXIA80-M50', '56 lbs', '500 lbf-in', '800 lbf-in' ],
						],
					],
					'filter_by'    => 2,
					'filter_title' => 'Type',
					'variant'      => 'quick-compare-models',
				],
			);
			?>
		</div>

		<div class="alignwide">
			<br /><hr /><br />
			<h2 class="has-text-align-center">Component: Media Lightbox Item 1</h2>
			<?php
			Template::render_component(
				'media-lightbox',
				null,
				[
					'name'             => 'mylightbox',
					'group'            => 'gallery-1',
					'caption'          => 'Image Caption',
					'show_count'       => true,
					'allow_fullscreen' => true,
					'content'          => Template::get_component(
						'image',
						null,
						[
							'id'    => 244,
							'size'  => 'large',
							'class' => 'media-text__lightbox-image',
						]
					),
				]
			);
			?>
			<hr /><br />
			<h2 class="has-text-align-center">Component: Media Lightbox Item 2</h2>
			<?php
			Template::render_component(
				'media-lightbox',
				null,
				[
					'name'             => 'mylightbox',
					'caption'          => 'Image Caption 2',
					'group'            => 'gallery-1',
					'show_count'       => true,
					'allow_fullscreen' => true,
					'content'          => Template::get_component(
						'image',
						null,
						[
							'id'    => 12354,
							'size'  => 'large',
							'class' => 'media-text__lightbox-image',
						]
					),
				]
			);
			?>
			<hr /><br />
			<h2 class="has-text-align-center">Component: Media Lightbox Item 3</h2>
			<?php
			Template::render_component(
				'media-lightbox',
				null,
				[
					'name'             => 'mylightbox',
					'caption'          => 'Image Caption 3',
					'group'            => 'gallery-1',
					'show_count'       => true,
					'allow_fullscreen' => true,
					'content'          => Template::get_component(
						'image',
						null,
						[
							'id'    => 12338,
							'size'  => 'large',
							'class' => 'media-text__lightbox-image',
						]
					),
				]
			);
			?>
			<hr /><br />
			<h2 class="has-text-align-center">Component: Video(Static Thumbnail)</h2>
			<?php
			Template::render_component(
				'video',
				null,
				[
					'video_url'      => 'https://fast.wistia.net/embed/iframe/vgra6n0r88',
					'cover_image_id' => 12338,
					'caption'        => 'Optional video description',
				]
			);
			?>

			<hr /><br />
			<h2 class="has-text-align-center">Component: Video(Dynamic Thumbnail)</h2>
			<?php
			Template::render_component(
				'video',
				null,
				[
					'video_url' => 'https://fast.wistia.net/embed/iframe/26sk4lmiix',
					'caption'   => 'Video Caption',
				]
			);
			?>

			<br /><hr /><br />

			<h2 class="has-text-align-center">Component: Your Quote</h2>

			<div class="alignwide">
				<?php
				Template::render_component( 'your-quote-table' );
				?>
			</div>
		</div>
	</div>

</main>
