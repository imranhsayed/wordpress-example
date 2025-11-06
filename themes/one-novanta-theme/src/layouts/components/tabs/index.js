/**
 * Component: Tabs.
 */

/**
 * Global variables.
 */
const { customElements } = window;

// Create a global flag to track if we've imported/loaded the tabs.
window.OneNovanta = window.OneNovanta || {};
window.OneNovanta.tabsWebComponentImported = window.OneNovanta.tabsWebComponentImported || false;
window.OneNovanta.tabsComponentLoaded = window.OneNovanta.tabsComponentLoaded || false;

/**
 * External dependencies - only import once
 */
if ( ! window.OneNovanta.tabsWebComponentImported && ! customElements.get( 'rt-tabs' ) ) {
	window.OneNovanta.tabsWebComponentImported = true;
	require( '@rtcamp/web-components/build/tabs' );
}

/**
 * Internal dependencies
 */
import OneNovantaTable from '../table';

/**
 * Internal dependencies
 */

/**
 * Tabs component.
 *
 * @type {Object}
 */
const OneNovantaTabs = {

	/**
	 * Initialize.
	 *
	 * @return {void}
	 */
	init() {
		// Bind functions.
		this.bindEvents = this.bindEvents.bind( this );
		this.bindAttributes = this.bindAttributes.bind( this );

		// Bind events.
		this.bindEvents();
	},

	/**
	 * Bind Attributes.
	 *
	 * @return {void}
	 */
	bindAttributes() {
		this.tabs = document.querySelectorAll( '.novanta-tabs-wrapper rt-tabs-nav-item' );
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
		this?.tabs?.forEach( ( tab ) => {
			const tabButton = tab.querySelector( 'a' );

			if ( ! tabButton ) {
				return;
			}

			// Remove old event listener if it exists.
			tabButton.removeEventListener( 'click', OneNovantaTable.addStickyStyles );

			// Add sticky styles to tables when the tab changes.
			tabButton.addEventListener( 'click', OneNovantaTable.addStickyStyles );
		} );
	},
};

/**
 * Load only once.
 */
if ( ! window.OneNovanta.tabsComponentLoaded ) {
	window.OneNovanta.tabsComponentLoaded = true;

	// Initialize Tabs component scripts.
	document.addEventListener( 'DOMContentLoaded', () => OneNovantaTabs.init() );
}

export default OneNovantaTabs;
