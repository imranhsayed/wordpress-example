/**
 * Component: Filter Dropdown.
 */

// Create a global flag to track if we've loaded the filter-dropdown.
window.OneNovanta = window.OneNovanta || {};
window.OneNovanta.filterDropdownComponentLoaded = window.OneNovanta.filterDropdownComponentLoaded || false;

/**
 * Filter Dropdown component.
 *
 * @type {Object}
 */
const OneNovantaTableFilter = {
	/**
	 * Initialize.
	 *
	 * @return {void}
	 */
	init() {
		// Bind functions.
		this.bindEvents = this.bindEvents.bind( this );
		this.bindAttributes = this.bindAttributes.bind( this );
		this.toggleDropdown = this.toggleDropdown.bind( this );
		this.bindGlobalEvents = this.bindGlobalEvents.bind( this );
		this.handleOptionSelect = this.handleOptionSelect.bind( this );
		this.onOptionClickListener = this.onOptionClickListener.bind( this );

		// Bind events.
		this.bindEvents();

		// Bind global events.
		this.bindGlobalEvents();
	},

	/**
	 * Bind attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		this.tablesFilters = document.querySelectorAll( '.one-novanta-filter-dropdown' );
	},

	/**
	 * Bind global events.
	 *
	 * @return {void}
	 */
	bindGlobalEvents() {
		if ( ! Array.isArray( this?.tablesFilters ) || 0 === this?.tablesFilters?.length ) {
			this.bindAttributes();
		}

		// Add an event listener to close the filter dropdown if clicked outside.
		document.addEventListener( 'click', ( event ) => {
			this?.tablesFilters?.forEach( ( tableFilter ) => {
				const selectButton = tableFilter?.querySelector( '.one-novanta-filter-dropdown__button' );
				const dropdown = tableFilter?.querySelector( '.one-novanta-filter-dropdown__dropdown-list' );

				if ( ! selectButton || ! dropdown ) {
					return;
				}

				if ( ! tableFilter?.contains( event.target ) ) {
					this.toggleDropdown( selectButton, dropdown, false );
				}
			} );
		} );
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
			const selectButton = tableFilter?.querySelector( '.one-novanta-filter-dropdown__button' );
			const dropdown = tableFilter?.querySelector( '.one-novanta-filter-dropdown__dropdown-list' );
			const options = dropdown?.querySelectorAll( 'li' );
			const selectedValue = selectButton?.querySelector( '.one-novanta-filter-dropdown__selected-value' );

			if ( ! selectButton || ! dropdown || ! options || ! selectedValue ) {
				return;
			}

			options?.forEach( ( option ) => {
				// Remove old event listener.
				option.removeEventListener( 'click', () => this.onOptionClickListener( option, options, selectedValue, selectButton, dropdown ) );
				// Add new event listener.
				option.addEventListener( 'click', () => this.onOptionClickListener( option, options, selectedValue, selectButton, dropdown ) );
			} );

			// Remove old event listener.
			selectButton?.removeEventListener( 'click', () => this.toggleDropdown( selectButton, dropdown ) );
			// Add new event listener.
			selectButton?.addEventListener( 'click', () => this.toggleDropdown( selectButton, dropdown ) );
		} );
	},

	/**
	 * Click listener for filter options.
	 *
	 * @param {HTMLElement}        option        Current selected option.
	 * @param {Array<HTMLElement>} options       Filter options.
	 * @param {HTMLElement}        selectedValue Current selection.
	 * @param {HTMLElement}        selectButton  Filter dropdown button.
	 * @param {HTMLElement}        dropdown      Filter dropdown.
	 *
	 * @return {void}
	 */
	onOptionClickListener( option, options, selectedValue, selectButton, dropdown ) {
		this.handleOptionSelect( option, options, selectedValue );
		this.toggleDropdown( selectButton, dropdown, false );
	},

	/**
	 * Toggles filter dropdown.
	 *
	 * @param {HTMLElement}  selectButton Filter dropdown button.
	 * @param {HTMLElement}  dropdown     Filter dropdown.
	 * @param {boolean|null} expand       Is filter expanded.
	 *
	 * @return {void}
	 */
	toggleDropdown( selectButton, dropdown, expand = null ) {
		const isOpen =
			expand !== null ? expand : dropdown?.classList?.contains( 'is-hidden' );
		dropdown?.classList?.toggle( 'is-hidden', ! isOpen );
		selectButton?.setAttribute( 'aria-expanded', isOpen?.toString() );
	},

	/**
	 * Handles filter select.
	 *
	 * @param {HTMLElement}        option        Current selected option.
	 * @param {Array<HTMLElement>} options       Filter options.
	 * @param {HTMLElement}        selectedValue Current selection.
	 *
	 * @return {void}
	 */
	handleOptionSelect( option, options, selectedValue ) {
		options?.forEach( ( opt ) => {
			opt?.classList?.remove( 'selected' );
			opt?.setAttribute( 'aria-selected', 'false' );
		} );

		option?.classList?.add( 'selected' );
		option?.setAttribute( 'aria-selected', 'true' );

		const visibleText = option?.textContent?.trim();
		const slugValue = option?.getAttribute( 'data-filter-slug' );

		if ( ! selectedValue ) {
			return;
		}

		// Update the visible label.
		selectedValue.textContent = visibleText;

		// Update slug attribute if present, otherwise remove it.
		if ( slugValue ) {
			selectedValue.setAttribute( 'data-filter-slug', slugValue );
		} else {
			selectedValue.removeAttribute( 'data-filter-slug' );
		}
	},
};

/**
 * Load only once.
 */
if ( ! window.OneNovanta.filterDropdownComponentLoaded ) {
	window.OneNovanta.filterDropdownComponentLoaded = true;

	// Initialize Filter Dropdown component scripts.
	document.addEventListener( 'DOMContentLoaded', () => OneNovantaTableFilter.init() );
}

export default OneNovantaTableFilter;
