/**
 * Component: Loading Indicator
 * Spinner toggle logic for elements with `.loading-indicator-component`.
 * 
 * Usage:
 *   showLoader('.loading-indicator-component');
 *   hideLoader('.loading-indicator-component');
 */

import './index.scss';

(() => {
	/**
	 * Show a loader by removing `is-hidden` class
	 * @param {string} selector - CSS selector for the loader
	 */
	function showLoader(selector) {
		const el = document.querySelector(selector);
		if (el) el.classList.remove('is-hidden');
	}

	/**
	 * Hide a loader by adding `is-hidden` class
	 * @param {string} selector - CSS selector for the loader
	 */
	function hideLoader(selector) {
		const el = document.querySelector(selector);
		if (el) el.classList.add('is-hidden');
	}

	// Expose globally
	window.showLoader = showLoader;
	window.hideLoader = hideLoader;

	// Optional: Auto-hide any loaders with `data-auto-hide="true"` after 2s
	document.querySelectorAll('.loading-indicator-component[data-auto-hide="true"]').forEach((loader) => {
		setTimeout(() => loader.classList.add('is-hidden'), 2000);
	});
})();
