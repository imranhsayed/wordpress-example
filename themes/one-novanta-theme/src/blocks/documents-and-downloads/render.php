<?php
/**
 * Render the Documents and Downloads block.
 *
 * @package OneNovanta\Blocks
 */

use OneNovanta\Controllers\Common\Template;

use function Novanta\Multilingual\get_languages;

// Set up block wrapper attributes with alignment class.
$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'alignwide is-layout-constrained',
	]
);

$wp_nonce = wp_create_nonce( 'wp_rest' );


// Get all values of novanta_download_types taxonomy.
$terms = one_novanta_get_terms(
	[
		'taxonomy'   => 'novanta_download_types',
		'hide_empty' => false,
	]
);

// List of term options.
$term_options = [];

// Extract term names and slugs if terms exist and no errors occurred.
if ( ! empty( $terms ) ) {
	foreach ( $terms as $the_term ) {
		$term_options[ $the_term->slug ] = $the_term->name;
	}
}

// Get all the languages.
$wpml_languages = get_languages();

$current_page   = 1;
$posts_per_page = 10;

/**
 * This is a read-only (non-API) page that processes URL parameters for filtering content.
 * No sensitive actions or data mutations are performed, so nonce verification is not required here.
 *
 * Note: Nonce verification is handled in the documents API.
 */
$param_language       = ! empty( $_GET['language'] ) ? sanitize_text_field( $_GET['language'] ) : '';  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$param_document_type  = ! empty( $_GET['document_type'] ) ? sanitize_text_field( $_GET['document_type'] ) : '';  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$param_search_keyword = ! empty( $_GET['search_keyword'] ) ? sanitize_text_field( $_GET['search_keyword'] ) : '';  // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$initial_documents = one_novanta_get_documents(
	[
		'page'           => $current_page,
		'per_page'       => $posts_per_page,
		'document_type'  => $param_document_type,
		'language'       => $param_language,
		'search_keyword' => $param_search_keyword,
	]
);

$table_title = _n( 'result', 'results', absint( $initial_documents['total_posts'] ), 'one-novanta-theme' );

$wpml_languages = array_column( $wpml_languages, 'label' );

/**
 * If empty rows, show No Documents where found.
 */
if ( empty( $initial_documents['content'] ) ) {
	$initial_documents['content'] = '<tr><td colspan="999" class="wp-one-novanta-no-rows-found">' . esc_html__( 'No Documents were found', 'one-novanta-theme' ) . '</td></tr>';
}
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<?php
	// Render the documents filter component.
	Template::render_component(
		'documents-filter',
		null,
		[
			'not_found_text'          => __( 'No Documents were found', 'one-novanta-theme' ),
			'document_filter_options' => $term_options,
			'language_filter_options' => $wpml_languages,
			'nonce'                   => $wp_nonce,
		]
	);

	// Render the table component with documents data.
	Template::render_component(
		'table',
		null,
		[
			'headers'                 => [
				__( 'File Name', 'one-novanta-theme' ),
				__( 'Download Type', 'one-novanta-theme' ),
				__( 'Language', 'one-novanta-theme' ),
				'',
			],
			'rows'                    => $initial_documents['content'],
			'wrapper_attributes'      => 'class="alignwide"',
			'table_title'             => $initial_documents['total_posts'] . ' ' . $table_title,
			'header_background_color' => 'secondary',
			'load_more_attributes'    => [
				'page'                => $current_page + 1,
				'target'              => '.wp-one-novanta-table__body',
				'numberOfPostsToLoad' => $posts_per_page,
				'source'              => rest_url( '/one-novanta/v1/documents' ),
				'found_posts'         => $initial_documents['total_posts'],
				'nonce'               => $wp_nonce,
			],
		]
	);
	?>
</div>
