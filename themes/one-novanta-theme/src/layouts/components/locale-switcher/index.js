/**
 * Global variables.
 */
const { customElements, HTMLElement } = window;

/**
 * Locale Switcher Class.
 */
class LocaleSwitcher extends HTMLElement {
	/**
	 * Constructor.
	 */
	constructor() {
		// Initialize parent.
		super();

		document.addEventListener( 'DOMContentLoaded', () => {
			// Elements.
			const localeButton = this.querySelector( '.locale-switcher__button' );
			const localeOptions = this.querySelectorAll( '.locale-switcher__dropdown-button' );

			// Events.
			if ( localeButton ) {
				localeButton.addEventListener( 'click', this.switcherButtonClicked.bind( this ) );
			}

			if ( this.ownerDocument.defaultView ) {
				this.ownerDocument.defaultView.addEventListener( 'click', this.handleSwitcherClose.bind( this ) );
			}

			if ( localeOptions ) {
				localeOptions.forEach( ( localeOption ) => {
					localeOption.addEventListener( 'click', this.localeOptionButtonClicked.bind( this ) );
				} );
			}
		} );
	}

	/**
	 * Event: Locale button clicked.
	 *
	 * @param {Event} event Event object.
	 */
	localeOptionButtonClicked( event ) {
		// Get target element.
		const targetElement = event.currentTarget;

		// Get the URL.
		const url = targetElement?.getAttribute( 'data-url' );

		// Switch to the URL.
		if ( url ) {
			window.location.href = url;
		}
	}

	/**
	 * Event: Button clicked.
	 */
	switcherButtonClicked() {
		// Check if the element is disabled.
		if ( 'true' === this.dataset.disabled ) {
			return;
		}

		// Toggle the attribute.
		this.toggleAttribute( 'active' );
	}

	/**
	 * Close the menu dropdown.
	 *
	 * @param {Event} event Event object.
	 */
	handleSwitcherClose( event ) {
		// Element.
		const targetElement = event.target;

		// Check if inside target element.
		if ( targetElement.closest( '.locale-switcher' ) ) {
			// Return if inside the element.
			return;
		}

		// Remove the attribute.
		this.removeAttribute( 'active' );
	}
}

/**
 * Initialize.
 */
customElements.define( 'one-novanta-theme-locale-switcher', LocaleSwitcher );
