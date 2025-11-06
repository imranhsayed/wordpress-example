document.addEventListener( 'DOMContentLoaded', function() {
	// Select the original .wp-block-one-novanta-header-search element
	const headerSearch = document.querySelector( '.wp-block-one-novanta-header-search' );

	// Select the target navigation <ul>
	const navList = document.querySelector( 'ul.one-novanta-header__navigation' );

	if ( headerSearch && navList ) {
		// Clone the search
		const clonedSwitcher = headerSearch.cloneNode( true );

		// Create a new <li> and append the cloned search
		const li = document.createElement( 'li' );
		li.classList.add( 'wp-block-navigation-item', 'wp-block-one-novanta-header-search-item' ); // Add both classes
		li.appendChild( clonedSwitcher );

		// Append the <li> to the navigation list
		navList.prepend( li );
	}
} );
