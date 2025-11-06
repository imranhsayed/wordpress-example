/**
 * WordPress dependencies
 */
import { useEffect, useState } from '@wordpress/element';
import { Modal, Button } from '@wordpress/components';
import domReady from '@wordpress/dom-ready';
import { sprintf, __ } from '@wordpress/i18n';
import { parse } from '@wordpress/blocks';
import { useSelect, useDispatch } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';

/**
 * A functional component that manages and displays a confirmation modal when changing the
 * product type in a WordPress block editor environment. The modal appears if the selected
 * product type is either 'simple' or 'variable', prompting the user to confirm or cancel
 * the change.
 *
 * The component handles the following responsibilities:
 * - Tracks the visibility of the modal using internal state (`showModal`).
 * - Tracks the currently selected product type and its previous value.
 * - Listens for changes to the product type dropdown (`product-type`), triggering the modal if required.
 * - Updates block content in the editor based on the selected product type upon confirmation.
 * - Reverts to the previous product type if the change is canceled.
 *
 * Usage of this component assumes the presence of WordPress block editor functions and
 * the `Modal` component for UI rendering.
 */
const ProductTypeModal = () => {
	const [ showModal, setShowModal ] = useState( false );
	const [ selectedProductType, setSelectedProductType ] = useState( '' );
	const [ oldProductType, setOldProductType ] = useState( '' );

	// Get current post type.
	const postType = useSelect( ( select ) => select( 'core/editor' ).getCurrentPostType() );
	const { replaceBlocks } = useDispatch( blockEditorStore );
	const { getBlocks } = useSelect( blockEditorStore );

	// Allowed post types.
	const allowedPostTypes = [ 'product' ];

	useEffect( () => {
		// Fetch product type.
		const productTypeSelect = document.getElementById( 'product-type' );

		if ( ! productTypeSelect ) {
			return;
		}

		/**
		 * Handles changes to a specific event and updates the application state accordingly.
		 *
		 * This function processes change events for certain product types and performs specific actions
		 * based on the selected product type. If the selected product type is not 'simple' or
		 * 'variable', the function exits without taking any action. For valid product types,
		 * it prevents further event propagation and updates the relevant state variables.
		 *
		 * @param {Event} event The event object triggered by a change.
		 *
		 * @return {void}
		 */
		const handleChange = ( event ) => {
			// Set selected product type and show modal.
			setSelectedProductType( event?.target?.value ?? '' );
			setShowModal( true );
		};

		// Add change event listener to product type dropdown.
		productTypeSelect?.addEventListener( 'change', handleChange, true );

		// Initialize on first-load.
		setSelectedProductType( productTypeSelect.value );
		setOldProductType( productTypeSelect.value );

		return () => {
			productTypeSelect?.removeEventListener( 'change', handleChange, true );
		};
	}, [] );

	/**
	 * Updates the content of the block editor based on the given product type.
	 *
	 * This function removes all existing blocks in the block editor and replaces them
	 * with a predefined block or pattern specific to the provided product type. The function
	 * supports two product types: 'simple' and 'variable'. If the product type does not match
	 * either of these, no action is taken.
	 *
	 * @param {string} productType The type of product determining the block or pattern to insert. Accepted values: 'simple', 'variable'.
	 *
	 * @return {void}
	 */
	const updateBlock = ( productType ) => {
		let newContent = '';

		// Define the block(s) or pattern to insert
		switch ( productType ) {
			case 'variable':
				newContent = '<!-- wp:one-novanta/product-variation-content /-->';
				break;
			default:
				newContent = '<!-- wp:pattern {"slug":"one-novanta-theme/product-tabs"} /-->';
		}

		// Remove all blocks.
		const currentBlocks = getBlocks();
		const rootClientIds = currentBlocks?.map( ( block ) => block.clientId );

		// Parse content into blocks.
		const parsedBlocks = parse( newContent );

		// Replace all blocks with new ones.
		if ( parsedBlocks?.length > 0 && rootClientIds?.length > 0 ) {
			replaceBlocks( rootClientIds, parsedBlocks );
		}
	};

	/**
	 * Handler function executed when a confirmation action is triggered via modal.
	 *
	 * This function updates the selected product type in the UI by setting the
	 * value of the product-type select element and dispatching a change event
	 * to trigger associated updates. It also manages the state of the modal visibility
	 * and stores the previous product type.
	 */
	const onConfirm = () => {
		const productTypeSelect = document.getElementById( 'product-type' );

		if ( ! productTypeSelect || ! selectedProductType ) {
			return;
		}

		// Update the product-type dropdown.
		productTypeSelect.value = selectedProductType;

		// Replace blocks.
		updateBlock( selectedProductType );

		// Cache old product type.
		setOldProductType( selectedProductType );

		// Hide modal.
		setShowModal( false );
	};

	/**
	 * A callback function executed when a cancel action is triggered via modal.
	 *
	 * This function performs the following tasks:
	 * 1. Resets the "product-type" dropdown field to its previous value if the dropdown exists.
	 * 2. Hides the current modal by updating its visibility state.
	 */
	const onCancel = () => {
		const productTypeSelect = document.getElementById( 'product-type' );

		if ( ! productTypeSelect ) {
			return;
		}

		// Reset product-type dropdown.
		productTypeSelect.value = oldProductType;

		// Dispatch change event.
		const event = new Event( 'change', { bubbles: true } );
		productTypeSelect.dispatchEvent( event );

		// Hide modal.
		setShowModal( false );
	};

	return (
		showModal && allowedPostTypes.includes( postType ) && (
			<Modal
				title={
					sprintf(
						// Translators: %s is the product type.
						__( 'Change Product Type to %s?', 'one-novanta-theme' ),
						( String( selectedProductType )?.charAt( 0 )?.toUpperCase() ?? '' ) + ( String( selectedProductType )?.slice( 1 ) ?? '' ),
					)
				}
				onRequestClose={ onCancel }
				shouldCloseOnClickOutside={ true }
			>
				<p>{
					// Translators: %s is the product type.
					sprintf( __( 'Changing product to %s type will remove all the content form current post.', 'one-novanta-theme' ), selectedProductType )
				}</p>
				<Button isPrimary onClick={ onConfirm }>
					{ __( 'Confirm', 'one-novanta-theme' ) }
				</Button>
			</Modal>
		)
	);
};

domReady( () => {
	const target = document.createElement( 'div' );
	document.body.appendChild( target );
	wp.element.render( <ProductTypeModal />, target ); // Append Modal.
} );
