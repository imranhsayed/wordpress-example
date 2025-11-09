### Reason for adding pnpm.peerDependencyRules
- Added pnpm.peerDependencyRules in the root package.json (/wp-content/package.json:21-28) to tell pnpm that React 18 is an allowed version for packages that
expect older React versions. This is because some wordpress packages like @wordpress/block-editor support react versions older than v18. Without this you will see
harmless, but annoying warnings like unmet peer react@"^0.14.0 || ^15.0.0 || ^16.0.0": found 18.3.1.

### Reason for adding allowedDeprecatedVersions
- Added allowedDeprecatedVersions configuration in /wp-content/package.json:28-35 to suppress unavoidable deprecation warnings:
Why These Warnings Were Unavoidable:

1. ESLint 8.57.1 - WordPress ecosystem isn't ready for ESLint 9 yet
2. 5 subdependencies(added to allowedDeprecatedVersions) - These are internal ESLint 8 dependencies that will be replaced when ESLint 9 becomes the standard

### Reason for creating inlineCrossReferences plugin
Problem: The accordion component's built JS file (build/components/accordion/index.js) was only 0.12 kB and contained an ES module import inside an IIFE:
import"../../blocks/accordion/view.js", which doesn't work in browsers. This prevented the accordion from working in the Component Viewer admin preview.

Root Cause: When both the accordion component and accordion block imported the same web components library (@rtcamp/web-components/build/accordion), Vite
optimized the build by creating a shared chunk and having entries cross-reference each other instead of bundling the code twice.

Solution: The custom Vite plugin (inlineCrossReferences()) that:
1. Runs before the wrapInIIFE plugin in the generateBundle hook
2. Detects cross-references between entries (import statements in entry chunks)
3. Inlines the referenced module's code directly into the entry that imports it
4. Each entry becomes self-contained and can load independently

## Reason for keeping the component directory structure the way it is:

We use Component Co-location (Most Popular) pattern for each component directory. 
It keeps styles, logic, and templates together:
e.g.
components/tile-carousel/
├── index.js
├── index.scss
├── index.php

Used by:
- React ecosystem (Next.js, Gatsby, Create React App)
- Vue.js (Single File Components)
- Angular (component architecture)
- Modern WordPress themes with build tools
- Design systems (Shopify Polaris, Adobe Spectrum, Material UI)

Why it's popular:
- Easy to find all related files
- Easy to delete/move components
- Clear dependencies
- Better for teams and maintainability

For WordPress Specifically

Block Themes & Modern WordPress:
- Component co-location (what we're doing)
- Entry file imports styles: import './style.scss'
- Build tools (Vite, Webpack, Parcel)

Examples:
- @wordpress/scripts (official tooling) - uses Webpack with this exact pattern
- Modern WordPress starter themes (Sage, Timber) - component co-location
- WordPress.org block library - each block has index.js importing its styles
