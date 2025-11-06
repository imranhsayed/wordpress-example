/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const fiftyFiftyQuestionVariation = {
	name: 'section-50-50-question',
	title: __( '50–50 Question', 'one-novanta-theme' ),
	description: __( '50–50 Question block', 'one-novanta-theme' ),
	attributes: {
		template: 'section-50-50-question',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'section-50-50-question',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{
				name: 'one-novanta/section-heading',
			},
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/fifty-fifty-wrapper',
						attributes: {
							heading: __( 'Product Features', 'one-novanta-theme' ),
							template: 'question',
						},
						innerBlocks: [
							{
								name: 'core/heading',
								attributes: {
									content: __( 'Features & Benefits', 'one-novanta-theme' ),
									level: 3,
									fontSize: 'large',
								},
							},
							{
								name: 'core/paragraph',
								attributes: {
									content: __( 'Features', 'one-novanta-theme' ),
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
				templateLock: 'insert',
				aspectRatio: '',
			},
			[
				[
					'one-novanta/fifty-fifty-wrapper',
					{
						template: 'question',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

const fiftyFiftyContentVariation = {
	name: 'section-50-50-content',
	title: __( '50–50 Content', 'one-novanta-theme' ),
	description: __( '50–50 Content block', 'one-novanta-theme' ),
	attributes: {
		template: 'section-50-50-content',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'section-50-50-content',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/fifty-fifty-wrapper',
						attributes: {
							template: 'content',
						},
						innerBlocks: [
							{
								name: 'core/heading',
								attributes: {
									content: __( 'Trusted global provider of robotic automation solutions since 1989', 'one-novanta-theme' ),
								},
							},
							{
								name: 'core/paragraph',
								attributes: {
									content: __( 'Since 1989, our team of mechanical, electrical, and software engineers has been developing cost-effective, state-of-the-art end-effector products and solutions that improve robotic productivity. ATI was acquired by Novanta Inc. in 2021.', 'one-novanta-theme' ),
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
				templateLock: 'insert',
				aspectRatio: '',
			},
			[
				[
					'one-novanta/fifty-fifty-wrapper',
					{
						template: 'content',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export { fiftyFiftyQuestionVariation, fiftyFiftyContentVariation };
