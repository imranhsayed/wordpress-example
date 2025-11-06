<?php
/**
 * Component Collage
 *
 * @component   Collage
 * @description A reusable Collage component with a multiple image-tile card components used inside the content.
 * @group       UI Elements
 * @props {
 *   "content": {"type": "array", "required": true, "description": "List of cards (passed to image-tile component)"},
 * }
 * @variations  {}
 * @defaults {
 *      "content" => []
 * }
 * @example     render_component(
 *     'collage',
 *     null,
 *     [
 *      'content' => [
 *              [
 *                  'pre_heading'   => 'Industry 01',
 *                  'heading'       => 'Electronics',
 *                  'image_id'      => '67'
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

// Return early if content is empty.
if ( empty( $content ) ) {
	return;
}

// Extra attributes.
$extra_attributes = array(
	'class' => array( 'component-collage' ),
);


// Combine extra attributes into wrapper attributes.
$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );

?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<?php
	foreach ( $content as $unit_content ) {
		Template::render_component(
			'cards',
			'image-tile',
			array(
				'image_ratio' => '3:2',
				'image_size'  => 'large',
				'link'        => $unit_content['link'] ?? '',
				'heading'     => $unit_content['heading'] ?? '',
				'image_id'    => $unit_content['image_id'] ?? '',
				'pre_heading' => $unit_content['pre_heading'] ?? '',
			),
		);
	}
	?>
</div>
