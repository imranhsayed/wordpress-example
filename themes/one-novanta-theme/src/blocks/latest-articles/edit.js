/**
 * WordPress dependencies
 */
import {
	useBlockProps,
	InspectorControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	QueryControls,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Internal dependencies
 */
import HeadingLevel from '../../js/block-components/heading-level';

export default function Edit( { attributes, setAttributes } ) {
	const {
		categoryId,
		order = 'asc',
		orderBy = 'title',
		numberOfItems = 4,
		headingLevel = 'h3',
	} = attributes;

	const categories = useSelect( ( select ) => {
		const query = { per_page: -1, hide_empty: false };
		return select( coreStore ).getEntityRecords( 'taxonomy', 'category', query );
	}, [] );

	const baseClassName = 'latest-articles-block';

	const blockProps = useBlockProps( {
		className: `${ baseClassName } alignfull`,
	} );

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<HeadingLevel
					headingLevel={ headingLevel }
					setHeadingLevel={ ( level ) => setAttributes( { headingLevel: level } ) }
				/>
				<PanelBody title={ __( 'Content', 'one-novanta-theme' ) }>
					<QueryControls
						categoriesList={ categories }
						selectedCategoryId={ categoryId }
						onCategoryChange={ ( id ) => {
							if ( ! id ) {
								setAttributes( { categoryId: 0 } );
								return;
							}
							setAttributes( { categoryId: parseInt( id, 10 ) } );
						}
						}
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
			</InspectorControls>

			<ServerSideRender
				block="one-novanta/latest-articles"
				attributes={ attributes }
			/>
		</div>
	);
}
