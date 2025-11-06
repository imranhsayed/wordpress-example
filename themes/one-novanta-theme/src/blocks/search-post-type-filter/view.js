/**
 * Frontend script for the Search post type filter block.
 */

document.addEventListener( 'DOMContentLoaded', () => {
	const postTypeFilter = document.querySelector( '.search-filter' );

	// Early return if the post type filter element is not found
	if ( ! postTypeFilter ) {
		return;
	}

	const leftBlur = postTypeFilter.querySelector( '.left-blur' );
	const rightBlur = postTypeFilter.querySelector( '.right-blur' );

	// Early return if either blur element is not found
	if ( ! leftBlur || ! rightBlur ) {
		return;
	}

	const scrollThreshold = 10;
	let ticking = false;

	/**
	 * Updates blur visibility based on scroll position
	 */
	function updateBlurVisibility() {
		const { scrollLeft, scrollWidth, clientWidth } = postTypeFilter;
		const maxScrollLeft = scrollWidth - clientWidth;

		// Show the left blur if the user has scrolled past the initial threshold.
		leftBlur.classList.toggle( 'show', scrollLeft > scrollThreshold );

		// Show the right blur if the user has not yet reached the end of the scrollable area.
		rightBlur.classList.toggle( 'show', scrollLeft < maxScrollLeft - scrollThreshold );

		// Allow the next scroll event to be processed.
		ticking = false;
	}

	/**
	 * A throttled scroll handler that uses requestAnimationFrame to optimize performance
	 * by updating the blur visibility only before the next browser repaint.
	 */
	function handleScroll() {
		if ( ! ticking ) {
			window.requestAnimationFrame( updateBlurVisibility );
			ticking = true;
		}
	}

	// Initial visibility check
	updateBlurVisibility();

	// Add scroll event listener
	postTypeFilter.addEventListener( 'scroll', handleScroll, { passive: true } );

	// Observe the container for resize events to update the blur visibility.
	const resizeObserver = new ResizeObserver( updateBlurVisibility );
	resizeObserver.observe( postTypeFilter );
}, { once: true } );
