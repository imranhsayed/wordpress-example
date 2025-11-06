/**
 * Component: Compare Model Table.
 */

// Create a global flag to track if we've loaded the compare-model-table.
window.OneNovanta = window.OneNovanta || {};
window.OneNovanta.compareModelTableComponentLoaded = window.OneNovanta.compareModelTableComponentLoaded || false;

/**
 * Compare Model Table component.
 *
 * @type {Object}
 */
const OneNovantaCompareModelTable = {

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
		this.handleOptionSelect = this.handleOptionSelect.bind( this );
		this.filterChangeListener = this.filterChangeListener.bind( this );

		// Bind events.
		this.bindEvents();
	},

	/**
	 * Bind attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		// Fetch table filters.
		this.tablesFilters = document.querySelectorAll( '.wp-one-novanta-compare-model-table .wp-one-novanta-compare-model-table__filter' );
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
		const filter = option?.closest( '.wp-one-novanta-compare-model-table__filter' );

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
		const defaultSelector = filter?.querySelector( '.wp-one-novanta-compare-model-table__filter__option--default' );

		// Extract default value.
		const defaultValue = defaultSelector?.textContent?.trim();

		// Return if default or selected filter values are not available.
		if ( ! selectedValue || ! defaultValue ) {
			return;
		}

		// Fetch the container.
		const table = filter?.closest( '.wp-one-novanta-compare-model-table' );

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
			const cell = row?.querySelector( `td:nth-child( ${ filterColumnIndex + 1 } )` );

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
if ( ! window.OneNovanta.compareModelTableComponentLoaded ) {
	window.OneNovanta.compareModelTableComponentLoaded = true;

	// Initialize Compare Model Table component scripts.
	document.addEventListener( 'DOMContentLoaded', () => OneNovantaCompareModelTable.init() );
}

export default OneNovantaCompareModelTable;
