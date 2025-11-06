/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const latestArticlesTilesVariation = {
	name: 'latest-articles-tiles',
	title: __( 'Latest Articles: Tiles', 'one-novanta-theme' ),
	description: __( 'Display the latest articles in a tile layout.', 'one-novanta-theme' ),
	attributes: {
		template: 'latest-articles-tiles',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'latest-articles-tiles',
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
						name: 'one-novanta/latest-articles',
						attributes: {
							template: 'tiles',
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
				templateLock: 'all',
			},
			[
				[
					'one-novanta/latest-articles',
					{
						template: 'tiles',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

const latestArticlesArticleCollectionVariation = {
	name: 'latest-articles-article-collection',
	title: __( 'Latest Articles: Collection', 'one-novanta-theme' ),
	description: __( 'Display the latest articles in a collection layout.', 'one-novanta-theme' ),
	attributes: {
		template: 'latest-articles-article-collection',
		showDescription: false,
	},
	example: {
		attributes: {
			template: 'latest-articles-article-collection',
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
						name: 'one-novanta/latest-articles',
						attributes: {
							template: 'article-collection',
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
				templateLock: 'all',
			},
			[
				[
					'one-novanta/latest-articles',
					{
						template: 'article-collection',
					},
				],
			],
		],
	],
	scope: [ 'inserter' ],
	isActive: [ 'template' ],
};

export {
	latestArticlesTilesVariation,
	latestArticlesArticleCollectionVariation,
};
