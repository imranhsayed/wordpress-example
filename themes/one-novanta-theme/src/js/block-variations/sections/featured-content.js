/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const featuredContentVariation = {
	name: 'featured-content',
	title: __( 'Featured Content', 'one-novanta-theme' ),
	attributes: {
		template: 'featured-content',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'featured-content',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/featured-content',
						attributes: {
							mediaType: 'image',
							mediaAlignment: 'left',
						},
						innerBlocks: [
							{
								name: 'core/heading',
								attributes: {
									content: __( 'Heading', 'one-novanta-theme' ),
								},
							},
							{
								name: 'core/paragraph',
								attributes: {
									content: __( 'Description', 'one-novanta-theme' ),
								},
							},
							{
								name: 'core/buttons',
								innerBlocks: [
									{
										name: 'core/button',
										attributes: {
											text: __( 'Primary', 'one-novanta-theme' ),
											className: 'is-style-fill',
										},
									},
									{
										name: 'core/button',
										attributes: {
											text: __( 'Secondary', 'one-novanta-theme' ),
											className: 'is-style-outline',
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
				[ 'one-novanta/featured-content' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default featuredContentVariation;
