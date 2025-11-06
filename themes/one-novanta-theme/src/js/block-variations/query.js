/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import domReady from '@wordpress/dom-ready';
import { addFilter } from '@wordpress/hooks';
import { registerBlockVariation } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

domReady( () => {
	registerBlockVariation(
		'core/query',
		{
			name: 'one-novanta/product-search-query-block',
			title: __( 'Product Search Query', 'one-novanta-theme' ),
			description: __( 'An interactive block for product search.', 'one-novanta-theme' ),
			attributes: {
				namespace: 'one-novanta/product-search-query-block',
				align: 'wide',
			},
			category: 'one-novanta',
			usesContext: [ 'query' ],
			innerBlocks: [
				[
					'one-novanta/product-search',
					{
						lock: {
							move: true,
							remove: true,
						},
					},
					[],
				],
			],
			scope: [ 'inserter' ],
			isActive: [ 'namespace' ],
			allowedControls: [ 'taxQuery', 'postType' ],
			supports: {
				templateLock: 'all',
			},
			example: {
				attributes: {
					postType: 'post',
					perPage: 6,
					taxQuery: {},
					namespace: 'one-novanta/product-search-query-block',
					align: 'wide',
				},
				innerBlocks: [
					{
						name: 'one-novanta/product-search',
						attributes: {
							postType: 'post',
							perPage: 6,
							taxQuery: {},
						},
					},
				],
			},
		},
	);
} );

// helper to detect your variation
const isMyProductSearchVariation = ( props ) => {
	return (
		props.name === 'core/query' &&
		props.attributes.namespace === 'one-novanta/product-search-query-block'
	);
};

// the HOC that injects our SelectControl
const withProductSearchQueryControls = ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isMyProductSearchVariation( props ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const query = attributes.query || {};
		const { perPage = 6 } = query;

		return (
			<>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title={ __( 'Product Sort Options', 'one-novanta-theme' ) } initialOpen={ true }>
						<RangeControl
							min={ 1 }
							max={ 50 }
							step={ 1 }
							value={ perPage }
							onChange={ ( value ) => {
								setAttributes( {
									query: {
										...query,
										perPage: value,
									},
								} );
							} }
							defaultValue={ 6 }
							label={ __( 'Posts per page', 'one-novanta-theme' ) }
						/>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
};

// Apply filter
addFilter( 'editor.BlockEdit', 'core/query', withProductSearchQueryControls );
