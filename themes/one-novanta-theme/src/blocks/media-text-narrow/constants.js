/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

// Default template for the media text narrow block
export const DEFAULT_TEMPLATE = [
	[
		'core/paragraph',
		{
			placeholder: __( 'Add media text content', 'one-novanta-theme' ),
			content: __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'one-novanta-theme' ),
		},
	],
	[
		'core/buttons',
		{},
		[
			[
				'core/button',
				{
					text: __( 'About us', 'one-novanta-theme' ),
					placeholder: __( 'Add Button Text', 'one-novanta-theme' ),
					className: 'is-style-outline',
				},
			],
			[
				'core/button',
				{
					text: __( 'Contact us', 'one-novanta-theme' ),
					placeholder: __( 'Add Button Text', 'one-novanta-theme' ),
				},
			],
		],
	],
];

// Allowed image type
export const ALLOWED_IMAGE_TYPE = [ 'image' ];
