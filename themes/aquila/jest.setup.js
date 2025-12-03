// Add custom matchers or global test setup here
// This file runs before each test file

// Import jest-dom matchers
import '@testing-library/jest-dom';

// Mock WordPress dependencies if needed
global.wp = {
	i18n: {
		__: ( text ) => text,
		_x: ( text ) => text,
		_n: ( single, plural, number ) => ( number === 1 ? single : plural ),
	},
	element: require( '@wordpress/element' ),
	components: require( '@wordpress/components' ),
};
