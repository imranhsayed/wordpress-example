/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const separator = {
	name: 'one-novanta/separator',
	title: __( 'Separator', 'one-novanta-theme' ),
	icon: 'media-interactive',
	description: __( 'A custom separator block for OneNovanta theme.', 'one-novanta-theme' ),
	attributes: {
		template: 'separator',
		showTitle: false,
		showDescription: false,
		style: {
			spacing: {
				padding: {
					top: 'var:preset|spacing|40',
					bottom: 'var:preset|spacing|40',
				},
			},
		},
	},
	example: {
		attributes: {
			template: 'separator',
			showTitle: false,
			showDescription: false,
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|40',
						bottom: 'var:preset|spacing|40',
					},
				},
			},
		},
		innerBlocks: [
			{ name: 'one-novanta/section-heading' },
			{
				name: 'one-novanta/section-content',
				attributes: { templateLock: 'all' },
				innerBlocks: [
					{
						name: 'core/separator',
						attributes: {
							style: {
								spacing: {
									margin: {
										top: '0',
										bottom: '0',
									},
									padding: {
										top: '0',
										bottom: '0',
									},
								},
							},
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
					'core/separator',
					{
						style: {
							spacing: {
								margin: {
									top: '0',
									bottom: '0',
								},
								padding: {
									top: '0',
									bottom: '0',
								},
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

export default separator;
