# Playwright BDD E2E Testing Setup and Usage

This guide covers how to install, configure, and run end-to-end (E2E) tests using Playwright with Behavior-Driven Development (BDD) for the Aquila WordPress theme.

## Overview

Playwright is a modern E2E testing framework that supports multiple browsers (Chromium, Firefox, WebKit). Combined with `playwright-bdd`, it enables writing tests in Gherkin syntax (Given/When/Then) for better readability and collaboration.

## Prerequisites

- Node.js (v18 or higher)
- pnpm package manager
- Local by Flywheel (or similar local WordPress environment)
- WordPress site running at `https://wordpress-example.local`

## Installation

### 1. Install Dependencies

The required packages are already included in `package.json`. If you need to reinstall:

```bash
cd themes/aquila
pnpm install
```

### Key Testing Dependencies

- `@playwright/test`: Playwright testing framework
- `playwright-bdd`: BDD plugin for Playwright
- `dotenv`: Environment variable management

### 2. Install Playwright Browsers

Playwright requires browser binaries to be installed:

```bash
pnpm exec playwright install
```

This downloads Chromium, Firefox, WebKit, and their dependencies.

For Chromium only (faster):

```bash
pnpm playwright:install
```

## Configuration

### 1. Environment Variables

Create a `.env` file in the theme root:

```bash
# themes/aquila/.env
BASE_URL=https://wordpress-example.local
```

**Important:** Update the `BASE_URL` to match your local WordPress site URL.

### 2. Playwright Configuration

The configuration is in `playwright.config.js`:

```javascript
const { defineConfig, devices } = require('@playwright/test');
const { defineBddConfig } = require('playwright-bdd');
require('dotenv').config();

const testDir = defineBddConfig({
	features: 'test/e2e/features/**/*.feature',
	steps: 'test/e2e/steps/**/*.js',
	outputDir: '.features-gen',
});

module.exports = defineConfig({
	testDir,
	timeout: 30 * 1000,
	fullyParallel: true,
	retries: process.env.CI ? 2 : 0,
	workers: process.env.CI ? 1 : undefined,

	use: {
		baseURL: process.env.BASE_URL || 'https://wordpress-example.local',
		ignoreHTTPSErrors: true, // For Local by Flywheel self-signed certs
		trace: 'on-first-retry',
		screenshot: 'only-on-failure',
		video: 'retain-on-failure',
	},

	projects: [
		{ name: 'chromium', use: { ...devices['Desktop Chrome'] } },
		{ name: 'firefox', use: { ...devices['Desktop Firefox'] } },
		{ name: 'webkit', use: { ...devices['Desktop Safari'] } },
		{ name: 'Mobile Chrome', use: { ...devices['Pixel 5'] } },
		{ name: 'Mobile Safari', use: { ...devices['iPhone 12'] } },
	],
});
```

## Project Structure

```
themes/aquila/
├── test/
│   └── e2e/
│       ├── features/               # Gherkin feature files
│       │   ├── homepage.feature
│       │   └── search.feature
│       └── steps/                  # Step definitions
│           ├── common.steps.js     # Shared steps
│           ├── homepage.steps.js
│           └── search.steps.js
├── .features-gen/                  # Auto-generated test files
├── playwright.config.js            # Playwright configuration
├── .env                            # Environment variables
└── test-results/                   # Test results and artifacts
```

## Writing Tests

### 1. Feature Files (Gherkin Syntax)

Create feature files in `test/e2e/features/`:

```gherkin
# test/e2e/features/homepage.feature
Feature: Homepage Navigation
  As a website visitor
  I want to navigate the homepage
  So that I can access different sections of the website

  Background:
    Given I am on the homepage

  Scenario: View homepage title
    Then the page title should be visible
    And the page should have a valid title

  Scenario: Check main navigation exists
    Then I should see the main navigation menu
    And the navigation should contain links
```

### 2. Step Definitions

Create step implementations in `test/e2e/steps/`:

```javascript
// test/e2e/steps/homepage.steps.js
const { expect } = require('@playwright/test');
const { createBdd } = require('playwright-bdd');

const { Given, When, Then } = createBdd();

Then('the page title should be visible', async ({ page }) => {
	const title = await page.title();
	expect(title).toBeTruthy();
	expect(title.length).toBeGreaterThan(0);
});

Then('I should see the main navigation menu', async ({ page }) => {
	const nav = await page.locator('nav').first();
	await expect(nav).toBeVisible();
});
```

### 3. Common Steps

Reusable steps in `test/e2e/steps/common.steps.js`:

```javascript
const { createBdd } = require('playwright-bdd');
const { Given, When, Then } = createBdd();

Given('I am on the homepage', async ({ page }) => {
	await page.goto('/');
	await page.waitForLoadState('domcontentloaded');
});

When('I click on {string}', async ({ page }, text) => {
	await page.click(`text=${text}`);
});

Then('I should see {string}', async ({ page }, text) => {
	await expect(page.locator(`text=${text}`)).toBeVisible();
});
```

## Running Tests

### Run All Tests

```bash
# From theme directory
cd themes/aquila
pnpm test:e2e

# From root directory
cd /path/to/wp-content
pnpm test:e2e
```

### Run Tests with Browser UI Visible

```bash
pnpm test:e2e:headed
```

### Run Tests in UI Mode

Interactive mode with test explorer:

```bash
pnpm test:e2e:ui
```

### Run Tests in Debug Mode

```bash
pnpm test:e2e:debug
```

### Run Specific Tests

```bash
# Run tests matching a pattern
pnpm test:e2e --grep "homepage"

# Run a specific project (browser)
pnpm test:e2e --project=chromium

# Run a specific feature file
pnpm test:e2e homepage.feature
```

## Available Scripts

These scripts are defined in `package.json`:

| Script | Command | Description |
|--------|---------|-------------|
| `test:e2e` | `playwright test` | Run all E2E tests |
| `test:e2e:headed` | `playwright test --headed` | Run tests with visible browser |
| `test:e2e:ui` | `playwright test --ui` | Run tests in interactive UI mode |
| `test:e2e:debug` | `playwright test --debug` | Run tests in debug mode |
| `test:e2e:codegen` | `playwright codegen` | Generate tests by recording actions |
| `playwright:install` | `playwright install chromium` | Install Chromium browser only |

## Test Reports

After running tests, reports are available in:

- **HTML Report:** `playwright-report/index.html`
- **Test Results:** `test-results/` directory
- **Screenshots:** Captured on failure
- **Videos:** Recorded on failure

View the HTML report:

```bash
npx playwright show-report
```

## Writing Effective BDD Tests

### 1. Feature File Best Practices

```gherkin
Feature: Clear, concise feature name
  As a [user type]
  I want to [goal]
  So that [benefit]

  Background:
    Given [common setup for all scenarios]

  Scenario: Specific test case description
    Given [initial context]
    When [action]
    Then [expected outcome]
    And [additional verification]
```

### 2. Step Definition Best Practices

- **Reuse common steps** across multiple features
- **Use parameters** for flexibility: `When I enter {string} in the {string} field`
- **Keep steps atomic** - each step should do one thing
- **Use descriptive names** that match Gherkin naturally

### 3. Page Object Pattern

For complex pages, create page objects:

```javascript
// test/e2e/pages/HomePage.js
class HomePage {
	constructor(page) {
		this.page = page;
		this.navigation = page.locator('nav');
		this.searchInput = page.locator('input[name="s"]');
	}

	async goto() {
		await this.page.goto('/');
	}

	async search(term) {
		await this.searchInput.fill(term);
		await this.searchInput.press('Enter');
	}
}

module.exports = { HomePage };
```

## Common Playwright Actions

### Navigation

```javascript
await page.goto('/');
await page.goto('/about');
await page.goBack();
await page.reload();
```

### Locators

```javascript
// By text
page.locator('text=Sign in');

// By role (preferred for accessibility)
page.getByRole('button', { name: 'Submit' });

// By CSS selector
page.locator('.class-name');

// By test ID
page.getByTestId('submit-button');
```

### Interactions

```javascript
// Click
await page.click('button');

// Type
await page.fill('input[name="email"]', 'test@example.com');

// Select dropdown
await page.selectOption('select#country', 'USA');

// Check/uncheck
await page.check('input[type="checkbox"]');
```

### Assertions

```javascript
// Visibility
await expect(page.locator('nav')).toBeVisible();
await expect(page.locator('.error')).not.toBeVisible();

// Text content
await expect(page.locator('h1')).toHaveText('Welcome');
await expect(page.locator('p')).toContainText('Hello');

// Attributes
await expect(page.locator('button')).toHaveAttribute('disabled');
await expect(page.locator('a')).toHaveAttribute('href', '/about');

// Count
await expect(page.locator('li')).toHaveCount(5);

// URL
await expect(page).toHaveURL(/\/dashboard/);
```

## Debugging Tests

### 1. Using Debug Mode

```bash
pnpm test:e2e:debug
```

This opens Playwright Inspector for step-by-step debugging.

### 2. Using Console Logs

```javascript
console.log('Current URL:', page.url());
console.log('Page title:', await page.title());
```

### 3. Pause Execution

```javascript
await page.pause(); // Opens Playwright Inspector
```

### 4. Screenshots

```javascript
await page.screenshot({ path: 'screenshot.png' });
await page.screenshot({ path: 'full-page.png', fullPage: true });
```

## Troubleshooting

### Tests Can't Connect to Site

1. **Verify site is running:** Check Local by Flywheel
2. **Check BASE_URL:** Ensure `.env` has correct URL
3. **Test connectivity:**
   ```bash
   curl -k https://wordpress-example.local
   ```

### Browser Not Installed

```bash
pnpm exec playwright install
```

### SSL Certificate Errors

Add `ignoreHTTPSErrors: true` in `playwright.config.js` (already configured).

### Tests Timeout

1. Increase timeout in `playwright.config.js`:
   ```javascript
   timeout: 60 * 1000, // 60 seconds
   ```
2. Add explicit waits:
   ```javascript
   await page.waitForLoadState('networkidle');
   ```

### Element Not Found

1. **Wait for element:**
   ```javascript
   await page.waitForSelector('button', { state: 'visible' });
   ```
2. **Check selector:** Use Playwright Inspector to verify
3. **Add debug screenshot:**
   ```javascript
   await page.screenshot({ path: 'debug.png' });
   ```

## CI/CD Integration

### GitHub Actions Example

```yaml
name: E2E Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3

      - name: Setup Node
        uses: actions/setup-node@v3
        with:
          node-version: '18'

      - name: Install pnpm
        uses: pnpm/action-setup@v2
        with:
          version: 8

      - name: Install dependencies
        run: pnpm install

      - name: Install Playwright browsers
        run: pnpm exec playwright install --with-deps

      - name: Run E2E tests
        run: pnpm test:e2e
        env:
          BASE_URL: ${{ secrets.BASE_URL }}

      - name: Upload test results
        if: always()
        uses: actions/upload-artifact@v3
        with:
          name: playwright-report
          path: playwright-report/
```

## Test Generation with Codegen

Playwright can generate tests by recording your actions:

```bash
pnpm test:e2e:codegen
```

This opens a browser where you can:
1. Perform actions on your site
2. Playwright generates the code automatically
3. Copy the generated code to your step definitions

## Best Practices

### 1. Test Independence

Each test should be independent and not rely on other tests:

```gherkin
Scenario: Create and delete post
  Given I am logged in as admin
  When I create a new post
  And I delete the post
  Then the post should not exist
```

### 2. Use Data Tables

For testing multiple inputs:

```gherkin
Scenario Outline: Login with different credentials
  Given I am on the login page
  When I enter "<email>" and "<password>"
  Then I should see "<result>"

  Examples:
    | email          | password  | result          |
    | user@test.com  | correct   | Dashboard       |
    | user@test.com  | wrong     | Invalid login   |
```

### 3. Avoid Hardcoded Waits

Instead of:
```javascript
await page.waitForTimeout(5000); // Bad
```

Use:
```javascript
await page.waitForSelector('button'); // Good
await page.waitForLoadState('networkidle'); // Good
```

### 4. Clean Up Test Data

```javascript
// After each test
test.afterEach(async ({ page }) => {
	// Delete test data
	// Logout user
	// Clear cookies
});
```

## Additional Resources

- [Playwright Documentation](https://playwright.dev/)
- [Playwright BDD](https://vitalets.github.io/playwright-bdd/)
- [Gherkin Syntax](https://cucumber.io/docs/gherkin/)
- [Playwright Best Practices](https://playwright.dev/docs/best-practices)
- [Playwright Codegen](https://playwright.dev/docs/codegen)

## Next Steps

After setting up Playwright:

1. Write E2E tests for critical user flows
2. Run tests before deploying to production
3. Integrate tests into CI/CD pipeline
4. Set up test data management
5. Add visual regression testing with Playwright's screenshot comparison
6. Configure cross-browser testing strategy
7. Set up test reporting and monitoring
