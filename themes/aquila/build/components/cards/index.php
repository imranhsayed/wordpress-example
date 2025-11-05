<?php
/**
 * Component Card
 *
 * @component Card
 * @description A reusable card component.
 * @group UI Elements
 * @props {
 *     "image_id": {"type": "int", "required": true, "description": "Card Image attachment ID"},
 *     "content": {"type": "string", "required": false, "description": "Card content"},
 *     "heading_tag": {"type": "string", "required": false, "description": "Card heading tag. Defaults to h2"},
 *     "heading": {"type": "string", "required": false, "description": "Card heading text"},
 *     "wrapper_attributes": {"type": "string", "description": "Card Wrapper attributes (optional)"}
 * }
 * @variations {
 *   "default": {"image_id": 1, "heading": "Extremely High Repeatability", "content": "<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing shows typical repeatability is much better than guaranteed values.</p>"},
 *   "with-h3": {"image_id": 1, "heading": "Innovative Design", "heading_tag": "h3", "content": "<p>Advanced engineering principles combined with modern manufacturing techniques deliver superior performance and reliability.</p>"}
 * }
 * @example render_component(
 *      'card',
 *      null,
 *      [
 *          'image_id' => 21,
 *          'heading'  => 'Extremely High Repeatability',
 *          'content'  => '<p>The piston acts as a large dowel pin, aligning the Master plate and Tool plate with unmatched repeatability. Million-cycle testing, at rated load, shows that the typical repeatability is much better than the guaranteed values.</p>',
 *      ]
 * );
 *
 * @package Aquila\Components
 */

// Import the Template class from the Aquila\Theme\ namespace.
use Aquila\Theme\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$image_id           = $args['image_id'] ?? '';
$heading            = $args['heading'] ?? '';
$heading_tag        = $args['heading_tag'] ?? 'h2';
$content            = $args['content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Return null if the content is empty to prevent further processing.
if ( empty( $image_id ) ) {
	return null;
}

// Extra attributes.
$extra_attributes = [
	'class' => [ 'card' ],
];

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<figure class="card__image">
		<?php
		// Image Component.
		Template::render_component(
			'image',
			null,
			[
				'id'              => $image_id,
				'size'            => [ 400, 220 ],
				'use_focal_point' => true, // Use focal point for the image.
			]
		);
		?>
	</figure>

	<?php if ( ! empty( $heading ) ) { ?>
		<?php printf( '<%1$s class="card__heading has-heading-font-family has-medium-font-size">%2$s</%1$s>', esc_html( $heading_tag ), esc_html( $heading ) ); ?>
	<?php } ?>

	<?php if ( ! empty( $content ) ) { ?>
		<div class="card__content">
			<?php aquila_kses_post_e( $content ); ?>
		</div>
	<?php } ?>
</div>
