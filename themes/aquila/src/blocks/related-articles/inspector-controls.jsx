/**
 * WordPress dependencies
 */
import { InspectorControls as BaseInspectorControls } from '@wordpress/block-editor';
import { PanelBody, QueryControls } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

export default function InspectorControls( {
	attributes,
	setAttributes,
} ) {
	const {
		categoryId,
		order = 'asc',
		orderBy = 'title',
		numberOfItems = 4,
	} = attributes;

	const categories = useSelect( ( select ) => {
		const query = { per_page: -1, hide_empty: false };
		return select( coreStore ).getEntityRecords(
			'taxonomy',
			'category',
			query,
		);
	}, [] );

	return (
		<BaseInspectorControls>
			<PanelBody title={ __( 'Content', 'aquila-theme' ) }>
				<QueryControls
					categoriesList={ categories }
					selectedCategoryId={ categoryId }
					onCategoryChange={ ( id ) => {
						if ( ! id ) {
							setAttributes( { categoryId: 0 } );
							return;
						}
						setAttributes( { categoryId: parseInt( id, 10 ) } );
					} }
					order={ order }
					orderBy={ orderBy }
					onOrderChange={ ( newOrder ) =>
						setAttributes( { order: newOrder } )
					}
					onOrderByChange={ ( newOrderBy ) =>
						setAttributes( { orderBy: newOrderBy } )
					}
					numberOfItems={ numberOfItems }
					onNumberOfItemsChange={ ( newCount ) =>
						setAttributes( { numberOfItems: newCount } )
					}
				/>
			</PanelBody>
		</BaseInspectorControls>
	);
}
