/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const tilesCarouselVariation = {
	name: 'tiles-carousel',
	title: __( 'Tile Carousel', 'one-novanta-theme' ),
	attributes: {
		template: 'tiles-carousel',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'tiles-carousel',
			showDescription: false,
			showTitle: false,
			style: { spacing: { padding: { top: '0', bottom: '0' } } },
		},
		innerBlocks: [ // Not adding a section content wrapper to display the example correctly.
			{
				name: 'one-novanta/tile-carousel',
				innerBlocks: [
					{ name: 'one-novanta/image-tile' },
					{ name: 'one-novanta/image-tile' },
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
				[ 'one-novanta/tile-carousel' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default tilesCarouselVariation;
