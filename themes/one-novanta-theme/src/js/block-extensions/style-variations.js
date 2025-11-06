/**
 * Register block style variations.
 */

/**
 * WordPress dependencies
 */
import { unregisterBlockStyle } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

/**
 * Unregister style variations.
 *
 * @return {void}
 */
const unregister = () => {
	// Unregister block style variations.
	unregisterBlockStyle( 'core/image', [ 'default', 'rounded' ] );
};

/**
 * Register and unregister style variations on dom ready.
 */
domReady( () => {
	unregister();
} );
