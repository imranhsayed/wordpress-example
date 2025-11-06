/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Edit component.
 */
export default function Edit() {
	const blockProps = useBlockProps( {
		className: 'alignfull',
	} );

	return (
		<div { ...blockProps }>
			<ServerSideRender
				block="one-novanta/documents-and-downloads"
			/>
		</div>
	);
}
