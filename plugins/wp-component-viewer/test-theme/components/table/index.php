<?php
/**
 * Component Table
 *
 * @component Table
 * @description Displays a responsive table with optional design variants
 * @group Layout
 * @props {
 *   "headers": {
 *     "type": "array",
 *     "default": [],
 *     "description": "Array of table headers (e.g., ['Name', 'Age'])"
 *   },
 *   "rows": {
 *     "type": "array",
 *     "default": [],
 *     "description": "Array of table rows, each row being an array of cell values"
 *   },
 *   "variant": {
 *     "type": "string",
 *     "default": "default",
 *     "description": "Visual variant: default, striped, bordered"
 *   },
 *   "wrapper_attributes": {
 *     "type": "string",
 *     "description": "Optional wrapper attributes"
 *   }
 * }
 * @variations {
 *   "default": {
 *     "headers": ["Name", "Role", "Location"],
 *     "rows": [["Aarav", "Developer", "Delhi"], ["Sita", "Designer", "Mumbai"]],
 *     "variant": "default"
 *   },
 *   "striped": {
 *     "headers": ["Name", "Department", "Status"],
 *     "rows": [["Kabir", "HR", "Active"], ["Naina", "Finance", "On Leave"]],
 *     "variant": "striped"
 *   },
 *   "bordered": {
 *     "headers": ["Course", "Duration", "Fee"],
 *     "rows": [["Web Dev", "6 months", "₹10,000"], ["Data Science", "1 year", "₹25,000"]],
 *     "variant": "bordered"
 *   }
 * }
 * @example render_component('table', [
 *   'headers' => ['Name', 'Email'],
 *   'rows' => [['Devansh', 'dev@example.com'], ['Ishita', 'ishita@example.com']],
 *   'variant' => 'striped'
 * ]);
 *
 * @package Components
 */

$headers            = $args['headers'] ?? [];
$rows               = $args['rows'] ?? [];
$variant            = $args['variant'] ?? 'default';
$wrapper_attributes = $args['wrapper_attributes'] ?? 'class="table-component variant-' . esc_attr($variant) . '"';
?>

<?php if (!empty($headers) || !empty($rows)) : ?>
	<div <?php echo wp_kses_data($wrapper_attributes); ?>>
		<table class="table-component__table">
			<?php if (!empty($headers)) : ?>
				<thead>
					<tr>
						<?php foreach ($headers as $header) : ?>
							<th><?php echo esc_html($header); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
			<?php endif; ?>
			<tbody>
				<?php foreach ($rows as $row) : ?>
					<tr>
						<?php foreach ($row as $cell) : ?>
							<td><?php echo esc_html($cell); ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>
