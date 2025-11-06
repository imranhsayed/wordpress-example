<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Check if it's a preview in gutenberg.
$is_preview = ! empty( $is_preview );

// Get ACF field value.
$documents = get_field( 'documents' );

// Check if the field is empty or not an array.
if ( empty( $documents ) || ! is_array( $documents ) ) {
	// Check if it's a preview in gutenberg.
	if ( $is_preview ) {
		// Show a message in the preview.
		echo '<div class="acf-block-fields acf-fields"><div class="acf-field"><label>' . esc_html__( 'Please add any Document.', 'one-novanta-theme' ) . '</label></div></div>';
	}

	return;
}

// Sanitize the document IDs.
$documents = array_map( 'absint', $documents );

// Initialize an empty array to store the table rows.
$table_rows = [];

// Loop through the rows and display the data.
foreach ( $documents as $document_id ) {
	// Bail out if the document is empty or not numeric.
	if ( empty( $document_id ) ) {
		continue;
	}

	// Get document data.
	$document_data = one_novanta_get_document_data( $document_id );

	// Check if the document data is empty.
	if ( empty( $document_data ) ) {
		continue;
	}

	$required_download_data = [
		$document_data['excerpt'],
		$document_data['document_types'],
		implode( ', ', $document_data['languages'] ),
	];

	$document_data[0] = $document_data['excerpt'];
	$document_data[1] = $document_data['document_types'];
	$document_data[2] = $document_data['languages'];

	unset( $document_data['excerpt'] );
	unset( $document_data['document_types'] );
	unset( $document_data['languages'] );

	// Add the document data.
	$table_rows[] = $required_download_data;
}

// Set up block wrapper attributes.
$wrapper_attributes = get_block_wrapper_attributes();

// Table Component.
Template::render_component(
	'table',
	null,
	[
		'headers'            => [
			__( 'Download', 'one-novanta-theme' ),
			__( 'Download Type', 'one-novanta-theme' ),
			__( 'Language', 'one-novanta-theme' ),
		],
		'rows'               => $table_rows,
		'background_color'   => 'secondary',
		'filter_by'          => 2,
		'filter_title'       => __( 'Type', 'one-novanta-theme' ),
		'wrapper_attributes' => $wrapper_attributes,
	],
);
