/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const TEMPLATE = [
	[
		'core/heading',
		{
			placeholder: __( 'Enter heading…', 'one-novanta-theme' ),
			className: 'media-text__heading',
			fontSize: 'xxx-large',
		},
	],
	[
		'core/paragraph',
		{
			placeholder: __( 'Enter description…', 'one-novanta-theme' ),
		},
	],
	[
		'core/buttons',
		{
			style: {
				spacing: {
					blockGap: 'var:preset|spacing|30',
				},
			},
		},
		[
			[
				'core/button',
				{
					text: __( 'Secondary', 'one-novanta-theme' ),
				},
			],
		],
	],
];

export default TEMPLATE;
