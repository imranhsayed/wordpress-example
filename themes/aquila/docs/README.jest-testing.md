# Jest Unit Testing Setup and Usage

This guide covers how to install, configure, and run Jest unit tests for the Aquila WordPress theme.

## Overview

Jest is a JavaScript testing framework that provides unit testing capabilities for React components and JavaScript utilities. This setup uses `@wordpress/scripts` which includes Jest pre-configured for WordPress development.

## Prerequisites

- Node.js (v18 or higher)
- pnpm package manager
- The Aquila theme installed and set up

## Installation

### 1. Install Dependencies

The required packages are already included in the `package.json`. If you need to reinstall them:

```bash
cd themes/aquila
pnpm install
```

### Key Testing Dependencies

- `@wordpress/scripts`: Provides wp-scripts test-unit-js command with Jest pre-configured
- `@testing-library/react`: Testing utilities for React components
- `@testing-library/jest-dom`: Custom Jest matchers for DOM testing
- `jest`: JavaScript testing framework (included with @wordpress/scripts)

### 2. Jest Configuration

The Jest configuration is located in `jest.config.js`:

```javascript
module.exports = {
	preset: '@wordpress/jest-preset-default',
	testEnvironment: 'jsdom',
	setupFilesAfterEnv: ['<rootDir>/jest.setup.js'],
	moduleNameMapper: {
		'\\.(css|less|scss|sass)$': 'identity-obj-proxy',
		'\\.(jpg|jpeg|png|gif|svg)$': '<rootDir>/__mocks__/fileMock.js',
	},
	testMatch: [
		'**/__tests__/**/*.[jt]s?(x)',
		'**/?(*.)+(spec|test).[jt]s?(x)',
	],
	collectCoverageFrom: [
		'src/**/*.{js,jsx}',
		'!src/**/*.stories.{js,jsx}',
		'!src/**/index.js',
	],
};
```

### 3. Jest Setup File

The `jest.setup.js` file configures the testing environment:

```javascript
import '@testing-library/jest-dom';
```

This imports custom matchers like `toBeInTheDocument()`, `toHaveClass()`, etc.

## Project Structure

```
themes/aquila/
├── src/
│   ├── components/
│   │   └── hello-aquila/
│   │       ├── index.js
│   │       └── index.test.js          # Component tests
│   └── utils/
│       └── hello.js
├── test/
│   └── unit/
│       └── hello.test.js               # Utility tests
├── jest.config.js                      # Jest configuration
└── jest.setup.js                       # Jest setup file
```

## Writing Tests

### Basic Test Example

```javascript
// src/utils/hello.test.js
import { greet } from './hello';

describe('greet', () => {
	it('should return greeting message', () => {
		expect(greet('World')).toBe('Hello, World!');
	});
});
```

### React Component Test Example

```javascript
// src/components/hello-aquila/index.test.js
import { render, screen } from '@testing-library/react';
import HelloAquila from './index';

describe('HelloAquila Component', () => {
	it('should render component', () => {
		render(<HelloAquila />);
		expect(screen.getByText('Hello Aquila')).toBeInTheDocument();
	});
});
```

## Running Tests

### Run All Tests

```bash
# From theme directory
cd themes/aquila
pnpm test

# From root directory
cd /path/to/wp-content
pnpm test
```

### Run Tests in Watch Mode

Watch mode reruns tests when files change:

```bash
pnpm test:watch
```

### Run Tests with Coverage

Generate a coverage report:

```bash
pnpm test:coverage
```

Coverage reports are generated in the `coverage/` directory. Open `coverage/lcov-report/index.html` in a browser to view detailed coverage.

## Available Scripts

These scripts are defined in `package.json`:

| Script | Command | Description |
|--------|---------|-------------|
| `test` | `wp-scripts test-unit-js` | Run all unit tests |
| `test:watch` | `wp-scripts test-unit-js --watch` | Run tests in watch mode |
| `test:coverage` | `wp-scripts test-unit-js --coverage` | Run tests with coverage report |

## Testing Best Practices

### 1. Test File Naming

- Place component tests next to components: `component.test.js`
- Place utility tests in `test/unit/`: `test/unit/utility.test.js`
- Use descriptive test names that explain what is being tested

### 2. Test Structure

Use the AAA pattern (Arrange, Act, Assert):

```javascript
describe('Component or Function', () => {
	it('should do something specific', () => {
		// Arrange: Set up test data
		const input = 'test';

		// Act: Execute the function/render component
		const result = myFunction(input);

		// Assert: Verify the result
		expect(result).toBe('expected');
	});
});
```

### 3. Testing React Components

```javascript
import { render, screen, fireEvent } from '@testing-library/react';

describe('MyComponent', () => {
	it('should handle user interaction', () => {
		render(<MyComponent />);

		const button = screen.getByRole('button');
		fireEvent.click(button);

		expect(screen.getByText('Clicked')).toBeInTheDocument();
	});
});
```

### 4. Mocking

Mock external dependencies:

```javascript
// Mock a module
jest.mock('./api', () => ({
	fetchData: jest.fn(() => Promise.resolve({ data: 'test' })),
}));

// Mock WordPress functions
global.wp = {
	i18n: {
		__: (text) => text,
	},
};
```

## Common Jest Matchers

```javascript
// Equality
expect(value).toBe(expected);           // Strict equality (===)
expect(value).toEqual(expected);        // Deep equality

// Truthiness
expect(value).toBeTruthy();
expect(value).toBeFalsy();
expect(value).toBeNull();
expect(value).toBeDefined();

// Numbers
expect(value).toBeGreaterThan(3);
expect(value).toBeLessThan(5);

// Strings
expect(string).toMatch(/pattern/);
expect(string).toContain('substring');

// Arrays
expect(array).toContain(item);
expect(array).toHaveLength(3);

// Objects
expect(obj).toHaveProperty('key', 'value');

// Functions
expect(fn).toHaveBeenCalled();
expect(fn).toHaveBeenCalledWith(arg1, arg2);
```

## Common Testing Library Queries

```javascript
// Get by text content
screen.getByText('Hello');

// Get by role (preferred for accessibility)
screen.getByRole('button', { name: /submit/i });

// Get by test ID
screen.getByTestId('custom-element');

// Get by label text (for forms)
screen.getByLabelText('Email');

// Query variants
screen.queryByText('Text');    // Returns null if not found
screen.findByText('Text');     // Async, waits for element
```

## Troubleshooting

### Test Fails with Module Import Errors

If you see errors like `Cannot find module` for CSS or image imports:

1. Verify `moduleNameMapper` in `jest.config.js` is configured
2. Check that `identity-obj-proxy` is installed

### React Component Tests Fail

1. Ensure `jest.setup.js` imports `@testing-library/jest-dom`
2. Verify `testEnvironment` is set to `'jsdom'` in `jest.config.js`
3. Check that `@testing-library/react` is installed

### Tests Pass Locally but Fail in CI

1. Ensure all dependencies are installed in CI environment
2. Check Node.js version matches between local and CI
3. Verify `pnpm` is being used (not npm/yarn)

## CI/CD Integration

To run tests in GitHub Actions:

```yaml
- name: Install dependencies
  run: pnpm install

- name: Run unit tests
  run: pnpm test

- name: Run tests with coverage
  run: pnpm test:coverage
```

## Additional Resources

- [Jest Documentation](https://jestjs.io/)
- [React Testing Library](https://testing-library.com/react)
- [@wordpress/scripts Testing](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#test-unit-js)
- [Jest DOM Matchers](https://github.com/testing-library/jest-dom)

## Next Steps

After setting up Jest:

1. Write tests for all new components and utilities
2. Aim for >80% code coverage
3. Run tests before committing code
4. Set up pre-commit hooks to run tests automatically
5. Integrate tests into your CI/CD pipeline
