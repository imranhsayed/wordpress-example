<?php
/**
 * Component: Donation Unit
 *
 * @component Donation Unit
 * @description A donation UI component with selectable amounts and recurring toggle.
 * @group UI Elements
 * @props {
 *   "title": { "type": "string", "description": "Donation title", "required": true },
 *   "description": { "type": "string", "description": "Short supporting text" },
 *   "amounts": { "type": "array", "description": "Preset amounts", "default": [100, 250, 500] },
 *   "recurring": { "type": "boolean", "description": "Show monthly toggle", "default": true },
 *   "button_text": { "type": "string", "description": "Submit button text", "default": "Donate Now" }
 * }
 * @variations {
 *   "default": {
 *     "title": "Support Our Mission",
 *     "description": "Your contribution helps us reach more people in need.",
 *     "amounts": [100, 250, 500, 1000],
 *     "recurring": true,
 *     "button_text": "Donate Now"
 *   }
 * }
 * @extra_allowed_tags {
 *   "button": { "type": true, "class": true },
 *   "input": { "type": true, "name": true, "value": true, "id": true, "checked": true },
 *   "label": { "for": true, "class": true },
 *   "div": { "class": true },
 *   "p": { "class": true }
 * }
 *
 * @example render_component('donation-unit', [
 *   'title' => 'Support Children’s Education',
 *   'description' => 'Your ₹500 can buy books for a child.',
 *   'amounts' => [100, 250, 500],
 *   'recurring' => true,
 *   'button_text' => 'Contribute'
 * ])
 */

$title        = esc_html( $args['title'] ?? 'Donate' );
$description  = esc_html( $args['description'] ?? '' );
$amounts      = $args['amounts'] ?? [ 100, 250, 500 ];
$recurring    = $args['recurring'] ?? true;
$button_text  = esc_html( $args['button_text'] ?? 'Donate Now' );
?>

<div class="donation-unit">
	<h2 class="donation-unit__title"><?php echo $title; ?></h2>

	<?php if ( $description ) : ?>
		<p class="donation-unit__description"><?php echo $description; ?></p>
	<?php endif; ?>

	<div class="donation-unit__amounts">
		<?php foreach ( $amounts as $index => $amount ) : ?>
			<label class="donation-unit__amount-option">
				<input
					type="radio"
					name="donation-amount"
					value="<?php echo esc_attr( $amount ); ?>"
					<?php checked( 0 === $index ); ?>
				/>
				<span>₹<?php echo esc_html( $amount ); ?></span>
			</label>
		<?php endforeach; ?>
	</div>

	<?php if ( $recurring ) : ?>
		<div class="donation-unit__recurring">
			<label>
				<input type="checkbox" name="donation-recurring" />
				Make this a monthly donation
			</label>
		</div>
	<?php endif; ?>

	<div class="donation-unit__submit">
		<button type="button"><?php echo $button_text; ?></button>
	</div>
</div>
