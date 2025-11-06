/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const imageCTAVariant = {
	name: 'one-novanta/image-cta',
	title: __( 'Image CTA', 'one-novanta-theme' ),
	attributes: {
		template: 'one-novanta/image-cta',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'one-novanta/image-cta',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/image-cta',
						innerBlocks: [
							{
								name: 'core/heading',
								attributes: {
									fontSize: 'xxx-large',
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
											text: __( 'Secondary', 'one-novanta-theme' ),
											className: 'is-style-fill',
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
				[ 'one-novanta/image-cta' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default imageCTAVariant;
