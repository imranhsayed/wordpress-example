/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const featuredMediaSliderVariation = {
	name: 'featured-media-slider',
	title: __( 'Featured Media Slider', 'one-novanta-theme' ),
	attributes: {
		template: 'featured-media-slider',
		showButtons: true,
		headingLayout: 'columns',
	},
	example: {
		attributes: {
			template: 'featured-media-slider',
			showButtons: true,
			headingLayout: 'columns',
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
					{
						name: 'core/group',
						attributes: {
							layout: {
								type: 'flex',
								justifyContent: 'space-between',
								verticalAlignment: 'top',
							},
						},
						innerBlocks: [
							{
								name: 'core/heading',
								attributes: {
									level: 3,
									content: __( 'Sub Heading', 'one-novanta-theme' ),
								},
							},
							{
								name: 'core/paragraph',
								attributes: {
									content: __( 'Description', 'one-novanta-theme' ),
								},
							},
						],
					},
					{
						name: 'core/group',
						attributes: {
							layout: {
								type: 'flex',
								orientation: 'vertical',
							},
						},
						innerBlocks: [
							{
								name: 'core/buttons',
								attributes: {
									layout: {
										type: 'flex',
										orientation: 'vertical',
									},
								},
								innerBlocks: [
									{
										name: 'core/button',
										attributes: {
											text: __( 'Secondary', 'one-novanta-theme' ),
											className: 'is-style-outline',
										},
									},
									{
										name: 'core/button',
										attributes: {
											text: __( 'Primary', 'one-novanta-theme' ),
											className: 'is-style-fill',
										},
									},
								],
							},
						],
					},
				],
			},
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/featured-media-slider',
					},
				],
			},
		],
	},
	innerBlocks: [
		[ 'one-novanta/section-heading', {
			lock: {
				move: true,
				remove: true,
			},
		} ],
		[
			'one-novanta/section-content',
			{
				templateLock: 'all',
				lock: {
					move: true,
					remove: true,
				},
			},
			[
				[ 'one-novanta/featured-media-slider' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default featuredMediaSliderVariation;
