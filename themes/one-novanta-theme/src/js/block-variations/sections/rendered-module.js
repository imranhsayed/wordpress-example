/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const relatedModulesVariation = {
	name: 'related-modules',
	title: __( 'Related Modules', 'one-novanta-theme' ),
	attributes: {
		template: 'related-modules',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'related-modules',
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
					{ name: 'one-novanta/related-modules' },
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
				[ 'one-novanta/related-modules' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default relatedModulesVariation;
