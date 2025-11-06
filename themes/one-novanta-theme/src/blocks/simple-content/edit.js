/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Editor side of the block.
 *
 * @param {Object} props            Block Props.
 * @param {Object} props.attributes Block Attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes } ) {
	const { content } = attributes;
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<ServerSideRender
				block="one-novanta/simple-content"
				attributes={ { content } }
			/>
		</div>
	);
}
