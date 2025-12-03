# Testing Quick Start Guide

Complete testing setup for the Aquila WordPress theme with Jest, Playwright, and Cucumber/Gherkin.

## Table of Contents
1. [Installation](#installation)
2. [Unit Testing (Jest)](#unit-testing-jest)
3. [E2E Testing (Playwright + Cucumber)](#e2e-testing-playwright--cucumber)
4. [File Structure](#file-structure)
5. [Quick Commands](#quick-commands)

---

## Installation

### First Time Setup

```bash
# Install dependencies
pnpm install

# Install Playwright browsers (required for E2E tests)
pnpm playwright:install
```

---

## Unit Testing (Jest)

### Running Unit Tests

```bash
# Run all unit tests
pnpm test

# Run tests in watch mode (re-runs on file changes)
pnpm test:watch

# Run tests with coverage report
pnpm test:coverage
```

### Writing Unit Tests

**Traditional Jest Test:**
```javascript
// test/unit/utils/example.test.js
import { myFunction } from '../../../src/utils/example';

describe('myFunction', () => {
  it('should return expected value', () => {
    expect(myFunction('input')).toBe('expected');
  });
});
```

**Gherkin/BDD Test:**

1. Create feature file: `test/unit/utils/__tests__/example.feature`
```gherkin
Feature: Example functionality
  Scenario: Basic usage
    Given I have input "test"
    When I process the input
    Then the result should be "TEST"
```

2. Create step definitions: `test/unit/utils/__tests__/example.steps.js`
```javascript
import { loadFeature, defineFeature } from 'jest-cucumber';
import { processInput } from '../../../../src/utils/example';

const feature = loadFeature('./test/unit/utils/__tests__/example.feature');

defineFeature(feature, (test) => {
  let input, result;

  test('Basic usage', ({ given, when, then }) => {
    given('I have input "test"', () => {
      input = 'test';
    });

    when('I process the input', () => {
      result = processInput(input);
    });

    then('the result should be "TEST"', () => {
      expect(result).toBe('TEST');
    });
  });
});
```

---

## E2E Testing (Playwright-BDD)

### Prerequisites

1. **Ensure WordPress is running:**
   ```bash
   # Your WordPress site should be accessible
   # Default: http://localhost:8080
   ```

2. **Set BASE_URL (if different from default):**
   ```bash
   export BASE_URL=http://localhost:10004
   ```

3. **Install Playwright browsers (first time only):**
   ```bash
   pnpm playwright:install
   ```

### Running E2E Tests

```bash
# Run all E2E tests (headless)
pnpm test:e2e

# Run with visible browser
pnpm test:e2e:headed

# Interactive UI mode (best for debugging)
pnpm test:e2e:ui

# Debug mode with step-by-step execution
pnpm test:e2e:debug

# With custom BASE_URL
BASE_URL=http://example.local pnpm test:e2e
```

### Writing E2E Tests

**Step 1: Create feature file** - `test/e2e/features/login.feature`
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

**Step 2: Create step definitions** - `test/e2e/steps/login.steps.js`
```javascript
const { expect } = require('@playwright/test');
const { createBdd } = require('playwright-bdd');

const { When, Then } = createBdd();

When('I enter {string} in the {string} field', async ({ page }, value, field) => {
  await page.fill(`#${field}`, value);
});
```

**Step 3: Generate test specs**
```bash
pnpm exec bddgen
```

**Step 4: Run tests**
```bash
pnpm test:e2e
```

**Traditional Playwright Style (Optional):**

Create test file: `test/e2e/login.spec.js`
```javascript
const { test, expect } = require('@playwright/test');

test('user can log in', async ({ page }) => {
  await page.goto('/wp-login.php');
  await page.fill('#user_login', 'testuser');
  await page.fill('#user_pass', 'password');
  await page.click('#wp-submit');

  await expect(page.locator('text=Dashboard')).toBeVisible();
});
```

### Using Playwright Codegen

Generate test code by recording your actions:
```bash
pnpm test:e2e:codegen http://localhost:8080
```

This opens a browser where you can:
1. Perform actions (click, type, navigate)
2. See generated test code in real-time
3. Copy the code to your test files

---

## File Structure

This project follows **WordPress Gutenberg testing standards**:
- Unit tests in `test/unit/` (separate from source code)
- E2E tests in `test/e2e/`
- Test files mirror the source file structure

Reference: [WordPress Block Editor Testing Overview](https://developer.wordpress.org/block-editor/contributors/code/testing-overview/)

```
themes/aquila/
├── src/
│   └── utils/
│       └── string-helpers.js          # Utility functions
├── test/                              # All tests directory
│   ├── unit/                          # Unit tests (Jest)
│   │   └── utils/
│   │       ├── string-helpers.test.js     # Traditional Jest tests
│   │       └── __tests__/
│   │           ├── string-helpers.feature # Gherkin scenarios
│   │           └── string-helpers.steps.js # Step definitions
│   └── e2e/                           # E2E tests (playwright-bdd)
│       ├── features/                  # Gherkin feature files
│       │   ├── homepage.feature       # Homepage scenarios
│       │   └── search.feature         # Search scenarios
│       ├── steps/                     # Step definitions
│       │   ├── common.steps.js        # Reusable steps
│       │   ├── homepage.steps.js      # Homepage steps
│       │   └── search.steps.js        # Search steps
│       └── README.md                  # E2E documentation
├── .features-gen/                     # Auto-generated (gitignored)
├── jest.config.js                     # Jest configuration
├── jest.setup.js                      # Jest setup file
├── playwright.config.js               # Playwright configuration
└── package.json                       # Test scripts
```

---

## Quick Commands

### Unit Tests
| Command | Description |
|---------|-------------|
| `pnpm test` | Run all unit tests |
| `pnpm test:watch` | Watch mode (re-run on changes) |
| `pnpm test:coverage` | Generate coverage report |

### E2E Tests (playwright-bdd)
| Command | Description |
|---------|-------------|
| `pnpm test:e2e` | Run all E2E tests (headless) |
| `pnpm test:e2e:headed` | Run with visible browser |
| `pnpm test:e2e:ui` | Interactive UI mode |
| `pnpm test:e2e:debug` | Debug mode |
| `pnpm test:e2e:codegen` | Generate test code |
| `pnpm playwright:install` | Install browser binaries |
| `pnpm exec bddgen` | Generate specs from features |

---

## Common Patterns

### Reusable Cucumber Steps (Already Available)

The `common.steps.js` file provides these steps:

**Navigation:**
- `Given I am on the homepage`
- `Given I am on the "/about" page`
- `When I navigate to "/contact"`
- `When I click on "Button Text"`

**Form Interactions:**
- `When I enter "value" in the "fieldname" field`
- `When I submit the form`

**Assertions:**
- `Then I should see "text"`
- `Then I should not see "text"`
- `Then the element "selector" should be visible`
- `Then the current URL should be "/expected-path"`
- `Then the page title should contain "Expected Title"`

**Waits:**
- `When I wait for 2 seconds`
- `When I wait for the element ".loading" to be visible`

### Example: Complete Feature

```gherkin
Feature: Contact Form
  Background:
    Given I am on the "/contact" page

  Scenario: Submit contact form
    When I enter "John Doe" in the "name" field
    And I enter "john@example.com" in the "email" field
    And I enter "Hello World" in the "message" field
    And I submit the form
    Then I should see "Thank you"
    And the current URL should be "/contact?sent=true"
```

---

## Debugging Tips

### Unit Tests
```bash
# Run specific test file
pnpm test -- test/unit/utils/string-helpers.test.js

# Run tests matching pattern
pnpm test --testNamePattern="capitalize"

# Update snapshots
pnpm test -u
```

### E2E Tests
```bash
# Run specific feature
pnpm test:e2e -- test/e2e/features/homepage.feature

# Run specific scenario
pnpm test:e2e -- --grep "View homepage title"

# Slow down execution for debugging
SLOW_MO=1000 pnpm test:e2e:headed

# Use Playwright inspector
pnpm test:e2e:debug
```

### View Test Reports

**Unit Tests:**
- Coverage report: `coverage/lcov-report/index.html`

**E2E Tests:**
- Cucumber HTML report: `cucumber-report.html`
- Playwright HTML report: `playwright-report/index.html`
- Screenshots on failure: `screenshots/`

---

## Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `BASE_URL` | `http://localhost:8080` | WordPress site URL |
| `HEADLESS` | `true` | Run browser in headless mode |
| `SLOW_MO` | `0` | Slow down operations (ms) |
| `CI` | `false` | CI environment flag |

**Example:**
```bash
BASE_URL=http://example.local HEADLESS=false SLOW_MO=500 pnpm test:e2e
```

---

## Troubleshooting

### "No tests found"
- Check test file names match patterns: `*.test.js`, `*.spec.js`, `*.steps.js`
- Ensure feature files are in correct directory

### "Playwright browsers not installed"
```bash
pnpm playwright:install
```

### "Cannot connect to WordPress"
- Ensure WordPress is running
- Check BASE_URL is correct
- Verify network connectivity

### "Timeout errors"
- Increase timeout in config files
- Check if site is slow to load
- Use `waitForSelector` for dynamic content

### "Tests pass locally but fail in CI"
- Set appropriate BASE_URL for CI environment
- Install Playwright browsers in CI
- Check for timing issues (add waits if needed)

---

## Next Steps

1. **Write your first test:**
   - Start with a simple unit test
   - Add Gherkin scenarios for better readability

2. **Expand E2E coverage:**
   - Test critical user flows
   - Add authentication tests
   - Test form submissions

3. **Integrate with CI/CD:**
   - Add test runs to GitHub Actions / GitLab CI
   - Generate and publish test reports
   - Set up automated deployment on passing tests

4. **Monitor test health:**
   - Track test execution time
   - Identify and fix flaky tests
   - Maintain high coverage

---

## Resources

- [Jest Documentation](https://jestjs.io/)
- [Playwright Documentation](https://playwright.dev/)
- [Cucumber.js Documentation](https://cucumber.io/docs/cucumber/)
- [jest-cucumber](https://github.com/bencompton/jest-cucumber)
- [E2E Testing Guide](./test/e2e/README.md)
- [JIRA Ticket Details](./JIRA-TICKET.md)

---

**Happy Testing! 🧪**
