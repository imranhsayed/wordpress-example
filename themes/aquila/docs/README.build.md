# Build System Documentation

This theme uses `@wordpress/scripts` with a custom webpack configuration to handle the build process for blocks, components, and styles.

## Table of Contents

- [Overview](#overview)
- [Build Structure](#build-structure)
- [How It Works](#how-it-works)
- [Entry Point Discovery](#entry-point-discovery)
- [Custom Webpack Configuration](#custom-webpack-configuration)
- [Custom Webpack Plugins](#custom-webpack-plugins)
- [Available Scripts](#available-scripts)
- [TypeScript Support](#typescript-support)
- [Adding New Blocks or Components](#adding-new-blocks-or-components)
- [Troubleshooting](#troubleshooting)

## Overview

The build system is based on `@wordpress/scripts`, the official WordPress package for building blocks and themes. We extend the default configuration with a custom `webpack.config.js` to maintain our specific project structure and requirements.

### Key Features

- **Automatic Entry Discovery**: Automatically finds and builds all blocks and components
- **WordPress Integration**: Handles WordPress dependencies and generates `.asset.php` files
- **TypeScript Support**: Full TypeScript support for non-block files
- **RTL Support**: Automatically generates right-to-left CSS for internationalization
- **SVG as Components**: Import SVG files as React components
- **SCSS Support**: Built-in SCSS/Sass compilation
- **Custom Directory Structure**: Maintains organized `blocks/`, `components/`, and `css/` folders

Here's what @wordpress/scripts provides out of the box:

Babel (built-in):
- @babel/preset-env with WordPress browser support
- @babel/preset-react with automatic runtime
- @babel/plugin-transform-runtime
- All necessary WordPress-specific transforms

PostCSS (built-in):
- Autoprefixer
- PostCSS preset-env
- RTL CSS generation

## Build Structure

The build process outputs files to the `build/` directory with the following structure:

```
build/
├── blocks/                    # Gutenberg blocks
│   ├── accordion/
│   │   ├── accordion-item/    # Nested block
│   │   │   ├── index.js       # Block JavaScript
│   │   │   ├── style.css      # Block styles (LTR)
│   │   │   ├── style-rtl.css  # Block styles (RTL)
│   │   │   ├── index.asset.php # WordPress dependencies
│   │   │   ├── block.json     # Block metadata
│   │   │   ├── render.php     # Server-side render
│   │   │   └── translations.php
│   │   ├── index.js
│   │   ├── style.css
│   │   ├── style-rtl.css
│   │   ├── view.js            # Frontend script
│   │   └── ...
│   ├── tile-carousel/
│   ├── notice/
│   └── ...
├── components/                # Reusable components
│   ├── accordion/
│   │   ├── index.js
│   │   ├── index.css
│   │   ├── index-rtl.css
│   │   └── index.php          # PHP component
│   ├── button/
│   ├── cards/
│   └── ...
├── css/                       # Global styles
│   ├── main.css
│   ├── main-rtl.css
│   └── main.asset.php
├── index.js                   # Theme entry point
└── index.css
```

## How It Works

### 1. Base Configuration

The build extends `@wordpress/scripts` default webpack configuration:

```javascript
// webpack.config.js
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
  // Custom configurations override defaults
};
```

### 2. Entry Point Discovery

Instead of manually defining entry points, the build system automatically scans the `src/` directory to discover:

- All blocks in `src/blocks/` (including nested blocks)
- All components in `src/components/`
- All SCSS files in `src/scss/`
- The main entry point at `src/index.js`

This is handled by the `getEntries()` function in `webpack.config.js`.

### 3. Custom Output Structure

The webpack configuration uses custom output settings to maintain our directory structure:

```javascript
output: {
  path: path.resolve(__dirname, 'build'),
  filename: '[name].js',
  clean: true,
}
```

The `[name]` placeholder is replaced with the entry key, so:
- Entry: `blocks/accordion/index` → Output: `build/blocks/accordion/index.js`
- Entry: `components/button/index` → Output: `build/components/button/index.js`
- Entry: `css/main` → Output: `build/css/main.css`

### 4. Asset Processing

During the build:
1. **JavaScript/TypeScript** files are transpiled and bundled
2. **SCSS/CSS** files are compiled and extracted
3. **PHP files** are copied from `src/` to `build/`
4. **block.json** files are copied to their respective block directories
5. **`.asset.php`** files are auto-generated with WordPress dependencies

## Entry Point Discovery

The `getEntries()` function in `webpack.config.js` automatically discovers entry points:

### Components (`src/components/`)

```javascript
// Scans: src/components/{component-name}/index.{js,jsx,ts,tsx}
// Creates entry: components/{component-name}/index
// Outputs to: build/components/{component-name}/index.js
```

**Example:**
```
src/components/button/index.js → build/components/button/index.js
src/components/cards/index.tsx → build/components/cards/index.js
```

### Blocks (`src/blocks/`)

```javascript
// Scans: src/blocks/{block-name}/index.{js,jsx,ts,tsx}
// Creates entry: blocks/{block-name}/index
// Outputs to: build/blocks/{block-name}/index.js

// Also scans for view scripts: src/blocks/{block-name}/view.{js,jsx,ts,tsx}
// Creates entry: blocks/{block-name}/view
// Outputs to: build/blocks/{block-name}/view.js
```

**Supports nested blocks:**
```
src/blocks/accordion/accordion-item/index.js
  → build/blocks/accordion/accordion-item/index.js
```

**Supports view scripts (frontend):**
```
src/blocks/accordion/view.js → build/blocks/accordion/view.js
```

### SCSS Files (`src/scss/`)

```javascript
// Scans: src/scss/{name}.scss (non-partials, not starting with _)
// Creates JS wrapper: src/js/{name}.js (auto-generated)
// Creates entry: css/{name}
// Outputs to: build/css/{name}.css
```

**Example:**
```
src/scss/main.scss → build/css/main.css
src/scss/_variables.scss → (ignored, is a partial)
```

### Global Entry

```javascript
// Entry: src/index.js
// Output: build/index.js
```

## Custom Webpack Configuration

### Extending @wordpress/scripts

The `webpack.config.js` file extends the default configuration from `@wordpress/scripts`:

```javascript
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,

  // 1. Custom entry points
  entry: getEntries(),

  // 2. Custom output configuration
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: '[name].js',
    clean: true,
  },

  // 3. Disable code splitting
  optimization: {
    ...defaultConfig.optimization,
    splitChunks: false,
  },

  // 4. Custom plugins
  plugins: [ ... ],

  // 5. Path aliases
  resolve: {
    ...defaultConfig.resolve,
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },

  // 6. Custom module rules
  module: { ... },
};
```

### Key Customizations

#### 1. Entry Points

The `getEntries()` function dynamically discovers all entry points:

```javascript
function getEntries() {
  const entries = {};

  // Scan components directory
  // Scan blocks directory recursively
  // Scan SCSS files
  // Add global entry

  return entries;
}
```

This returns an object like:
```javascript
{
  'blocks/accordion/index': '/path/to/src/blocks/accordion/index.js',
  'blocks/accordion/view': '/path/to/src/blocks/accordion/view.js',
  'blocks/accordion/accordion-item/index': '/path/to/src/blocks/accordion/accordion-item/index.js',
  'components/button/index': '/path/to/src/components/button/index.js',
  'css/main': '/path/to/src/js/main.js',
  'index': '/path/to/src/index.js',
}
```

#### 2. Output Configuration

```javascript
output: {
  path: path.resolve(__dirname, 'build'),
  filename: '[name].js',
  clean: true,
}
```

- `path`: All files output to `build/` directory
- `filename`: Uses entry name (e.g., `blocks/accordion/index.js`)
- `clean`: Cleans `build/` directory before each build

#### 3. Code Splitting

```javascript
optimization: {
  splitChunks: false,
}
```

Code splitting is disabled to prevent shared chunks. This ensures each block/component is self-contained, which simplifies WordPress dependency management and prevents issues with missing dependencies.

#### 4. SVG Handling

```javascript
module: {
  rules: [
    {
      test: /\.svg$/,
      issuer: /\.(js|jsx|ts|tsx)$/,
      use: ['@svgr/webpack'],
    },
  ],
}
```

SVG files can be imported as React components:
```javascript
import ArrowIcon from '@/svg/arrow-right.svg';
<ArrowIcon />
```

#### 5. Path Aliases

```javascript
resolve: {
  alias: {
    '@': path.resolve(__dirname, './src'),
  },
}
```

Use `@` for cleaner imports:
```javascript
import Button from '@/components/button';
```

## Custom Webpack Plugins

### 1. CopyPhpFilesPlugin

**Purpose:** Copies all PHP files from `src/` to `build/` maintaining directory structure.

**How it works:**
- Runs after webpack emits files (`afterEmit` hook)
- Recursively scans `src/` directory
- Copies every `.php` file to corresponding location in `build/`

**Example:**
```
src/blocks/accordion/render.php → build/blocks/accordion/render.php
src/components/button/index.php → build/components/button/index.php
```

**Code location:** `webpack.config.js` lines 127-162

### 2. BlockAssetsPlugin

**Purpose:** Handles block-specific files that aren't processed by webpack.

**How it works:**
- Runs after webpack emits files
- Scans for directories containing `block.json`
- Copies `block.json` to build directory
- Copies `render.php` if it exists
- Verifies `.asset.php` was generated

**Example:**
```
src/blocks/notice/block.json → build/blocks/notice/block.json
src/blocks/notice/render.php → build/blocks/notice/render.php
```

**Code location:** `webpack.config.js` lines 167-225

### 3. CleanupScssEntriesPlugin

**Purpose:** Removes unnecessary JavaScript files created from SCSS-only entries.

**How it works:**
- Runs after webpack emits files
- Checks `build/css/` directory
- Deletes any `.js` files (SCSS entries only need `.css` output)

**Example:**
```
build/css/main.js → deleted (not needed)
build/css/main.css → kept
```

**Code location:** `webpack.config.js` lines 214-238

### 4. RenameBlockCssPlugin

**Purpose:** Renames block CSS files from `index.css` to `style.css` to match WordPress conventions.

**How it works:**
- Uses webpack's `processAssets` hook (runs before files are written to disk)
- Manipulates webpack's in-memory asset compilation
- Renames only files in `blocks/` directory
- Preserves RTL files (`index-rtl.css` → `style-rtl.css`)

**Why this is needed:**
Webpack names CSS files based on the entry point name. Since block entries are named `blocks/accordion/index`, the CSS would be `index.css`. However, WordPress convention (and `block.json` files) expect `style.css`.

**Example:**
```
Webpack would output:    blocks/accordion/index.css
Plugin renames to:       blocks/accordion/style.css

Webpack would output:    blocks/accordion/index-rtl.css
Plugin renames to:       blocks/accordion/style-rtl.css
```

**Performance:**
- Runs in-memory before disk write (very fast, <1ms)
- No filesystem I/O overhead
- Watch-mode friendly

**Code location:** `webpack.config.js` lines 240-285

### 5. DependencyExtractionWebpackPlugin

**Purpose:** Automatically generates `.asset.php` files with WordPress dependencies.

**How it works:**
- Built into `@wordpress/scripts`
- Analyzes import statements
- Detects WordPress packages (`@wordpress/*`, `react`, etc.)
- Generates `.asset.php` with dependency list and version hash

**Example output:**
```php
<?php return array(
  'dependencies' => array('wp-blocks', 'wp-element', 'wp-i18n'),
  'version' => '06a4adfe8d014719cc3c'
);
```

**Configuration:**
```javascript
new DependencyExtractionWebpackPlugin({
  outputFormat: 'php',
  combineAssets: false,
})
```

## Available Scripts

### Development

```bash
pnpm run dev
```

Starts webpack in watch mode with live rebuild on file changes.

**Features:**
- Fast incremental builds
- Source maps for debugging
- Watches `src/` directory for changes

### Production Build

```bash
pnpm run build
```

Creates optimized production build.

**Optimizations:**
- JavaScript minification
- CSS minification
- Asset optimization
- Content-based versioning

### Type Checking

```bash
pnpm run type-check
```

Runs TypeScript type checking without emitting files. Useful for checking types without building.

### Linting

```bash
# JavaScript linting
pnpm run lint

# Fix JavaScript issues automatically
pnpm run lint:fix

# CSS/SCSS linting
pnpm run lint:css

# Fix CSS issues automatically
pnpm run lint:css:fix
```

Uses WordPress coding standards via `@wordpress/scripts`.

### Formatting

```bash
pnpm run format
```

Formats code using WordPress coding standards (Prettier with WordPress config).

## TypeScript Support

TypeScript is fully supported and configured for the project.

### What's Supported

- ✅ Components in `src/components/**/*.{ts,tsx}`
- ✅ Block components in `src/block-components/**/*.{ts,tsx}`
- ✅ Utilities and helpers
- ❌ Block entry files in `src/blocks/**/*` (kept as JavaScript)

### Configuration

TypeScript settings are in `tsconfig.json`:

```json
{
  "compilerOptions": {
    "jsx": "react-jsx",
    "target": "ES2020",
    "module": "ESNext",
    "strict": true,
    "paths": {
      "@/*": ["./src/*"]
    }
  },
  "exclude": [
    "node_modules",
    "build",
    "src/blocks/**/*"
  ]
}
```

### Using TypeScript

Create `.tsx` or `.ts` files:

```typescript
// src/components/button/index.tsx
interface ButtonProps {
  variant: 'primary' | 'secondary';
  onClick: () => void;
  children: React.ReactNode;
}

export const Button: React.FC<ButtonProps> = ({ variant, onClick, children }) => {
  return (
    <button className={`btn btn--${variant}`} onClick={onClick}>
      {children}
    </button>
  );
};
```

Webpack automatically handles TypeScript compilation.

## Adding New Blocks or Components

### Adding a New Block

**1. Create block directory:**
```bash
mkdir -p src/blocks/my-block
```

**2. Create required files:**
```
src/blocks/my-block/
├── index.js           # Block registration
├── edit.jsx          # Editor component
├── save.jsx          # Save function
├── block.json        # Block metadata
├── style.scss        # Public styles
├── editor.scss       # Editor-only styles
└── render.php        # Server-side render (optional)
```

**3. Register the block:**
```javascript
// src/blocks/my-block/index.js
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

registerBlockType(metadata.name, {
  edit: Edit,
  save: Save,
});
```

**4. Build:**
```bash
pnpm run build
```

**Output:**
```
build/blocks/my-block/
├── index.js
├── index.css
├── index-rtl.css
├── index.asset.php
├── block.json
└── render.php
```

The block is automatically discovered and built!

### Adding a New Component

**1. Create component directory:**
```bash
mkdir -p src/components/my-component
```

**2. Create component files:**
```
src/components/my-component/
├── index.js          # Component logic
├── style.scss        # Component styles
└── index.php         # PHP render function (optional)
```

**3. Build:**
```bash
pnpm run build
```

**Output:**
```
build/components/my-component/
├── index.js
├── index.css
├── index-rtl.css
└── index.php
```

### Adding Frontend Scripts (view.js)

For blocks that need frontend interactivity:

**1. Create view.js:**
```javascript
// src/blocks/accordion/view.js
import domReady from '@wordpress/dom-ready';

domReady(() => {
  const accordions = document.querySelectorAll('.accordion');
  // Add your frontend logic here
});
```

**2. Build automatically detects it:**
```
build/blocks/accordion/view.js
build/blocks/accordion/view.asset.php
```

**3. Enqueue in PHP:**
```php
wp_enqueue_script(
  'accordion-view-script',
  get_template_directory_uri() . '/build/blocks/accordion/view.js',
  // Dependencies from view.asset.php
);
```

## Build Process Flow

Here's what happens when you run `pnpm run build`:

```
1. Entry Discovery
   └─> getEntries() scans src/ directory
       └─> Returns object with all entry points

2. Webpack Processing
   ├─> JavaScript/TypeScript
   │   ├─> Transpilation (Babel)
   │   ├─> Bundling
   │   └─> Minification (production)
   │
   ├─> SCSS/CSS
   │   ├─> SCSS compilation
   │   ├─> Autoprefixer
   │   ├─> Minification
   │   └─> RTL CSS generation
   │
   └─> Assets
       ├─> SVG → React components
       └─> Images → Optimized output

3. Custom Plugins
   ├─> DependencyExtractionPlugin
   │   └─> Generates .asset.php files
   │
   ├─> CopyPhpFilesPlugin
   │   └─> Copies PHP files to build/
   │
   ├─> BlockAssetsPlugin
   │   ├─> Copies block.json
   │   └─> Copies render.php
   │
   └─> CleanupScssEntriesPlugin
       └─> Removes empty JS files from css/

4. Output
   └─> All files written to build/ directory
```

## Troubleshooting

### Build Fails with Module Not Found

**Issue:** `Module not found: Error: Can't resolve 'package-name'`

**Solution:** Install the missing package:
```bash
pnpm add package-name           # For dependencies
pnpm add -D package-name        # For dev dependencies
```

### Changes Not Showing

**Issue:** Changes don't appear after building

**Solutions:**
1. Clear build directory: `rm -rf build && pnpm run build`
2. Hard refresh browser: `Cmd+Shift+R` (Mac) or `Ctrl+Shift+R` (Windows)
3. Clear WordPress cache if using a caching plugin

### TypeScript Errors

**Issue:** TypeScript compilation errors

**Solution:**
```bash
pnpm run type-check
```

Fix errors shown in output. Note: Build will succeed with warnings even if TypeScript has errors.

### Missing .asset.php Files

**Issue:** `.asset.php` files not generated

**Cause:** No WordPress packages imported

**Solution:** Import WordPress packages:
```javascript
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
```

### Large Bundle Sizes

**Issue:** JavaScript bundles are too large

**Solutions:**
1. Check for duplicate dependencies: `pnpm list package-name`
2. WordPress packages are already externalized
3. Avoid importing large libraries that aren't needed

### Build Directory Structure Wrong

**Issue:** Files output to wrong location

**Cause:** Entry point naming doesn't match expected pattern

**Solution:** Ensure entry keys follow the pattern:
- Blocks: `blocks/{name}/index`
- Components: `components/{name}/index`
- CSS: `css/{name}`

Check `getEntries()` function logic in `webpack.config.js`.

## Performance Optimization

### Production Builds

Production builds include:
- **Minification**: JavaScript and CSS minified
- **Tree Shaking**: Unused code removed
- **Asset Optimization**: Images and assets optimized

### Caching

Content-based hashing in `.asset.php`:
```php
'version' => '06a4adfe8d014719cc3c'  // Changes when content changes
```

WordPress uses this for cache busting.

### External Dependencies

WordPress packages are externalized (not bundled):
- All `@wordpress/*` packages
- `react` and `react-dom`
- `jquery`

This significantly reduces bundle size.

## Resources

- [@wordpress/scripts Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [Webpack Documentation](https://webpack.js.org/)
- [WordPress Block Development](https://developer.wordpress.org/block-editor/)
- [TypeScript Documentation](https://www.typescriptlang.org/)
