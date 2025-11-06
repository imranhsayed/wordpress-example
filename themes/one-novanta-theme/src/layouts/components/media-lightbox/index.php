<?php
/**
 * Component Media Lightbox
 *
 * @component Media Lightbox
 * @description A reusable media lightbox component.
 * @group UI Elements
 * @props {
 *  "name": {"type": "string", "required": false, "description": "Name of the lightbox."},
 *  "caption": {"type": "string", "required": false, "description": "Caption of the lightbox."},
 *  "show_count": {"type": "boolean", "required": false, "description": "Show count of items in the lightbox."},
 *  "group": {"type": "string", "required": false, "description": "Group name for the lightbox."},
 *  "content": {"type": "string", "required": true, "description": "Media lightbox content."},
 *  "wrapper_attributes": {"type": "array", "required": false, "description": "Additional attributes for the wrapper."},
 *  "allow_fullscreen": {"type": "boolean", "required": false, "description": "Allow fullscreen mode."},
 * }
 *
 * @variations {}
 * @example render_component(
 *     'media-lightbox',
 *     null,
 *     [
 *          'name'       => 'myLightbox',
 *           caption'    => 'Image Caption',
 *          'show_count' => true,
 *          'group'      => 'gallery-1',
 *          'content'    => Template::get_component(
 *             image',
 *             null,
 *             [
 *                 'id'    => 244,
 *                 'size'  => 'large',
 *                 'class' => 'media-text__lightbox-image',
 *             ]
 *         ),
 *     ]
 * );
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

// Retrieve attributes from the arguments array, providing default values if not set.
$content            = $args['content'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
$name               = $args['name'] ?? '';
$caption            = $args['caption'] ?? '';
$group              = $args['group'] ?? '';
$show_count         = $args['show_count'] ?? true;
$allow_fullscreen   = $args['allow_fullscreen'] ?? false;
$caption_align      = $args['caption_align'] ?? 'left';
$media_id           = $args['media_id'] ?? '';

// Return null if the content or name is empty to prevent further processing.
if ( empty( $content ) || empty( $name ) ) {
	return null;
}
?>

<div class="media-lightbox" <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<ati-media-lightbox>
		<rt-lightbox
			id="<?php echo esc_attr( $name ); ?>"
			close-on-overlay-click="yes"
			swipe="yes"
			swipe-threshold="300"
			class="media-lightbox__wrapper"
		>
			<dialog class="media-lightbox__dialog">
				<div class="media-lightbox__content-wrapper">
					<rt-lightbox-close class="media-lightbox__close">
						<button
							class="media-lightbox__close-button"
							aria-label="<?php esc_attr_e( 'Close', 'one-novanta-theme' ); ?>"
						>
							<?php
							Template::render_component(
								'svg',
								null,
								[ 'name' => 'close' ],
							);
							?>
						</button>
					</rt-lightbox-close>

					<rt-lightbox-previous class="media-lightbox__navigation-previous">
						<button
							class="media-lightbox__navigation-button"
							aria-label="<?php esc_attr_e( 'Previous', 'one-novanta-theme' ); ?>"
						>
							<?php
							Template::render_component(
								'svg',
								null,
								[ 'name' => 'arrow-right-thin' ],
							);
							?>
						</button>
					</rt-lightbox-previous>
					<rt-lightbox-content class="media-lightbox__content"></rt-lightbox-content>
					<rt-lightbox-next class="media-lightbox__navigation-next">
						<button
							class="media-lightbox__navigation-button"
							aria-label="<?php esc_attr_e( 'Next', 'one-novanta-theme' ); ?>"
						>
							<?php
							Template::render_component(
								'svg',
								null,
								[ 'name' => 'arrow-right-thin' ],
							);
							?>
						</button>
					</rt-lightbox-next>
					<?php if ( true === boolval( $show_count ) ) : ?>
						<rt-lightbox-count class="media-lightbox__count" format="$current / $total"></rt-lightbox-count>
					<?php endif; ?>
					<div class="media-lightbox__nav"></div>
				</div>
			</dialog>
		</rt-lightbox>
	</ati-media-lightbox>
	<rt-lightbox-trigger
		lightbox="<?php echo esc_attr( $name ); ?>"
		group="<?php echo esc_attr( $group ); ?>"
		class="media-lightbox__trigger"
	>
		<button class="media-lightbox__trigger-button" aria-label="<?php esc_attr_e( 'Open Lightbox', 'one-novanta-theme' ); ?>">
			<figure class="media-lightbox__figure">
				<?php one_novanta_kses_post_e( $content ); ?>
				<?php if ( ! empty( $caption ) ) : ?>
					<figcaption class="media-lightbox__caption">
						<?php one_novanta_kses_post_e( $caption ); ?>
					</figcaption>
				<?php endif; ?>

				<?php if ( true === $allow_fullscreen ) : ?>
					<span class="media-lightbox__trigger-fullscreen" aria-hidden="true">
						<?php
						Template::render_component(
							'svg',
							null,
							[ 'name' => 'expand' ],
						);
						?>
					</span>
				<?php endif; ?>
			</figure>
		</button>
		<template>
			<?php if ( empty( $media_id ) ) : ?>
				<?php one_novanta_kses_post_e( $content ); ?>
			<?php else : ?>
				<?php wp_enqueue_script( 'wistia-player' ); ?>
				<wistia-player media-id="<?php echo esc_attr( $media_id ); ?>"></wistia-player>
			<?php endif; ?>
		</template>
	</rt-lightbox-trigger>
</div>
