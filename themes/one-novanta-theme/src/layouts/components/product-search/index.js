/**
 * `HTMLElement` from the window object.
 */
const { HTMLElement } = window;

/**
 * Internal dependencies
 */
import './filter-toggle';
import './minimize-filters';
import { debounce } from '../../../js/utils';
import { LoadMoreInstance } from '../load-more/load-more';

/**
 * OneNovantaProductSearch class
 */
class OneNovantaProductSearch extends HTMLElement {
	/**
	 * Filtered items object.
	 *
	 * Structure: { taxonomyName: Set(termIds) }
	 *
	 * @type {{}}
	 */
	filteredItems = {};
	pendingPostType = null;

	/**
	 * Connected Callback.
	 */
	connectedCallback() {
		// Elements.
		this.checkBoxWrapper = this.querySelector( '.product-search__sidebar-inner' );
		this.checkboxElements = this.querySelectorAll( '.product-search__filter-widget input[type="checkbox"]' );
		this.loadMoreWrapper = this.querySelector( '.button-load-more-wrapper' );
		this.loadingIcon = this.querySelector( '.product-search__is-loading' );
		this.hasAddToCart = false;

		/**
		 * Set up default Query.
		 * If on archive page with default category, if user selects and unselect.
		 * It will show all results of that post-type.
		 * So we need to store default query to avoid that edge case.
		 */
		this.setUpDefaultQuery();

		// Debounce the internal logic instead of just the API call.
		this.scheduleFilterUpdate = debounce( this.filterChangedEvent.bind( this ), 500 );

		// Bind methods.
		this.checkboxElements.forEach( ( checkbox ) => {
			checkbox.addEventListener( 'click', this.onFilterClicked.bind( this ) );
		} );

		this.addEventListener( 'one-novanta-loadmore:triggered', this.onLoadMoreTrigger );
		this.addEventListener( 'one-novanta-loadmore:completed', this.onLoadMoreCompleted );
	}

	/**
	 * Sets up default taxonomy filters from the data-query attribute.
	 *
	 * Parses the `tax_query` from `.button-load-more-wrapper` and stores taxonomy terms in `this.filteredItems` as Sets.
	 */
	setUpDefaultQuery() {
		if ( ! this.loadMoreWrapper ) {
			return;
		}

		const defaultQuery = JSON.parse( this.loadMoreWrapper.dataset?.query );

		const { tax_query: taxQuery = [], has_add_to_cart: hasAddToCart = false } = defaultQuery;

		if ( hasAddToCart ) {
			this.hasAddToCart = true;
		}

		if ( ! taxQuery || taxQuery.length === 0 ) {
			return;
		}

		// Store the default query in filteredItems
		taxQuery.forEach( ( unitQuery ) => {
			const { taxonomy = '', terms = null } = unitQuery;

			if ( taxonomy.length === 0 || ! parseInt( terms ) ) {
				return;
			}

			this.filteredItems[ taxonomy ] = new Set();

			// Set taxonomy term in required format.
			this.filteredItems[ taxonomy ].add( terms.toString() );
		} );
	}

	/**
	 * Handle checkbox click events.
	 *
	 * @param {Event} event - The click event.
	 *
	 * @return {void}
	 */
	onFilterClicked( event ) {
		const checkbox = event.target;
		const { taxonomy, postType } = checkbox.dataset;
		const termId = checkbox.value;

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

		// Save latest postType, then trigger the debounced function with no args
		this.pendingPostType = postType;
		this.scheduleFilterUpdate();
	}

	/**
	 * Handle the filterChanged event.
	 *
	 * @return {void}
	 */
	filterChangedEvent() {
		const postType = this.pendingPostType; // Use the latest saved postType

		// Check if the wrapper exists
		if ( ! this.loadMoreWrapper || ! postType ) {
			return;
		}

		const target = this.querySelector( this.loadMoreWrapper.dataset.target );

		target.style.height = `${ target.offsetHeight }px`; // Start height of target element to prevent CLI.
		target.classList.add( 'hidden' );
		this.loadMoreWrapper.classList.add( 'hidden' );
		this.loadingIcon.classList.remove( 'hidden' );

		this.triggerLoadMore( target, postType );
	}

	/**
	 * Trigger the load more class Instance.
	 *
	 * @param {HTMLElement} target   The target element to load more content into.
	 * @param {string}      postType Current post-type.
	 *
	 * @return {void}
	 */
	async triggerLoadMore( target, postType ) {
		const searchResultsElement = this.querySelector( '.product-search__results-count' );

		// Clear target content
		target.innerHTML = '';

		// Clone the button to reset its state and remove the old event listener.
		const oldButton = this.querySelector( '.button-load-more' );
		const newButton = oldButton.cloneNode( true );
		oldButton.parentNode.replaceChild( newButton, oldButton );

		// Remove old display none style if present.
		this.loadMoreWrapper.removeAttribute( 'style' );

		const instance = new LoadMoreInstance( this.loadMoreWrapper );

		// Reset the page to 1 and update the query
		instance.wrapper.dataset.page = 1;

		// Construct tax_query object
		const taxQuery = { relation: 'AND' };
		Object.entries( this.filteredItems ).forEach( ( [ taxonomy, terms ], index ) => {
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
			has_add_to_cart: this?.hasAddToCart ?? false,
		} );

		instance.init();

		// Load the new data
		const { count, totalResults } = await instance.loadMore();

		// Update the foundPosts data-attribute after posts are filtered.
		instance.wrapper.dataset.foundPosts = totalResults;

		if ( searchResultsElement ) {
			searchResultsElement.innerHTML = searchResultsElement.innerHTML.replace(
				/\d+/,
				`${ totalResults }`,
			);
		}

		if ( count >= totalResults ) {
			// Hide load-more on filter-change if all the results are displayed.
			this.loadMoreWrapper.style.display = 'none';
		} else {
			this.loadMoreWrapper.removeAttribute( 'style' );
		}

		this.loadMoreWrapper.classList.remove( 'hidden' );
		this.loadingIcon.classList.add( 'hidden' );
		target.classList.remove( 'hidden' );

		if ( window.innerWidth < 768 ) {
			// Scroll to the top of the target element if the window is smaller than 768px wide.
			target.scrollIntoView( { behavior: 'instant', block: 'start', inline: 'nearest' } );
		}
		target.style.height = 'auto';
	}

	/**
	 * Triggered when load-more starts.
	 * Adds a class to show that filtering is in progress.
	 */
	onLoadMoreTrigger() {
		if ( ! this.checkBoxWrapper ) {
			return;
		}

		// Set fetching class to indicate, fetching in progress and disable further filter actions.
		this.checkBoxWrapper.classList.add( 'fetching-filtered-data' );
	}

	/**
	 * Triggered when load-more completes.
	 * Removes the fetching indicator class.
	 */
	onLoadMoreCompleted() {
		if ( ! this.checkBoxWrapper ) {
			return;
		}

		// After fetching is completed and data is updated, enable the filtering.
		this.checkBoxWrapper.classList.remove( 'fetching-filtered-data' );
	}
}

// Register the custom element
customElements.define( 'one-novanta-product-search', OneNovantaProductSearch );

window.addEventListener( 'load', () => {
	// Reset all checkbox filters.
	document
		.querySelectorAll( '.product-search .product-search__filter-widget input[type="checkbox"]' )
		?.forEach( ( checkbox ) => checkbox.checked = false );
} );
