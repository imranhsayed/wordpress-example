/**
 * Documents Filter Component
 *
 * This module provides functionality for filtering documents based on search keyword,
 * document type, and language. It handles both the filtering UI and API interactions.
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const OneNovantaDocumentsFilter = {
	init() {
		const wrappers = document.querySelectorAll( '.wp-one-novanta-documents-filter' );

		// If no wrappers are found, exit early.
		if ( ! wrappers || ! wrappers?.length ) {
			return;
		}

		// Initialize each documents filter instance found on the page
		wrappers.forEach( ( wrapper ) => {
			const instance = new DocumentsFilterInstance( wrapper );
			instance.init();
		} );
	},
};

/**
 * Class to handle individual document filter instances
 * Manages the filtering UI, URL parameters, and API requests for document filtering
 */
class DocumentsFilterInstance {
	// CSS selectors for various UI elements
	KEYWORD_SELECTOR = '.wp-one-novanta-documents-filter__search-input';
	DOCUMENT_TYPE_SELECTOR = '#wp-one-novanta-documents-filter__document-type .one-novanta-filter-dropdown__selected-value';
	LANGUAGE_SELECTOR = '#wp-one-novanta-documents-filter__language .one-novanta-filter-dropdown__selected-value';
	LOAD_MORE_BUTTON_SELECTOR = '.button-load-more-wrapper';
	DOCUMENT_TYPE_SELECTOR_DEFAULT_TEXT = '#wp-one-novanta-documents-filter__document-type .wp-one-novanta-documents-filter__filter__option--default';
	DOCUMENT_TYPE_OPTIONS_LIST = '#wp-one-novanta-documents-filter__document-type .one-novanta-filter-dropdown__dropdown-list li[data-filter-slug]';
	LANGUAGE_SELECTOR_DEFAULT_TEXT = '#wp-one-novanta-documents-filter__language .wp-one-novanta-documents-filter__filter__option--default';

	/**
	 * Initialize a new DocumentsFilterInstance
	 * @param {HTMLElement} wrapper - The container element for this filter instance
	 */
	constructor( wrapper ) {
		this.wrapper = wrapper;
		this.button = null;
		this.targetContainer = null;
		this.headerTitle = null;
		this.defaultDocumentTypeText = null;
		this.defaultLanguageText = null;
		this.documentTypeOptionsMap = new Map();

		// Individual instance-specific data attributes
		this.searchKeyword = null;
		this.documentType = null;
		this.language = null;
		this.target = null;
		this.endpoint = null;
		this.nonce = null;
	}

	/**
	 * Initialize the filter instance by setting up data attributes and event listeners
	 * Also syncs the initial state with URL parameters
	 */
	init() {
		if ( ! this.wrapper ) {
			return;
		}

		this.setDataAttributes();
		this.getDocumentTypeOptions();
		this.updateDataAttributesFromQuery();

		this.button = this.wrapper.querySelector( '#wp-one-novanta-documents-filter__search-button' );
		this.targetContainer = document.querySelector( this.target );
		this.headerTitle = document.querySelector( '.wp-one-novanta-table__header__title' );

		if ( ! this.button || ! this.targetContainer || ! this.endpoint ) {
			return;
		}

		// Add event listener.
		this.button.addEventListener( 'click', this.updateContent.bind( this ) );
	}

	/**
	 * Updates the URL query parameters based on current filter values
	 * This allows for shareable URLs and browser history management
	 */
	updateQueryParameters() {
		const url = new URL( window.location.href );
		const queryParams = new URLSearchParams( url.search );

		// Only set the query parameters if they are not null, and have length greater than 0.
		if ( this.searchKeyword && this.searchKeyword.length > 0 ) {
			queryParams.set( 'search_keyword', this.searchKeyword );
		} else {
			queryParams.delete( 'search_keyword' );
		}

		if ( this.documentType && this.documentType.length > 0 ) {
			queryParams.set( 'document_type', this.documentType );
		} else {
			queryParams.delete( 'document_type' );
		}

		if ( this.language && this.language.length > 0 ) {
			queryParams.set( 'language', this.language );
		} else {
			queryParams.delete( 'language' );
		}

		url.search = queryParams.toString();

		// set the new URL
		window.history.replaceState( null, null, url.toString() );
	}

	/**
	 * Reads and applies filter values from URL query parameters
	 * Enables filter state persistence across page loads
	 */
	updateDataAttributesFromQuery() {
		// Get query parameters.
		const urlParams = new URLSearchParams( window.location.search );
		const searchKeyword = urlParams.get( 'search_keyword' );
		const documentType = urlParams.get( 'document_type' );
		const language = urlParams.get( 'language' );

		// Update data attributes
		this.searchKeyword = searchKeyword || null;
		this.documentType = documentType || null;
		this.language = language || null;

		// Use selectors and update the dropdown values
		const searchKeywordInput = this.wrapper.querySelector( this.KEYWORD_SELECTOR );
		const documentTypeDropdown = this.wrapper.querySelector( this.DOCUMENT_TYPE_SELECTOR );
		const languageDropdown = this.wrapper.querySelector( this.LANGUAGE_SELECTOR );
		this.defaultDocumentTypeText = this.wrapper.querySelector( this.DOCUMENT_TYPE_SELECTOR_DEFAULT_TEXT )?.textContent;
		this.defaultLanguageText = this.wrapper.querySelector( this.LANGUAGE_SELECTOR_DEFAULT_TEXT )?.textContent;

		if ( searchKeywordInput ) {
			searchKeywordInput.value = searchKeyword || '';
		}

		if ( documentTypeDropdown ) {
			// Set dropdown text based on the map value or fallback to default
			documentTypeDropdown.textContent = this.documentTypeOptionsMap.get( documentType ) || this.defaultDocumentTypeText;
		}

		if ( languageDropdown ) {
			languageDropdown.textContent = language || this.defaultLanguageText;
		}
	}

	/**
	 * Sets up instance properties from data attributes on the wrapper element
	 * Configures target container, API endpoint, and security nonce
	 */
	setDataAttributes() {
		const dataset = this.wrapper.dataset;

		this.target = dataset.targetContainer || null;
		this.endpoint = dataset.endpoint || null;
		this.nonce = dataset.nonce || null;
	}

	/**
	 * Updates the filtered content by making an API request
	 * Updates URL parameters and handles the loading state of the search button
	 */
	async updateContent() {
		const inputSearchKeyword = this.wrapper.querySelector( this.KEYWORD_SELECTOR ).value;
		const selectedDocumentTypeElement = this.wrapper.querySelector( this.DOCUMENT_TYPE_SELECTOR );
		const selectedLanguage = this.wrapper.querySelector( this.LANGUAGE_SELECTOR )?.textContent;
		const documentTypeSlug = selectedDocumentTypeElement?.getAttribute( 'data-filter-slug' );

		// Check if any of them are different from the current values, if yes, then update the values, and remove the button wrapper hidden style.
		if ( this.searchKeyword !== inputSearchKeyword || this.documentType !== documentTypeSlug || this.language !== selectedLanguage ) {
			this.searchKeyword = inputSearchKeyword;
			this.documentType = documentTypeSlug;
			this.language = selectedLanguage;

			const loadMoreButtonWrapper = document.querySelector( this.LOAD_MORE_BUTTON_SELECTOR );
			if ( loadMoreButtonWrapper && loadMoreButtonWrapper.hasAttribute( 'style' ) ) {
				loadMoreButtonWrapper.attributes.removeNamedItem( 'style' );
			}
		} else {
			// Return since there is no need to make an request, the content is already the same.
			return;
		}

		this.button.setAttribute( 'disabled', true );

		// Do not send the value if those are placeholder values.
		if ( this.defaultDocumentTypeText === this.documentType ) {
			this.documentType = null;
		}

		if ( this.defaultLanguageText === this.language ) {
			this.language = null;
		}

		const response = await this.fetchContent();

		if ( response ) {
			// Update Load-more button UI based on total posts.
			this.updatePostUI( parseInt( response.total_posts ) );

			// If response.content exists, set it as innerHTML, otherwise append the new paragraph element
			if ( response.content ) {
				this.targetContainer.innerHTML = response.content;
			} else {
				this.targetContainer.innerHTML = '';
				this.targetContainer.appendChild( this.noContentFound() );
			}

			this.updateLoadMoreComponent();
		}

		this.button.removeAttribute( 'disabled' );
		// Update URL parameters.
		this.updateQueryParameters();

		// Unhide the button wrapper target container.
		this.removeTableLoading();
	}

	/**
	 * Makes an API request to fetch filtered documents
	 * Handles parameter construction and error handling
	 *
	 * @return {Promise<{content: string, count: number, total_posts: number}>} API response with filtered content and total count
	 */
	async fetchContent() {
		try {
			const params = new URLSearchParams();

			if ( this.searchKeyword && this.searchKeyword.length > 0 ) {
				params.set( 'search_keyword', this.searchKeyword );
			}
			if ( this.documentType && this.documentType.length > 0 && this.defaultDocumentTypeText !== this.documentType ) {
				params.set( 'document_type', this.documentType );
			}
			if ( this.language && this.language.length > 0 && this.defaultLanguageText !== this.language ) {
				params.set( 'language', this.language );
			}

			const headers = new Headers( {
				'Content-Type': 'application/json',
			} );

			if ( this.nonce && this.nonce.length > 0 ) {
				headers.set( 'X-WP-Nonce', this.nonce );
			}

			const response = await fetch( `${ this.endpoint }?${ params.toString() }`, {
				method: 'GET',
				headers,
			} );

			// Check if the response is ok. If not, throw an error.
			if ( ! response.ok ) {
				throw new Error();
			}

			return await response.json();
		} catch {
			// eslint-disable-next-line no-console
			console.error( 'Failed to load documents from API.' );
		}

		return null;
	}

	/**
	 * Updates the load more button's data attributes with current filter parameters
	 * Ensures pagination maintains the current filter state
	 */
	updateLoadMoreComponent() {
		const loadMoreButton = document.querySelector( this.LOAD_MORE_BUTTON_SELECTOR );
		if ( ! loadMoreButton ) {
			return;
		}

		const parameters = {};

		if ( this.searchKeyword && this.searchKeyword.length > 0 ) {
			parameters.search_keyword = this.searchKeyword;
		}

		if ( this.documentType && this.documentType.length > 0 && this.defaultDocumentTypeText !== this.documentType ) {
			parameters.document_type = this.documentType;
		}

		if ( this.language && this.language.length > 0 && this.defaultLanguageText !== this.language ) {
			parameters.language = this.language;
		}

		loadMoreButton.setAttribute( 'data-query', JSON.stringify( parameters ) );

		// Reset the page number.
		loadMoreButton.setAttribute( 'data-page', 2 );

		const totalPostsCount = parseInt( loadMoreButton.dataset.foundPosts );
		const currentPostsCount = this.targetContainer.children.length;

		// Hide load-more if filtered list length if greater than the total count.
		if ( currentPostsCount >= totalPostsCount ) {
			loadMoreButton.classList.add( 'button-load-more-wrapper--hidden' );
		}
	}

	/**
	 * Removes the loading state from the table.
	 */
	removeTableLoading() {
		const tableLoading = document.querySelector( '.wp-one-novanta-table figure' );
		if ( ! tableLoading ) {
			return;
		}

		// Set the data-is-loading attribute to false.
		tableLoading.setAttribute( 'data-is-loading', 'false' );
	}

	/**
	 * Creates a table row with a "No Documents were found" message.
	 * @return {HTMLTableRowElement} The message row.
	 */
	noContentFound() {
		const tr = document.createElement( 'tr' );
		const td = document.createElement( 'td' );

		// Add a large colspan to take max-width.
		td.setAttribute( 'colspan', '999' );

		td.classList.add( 'wp-one-novanta-no-rows-found' );

		let notFoundText = this.wrapper.dataset.notFoundText;

		if ( ! notFoundText ) {
			notFoundText = __( 'No Documents were found', 'one-novanta-theme' );
		}

		td.textContent = notFoundText;

		tr.appendChild( td );
		return tr;
	}

	/**
	 * Update total post count in UI and toggle "Load More" button visibility.
	 *
	 * @param {number} totalPosts - Total number of posts found.
	 */
	updatePostUI( totalPosts ) {
		// Check if totalPosts is a valid integer, it can be 0.
		if ( ! Number.isInteger( totalPosts ) ) {
			return;
		}

		const loadMoreButtonWrapper = document.querySelector( this.LOAD_MORE_BUTTON_SELECTOR );

		if ( this.headerTitle ) {
			// Only replace the integer part.
			this.headerTitle.innerHTML = this.headerTitle.innerHTML.replace(
				/\d+/,
				`${ totalPosts }`,
			);
		}

		loadMoreButtonWrapper.dataset.foundPosts = totalPosts;
		loadMoreButtonWrapper.classList.toggle( 'button-load-more-wrapper--hidden', parseInt( totalPosts ) === 0 );
	}

	/**
	 * Populates the documentTypeOptionsMap with slugs and their corresponding text labels
	 * from DOM elements matching the DOCUMENT_TYPE_OPTIONS_LIST selector.
	 */
	getDocumentTypeOptions() {
		// Get all elements matching the document type options selector
		const documentTypeOptionsElements = this.wrapper.querySelectorAll( this.DOCUMENT_TYPE_OPTIONS_LIST );

		// Exit if no elements found
		if ( ! documentTypeOptionsElements || documentTypeOptionsElements.length === 0 ) {
			return;
		}

		documentTypeOptionsElements.forEach( ( option ) => {
			const slug = option.getAttribute( 'data-filter-slug' );
			const text = option.textContent.trim();

			// If slug exists, add it to the map with its text label
			if ( slug ) {
				this.documentTypeOptionsMap.set( slug, text );
			}
		} );
	}
}

// Initialize all Load More wrappers when DOM is ready.
document.addEventListener( 'DOMContentLoaded', () => OneNovantaDocumentsFilter.init() );
