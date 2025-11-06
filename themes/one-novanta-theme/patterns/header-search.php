<?php
/**
 * Pattern Header search
 *
 * Title: Header search
 * Slug: one-novanta-theme/header-search
 * Description: Header search pattern.
 * Categories: header search
 * Keywords: header-search
 * Viewport Width: 1280
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

use OneNovanta\Controllers\Common\Template;
?>

<?php
	// Primary Button with URL.
	$markup = Template::get_component(
		'svg',
		null,
		[ 'name' => 'search' ],
	);

	if ( ! is_string( $markup ) ) {
		return;
	}
	?>

<!-- wp:one-novanta/simple-content {"content": "<?php echo str_replace( '"', "'", $markup ); // phpcs:ignore ?>"} /-->
