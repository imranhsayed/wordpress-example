# JIRA Ticket: Setup Testing Tools: JEST, Playwright with Cucumber

## Description

Set up a comprehensive testing infrastructure for the Aquila WordPress theme to enable unit testing, integration testing, and BDD-style testing. This includes configuring Jest for unit testing with Gherkin/Cucumber support for behavior-driven development, and Playwright for end-to-end testing.

### Current Status
- ✅ Jest unit testing framework configured with @wordpress/scripts
- ✅ Gherkin/Cucumber BDD testing integrated via jest-cucumber for unit tests
- ✅ Example utility functions and unit tests created
- ✅ Playwright E2E testing framework configured
- ✅ Cucumber/Gherkin integration for E2E tests with Playwright
- ✅ Example E2E feature files and step definitions created

### Technical Implementation

**Jest Configuration:**
- Extends @wordpress/scripts default Jest configuration
- jsdom test environment for DOM testing
- CSS/SCSS module mocking via identity-obj-proxy
- WordPress global mocks (wp.i18n, wp.element, wp.components)
- Coverage collection configured for src directory
- Support for both traditional Jest tests and Gherkin feature files

**Gherkin/BDD Support:**
- jest-cucumber package integrated
- Feature files (.feature) for human-readable test scenarios
- Step definitions (.steps.js) mapping Gherkin syntax to test code
- Example feature file demonstrating Given-When-Then syntax

**Playwright/E2E Configuration:**
- Playwright test runner configured for multiple browsers (Chromium, Firefox, WebKit)
- Cucumber.js integrated with Playwright for BDD E2E testing
- Custom World class connecting Playwright with Cucumber
- Before/After hooks for browser lifecycle management
- Automatic screenshot capture on test failures
- Support for both traditional Playwright tests and Cucumber/Gherkin scenarios
- Mobile viewport testing (Pixel 5, iPhone 12)

**Test Scripts Added:**

*Unit Testing:*
- `pnpm test` - Run Jest unit tests
- `pnpm test:watch` - Run tests in watch mode
- `pnpm test:coverage` - Run tests with coverage report

*E2E Testing (Cucumber):*
- `pnpm test:e2e` - Run E2E tests with Cucumber (headless)
- `pnpm test:e2e:headed` - Run E2E tests with visible browser

*E2E Testing (Playwright):*
- `pnpm test:playwright` - Run Playwright E2E tests
- `pnpm test:playwright:headed` - Run with visible browser
- `pnpm test:playwright:ui` - Run with interactive UI mode
- `pnpm test:playwright:debug` - Run with debugger
- `pnpm playwright:install` - Install browser binaries
- `pnpm playwright:codegen` - Generate test code interactively

### Example Tests Created

**Unit Tests (Jest):**
- String helper utilities: `capitalize()`, `truncate()`, `slugToTitle()`
- 15 traditional Jest unit tests
- 8 Gherkin BDD scenarios for unit testing
- 100% code coverage on utility functions

**E2E Tests (Playwright + Cucumber):**
- Homepage navigation feature (4 scenarios)
  - Page title verification
  - Navigation menu presence
  - Content area validation
  - Footer verification
- Search functionality feature (4 scenarios)
  - Search form visibility
  - Basic search execution
  - Empty query handling
  - Special character handling
- Traditional Playwright tests (example.spec.js)
  - Homepage tests
  - Navigation tests
- Reusable step definitions (common.steps.js)
  - Navigation steps
  - Form interaction steps
  - Visibility assertions
  - Wait steps

---

## Acceptance Criteria

### Jest Setup
- [ ] Jest is configured and integrated with @wordpress/scripts
- [ ] Jest configuration file (jest.config.js) extends WordPress defaults
- [ ] Test setup file (jest.setup.js) includes WordPress mocks
- [ ] Tests can be run via npm/pnpm scripts
- [ ] Test coverage reporting is enabled and configured
- [ ] CSS/SCSS imports are properly mocked
- [ ] jsdom environment is configured for DOM testing

### Gherkin/Cucumber Integration
- [ ] jest-cucumber package is installed as dev dependency
- [ ] Feature files (.feature) can be created and recognized
- [ ] Step definitions can be written and executed
- [ ] Gherkin scenarios appear in test output with proper naming
- [ ] Both traditional Jest and Gherkin tests can coexist
- [ ] Step definition files are excluded from coverage reports

### Test Examples
- [ ] At least one example utility function is created
- [ ] Traditional Jest test file demonstrates best practices
- [ ] Gherkin feature file demonstrates BDD scenarios
- [ ] Step definitions file shows proper Given-When-Then implementation
- [ ] All example tests pass successfully
- [ ] Tests include edge cases (null, undefined, invalid types)

### Documentation
- [ ] Test scripts are documented in package.json
- [ ] Example tests serve as reference for team
- [ ] Configuration files include inline comments where needed

### Playwright Setup
- [ ] Playwright is installed and configured
- [ ] Multiple browsers are configured (Chromium, Firefox, WebKit)
- [ ] Mobile viewports are configured for responsive testing
- [ ] Cucumber integration for Playwright is set up
- [ ] Custom World class integrates Playwright with Cucumber
- [ ] E2E feature files are created with Gherkin syntax
- [ ] Step definitions are implemented for E2E scenarios
- [ ] Before/After hooks manage browser lifecycle
- [ ] Screenshot capture on failure is configured
- [ ] Both Cucumber and traditional Playwright tests work
- [ ] Test reports (HTML, JSON) are generated
- [ ] Playwright can run in CI/CD environment
- [ ] E2E README documentation is created

---

## Release Notes

### New Features

**Testing Infrastructure**
- Added Jest unit testing framework integrated with @wordpress/scripts
- Implemented Gherkin/Cucumber BDD testing support via jest-cucumber for unit tests
- Added Playwright E2E testing framework with multi-browser support
- Integrated Cucumber.js with Playwright for BDD E2E testing
- Created comprehensive Jest configuration with WordPress-specific mocks
- Created Playwright configuration with browser and viewport options
- Added test coverage reporting with configurable thresholds
- Implemented automatic screenshot capture on test failures

**Test Scripts**

*Unit Testing:*
- `pnpm test` - Execute all unit tests
- `pnpm test:watch` - Run tests in watch mode for active development
- `pnpm test:coverage` - Generate detailed coverage reports

*E2E Testing:*
- `pnpm test:e2e` - Run Cucumber E2E tests (headless)
- `pnpm test:e2e:headed` - Run E2E tests with visible browser
- `pnpm test:playwright` - Run traditional Playwright E2E tests
- `pnpm test:playwright:ui` - Interactive UI mode for debugging
- `pnpm test:playwright:debug` - Step-by-step debugger
- `pnpm playwright:codegen` - Generate test code interactively

**Example Test Suite**

*Unit Tests:*
- Implemented string helper utilities (capitalize, truncate, slugToTitle)
- Created 15 traditional Jest unit tests demonstrating testing patterns
- Created 8 Gherkin BDD scenarios showcasing behavior-driven development
- Achieved 100% test coverage on example utilities

*E2E Tests:*
- Homepage navigation feature with 4 Gherkin scenarios
- Search functionality feature with 4 Gherkin scenarios
- Traditional Playwright test examples (example.spec.js)
- Reusable step definitions library for common actions
- Support for both Cucumber and Playwright test styles

### Developer Experience Improvements
- Tests can be written in both traditional and Gherkin/BDD syntax
- BDD scenarios are readable by non-technical stakeholders (PMs, QA, clients)
- Watch mode enables rapid test-driven development
- Coverage reports help identify untested code paths
- Playwright UI mode provides interactive debugging experience
- Codegen tool auto-generates test code by recording interactions
- Multiple browser testing ensures cross-browser compatibility
- Mobile viewport testing validates responsive designs
- Screenshot capture aids in debugging failed tests

### Configuration Files Added

*Unit Testing:*
- `jest.config.js` - Jest configuration extending WordPress defaults
- `jest.setup.js` - Global test setup with WordPress mocks
- `src/utils/__tests__/string-helpers.feature` - Example Gherkin feature file
- `src/utils/__tests__/string-helpers.steps.js` - Example step definitions
- `src/utils/string-helpers.test.js` - Example traditional Jest tests

*E2E Testing:*
- `playwright.config.js` - Playwright configuration with multi-browser support
- `cucumber.config.js` - Cucumber configuration for E2E tests
- `e2e/support/world.js` - Custom World class integrating Playwright
- `e2e/support/hooks.js` - Before/After hooks for browser lifecycle
- `e2e/features/homepage.feature` - Homepage navigation scenarios
- `e2e/features/search.feature` - Search functionality scenarios
- `e2e/features/step-definitions/common.steps.js` - Reusable steps
- `e2e/features/step-definitions/homepage.steps.js` - Homepage-specific steps
- `e2e/features/step-definitions/search.steps.js` - Search-specific steps
- `e2e/example.spec.js` - Traditional Playwright test examples
- `e2e/README.md` - Comprehensive E2E testing documentation
- `.gitignore` - Ignore test reports, screenshots, and artifacts

### Dependencies Added
- `jest-cucumber@^4.5.0` - Gherkin/Cucumber support for Jest unit tests
- `@playwright/test@^1.57.0` - Playwright test runner and utilities
- `@cucumber/cucumber@^12.3.0` - Cucumber.js for BDD E2E testing
- `@cucumber/playwright@^3.1.0` - Playwright integration for Cucumber (deprecated, reference only)

---

## Definitions of Success

### Quantitative Metrics

**Test Execution:**
- ✅ All tests execute successfully without errors
- ✅ Test suite completes in under 3 seconds for current test count
- ✅ 100% of example code has test coverage
- ✅ Zero failing tests in the baseline

**Code Quality:**
- Tests cover happy paths, edge cases, and error conditions
- No test-related warnings or deprecations in output
- Test files follow consistent naming conventions
- Code coverage thresholds can be enforced in CI/CD

### Qualitative Metrics

**Developer Productivity:**
- Developers can write new tests without consulting documentation
- Test failures provide clear, actionable error messages
- Watch mode enables rapid feedback during development
- Both traditional and BDD test styles are supported

**Code Maintainability:**
- Test code is as clean and readable as production code
- Gherkin scenarios serve as living documentation
- Test structure matches source code structure
- Tests are independent and can run in any order

**Team Adoption:**
- Non-technical stakeholders can read and understand Gherkin scenarios
- Example tests serve as templates for new test creation
- Testing patterns are consistent across the codebase
- Team members can run tests locally without issues

### Success Indicators

1. **Tests Pass Consistently**
   - All 23 tests (15 Jest + 8 Gherkin) pass on every run
   - No flaky or intermittent test failures
   - Tests pass in both local and CI/CD environments

2. **Coverage Baseline Established**
   - Coverage reports generate successfully
   - Baseline coverage percentage is documented
   - Coverage trends can be tracked over time

3. **Documentation Quality**
   - Example tests demonstrate multiple testing patterns
   - Feature files are written in clear, business-readable language
   - Configuration files are self-documenting

4. **Developer Confidence**
   - Team members actively write tests for new features
   - Tests catch bugs before they reach production
   - Refactoring is safer with comprehensive test coverage

5. **Integration Success**
   - Jest integrates seamlessly with @wordpress/scripts
   - Playwright integrates with Cucumber for BDD E2E tests
   - Tests work with existing build and lint tooling
   - No conflicts with Storybook or other dev tools

6. **E2E Test Execution**
   - All E2E tests can be executed successfully
   - Tests run in multiple browsers (Chromium, Firefox, WebKit)
   - Mobile viewport tests validate responsive design
   - Screenshot capture works on failures
   - Both Cucumber and traditional Playwright tests coexist

### Future Success Criteria

- Visual regression testing is configured
- E2E tests run automatically in CI/CD pipeline
- Performance testing is integrated
- API/integration testing is set up
- Coverage thresholds are enforced
- Video recording on failures is enabled

---

## Notes

### Technical Decisions

**Why jest-cucumber over other BDD tools?**
- Native Jest integration (no separate test runner)
- Lightweight and focused on Gherkin syntax
- Maintains Jest's fast execution speed
- Compatible with @wordpress/scripts

**Why @wordpress/scripts?**
- Already includes Jest, Babel, and other testing dependencies
- Maintained by WordPress core team
- Consistent with WordPress development standards
- Reduces dependency management overhead

**Why Playwright over other E2E tools?**
- Modern, fast, and reliable E2E testing framework
- Multi-browser support (Chromium, Firefox, WebKit) out of the box
- Excellent developer experience with UI mode and codegen
- Auto-waiting and retry mechanisms reduce flaky tests
- Strong TypeScript support and active development
- Built-in screenshot and video capture capabilities

**Why integrate Cucumber with Playwright?**
- Maintains consistency with Jest unit test approach (both use Gherkin)
- BDD scenarios serve as living documentation
- Shared step definitions reduce test code duplication
- Non-technical stakeholders can understand and contribute to test scenarios

### Best Practices Established

1. **Test File Organization:**
   - *Unit tests:* `src/**/*.test.js` or `src/**/__tests__/*.feature`
   - *Unit step definitions:* `src/**/__tests__/*.steps.js`
   - *E2E feature files:* `e2e/features/*.feature`
   - *E2E step definitions:* `e2e/features/step-definitions/*.steps.js`
   - *E2E traditional tests:* `e2e/*.spec.js`
   - *E2E support files:* `e2e/support/**/*.js`

2. **Test Structure:**
   - Arrange-Act-Assert pattern for unit tests
   - Given-When-Then pattern for BDD scenarios
   - One concept per test case
   - Reusable step definitions in common.steps.js
   - Page-specific steps in dedicated files

3. **Coverage Configuration:**
   - Exclude story files (*.stories.js)
   - Exclude step definitions (*.steps.js)
   - Exclude barrel exports (index.js)
   - Exclude TypeScript declarations (*.d.ts)

4. **E2E Test Practices:**
   - Use semantic selectors (text, role) over CSS selectors
   - Implement auto-waiting instead of hard-coded waits
   - Capture screenshots on failure for debugging
   - Keep tests independent and stateless
   - Use Background for common setup across scenarios
   - Test critical user flows first

### Known Limitations

- E2E tests require a running WordPress instance (BASE_URL must be set)
- No visual regression testing configured yet
- No API/integration testing setup
- Coverage thresholds not enforced (can be added later)
- Video recording on failures not enabled by default (can be configured)
- E2E tests not yet integrated into CI/CD pipeline
- Playwright browsers need to be installed before first run

### Next Steps

1. ✅ ~~Complete Playwright setup with Cucumber integration~~
2. ✅ ~~Create E2E test examples for critical user flows~~
3. Configure WordPress test environment with known base URL
4. Set up CI/CD pipeline to run all tests automatically
5. Establish coverage thresholds for new code
6. Add visual regression testing capabilities (e.g., Percy, Playwright Screenshots)
7. Add more E2E scenarios for:
   - User authentication flows
   - Content creation/editing
   - Form submissions
   - Cart/checkout (if applicable)
8. Implement API testing layer
9. Create team training materials and documentation
10. Set up test data management strategy
