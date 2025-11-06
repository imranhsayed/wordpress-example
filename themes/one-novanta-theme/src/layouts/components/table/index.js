/**
 * Component: Table.
 */

// Create a global flag to track if we've loaded the table.
window.OneNovanta = window.OneNovanta || {};
window.OneNovanta.tableComponentLoaded = window.OneNovanta.tableComponentLoaded || false;

/**
 * Table component.
 *
 * @type {Object}
 */
const OneNovantaTable = {

	/**
	 * Initialize.
	 *
	 * @return {void}
	 */
	init() {
		// Bind functions.
		this.filterRows = this.filterRows.bind( this );
		this.bindEvents = this.bindEvents.bind( this );
		this.resetFilter = this.resetFilter.bind( this );
		this.bindAttributes = this.bindAttributes.bind( this );
		this.addStickyStyles = this.addStickyStyles.bind( this );
		this.handleOptionSelect = this.handleOptionSelect.bind( this );
		this.filterChangeListener = this.filterChangeListener.bind( this );
		this.handleIsLoadingMutation = this.handleIsLoadingMutation.bind( this );
		this.registerIsLoadingObserver = this.registerIsLoadingObserver.bind( this );

		this.oldObserver = false;

		// Bind events.
		this.bindEvents();

		// Add sticky styles.
		this.addStickyStyles();

		// Register is-loading observer.
		this.registerIsLoadingObserver();
	},

	/**
	 * Register is-loading observer, so we can dynamically set the loading to true and false dynamically.
	 *
	 * @return {void}
	 */
	registerIsLoadingObserver() {
		// Check if the data-is-loading attribute exists, if it is true, pop the style of .wp-one-novanta-table__is-loading to display: flex. Use MutationObserver to watch for changes in the data-is-loading attribute.
		const observer = new MutationObserver( ( mutationsList ) => {
			for ( const mutation of mutationsList ) {
				if ( mutation.type === 'attributes' && mutation.attributeName === 'data-is-loading' ) {
					this.handleIsLoadingMutation( mutation.target );
				}
			}
		} );

		// Disconnect old observer.
		if ( this.oldObserver ) {
			this.oldObserver?.disconnect();
		}

		// Start observing the table for changes in the data-is-loading attribute.
		this?.tableWrappers?.forEach( ( table ) => {
			observer.observe( table, { attributes: true } );
			this.handleIsLoadingMutation( table );
		} );

		// Save current observer.
		this.oldObserver = observer;
	},

	/**
	 * Handles the display of the loading icon in the specified table based on its "data-is-loading" attribute.
	 *
	 * @param {HTMLElement} table The table element to check and update the loading icon visibility.
	 *
	 * @return {void}
	 */
	handleIsLoadingMutation( table ) {
		const isLoadingIconWrapper = table?.querySelector( '.wp-one-novanta-table__is-loading' );

		if ( ! isLoadingIconWrapper ) {
			return;
		}

		const isLoading = table?.getAttribute( 'data-is-loading' );

		if ( isLoading === 'true' ) {
			isLoadingIconWrapper.classList.remove( 'hidden' );
		} else {
			isLoadingIconWrapper.classList.add( 'hidden' );
		}
	},

	/**
	 * Bind attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		// Fetch table filters and tables.
		this.tablesFilters = document.querySelectorAll( '.wp-one-novanta-table .wp-one-novanta-table__filter' );
		this.tableWrappers = document.querySelectorAll( '.wp-one-novanta-table figure' );
	},

	/**
	 * Bind events.
	 *
	 * @return {void}
	 */
	bindEvents() {
		// Bind attributes.
		this.bindAttributes();

		// Bind table filter events.
		this?.tablesFilters?.forEach( ( tableFilter ) => {
			const options = tableFilter?.querySelectorAll( '.one-novanta-filter-dropdown__dropdown-list li' );

			options?.forEach( ( option ) => {
				// Remove old event listener.
				option.removeEventListener( 'click', () => this.handleOptionSelect( option ) );
				// Add new event listener.
				option.addEventListener( 'click', () => this.handleOptionSelect( option ) );
			} );
		} );
	},

	/**
	 * Handles filter select.
	 *
	 * @param {HTMLElement} option Current selected option.
	 *
	 * @return {void}
	 */
	handleOptionSelect( option ) {
		const optionValue = option?.textContent?.trim();

		// Fetch filter.
		const filter = option?.closest( '.wp-one-novanta-table__filter' );

		// Call change listener.
		this.filterChangeListener( filter, optionValue );
	},

	/**
	 * Fires whenever the filter value is changed in the table.
	 *
	 * @param {HTMLElement} filter        Table filter.
	 * @param {string}      selectedValue Current selected value.
	 *
	 * @return {void}
	 */
	filterChangeListener( filter, selectedValue ) {
		// Fetch default filter.
		const defaultSelector = filter?.querySelector( '.wp-one-novanta-table__filter__option--default' );

		// Extract default value.
		const defaultValue = defaultSelector?.textContent?.trim();

		// Return if default or selected filter values are not available.
		if ( ! selectedValue || ! defaultValue ) {
			return;
		}

		// Fetch the container.
		const table = filter?.closest( '.wp-one-novanta-table' );

		if ( ! table ) {
			return;
		}

		// Fetch all rows.
		const rows = table?.querySelectorAll( 'tbody tr' );

		// Extract the column index using which table needs to be filtered.
		const filterColumnIndex = filter?.dataset?.filterColumn;

		// Return if rows or column index is not available.
		if ( ! rows || ! filterColumnIndex ) {
			return;
		}

		// Enable all rows if the default filter is selected.
		if ( defaultValue === selectedValue ) {
			this.resetFilter( rows );
			return;
		}

		// Filter rows.
		this.filterRows( rows, parseInt( filterColumnIndex ), selectedValue );
	},

	/**
	 * Add sticky styles if the table content is scrollable.
	 *
	 * @return {void}
	 */
	addStickyStyles() {
		if ( ! Array.isArray( this?.tableWrappers ) || 0 === this?.tableWrappers?.length ) {
			this.bindAttributes();
		}

		this?.tableWrappers?.forEach( ( tableWrapper ) => {
			if ( tableWrapper.scrollWidth > tableWrapper.clientWidth ) {
				tableWrapper?.querySelector( '.wp-one-novanta-table__wrapper' )?.classList?.add( 'has-sticky' );
			}
		} );
	},

	/**
	 * Filter table rows.
	 *
	 * @param {Array<HTMLElement>} rows              Table rows.
	 * @param {number}             filterColumnIndex Column index using which table needs to be filtered.
	 * @param {string}             value             Selected filter value.
	 *
	 * @return {void}
	 */
	filterRows( rows, filterColumnIndex, value ) {
		rows?.forEach( ( row ) => {
			const cell = row.querySelector( `td:nth-child( ${ filterColumnIndex } )` );

			row?.classList?.remove( 'hidden' );

			if ( cell?.textContent?.trim() !== value ) {
				row?.classList?.add( 'hidden' );
			}
		} );
	},

	/**
	 * Reset filter by enabling all the rows.
	 *
	 * @param {Array<HTMLElement>} rows Table rows.
	 *
	 * @return {void}
	 */
	resetFilter( rows ) {
		rows?.forEach( ( row ) => row?.classList?.remove( 'hidden' ) );
	},
};

/**
 * Load only once.
 */
if ( ! window.OneNovanta.tableComponentLoaded ) {
	window.OneNovanta.tableComponentLoaded = true;

	// Initialize Table component scripts.
	document.addEventListener( 'DOMContentLoaded', () => OneNovantaTable.init() );
}

export default OneNovantaTable;
