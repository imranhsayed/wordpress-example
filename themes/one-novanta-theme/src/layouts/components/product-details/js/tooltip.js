/**
 * Global variables.
 */
const { customElements, HTMLElement, document } = window;

/**
 * ProductTooltip Class.
 */
export default class ProductTooltip extends HTMLElement {
	constructor() {
		super();

		// Store references.
		this.labels = [];
		this.cleanups = new Map();
		this.activeTooltips = new Set();
		this.labelSelector = 'th.label label';
		this.tooltipContentSelector = '.product-details__tooltip-content';
		this.arrowOffsetProperty = '--arrow-offset-left';
	}

	/**
	 * Called when the element is inserted into the DOM.
	 */
	connectedCallback() {
		// Store references.
		this.labels = Array.from( this.querySelectorAll( this.labelSelector ) );

		// Initialize tooltips.
		this.labels.forEach( this.initProductTooltip.bind( this ) );

		// Add global click handler for mobile tooltip dismissal
		this.globalClickHandler = this.handleGlobalClick.bind( this );
		document.addEventListener( 'click', this.globalClickHandler );
		document.addEventListener( 'touchstart', this.globalClickHandler );
	}

	/**
	 * Called when the element is removed from the DOM.
	 */
	disconnectedCallback() {
		// Clean up event listeners.
		this.cleanups.forEach( ( cleanupFn ) => cleanupFn() );
		this.cleanups.clear();

		// Remove global click handler
		document.removeEventListener( 'click', this.globalClickHandler );
		document.removeEventListener( 'touchstart', this.globalClickHandler );
	}

	/**
	 * Handle global clicks to close tooltips on mobile
	 *
	 * @param {MouseEvent} event -The click event
	 */
	handleGlobalClick = ( event ) => {
		// Only handle if we have active tooltips
		if ( 0 === this.activeTooltips.size ) {
			return;
		}

		// Check if the click was on a tooltip trigger or tooltip content
		const clickedElement = event.target;
		const isTooltipTrigger = clickedElement.closest( this.labelSelector );
		const isTooltipContent = clickedElement.closest( this.tooltipContentSelector );

		// If clicked outside tooltip triggers and content, hide all tooltips
		if ( ! isTooltipTrigger && ! isTooltipContent ) {
			this.hideAllTooltips();
		}
	};

	/**
	 * Hide all active tooltips
	 */
	hideAllTooltips = () => {
		this.activeTooltips.forEach( ( hideFunction ) => {
			hideFunction();
		} );
		this.activeTooltips.clear();
	};

	/**
	 * Check if tooltip content is empty or not found.
	 *
	 * @param {HTMLElement|null} content - The tooltip content element to check
	 *
	 * @return {boolean} - Returns true if content is empty or null, false otherwise
	 */
	isTooltipEmpty = ( content ) => {
		if ( ! content ) {
			return true;
		}

		const trimmedContent = content.textContent.trim();
		return trimmedContent === '';
	};

	/**
	 * Create a span element for the icon.
	 *
	 * Note: If we create icon using css ::after pseudo-element, calculation of tooltip position will not be accurate for all cases.
	 */
	createIcon = () => {
		const icon = document.createElement( 'span' );
		icon.className = 'product-details__tooltip-icon';
		icon.textContent = 'i';
		icon.setAttribute( 'aria-hidden', 'true' );
		return icon;
	};

	/**
	 * Add event handlers for showing and hiding the tooltip.
	 *
	 * @param {HTMLElement} label               - The label element to attach the tooltip to
	 * @param {HTMLElement} tooltipContent      - The tooltip content element
	 * @param {HTMLElement} iconSpan            - The icon span element
	 * @param {HTMLElement} originalParent      - The original parent element of the tooltip content
	 * @param {HTMLElement} originalNextSibling - The original next sibling of the tooltip content
	 */
	addTooltipEventHandlers = ( label, tooltipContent, iconSpan, originalParent, originalNextSibling ) => {
		let isTooltipVisible = false;

		// Show the tooltip
		const showTooltip = () => {
			if ( isTooltipVisible ) {
				return;
			}

			isTooltipVisible = true;

			// Append to body to escape positioning contexts
			document.body.appendChild( tooltipContent );

			// Make visible and get positions/dimensions
			tooltipContent.style.display = 'block';

			// Get the icon position and dimensions
			const iconRect = iconSpan.getBoundingClientRect();
			const tooltipHeight = tooltipContent.offsetHeight;
			const tooltipWidth = tooltipContent.offsetWidth;

			// Gap between icon and tooltip content
			const gap = 8;

			// Calculate Tooltip Position based on Icon
			let desiredTop = iconRect.top + window.scrollY - tooltipHeight - gap;
			let desiredLeft = iconRect.left + window.scrollX + ( iconRect.width / 2 ) - ( tooltipWidth / 2 );

			// Calculate arrow position relative to the tooltip icon
			const iconCenterViewportX = iconRect.left + ( iconRect.width / 2 );
			const tooltipLeftViewportX = desiredLeft - window.scrollX;
			let arrowOffsetLeft = iconCenterViewportX - tooltipLeftViewportX;

			// Adjust Tooltip position to stay within viewport boundaries
			const viewportWidth = document.documentElement.clientWidth;
			const viewportHeight = document.documentElement.clientHeight;
			const scrollX = window.scrollX;
			const scrollY = window.scrollY;
			const edgeMargin = 5;

			tooltipContent.classList.remove( 'tooltip-below' );

			// Adjust top boundary
			if ( desiredTop < scrollY + edgeMargin ) {
				desiredTop = iconRect.bottom + scrollY + gap;
				tooltipContent.classList.add( 'tooltip-below' );

				if ( desiredTop + tooltipHeight > viewportHeight + scrollY - edgeMargin ) {
					desiredTop = scrollY + edgeMargin;
				}
			}

			// Adjust left boundary
			const originalDesiredLeft = desiredLeft;
			if ( desiredLeft < scrollX + edgeMargin ) {
				desiredLeft = scrollX + edgeMargin;
				arrowOffsetLeft -= ( desiredLeft - originalDesiredLeft );
			}

			if ( desiredLeft + tooltipWidth > viewportWidth + scrollX - edgeMargin ) {
				desiredLeft = viewportWidth + scrollX - tooltipWidth - edgeMargin;
				arrowOffsetLeft -= ( desiredLeft - originalDesiredLeft );
			}

			// Clamp arrow position
			const arrowWidth = 6;
			arrowOffsetLeft = Math.max( arrowWidth, Math.min( arrowOffsetLeft, tooltipWidth - arrowWidth ) );

			// Set tooltip position
			tooltipContent.style.top = `${ desiredTop }px`;
			tooltipContent.style.left = `${ desiredLeft }px`;
			tooltipContent.style.setProperty( this.arrowOffsetProperty, `${ arrowOffsetLeft }px` );

			// Add to active tooltips for mobile management
			this.activeTooltips.add( hideTooltip );
		};

		// Hide the tooltip
		const hideTooltip = () => {
			if ( ! isTooltipVisible ) {
				return;
			}

			isTooltipVisible = false;

			tooltipContent.style.display = 'none';
			tooltipContent.classList.remove( 'tooltip-below' );
			tooltipContent.style.removeProperty( this.arrowOffsetProperty );

			if ( originalParent ) {
				if ( originalNextSibling ) {
					originalParent.insertBefore( tooltipContent, originalNextSibling );
				} else {
					originalParent.appendChild( tooltipContent );
				}
			} else {
				tooltipContent.remove();
			}
			tooltipContent.style.top = '';
			tooltipContent.style.left = '';

			// Remove from active tooltips
			this.activeTooltips.delete( hideTooltip );
		};

		// Toggle tooltip (for mobile tap)
		const toggleTooltip = ( event ) => {
			event.preventDefault();
			event.stopPropagation();

			if ( isTooltipVisible ) {
				hideTooltip();
			} else {
				// Hide other tooltips first
				this.hideAllTooltips();
				showTooltip();
			}
		};

		// Desktop mouse events
		label.addEventListener( 'mouseenter', showTooltip );
		label.addEventListener( 'mouseleave', hideTooltip );

		// Keyboard events
		label.addEventListener( 'focus', showTooltip );
		label.addEventListener( 'blur', hideTooltip );
		label.addEventListener( 'keydown', ( event ) => {
			if ( 'Escape' === event.key ) {
				hideTooltip();
				label.blur();
			}
		} );

		// Mobile touch events
		label.addEventListener( 'touchstart', ( event ) => {
			// Prevent the touchstart from triggering mouse events
			event.preventDefault();
		} );

		label.addEventListener( 'touchend', toggleTooltip );

		// Handle click for mobile devices that fire click events
		label.addEventListener( 'click', ( event ) => {
			// Check if this is a touch-generated click by looking at event properties
			// or if we're on a touch device
			if ( 'ontouchstart' in window || navigator.maxTouchPoints > 0 ) {
				toggleTooltip( event );
			}
		} );

		// Register cleanup function for this label
		this.cleanups.set( label, () => {
			label.removeEventListener( 'mouseenter', showTooltip );
			label.removeEventListener( 'mouseleave', hideTooltip );
			label.removeEventListener( 'focus', showTooltip );
			label.removeEventListener( 'blur', hideTooltip );
			label.removeEventListener( 'keydown', hideTooltip );
			label.removeEventListener( 'touchstart', () => {} );
			label.removeEventListener( 'touchend', toggleTooltip );
			label.removeEventListener( 'click', toggleTooltip );

			// Remove from active tooltips if present
			this.activeTooltips.delete( hideTooltip );
		} );
	};

	/**
	 * Initialize the tooltip for a product label.
	 *
	 * @param {HTMLElement} label - The label element to initialize the tooltip for
	 */
	initProductTooltip = ( label ) => {
		const row = label.closest( 'tr' );
		const tooltipContent = row ? row.querySelector( this.tooltipContentSelector ) : null;

		// Check if tooltip content is empty or not found
		if ( this.isTooltipEmpty( tooltipContent ) ) {
			// If no tooltip content, show default cursor
			label.style.cursor = 'default';

			// Return early to avoid adding icon and listeners
			return;
		}

		// Create a span element for the icon
		const iconSpan = this.createIcon();
		label.appendChild( iconSpan );

		// Store the original parent and next sibling of the tooltip content
		const originalParent = tooltipContent.parentElement;
		const originalNextSibling = tooltipContent.nextElementSibling;

		// Add keyboard accessibility
		label.setAttribute( 'tabindex', '0' );
		let tooltipId = tooltipContent.id;
		if ( ! tooltipId ) {
			tooltipId = `tooltip-${ label.getAttribute( 'for' ) || Math.random().toString( 36 ).substring( 2, 9 ) }`;
			tooltipContent.setAttribute( 'id', tooltipId );
		}

		tooltipContent.setAttribute( 'role', 'tooltip' );
		label.setAttribute( 'aria-describedby', tooltipId );

		this.addTooltipEventHandlers( label, tooltipContent, iconSpan, originalParent, originalNextSibling );
	};
}

/**
 * Initialize.
 */
customElements.define( 'novanta-product-tooltip', ProductTooltip );
