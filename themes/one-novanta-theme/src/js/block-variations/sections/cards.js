/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const cardsVariations = {
	name: 'cards',
	title: __( 'Cards', 'one-novanta-theme' ),
	attributes: {
		template: 'cards',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'cards',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/cards',
						innerBlocks: [
							{
								name: 'one-novanta/card',
								attributes: {
									heading: __( 'Card Heading 1', 'one-novanta-theme' ),
									content: __( 'Content for Card Heading 1', 'one-novanta-theme' ),
								},
							},
							{
								name: 'one-novanta/card',
								attributes: {
									heading: __( 'Card Heading 2', 'one-novanta-theme' ),
									content: __( 'Content for Card Heading 2', 'one-novanta-theme' ),
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
				[ 'one-novanta/cards' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default cardsVariations;
