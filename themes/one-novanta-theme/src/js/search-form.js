/**
 * Search form JS
 */

document.addEventListener( 'DOMContentLoaded', () => {
	const CLEAR_BUTTON_SVG = '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none" viewBox="0 0 19 19"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m1.621 16.864 15-14.81M16.621 16.864l-15-14.81"/></svg>';
	const SEARCH_INPUT_ADJUSTMENT = 50;

	const createClearButton = () => {
		const button = document.createElement( 'button' );
		button.classList.add( 'one-novanta-search-form__clear' );
		button.type = 'button';
		button.setAttribute( 'aria-label', 'Clear search input' );
		button.setAttribute( 'tabindex', '0' );

		// Use DOMParser to safely parse the SVG string
		const parser = new DOMParser();
		const svgDoc = parser.parseFromString( CLEAR_BUTTON_SVG, 'image/svg+xml' );
		const svgElement = svgDoc.documentElement;
		svgElement.setAttribute( 'aria-hidden', 'true' );

		// Append the SVG to the button
		button.appendChild( svgElement );

		return button;
	};

	const handleSearchForm = ( block ) => {
		// Return early if block is not found
		if ( ! block ) {
			return;
		}

		const form = block.querySelector( '.wp-block-search' );
		const searchInput = block.querySelector( '.wp-block-search__input' );

		// Return early if form or search input not found
		if ( ! form || ! searchInput ) {
			return;
		}

		const searchButton = block.querySelector( '.wp-block-search__button' );
		const searchFormWrapper = block.querySelector( '.wp-block-search__inside-wrapper' );
		const clearButton = createClearButton();

		// Submit form when Enter is pressed.
		const handleKeydown = ( e ) => {
			if ( e.key === 'Enter' ) {
				e.preventDefault();
				form.submit();
			}
		};
		searchInput.addEventListener( 'keydown', handleKeydown );

		// Add the clear button
		if ( searchFormWrapper ) {
			if ( searchButton ) {
				searchFormWrapper.insertBefore( clearButton, searchButton );
			} else {
				searchFormWrapper.appendChild( clearButton );
			}
		}

		const updateClearButtonVisibility = ( inputValue ) => {
			clearButton.classList.toggle( 'one-novanta-search-form__clear--visible', '' !== inputValue.trim() );
		};

		const updateSearchInputLayout = () => {
			// Return early if search form wrapper not found
			if ( ! searchFormWrapper ) {
				return;
			}

			const searchInputValue = searchInput.value;
			updateClearButtonVisibility( searchInputValue );

			// Calculate width for CSS custom property
			if ( searchInput.offsetWidth > 0 ) {
				const searchInputWidth = searchInput.offsetWidth - SEARCH_INPUT_ADJUSTMENT;
				searchFormWrapper.style.setProperty( '--search-input-width', `${ searchInputWidth }px` );
			}
		};

		// Initial calculation and visibility update
		requestAnimationFrame( updateSearchInputLayout );

		// Observe resize changes
		const resizeObserver = new ResizeObserver( updateSearchInputLayout );
		resizeObserver.observe( searchInput );

		// Prevent submit button from submitting and allow clear field.
		const handleClearButtonClick = ( e ) => {
			e.preventDefault();
			searchInput.value = '';
			updateClearButtonVisibility( '' );
			searchInput.focus();
		};
		clearButton.addEventListener( 'click', handleClearButtonClick );

		const handleInputChange = () => {
			updateClearButtonVisibility( searchInput.value );
		};
		searchInput.addEventListener( 'input', handleInputChange );
	};

	document.querySelectorAll( '.one-novanta-search-form' ).forEach( handleSearchForm );
} );
