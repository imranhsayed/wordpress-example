/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';
import { registerBlockVariation } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import { default as sectionVariations } from './sections';

domReady( () => {
	sectionVariations.forEach( ( variation ) => {
		registerBlockVariation(
			'one-novanta/section',
			{
				...variation,
			},
		);
	} );
} );
