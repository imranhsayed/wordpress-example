<?php
/**
 * Component Your Quote Table
 *
 * @component Your Quote Table
 * @description A reusable your-quote table component
 * @group UI Elements
 * @props {
 *   "wrapper_attributes": { "type": "string", "require": false, "description": "Component's wrapper attributes." }
 * }
 *
 * @example render_component('your-quote-table');
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Return if required arguments are not available.
if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

// Default values.
$defaults = [
	'wrapper_attributes' => '',
];

// Merge arguments with defaults.
$args = wp_parse_args( $args, $defaults );

$current_language = \Novanta\Multilingual\get_current_language();

// Destruct arguments.
$wrapper_attributes = is_string( $args['wrapper_attributes'] ) ? $args['wrapper_attributes'] : $defaults['wrapper_attributes'];

// Base table class.
$base_class = 'wp-one-novanta-your-quote-table';

// Submit your quote form ID.
$form_submit_your_quote_form_id = get_option( 'options_submit_your_quote_form', '' );

// Generate rows dynamically from cart.
global $woocommerce;

if ( empty( $woocommerce ) ) {
	return;
}

// Initialize cart items and table rows.
$items = [];
$rows  = [];

// Fetch cart items.
if ( ! empty( $woocommerce->cart ) ) {
	$items = $woocommerce->cart->get_cart();
}

if ( ! empty( $items ) ) {
	foreach ( $items as $item => $values ) {
		/**
		 * Get Product ID.
		 *
		 * Product ID in Cart will always be in "En".
		 */
		$product_id = $values['data']->get_id();

		// Get translated product ID if available.
		$translated_product_id = \Novanta\Multilingual\get_post_translation( $product_id, $current_language );

		// If a translation exists, use it.
		if ( ! empty( $translated_product_id ) ) {
			$product_id = $translated_product_id;
		}

		// Get product data.
		$product = one_novanta_get_product_data( $product_id );

		if ( empty( $product ) ) {
			continue;
		}

		// Generate row data.
		$row_data = [
			'key'         => $values['key'] ?? '',
			'image_id'    => $product['image_id'],
			'product'     => $product['heading'],
			'part_number' => $product['sku'] ?? '',
			'quantity'    => $values['quantity'] ?? 1,
			'summary'     => $product['content'],
		];

		// Skip if product or key is empty.
		if ( empty( $row_data['product'] ) || empty( $row_data['key'] ) ) {
			continue;
		}

		$rows[] = $row_data;
	}
}

// Extra attributes.
$extra_attributes = [
	'class'                          => [ $base_class ],
	'data-row-count'                 => [ strval( count( $rows ) ) ],
	'data-submit-your-quote-form-id' => [ strval( $form_submit_your_quote_form_id ) ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>

	<?php
	// Clear quote button.
	Template::render_component(
		'button',
		null,
		[
			'content'            => __( 'Clear quote', 'one-novanta-theme' ),
			'wrapper_attributes' => one_novanta_get_wrapper_attributes( [ 'class' => [ "{$base_class}__clear-quote" ] ] ),
			'url'                => '#',
		],
	);
	?>

	<div class="<?php echo esc_attr( "{$base_class}__container" ); ?>">
		<div class="<?php echo esc_attr( "{$base_class}__content" ); ?>">
			<table class="<?php echo esc_attr( "{$base_class}__wrapper" ); ?>">

				<thead class="<?php echo esc_attr( "{$base_class}__head" ); ?>">
				<tr class="<?php echo esc_attr( "{$base_class}__head-row" ); ?>">
					<th class="<?php echo esc_attr( "{$base_class}__head-cell {$base_class}__head-image" ); ?>"></th>

					<th class="<?php echo esc_attr( "{$base_class}__head-cell" ); ?>"><?php esc_html_e( 'Product', 'one-novanta-theme' ); ?></th>
					<th class="<?php echo esc_attr( "{$base_class}__head-cell" ); ?>"><?php esc_html_e( 'Summary', 'one-novanta-theme' ); ?></th>
					<th class="<?php echo esc_attr( "{$base_class}__head-cell" ); ?>"><?php esc_html_e( 'Part Number', 'one-novanta-theme' ); ?></th>
					<th class="<?php echo esc_attr( "{$base_class}__head-cell" ); ?>"><?php esc_html_e( 'Quantity', 'one-novanta-theme' ); ?></th>

					<th class="<?php echo esc_attr( "{$base_class}__head-cell {$base_class}__head-cta" ); ?>"></th>
				</tr>
				</thead>

				<tbody class="<?php echo esc_attr( "{$base_class}__body" ); ?>">

				<?php foreach ( $rows as $index => $row ) : ?>

					<tr class="<?php echo esc_attr( "{$base_class}__body-row" ); ?>" data-key="<?php echo esc_attr( $row['key'] ); ?>">
						<td class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-image" ); ?>">
							<?php
							// Image Component.
							Template::render_component(
								'image',
								null,
								[
									'id'   => $row['image_id'] ?? 0,
									'size' => [ 150, 150 ],
								],
							);
							?>
						</td>

						<td
							class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-content {$base_class}__body-content--product" ); ?>"
							data-head="<?php esc_attr_e( 'Product', 'one-novanta-theme' ); ?>"
						><?php one_novanta_kses_post_e( $row['product'] ?? '' ); ?></td>

						<td
							class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-content {$base_class}__body-content--summary" ); ?>"
							data-head="<?php esc_attr_e( 'Summary', 'one-novanta-theme' ); ?>"
						><?php one_novanta_kses_post_e( $row['summary'] ?? '' ); ?></td>

						<td
							class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-content {$base_class}__body-content--part-number" ); ?>"
							data-head="<?php esc_attr_e( 'Part Number', 'one-novanta-theme' ); ?>"
						><?php one_novanta_kses_post_e( $row['part_number'] ); ?></td>

						<td
							class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-content {$base_class}__body-content--quantity" ); ?>"
							data-head="<?php esc_attr_e( 'Quantity', 'one-novanta-theme' ); ?>"
						>
							<div class="<?php echo esc_attr( "{$base_class}__body-content--quantity__input" ); ?>">
								<a href="#" role="button" aria-label="<?php echo esc_attr__( 'Increase quantity', 'one-novanta-theme' ); ?>" class="
									<?php
									echo esc_attr(
										one_novanta_merge_classes(
											[
												"{$base_class}__body-content--quantity__plus",
												'disabled' => intval( $row['quantity'] ) >= 99,
											],
										),
									);
									?>
								">
									<?php
									Template::render_component(
										'svg',
										null,
										[
											'name' => 'arrow-up',
										],
									);
									?>
								</a>
								<input id="<?php echo esc_attr( "{$base_class}__body-content--quantity__input-field-{$index}" ); ?>" class="<?php echo esc_attr( "{$base_class}__body-content--quantity__input-field" ); ?>" type="number" min="1" max="99" value="<?php echo esc_attr( $row['quantity'] ); ?>" aria-label="<?php echo esc_attr__( 'Quantity', 'one-novanta-theme' ); ?>" />
								<a href="#" role="button" aria-label="<?php echo esc_attr__( 'Decrease quantity', 'one-novanta-theme' ); ?>" class="
									<?php
									echo esc_attr(
										one_novanta_merge_classes(
											[
												"{$base_class}__body-content--quantity__minus",
												'disabled' => intval( $row['quantity'] ) <= 1,
											],
										),
									);
									?>
								">
									<?php
									Template::render_component(
										'svg',
										null,
										[
											'name' => 'arrow-down',
										],
									);
									?>
								</a>
							</div>
						</td>

						<td class="<?php echo esc_attr( "{$base_class}__body-cell {$base_class}__body-cta" ); ?>">
							<a href="#"><?php esc_html_e( 'Remove', 'one-novanta-theme' ); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>
		</div>

		<div class="<?php echo esc_attr( "{$base_class}__empty-wrapper" ); ?>">
			<span class="<?php echo esc_attr( "{$base_class}__empty-wrapper__icon" ); ?>">
				<?php
				Template::render_component(
					'svg',
					null,
					[
						'name' => 'product-cart',
					],
				);
				?>
			</span>

			<p class="<?php echo esc_attr( "{$base_class}__empty-wrapper__message" ); ?>"><?php esc_html_e( 'Your quote is currently empty', 'one-novanta-theme' ); ?></p>

			<?php
			Template::render_component(
				'button',
				null,
				[
					'content'            => __( 'Add products', 'one-novanta-theme' ),
					'icon'               => true,
					'url'                => get_post_type_archive_link( 'product' ),
					'wrapper_attributes' => one_novanta_get_wrapper_attributes(
						[
							'class' => [ "{$base_class}__add-product" ],
						],
					),
				],
			);
			?>
		</div>
	</div>
</div>
