<?php
/**
 * Component Pricing Toggle
 *
 * @component Pricing Toggle
 * @description A reusable pricing toggle component to switch between monthly and yearly pricing
 * @group Layout
 * @props {
 *   "monthly_label": {
 *     "type": "string",
 *     "description": "Label for monthly option (default: Monthly)"
 *   },
 *   "yearly_label": {
 *     "type": "string", 
 *     "description": "Label for yearly option (default: Yearly)"
 *   },
 *   "default_period": {
 *     "type": "string",
 *     "description": "Default selected period: monthly or yearly (default: monthly)"
 *   },
 *   "show_discount": {
 *     "type": "boolean",
 *     "description": "Show discount badge on yearly option (default: true)"
 *   },
 *   "discount_text": {
 *     "type": "string",
 *     "description": "Discount text to display (default: Save 20%)"
 *   },
 *   "wrapper_class": {
 *     "type": "string",
 *     "description": "Additional CSS classes for wrapper"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Wrapper HTML attributes (optional)"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "monthly_label": "Monthly",
 *     "yearly_label": "Yearly",
 *     "default_period": "monthly",
 *     "show_discount": true,
 *     "discount_text": "Save 20%"
 *   },
 *   "no-discount": {
 *     "monthly_label": "Monthly",
 *     "yearly_label": "Yearly", 
 *     "default_period": "monthly",
 *     "show_discount": false
 *   },
 *   "custom-labels": {
 *     "monthly_label": "Per Month",
 *     "yearly_label": "Per Year",
 *     "default_period": "monthly",
 *     "show_discount": true,
 *     "discount_text": "2 months free"
 *   }
 * }
 * @example render_component('pricing-toggle', [
 *   'monthly_label' => 'Monthly',
 *   'yearly_label' => 'Yearly',
 *   'default_period' => 'monthly',
 *   'show_discount' => true,
 *   'discount_text' => 'Save 20%',
 * ]);
 *
 * @package Components
 */

$monthly_label = $args['monthly_label'] ?? 'Monthly';
$yearly_label = $args['yearly_label'] ?? 'Yearly';
$default_period = $args['default_period'] ?? 'monthly';
$show_discount = $args['show_discount'] ?? true;
$discount_text = $args['discount_text'] ?? 'Save 20%';
$wrapper_class = $args['wrapper_class'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

$is_yearly_default = $default_period === 'yearly';
$unique_id = uniqid('pricing-toggle-');
?>

<div class="pricing-toggle <?php echo esc_attr( $wrapper_class ); ?>" <?php echo wp_kses_data( $wrapper_attributes ); ?> data-toggle-id="<?php echo esc_attr( $unique_id ); ?>">
	<div class="pricing-toggle__wrapper">
		<div class="pricing-toggle__container">
			<!-- Monthly Option -->
			<button 
				type="button"
				class="pricing-toggle__option <?php echo $is_yearly_default ? '' : 'pricing-toggle__option--active'; ?>"
				data-period="monthly"
				aria-pressed="<?php echo $is_yearly_default ? 'false' : 'true'; ?>"
			>
				<span class="pricing-toggle__label">
					<?php echo esc_html( $monthly_label ); ?>
				</span>
			</button>

			<!-- Yearly Option -->
			<button 
				type="button"
				class="pricing-toggle__option <?php echo $is_yearly_default ? 'pricing-toggle__option--active' : ''; ?>"
				data-period="yearly"
				aria-pressed="<?php echo $is_yearly_default ? 'true' : 'false'; ?>"
			>
				<span class="pricing-toggle__label">
					<?php echo esc_html( $yearly_label ); ?>
					<?php if ( $show_discount && $discount_text ) : ?>
						<span class="pricing-toggle__discount"><?php echo esc_html( $discount_text ); ?></span>
					<?php endif; ?>
				</span>
			</button>

			<!-- Toggle Slider -->
			<div class="pricing-toggle__slider <?php echo $is_yearly_default ? 'pricing-toggle__slider--yearly' : ''; ?>"></div>
		</div>
	</div>
</div>