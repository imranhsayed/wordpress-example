/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */

/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { createInterpolateElement } from '@wordpress/element';

/**
 * External dependencies
 */
import classnames from 'classnames';

// This is used to insert <sub> text in heading.
const searchTitle = createInterpolateElement(
	__(
		'Search results <sub>0 results for "Search String"</sub>',
		'one-novanta-theme',
	),
	{
		sub: <sub className="has-large-font-size search-results-title-count__count" />,
	},
);

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	// Block props.
	const blockProps = useBlockProps( {
		className: classnames(
			'wp-block-heading',
			'has-display-font-size',
			'search-results-title-count__title',
		),
	} );

	return (
		<div className="wp-block-group alignwide search-results-title-count">
			<h1 { ...blockProps } >
				{ searchTitle }
			</h1>
		</div>
	);
}
