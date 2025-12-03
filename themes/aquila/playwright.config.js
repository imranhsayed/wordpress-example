const { defineConfig, devices } = require( '@playwright/test' );
const { defineBddConfig } = require( 'playwright-bdd' );
require( 'dotenv' ).config();

/**
 * Playwright configuration for E2E testing with BDD support.
 * @see https://playwright.dev/docs/test-configuration
 * @see https://vitalets.github.io/playwright-bdd/
 */

const testDir = defineBddConfig( {
	features: 'test/e2e/features/**/*.feature',
	steps: 'test/e2e/steps/**/*.js',
	outputDir: '.features-gen',
} );

module.exports = defineConfig( {
	testDir,

	// Maximum time one test can run for
	timeout: 30 * 1000,

	expect: {
		// Maximum time expect() should wait for the condition to be met
		timeout: 5000,
	},

	// Run tests in files in parallel
	fullyParallel: true,

	// Fail the build on CI if you accidentally left test.only in the source code
	forbidOnly: !! process.env.CI,

	// Retry on CI only
	retries: process.env.CI ? 2 : 0,

	// Opt out of parallel tests on CI
	workers: process.env.CI ? 1 : undefined,

	// Reporter to use
	reporter: [
		[ 'html', { outputFolder: 'playwright-report' } ],
		[ 'list' ],
	],

	// Shared settings for all the projects below
	use: {
		// Base URL to use in actions like `await page.goto('/')`
		baseURL: process.env.BASE_URL || 'https://wordpress-example.local',

		// Ignore HTTPS errors for Local by Flywheel self-signed certificates
		ignoreHTTPSErrors: true,

		// Collect trace when retrying the failed test
		trace: 'on-first-retry',

		// Take screenshot on failure
		screenshot: 'only-on-failure',

		// Record video on failure
		video: 'retain-on-failure',
	},

	// Configure projects for major browsers
	projects: [
		{
			name: 'chromium',
			use: { ...devices[ 'Desktop Chrome' ] },
		},
		{
			name: 'firefox',
			use: { ...devices[ 'Desktop Firefox' ] },
		},
		{
			name: 'webkit',
			use: { ...devices[ 'Desktop Safari' ] },
		},
		// Mobile viewports
		{
			name: 'Mobile Chrome',
			use: { ...devices[ 'Pixel 5' ] },
		},
		{
			name: 'Mobile Safari',
			use: { ...devices[ 'iPhone 12' ] },
		},
	],

	// Run your local dev server before starting the tests
	// Uncomment and configure if needed
	// webServer: {
	// 	command: 'npm run dev',
	// 	port: 8080,
	// 	reuseExistingServer: !process.env.CI,
	// },
} );
