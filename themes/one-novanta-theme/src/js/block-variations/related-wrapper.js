/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import domReady from '@wordpress/dom-ready';
import { registerBlockVariation } from '@wordpress/blocks';

domReady( () => {
	registerBlockVariation( 'one-novanta/related-wrapper', {
		name: 'related-articles',
		title: __( 'Related Articles', 'one-novanta-theme' ),
		description: __( 'Show related articles based on selected category.', 'one-novanta-theme' ),
		icon: 'admin-post',
		isDefault: true,
		attributes: {
			template: 'related-articles',
		},
		innerBlocks: [
			[ 'one-novanta/related-articles' ],
		],
		scope: [ 'inserter' ],
		isActive: [ 'template' ],
	} );

	registerBlockVariation( 'one-novanta/related-wrapper', {
		name: 'related-products',
		title: __( 'Related Products', 'one-novanta-theme' ),
		description: __( 'Show related products based on selected category.', 'one-novanta-theme' ),
		icon: 'cart',
		attributes: {
			template: 'related-products',
		},
		innerBlocks: [
			[ 'one-novanta/related-products' ],
		],
		scope: [ 'inserter' ],
		isActive: [ 'template' ],
	} );
} );
