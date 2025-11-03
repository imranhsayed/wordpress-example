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
	const baseClassName = 'related-articles-block';

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
				block="aquila/related-articles"
				attributes={ attributes }
			/>
		</div>
	);
}
