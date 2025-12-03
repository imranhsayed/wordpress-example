const { expect } = require( '@playwright/test' );
const { createBdd } = require( 'playwright-bdd' );

const { Then } = createBdd();

Then( 'the page title should be visible', async ( { page } ) => {
	const title = await page.title();
	expect( title ).toBeTruthy();
	expect( title.length ).toBeGreaterThan( 0 );
} );

Then( 'the page should have a valid title', async ( { page } ) => {
	const title = await page.title();
	expect( title ).not.toBe( '' );
	expect( title ).not.toContain( 'undefined' );
	expect( title ).not.toContain( 'null' );
} );

Then( 'I should see the main navigation menu', async ( { page } ) => {
	// Try multiple common navigation selectors
	const navSelectors = [
		'nav',
		'[role="navigation"]',
		'.navigation',
		'.menu',
		'#menu',
		'header nav',
	];

	let foundNav = false;
	for ( const selector of navSelectors ) {
		const nav = await page.locator( selector ).first();
		if ( await nav.isVisible() ) {
			foundNav = true;
			break;
		}
	}

	expect( foundNav ).toBe( true );
} );

Then( 'the navigation should contain links', async ( { page } ) => {
	const nav = await page.locator( 'nav, [role="navigation"]' ).first();
	const links = await nav.locator( 'a' ).count();
	expect( links ).toBeGreaterThan( 0 );
} );

Then( 'I should see the main content area', async ( { page } ) => {
	const contentSelectors = [
		'main',
		'[role="main"]',
		'#content',
		'.content',
		'article',
	];

	let foundContent = false;
	for ( const selector of contentSelectors ) {
		const content = await page.locator( selector ).first();
		if ( await content.isVisible() ) {
			foundContent = true;
			break;
		}
	}

	expect( foundContent ).toBe( true );
} );

Then( 'the content should not be empty', async ( { page } ) => {
	const main = await page.locator( 'main, [role="main"], #content' ).first();
	const text = await main.textContent();
	expect( text.trim().length ).toBeGreaterThan( 0 );
} );

Then( 'I should see the footer section', async ( { page } ) => {
	const footerSelectors = [
		'footer',
		'[role="contentinfo"]',
		'.footer',
		'#footer',
	];

	let foundFooter = false;
	for ( const selector of footerSelectors ) {
		const footer = await page.locator( selector ).first();
		if ( await footer.isVisible() ) {
			foundFooter = true;
			break;
		}
	}

	expect( foundFooter ).toBe( true );
} );

Then( 'the footer should contain copyright information', async ( { page } ) => {
	const footer = await page.locator( 'footer, [role="contentinfo"]' ).first();
	const footerText = await footer.textContent();

	// Look for common copyright indicators
	const hasCopyright = footerText.includes( '©' ) ||
		footerText.toLowerCase().includes( 'copyright' ) ||
		footerText.match( /\d{4}/ ); // Year

	expect( hasCopyright ).toBe( true );
} );
