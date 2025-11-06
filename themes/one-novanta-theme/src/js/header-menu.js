/**
 * Internal dependencies
 */
import { debounce } from '../js/utils';

/**
 * Check if it's below desktop view (i.e., mobile/tablet).
 * @return {boolean} - True if viewport is below desktop size.
 */
function isBelowDesktop() {
	return window.innerWidth < 1440;
}

/**
 * Initialize submenu toggle functionality for mobile views.
 */
function initMobileSubmenu() {
	// Select all submenu list items in the navigation.
	const submenuItems = document.querySelectorAll( '.wp-block-navigation-submenu:not([data-js-initialized="true"])' );

	// Exit early if no submenu items found.
	if ( ! submenuItems || submenuItems.length === 0 ) {
		return;
	}

	submenuItems.forEach( ( menuItem ) => {
		const toggleBtn = menuItem.querySelector( '.wp-block-navigation-submenu__toggle' );
		const submenu = menuItem.querySelector( '.wp-block-navigation__submenu-container' );

		if ( toggleBtn && submenu ) {
			// Remove WordPress's interactivity bindings.
			menuItem.removeAttribute( 'data-wp-on-async--mouseenter' );
			menuItem.removeAttribute( 'data-wp-on-async--mouseleave' );
			toggleBtn.removeAttribute( 'data-wp-bind--aria-expanded' );
			toggleBtn.removeAttribute( 'data-wp-on-async--click' );

			// Add custom click handler.
			toggleBtn.addEventListener( 'click', function( e ) {
				e.preventDefault();
				e.stopPropagation();

				const isExpanded = toggleBtn.getAttribute( 'aria-expanded' ) === 'true';
				const newState = ! isExpanded;

				toggleBtn.setAttribute( 'aria-expanded', newState );
				submenu.classList.toggle( 'is-open', newState );
				menuItem.classList.toggle( 'submenu-open', newState );
			} );
		}

		// Mark as initialized to avoid reprocessing.
		menuItem.dataset.jsInitialized = 'true';
	} );
}

// On initial load.
document.addEventListener( 'DOMContentLoaded', function() {
	if ( isBelowDesktop() ) {
		initMobileSubmenu();
	}
} );

// Debounced resize handler.
window.addEventListener( 'resize', debounce( function() {
	if ( isBelowDesktop() ) {
		initMobileSubmenu();
	}
}, 150 ) );
