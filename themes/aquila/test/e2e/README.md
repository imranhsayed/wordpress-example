# E2E Testing with Playwright-BDD

This directory contains end-to-end (E2E) tests using **playwright-bdd** for BDD/Gherkin support.

## Why playwright-bdd?

We migrated from `@cucumber/cucumber` to `playwright-bdd` for better integration:

✅ **Simpler setup** - No World class or hooks needed
✅ **Native Playwright** - Uses Playwright fixtures (`{ page }`)
✅ **Better debugging** - Playwright UI mode and inspector work perfectly
✅ **Auto-generation** - Converts `.feature` files to `.spec.js` automatically
✅ **Less code** - 80% reduction in boilerplate

## Directory Structure

```
test/e2e/
├── features/              # Gherkin feature files
│   ├── homepage.feature   # Homepage navigation tests
│   └── search.feature     # Search functionality tests
└── steps/                 # Step definitions
    ├── common.steps.js    # Reusable step definitions
    ├── homepage.steps.js  # Homepage-specific steps
    └── search.steps.js    # Search-specific steps
```

## Prerequisites

1. **Install Playwright browsers (first time only):**
   ```bash
   pnpm playwright:install
   ```

2. **Ensure WordPress is running:**
   ```bash
   # Set your WordPress URL
   export BASE_URL=http://localhost:10004
   ```

## Running Tests

### All Tests (BDD + Traditional)

```bash
# Run all E2E tests (headless)
pnpm test:e2e

# Run with visible browser
pnpm test:e2e:headed

# Interactive UI mode (best for debugging)
pnpm test:e2e:ui

# Debug mode with step-by-step execution
pnpm test:e2e:debug
```

### List All Tests

```bash
pnpm test:e2e --list
```

### Run Specific Tests

```bash
# Run specific feature
pnpm test:e2e test/e2e/features/homepage.feature.spec.js

# Run specific scenario by name
pnpm test:e2e --grep "View homepage title"

# Run specific browser
pnpm test:e2e --project=chromium
```

## Writing BDD Tests

### 1. Create Feature File

Create `test/e2e/features/login.feature`:

```gherkin
Feature: User Login
  As a user
  I want to log in
  So that I can access my account

  Background:
    Given I am on the homepage

  Scenario: Successful login
    When I navigate to "/wp-login.php"
    And I enter "testuser" in the "username" field
    And I enter "password" in the "password" field
    And I click on "Log In"
    Then I should see "Dashboard"
```

### 2. Create Step Definitions

Create `test/e2e/steps/login.steps.js`:

```javascript
const { expect } = require('@playwright/test');
const { createBdd } = require('playwright-bdd');

const { When, Then } = createBdd();

When('I enter {string} in the {string} field', async ({ page }, value, field) => {
  await page.fill(`#${field}`, value);
});

Then('I should see {string}', async ({ page }, text) => {
  await expect(page.locator(`text=${text}`)).toBeVisible();
});
```

### 3. Generate Test Specs

```bash
# Run this after adding/modifying feature files
pnpm exec bddgen
```

This creates test specs in `.features-gen/` directory (auto-gitignored).

### 4. Run Tests

```bash
pnpm test:e2e
```

## Key Differences from @cucumber/cucumber

### Before (@cucumber/cucumber)
```javascript
const { When } = require('@cucumber/cucumber');

// Needed World class, hooks, and manual browser management
When('I navigate to the homepage', async function () {
  await this.page.goto('/');  // Using this.page
});
```

### After (playwright-bdd)
```javascript
const { createBdd } = require('playwright-bdd');
const { When } = createBdd();

// No World, no hooks, clean fixtures
When('I navigate to the homepage', async ({ page }) => {
  await page.goto('/');  // Using { page } fixture
});
```

## Available Common Steps

The `common.steps.js` file provides reusable steps:

### Navigation
- `Given I am on the homepage`
- `Given I am on the "/about" page`
- `When I navigate to "/contact"`
- `When I click on "Button Text"`

### Form Interactions
- `When I enter "value" in the "fieldname" field`
- `When I submit the form`

### Assertions
- `Then I should see "text"`
- `Then I should not see "text"`
- `Then the element "selector" should be visible`
- `Then the current URL should be "/expected-path"`
- `Then the page title should contain "Expected Title"`

### Waits
- `When I wait for 2 seconds`
- `When I wait for the element ".loading" to be visible`

## Debugging

### Use Playwright UI Mode

```bash
pnpm test:e2e:ui
```

This opens an interactive UI where you can:
- See all tests
- Run tests step-by-step
- Time travel through test execution
- View screenshots and traces

### Use Playwright Inspector

```bash
pnpm test:e2e:debug
```

This opens the Playwright Inspector for step-by-step debugging.

### Generate Test Code

Record browser interactions to generate test code:

```bash
pnpm test:e2e:codegen http://localhost:10004
```

## Configuration

### Base URL

Set in one of these ways:

```bash
# Environment variable
export BASE_URL=http://localhost:10004
pnpm test:e2e

# Or inline
BASE_URL=http://example.com pnpm test:e2e
```

### Browser Selection

Run tests in specific browser:

```bash
# Chromium only
pnpm test:e2e --project=chromium

# Firefox only
pnpm test:e2e --project=firefox

# Mobile Chrome
pnpm test:e2e --project="Mobile Chrome"
```

## Reports

After tests run, view reports:

### HTML Report
```bash
npx playwright show-report
```

Opens `playwright-report/index.html` in browser.

### Screenshots on Failure

Screenshots are automatically captured on failure:
- Location: `test-results/` directory
- Attached to HTML report

## Best Practices

1. **Use Background for common setup** - Runs before each scenario
2. **Keep steps simple and reusable** - One action per step
3. **Use semantic selectors** - `text=`, `role=`, not CSS
4. **Leverage Playwright auto-waiting** - No manual waits needed
5. **Write descriptive scenarios** - Business language, not technical
6. **One scenario, one concept** - Test one thing per scenario

## Troubleshooting

### "Cannot find step definition"

1. Make sure step is defined in `test/e2e/steps/**/*.js`
2. Check the step text matches exactly
3. Regenerate specs: `pnpm exec bddgen`

### "Cannot connect to WordPress"

1. Ensure WordPress is running
2. Check BASE_URL is correct
3. Verify network connectivity

### "Timeout errors"

1. Increase timeout in `playwright.config.js`
2. Check if site is slow to load
3. Use `waitForSelector` for dynamic content

### Tests work in UI mode but fail headless

1. Some elements might not be immediately visible
2. Add explicit waits where needed
3. Check for animations/transitions

## CI/CD Integration

### GitHub Actions Example

```yaml
- name: Install dependencies
  run: pnpm install

- name: Install Playwright browsers
  run: pnpm playwright:install

- name: Run E2E tests
  run: pnpm test:e2e
  env:
    BASE_URL: ${{ secrets.SITE_URL }}

- name: Upload test reports
  if: always()
  uses: actions/upload-artifact@v3
  with:
    name: playwright-report
    path: playwright-report/
```

## Resources

- [playwright-bdd Documentation](https://vitalets.github.io/playwright-bdd/)
- [Playwright Documentation](https://playwright.dev/)
- [Gherkin Syntax Reference](https://cucumber.io/docs/gherkin/)
- [Playwright Best Practices](https://playwright.dev/docs/best-practices)

---

**Happy Testing! 🎭**
