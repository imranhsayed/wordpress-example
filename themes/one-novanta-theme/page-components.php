<?php
/**
 * Components Page
 *
 * @package OneNovantaTheme
 */

use OneNovanta\Controllers\Common\Template;

// Header.
get_header();
?>

	<main class="wp-block-group is-layout-constrained wp-block-group-is-layout-constrained">
		<div class="entry-content alignfull wp-block-post-content is-layout-constrained wp-block-post-content-is-layout-constrained">

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

			<br /><hr />
			<h2 class="has-text-align-center">Component: Media Text</h2>

			<?php
			Template::render_component(
				'media-text',
				null,
				[
					'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
					'content'            => Template::get_component(
						'media-text',
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
						'media-text',
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
											'icon'    => false,
											'url'     => '#',
											'variant' => 'secondary',
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
										],
									),
								]
							),
						],
					),
				]
			);

			Template::render_component(
				'media-text',
				null,
				[
					'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ 'alignwide' ] ] ),
					'media_align'        => 'right',
					'content'            => Template::get_component(
						'media-text',
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
						'media-text',
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
											'icon'    => false,
											'url'     => '#',
											'variant' => 'secondary',
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
										],
									),
								]
							),
						],
					),
				]
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
			<h2 class="has-text-align-center">Component: Card</h2>

			<?php
			Template::render_component(
				'card',
				null,
				[
					'image_id'    => 21,
					'heading'     => 'Extremely High Repeatability',
					'heading_tag' => 'h4',
					'content'     => '<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing, at rated load, shows that the typical repeatability is much better than the guaranteed values.</p>',
				],
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

			<h2>Accordion</h2>
			<div class="alignwide">
				<?php
				// Image Component.
				Template::render_component(
					'accordion',
					null,
					array(
						'data' => [
							[
								'heading'         => 'Natoque himenaeos',
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
								'open_by_default' => true,
							],
							[
								'heading'         => 'Accordion component',
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
								'open_by_default' => true,
							],
							[
								'heading'         => 'Congue cursus ridiculus',
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
								'open_by_default' => true,
							],
						],
					),
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
						'list_items' => [
							[
								'link' => '#',
								'text' => 'Everest S Command Reference Manual',
							],
							[
								'link' => '#',
								'text' => 'Everest S XCR Command Reference Manual',
							],
							[
								'link' => '#',
								'text' => 'Everest S NET Product Manual',
							],
							[
								'link' => '#',
								'text' => 'Everest S XCR Product Manual',
							],
							[
								'link' => '#',
								'text' => 'Communication using SDO',
							],
							[
								'link' => '#',
								'text' => 'Denali Product Manual',
							],
						],
					],
				);
				?>

			<br /><hr /><br />

			<h2>Section</h2>
			<?php
			// Image Component.
			Template::render_component(
				'section',
				null,
				[
					'heading'           => 'Heading...',
					'description'       => 'Description...',
					'heading_alignment' => 'center',
					'content'           => Template::get_component(
						'media-text',
						null,
						[
							'content' => Template::get_component(
								'media-text',
								'media',
								[
									'content' => Template::get_component(
										'image',
										null,
										[
											'id'   => 1949,
											'size' => 'large',
										],
									),
								],
							) .
								Template::get_component(
									'media-text',
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
											],
										),
									],
								),
						],
					),
				],
			);
			?>

			<?php
			// Component: Tiles.
			Template::render_component(
				'section',
				null,
				[
					'heading'           => 'Component: Tiles (Variation white background)',
					'description'       => '',
					'heading_alignment' => 'center',
					'background_color'  => 'background',
					'content'           => Template::get_component(
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

			// Component: Tiles.
			Template::render_component(
				'section',
				null,
				[
					'heading'           => 'Component: Tiles (Variation white background)',
					'description'       => '',
					'heading_alignment' => 'center',
					'background_color'  => 'secondary',
					'content'           => Template::get_component(
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
			?>

			<br /><hr /><br />
			<h2 class="has-text-align-center">Component: Image Text</h2>
			<?php
			// Image Text Component.
			Template::render_component(
				'cards',
				'image-text',
				array(
					'heading'          => 'View our other industry sectors',
					'background_color' => 'secondary',
					'cards_content'    => array(
						array(
							'pre_heading' => 'Industry 01',
							'heading'     => 'Electronics',
							'link'        => 'google.com',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 02',
							'heading'     => 'Construction',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 03',
							'heading'     => 'Computer Science',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 04',
							'heading'     => 'Automotive',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 05',
							'heading'     => 'Healthcare',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 06',
							'heading'     => 'Energy',
							'image_id'    => '67',
						),
					),
				),
			);
			?>

			<br /><hr /><br />
			<h2 class="has-text-align-center">Component: Tile Carousel</h2>
			<?php
			Template::render_component(
				'tile-carousel',
				null,
				array(
					'heading' => 'View our other industry sectors',
					'content' => array(
						array(
							'pre_heading' => 'Industry 01',
							'heading'     => 'Electronics',
							'image_id'    => 67,
							'link'        => 'google.com',
						),
						array(
							'pre_heading' => 'Industry 02',
							'heading'     => 'Construction',
							'image_id'    => 142,
							'link'        => 'google.com',
						),
						array(
							'pre_heading' => 'Industry 03',
							'heading'     => 'Computer Science',
							'image_id'    => 78,
						),
						array(
							'pre_heading' => 'Industry 04',
							'heading'     => 'Automotive',
							'image_id'    => 134,
							'link'        => 'google.com',
						),
						array(
							'pre_heading' => 'Industry 05',
							'heading'     => 'Healthcare',
							'image_id'    => 126,
						),
						array(
							'pre_heading' => 'Industry 06',
							'heading'     => 'Energy',
							'link'        => 'google.com',
							'image_id'    => 118,
						),
						array(
							'pre_heading' => 'Industry 07',
							'link'        => 'google.com',
							'heading'     => 'Agriculture',
							'image_id'    => 110,
						),
						array(
							'pre_heading' => 'Industry 08',
							'link'        => 'google.com',
							'heading'     => 'Retail',
							'image_id'    => 102,
						),
						array(
							'pre_heading' => 'Industry 09',
							'heading'     => 'Finance',
							'image_id'    => 94,
						),
						array(
							'pre_heading' => 'Industry 10',
							'heading'     => 'Telecommunications',
							'image_id'    => 86,
							'link'        => 'google.com',
						),
					),
				),
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
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 02',
							'heading'     => 'Construction',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 03',
							'heading'     => 'Computer Science',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 04',
							'heading'     => 'Automotive',
							'image_id'    => '67',
						),
						array(
							'pre_heading' => 'Industry 05',
							'heading'     => 'Healthcare',
							'image_id'    => '67',
						),
					),
				),
			);
			?>
		</div>
	</main>

<?php

// Footer.
get_footer();
