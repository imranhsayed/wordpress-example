/**
 * Removes all HTML tags from a given string and returns only the text content.
 *
 * @param {string} html - The HTML string to strip tags from.
 *
 * @return {string} The plain text content with all HTML tags removed.
 */
const stripHtml = ( html = '' ) => {
	// Parse the HTML string into a DOM document
	const doc = new DOMParser().parseFromString( html, 'text/html' );
	// Return the text content of the body, or empty string if not available
	return doc.body.textContent || '';
};

export default stripHtml;
