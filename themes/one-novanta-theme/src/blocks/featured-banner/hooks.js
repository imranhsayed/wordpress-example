/**
 * WordPress dependencies
 */
import { useSelect } from '@wordpress/data';

// Fetches current post data.
export const usePostData = () => {
	const postData = useSelect( ( select ) => {
		const postType = select( 'core/editor' ).getCurrentPostType();
		const allTaxonomies = select( 'core' ).getTaxonomies( { per_page: -1 } );

		return {
			postType,
			allTaxonomies,
		};
	}, [] );

	const { postType, allTaxonomies } = postData;
	const taxonomies = allTaxonomies && postType
		? allTaxonomies.filter( ( fetchedTaxonomy ) => fetchedTaxonomy.types.includes( postType ) )
		: [];

	return {
		postType,
		taxonomies,
	};
};
