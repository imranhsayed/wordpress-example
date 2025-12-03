/**
 * Tests for Hello Aquila Component
 */
import React from 'react';
import { render, screen } from '@testing-library/react';
import HelloAquila from './index';

describe( 'HelloAquila Component', () => {
	it( 'renders Hello Aquila text', () => {
		render( <HelloAquila /> );

		expect( screen.getByText( 'Hello Aquila' ) ).toBeInTheDocument();
	} );

	it( 'renders with correct class name', () => {
		const { container } = render( <HelloAquila /> );

		expect( container.querySelector( '.hello-aquila' ) ).toBeInTheDocument();
	} );

	it( 'renders as an h1 heading', () => {
		render( <HelloAquila /> );

		const heading = screen.getByRole( 'heading', { level: 1 } );
		expect( heading ).toHaveTextContent( 'Hello Aquila' );
	} );
} );
