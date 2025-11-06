/**
 * Decodes HTML entities in a given string.
 *
 * @param {string} str - The HTML-encoded string to decode.
 *
 * @return {string} - The decoded string with HTML entities converted to their corresponding characters.
 */
const decodeHtmlEntities = ( str ) => {
	// Create a temporary textarea element
	const txt = document.createElement( 'textarea' );

	// Assign the HTML-encoded string to its innerHTML
	txt.innerHTML = str;

	// The browser decodes the HTML and assigns it to the textarea's value
	return txt.value;
};

export default decodeHtmlEntities;
