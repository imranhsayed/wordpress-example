<?php
/**
 * Component Image Tile
 *
 * @component Image Tile
 * @description A reusable unit card component with an image and text as content.
 * @group UI Elements
 * @props {
 *      "image_id": {"type": "int", "required": true, "description": "Cover image"},
 *      "link": {"type": "string", "required": false, "description": "Card link, default to empty string"},
 *      "heading": {"type": "string", "required": true, "description": "Card heading"},
 *      "pre_heading": {"type": "string", "required": true, "description": "Heading text that lies over heading."},
 *      "image_ratio": {"type": "string", "required": false, "description": "Ratio at which image will be rendered. Default to 1:1"},
 *      "image_size": {"type": "string", "required": false, "description": "Image size to be used. Default to thumbnail"},
 * }
 * @variations {}
 * @defaults {
 *      "img" => 0,
 *      "link" => "",
 *      "heading" => "",
 *      "pre_heading" => ""
 *      "image_size" => "thumbnail",
 * }
 * @example render_component(
 *     'cards',
 *     'image-tile',
 *      [
 *          'image_id'      => '1',
 *          'link'          => 'https://<link>.com',
 *          'heading'       => 'Heading',
 *          'pre_heading'   => 'Pre heading',
 *          'image_ratio'   => '16:9',
 *          'image_size'    => 'thumbnail',
 *      ]
 * );
 * @todo based on block response check if link have just url or target too.
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Check if the arguments are missing, then return early.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

$card_link          = $args['link'] ?? '';
$heading            = $args['heading'] ?? '';
$pre_heading        = $args['pre_heading'] ?? '';
$image_ratio        = $args['image_ratio'] ?? '1:1';
$image_size         = $args['image_size'] ?? 'thumbnail';
$image_id           = intval( $args['image_id'] );
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

$extra_classes = array( 'image-tile' );

switch ( $image_ratio ) {
	case '2:1':
		$extra_classes[] = 'image-tile--two-one';
		break;
	case '3:2':
		$extra_classes[] = 'image-tile--three-two';
		break;
	case '16:9':
		$extra_classes[] = 'image-tile--sixteen-nine';
		break;
	default:
		$extra_classes[] = 'image-tile--one-one';
		break;
}

// Extra attributes.
$extra_attributes = array(
	'class' => $extra_classes,
);

// If image not provided return early.
if ( empty( $image_id ) ) {
	return;
}

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<figure class="image-tile__image-wrap">
		<?php
		Template::render_component(
			'image',
			null,
			array(
				'id'              => $image_id,
				'size'            => $image_size,
				'icon'            => false,
				'attr'            => '',
				'use_focal_point' => true, // Use focal point for the image.
			)
		);
		?>
	</figure>

	<div class="image-tile__content">
		<p class="image-tile__pre_heading has-tiny-font-size"><?php echo esc_html( $pre_heading ); ?></p>

		<h3 class="image-tile__heading has-large-font-size">
			<span class="image-tile__heading-text"><?php echo esc_html( $heading ); ?></span>

			<?php
			if ( ! empty( $card_link ) ) {
				// SVG Component.
				Template::render_component(
					'svg',
					null,
					array( 'name' => 'arrow-right' ),
				);
			}
			?>
		</h3>
	</div>

	<?php if ( ! empty( $card_link ) ) : ?>
		<a href="<?php echo esc_url( $card_link ); ?>" class="stretched-link image-tile__link" aria-label="<?php echo esc_attr( $heading ); ?>" tabindex="0" ><?php echo esc_html( $heading ); ?></a>
	<?php endif; ?>
</div>
