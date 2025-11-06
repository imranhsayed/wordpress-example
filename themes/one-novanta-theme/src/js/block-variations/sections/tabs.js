/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const tabsVariation = {
	name: 'tabs',
	title: __( 'Tabs', 'one-novanta-theme' ),
	attributes: {
		template: 'tabs',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'tabs',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{ name: 'one-novanta/tabs' },
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
				[ 'one-novanta/tabs' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default tabsVariation;
