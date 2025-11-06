/**
 * Check if it's below desktop view (i.e., mobile/tablet).
 * @return {boolean} - True if viewport is below desktop size.
 */
function isBelowDesktop() {
	return window.innerWidth < 1440;
}

// Wait for the DOM to fully load before executing the script
document.addEventListener( 'DOMContentLoaded', () => {
	// Select the hamburger menu button
	const hamburgerMenu = document.querySelector( '.one-novanta-header__hamburger-menu' );

	/**
	 * Toggles mobile navigation state on body and navigation parent
	 */
	function toggleMobileNavigation() {
		// Toggle class on <body> element
		document.body.classList.toggle( 'has-mobile-navigation-open' );

		// Find the closest parent with class 'one-novanta-header__navigation'
		const navParent = hamburgerMenu.closest( '.one-novanta-header__navigation' );

		// Toggle the active class on the navigation parent
		if ( navParent ) {
			navParent.classList.toggle( 'one-novanta-header__navigation--active' );
		}
	}

	/**
	 * Closes the mobile navigation if it is open
	 */
	function closeMobileNavigation() {
		// Only proceed if the navigation is currently open
		if ( document.body.classList.contains( 'has-mobile-navigation-open' ) ) {
			document.body.classList.remove( 'has-mobile-navigation-open' );

			const navParent = hamburgerMenu.closest( '.one-novanta-header__navigation' );
			if ( navParent ) {
				navParent.classList.remove( 'one-novanta-header__navigation--active' );
			}
		}
	}

	// Add click listener to the hamburger menu, if it exists
	if ( hamburgerMenu ) {
		hamburgerMenu.addEventListener( 'click', toggleMobileNavigation );
	}

	// Add keydown listener for Escape key to close mobile navigation
	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closeMobileNavigation();
		}
	} );

	// Add resize listener to remove mobile navigation if width is >= 1440
	window.addEventListener( 'resize', () => {
		if ( ! isBelowDesktop() ) {
			closeMobileNavigation();
		}
	} );
} );
