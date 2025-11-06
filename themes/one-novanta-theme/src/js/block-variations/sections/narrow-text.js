/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const narrowTextMediaVariation = {
	name: 'narrow-text',
	title: __( 'Media: Narrow Content', 'one-novanta-theme' ),
	description: __( 'A default Cards with image.', 'one-novanta-theme' ),
	attributes: {
		template: 'narrow-text',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'narrow-text',
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
						name: 'one-novanta/media-text-narrow',
						attributes: {
							overline: __( 'INDUSTRY 1', 'one-novanta-theme' ),
							heading: __( 'Automotive', 'one-novanta-theme' ),
						},
					},
				],
			},
		],
	},
	innerBlocks: [
		[ 'one-novanta/section-heading', {
			style: {
				spacing: {
					margin: {
						bottom: 'var:preset|spacing|80',
					},
				},
			},
		} ],
		[
			'one-novanta/section-content',
			{
				templateLock: 'all',
			},
			[
				[ 'one-novanta/media-text-narrow' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default narrowTextMediaVariation;
