<?php
/**
 * Component Testimonial Slider
 *
 * @component Testimonial Slider
 * @description An interactive carousel to display testimonials with name, role, and message
 * @group UI Elements
 * @props {
 *   "testimonials": {
 *     "type": "array",
 *     "description": "Array of testimonial data with name, role, and message"
 *   },
 *   "autoplay": {
 *     "type": "boolean",
 *     "default": true,
 *     "description": "Enable auto-slide"
 *   },
 *   "interval": {
 *     "type": "number",
 *     "default": 5000,
 *     "description": "Autoplay interval in milliseconds"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "testimonials": [
 *       {
 *         "name": "Aarav Mehta",
 *         "role": "UI/UX Designer",
 *         "message": "Absolutely love the clean design and user experience!"
 *       },
 *       {
 *         "name": "Divya Kapoor",
 *         "role": "Software Engineer",
 *         "message": "The best testimonial slider I’ve seen on a WP site."
 *       },
 *       {
 *         "name": "Rohit Sharma",
 *         "role": "Project Manager",
 *         "message": "Smooth transitions and elegant styling!"
 *       }
 *     ]
 *   }
 * }
 * @example render_component('testimonial-slider', [
 *   'testimonials' => [
 *     ['name' => 'Anika', 'role' => 'Product Designer', 'message' => 'Brilliant!'],
 *     ['name' => 'Harsh', 'role' => 'Developer Advocate', 'message' => 'Slick and fast!'],
 *   ]
 * ])
 *
 * @package Components
 */

$testimonials = $args['testimonials'] ?? [];
?>

<div class="testimonial-slider js-testimonial-slider">
  <div class="testimonial-slider__viewport">
    <div class="testimonial-slider__track">
      <?php foreach ($testimonials as $testimonial) : ?>
        <div class="testimonial-slider__slide">
          <blockquote>
            <p class="testimonial-slider__message">"<?php echo esc_html($testimonial['message']); ?>"</p>
            <footer class="testimonial-slider__footer">
              — <strong><?php echo esc_html($testimonial['name']); ?></strong>, <span><?php echo esc_html($testimonial['role']); ?></span>
            </footer>
          </blockquote>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="testimonial-slider__nav">
    <button class="testimonial-slider__prev" aria-label="Previous">&larr;</button>
    <button class="testimonial-slider__next" aria-label="Next">&rarr;</button>
  </div>
</div>
