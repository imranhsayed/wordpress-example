/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const tilesVariation = {
	name: 'tiles',
	title: __( 'Tiles', 'one-novanta-theme' ),
	attributes: {
		template: 'tiles',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'tiles',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/tiles',
						attributes: {
							numberOfColumns: 2,
						},
						innerBlocks: [
							{
								name: 'one-novanta/tile',
								attributes: {
									heading: __( 'Heading 1', 'one-novanta-theme' ),
									subheading: __( 'Sub-Heading 1', 'one-novanta-theme' ),
								},
							},
							{
								name: 'one-novanta/tile',
								attributes: {
									heading: __( 'Heading 2', 'one-novanta-theme' ),
									subheading: __( 'Sub-Heading 2', 'one-novanta-theme' ),
								},
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
				[ 'one-novanta/tiles' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default tilesVariation;
