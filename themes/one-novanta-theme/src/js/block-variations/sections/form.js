/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const sectionFormVariation = {
	name: 'section-form',
	title: __( 'Form', 'one-novanta-theme' ),
	description: __( 'Section with a form and supporting text.', 'one-novanta-theme' ),
	attributes: {
		template: 'section-form',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'section-form',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/form-wrapper',
						attributes: {
							template: 'form',
						},
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
				templateLock: 'insert',
				aspectRatio: '',
			},
			[
				[
					'one-novanta/form-wrapper',
					{
						template: 'form',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

const sectionFormWithMediaVariation = {
	name: 'section-form-with-media',
	title: __( 'Form with Media', 'one-novanta-theme' ),
	description: __( 'Section with a form and supporting image.', 'one-novanta-theme' ),
	attributes: {
		template: 'section-form-with-media',
		showDescription: false,
		showTitle: false,
	},
	example: {
		attributes: {
			template: 'section-form-with-media',
			showDescription: false,
			showTitle: false,
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'one-novanta/form-wrapper',
						attributes: {
							template: 'form-with-media',
						},
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
				templateLock: 'insert',
				aspectRatio: '',
			},
			[
				[
					'one-novanta/form-wrapper',
					{
						template: 'form-with-media',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export { sectionFormVariation, sectionFormWithMediaVariation };
