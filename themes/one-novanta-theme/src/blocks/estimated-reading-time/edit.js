/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit() {
	const blockProps = useBlockProps();

	return (
		<>
			<div { ...blockProps }>
				{ __( 'Estimated Reading Time', 'one-novanta-theme' ) }
			</div>
		</>
	);
}
