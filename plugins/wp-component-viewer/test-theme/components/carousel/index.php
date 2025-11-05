<?php
/**
 * Component Carousel
 *
 * @component Carousel
 * @description A simple image carousel/slider
 * @group Layout
 * @props {
 *   "slides": {
 *     "type": "array",
 *     "required": true,
 *     "description": "Array of slides with 'image_url' and optional 'caption'"
 *   },
 *   "show_dots": {
 *     "type": "boolean",
 *     "description": "Show dot navigation below the carousel"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Wrapper attributes (optional)"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "show_dots": true,
 *     "slides": [
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+1",
 *         "caption": "Slide 1"
 *       },
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+2",
 *         "caption": "Slide 2"
 *       },
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+3",
 *         "caption": "Slide 3"
 *       }
 *     ]
 *   },
 *   "no-dots": {
 *     "show_dots": false,
 *     "slides": [
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+1",
 *         "caption": "Slide 1"
 *       },
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+2",
 *         "caption": "Slide 2"
 *       },
 *       {
 *         "image_url": "https://placehold.co/600x400@2x.png?text=Slide+3",
 *         "caption": "Slide 3"
 *       }
 *     ]
 *   }
 * }
 * @example render_component('carousel', [
 *   'show_dots' => true,
 *   'slides' => [
 *     [
 *       'image_url' => 'https://placehold.co/600x400@2x.png?text=Slide+1',
 *       'caption'   => 'Slide 1'
 *     ],
 *     [
 *       'image_url' => 'https://placehold.co/600x400@2x.png?text=Slide+2',
 *       'caption'   => 'Slide 2'
 *     ]
 *   ]
 * ]);
 *
 * @package Components
 */

if (empty($args) || ! is_array($args) || empty($args['slides'])) {
	return;
}

$slides = $args['slides'];
$show_dots = isset($args['show_dots']) ? (bool) $args['show_dots'] : false;
$wrapper_attributes = ! empty($args['wrapper_attributes']) ? $args['wrapper_attributes'] : 'class="carousel-component"';
?>

<div <?php echo wp_kses_data($wrapper_attributes); ?>>
	<div class="carousel-component__track">
		<?php foreach ($slides as $index => $slide) : ?>
			<div class="carousel-component__slide<?php echo 0 === $index ? ' is-active' : ''; ?>">
				<img src="<?php echo esc_url($slide['image_url']); ?>" alt="Slide <?php echo esc_attr($index + 1); ?>" />
				<?php if (! empty($slide['caption'])) : ?>
					<div class="carousel-component__caption"><?php echo esc_html($slide['caption']); ?></div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<button class="carousel-component__prev" aria-label="Previous Slide">&#10094;</button>
	<button class="carousel-component__next" aria-label="Next Slide">&#10095;</button>

	<?php if ($show_dots) : ?>
		<div class="carousel-component__dots">
			<?php foreach ($slides as $index => $_) : ?>
				<button
					class="carousel-component__dot<?php echo 0 === $index ? ' is-active' : ''; ?>"
					data-index="<?php echo esc_attr($index); ?>"
					aria-label="Slide <?php echo esc_attr($index + 1); ?>">
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
