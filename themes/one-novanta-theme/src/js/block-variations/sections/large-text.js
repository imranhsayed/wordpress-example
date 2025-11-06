/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const largeText = {
	name: 'large-text',
	title: __( 'Large Text', 'one-novanta-theme' ),
	attributes: {
		template: 'large-text',
		showTitle: false,
		showDescription: false,
		className: 'large-text-block',
	},
	example: {
		attributes: {
			template: 'large-text',
			showDescription: false,
			showTitle: false,
			className: 'large-text-block',
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				innerBlocks: [
					{
						name: 'core/paragraph',
						attributes: {
							fontSize: 'xx-large',
							className: 'large-text-block__text',
							content: __( 'Unleash robotic precision and control with the highest resolution force/torque sensors available', 'one-novanta-theme' ),
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
			{ templateLock: 'all' },
			[
				[
					'core/paragraph',
					{
						fontSize: 'xx-large',
						placeholder: __( 'Write your text here…', 'one-novanta-theme' ),
						className: 'large-text-block__text',
						fontFamily: 'heading',
						style: {
							typography: {
								fontStyle: 'normal',
								fontWeight: '600',
							},
						},
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export default largeText;
