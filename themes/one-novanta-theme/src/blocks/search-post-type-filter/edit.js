/**
 * WordPress dependencies
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useCallback, useMemo, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * An empty array reference to be used for default values or when data is not yet available.
 */
const EMPTY_ARRAY = [];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {Object}   props.attributes    Block Attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { selectedPostTypes } = attributes;

	// Last selected item for select control
	const [ lastInteractedPostTypeSlug, setLastInteractedPostTypeSlug ] = useState( '' );

	// Block props.
	const blockProps = useBlockProps( {
		className: 'one-novanta-search-filter',
	} );

	/**
	 * Fetch all registered post types using the useSelect hook.
	 * This selects the raw post types data.
	 */
	const allFetchedPostTypes = useSelect( ( select ) => {
		return select( 'core' ).getPostTypes( { per_page: -1 } );
	}, [] );

	/**
	 * Memoized derivation of available post types for selection.
	 * This transformation (filter and map) is now done with useMemo,
	 * ensuring that `availablePostTypes` only gets a new reference if `allFetchedPostTypes` changes.
	 */
	const availablePostTypes = useMemo( () => {
		if ( ! allFetchedPostTypes ) {
			// Return empty array if no post types are found yet
			return EMPTY_ARRAY;
		}

		// Filter and transform post types
		return allFetchedPostTypes
			.filter(
				( postType ) => ( postType.has_archive || postType.slug === 'post' ),
			)
			.map( ( postType ) => ( {
				slug: postType.slug,
				title: postType.name,
			} ) );
	}, [ allFetchedPostTypes ] );

	/**
	 * Memoized options for the SelectControl.
	 * Only re-calculate if availablePostTypes changes.
	 */
	const selectOptions = useMemo( () => {
		return [
			{ label: __( 'Select a post type', 'one-novanta-theme' ), value: '' },
			...availablePostTypes.map( ( type ) => ( {
				label: type.title,
				value: type.slug,
			} ) ),
		];
	}, [ availablePostTypes ] );

	/**
	 * Handles changes from the SelectControl.
	 *
	 * @param {string} postTypeSlug The slug of the post type selected/deselected.
	 */
	const onPostTypeChange = useCallback(
		( postTypeSlug ) => {
			// Update the last interacted slug for the SelectControl display
			setLastInteractedPostTypeSlug( postTypeSlug );

			if ( ! postTypeSlug ) {
				// Do nothing if the placeholder "Select a post type" is chosen
				return;
			}

			const isAlreadySelected = selectedPostTypes.some(
				( type ) => type.slug === postTypeSlug,
			);

			let updatedSelectedPostTypes;

			if ( isAlreadySelected ) {
				// If already selected, remove it
				updatedSelectedPostTypes = selectedPostTypes.filter(
					( type ) => type.slug !== postTypeSlug,
				);
			} else {
				// If not selected, add it
				const postTypeToAdd = availablePostTypes.find(
					( type ) => type.slug === postTypeSlug,
				);
				if ( postTypeToAdd ) {
					updatedSelectedPostTypes = [
						...selectedPostTypes,
						postTypeToAdd,
					];
				} else {
					// Should not happen if selectOptions are in sync with availablePostTypes
					updatedSelectedPostTypes = [ ...selectedPostTypes ];
				}
			}

			setAttributes( { selectedPostTypes: updatedSelectedPostTypes } );
		},
		[ selectedPostTypes, availablePostTypes, setAttributes ],
	);

	/**
	 * Removes a post type from the selected list.
	 *
	 * @param {string} postTypeSlugToRemove The slug of the post type to remove.
	 */
	const removePostType = useCallback(
		( postTypeSlugToRemove ) => {
			setAttributes( {
				selectedPostTypes: selectedPostTypes.filter(
					( type ) => type.slug !== postTypeSlugToRemove,
				),
			} );
			// Clear the SelectControl to the placeholder when an item is removed via the button
			setLastInteractedPostTypeSlug( '' );
		},
		[ selectedPostTypes, setAttributes ],
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'one-novanta-theme' ) }>
					<SelectControl
						label={ __( 'Add or remove post types', 'one-novanta-theme' ) }
						value={ lastInteractedPostTypeSlug }
						options={ selectOptions }
						onChange={ onPostTypeChange }
						help={ __( 'Select a post type to add it to the filter. Select it again to remove.', 'one-novanta-theme' ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ selectedPostTypes && selectedPostTypes.length > 0 ? (
					<ul className="search-filter__post-types">
						{ selectedPostTypes.map( ( postType ) => (
							<li
								key={ postType.slug }
								className="search-filter__post-type"
							>
								<span className="search-filter__post-type-link wp-one-novanta-button wp-one-novanta-button--primary">
									{ postType.title }
									<button className="search-filter__post-type-link-remove" onClick={ () => removePostType( postType.slug ) } aria-label={ __( 'Remove', 'one-novanta-theme' ) }>&times;</button>
								</span>
							</li>
						) ) }
					</ul>
				) : (
					<p>
						{ __( 'No post types selected. Please select post types from the block settings.', 'one-novanta-theme' ) }
					</p>
				) }
			</div>
		</>
	);
}
