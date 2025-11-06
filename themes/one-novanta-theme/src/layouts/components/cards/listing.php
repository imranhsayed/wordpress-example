<?php
/**
 * Component Listing Card
 *
 * @component Listing Card
 * @description A reusable listing-card component with content.
 * @group UI Elements
 * @props {
 *   "image_id": {"type": "int", "required": true, "description": "Listing Card Image attachment ID"},
 *   "content": {"type": "string", "required": false, "description": "Listing Card content"},
 * }
 * @variations {}
 * @example get_component(
 *     'cards',
 *     'listing',
 *     [
 *         'image_id' => 21,
 *         'content'  => '
 *             <h3>High Rigidity</h3>
 *             <p>ATI Material Removal Tools offer integrated compliance for consistent, repeatable processing, and can be easily programmed and mounted for various operations using durable pneumatic or electric motors.</p>
 *         ',
 *     ],
 * );
 *
 * @package OneNovantaTheme\Components
 */

// Import the Template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? '';
$content            = $args['content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $image_id ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'listing-card' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >

	<figure class="listing-card__image-wrap">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'              => $image_id,
				'size'            => 'large',
				'use_focal_point' => true, // Use focal point for the image.
			]
		);
		?>
	</figure>

	<?php if ( ! empty( $content ) ) { ?>
		<div class="listing-card__content">
			<?php one_novanta_kses_post_e( $content ); ?>
		</div>
	<?php } ?>
</div>
