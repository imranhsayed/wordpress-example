<?php
/**
 * Component Documents Filter.
 *
 * @component Documents Filter
 * @description A reusable documents filter component that provides search and filtering functionality.
 * @group UI Elements
 * @props {
 *   "endpoint": {"type": "string", "required": true, "description": "The API endpoint for fetching documents.", "default": "/wp-json/one-novanta/v1/documents"},
 *   "target_container": {"type": "string", "required": true, "description": "CSS selector for the target container where results will be displayed.", "default": "tbody.wp-one-novanta-table__body"}, *
 *   "document_filter_options": {"type": "array", "required": true, "description": "Array of filter options for document types and languages."},
 *   "language_filter_options": {"type": "array", "required": true, "description": "Array of filter options for languages."},
 *   "nonce": {"type": "string", "required": false, "description": "A nonce for security purposes."},
 *   "wrapper_attributes": {"type": "string", "required": false, "description": "Additional HTML attributes to be added to the wrapper element."}
 * }
 * @default {
 *   "nonce": "",
 *   "endpoint": "/wp-json/one-novanta/v1/documents",
 *   "target_container": "tbody.wp-one-novanta-table__body",
 *   "document_filter_options": [],
 *   "wrapper_attributes": ""
 * }
 * @example Template::render_component(
 *     'documents-filter',
 *     null,
 *     [
 *         'nonce' => wp_create_nonce('wp_rest'),
 *         'endpoint' => '/wp-json/one-novanta/v1/documents',
 *         'target_container' => '#documents-table-body',
 *         'document_filter_options' => ['manual', 'guide', 'datasheet'],
 *         'wrapper_attributes' => 'data-custom="value"'
 *     ]
 * );
 *
 * @package OneNovanta\Blocks
 */

use OneNovanta\Controllers\Common\Template;

if ( empty( $args ) || ! is_array( $args ) ) {
	return;
}

$base_class = 'wp-one-novanta-documents-filter';

$nonce    = $args['nonce'] ?? '';
$endpoint = $args['endpoint'] ?? rest_url( '/one-novanta/v1/documents' );

$target_container        = $args['target_container'] ?? 'tbody.wp-one-novanta-table__body';
$document_filter_options = $args['document_filter_options'] ?? [];
$language_filter_options = $args['language_filter_options'] ?? [];
$wrapper_attributes      = $args['wrapper_attributes'] ?? '';
$not_found_text          = $args['not_found_text'] ?? __( 'No Documents were found', 'one-novanta-theme' );

$extra_attributes = [
	'class'                 => [
		one_novanta_merge_classes(
			[
				$base_class,
				'alignwide',
			],
		),
	],
	'data-target-container' => [ strval( $target_container ) ],
	'data-endpoint'         => [ strval( $endpoint ) ],
	'data-nonce'            => [ strval( $nonce ) ],
];

$wrapper_attributes = one_novanta_get_wrapper_attributes( $extra_attributes, $wrapper_attributes );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> data-not-found-text="<?php echo esc_attr( $not_found_text ); ?>">
	<div class="<?php echo esc_attr( $base_class ) . '__search-input-wrapper'; ?>" >
		<input class="<?php echo esc_attr( one_novanta_merge_classes( $base_class . '__search-input', 'has-medium-font-size', 'has-heading-font-family' ) ); ?>" type="text" placeholder="<?php esc_attr_e( 'Keyword', 'one-novanta-theme' ); ?>" name="one-novanta-documents-search-input" />
		<?php
		Template::render_component(
			'svg',
			null,
			[
				'name' => 'search',
			]
		);
		?>
	</div>

	<?php
	Template::render_component(
		'filter-dropdown',
		null,
		[
			'base_class'          => $base_class,
			'default_filter_text' => __( 'Document Type', 'one-novanta-theme' ),
			'filter_options'      => $document_filter_options,
			'wrapper_attributes'  => one_novanta_get_wrapper_attributes(
				[
					'id' => [ "$base_class" . '__document-type' ],
				]
			),
		]
	);

	Template::render_component(
		'filter-dropdown',
		null,
		[
			'base_class'          => $base_class,
			'default_filter_text' => __( 'Language', 'one-novanta-theme' ),
			'filter_options'      => $language_filter_options,
			'wrapper_attributes'  => one_novanta_get_wrapper_attributes(
				[
					'id' => [ "{$base_class}__language" ],
				]
			),
		]
	);

	Template::render_component(
		'button',
		null,
		[
			'content'            => __( 'Search', 'one-novanta-theme' ),
			'icon'               => true,
			'wrapper_attributes' => one_novanta_get_wrapper_attributes(
				[
					'id' => [ "{$base_class}__search-button" ],
				]
			),
		]
	);
	?>
</div>
