/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const relatedArticlesVariation = {
	name: 'related-articles',
	title: __( 'Related Articles', 'one-novanta-theme' ),
	attributes: {
		template: 'related-articles',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'related-articles',
			showDescription: false,
		},
		innerBlocks: [
			{
				name: 'one-novanta/section-heading',
				innerBlocks: [
					{
						name: 'core/heading',
						attributes: {
							content: __( 'Heading', 'one-novanta-theme' ),
						},
					},
				],
			},
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{ name: 'one-novanta/related-articles' },
				],
			},
		],
	},
	innerBlocks: [
		[ 'one-novanta/section-heading' ],
		[
			'one-novanta/section-content',
			{
				templateLock: 'all',
			},
			[
				[ 'one-novanta/related-articles' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

const relatedProductsVariantion = {
	name: 'related-products',
	title: __( 'Related Products', 'one-novanta-theme' ),
	attributes: {
		template: 'related-products',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'related-products',
			showDescription: false,
		},
		innerBlocks: [
			{
				name: 'one-novanta/section-heading',
				innerBlocks: [
					{
						name: 'core/heading',
						attributes: {
							content: __( 'Heading', 'one-novanta-theme' ),
						},
					},
				],
			},
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/related-products',
					},
				],
			},
		],
	},
	innerBlocks: [
		[ 'one-novanta/section-heading' ],
		[
			'one-novanta/section-content',
			{
				templateLock: 'all',
			},
			[
				[ 'one-novanta/related-products' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export { relatedArticlesVariation, relatedProductsVariantion };
