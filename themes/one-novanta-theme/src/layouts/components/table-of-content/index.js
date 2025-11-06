/**
 * Table of Content Scroll Handler.
 * Uses requestAnimationFrame and CSS variables for optimal animation performance
 */
document.addEventListener( 'DOMContentLoaded', () => {
	// Get the table of content element
	const tocElement = document.querySelector( '.table-of-content' );

	// If no TOC element exists on the page, exit early
	if ( ! tocElement ) {
		return;
	}

	// Select all TOC links inside list items and convert NodeList to array
	const tocLinks = Array.from( document.querySelectorAll( '.table-of-content__list-item > a' ) );

	// If no TOC links found, exit early
	if ( tocLinks.length === 0 ) {
		return;
	}

	// Get the parent <li> elements for each TOC link
	const tocItems = tocLinks.map( ( link ) => link.closest( 'li' ) );

	// Get the target heading element each TOC link points to
	const headingElements = tocLinks.map( ( link ) => {
		const href = link.getAttribute( 'href' );
		return href ? document.querySelector( href ) : null;
	} );

	// Track whether an animation frame is already scheduled
	let ticking = false;

	// Track last active index for smoother transitions
	let lastActiveIndex = -1;

	// Track the last progress percentage
	let lastProgressPercentage = 0;

	// Track if the TOC is in the viewport
	let isTocVisible = false;

	// Track if the scroll listener is attached
	let isScrollListenerAttached = false;

	/**
	 * Set the click event for the TOC element on mobile devices.
	 *
	 * @return {void}
	 */
	function setTocClickEvent() {
		if ( window.innerWidth > 781 ) {
			return;
		}

		tocElement?.setAttribute( 'aria-expanded', 'false' );

		tocElement?.addEventListener( 'click', ( event ) => {
			event?.preventDefault();
			const anchor = event?.target?.closest( 'a[href^="#"]' );

			const currentState = tocElement?.getAttribute( 'aria-expanded' );

			switch ( currentState?.toLowerCase() ) {
				case 'true':
					tocElement?.setAttribute( 'aria-expanded', 'false' );
					break;
				case 'false':
					tocElement?.setAttribute( 'aria-expanded', 'true' );
			}

			if ( anchor ) {
				const targetId = anchor?.getAttribute( 'href' )?.substring( 1 );
				const targetElement = document.getElementById( targetId );

				if ( targetElement ) {
					// Add timeout to let toc dropdown close before scroll.
					setTimeout( () => targetElement.scrollIntoView( { behavior: 'smooth' } ), 300 );
				}
			}
		} );
	}

	/**
	 * Check if the TOC element is visible in the viewport
	 * @return {boolean} Whether the TOC is visible
	 */
	function checkTocVisibility() {
		const rect = tocElement.getBoundingClientRect();
		const windowHeight = window.innerHeight || document.documentElement.clientHeight;

		// Consider TOC visible if any part of it is in the viewport
		return rect.top < windowHeight && rect.bottom > 0;
	}

	/**
	 * Attach or detach scroll listener based on TOC visibility
	 */
	function toggleScrollListener() {
		const shouldBeVisible = checkTocVisibility();

		// Update the visibility state
		isTocVisible = shouldBeVisible;

		// Handle scroll listener attachment/detachment based on current visibility state
		if ( isTocVisible && ! isScrollListenerAttached ) {
			// TOC is visible but listener not attached, so attach it
			window.addEventListener( 'scroll', onScroll );
			isScrollListenerAttached = true;

			// Update immediately
			updateActiveItem();
		} else if ( ! isTocVisible && isScrollListenerAttached ) {
			// TOC is not visible but listener is attached, so detach it
			window.removeEventListener( 'scroll', onScroll );
			isScrollListenerAttached = false;
		}
	}

	/**
	 * Update the state of all TOC items based on current scroll position
	 */
	function updateActiveItem() {
		// Only process if TOC is visible
		if ( ! isTocVisible ) {
			ticking = false;
			return;
		}

		const threshold = 50; // Pixel distance from top of viewport to consider "active"
		let activeIndex = -1;
		let progressPercentage = 0;

		// Calculate active heading with hysteresis to prevent rapid switching
		// First check if the last active heading is still somewhat visible
		if ( lastActiveIndex !== -1 && headingElements[ lastActiveIndex ] ) {
			const lastActiveRect = headingElements[ lastActiveIndex ].getBoundingClientRect();
			// Keep the last active heading if it's still largely in view
			if ( lastActiveRect.top > -100 && lastActiveRect.top < 100 ) {
				activeIndex = lastActiveIndex;
			}
		}

		// If no heading is active yet, find the one closest to the top
		if ( activeIndex === -1 ) {
			// First pass: check for heading that is close to the top of the viewport
			headingElements.forEach( ( heading, index ) => {
				if ( ! heading ) {
					return;
				} // Skip if heading doesn't exist

				const rect = heading.getBoundingClientRect();
				if ( Math.abs( rect.top ) <= threshold ) {
					activeIndex = index;
				}
			} );

			// Fallback: if none are exactly aligned, use last heading above the viewport
			if ( activeIndex === -1 ) {
				for ( let i = headingElements.length - 1; i >= 0; i-- ) {
					if ( headingElements[ i ] && headingElements[ i ].getBoundingClientRect().top < 0 ) {
						activeIndex = i;
						break;
					}
				}
			}
		}

		// Default to first heading if still no active heading found
		if ( activeIndex === -1 && headingElements.length > 0 ) {
			activeIndex = 0;
		}

		// Calculate progress percentage for the active heading
		if ( activeIndex !== -1 && activeIndex < headingElements.length - 1 ) {
			const currentHeading = headingElements[ activeIndex ];
			const nextHeading = headingElements[ activeIndex + 1 ];

			if ( currentHeading && nextHeading ) {
				const currentRect = currentHeading.getBoundingClientRect();
				const nextRect = nextHeading.getBoundingClientRect();

				// Calculate distance between the two headings
				const contentDistance = nextRect.top - currentRect.top;

				// Calculate how far we've scrolled past the current heading
				// Only consider negative top values (heading is above viewport top)
				const scrolledPastHeading = currentRect.top <= 0 ? -currentRect.top : 0;

				// Calculate percentage (0-100%)
				progressPercentage = Math.min( 100, Math.max( 0, ( scrolledPastHeading / contentDistance ) * 100 ) );
			}
		}

		// Smooth out progress changes using interpolation
		const smoothProgress = lastActiveIndex === activeIndex
			? lastProgressPercentage + ( ( progressPercentage - lastProgressPercentage ) * 0.15 )
			: progressPercentage;

		lastProgressPercentage = smoothProgress;

		// Update all items based on their relationship to the active item
		tocItems.forEach( ( item, index ) => {
			// Items before active index are visited
			if ( index < activeIndex ) {
				item.dataset.visited = '1';
				item.dataset.active = '0';
				// Remove any leftover progress
				item.style.removeProperty( '--toc-progress' );
			} else if ( index === activeIndex ) {
				// Current active item
				item.dataset.active = '1';
				item.dataset.visited = '0';

				// Apply the progress percentage to the active item
				if ( index < headingElements.length - 1 ) {
					item.style.setProperty( '--toc-progress', `${ smoothProgress }%` );
				}
			} else {
				// Future items
				item.dataset.active = '0';
				item.dataset.visited = '0';
				// Remove any leftover progress
				item.style.removeProperty( '--toc-progress' );
			}
		} );

		// Update last active index
		lastActiveIndex = activeIndex;

		// Reset the ticking flag to allow future animations
		ticking = false;
	}

	/**
	 * Scroll event handler that uses requestAnimationFrame to optimize performance
	 */
	function onScroll() {
		if ( ! ticking ) {
			// Only request a new animation frame if one isn't already pending
			requestAnimationFrame( updateActiveItem );
			ticking = true;
		}
	}

	// Set up intersection observer to efficiently track TOC visibility
	const intersectionObserver = new IntersectionObserver(
		( entries ) => {
			// Update visibility based on intersection
			isTocVisible = entries[ 0 ].isIntersecting;
			toggleScrollListener();
		},
		{ threshold: 0 }, // Trigger as soon as any part becomes visible
	);

	// Start observing the TOC element
	intersectionObserver.observe( tocElement );

	// Also listen for resize events which might affect visibility
	window.addEventListener( 'resize', toggleScrollListener );

	// Initial check to set everything up
	toggleScrollListener();

	setTocClickEvent();
} );
