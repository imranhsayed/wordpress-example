<?php
/**
 * Pattern Product Tabs
 *
 * Title: Product Tabs
 * Slug: one-novanta-theme/product-tabs
 * Description: Product Tabs.
 * Categories: onenovanta,product
 * Keywords: Product
 *
 * @package OneNovantaTheme\Patterns
 */

?>

<!-- wp:one-novanta/section {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|80"}}},"showTitle":false,"showDescription":false,"template":"tabs","backgroundColor":"secondary","anchor":"one-novanta-single-product-all-features"} -->
<div class="alignfull has-secondary-background-color has-background" id="one-novanta-single-product-all-features" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:one-novanta/section-content {"templateLock":"all"} -->
	<div class="wp-block-one-novanta-section-content alignwide">
		<!-- wp:one-novanta/tabs -->
		<div>
			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( 'Product Features', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/section {"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"showTitle":false,"showDescription":false,"template":"section-50-50-question"} -->
				<div class="alignfull" style="padding-top:0;padding-bottom:0">
					<!-- wp:one-novanta/section-content {"templateLock":"all"} -->
					<div class="wp-block-one-novanta-section-content alignwide">
						<!-- wp:one-novanta/fifty-fifty-wrapper {"imageAlignment":"left","heading":"<?php esc_attr_e( 'Product Features', 'one-novanta-theme' ); ?>","template":"question"} -->
						<div class="wp-block-one-novanta-fifty-fifty-wrapper alignfull">
							<!-- wp:heading {"level":3} -->
							<h3 class="wp-block-heading" id="product-feature-heading"><?php esc_html_e( 'Product Feature Heading', 'one-novanta-theme' ); ?></h3>
							<!-- /wp:heading -->

							<!-- wp:list -->
							<ul class="wp-block-list">
								<!-- wp:list-item -->
								<li><?php esc_html_e( 'Product Feature', 'one-novanta-theme' ); ?></li>
								<!-- /wp:list-item -->
							</ul>
							<!-- /wp:list -->

							<!-- wp:heading {"level":3} -->
							<h3 class="wp-block-heading" id="product-feature-heading"><?php esc_html_e( 'Product Feature Heading', 'one-novanta-theme' ); ?></h3>
							<!-- /wp:heading -->

							<!-- wp:list -->
							<ul class="wp-block-list">
								<!-- wp:list-item -->
								<li><?php esc_html_e( 'Product Feature', 'one-novanta-theme' ); ?></li>
								<!-- /wp:list-item -->
							</ul>
							<!-- /wp:list -->

							<!-- wp:buttons -->
							<div class="wp-block-buttons">
								<!-- wp:button {"className":"is-style-fill has-arrow"} -->
								<div class="wp-block-button is-style-fill has-arrow">
									<a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Primary', 'one-novanta-theme' ); ?></a>
								</div>
								<!-- /wp:button -->

								<!-- wp:button {"className":"is-style-outline has-arrow"} -->
								<div class="wp-block-button is-style-outline has-arrow">
									<a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Secondary', 'one-novanta-theme' ); ?></a>
								</div>
								<!-- /wp:button -->
							</div>
							<!-- /wp:buttons -->
						</div>
						<!-- /wp:one-novanta/fifty-fifty-wrapper -->
					</div>
					<!-- /wp:one-novanta/section-content -->
				</div>
				<!-- /wp:one-novanta/section -->
			<!-- /wp:one-novanta/tab-item -->

			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( 'Specifications', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/specifications -->
					<!-- wp:one-novanta/specification-item /-->
				<!-- /wp:one-novanta/specifications -->
			<!-- /wp:one-novanta/tab-item -->

			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( 'Documents \u0026 Downloads', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/documents {"name":"one-novanta/documents","mode":"auto"} /-->
			<!-- /wp:one-novanta/tab-item -->

			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( '3D CAD Models', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/cad-modals -->
					<!-- wp:one-novanta/cad-modal-item /-->
				<!-- /wp:one-novanta/cad-modals -->
			<!-- /wp:one-novanta/tab-item -->

			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( 'Accessories', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/accessories {"name":"one-novanta/accessories","mode":"auto"} /-->
			<!-- /wp:one-novanta/tab-item -->

			<!-- wp:one-novanta/tab-item {"title":"<?php esc_attr_e( 'Components', 'one-novanta-theme' ); ?>"} -->
				<!-- wp:one-novanta/components {"name":"one-novanta/components","mode":"auto"} /-->
			<!-- /wp:one-novanta/tab-item -->
		</div>
		<!-- /wp:one-novanta/tabs -->
	</div>
	<!-- /wp:one-novanta/section-content -->
</div>
<!-- /wp:one-novanta/section -->
