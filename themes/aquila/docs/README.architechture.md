### Reason for adding pnpm.peerDependencyRules
- Added pnpm.peerDependencyRules in the root package.json (/wp-content/package.json:21-28) to tell pnpm that React 18 is an allowed version for packages that
expect older React versions. This is because some wordpress packages like @wordpress/block-editor support react versions older than v18. Without this you will see
harmless, but annoying warnings like unmet peer react@"^0.14.0 || ^15.0.0 || ^16.0.0": found 18.3.1.

### Reason for adding allowedDeprecatedVersions
- Added allowedDeprecatedVersions configuration in /wp-content/package.json:28-35 to suppress unavoidable deprecation warnings:
Why These Warnings Were Unavoidable:

1. ESLint 8.57.1 - WordPress ecosystem isn't ready for ESLint 9 yet
2. 5 subdependencies(added to allowedDeprecatedVersions) - These are internal ESLint 8 dependencies that will be replaced when ESLint 9 becomes the standard
