/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, RichText } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// Block props and set class name for container.
	const blockProps = useBlockProps( { className: `info-box` } );

	return (
		<div { ...blockProps } >
			<RichText
				tagName="h2"
				value={ attributes.heading }
				onChange={ ( heading ) => setAttributes( { heading } ) }
				placeholder={ __( 'Enter list heading…', 'one-novanta-theme' ) }
				className={ 'info-box__heading' }
			/>
			<div className="info-box__list has-medium-font-size">
				<InnerBlocks
					allowedBlocks={ [ 'one-novanta/navigation-links-list-item' ] }
					orientation="vertical"
					renderAppender={ () => <InnerBlocks.ButtonBlockAppender /> } // Don't show auto-render appender
				/>
			</div>
		</div>
	);
}
