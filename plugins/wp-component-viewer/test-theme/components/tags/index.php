<?php
/**
 * Component Tags
 *
 * @component Tags
 * @description Displays a list of tags with optional design variants
 * @group Content Display
 * @props {
 *   "tags": {
 *     "type": "array",
 *     "default": [],
 *     "description": "Array of tags to display (e.g., ['PHP', 'JavaScript'])"
 *   },
 *   "variant": {
 *     "type": "string",
 *     "default": "default",
 *     "description": "Visual variant: default, minimal, boxed"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "tags": ["WordPress", "PHP", "HTML"],
 *     "variant": "default"
 *   },
 *   "minimal": {
 *     "tags": ["Clean", "Flat"],
 *     "variant": "minimal"
 *   },
 *   "boxed": {
 *     "tags": ["Design", "Code", "UX"],
 *     "variant": "boxed"
 *   }
 * }
 * @example render_component('tags', [
 *   'tags' => ['Custom', 'Dynamic', 'Reusable'],
 *   'variant' => 'boxed'
 * ]);
 *
 * @package Components
 */

$tags               = $args['tags'] ?? [];
$variant            = $args['variant'] ?? 'default';
$wrapper_attributes = $args['wrapper_attributes'] ?? 'class="tags-component variant-' . esc_attr($variant) . '"';
?>

<?php if (!empty($tags)) : ?>
	<div <?php echo wp_kses_data($wrapper_attributes); ?>>
		<ul class="tags-component__list">
			<?php foreach ($tags as $tag) : ?>
				<li class="tags-component__item"><?php echo esc_html($tag); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
