/**
 * WordPress helper functions.
 */

/**
 * Get post excerpt with custom length.
 *
 * @param {string} content - Post content.
 * @param {number} length  - Maximum length (default: 55 words).
 * @return {string} Excerpt.
 */
export function getExcerpt( content, length = 55 ) {
	if ( ! content || typeof content !== 'string' ) {
		return '';
	}

	const words = content.split( ' ' );
	if ( words.length <= length ) {
		return content;
	}

	return words.slice( 0, length ).join( ' ' ) + '...';
}

/**
 * Check if user is logged in.
 *
 * @return {boolean} True if user is logged in.
 */
export function isUserLoggedIn() {
	return !! window.wp?.currentUser?.id;
}

/**
 * Get site title.
 *
 * @return {string} Site title.
 */
export function getSiteTitle() {
	return window.wp?.siteTitle || '';
}
