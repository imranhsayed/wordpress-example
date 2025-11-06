<?php
/**
 * Header template for `wp-activate.php`.
 *
 * @package OneNovantaTheme
 */

/*
 * Get the header template HTML.
 * This needs to run before <head> so that blocks can add scripts and styles in wp_head().
 */
$header_template_html = render_block(
	array(
		'blockName' => 'core/template-part',
		'attrs'     => array(
			'slug' => 'header',
		),
	)
);

/*
 * Get the footer template HTML.
 * This needs to run before <head> so that blocks can add scripts and styles in wp_head().
 */
render_block(
	array(
		'blockName' => 'core/template-part',
		'attrs'     => array(
			'slug' => 'footer',
		),
	)
);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php one_novanta_kses_post_e( $header_template_html ); ?>
