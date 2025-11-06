/**
 * Component: Product Search.
 */

/**
 * Internal dependencies
 */
import { LoadMoreInstance } from '../load-more/load-more';

const OneNovantaTriggerFilter = {
	// Structure: { taxonomyName: Set(termIds) }
	filteredItems: {},
	productSearchBlock: null,

	/**
	 * Initialize all Checkbox instances.
	 *
	 * @return {void}
	 */
	init() {
		// Select all checkbox inputs within the filter widget
		this.productSearchBlock = document.querySelector( '.product-search' );

		// Return early if the main element is not found.
		if ( ! this.productSearchBlock ) {
			return;
		}

		const checkboxes = this.productSearchBlock.querySelectorAll( '.product-search__filter-widget input[type="checkbox"]' );

		this.setUpDefaultQuery();

		checkboxes.forEach( ( checkbox ) => {
			checkbox.addEventListener( 'click', this.filterClicked.bind( this ) );
		} );

		document.addEventListener( 'filterChanged', this.filterChangedEvent.bind( this ) );
	},

	/**
	 * Sets up default taxonomy filters from the data-query attribute.
	 *
	 * Parses the `tax_query` from `.button-load-more-wrapper` and stores taxonomy terms in `this.filteredItems` as Sets.
	 */
	setUpDefaultQuery() {
		const loadMore = this.productSearchBlock.querySelector( '.button-load-more-wrapper' );

		if ( ! loadMore ) {
			return;
		}

		const defaultQuery = JSON.parse( loadMore.dataset?.query );

		const { tax_query: taxQuery = [] } = defaultQuery;

		if ( ! taxQuery || taxQuery.length === 0 ) {
			return;
		}

		// Store the default query in filteredItems
		taxQuery.forEach( ( unitQuery ) => {
			const { taxonomy = '', terms = [] } = unitQuery;

			if ( taxonomy.length === 0 || terms.length === 0 ) {
				return;
			}

			this.filteredItems[ taxonomy ] = new Set();

			// Set taxonomy term in required format.
			terms.forEach( ( term ) => this.filteredItems[ taxonomy ].add( term.toString() ) );
		} );
	},

	/**
	 * Handle checkbox click events.
	 *
	 * @param {Event} event - The click event.
	 *
	 * @return {void}
	 */
	filterClicked( event ) {
		const checkbox = event.target;
		const { taxonomy, postType } = checkbox.dataset;
		const termId = checkbox.value;

		const productSearchContainer = checkbox.closest( '.product-search' );

		if ( ! this.filteredItems[ taxonomy ] ) {
			this.filteredItems[ taxonomy ] = new Set();
		}

		if ( checkbox.checked ) {
			this.filteredItems[ taxonomy ].add( termId );
		} else {
			this.filteredItems[ taxonomy ].delete( termId );

			if ( this.filteredItems[ taxonomy ].size === 0 ) {
				// Clean up empty taxonomies
				delete this.filteredItems[ taxonomy ];
			}
		}

		const customEvent = new CustomEvent( 'filterChanged', {
			detail: {
				postType,
				filteredItems: this.filteredItems,
				container: productSearchContainer,
			},
			bubbles: true,
		} );

		productSearchContainer.dispatchEvent( customEvent );
	},

	/**
	 * Handle the filterChanged event.
	 *
	 * @param {Event} event - The filterChanged event.
	 *
	 * @return {void}
	 */
	filterChangedEvent( event ) {
		const { filteredItems, postType, container } = event.detail;

		// Find the "Load More" wrapper within this specific container
		const loadMoreWrapper = container.querySelector( '.button-load-more-wrapper' );

		// Check if the wrapper exists
		if ( ! loadMoreWrapper ) {
			return;
		}

		const target = document.querySelector( loadMoreWrapper.dataset.target );

		// Start fade-out
		target.classList.remove( 'fade-in' );
		target.classList.add( 'fade-out' );

		// Wait for fade-out animation to complete
		target.addEventListener( 'animationend',
			() => {
				// Trigger the load more function after fade-out
				this.triggerLoadMore( target, loadMoreWrapper, filteredItems, postType, container );
			},
			{ once: true }, // Ensures it only runs once
		);
	},

	/**
	 * Trigger the load more class Instance.
	 *
	 * @param {HTMLElement} target          - The target element to load more content into.
	 * @param {HTMLElement} loadMoreWrapper - The wrapper element for the load more button.
	 * @param {Object}      filteredItems   - The filtered items object.
	 * @param {string}      postType        - The post type to filter by.
	 * @param {HTMLElement} container       - The container element.
	 *
	 * @return {void}
	 */
	async triggerLoadMore( target, loadMoreWrapper, filteredItems, postType, container ) {
		const searchResultsElement = container.querySelector( '.product-search__results-count' );
		// Clear target content
		target.innerHTML = '';

		// Clone the button to reset its state and remove the old event listener.
		const oldButton = container.querySelector( '.button-load-more' );
		const newButton = oldButton.cloneNode( true );
		oldButton.parentNode.replaceChild( newButton, oldButton );

		// Remove old display none style if present.
		loadMoreWrapper.removeAttribute( 'style' );

		const instance = new LoadMoreInstance( loadMoreWrapper );

		// Reset the page to 1 and update the query
		instance.wrapper.dataset.page = 1;

		// Construct tax_query object
		const taxQuery = { relation: 'AND' };
		Object.entries( filteredItems ).forEach( ( [ taxonomy, terms ], index ) => {
			taxQuery[ index ] = {
				taxonomy,
				field: 'term_id',
				terms: Array.from( terms ),
				operator: 'IN',
			};
		} );

		// Update the query attribute to include the tax_query
		instance.wrapper.dataset.query = JSON.stringify( {
			tax_query: taxQuery,
			post_type: postType,
		} );

		instance.init();

		// Add fade-in
		target.classList.remove( 'fade-out' );
		target.classList.add( 'fade-in' );

		// Load the new data
		const { count, totalResults } = await instance.loadMore();

		// Update the foundPosts data-attribute.
		instance.wrapper.dataset.foundPosts = totalResults;

		// Update the results.
		if ( searchResultsElement ) {
			searchResultsElement.innerHTML = searchResultsElement.innerHTML.replace(
				/\d+/,
				`${ totalResults }`,
			);
		}

		if ( count >= totalResults ) {
			// Hide load-more on filter-change if all the results are displayed.
			loadMoreWrapper.style.display = 'none';
		} else {
			loadMoreWrapper.removeAttribute( 'style' );
		}
	},
};

document.addEventListener( 'DOMContentLoaded', () => OneNovantaTriggerFilter.init() );
