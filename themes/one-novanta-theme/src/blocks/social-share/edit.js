/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Editor side of the block.
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	// Get the block props with custom class names.
	const blockProps = useBlockProps(
		{
			className: 'novanta-social-share',
		},
	);

	return (
		<div { ...blockProps }>
			<ServerSideRender
				block="one-novanta/social-share"
			/>
		</div>
	);
}
