/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const formMedia = {
	name: 'one-novanta/media-form-variation',
	title: __( 'Form with Image', 'one-novanta-theme' ),
	attributes: {
		template: 'one-novanta/media-form-variation',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'one-novanta/media-form-variation',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{ name: 'one-novanta/media-form' },
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
				[ 'one-novanta/media-form' ],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default formMedia;
