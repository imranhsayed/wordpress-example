/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const imageTextCards = {
	name: 'image-text-cards',
	title: __( 'Image Text Cards', 'one-novanta-theme' ),
	description: __( 'Cards with image.', 'one-novanta-theme' ),
	attributes: {
		template: 'image-text-cards',
		showDescription: false,
		templateLock: 'insert',
	},
	example: {
		attributes: {
			template: 'image-text-cards',
			showDescription: false,
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
				],
			},
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/image-text-cards',
					},
				],
			},
		],
	},
	innerBlocks: [
		[ 'one-novanta/section-heading', {
			textAlign: 'center',
		} ],
		[
			'one-novanta/section-content',
			{
				lock: {
					move: true,
					remove: true,
				},
			},
			[
				[ 'one-novanta/image-text-cards' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default imageTextCards;
