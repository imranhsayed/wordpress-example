<?php
/**
 * Component Featured Media Slider
 *
 * @component Featured Media Slider
 * @description A reusable Slider component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "array", "required": true, "description": "List of Images with caption"},
 * }
 * @variations {}
 * @default {
 *      'content' => [],
 * }
 * @example Template::render_component(
 *     'featured-media-slider',
 *     'null',
 *     [
 *      'content' => [
 *              [
 *                  'imageID'   => 1,
 *                  'caption'   => 'Lorem ipsum dolor sit amet',
 *              ]
 *          ]
 *      ]
 * );
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Check if the arguments are missing, then return early.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? array();
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return early if no image present.
if ( empty( $content ) ) {
	return;
}

// Extra attributes.
$extra_attributes = array(
	'class' => array( 'featured-media-slider', 'alignfull' ),
);

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<div class="featured-media-slider__content">
		<rt-slider behavior="slide" class="featured-media-slider__slider">
			<rt-slider-track class="featured-media-slider__track">
				<rt-slider-slides class="featured-media-slider__slides">
					<?php
					foreach ( $content as $unit_image_meta ) {
						?>
						<rt-slider-slide class="featured-media-slider__slide">
							<?php
							Template::render_component(
								'image',
								null,
								array(
									'size' => 'image-large',
									'id'   => $unit_image_meta['imageID'] ?? 0,
								),
							);

							if ( ! empty( $unit_image_meta['caption'] ) ) {
								?>
								<p class="featured-media-slider__caption"><?php echo esc_html( $unit_image_meta['caption'] ); ?></p>
								<?php
							}
							?>
						</rt-slider-slide>
						<?php
					}
					?>
				</rt-slider-slides>
			</rt-slider-track>
			<?php if ( is_array( $content ) && count( $content ) > 1 ) { ?>
			<div class="featured-media-slider__navigation">
				<rt-slider-arrow direction="previous" class="featured-media-slider-arrow featured-media-slider-arrow--previous">
					<button class="arrow-btn featured-media-slider-arrow-button" tabindex="0" aria-label="<?php esc_attr_e( 'Previous slide', 'one-novanta-theme' ); ?>">
						<?php
						// SVG Component.
						Template::render_component(
							'svg',
							null,
							array( 'name' => 'arrow-right-full' ),
						);
						?>
					</button>
				</rt-slider-arrow>
				<rt-slider-arrow direction="next" class="featured-media-slider-arrow featured-media-slider-arrow--next">
					<button class="arrow-btn featured-media-slider-arrow-button" tabindex="0" aria-label="<?php esc_attr_e( 'Next slide', 'one-novanta-theme' ); ?>">					
						<?php
						// SVG Component.
						Template::render_component(
							'svg',
							null,
							array( 'name' => 'arrow-right-full' ),
						);
						?>
					</button>
				</rt-slider-arrow>
			</div>
			<?php } ?>
		</rt-slider>
	</div>
</div>
