/**
 * Global variables.
 * Destructures `customElements` and `HTMLElement` from the window object.
 */
const { customElements, HTMLElement } = window;

/**
 * MinimizeFilterButton Web Component.
 * A custom element that toggles the visibility of excess filter list items in product search.
 * @augments HTMLElement
 */
class MinimizeFilterButton extends HTMLElement {
	/**
	 * Constructor.
	 * Initializes the component and binds event handlers.
	 */
	constructor() {
		super();

		// Bind `this` context for the event handler
		this.handleToggle = this.handleToggle.bind( this );
	}

	/**
	 * Connected Callback.
	 * Invoked when the element is inserted into the DOM.
	 * Sets up initial state and event listeners.
	 */
	connectedCallback() {
		if ( document.readyState === 'loading' ) {
			document.addEventListener( 'DOMContentLoaded', () => this.init() );
		} else {
			this.init();
		}
	}

	/**
	 * Initializes the component.
	 * - Caches DOM references
	 * - Sets default button text
	 * - Initializes event listeners
	 */
	init() {
		this.toggleButton = this.querySelector( '.product-search__minimize-button' );
		this.hiddenItems = this.closest( '.product-search__filter-widget' )
			?.querySelectorAll( '.product-search__filter-item.is-hidden' );

		// Set default texts with fallback values
		this.expandText = this.getAttribute( 'expand-text' ) ?? 'See All';
		this.collapseText = this.getAttribute( 'collapse-text' ) ?? 'See Less';

		// Only proceed if required elements exist
		if ( this.toggleButton && this.hiddenItems?.length ) {
			this.toggleButton.addEventListener( 'click', this.handleToggle );

			// Initialize default button state
			const isExpanded = this.toggleButton.getAttribute( 'data-expanded' ) === 'true';
			this.updateItemsVisibility( isExpanded );
			this.toggleButton.textContent = isExpanded ? this.collapseText : this.expandText;
		}
	}

	/**
	 * Handles the toggle button click event.
	 * - Toggles data-expanded state
	 * - Shows/hides hidden list items
	 * - Updates button text
	 */
	handleToggle() {
		const isExpanded = this.toggleButton.getAttribute( 'data-expanded' ) === 'true';
		const newState = ! isExpanded;

		this.toggleButton.setAttribute( 'data-expanded', String( newState ) );
		this.updateItemsVisibility( newState );
		this.toggleButton.textContent = newState ? this.collapseText : this.expandText;
	}

	/**
	 * Updates visibility of hidden filter list items.
	 *
	 * @param {boolean} showItems - Whether to show or hide the hidden items.
	 */
	updateItemsVisibility( showItems ) {
		this.hiddenItems.forEach( ( item ) => {
			item.style.display = showItems ? 'list-item' : 'none';
		} );
	}

	/**
	 * Disconnected Callback.
	 * Invoked when the element is removed from the DOM.
	 * Cleans up event listeners to prevent memory leaks.
	 */
	disconnectedCallback() {
		if ( this.toggleButton ) {
			this.toggleButton.removeEventListener( 'click', this.handleToggle );
		}
	}
}

// Register the custom element
customElements.define( 'one-novanta-toggle-minimize-filter-button', MinimizeFilterButton );
