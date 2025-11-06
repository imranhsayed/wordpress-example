/**
 * Global variables.
 * Destructures `customElements` and `HTMLElement` from the window object.
 */
const { customElements, HTMLElement } = window;

/**
 * FilterToggle Web Component.
 * A custom element that toggles the visibility of a sidebar filter.
 * @augments HTMLElement
 */
class FilterToggle extends HTMLElement {
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
		// Initialize after DOM is fully loaded if necessary
		if ( document.readyState === 'loading' ) {
			document.addEventListener( 'DOMContentLoaded', () => this.init() );
		} else {
			this.init();
		}
	}

	/**
	 * Initializes the component.
	 * - Caches DOM references
	 * - Sets default texts
	 * - Initializes event listeners
	 */
	init() {
		// Get references to DOM elements
		this.toggleButton = this.querySelector( '.product-search__toggle-button' );
		this.sidebar = document.querySelector( '.product-search__sidebar-inner' );

		// Set default texts with fallback values
		this.expandText = this.getAttribute( 'expand-text' ) ?? 'Show Filters';
		this.collapseText = this.getAttribute( 'collapse-text' ) ?? 'Hide Filters';

		// Only proceed if required elements exist
		if ( this.toggleButton && this.sidebar ) {
			// Set up click event listener
			this.toggleButton.addEventListener( 'click', this.handleToggle );

			// Initialize component state
			const isExpanded = this.toggleButton.getAttribute( 'aria-expanded' ) === 'true';
			this.sidebar.classList.toggle( 'is-visible', isExpanded );
			this.toggleButton.textContent = isExpanded ? this.collapseText : this.expandText;
		}
	}

	/**
	 * Handles the toggle button click event.
	 * - Toggles aria-expanded state
	 * - Shows/hides sidebar
	 * - Updates button text
	 */
	handleToggle() {
		const isExpanded = this.toggleButton.getAttribute( 'aria-expanded' ) === 'true';
		const newState = ! isExpanded;

		// Update accessibility attribute
		this.toggleButton.setAttribute( 'aria-expanded', String( newState ) );

		// Toggle sidebar visibility
		this.sidebar.classList.toggle( 'is-visible', newState );

		// Update button text
		this.toggleButton.textContent = newState ? this.collapseText : this.expandText;
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
customElements.define( 'one-novanta-toggle-search-filter-button', FilterToggle );
