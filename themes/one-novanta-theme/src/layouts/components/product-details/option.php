<?php
/**
 * Product options
 *
 * @package OneNovantaTheme\Blocks
 */

// Retrieve attributes from the arguments array, providing default values if not set.
$select_id = $args['select_id'] ?? '';
$name      = $args['name'] ?? '';
$label     = $args['label'] ?? '';
$options   = $args['options'] ?? [];

// Return null if the name is empty to prevent further processing.
if ( empty( $name ) ) {
	return null;
}
?>

<div class="product-details__option">
	<label class="product-details__option-label" for="<?php echo esc_attr( $select_id ); ?>">
		<?php echo esc_html( $label ); ?>
	</label>
	<select class="product-details__option-select" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $select_id ); ?>">
		<option value=""><?php echo esc_html__( 'Please select', 'one-novanta-theme' ); ?></option>
		<?php foreach ( $options as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>">
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>
