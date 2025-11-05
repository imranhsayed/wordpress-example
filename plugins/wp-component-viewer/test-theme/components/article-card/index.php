<?php
/**
 * Component Article Card
 *
 * @component Article Card
 * @description A reusable card to display articles or posts
 * @group Content Display
 * @props {
 *   "title": {
 *     "type": "string",
 *     "required": true,
 *     "description": "Article title"
 *   },
 *   "excerpt": {
 *     "type": "string",
 *     "description": "Short excerpt of the article"
 *   },
 *   "image_url": {
 *     "type": "string",
 *     "description": "URL of the article's featured image"
 *   },
 *   "link": {
 *     "type": "string",
 *     "description": "Link to the full article"
 *   },
 *   "date": {
 *     "type": "string",
 *     "description": "Publish date (optional)"
 *   },
 *   "author": {
 *     "type": "string",
 *     "description": "Author name (optional)"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Wrapper HTML attributes (optional)"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "title": "How to Build a WordPress Theme",
 *     "excerpt": "Learn how to create a custom theme from scratch with best practices.",
 *     "image_url": "https://placehold.co/600x400",
 *     "link": "#",
 *     "date": "May 2025",
 *     "author": "Devansh"
 *   },
 *   "without-image": {
 *     "title": "How to Build a WordPress Theme",
 *     "excerpt": "Learn how to create a custom theme from scratch with best practices.",
 *     "link": "#",
 *     "date": "May 2025",
 *     "author": "Devansh"
 *   }
 * }
 * @example render_component('article-card', [
 *   'title' => 'How to Build a WordPress Theme',
 *   'excerpt' => 'Learn how to create a custom theme from scratch with best practices.',
 *   'image_url' => 'https://placehold.co/600x400',
 *   'link' => '#',
 *   'date' => 'May 2025',
 *   'author' => 'Devansh',
 * ]);
 *
 * @package Components
 */

if ( empty( $args['title'] ) ) return;

$title             = $args['title'];
$excerpt           = $args['excerpt'] ?? '';
$image_url         = $args['image_url'] ?? '';
$link              = $args['link'] ?? '#';
$date              = $args['date'] ?? '';
$author            = $args['author'] ?? '';
$wrapper_attributes = $args['wrapper_attributes'] ?? '';
?>

<article class="article-card" <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<a href="<?php echo esc_url( $link ); ?>" class="article-card__inner">
		<?php if ( $image_url ) : ?>
			<div class="article-card__image-wrapper">
				<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="article-card__image" />
			</div>
		<?php endif; ?>

		<div class="article-card__content">
			<h2 class="article-card__title"><?php echo esc_html( $title ); ?></h2>

			<?php if ( $excerpt ) : ?>
				<p class="article-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<?php if ( $author || $date ) : ?>
				<div class="article-card__meta">
					<?php if ( $author ) : ?><span class="article-card__author"><?php echo esc_html( $author ); ?></span><?php endif; ?>
					<?php if ( $author && $date ) : ?><span class="article-card__divider">|</span><?php endif; ?>
					<?php if ( $date ) : ?><span class="article-card__date"><?php echo esc_html( $date ); ?></span><?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</a>
</article>
