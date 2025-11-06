/**
 * Debounce.
 *
 * @param {Function} callback Callback function.
 * @param {number}   wait     Time to wait before re-calling the callback function.
 *
 * @return {Function} Debounced function.
 */
const debounce = ( callback, wait ) => {
	let timeoutId = null;
	return ( ...args ) => {
		window.clearTimeout( timeoutId );
		timeoutId = window.setTimeout( () => {
			callback( ...args );
		}, wait );
	};
};

/**
 * Key specific debounce.
 * Use when you want to create multiple debounce functions separated by keys from a single debounce function.
 *
 * @param {Function} callback Callback function.
 * @param {number}   wait     Time to wait before re-calling the callback function.
 *
 * @return {Function} Debounced function.
 */
const keySpecificDebounce = ( callback, wait ) => {
	const timers = {};

	return function( key, ...args ) {
		clearTimeout( timers[ key ] );

		timers[ key ] = setTimeout( () => {
			callback.apply( this, [ key, ...args ] );
			delete timers[ key ];
		}, wait );
	};
};

export { debounce, keySpecificDebounce };
