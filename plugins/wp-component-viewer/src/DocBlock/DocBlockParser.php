<?php
/**
 * DocBlock parser
 *
 * @package WPComponentViewer\DocBlock
 */

namespace WPComponentViewer\DocBlock;

/**
 * DocBlockParser class
 */
class DocBlockParser {
	/**
	 * Parse a file for component documentation
	 *
	 * @param string $file_path File path.
	 * @return array|null
	 */
	public static function parse_file( $file_path ) {
		if ( ! file_exists( $file_path ) ) {
			return null;
		}

		global $wp_filesystem;

		// Include the filesystem API if not already loaded.
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		WP_Filesystem();

		if ( ! $wp_filesystem->exists( $file_path ) ) {
			return null;
		}

		$file_content = $wp_filesystem->get_contents( $file_path );
		return self::parse_doc_block( $file_content );
	}

	/**
	 * Parse docblock from content
	 *
	 * @param string $content File content.
	 * @return array|null
	 */
	public static function parse_doc_block( $content ) {
		$matches = array();
		// Match PHPDoc style comments.
		preg_match_all( '/\/\*\*(.*?)\*\//s', $content, $matches );

		if ( empty( $matches[1] ) ) {
			return null;
		}

		foreach ( $matches[1] as $doc_block ) {
			$data = self::parse_doc_block_content( $doc_block );

			// If it has @component tag, it's a component we want.
			if ( ! empty( $data ) && isset( $data['component'] ) ) {
				return $data;
			}
		}

		return null;
	}

	/**
	 * Parse docblock content into structured data
	 *
	 * @param string $content DocBlock content.
	 * @return array
	 */
	private static function parse_doc_block_content( $content ) {
		$lines         = explode( "\n", $content );
		$data          = array();
		$current_tag   = null;
		$current_value = '';
		$preserve_raw  = false;

		foreach ( $lines as $line ) {
			$line = preg_replace( '/^\s*\*\s?/', '', $line );

			// If this line has a tag, process previous tag and start a new one.
			if ( preg_match( '/^@([a-zA-Z_]+)\s*(.*)?$/', $line, $matches ) ) {
				// Save the previous tag if there was one.
				if ( $current_tag ) {
					$data[ $current_tag ] = $preserve_raw ? rtrim( $current_value, "\n" ) : rtrim( $current_value );
				}

				$current_tag   = $matches[1];
				$current_value = isset( $matches[2] ) ? $matches[2] : '';
				$preserve_raw  = ( 'example' === $current_tag );
			} elseif ( $current_tag ) {
				// Append to current tag value.
				$current_value .= "\n" . $line;
			}
		}

		// Save the last tag.
		if ( $current_tag ) {
			$data[ $current_tag ] = $preserve_raw ? rtrim( $current_value, "\n" ) : rtrim( $current_value );
		}

		return $data;
	}
}
