/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const yourQuoteTableVariation = {
	name: 'your-quote-table',
	title: __( 'Your Quote Table', 'one-novanta-theme' ),
	attributes: {
		template: 'your-quote-table',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'your-quote-table',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{ name: 'one-novanta/your-quote-table' },
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
				[ 'one-novanta/your-quote-table' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default yourQuoteTableVariation;
