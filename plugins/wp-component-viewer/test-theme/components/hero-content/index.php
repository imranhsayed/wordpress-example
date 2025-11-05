<?php
/**
 * Component Hero Content
 *
 * @component Hero Content
 * @description A full-width hero section with heading, subheading, and optional button
 * @group Layout
 * @props {
 *   "title": {
 *     "type": "string",
 *     "required": true,
 *     "description": "Main hero heading"
 *   },
 *   "subtitle": {
 *     "type": "string",
 *     "description": "Hero subheading text"
 *   },
 *   "button_text": {
 *     "type": "string",
 *     "description": "CTA button text"
 *   },
 *   "button_url": {
 *     "type": "string",
 *     "description": "CTA button URL"
 *   },
 *   "align": {
 *     "type": "string",
 *     "default": "center",
 *     "description": "Content alignment: 'center', 'left', 'right'"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "title": "Welcome to Our Site",
 *     "subtitle": "Delivering excellence with every click.",
 *     "button_text": "Learn More",
 *     "button_url": "#"
 *   },
 *   "left-align": {
 *     "title": "We Build Digital Products",
 *     "subtitle": "Custom software, apps, and platforms.",
 *     "align": "left",
 *     "button_text": "Get Started",
 *     "button_url": "/contact"
 *   }
 * }
 * @example render_component('hero-content', [
 *   'title' => 'Join Our Community',
 *   'subtitle' => 'A place where ideas grow.',
 *   'button_text' => 'Sign Up Free',
 *   'button_url' => '/signup'
 * ]);
 *
 * @package Components
 */

if (empty($args['title'])) {
	return;
}

$title              = $args['title'];
$subtitle           = $args['subtitle'] ?? '';
$button_text        = $args['button_text'] ?? '';
$button_url         = $args['button_url'] ?? '';
$align              = $args['align'] ?? 'center';
$wrapper_attributes = $args['wrapper_attributes'] ?? 'class="hero-content-component align-' . esc_attr($align) . '"';
?>

<section <?php echo wp_kses_data($wrapper_attributes); ?>>
	<div class="hero-content-component__inner">
		<h1 class="hero-content-component__title"><?php echo esc_html($title); ?></h1>

		<?php if ($subtitle) : ?>
			<p class="hero-content-component__subtitle"><?php echo esc_html($subtitle); ?></p>
		<?php endif; ?>

		<?php if ($button_text && $button_url) : ?>
			<a href="<?php echo esc_url($button_url); ?>" class="hero-content-component__button">
				<?php echo esc_html($button_text); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
