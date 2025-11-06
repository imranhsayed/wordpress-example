/**
 * Component: Your Quote Table.
 */

/**
 * Internal dependencies
 */
import { debounce, keySpecificDebounce } from '../../../js/utils';

/* globals WooCommerceCart, gform */

/**
 * OneNovantaYourQuoteTable is a class responsible for managing and interacting with
 * a "Your Quote" table component in a shopping cart or e-commerce interface.
 *
 * It provides functionalities to bind events, update product quantities,
 * remove individual products, and manage cart actions like clearing all products.
 */
class OneNovantaYourQuoteTable {
	/**
	 * Button element.
	 *
	 * @type {HTMLElement}
	 */
	yourQuoteTableComponent;

	/**
	 * Updates the product information in the user's shopping cart.
	 */
	updateProductCart;

	/**
	 * Removes the product from the user's shopping cart.
	 */
	removeProductFromCart;

	/**
	 * Removes all products from the user's shopping cart.
	 */
	removeAllProductsFromCart;

	/**
	 * Constructor.
	 *
	 * @param {HTMLElement} yourQuoteTableComponent Your Quote Table component.
	 *
	 * @return {void}
	 */
	constructor( yourQuoteTableComponent ) {
		if ( ! yourQuoteTableComponent ) {
			return;
		}

		this.yourQuoteTableComponent = yourQuoteTableComponent;

		// Update product cart debounce.
		this.updateProductCart = keySpecificDebounce( ( key, quantity, callback = null ) => {
			if ( ! key || ! quantity ) {
				return;
			}

			WooCommerceCart.update( key, parseInt( quantity ), callback );
		}, 500 );

		// Remove product cart debounce.
		this.removeProductFromCart = keySpecificDebounce( ( key, callback = null ) => {
			if ( ! key ) {
				return;
			}

			WooCommerceCart.remove( key, callback );
		}, 500 );

		// Remove all products from cart debounce.
		this.removeAllProductsFromCart = debounce( ( callback = null ) => {
			WooCommerceCart.removeAll( callback );
		}, 500 );

		// Bind events.
		this.bindEvents();

		const summaryCells = this.yourQuoteTableComponent.querySelectorAll( '.wp-one-novanta-your-quote-table__body-content--summary' );

		// Truncate the summary before setting table height.
		summaryCells.forEach( ( summaryCell ) => {
			this.truncateHtmlElementContent( summaryCell );
		} );

		// Set table height.
		this.setTableHeight();
	}

	/**
	 * Bind events.
	 *
	 * @return {void}
	 */
	bindEvents() {
		window.addEventListener( 'resize', debounce( () => {
			this.setTableHeight();
		}, 100 ) );

		// Add event to remove product buttons.
		const removeButtons = this.yourQuoteTableComponent?.querySelectorAll( '.wp-one-novanta-your-quote-table__body-cell.wp-one-novanta-your-quote-table__body-cta a' ) ?? [];
		removeButtons?.forEach( ( removeButton ) => removeButton.addEventListener( 'click', ( event ) => this.removeProduct( event ) ) );

		// Add event to increase product quantity buttons.
		const increaseQuantityButtons = this.yourQuoteTableComponent?.querySelectorAll( '.wp-one-novanta-your-quote-table__body-content--quantity__plus' ) ?? [];
		increaseQuantityButtons?.forEach( ( increaseQuantityButton ) => increaseQuantityButton.addEventListener( 'click', ( event ) => this.updateProductQuantity( event, 'increase' ) ) );

		// Add event to decrease product quantity buttons.
		const decreaseQuantityButtons = this.yourQuoteTableComponent?.querySelectorAll( '.wp-one-novanta-your-quote-table__body-content--quantity__minus' ) ?? [];
		decreaseQuantityButtons?.forEach( ( decreaseQuantityButton ) => decreaseQuantityButton.addEventListener( 'click', ( event ) => this.updateProductQuantity( event, 'decrease' ) ) );

		// Add event to product quantity inputs.
		const quantityInputs = this.yourQuoteTableComponent?.querySelectorAll( '.wp-one-novanta-your-quote-table__body-content--quantity__input input' );
		quantityInputs?.forEach( ( quantityInput ) => quantityInput.addEventListener( 'change', ( event ) => this.onQuantityValueChange( event ) ) );

		// Add event to Clear Quote buttons.
		const clearQuoteButton = this.yourQuoteTableComponent.querySelector( '.wp-one-novanta-your-quote-table__clear-quote' );
		clearQuoteButton.addEventListener( 'click', ( event ) => this.removeAllProducts( event ) );

		// Add filter to clear cart when quote is submitted.
		gform?.utils?.addFilter( 'gform/ajax/post_ajax_submission', ( data ) => this.onQuoteSubmit( data ) );
	}

	/**
	 * Enables the loading state by adding the 'loading' class to the 'yourQuoteTableComponent' element.
	 *
	 * @return {void}
	 */
	enableLoading() {
		this.yourQuoteTableComponent.classList.add( 'loading' );
	}

	/**
	 * Disables the loading state by removing the 'loading' class from the `yourQuoteTableComponent` element.
	 *
	 * @return {void}
	 */
	disableLoading() {
		this.yourQuoteTableComponent.classList.remove( 'loading' );
	}

	/**
	 * Callback event to fire when quantity changes.
	 *
	 * @param {Event} event Change event.
	 *
	 * @return {void}
	 */
	onQuantityValueChange( event ) {
		event?.preventDefault();

		const quantityInput = event?.target;

		if ( ! quantityInput ) {
			return;
		}

		let currentValue = quantityInput?.value;

		if ( ! currentValue ) {
			currentValue = quantityInput.min;
		}

		currentValue = parseInt( currentValue );
		const maxValue = parseInt( quantityInput.max );

		const quantityInputContainer = quantityInput?.closest( '.wp-one-novanta-your-quote-table__body-content--quantity__input' );

		this.enableLoading();

		if ( maxValue < currentValue ) {
			quantityInput.value = maxValue;
			this.maybeDisableQuantityUpdate( quantityInputContainer );
			this.updateProductCart( this.getKeyProductKeyFromInput( quantityInput ), maxValue, this.disableLoading.bind( this ) );
			return;
		}

		const minValue = parseInt( quantityInput.min );
		if ( minValue > currentValue ) {
			quantityInput.value = minValue;
			this.maybeDisableQuantityUpdate( quantityInputContainer );
			this.updateProductCart( this.getKeyProductKeyFromInput( quantityInput ), minValue, this.disableLoading.bind( this ) );
			return;
		}

		quantityInput.value = currentValue;
		this.maybeDisableQuantityUpdate( quantityInputContainer );
		this.updateProductCart( this.getKeyProductKeyFromInput( quantityInput ), currentValue, this.disableLoading.bind( this ) );
	}

	/**
	 * Updates the product quantity in the input field and ensures it remains within the allowed range.
	 * The method can increase or decrease the quantity based on the specified operation.
	 * If the quantity is updated, it triggers the cart update process.
	 *
	 * @param {Event}  event                  The event object that triggered the quantity update.
	 * @param {string} [operation='increase'] Specifies the operation to perform: 'increase' or 'decrease'. Defaults to 'increase'.
	 *
	 * @return {void} This method does not return a value.
	 */
	updateProductQuantity( event, operation = 'increase' ) {
		event?.preventDefault();

		const quantityInputContainer = event?.target?.closest( '.wp-one-novanta-your-quote-table__body-content--quantity__input' );
		const quantityInput = quantityInputContainer?.querySelector( 'input' );

		// Check if quantity input exists.
		if ( ! quantityInputContainer || ! quantityInput ) {
			return;
		}

		// Get old quantity.
		const oldQuantity = quantityInput.value;

		// Increase or decrease quantity.
		if ( 'increase' === operation ) {
			quantityInput.value = parseInt( quantityInput.value ) + 1;
		} else {
			quantityInput.value = parseInt( quantityInput.value ) - 1;
		}

		// Check if quantity is within range.
		if ( parseInt( quantityInput.max ) < parseInt( quantityInput.value ) ) {
			quantityInput.value = quantityInput.max;
		}

		// Check if quantity is within range.
		if ( parseInt( quantityInput.min ) > parseInt( quantityInput.value ) ) {
			quantityInput.value = quantityInput.min;
		}

		// Disable buttons if quantity is at min or max.
		this.maybeDisableQuantityUpdate( quantityInputContainer );

		// Update cart if quantity has changed.
		if ( oldQuantity === quantityInput.value ) {
			return;
		}

		this.enableLoading();

		// Update cart.
		this.updateProductCart( this.getKeyProductKeyFromInput( quantityInput ), quantityInput.value, this.disableLoading.bind( this ) );
	}

	/**
	 * Callback function to fire when remove product button is clicked.
	 *
	 * @param {Event} event Click Event.
	 *
	 * @return {void}
	 */
	removeProduct( event ) {
		event?.preventDefault();

		const table = this.yourQuoteTableComponent?.querySelector( '.wp-one-novanta-your-quote-table__wrapper' );
		const tableRow = event?.target?.closest( '.wp-one-novanta-your-quote-table__body-row' );

		if ( ! table || ! tableRow ) {
			return;
		}

		this.enableLoading();

		table.deleteRow( tableRow.rowIndex );

		this.yourQuoteTableComponent?.setAttribute( 'data-row-count', String( parseInt( this.yourQuoteTableComponent?.getAttribute( 'data-row-count' ) ?? 1 ) - 1 ) );

		const key = tableRow?.getAttribute( 'data-key' );

		this.removeProductFromCart( key, this.disableLoading.bind( this ) );
	}

	/**
	 * Callback function to fire when clear quote (remove all product) button is clicked.
	 *
	 * @param {Event|null} event Click Event.
	 *
	 * @return {void}
	 */
	removeAllProducts( event = null ) {
		event?.preventDefault();

		const tableRows = this.yourQuoteTableComponent?.querySelectorAll( '.wp-one-novanta-your-quote-table__body-row' );
		const table = this.yourQuoteTableComponent?.querySelector( '.wp-one-novanta-your-quote-table__wrapper' );

		if ( ! table || ! tableRows ) {
			return;
		}

		this.enableLoading();

		tableRows.forEach( ( tableRow ) => table.deleteRow( tableRow.rowIndex ) );

		this.yourQuoteTableComponent.setAttribute( 'data-row-count', 0 );

		this.removeAllProductsFromCart( this.disableLoading.bind( this ) );
	}

	/**
	 * Sets table height on page load and screen size change.
	 *
	 * @return {void}
	 */
	setTableHeight() {
		const root = document.documentElement;
		const yourQuoteTable = this.yourQuoteTableComponent.querySelector( '.wp-one-novanta-your-quote-table__wrapper' );

		if ( ! yourQuoteTable ) {
			return;
		}

		const headRowHeight = ( this.yourQuoteTableComponent.querySelector( '.wp-one-novanta-your-quote-table__wrapper .wp-one-novanta-your-quote-table__head-row' ) )?.offsetHeight;
		const tableRows = Array.from( ( this.yourQuoteTableComponent.querySelectorAll( '.wp-one-novanta-your-quote-table__wrapper .wp-one-novanta-your-quote-table__body-row' ) ?? [] ) ).slice( 0, 5 );

		const tableRowsHeight = [];

		tableRows.forEach( ( tableRow ) => tableRowsHeight.push( tableRow.offsetHeight ) );

		let totalHeight = tableRowsHeight.reduce( ( accumulator, tableRowHeight ) => {
			if ( isNaN( tableRowHeight ) ) {
				return accumulator;
			}

			return accumulator + tableRowHeight;
		}, 0 );

		if ( ! isNaN( headRowHeight ) ) {
			totalHeight += headRowHeight;
			root?.style?.setProperty( '--one-novanta-your-quote-table-header-height', `${ headRowHeight }px` );
		}

		root?.style?.setProperty( '--one-novanta-your-quote-table-height', `${ totalHeight + 5 }px` );
	}

	/**
	 * Fetch product-key from quantity input.
	 *
	 * @param {HTMLElement} quantityInput Quantity input.
	 *
	 * @return {string|null|undefined} String on success | Null or Undefined on failure.
	 */
	getKeyProductKeyFromInput( quantityInput ) {
		const row = quantityInput.closest( '.wp-one-novanta-your-quote-table__body-row' );
		const key = row?.getAttribute( 'data-key' );

		if ( ! key ) {
			return;
		}

		return key;
	}

	/**
	 * Disable increase/decrease quantity buttons for specific quantity input.
	 *
	 * @param {HTMLElement} quantityInputContainer Quantity input.
	 */
	maybeDisableQuantityUpdate( quantityInputContainer ) {
		if ( ! quantityInputContainer ) {
			return;
		}

		const increaseQuantityButton = quantityInputContainer?.querySelector( '.wp-one-novanta-your-quote-table__body-content--quantity__plus' );
		const decreaseQuantityButton = quantityInputContainer?.querySelector( '.wp-one-novanta-your-quote-table__body-content--quantity__minus' );
		const quantityInput = quantityInputContainer?.querySelector( 'input' );

		const quantity = parseInt( quantityInput?.value );

		if ( isNaN( quantity ) ) {
			return;
		}

		increaseQuantityButton.classList.remove( 'disabled' );
		decreaseQuantityButton.classList.remove( 'disabled' );

		if ( parseInt( quantityInput.min ) >= quantityInput.value ) {
			decreaseQuantityButton.classList.add( 'disabled' );
			return;
		}

		if ( parseInt( quantityInput.max ) <= quantityInput.value ) {
			increaseQuantityButton.classList.add( 'disabled' );
		}
	}

	/**
	 * Remove all products when quote is submitted successfully.
	 *
	 * @param {Object} data Submitted form data.
	 *
	 * @return {Object} Submitted form data.
	 */
	onQuoteSubmit( data ) {
		// Return if form ID is not available or form is not successfully submitted.
		if ( ! data?.form?.dataset?.formid || ! data?.submissionResult?.success ) {
			return data;
		}

		const submitYourQuoteFormId = this.yourQuoteTableComponent?.dataset?.submitYourQuoteFormId;

		// Return if `submit your quote` ID is not provided or current form ID is not equals to `submit your quote` form ID.
		if ( ! submitYourQuoteFormId || submitYourQuoteFormId !== data?.form?.dataset?.formid ) {
			return data;
		}

		// Remove all products on successful submission of `submit your quote` form.
		this.removeAllProducts();

		return data;
	}

	/**
	 * Truncates the visible text content of an HTMLElement to a maximum number of characters,
	 * while preserving the original HTML structure (e.g., <p>, <ul>, <li>, etc.).
	 * Appends "..." at the cutoff point and ensures valid HTML output.
	 *
	 * @param {HTMLElement} element  The HTML element whose content should be truncated.
	 * @param {number}      maxChars The maximum number of visible characters to retain (default is 110).
	 */
	truncateHtmlElementContent( element, maxChars = 80 ) {
		let charCount = 0;
		let done = false;

		function truncateNode( node ) {
			if ( done ) {
				return null;
			}

			if ( node.nodeType === Node.TEXT_NODE ) {
				const text = node.textContent;
				if ( charCount + text.length > maxChars ) {
					const remaining = maxChars - charCount;
					charCount = maxChars;
					done = true;
					return document.createTextNode( text.slice( 0, remaining ) + '...' );
				}
				charCount += text.length;
				return node.cloneNode( true );
			}

			if ( node.nodeType === Node.ELEMENT_NODE ) {
				const clone = node.cloneNode( false ); // Clone element, not its children.
				for ( const child of node.childNodes ) {
					const truncatedChild = truncateNode( child );
					if ( truncatedChild ) {
						clone.appendChild( truncatedChild );
					}
					if ( done ) {
						break;
					}
				}
				return clone;
			}

			return null;
		}

		// Clear and rebuild just the contents of the element (not the element itself)
		const fragment = document.createDocumentFragment();
		for ( const child of element.childNodes ) {
			const truncated = truncateNode( child );
			if ( truncated ) {
				fragment.appendChild( truncated );
			}
			if ( done ) {
				break;
			}
		}

		element.innerHTML = ''; // Remove existing children.
		element.appendChild( fragment ); // Add truncated content.
	}
}

// Initialize Your Quote Table component scripts.
document.addEventListener( 'DOMContentLoaded', () => {
	// Fetch all Your Quote Tables.
	const yourQuoteTableComponents = document.querySelectorAll( '.wp-one-novanta-your-quote-table' );

	if ( ! yourQuoteTableComponents ) {
		return;
	}

	yourQuoteTableComponents.forEach( ( yourQuoteTableComponent ) => new OneNovantaYourQuoteTable( yourQuoteTableComponent ) );
} );
