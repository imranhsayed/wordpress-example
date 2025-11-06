/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const mediaTextCoverVariation = {
	name: 'media-text-cover',
	title: __( 'Boxed Image CTA', 'one-novanta-theme' ),
	attributes: {
		template: 'media-text-cover',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'media-text-cover',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/media-text-cover',
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
											text: __( 'Contact Us', 'one-novanta-theme' ),
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
				[ 'one-novanta/media-text-cover' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default mediaTextCoverVariation;
