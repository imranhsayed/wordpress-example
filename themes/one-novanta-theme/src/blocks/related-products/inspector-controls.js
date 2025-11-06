/**
 * WordPress dependencies
 */
import { InspectorControls as BaseInspectorControls } from '@wordpress/block-editor';
import { PanelBody, QueryControls } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function InspectorControls( { attributes, setAttributes } ) {
	const {
		order = 'asc',
		orderBy = 'title',
		numberOfItems = 4,
	} = attributes;

	return (
		<BaseInspectorControls>
			<PanelBody title={ __( 'Content', 'one-novanta-theme' ) }>
				<QueryControls
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
