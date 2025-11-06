<?php
/**
 * Footer template for `wp-activate.php`.
 *
 * @package OneNovantaTheme
 */

/*
 * Render the footer template HTML.
 */
one_novanta_kses_post_e(
	render_block(
		array(
			'blockName' => 'core/template-part',
			'attrs'     => array(
				'slug' => 'footer',
			),
		)
	)
);
?>
	</body>
</html>
