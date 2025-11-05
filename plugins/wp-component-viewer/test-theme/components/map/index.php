<?php
/**
 * Component: Map (No API Key)
 *
 * @component Map
 * @description Responsive Google Maps embed without API key.
 * @group Media & Visuals
 * @props {
 *   "location": {"type": "string", "description": "Place or address query", "required": true},
 *   "height": {"type": "string", "description": "Height of map container", "default": "300px"}
 * }
 * @variations {
 *   "default": {"location": "Taj Mahal, India", "height": "350px"},
 *   "office": {"location": "Googleplex, Mountain View, CA", "height": "400px"}
 * }
 * @extra_allowed_tags {
 *   "iframe": {"src": true, "width": true, "height": true, "style": true, "allowfullscreen": true, "loading": true, "referrerpolicy": true}
 * }
 * @example render_component('map', ['location' => 'Eiffel Tower, Paris', 'height' => '350px']);
 */

$location = rawurlencode( $args['location'] ?? '' );
$height = $args['height'] ?? '300px';

if ( empty( $location ) ) {
	return;
}

// Public embed URL without API key
$src = "https://www.google.com/maps?q={$location}&output=embed";

?>

<div class="map" style="height: <?php echo esc_attr( $height ); ?>; max-width: 100%; overflow: hidden; border-radius: 8px;">
	<iframe
		width="100%"
		height="100%"
		style="border:0"
		loading="lazy"
		allowfullscreen
		referrerpolicy="no-referrer-when-downgrade"
		src="<?php echo esc_url( $src ); ?>">
	</iframe>
</div>
