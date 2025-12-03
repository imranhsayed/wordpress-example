/**
 * Simple Hello World test.
 */
import { sayHello } from '../../src/utils/hello';

describe( 'Hello World', () => {
	it( 'says hello to the world', () => {
		expect( sayHello() ).toBe( 'Hello, World!' );
	} );

	it( 'says hello to a person', () => {
		expect( sayHello( 'John' ) ).toBe( 'Hello, John!' );
	} );
} );
