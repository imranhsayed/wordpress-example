<?php
/**
 * Component Tile Carousel
 *
 * @component Tile Carousel
 * @description A reusable Carousel component.
 * @group UI Elements
 * @props {
 *   "content": {"type": "string", "required": true, "description": "HTML markup for carousel slides"},
 *   "totalSlides": {"type": "string", "required": false, "description": "Total number of slides"},
 *   "wrapper_attributes": {"type": "string", "required": false, "description": "Additional wrapper attributes"}
 * }
 * @variations {
 *   "default": {
 *     "content": "<rt-slider-slide class=\"tile-carousel__slide\"><div class=\"image-tile\"><a href=\"#\" class=\"image-tile__link\"><div class=\"image-tile__image-wrapper\"><img width=\"400\" height=\"400\" src=\"https://picsum.photos/400/400\" alt=\"Electronics\" class=\"image-tile__image\" /></div><div class=\"image-tile__content\"><span class=\"image-tile__pre-heading\">Industry 01</span><h3 class=\"image-tile__heading\">Electronics</h3></div></a></div></rt-slider-slide><rt-slider-slide class=\"tile-carousel__slide\"><div class=\"image-tile\"><a href=\"#\" class=\"image-tile__link\"><div class=\"image-tile__image-wrapper\"><img width=\"400\" height=\"400\" src=\"https://picsum.photos/400/400\" alt=\"Manufacturing\" class=\"image-tile__image\" /></div><div class=\"image-tile__content\"><span class=\"image-tile__pre-heading\">Industry 02</span><h3 class=\"image-tile__heading\">Manufacturing</h3></div></a></div></rt-slider-slide><rt-slider-slide class=\"tile-carousel__slide\"><div class=\"image-tile\"><a href=\"#\" class=\"image-tile__link\"><div class=\"image-tile__image-wrapper\"><img width=\"400\" height=\"400\" src=\"https://picsum.photos/400/400\" alt=\"Healthcare\" class=\"image-tile__image\" /></div><div class=\"image-tile__content\"><span class=\"image-tile__pre-heading\">Industry 03</span><h3 class=\"image-tile__heading\">Healthcare</h3></div></a></div></rt-slider-slide><rt-slider-slide class=\"tile-carousel__slide\"><div class=\"image-tile\"><a href=\"#\" class=\"image-tile__link\"><div class=\"image-tile__image-wrapper\"><img width=\"400\" height=\"400\" src=\"https://picsum.photos/400/400\" alt=\"Automotive\" class=\"image-tile__image\" /></div><div class=\"image-tile__content\"><span class=\"image-tile__pre-heading\">Industry 04</span><h3 class=\"image-tile__heading\">Automotive</h3></div></a></div></rt-slider-slide>",
 *     "totalSlides": "4",
 *     "wrapper_attributes": ""
 *   }
 * }
 * @extra_allowed_tags {
 *   "rt-slider": {"behavior": true, "class": true, "slides-to-show": true, "total": true, "responsive": true},
 *   "rt-slider-track": {"class": true},
 *   "rt-slider-slides": {"class": true},
 *   "rt-slider-slide": {"class": true},
 *   "rt-slider-arrow": {"direction": true, "class": true}
 * }
 * @default {
 *      'heading'       => '',
 *      'content' => [],
 * }
 * @example     render_component(
 *     'tile-carousel',
 *     'null',
 *     [
 *      'heading' => 'Lorem ipsum dolor sit amet',
 *      'content' => [
 *              [
 *                  'preHeading'    => 'Pre Heading',
 *                  'heading'       => 'Heading',
 *                  'imageID'       => '1'
 *              ]
 *          ]
 *      ]
 * );
 *
 * @package AquilaTheme\Components
 */

use Aquila\Theme\Template;

// Check if the arguments are missing, then return early.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'];
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$total_slides       = $args['totalSlides'] ?? 0;

// Return early if no carousel cards.
if ( empty( $content ) ) {
	return;
}

// Extra attributes.
$extra_attributes = array(
	'class' => array( 'tile-carousel' ),
);

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<div class="tile-carousel__content">
		<rt-slider
			behavior="slide"
			class="tile-carousel__slider"
			slides-to-show="3"
			total="<?php echo esc_attr( $total_slides ); ?>"
			responsive='[{"media": "(max-width: 768px)","slides-to-show": "1"},{"media": "(max-width: 1024px)","slides-to-show": "2"},{"media": "(min-width: 1024px)","slides-to-show": "3"}]'
		>
			<rt-slider-track class="tile-carousel__track">
				<rt-slider-slides class="tile-carousel__slides">
					<?php aquila_kses_post_e( $content ); ?>
				</rt-slider-slides>
			</rt-slider-track>
			<div class="tile-carousel__navigation">
				<rt-slider-arrow direction="previous" class="tile-carousel__navigation-arrow tile-carousel__navigation-arrow--previous">
					<button class="arrow-btn tile-carousel__navigation-arrow-button" tabindex="0" aria-label="<?php esc_attr_e( 'Previous slide', 'one-novanta-theme' ); ?>">
						<?php
						// SVG Component.
						Template::render_component(
							'svg',
							null,
							array( 'name' => 'arrow-right-thin' ),
						);
						?>
					</button>
				</rt-slider-arrow>
				<rt-slider-arrow direction="next" class="tile-carousel__navigation-arrow tile-carousel__navigation-arrow--next">
					<button class="arrow-btn tile-carousel__navigation-arrow-button" tabindex="0" aria-label="<?php esc_attr_e( 'Next slide', 'one-novanta-theme' ); ?>">
						<?php
						// SVG Component.
						Template::render_component(
							'svg',
							null,
							array( 'name' => 'arrow-right-thin' ),
						);
						?>
					</button>
				</rt-slider-arrow>
			</div>
		</rt-slider>
	</div>
</div>
