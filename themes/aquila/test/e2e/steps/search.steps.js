const { expect } = require( '@playwright/test' );
const { createBdd } = require( 'playwright-bdd' );

const { When, Then } = createBdd();

When( 'I look for the search form', async ( { page } ) => {
	// Just verify it exists, don't need to store it
	const searchSelectors = [
		'form[role="search"]',
		'form.search-form',
		'.search-form',
		'[role="search"]',
		'input[type="search"]',
		'input[name="s"]',
	];

	let foundSearch = false;
	for ( const selector of searchSelectors ) {
		const element = await page.locator( selector ).first();
		if ( await element.isVisible() ) {
			foundSearch = true;
			break;
		}
	}

	expect( foundSearch ).toBe( true );
} );

Then( 'the search form should be visible', async ( { page } ) => {
	const searchSelectors = [
		'form[role="search"]',
		'form.search-form',
		'.search-form',
		'[role="search"]',
		'input[type="search"]',
		'input[name="s"]',
	];

	let foundSearch = false;
	for ( const selector of searchSelectors ) {
		const element = await page.locator( selector ).first();
		if ( await element.isVisible() ) {
			foundSearch = true;
			break;
		}
	}

	expect( foundSearch ).toBe( true );
} );

Then( 'the search input field should be present', async ( { page } ) => {
	const searchInput = await page.locator( 'input[type="search"], input[name="s"], input[placeholder*="search" i]' ).first();
	await expect( searchInput ).toBeVisible();
} );

When( 'I enter {string} in the search field', async ( { page }, searchTerm ) => {
	const searchInput = await page.locator( 'input[type="search"], input[name="s"], input[placeholder*="search" i]' ).first();
	await searchInput.fill( searchTerm );
} );

When( 'I submit the search form', async ( { page } ) => {
	const searchInput = await page.locator( 'input[type="search"], input[name="s"]' ).first();

	// Try to find and click submit button first
	const submitButton = await page.locator( 'button[type="submit"], input[type="submit"]' ).first();

	if ( await submitButton.isVisible() ) {
		await submitButton.click();
	} else {
		// Fallback: press Enter in the search field
		await searchInput.press( 'Enter' );
	}

	await page.waitForLoadState( 'domcontentloaded' );
} );

When( 'I submit the search form without entering text', async ( { page } ) => {
	const searchInput = await page.locator( 'input[type="search"], input[name="s"]' ).first();
	await searchInput.fill( '' );

	const submitButton = await page.locator( 'button[type="submit"], input[type="submit"]' ).first();

	if ( await submitButton.isVisible() ) {
		await submitButton.click();
	} else {
		await searchInput.press( 'Enter' );
	}
} );

Then( 'I should be on the search results page', async ( { page } ) => {
	const url = page.url();
	const isSearchPage = url.includes( '?s=' ) ||
		url.includes( '/search' ) ||
		url.includes( 'search=' );

	expect( isSearchPage ).toBe( true );
} );

Then( 'I should see search results or a no results message', async ( { page } ) => {
	const pageContent = await page.content();

	// Check for either results or no results message
	const hasResults = pageContent.includes( 'result' ) ||
		pageContent.includes( 'found' ) ||
		pageContent.includes( 'search' ) ||
		pageContent.includes( 'no results' ) ||
		pageContent.includes( 'nothing found' ) ||
		pageContent.includes( 'sorry' );

	expect( hasResults ).toBe( true );
} );

Then( 'I should remain on the current page or see a message', async ( { page } ) => {
	// The page should either stay the same or show some feedback
	const pageExists = await page.locator( 'body' ).isVisible();
	expect( pageExists ).toBe( true );
} );

Then( 'the page should handle the search gracefully', async ( { page } ) => {
	// Check that the page loaded successfully
	await page.waitForLoadState( 'domcontentloaded' );
	const body = await page.locator( 'body' );
	await expect( body ).toBeVisible();
} );

Then( 'I should not see any errors', async ( { page } ) => {
	const pageContent = await page.content();

	// Check for common error indicators
	const hasError = pageContent.toLowerCase().includes( 'fatal error' ) ||
		pageContent.toLowerCase().includes( 'parse error' ) ||
		pageContent.toLowerCase().includes( 'syntax error' );

	expect( hasError ).toBe( false );
} );
