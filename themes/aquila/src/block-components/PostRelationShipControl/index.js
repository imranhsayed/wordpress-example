/**
 * WordPress dependencies
 */
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Relationship from '../Relationship';

/**
 * PostRelationShipControl Component
 *
 * A component that allows users to search and select multiple posts via a modal
 *
 * @param {Object}   props               - Component props
 * @param {Array}    props.selectedPosts - Array of selected post IDs
 * @param {Function} props.onChange      - Callback when selection changes
 * @param {string}   props.postType      - Post type to search (default: 'post')
 * @param {number}   props.maxPosts      - Maximum number of posts that can be selected
 * @param {string}   props.label         - Label for the control
 * @param {string}   props.buttonLabel   - Label for the select button
 * @param {string}   props.modalTitle    - Title for the modal
 * @return {JSX.Element} The component
 */
export default function PostRelationShipControl({
	selectedPosts = [],
	onChange,
	postType = 'post',
	maxPosts = 20,
	label = __('Posts', 'aquila-theme'),
	buttonLabel = __('Select Posts', 'aquila-theme'),
	modalTitle = __('Select Posts', 'aquila-theme'),
}) {
	// Get the selected posts details
	const initialItems = useSelect(
		(select) => {
			if (!selectedPosts || selectedPosts.length === 0) {
				return [];
			}

			return selectedPosts
				.map((postId) => {
					const post = select(coreStore).getEntityRecord(
						'postType',
						postType,
						postId
					);
					if (!post) {
						return null;
					}
					return {
						id: post.id,
						value: post.id,
						label:
							post.title.rendered ||
							__('(no title)', 'aquila-theme'),
					};
				})
				.filter(Boolean);
		},
		[selectedPosts, postType]
	);

	// Search query function for posts
	const searchQuery = (query = '') => {
		return new Promise((resolve) => {
			// WordPress REST API uses plural form for post types
			const restBase = postType === 'post' ? 'posts' : postType + 's';

			const searchParam = query
				? `&search=${encodeURIComponent(query)}`
				: '';

			apiFetch({
				path: `/wp/v2/${restBase}?per_page=20&_fields=id,title${searchParam}`,
			})
				.then((posts) => {
					const results = posts.map((post) => ({
						id: post.id,
						value: post.id,
						label:
							post.title.rendered ||
							__('(no title)', 'aquila-theme'),
					}));
					resolve(results);
				})
				.catch(() => {
					resolve([]);
				});
		});
	};

	return (
		<Relationship
			initialItems={initialItems}
			label={label}
			searchQuery={searchQuery}
			buttonLabel={buttonLabel}
			modalTitle={modalTitle}
			max={maxPosts}
			onSelect={onChange}
		/>
	);
}
