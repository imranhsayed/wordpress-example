/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const listingVariations = {
	name: 'one-novanta/listing',
	title: __( 'Listing', 'one-novanta-theme' ),
	attributes: {
		template: 'one-novanta/listing',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'one-novanta/listing',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/listing',
						innerBlocks: [
							{
								name: 'one-novanta/listing-item',
								innerBlocks: [
									{
										name: 'core/heading',
										attributes: {
											content: __( 'List Item 1', 'one-novanta-theme' ),
										},
									},
									{
										name: 'core/paragraph',
										attributes: {
											content: __( 'Content for List Item 1', 'one-novanta-theme' ),
										},
									},
								],
							},
							{
								name: 'one-novanta/listing-item',
								innerBlocks: [
									{
										name: 'core/heading',
										attributes: {
											content: __( 'List Item 2', 'one-novanta-theme' ),
										},
									},
									{
										name: 'core/paragraph',
										attributes: {
											content: __( 'Content for List Item 2', 'one-novanta-theme' ),
										},
									},
								],
							},
						],
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
				[ 'one-novanta/listing' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default listingVariations;
