<?php
/**
 * Product Details Gallery
 *
 * @package OneNovantaTheme\Blocks
 */

// Import the template class from the OneNovanta\Controllers\Common namespace.
use OneNovanta\Controllers\Common\Template;

$image_ids = $args['image_ids'] ?? [];

// If image_ids array is empty, return.
if ( empty( $image_ids ) ) {
	// Always render the gallery container to ensure the layout is consistent.
	?>
	<div class="product-details__gallery">
		<div class="product-details__gallery-slider">
			<div class="product-details__gallery-slide">
				<?php
				// Render thumbnail image.
				Template::render_component(
					'image',
					null,
					[
						'id'   => 0,
						'size' => 'thumbnail',
					]
				);
				?>
			</div>
		</div>
	</div>
	<?php

	// Bail out early to avoid rendering the gallery.
	return;
}

// Calculate total number of images and additional images beyond the first 4.
$total_images        = count( $image_ids );
$additional_images   = $total_images > 3 ? $total_images - 3 : 0;
$thumbnail_image_ids = array_slice( $image_ids, 0, 4 );
?>

<div class="product-details__gallery">
	<ati-product-gallery class="product-details__gallery-container">
		<div class="product-details__gallery-slider-container">
			<div class="product-details__gallery-slider">
				<?php foreach ( $image_ids as $key => $image_id ) : ?>
					<div class="product-details__gallery-slide" <?php echo 0 === $key ? 'data-active="true"' : ''; ?>>
						<?php
						Template::render_component(
							'media-lightbox',
							null,
							[
								'name'             => 'product-image-gallery',
								'group'            => 'product-image-gallery',
								'show_count'       => true,
								'allow_fullscreen' => false,
								'content'          => Template::get_component(
									'image',
									null,
									[
										'id'    => $image_id,
										'size'  => 'large',
										'class' => 'media-text__lightbox-image',
									]
								),
							]
						);
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="product-details__gallery-thumbnails">
			<?php
			foreach ( $thumbnail_image_ids as $key => $image_id ) :
				// For the 4th thumbnail, add an overlay if there are more images.
				$is_last_with_more = ( 3 === $key && $additional_images > 0 );
				?>
				<div class="product-details__gallery-thumbnail" <?php echo 0 === $key ? esc_attr( 'data-active="true"' ) : ''; ?>>
					<?php
					// Render thumbnail image.
					Template::render_component(
						'image',
						null,
						[
							'id'   => $image_id,
							'size' => 'thumbnail',
						]
					);
					?>

					<?php if ( $is_last_with_more ) : ?>
						<button class="product-details__gallery-thumbnail-overlay">
							<span class="product-details__gallery-thumbnail-overlay-number">+<?php echo esc_html( (string) $additional_images ); ?></span>
							<span class="product-details__gallery-thumbnail-overlay-text"><?php echo esc_html__( 'View all', 'one-novanta-theme' ); ?></span>
						</button>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</ati-product-gallery>
</div>
