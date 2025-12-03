const { expect } = require( '@playwright/test' );
const { createBdd } = require( 'playwright-bdd' );

const { Given, When, Then } = createBdd();

/**
 * Common navigation steps
 */
Given( 'I am on the homepage', async ( { page } ) => {
	await page.goto( '/' );
	await page.waitForLoadState( 'domcontentloaded' );
} );

Given( 'I am on the {string} page', async ( { page }, pagePath ) => {
	await page.goto( pagePath );
	await page.waitForLoadState( 'domcontentloaded' );
} );

When( 'I navigate to {string}', async ( { page }, url ) => {
	await page.goto( url );
	await page.waitForLoadState( 'domcontentloaded' );
} );

When( 'I click on {string}', async ( { page }, text ) => {
	await page.click( `text=${ text }` );
} );

When( 'I click the element with selector {string}', async ( { page }, selector ) => {
	await page.click( selector );
} );

/**
 * Form interaction steps
 */
When( 'I enter {string} in the {string} field', async ( { page }, value, fieldName ) => {
	const field = await page.locator( `input[name="${ fieldName }"], input[placeholder*="${ fieldName }"], textarea[name="${ fieldName }"]` ).first();
	await field.fill( value );
} );

When( 'I submit the form', async ( { page } ) => {
	await page.locator( 'button[type="submit"], input[type="submit"]' ).first().click();
} );

/**
 * Visibility and content assertions
 */
Then( 'I should see {string}', async ( { page }, text ) => {
	await expect( page.locator( `text=${ text }` ) ).toBeVisible();
} );

Then( 'I should not see {string}', async ( { page }, text ) => {
	await expect( page.locator( `text=${ text }` ) ).not.toBeVisible();
} );

Then( 'the element {string} should be visible', async ( { page }, selector ) => {
	await expect( page.locator( selector ) ).toBeVisible();
} );

Then( 'the element {string} should not be visible', async ( { page }, selector ) => {
	await expect( page.locator( selector ) ).not.toBeVisible();
} );

Then( 'the page should contain {string}', async ( { page }, text ) => {
	const content = await page.content();
	expect( content ).toContain( text );
} );

Then( 'the current URL should be {string}', async ( { page }, expectedUrl ) => {
	const currentUrl = page.url();
	expect( currentUrl ).toContain( expectedUrl );
} );

Then( 'the page title should contain {string}', async ( { page }, expectedTitle ) => {
	const title = await page.title();
	expect( title ).toContain( expectedTitle );
} );

/**
 * Wait steps
 */
When( 'I wait for {int} seconds', async ( { page }, seconds ) => {
	await page.waitForTimeout( seconds * 1000 );
} );

When( 'I wait for the element {string} to be visible', async ( { page }, selector ) => {
	await page.waitForSelector( selector, { state: 'visible' } );
} );
