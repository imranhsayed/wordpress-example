/**
 * WordPress dependencies
 */
import { InspectorControls as BaseInspectorControls } from '@wordpress/block-editor';
import { PanelBody, QueryControls, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

/**
 * Internal dependencies
 */
import PostRelationShipControl from '../../block-components/PostRelationShipControl';

export default function InspectorControls({ attributes, setAttributes }) {
	const {
		mode = 'automatic',
		selectedPosts = [],
		categoryId,
		order = 'asc',
		orderBy = 'title',
		numberOfItems = 4,
	} = attributes;

	const categories = useSelect((select) => {
		const query = { per_page: -1, hide_empty: false };
		return select(coreStore).getEntityRecords(
			'taxonomy',
			'category',
			query
		);
	}, []);

	return (
		<BaseInspectorControls>
			<PanelBody title={__('Settings', 'aquila-theme')}>
				<SelectControl
					label={__('Display Mode', 'aquila-theme')}
					value={mode}
					options={[
						{
							label: __('Automatic', 'aquila-theme'),
							value: 'automatic',
						},
						{
							label: __('Manual', 'aquila-theme'),
							value: 'manual',
						},
					]}
					onChange={(newMode) => {
						setAttributes({ mode: newMode });
					}}
					help={
						mode === 'automatic'
							? __(
									'Automatically fetch latest posts based on criteria below',
									'aquila-theme'
								)
							: __(
									'Manually select posts to display',
									'aquila-theme'
								)
					}
				/>
			</PanelBody>

			{mode === 'automatic' && (
				<PanelBody title={__('Query Settings', 'aquila-theme')}>
					<QueryControls
						categoriesList={categories}
						selectedCategoryId={categoryId}
						onCategoryChange={(id) => {
							if (!id) {
								setAttributes({ categoryId: 0 });
								return;
							}
							setAttributes({ categoryId: parseInt(id, 10) });
						}}
						order={order}
						orderBy={orderBy}
						onOrderChange={(newOrder) =>
							setAttributes({ order: newOrder })
						}
						onOrderByChange={(newOrderBy) =>
							setAttributes({ orderBy: newOrderBy })
						}
						numberOfItems={numberOfItems}
						onNumberOfItemsChange={(newCount) =>
							setAttributes({ numberOfItems: newCount })
						}
					/>
				</PanelBody>
			)}

			{mode === 'manual' && (
				<PanelBody
					title={__('Manual Selection', 'aquila-theme')}
					initialOpen={true}
				>
					<PostRelationShipControl
						selectedPosts={selectedPosts}
						onChange={(newSelectedPosts) => {
							setAttributes({ selectedPosts: newSelectedPosts });
						}}
						postType="post"
						maxPosts={20}
						label=""
						buttonLabel={__('Select Posts', 'aquila-theme')}
						modalTitle={__('Select Posts', 'aquila-theme')}
					/>
				</PanelBody>
			)}
		</BaseInspectorControls>
	);
}
