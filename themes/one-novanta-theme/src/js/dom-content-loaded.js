/**
 * Dom Content Loaded handler.
 * Adds a class to <html> when the DOM has fully loaded.
 */
class DomContentLoaded {
	constructor() {
		// Add Event.
		window.addEventListener( 'DOMContentLoaded', () => this.addClassOnDomLoaded() );
	}

	addClassOnDomLoaded() {
		// We add this class, which is used to add smooth scroll styles, when DOM content is loaded.
		document.documentElement.classList.add( 'dom-content-loaded' );
	}
}

// Instantiate the class (no need to assign it to a variable)
new DomContentLoaded();
