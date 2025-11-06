/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const latestNewsVariation = {
	name: 'latest-news',
	title: __( 'Latest News', 'one-novanta-theme' ),
	attributes: {
		template: 'latest-news',
		showDescription: false,
		showTitle: false,
		templateLock: 'insert',
	},
	example: {
		attributes: {
			template: 'latest-news',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/two-columns',
						innerBlocks: [
							{
								name: 'one-novanta/two-columns-column',
								innerBlocks: [
									{
										name: 'core/heading',
										attributes: {
											level: 2,
											content: __( 'Latest News', 'one-novanta-theme' ),
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
								name: 'one-novanta/two-columns-column',
								innerBlocks: [
									{ name: 'one-novanta/articles-collage' },
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
				lock: {
					move: true,
					remove: true,
				},
			},
			[
				[
					'one-novanta/two-columns',
					{},
					[
						// Left column with heading and paragraph
						[
							'one-novanta/two-columns-column',
							{
								allowedBlocks: [ 'core/paragraph', 'core/list', 'core/buttons' ],
								templateLock: false,
							},
							[
								[
									'core/heading',
									{
										level: 2,
										placeholder: __( 'Latest News', 'one-novanta-theme' ),
									},
								],
								[
									'core/paragraph',
									{
										placeholder: __( 'Descriptions here…', 'one-novanta-theme' ),
									},
								],
							],
						],
						// Right column with articles collage
						[
							'one-novanta/two-columns-column',
							{
								templateLock: 'insert',
							},
							[
								[ 'one-novanta/articles-collage' ],
							],
						],
					],
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default latestNewsVariation;
