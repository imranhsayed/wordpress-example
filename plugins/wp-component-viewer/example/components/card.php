<?php
/**
 * Card Component
 *
 * @component Card
 * @description A flexible card component for displaying content
 * @group UI Elements
 * @props {
 *   "title": {"type": "string", "description": "Card title"},
 *   "content": {"type": "string", "description": "Card content"},
 *   "image": {"type": "array", "description": "Image details with 'url', 'alt', and 'size'"},
 *   "footer": {"type": "string", "description": "Card footer content (HTML allowed)"},
 *   "variant": {"type": "string", "options": ["default", "bordered", "shadow"], "description": "Card style variant"},
 *   "classes": {"type": "string", "description": "Additional CSS classes"}
 * }
 * @variations {
 *   "default": {"title": "Default Card", "content": "This is the default card variant.", "variant": "default"},
 *   "bordered": {"title": "Bordered Card", "content": "This card has a border.", "variant": "bordered"},
 *   "shadow": {"title": "Shadow Card", "content": "This card has a shadow effect.", "variant": "shadow"},
 *   "with-image": {"title": "Card with Image", "content": "This card includes an image.", "image": {"url": "https://place-hold.it/300x200", "alt": "Placeholder"}, "variant": "default"},
 *   "with-footer": {"title": "Card with Footer", "content": "This card has a footer section.", "footer": "<button>Read More</button>", "variant": "default"}
 * }
 * @example get_component('card', [
 *   'title' => 'My Card',
 *   'content' => 'Card content goes here.',
 *   'image' => [
 *     'url' => 'https://example.com/image.jpg',
 *     'alt' => 'Image description'
 *   ],
 *   'variant' => 'shadow'
 * ]);
 *
 * @package Components
 */

// Default values.
$title   = $title ?? ''; //phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$content = $content ?? '';
$image   = $image ?? null;
$footer  = $footer ?? '';
$variant = $variant ?? 'default';
$classes = $classes ?? '';

// Build class list.
$card_classes = array(
	'wp-card',
	"wp-card--{$variant}",
);

if ( $classes ) {
	$card_classes[] = $classes;
}

// Combine into string.
$card_class = implode( ' ', $card_classes );
?>

<div class="<?php echo esc_attr( $card_class ); ?>">
	<?php if ( $image && isset( $image['url'] ) ) : ?>
		<div class="wp-card__image">
			<img src="<?php echo esc_url( $image['url'] ); ?>"
				alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>"
				<?php if ( isset( $image['size'] ) ) : ?>
					width="<?php echo esc_attr( $image['size'][0] ?? '' ); ?>"
					height="<?php echo esc_attr( $image['size'][1] ?? '' ); ?>"
				<?php endif; ?>>
		</div>
	<?php endif; ?>

	<div class="wp-card__body">
		<?php if ( $title ) : ?>
			<h3 class="wp-card__title"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( $content ) : ?>
			<div class="wp-card__content">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $footer ) : ?>
		<div class="wp-card__footer">
			<?php echo wp_kses_post( $footer ); ?>
		</div>
	<?php endif; ?>
</div>
