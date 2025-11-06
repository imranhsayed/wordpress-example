/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useEffect } from '@wordpress/element';
import { createBlock } from '@wordpress/blocks';
import { useDispatch, useSelect } from '@wordpress/data';
import { PanelBody, SelectControl, Spinner } from '@wordpress/components';
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { decodeHtmlEntities } from '../../js/utils';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.clientId      A unique identifier assigned to each block instance.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { attributes, setAttributes, clientId } ) {
	const { numberOfPosts = 3 } = attributes;

	const { replaceInnerBlocks } = useDispatch( 'core/block-editor' );
	const { getBlocks } = useSelect( ( select ) => select( 'core/block-editor' ), [] );

	const blockProps = useBlockProps( {
		className: 'component-collage-editor',
	} );

	// Get latest posts with featured images, limited by numberOfPosts.
	const posts = useSelect( ( select ) => {
		const { getEntityRecords } = select( 'core' );
		const allPosts = getEntityRecords( 'postType', 'post', {
			per_page: 10, // Fetch a few more just in case some don't have images
			_embed: true,
		} ) || [];

		// Filter posts that have a featured image
		return allPosts.filter( ( post ) => post.featured_media !== 0 ).slice( 0, numberOfPosts );
	}, [ numberOfPosts ] );

	/**
	 * If we have posts with featured images, use them.
	 * Otherwise, create empty tiles (fallbacks).
	 */
	const source = posts.length > 0
		? posts
		: new Array( numberOfPosts ).fill( {} ); // Array of empty objects for dummy blocks

	// Map posts to image-tile blocks.
	const postBlocks = source.map( ( post ) => {
		const media = post._embedded?.[ 'wp:featuredmedia' ]?.[ 0 ];
		const imageURL = media?.media_details?.sizes?.large?.source_url || media?.link || '';
		const imageAlt = media?.alt_text || '';

		const category = decodeHtmlEntities( post._embedded?.[ 'wp:term' ]?.[ 0 ]?.[ 0 ]?.name );

		return createBlock( 'one-novanta/image-tile', {
			heading: post.title?.rendered || '',
			preHeading: category ? category : '',
			link: { url: post.link || '' },
			imageID: post.featured_media || null,
			imageURL,
			imageAlt,
			imageRatio: '3:2',
			imageSize: 'large',
		} );
	} );

	// Re-render Dummy Innerblocks once, posts are fetched.
	useEffect( () => {
		if ( posts.length === 0 ) {
			return;
		}

		// Always replace inner blocks with post blocks when posts are ready
		replaceInnerBlocks( clientId, postBlocks, false );
	}, [ posts, postBlocks.length, getBlocks, replaceInnerBlocks, clientId, postBlocks ] );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Articles Collage Settings', 'one-novanta-theme' ) }>
					<SelectControl
						label={ __( 'Number of Posts', 'one-novanta-theme' ) }
						value={ numberOfPosts }
						options={ [
							{ label: '3', value: 3 },
							{ label: '5', value: 5 },
						] }
						onChange={ ( value ) => setAttributes( { numberOfPosts: parseInt( value, 10 ) } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ posts.length === 0 &&
					<p>
						{ __( 'Loading posts…', 'one-novanta-theme' ) }
						<Spinner />
					</p>
				}
				{ posts.length > 0 &&
					<InnerBlocks
						allowedBlocks={ [ 'one-novanta/image-tile' ] }
						template={ postBlocks.map( ( b ) => [ b.name, b.attributes ] ) }
						templateLock="all"
					/>
				}
			</div>
		</>
	);
}
