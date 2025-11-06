/**
 * WordPress dependencies
 */
import { useEffect } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import HeadingLevel from '../../js/block-components/heading-level';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.context       Block context.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { context, attributes, setAttributes } ) {
	const { headingLevel = 'h3' } = attributes;
	const blockProps = useBlockProps();

	// Context is not passed for the ServerSideRender.
	useEffect( () => {
		if ( context.query ) {
			// Only update attributes if context has changed.
			const { query } = context;
			setAttributes( {
				perPage: query.perPage || 6,
				postType: query.postType || 'post',
				taxQuery: query.taxQuery || {},
			} );
		}
	}, [ context, setAttributes ] );

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<HeadingLevel
					headingLevel={ headingLevel }
					setHeadingLevel={ ( level ) => setAttributes( { headingLevel: level } ) }
				/>
			</InspectorControls>
			<ServerSideRender
				block="one-novanta/product-search"
				attributes={ attributes }
			/>
		</div>
	);
}
