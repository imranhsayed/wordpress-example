const defaultConfig = require( '@wordpress/scripts/config/jest-unit.config.js' );

module.exports = {
	...defaultConfig,
	testEnvironment: 'jsdom',
	testMatch: [
		'<rootDir>/test/unit/**/__tests__/**/*.[jt]s?(x)',
		'<rootDir>/test/unit/**/?(*.)+(spec|test|steps).[jt]s?(x)',
		'<rootDir>/src/**/?(*.)+(spec|test).[jt]s?(x)',
	],
	testPathIgnorePatterns: [
		'/node_modules/',
		'/build/',
		'/test/e2e/', // Exclude Playwright E2E tests
		'/.features-gen/', // Exclude generated Playwright specs
	],
	moduleNameMapper: {
		'\\.(css|less|scss|sass)$': 'identity-obj-proxy',
	},
	setupFilesAfterEnv: [ '<rootDir>/jest.setup.js' ],
	collectCoverageFrom: [
		'src/**/*.{js,jsx,ts,tsx}',
		'!src/**/*.stories.{js,jsx,ts,tsx}',
		'!src/**/*.steps.{js,jsx,ts,tsx}',
		'!src/**/index.{js,ts}',
		'!src/**/*.d.ts',
	],
};
