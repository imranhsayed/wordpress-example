<?php
/**
 * Pattern Footer
 *
 * Title: Footer
 * Slug: one-novanta-theme/footer
 * Description: Footer pattern.
 * Categories: footer
 * Keywords: footer
 * Viewport Width: 1280
 * Block Types: core/template-part/footer
 * Post Types: wp_template
 * Inserter: false
 *
 * @package OneNovantaTheme\Patterns
 */

// Logo.
$novanta_logo_white_url     = '';
$novanta_iso_logo_white_url = '';

if ( defined( 'ONE_NOVANTA_THEME_URI' ) ) {
	$novanta_logo_white_url     = trailingslashit( ONE_NOVANTA_THEME_URI ) . 'src/svg/novanta-logo-white.svg';
	$novanta_iso_logo_white_url = trailingslashit( ONE_NOVANTA_THEME_URI ) . 'src/img/ISO-logo.png';
}

?>

<!-- wp:group {"className":"one-novanta-footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"primary","textColor":"background","fontSize":"medium","layout":{"inherit":"true","type":"constrained"}} -->
<div class="wp-block-group one-novanta-footer has-background-color has-primary-background-color has-text-color has-background has-link-color has-medium-font-size" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:image {"width":"245px","sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large is-resized">
			<img src="<?php echo esc_url( $novanta_logo_white_url ); ?>" alt="Novanta" style="width:245px"/>
		</figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","className":"one-novanta-footer__widgets","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns alignwide one-novanta-footer__widgets" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p>World class motion and robotic technologies for mission critical applications.</p>
			<!-- /wp:paragraph -->

			<!-- wp:image {"width":"120px","height":"auto","aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
			<figure class="wp-block-image size-full is-resized" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40)">
				<img src="<?php echo esc_url( $novanta_iso_logo_white_url ); ?>" alt="ISO Certified" style="aspect-ratio:1;object-fit:cover;width:120px;height:auto"/>
			</figure>
			<!-- /wp:image -->

			<!-- wp:paragraph -->
			<p><strong>001 0033 0021<br><br>1031 Goodworth Drive,<br>Apex, NC 27539 USA</strong></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><a href="https://novanta.vipdev.lndo.site/ati/post/70" data-type="page" data-id="70">About Us</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:navigation {"ref":106,"overlayMenu":"never","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"}} /--></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><a href="https://novanta.vipdev.lndo.site/ati/post/74" data-type="page" data-id="74">Industries</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:navigation {"ref":105,"overlayMenu":"never","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"}} /--></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><a href="https://novanta.vipdev.lndo.site/ati/post/72" data-type="page" data-id="72">Capabilities</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:navigation {"ref":107,"overlayMenu":"never","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"}} /--></div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"backgroundColor":"background"} -->
	<hr class="wp-block-separator alignwide has-text-color has-background-color has-alpha-channel-opacity has-background-background-color has-background" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20)"/>
	<!-- /wp:separator -->

	<!-- wp:columns {"align":"wide","className":"one-novanta-footer__bottom-columns","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
	<div class="wp-block-columns alignwide one-novanta-footer__bottom-columns" style="margin-top:0;margin-bottom:0">
		<!-- wp:column {"width":"66.66%"} -->
		<div class="wp-block-column" style="flex-basis:66.66%">
			<!-- wp:navigation {"ref":94,"overlayMenu":"never","className":"one-novanta-footer__quick-links","layout":{"type":"flex","justifyContent":"left","orientation":"horizontal"}} /-->

			<!-- wp:paragraph {"className":"one-novanta-footer__copyright"} -->
			<p class="one-novanta-footer__copyright">
				<?php
				printf(
					/* translators: %s: current year */
					esc_html__( '&copy; %s Novanta Inc. All Rights Reserved.', 'one-novanta-theme' ),
					gmdate( 'Y' ) // phpcs:ignore -- WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				?>
				</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"33.33%","className":"one-novanta-footer__social-icons"} -->
		<div class="wp-block-column one-novanta-footer__social-icons" style="flex-basis:33.33%">
			<!-- wp:social-links {"iconColor":"primary","iconColorValue":"#d9272d","iconBackgroundColor":"background","iconBackgroundColorValue":"#fff","layout":{"type":"flex","justifyContent":"right"}} -->
			<ul class="wp-block-social-links has-icon-color has-icon-background-color">
				<!-- wp:social-link {"url":"https://www.linkedin.com/company/ati-industrial-automation","service":"linkedin"} /-->

				<!-- wp:social-link {"url":"https://www.youtube.com/user/ATIendeffectors","service":"youtube"} /-->

				<!-- wp:social-link {"url":"https://www.facebook.com/AtiIndustrialAutomation","service":"facebook"} /-->
			</ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
