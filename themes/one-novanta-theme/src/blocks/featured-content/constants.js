/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

export const TEMPLATE = [
	[
		'core/heading',
		{
			placeholder: __( 'Enter heading…', 'one-novanta-theme' ),
			fontSize: 'xx-large',
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
					text: __( 'Primary', 'one-novanta-theme' ),
					className: 'is-style-fill',
				},
			],
			[
				'core/button',
				{
					text: __( 'Secondary', 'one-novanta-theme' ),
					className: 'is-style-outline',
				},
			],
		],
	],
];
