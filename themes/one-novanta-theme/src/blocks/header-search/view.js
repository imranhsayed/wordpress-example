/**
 * Global variables.
 */
const { customElements, HTMLElement } = window;

/**
 * HeaderSearch Component
 */
class HeaderSearch extends HTMLElement {
	connectedCallback() {
		// Elements
		this.searchForm = this.querySelector( '.header-search__form' );
		this.searchInput = this.querySelector( '.header-search__input' );
		this.actionButton = this.querySelector( '.header-search__button-handler' );
		this.clearButton = this.querySelector( '.header-search__clear' );
		this.bodyElement = document.querySelector( 'body' );

		// Bind handlers so we can remove them later
		this.boundOnSearchButtonClick = this.onSearchButtonClick.bind( this );
		this.boundOnClearClick = this.onClearClick.bind( this );
		this.boundOnInputChange = this.onInputChange.bind( this );
		this.boundOnFormSubmit = this.onFormSubmit.bind( this );
		this.boundOnDocumentClick = this.onDocumentClick.bind( this );

		// Event listeners
		this.actionButton?.addEventListener( 'click', this.boundOnSearchButtonClick );
		this.clearButton?.addEventListener( 'click', this.boundOnClearClick );
		this.searchInput?.addEventListener( 'input', this.boundOnInputChange );
		this.searchForm?.addEventListener( 'submit', this.boundOnFormSubmit );
		document.addEventListener( 'click', this.boundOnDocumentClick );
	}

	// Disconnect Callback
	disconnectedCallback() {
		// Remove event listeners
		this.actionButton?.removeEventListener( 'click', this.boundOnSearchButtonClick );
		this.clearButton?.removeEventListener( 'click', this.boundOnClearClick );
		this.searchInput?.removeEventListener( 'input', this.boundOnInputChange );
		this.searchForm?.removeEventListener( 'submit', this.boundOnFormSubmit );
		document.removeEventListener( 'click', this.boundOnDocumentClick );
	}

	// Toggle search form expansion on search button click
	onSearchButtonClick( event ) {
		event.preventDefault();
		if ( this.hasAttribute( 'expand' ) ) {
			this.collapseForm();
		} else {
			this.expandForm();
		}
	}

	// Expand the search form and focus input
	expandForm() {
		this.setAttribute( 'expand', 'true' );
		this.bodyElement.classList.add( 'search-backdrop' );
		this.searchInput?.focus();
	}

	// Collapse the search form and reset input
	collapseForm() {
		this.removeAttribute( 'expand' );
		this.bodyElement.classList.remove( 'search-backdrop' );

		if ( this.searchInput ) {
			this.searchInput.value = '';
		}

		this.toggleClearButton( false );
	}

	// Prevent empty form submissions
	onFormSubmit( event ) {
		if ( '' === this.searchInput?.value.trim() ) {
			event.preventDefault();
		}
	}

	// Clear the input field
	onClearClick( event ) {
		event.preventDefault();
		if ( this.searchInput ) {
			this.searchInput.value = '';
		}

		this.toggleClearButton( false );

		this.searchInput?.focus();
	}

	// Show or hide clear button based on input value
	onInputChange( event ) {
		this.toggleClearButton( event.target.value.length > 0 );
	}

	// Collapse search form if click is outside the component
	onDocumentClick( event ) {
		const clickedInside = this.contains( event.target );

		if ( this.hasAttribute( 'expand' ) && ! clickedInside ) {
			this.collapseForm();
		}
	}

	// Toggle clear button visibility
	toggleClearButton( show ) {
		if ( this.clearButton ) {
			this.clearButton.classList.toggle( 'header-search__clear--visible', show );
			this.clearButton.classList.toggle( 'header-search__clear--hidden', ! show );
		}
	}
}

/**
 * Register the custom element
 */
customElements.define( 'novanta-search', HeaderSearch );
