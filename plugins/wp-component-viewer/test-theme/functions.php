<?php
add_action('wp_enqueue_scripts', 'test_theme_enqueue_styles');

function test_theme_enqueue_styles() {
	wp_enqueue_style(
		'test-theme-style',
		get_stylesheet_uri(), // This loads style.css from the theme root
		array(),
		wp_get_theme()->get('Version')
	);
}
