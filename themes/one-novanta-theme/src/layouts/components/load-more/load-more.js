/**
 * Component: Load More.
 *
 * Description:
 * This component dynamically loads more content from an API and appends it to a specified container in the DOM
 * when the user clicks a "Load More" button. It extracts configuration from data-* attributes on the button wrapper.
 *
 * API Requirements:
 * The API endpoint specified in the `data-source` attribute must return a JSON response in the following format:
 *
 * {
 *	"content": "<div>HTML string of new posts/items</div>",
 *	"count": 5
 * }
 *
 * - `content` (string): A string of HTML that will be inserted into the target container.
 * - `count` (number): The number of items returned. Used to determine whether to disable the "Load More" button.
 *
 * This component sends a GET request with the following query parameters:
 * - page: Current page number (int)
 * - numberOfPostsToLoad: Number of items to load (int)
 * - query: JSON string of query data (encoded)
 * - nonce: Security nonce for authentication (string)
 * - foundPosts: Total number of post, only added at the first query.
 *
 * NOTE: The API endpoint must handle the nonce for verification.
 */

/**
 * Component: Load More (supports multiple instances).
 *
 * Each .button-load-more-wrapper element on the page initializes its own handler.
 */
const OneNovantaLoadMore = {
	/**
	 * Initialize all instances.
	 *
	 * @return {void}
	 */
	init() {
		// Bind functions.
		this.bindAttributes = this.bindAttributes.bind( this );
		this.bindEvents = this.bindEvents.bind( this );

		// Bind events.
		this.bindEvents();
	},

	/**
	 * Bind Attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		this.wrappers = document.querySelectorAll( '.button-load-more-wrapper' );
	},

	/**
	 * Bind events.
	 *
	 * @return {void}
	 */
	bindEvents() {
		// Bind Attributes.
		this.bindAttributes();

		// Bind tabs click event.
		this?.wrappers?.forEach( ( wrapper ) => {
			const instance = new LoadMoreInstance( wrapper );
			instance.init();
		} );
	},
};

/**
 * LoadMoreInstance: Handles a single load-more wrapper instance.
 */
class LoadMoreInstance {
	constructor( wrapper ) {
		this.wrapper = wrapper;
		this.button = null;
		this.targetContainer = null;

		// Individual instance-specific data attributes
		this.page = 0;
		this.query = {};
		this.nonce = '';
		this.source = '';
		this.target = '';
		this.numberOfPostsToLoad = 0;
	}

	/**
	 * Initialize this instance.
	 *
	 * @return {void}
	 */
	init() {
		if ( ! this.wrapper ) {
			return;
		}

		this.loadMore = this.loadMore.bind( this );

		this.setDataAttributes();

		this.button = this.wrapper.querySelector( '.button-load-more' );
		this.targetContainer = document.querySelector( this.target );

		if ( ! this.button || ! this.targetContainer ) {
			return;
		}

		// Remove old event listener.
		this.button.removeEventListener( 'click', this.loadMore );

		// Add new event listener.
		this.button.addEventListener( 'click', this.loadMore );
	}

	/**
	 * Set data attributes from the wrapper.
	 *
	 * @return {void}
	 */
	setDataAttributes() {
		const dataset = this.wrapper.dataset;

		this.page = parseInt( dataset.page || 0, 10 );
		this.query = JSON.parse( dataset.query || '{}' );
		this.nonce = dataset.nonce;
		this.source = dataset.source;
		this.target = dataset.target;
		this.numberOfPostsToLoad = parseInt( dataset.numberOfPostsToLoad || 0, 10 );
	}

	/**
	 * Load more content on button click.
	 *
	 * @return {Promise<void>} The fetched data is returned to be used by other scripts.
	 */
	async loadMore() {
		this.button.toggleAttribute( 'disabled', true );
		this.dispatchLoadMoreTriggered();

		// Resync the data attributes because we dynamically update the query parameters for documents filter.
		this.setDataAttributes();

		const fetchedData = await this.fetchContent();

		// If no data is fetched, enable the button and exit.
		if ( ! this.checkFetchedContent( fetchedData ) ) {
			this.button.toggleAttribute( 'disabled', false );
			this.dispatchLoadMoreCompleted();
			return;
		}

		this.appendContent( fetchedData );

		this.page += 1;
		this.wrapper.dataset.page = this.page;
		this.button.toggleAttribute( 'disabled', false );
		this.dispatchLoadMoreCompleted();

		return fetchedData;
	}

	/**
	 * Fetch content via GET request.
	 *
	 * @return {Promise<Object>} Custom API response. Which should follow the format: { content: string, count: number }
	 */
	async fetchContent() {
		try {
			const params = new URLSearchParams( {
				page: this.page,
				numberOfPostsToLoad: this.numberOfPostsToLoad,
			} );

			// Encode the query separately to ensure it does not get double encoded by URLSearchParams.
			params.set( 'query', encodeURIComponent( JSON.stringify( this.query ) ) );

			const headers = new Headers( {
				'Content-Type': 'application/json',
				'X-WP-Nonce': this.nonce,
			} );

			const response = await fetch( `${ this.source }?${ params.toString() }`, {
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
			console.error( 'Failed to load content.' );
		}

		return null;
	}

	/**
	 * Append new content to the DOM.
	 *
	 * @param {Object} fetchedData
	 *
	 * @return {void}
	 */
	appendContent( fetchedData ) {
		const { content, count } = fetchedData;

		this.targetContainer.insertAdjacentHTML( 'beforeend', content );
		const foundPosts = this.wrapper.dataset.foundPosts;
		const loadedPosts = this.targetContainer.children.length;

		if ( this.shouldHideWrapper( parseInt( count ), loadedPosts, foundPosts, this.numberOfPostsToLoad ) ) {
			this.wrapper.style.display = 'none';
		}
	}

	/**
	 * Check fetched content.
	 *
	 * @param {Object} fetchedData Content fetched from the API.
	 *
	 * @return {boolean} True if the content is valid, false otherwise.
	 */
	checkFetchedContent( fetchedData ) {
		return (
			typeof fetchedData === 'object' &&
			fetchedData !== null &&
			'content' in fetchedData &&
			'count' in fetchedData
		);
	}

	/**
	 * Determines whether the wrapper should be hidden based on the number of posts loaded and available.
	 *
	 * @param {number} count               - The number of posts returned in the current fetch.
	 * @param {number} loadedPosts         - The total number of posts loaded in the DOM after current request posts are added.
	 * @param {number} totalAvailablePosts - The total number of available posts (can be NaN if unknown).
	 * @param {number} postsToLoad         - The configured number of posts to load per fetch.
	 *
	 * @return {boolean} True if the wrapper should be hidden, false otherwise.
	 */
	shouldHideWrapper( count, loadedPosts, totalAvailablePosts, postsToLoad ) {
		return (
			count < postsToLoad ||
			( ! Number.isNaN( totalAvailablePosts ) && loadedPosts >= totalAvailablePosts )
		);
	}

	/**
	 * Dispatches the custom "load more triggered" event.
	 */
	dispatchLoadMoreTriggered() {
		// Dispatch custom load-more triggered event before loading
		this.wrapper.dispatchEvent( new CustomEvent( 'one-novanta-loadmore:triggered', {
			bubbles: true,
		} ) );
	}

	/**
	 * Dispatches the custom "load more completed" event.
	 */
	dispatchLoadMoreCompleted() {
		// Dispatch custom load-more completed event after content is added
		this.wrapper.dispatchEvent( new CustomEvent( 'one-novanta-loadmore:completed', {
			bubbles: true,
		} ) );
	}
}

export { LoadMoreInstance, OneNovantaLoadMore };
