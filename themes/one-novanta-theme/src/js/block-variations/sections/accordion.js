/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const accordionVariation = {
	name: 'accordion',
	title: __( 'Accordion', 'one-novanta-theme' ),
	description: __( 'A section with an accordion.', 'one-novanta-theme' ),
	attributes: {
		template: 'accordion',
		showDescription: false,
		showTitle: false,
	},
	innerBlocks: [
		[ 'one-novanta/section-heading' ],
		[
			'one-novanta/section-content',
			{
				templateLock: 'all',
			},
			[ [ 'one-novanta/accordion' ] ],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
	example: {
		attributes: {
			template: 'accordion',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/accordion',
						innerBlocks: [
							{
								name: 'one-novanta/accordion-item',
								attributes: {
									title: __( 'Accordion Item 1', 'one-novanta-theme' ),
									content: __( 'Content for Accordion Item 1', 'one-novanta-theme' ),
								},
							},
							{
								name: 'one-novanta/accordion-item',
								attributes: {
									title: __( 'Accordion Item 2', 'one-novanta-theme' ),
									content: __( 'Content for Accordion Item 2', 'one-novanta-theme' ),
								},
							},
						],
					},
				],
			},
		],
	},
};

export default accordionVariation;
