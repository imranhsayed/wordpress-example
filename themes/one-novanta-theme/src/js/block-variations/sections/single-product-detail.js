/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const singleProductDetail = {
	name: 'single-product-detail',
	title: __( 'Single Product Detail', 'one-novanta-theme' ),
	attributes: {
		template: 'single-product-detail',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'single-product-detail',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{ name: 'one-novanta/single-product-detail' },
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
				[ 'one-novanta/single-product-detail' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default singleProductDetail;
