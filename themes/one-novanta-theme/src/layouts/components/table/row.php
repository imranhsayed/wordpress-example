<?php
/**
 * Component Table Row
 *
 * @component Table Row
 * @description A reusable table row component
 * @group UI Elements
 * @props {
 *   "row": { "type": "array", "required": true, "description": "Table single row." },
 *   "wrapper_attributes": { "type": "string", "require": false, "description": "Component's wrapper attributes." }
 * }
 *
 * @example render_component('table', 'row', [
 *   'row' => [ 'Suggested Payload Limit', '(5) M5 or #10-32', '(5) M5 or #10-32']
 * ]);
 *
 * @package OneNovantaTheme\Components
 */

// Return if required arguments are not available.
if ( empty( $args ) || ! is_array( $args ) || empty( $args['row'] ) ) {
	return;
}

$row                = is_array( $args['row'] ) ? $args['row'] : [];
$wrapper_attributes = ( ! empty( $args['wrapper_attributes'] ) && is_string( $args['wrapper_attributes'] ) ) ? $args['wrapper_attributes'] : '';

// Base table class.
$base_class = 'wp-one-novanta-table';

$extra_attributes = [
	'class' => [ "{$base_class}__body-row" ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<tr <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<?php
	foreach ( $row as $cell ) :

		$decoded = '';

		if ( is_string( $cell ) ) {
			$decoded = json_decode( $cell, true );
		}

		if ( is_array( $decoded ) && array_key_exists( 'title', $decoded ) ) :
			$has_post_date = ! empty( $decoded['post_date'] );
			$has_version   = ! empty( $decoded['version'] );
			?>
			<td class="<?php echo esc_attr( "{$base_class}__body-cell" ); ?>">
				<?php one_novanta_kses_post_e( $decoded['title'] ); ?>

				<?php if ( $has_post_date || $has_version ) : ?>
					<div class="<?php echo esc_attr( "{$base_class}__body-cell-meta-data" ); ?>">
						<?php if ( $has_post_date ) : ?>
						<p class="<?php echo esc_attr( "{$base_class}__body-cell-date" ); ?>">
							<?php _e( 'Uploaded date: ', 'one-novanta-theme' ); ?>
							<span><?php echo esc_html( $decoded['post_date'] ); ?></span>
						</p>
						<?php endif; ?>

						<?php if ( $has_version ) : ?>
							<p class="<?php echo esc_attr( "{$base_class}__body-cell-version" ); ?>">
								<?php _e( 'Version number: ', 'one-novanta-theme' ); ?>
								<span><?php echo esc_html( $decoded['version'] ); ?></span>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</td>
		<?php elseif ( is_string( $cell ) ) : ?>
			<td class="<?php echo esc_attr( "{$base_class}__body-cell" ); ?>">
				<?php one_novanta_kses_post_e( $cell ); ?>
			</td>
		<?php endif; ?>
	<?php endforeach; ?>
</tr>
