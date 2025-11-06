/**
 * WordPress dependencies
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
	const { heading } = attributes;
	const blockProps = useBlockProps( { className: 'table-of-content has-small-font-size has-heading-font-family' } );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="p"
				value={ heading }
				onChange={ ( newHeading ) => setAttributes( { heading: newHeading } ) }
				className="table-of-content__label"
				allowedFormats={ [] }
			/>
			<ul className="table-of-content__list">
				<li className="table-of-content__item">
					{ __( 'H2 headings will be dynamically populated here from the post content.', 'one-novanta-theme' ) }
				</li>
			</ul>
		</div>
	);
}
