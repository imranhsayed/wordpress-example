/**
 * Simple hello world function.
 */

/**
 * Returns a greeting message.
 *
 * @param {string} name - Name to greet.
 * @return {string} Greeting message.
 */
export function sayHello( name ) {
	if ( ! name ) {
		return 'Hello, World!';
	}
	return `Hello, ${ name }!`;
}
