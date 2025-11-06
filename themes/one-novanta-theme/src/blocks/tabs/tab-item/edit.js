/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Edit component.
 *
 * @param {Object} props           Component props.
 * @param {string} props.className Block class name.
 * @param {string} props.clientId  Block client ID.
 * @param {Object} props.context   Block context.
 */
export default function Edit( {
	className,
	clientId,
	context,
} ) {
	// Block props.
	const blocksProps = useBlockProps( {
		className: classnames( className, 'tabs__tab', {
			'novanta-tabs-nav__tab--active': clientId === context[ 'one-novanta/tabs' ],
		} ),
		open: clientId === context[ 'one-novanta/tabs' ],
	} );

	// Inner blocks props.
	const innerBlockProps = useInnerBlocksProps(
		{ ...blocksProps },
		{
			template: [ [ 'core/paragraph', { placeholder: __( 'Add content…', 'one-novanta-theme' ) } ] ],
			templateLock: false,
		},
	);

	// Return the block's markup.
	return <div { ...innerBlockProps } />;
}
