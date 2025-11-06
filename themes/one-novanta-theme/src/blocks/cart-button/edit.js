/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Edit function for cart-button block.
 */
export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<ServerSideRender block="one-novanta/cart-button" />
		</div>
	);
}
