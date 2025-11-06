<?php
/**
 * Component Tile Carousel Slide
 *
 * @component Tile Carousel
 * @description Carousel slide component.
 *
 * @group UI Elements
 *
 * @uses components/cards/image-tile
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

?>
<rt-slider-slide class="tile-carousel__slide">
	<?php
	$card_link = $unit_card['link'] ?? '';

	// Check if the link is an array and get the URL.
	if ( is_array( $card_link ) ) {
		$card_link = $unit_card['link']['url'] ?? '';
	}

	Template::render_component(
		'cards',
		'image-tile',
		array(
			'image_ratio'        => $args['imageRatio'] ?? '',
			'link'               => $args['link'] ?? '',
			'heading'            => $args['heading'] ?? '',
			'image_id'           => $args['imageID'] ?? '',
			'pre_heading'        => $args['preHeading'] ?? '',
			'wrapper_attributes' => $args['wrapper_attributes'] ?? '',
			'image_size'         => 'tile-carousel',
		),
	);
	?>
</rt-slider-slide>
