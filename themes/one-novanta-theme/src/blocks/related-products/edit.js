/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Internal dependencies
 */
import InspectorControls from './inspector-controls';

export default function Edit( { attributes, setAttributes } ) {
	const baseClassName = 'related-products-block';

	const blockProps = useBlockProps( {
		className: `${ baseClassName } alignfull`,
	} );

	return (
		<div { ...blockProps }>
			<InspectorControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>

			<ServerSideRender
				block="one-novanta/related-products"
				attributes={ attributes }
			/>
		</div>
	);
}
