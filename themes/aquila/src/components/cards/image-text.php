<?php
/**
 * Component Image Text
 *
 * @component   Image Text
 * @description A reusable card component with multiple image-text card components used inside the content.
 * @group       UI Elements
 * @props {
 *   "cards_content": {"type": "array", "required": true, "description": "List of cards (passed to image-tile component)"},
 * }
 * @variations  {}
 * @example     render_component(
 *     'cards',
 *     'image-text',
 *     [
 *      'cards_content' => [
 *              [
 *                  'preHeading'    => 'Industry 01',
 *                  'heading'       => 'Electronics',
 *                  'imageID'       => '67'
 *              ]
 *          ]
 *      ]
 * );
 *
 * @package Aquila\Components
 */

use Aquila\Theme\Template;

// Check if the arguments are missing, then return early.
if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

// Retrieve attributes from the arguments array, providing default values if not set.
$cards_content      = $args['cards_content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';

// Check if the cards_content is empty and return early.
if ( empty( $cards_content ) ) {
	return;
}

// Extra attributes.
$extra_attributes = array(
	'class' => array( 'image-text', 'alignfull' ),
);

// Combine extra attributes into wrapper attributes.
$wrapper_attributes = aquila_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );

?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> >
	<div class="image-text__content">
		<?php
		/**
		 * Pass the card content to the grid component.
		 * Section component will be used in pattern.
		 */
		Template::render_component(
			'grid',
			'index',
			array(
				'column_count' => 4,
				'content'      => $cards_content,
			)
		);
		?>
	</div>
</div>
