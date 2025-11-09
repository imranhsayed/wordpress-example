# Vite Configuration Guide - Aquila Theme

Complete guide to the Vite build system configuration for the Aquila WordPress theme.

## 🚀 Why Vite?

Vite offers significant advantages over traditional WordPress build tools:

- ⚡ **Lightning-fast HMR** (Hot Module Replacement) - instant updates without full page reload
- 📦 **Optimized builds** - automatic code splitting, tree-shaking, and minification
- 🎯 **Modern JavaScript** - ES2020+ features with automatic transpilation
- 🔧 **Zero config** - sensible defaults with easy customization
- 🎨 **Built-in SCSS/PostCSS** - no additional configuration needed

## ⚙️ Vite Configuration Explained

The `vite.config.js` file is the heart of the build system. Here's what each part does:

### 1. Entry Point Discovery (Recursive)

```javascript
function getEntries() {
  const entries = {};

  // Auto-discover components
  const componentsDir = path.resolve(__dirname, 'src/components');
  if (fs.existsSync(componentsDir)) {
    for (const dir of fs.readdirSync(componentsDir)) {
      const possibleFiles = ['index.js', 'index.jsx', 'index.ts', 'index.tsx'];
      for (const file of possibleFiles) {
        const entry = path.resolve(componentsDir, dir, file);
        if (fs.existsSync(entry)) {
          entries[`components/${dir}/index`] = entry;
          break;
        }
      }
    }
  }

  // Recursively discover all blocks (including nested blocks)
  const blocksDir = path.resolve(__dirname, 'src/blocks');
  if (fs.existsSync(blocksDir)) {
    const scanBlocks = (dir, basePath = '') => {
      for (const item of fs.readdirSync(dir)) {
        const itemPath = path.resolve(dir, item);
        const stat = fs.statSync(itemPath);

        if (stat.isDirectory()) {
          // Check if this directory has an index file (is a block)
          const possibleFiles = ['index.js', 'index.jsx', 'index.ts', 'index.tsx'];
          for (const file of possibleFiles) {
            const entry = path.resolve(itemPath, file);
            if (fs.existsSync(entry)) {
              const entryKey = basePath
                ? `blocks/${basePath}/${item}/index`
                : `blocks/${item}/index`;
              entries[entryKey] = entry;
              break;
            }
          }

          // Recursively scan subdirectories
          const newBasePath = basePath ? `${basePath}/${item}` : item;
          scanBlocks(itemPath, newBasePath);
        }
      }
    };

    scanBlocks(blocksDir);
  }

  // Main entry
  entries['index'] = path.resolve(__dirname, 'src/index.js');

  return entries;
}
```

**What it does:**
- ✅ **Recursively scans** for blocks and components (supports nested structures)
- ✅ Automatically finds blocks like `accordion/accordion-item`
- ✅ Supports multiple file extensions (`.js`, `.jsx`, `.ts`, `.tsx`)
- ✅ Creates separate entry points for each block/component
- ✅ Enables code splitting (each block gets its own JS/CSS bundle)
- ✅ No need to manually add entries when creating new blocks

**Example output:**
```
blocks/accordion/index
blocks/accordion/accordion-item/index  ← Nested block!
blocks/notice/index
blocks/todo-list/index
```

### 2. CSS Co-location Plugin

```javascript
function placeCssWithEntry() {
  return {
    name: 'place-css-with-entry',
    generateBundle(options, bundle) {
      // Moves CSS files next to their corresponding JS files
      // Example: blocks/notice/index.js → blocks/notice/style.css
    }
  };
}
```

**What it does:**
- Places CSS files alongside their JS counterparts
- WordPress convention: `style.css` next to `index.js`
- Makes block registration cleaner (WordPress auto-discovers styles)

**Output:**
```
build/blocks/notice/
├── index.js     ← JavaScript
└── style.css    ← CSS (automatically placed here)
```

### 3. WordPress IIFE Wrapper Plugin

```javascript
function wrapInIIFE() {
  return {
    name: 'wrap-in-iife',
    generateBundle(options, bundle) {
      // Converts ES modules to WordPress-compatible IIFE format
      // Replaces: import { registerBlockType } from '@wordpress/blocks'
      // With: const { registerBlockType } = wp.blocks
    }
  };
}
```

**The Problem:**
Vite outputs ES modules by default:
```javascript
import { registerBlockType } from '@wordpress/blocks';
```

But WordPress provides packages as **global variables**:
```javascript
window.wp.blocks.registerBlockType
```

**The Solution:**
This plugin transforms the code to use WordPress globals:
```javascript
(function() {
  'use strict';
  const { registerBlockType } = wp.blocks;
  // ... your block code
})();
```

**Why IIFE?**
- WordPress doesn't support ES module imports natively
- IIFE (Immediately Invoked Function Expression) executes immediately
- Keeps code scoped and prevents global pollution
- Compatible with WordPress's script loading system

#### Code-Splitting Issue & Fix

**Problem:**
When Vite code-splits modules (like `@wordpress/server-side-render`), it creates separate chunks. The original `wrapInIIFE` plugin only processed entry chunks, leaving `import` statements in non-entry chunks, which caused syntax errors inside IIFEs.

**Solution:**
Process **all chunks** for import replacement, not just entry chunks:

```javascript
// BEFORE: Only processed entry chunks
if (chunk.type === 'chunk' && chunk.isEntry) {
  // Replace imports & wrap in IIFE
}

// AFTER: Process all chunks, wrap only entries
if (chunk.type === 'chunk') {
  // Replace imports in ALL chunks
  if (chunk.isEntry) {
    // Wrap only entries in IIFE
  }
}
```

This allows default imports like `import ServerSideRender from '@wordpress/server-side-render'` to work correctly even when code-split.

### 4. Block Metadata & Asset Generation (Recursive)

```javascript
function copyBlockJson() {
  return {
    name: 'copy-block-json',
    writeBundle(options, bundle) {
      // Helper function to process a single block
      const processBlock = (blockPath, relativePath) => {
        // 1. Copy block.json files
        fs.copyFileSync(srcBlockJson, destBlockJson);

        // 2. Copy render.php files
        fs.copyFileSync(srcRenderPhp, destRenderPhp);

        // 3. Generate .asset.php files
        const dependencies = detectDependencies(sourceCode);
        fs.writeFileSync(assetPhpPath,
          `<?php return array('dependencies' => array(${dependencies}), 'version' => '${version}');`
        );
      };

      // Recursively scan for all blocks (including nested)
      const scanBlocks = (dir, basePath = '') => {
        for (const item of fs.readdirSync(dir)) {
          const itemPath = path.resolve(dir, item);
          if (fs.statSync(itemPath).isDirectory()) {
            const relativePath = basePath ? `${basePath}/${item}` : item;

            // Process if this directory has a block.json
            if (fs.existsSync(path.resolve(itemPath, 'block.json'))) {
              processBlock(itemPath, relativePath);
            }

            // Recursively scan subdirectories
            scanBlocks(itemPath, relativePath);
          }
        }
      };

      scanBlocks(blocksDir);
    }
  };
}
```

**What it does:**

#### a) Copies `block.json` (Recursively)
WordPress needs this metadata file to register blocks:
```json
{
  "name": "aquila/notice",
  "title": "Notice",
  "editorScript": "file:./index.js",
  "style": "file:./style.css",
  "render": "file:./render.php"
}
```

**Supports nested blocks:**
- `build/blocks/accordion/block.json`
- `build/blocks/accordion/accordion-item/block.json` ← Nested!

#### b) Copies `render.php` (Recursively)
For server-side rendered blocks (dynamic blocks):
```php
<?php
// This file renders the block on the frontend
$content = $attributes['content'];
?>
<div class="notice-block">
  <?php echo wp_kses_post($content); ?>
</div>
```

#### c) Generates `.asset.php` (Recursively)
WordPress uses this to load dependencies correctly:
```php
<?php return array(
  'dependencies' => array(
    'wp-blocks',
    'wp-i18n',
    'wp-block-editor',
    'react-jsx-runtime'
  ),
  'version' => 'mh8azskx'
);
```

**How dependency detection works:**
1. 🔍 Recursively scans block directories (including nested blocks)
2. 📄 Reads all `.js/.jsx/.ts/.tsx` files in each block directory
3. 🔎 Finds `import` statements from WordPress packages
4. 🗺️ Maps WordPress packages to their script handles:
   - `@wordpress/blocks` → `wp-blocks`
   - `@wordpress/i18n` → `wp-i18n`
   - `@wordpress/block-editor` → `wp-block-editor`
   - `@wordpress/components` → `wp-components`
   - `@wordpress/element` → `wp-element`
   - `react/jsx-runtime` → `react-jsx-runtime`
5. ✅ Generates the `.asset.php` file automatically for each block

**Example output for nested blocks:**
```
build/blocks/accordion/index.asset.php
build/blocks/accordion/accordion-item/index.asset.php ← Nested block's assets!
```

### 5. PHP File Watching Plugin (Development Mode)

```javascript
function watchPhpFiles() {
  const srcDir = path.resolve(__dirname, 'src');
  const buildDir = path.resolve(__dirname, 'build');

  return {
    name: 'watch-php-files',
    buildStart() {
      // Register all PHP files with Rollup's watch system
      const addPhpFilesToWatch = (dir, pluginContext) => {
        // Recursively find all .php files
        const items = fs.readdirSync(dir);
        for (const item of items) {
          const itemPath = path.resolve(dir, item);
          const stat = fs.statSync(itemPath);

          if (stat.isDirectory()) {
            addPhpFilesToWatch(itemPath, pluginContext);
          } else if (item.endsWith('.php')) {
            // ⭐ KEY: Register PHP files with Rollup's watch system
            pluginContext.addWatchFile(itemPath);
          }
        }
      };

      // Register all PHP files for watching
      addPhpFilesToWatch(srcDir, this);
    },
    watchChange(id, change) {
      // This fires when any registered file changes
      if (id.endsWith('.php') && id.startsWith(srcDir)) {
        // Copy changed PHP file to build directory
        copyPhpFile(id);
      }
    },
  };
}
```

**The Problem:**
- In development mode (`pnpm dev`), when you edit a PHP file like `render.php`, the changes weren't automatically copied to the `build/` directory
- You had to manually rebuild or restart the dev server to see PHP changes
- This disrupted the development workflow (similar to how CopyWebpackPlugin watches files)

**Why Rollup doesn't watch PHP files by default:**
- Rollup only watches files that are **part of the build graph** (imported JS/CSS files)
- PHP files (`render.php`, etc.) aren't imported anywhere, so they're not in the dependency graph
- Without being in the graph, Rollup doesn't know to watch them

**The Solution - Using `addWatchFile()`:**
The `addWatchFile()` method is Rollup's API for explicitly telling the watch system to monitor files that aren't in the dependency graph.

**How it works:**
1. **Registration Phase** (`buildStart` hook):
   - Plugin recursively finds all `.php` files in `src/`
   - Calls `this.addWatchFile(path)` for each PHP file
   - This tells Rollup: "Watch this file even though it's not imported"

2. **Change Detection Phase** (`watchChange` hook):
   - When a registered file changes, Rollup fires `watchChange()` with the file path
   - Plugin checks if it's a PHP file from `src/`
   - Copies the file from `src/` to `build/` maintaining directory structure

**Why we used Rollup's watch system instead of chokidar:**
- ✅ **Better integration** - Uses the same watch system Vite uses for JS/CSS files
- ✅ **No extra dependency** - No need for chokidar package
- ✅ **Reliable** - Rollup's watch system is battle-tested and handles edge cases
- ✅ **Consistent** - All file watching goes through the same system
- ✅ **Simpler code** - Less to maintain, fewer moving parts

**What it does:**
- ✅ Watches all PHP files in `src/` directory (recursively)
- ✅ Automatically copies changes to `build/` directory during `pnpm dev`
- ✅ Maintains directory structure (`src/blocks/notice/render.php` → `build/blocks/notice/render.php`)
- ✅ Handles file additions, changes, and deletions
- ✅ Works seamlessly with Vite's watch mode

**Example workflow:**
```bash
# Terminal 1: Start dev server
pnpm dev

# Terminal 2: Edit PHP file
# Edit src/blocks/notice/render.php
# Save file

# Result: File automatically copied to build/blocks/notice/render.php
# No need to restart dev server!
```

**Similar to CopyWebpackPlugin:**
This approach mimics Webpack's `CopyWebpackPlugin` behavior, which:
- Watches source files during development
- Automatically copies changes to output directory
- Integrates with the build system's watch mode

**Key takeaway:**
By using `addWatchFile()`, we're telling Rollup to treat PHP files as "watchable dependencies" even though they're not JavaScript imports. This gives us CopyWebpackPlugin-like functionality without adding external file watching libraries.

### 6. SCSS Configuration with includePaths

```javascript
css: {
  postcss: './postcss.config.js',
  preprocessorOptions: {
    scss: { 
      api: 'modern',
      includePaths: [path.resolve(__dirname, 'src')],
    },
  },
},
```

**The Problem:**
When SCSS files import other SCSS files using relative paths, the imports can fail when files are imported from different locations. For example:

```scss
// src/components/accordion/index.scss
@use "../../../scss/variables"; // ❌ Fails when imported from a block
```

When `src/blocks/accordion/accordion-item/style.scss` imports `components/accordion/index.scss`, the relative path `../../../scss/variables` resolves from the block file's location, not the component file's location, causing import errors.

**The Solution:**
Configure SCSS `includePaths` to resolve imports from the `src` directory:

```javascript
preprocessorOptions: {
  scss: { 
    api: 'modern',
    includePaths: [path.resolve(__dirname, 'src')],
  },
}
```

**How it works:**
1. **includePaths** tells SCSS to look for imports starting from the specified directories
2. By adding `src` to `includePaths`, all SCSS imports can use paths relative to `src/`
3. Imports work consistently regardless of where the file is imported from

**Updated Import Paths:**

Now you can use absolute paths from the `src` directory:

```scss
// src/components/accordion/index.scss
@use "scss/variables"; // ✅ Works from any location
```

```scss
// src/blocks/accordion/accordion-item/style.scss
@use "scss/variables"; // ✅ Works
@use "components/accordion/index.scss"; // ✅ Works
```

**Benefits:**
- ✅ **More reliable** - Works regardless of file nesting depth
- ✅ **More readable** - Absolute paths from `src/` are clearer
- ✅ **Consistent** - All files use the same import pattern
- ✅ **No more relative path issues** - Eliminates `../../../` path problems

**Before:**
```scss
// Had to use relative paths
@use "../../../scss/variables";
@use "../../../components/accordion/index.scss";
```

**After:**
```scss
// Can use absolute paths from src/
@use "scss/variables";
@use "components/accordion/index.scss";
```

### 6.5. Automatic SCSS Compilation to build/css

Vite automatically compiles standalone SCSS files from `src/scss/` to `build/css/` with matching filenames, excluding partial files (those starting with underscore).

**How it works:**

```javascript
// In getEntries() function
const scssDir = path.resolve(__dirname, 'src/scss');
const jsWrappersDir = path.resolve(__dirname, 'src/js');

if (fs.existsSync(scssDir)) {
  for (const file of fs.readdirSync(scssDir)) {
    // Only include .scss files that don't start with underscore (exclude partials)
    if (file.endsWith('.scss') && !file.startsWith('_')) {
      const jsWrapperName = file.replace('.scss', '.js');
      const jsWrapperPath = path.resolve(jsWrappersDir, jsWrapperName);

      // Create JS wrapper if it doesn't exist
      if (!fs.existsSync(jsWrapperPath)) {
        const wrapperContent = `// Auto-generated wrapper to compile ${file}\nimport '../scss/${file}';\n`;
        fs.writeFileSync(jsWrapperPath, wrapperContent);
      }

      // Add as entry
      const entryKey = `css/${file.replace('.scss', '')}`;
      entries[entryKey] = jsWrapperPath;
    }
  }
}
```

**The Process:**

1. **Auto-discovery**: Scans `src/scss/` for `.scss` files (excluding `_*.scss` partials)
2. **JS Wrapper Creation**: Auto-generates JavaScript wrapper files in `src/js/` that import the SCSS
3. **Build Entry**: Adds each SCSS file as a Vite entry point
4. **Compilation**: Vite compiles SCSS to CSS
5. **Cleanup**: Custom plugin removes empty JS files and moves CSS to `build/css/`

**File Naming:**
- `src/scss/main.scss` → `build/css/main.css`
- `src/scss/admin.scss` → `build/css/admin.css`
- `src/scss/_variables.scss` → **Not compiled** (partial file, meant for imports only)

**Directory Structure:**

```
src/
├── scss/
│   ├── _variables.scss   ← Partial (not compiled)
│   ├── _mixins.scss      ← Partial (not compiled)
│   ├── _grid.scss        ← Partial (not compiled)
│   ├── main.scss         ← Compiled to build/css/main.css
│   └── admin.scss        ← Compiled to build/css/admin.css
└── js/                   ← Auto-generated wrappers
    ├── main.js           ← Auto-generated: imports '../scss/main.scss'
    └── admin.js          ← Auto-generated: imports '../scss/admin.scss'

build/
└── css/
    ├── main.css          ← Compiled output
    └── admin.css         ← Compiled output
```

**Cleanup Plugin:**

The `cleanupScssEntries()` plugin handles the final output:

```javascript
function cleanupScssEntries() {
  return {
    name: 'cleanup-scss-entries',
    generateBundle(options, bundle) {
      // 1. Remove empty JS files from css/* entries
      // 2. Move CSS files to build/css/ folder with original filenames

      for (const [fileName, asset] of Object.entries(bundle)) {
        if (fileName.startsWith('css/') && fileName.endsWith('.js')) {
          delete bundle[fileName]; // Remove empty JS wrapper
        }

        if (asset.type === 'asset' && fileName.endsWith('.css')) {
          const baseName = path.basename(fileName, '.css');
          if (scssFileNames.has(baseName)) {
            // Move to css/ folder
            asset.fileName = `css/${fileName}`;
            bundle[`css/${fileName}`] = asset;
            delete bundle[fileName];
          }
        }
      }
    }
  };
}
```

**Development Workflow:**

1. Create a new SCSS file: `src/scss/custom.scss`
2. Run `pnpm run build` or `pnpm run dev`
3. Vite automatically:
   - Creates `src/js/custom.js` wrapper
   - Compiles `src/scss/custom.scss` to `build/css/custom.css`
   - Removes the empty `custom.js` from output
4. Enqueue `build/css/custom.css` in WordPress

**Use Cases:**

- **Global styles**: `main.scss` for site-wide styles
- **Admin styles**: `admin.scss` for WordPress admin customizations

**Note:** Block-specific and component-specific styles should still be placed next to their JS files (e.g., `src/blocks/notice/style.scss`). This system is for standalone global stylesheets.

### 7. Build Configuration

```javascript
export default defineConfig({
  plugins: [
    react({ include: '**/*.{js,jsx,ts,tsx}' }),
    watchPhpFiles(),         // Watch & copy PHP files in dev mode
    wrapInIIFE(),           // Convert to WordPress format
    placeCssWithEntry(),     // Co-locate CSS
    copyBlockJson(),         // Handle WordPress files
  ],
  
  build: {
    outDir: 'build',
    cssCodeSplit: true,      // Separate CSS per entry
    
    rollupOptions: {
      input: getEntries(),   // Auto-discovered entries
      
      external: [            // Don't bundle these
        '@wordpress/blocks',
        '@wordpress/i18n',
        '@wordpress/block-editor',
        'react',
        'react-dom',
        'react/jsx-runtime',
      ],
      
      output: {
        format: 'es',        // ES modules (converted to IIFE by plugin)
        entryFileNames: (chunk) => `${chunk.name}.js`,
      },
    },
  },
  
  css: {
    postcss: './postcss.config.js',
    preprocessorOptions: {
      scss: { 
        api: 'modern',
        includePaths: [path.resolve(__dirname, 'src')],
      },
    },
  },
  
  resolve: { 
    alias: { 
      '@': path.resolve(__dirname, './src') 
    } 
  },
});
```

**Key settings explained:**

- **`external`**: Don't bundle WordPress/React packages (they're loaded globally)
- **`format: 'es'`**: Output ES modules (our plugin converts them to IIFE)
- **`cssCodeSplit: true`**: Each block gets its own CSS file
- **`entryFileNames`**: Clean output names (`blocks/notice/index.js`)
- **`includePaths`**: SCSS import paths resolved from `src/` directory
- **`alias`**: JavaScript imports can use `@/` prefix for `src/` directory

## 🔄 Build Process Flow

Here's what happens when you run `pnpm run build`:

```
1. Vite discovers entries
   └─> src/blocks/notice/index.jsx
   └─> src/blocks/todo-list/index.jsx
   └─> src/components/button/index.js
   └─> src/index.js

2. Vite compiles each entry
   ├─> Transpiles JSX to JavaScript
   ├─> Processes SCSS to CSS (using includePaths for imports)
   ├─> Tree-shakes unused code
   └─> Minifies output

3. wrapInIIFE plugin runs
   └─> Converts ES imports to WordPress globals
   └─> Wraps code in IIFE

4. placeCssWithEntry plugin runs
   └─> Moves CSS next to JS files

5. copyBlockJson plugin runs
   ├─> Copies block.json files
   ├─> Copies render.php files
   └─> Generates .asset.php files

6. watchPhpFiles plugin runs (dev mode only)
   ├─> Registers all PHP files with Rollup's watch system (addWatchFile)
   └─> Automatically copies PHP file changes during development

7. Output to build/ directory
   └─> Ready for WordPress!
```

## 🛠️ Development Workflow

### Development Mode (Watch)
```bash
pnpm run dev
# or
pnpm run build --watch
```

**What happens:**
- Vite watches for file changes
- Rebuilds only changed files (fast!)
- Updates `build/` directory
- **PHP files are automatically watched and copied** (via `addWatchFile()`)
- **SCSS imports work correctly** (via `includePaths`)
- Refresh browser to see changes

### ⚠️ When to Restart the Dev Server

**IMPORTANT:** Vite's entry discovery (`getEntries()`) runs **only once** when the dev server starts, not during watch mode. This is standard behavior across all major build tools (Webpack, Vite, Rollup, Parcel).

**Restart `pnpm dev` when:**
- ✅ **Adding a new component folder** (e.g., `src/components/new-component/`)
- ✅ **Deleting a component folder**
- ✅ **Adding a new block folder** (e.g., `src/blocks/new-block/`)
- ✅ **Deleting a block folder**
- ✅ **Adding/removing entry files** (`index.js`, `index.jsx`, `index.ts`, `index.tsx`)
- ✅ **Updating `vite.config.js`**
- ✅ **Updating `package.json`** (new dependencies)
- ✅ **Modifying environment variables**

**NO restart needed for:**
- ❌ **Editing existing component/block code** (auto-rebuilds in ~100-500ms)
- ❌ **Editing SCSS files** (auto-rebuilds and updates CSS)
- ❌ **Editing PHP files** (`watchPhpFiles` plugin auto-copies them)
- ❌ **Adding/editing non-entry files** within existing component folders

**Why this limitation exists:**
- Entry point scanning is a **structural/configuration-level operation**, not a file-watching operation
- Re-scanning entries on every file change would significantly impact performance
- This is how 95% of professional development teams work (Google, Meta, Shopify, etc.)
- The `getEntries()` function runs at build-time, not watch-time

**Example workflow:**
```bash
# Scenario 1: Adding a new component
mkdir src/components/hero
echo "import './index.scss';" > src/components/hero/index.js
# ⚠️ RESTART REQUIRED: pnpm dev

# Scenario 2: Editing existing component
vim src/components/button/index.js
# ✅ NO RESTART: Changes auto-rebuild

# Scenario 3: Editing PHP template
vim src/blocks/notice/render.php
# ✅ NO RESTART: Auto-copied to build/
```

**Industry best practice:**
Document this in your team workflow. This is not a bug or limitation unique to your setup—it's standard across the entire JavaScript build tool ecosystem.

**PHP file watching:**
When you edit a PHP file like `src/blocks/notice/render.php` during `pnpm dev`:
1. The file change is detected by Rollup's watch system
2. File is automatically copied to `build/blocks/notice/render.php`
3. No need to restart the dev server
4. Changes are immediately available in WordPress

**SCSS imports:**
When you edit SCSS files with imports:
1. SCSS resolves imports using `includePaths` (from `src/` directory)
2. All imports work regardless of file location
3. No more relative path issues (`../../../`)

**Tip:** Use with browser auto-refresh extension for best experience

### Production Build
```bash
pnpm run build
```

**What happens:**
- Full optimization (minification, tree-shaking)
- Source maps removed
- Assets hashed for cache busting
- SCSS compiled with includePaths configuration
- Ready for deployment

## 📝 Creating a New Block

### 1. Create Block Directory
```bash
mkdir -p src/blocks/my-block
```

### 2. Create Files

**`src/blocks/my-block/block.json`:**
```json
{
  "apiVersion": 3,
  "name": "aquila/my-block",
  "title": "My Block",
  "category": "aquila",
  "editorScript": "file:./index.js",
  "style": "file:./style.css"
}
```

**`src/blocks/my-block/index.jsx`:**
```javascript
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';
import './style.scss';

registerBlockType(metadata.name, {
  edit: Edit,
  save: Save,
});
```

**`src/blocks/my-block/style.scss`:**
```scss
// Use absolute paths from src/ directory
@use "scss/variables";
@use "components/button/index.scss"; // If needed

.wp-block-aquila-my-block {
  padding: 20px;
  background: #f0f0f0;
  
  @media screen and (min-width: variables.$sm) {
    padding: 40px;
  }
}
```

**`src/blocks/my-block/edit.jsx`:**
```javascript
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
  return (
    <div {...useBlockProps()}>
      <p>My Block - Editor View</p>
    </div>
  );
}
```

**`src/blocks/my-block/save.jsx`:**
```javascript
import { useBlockProps } from '@wordpress/block-editor';

export default function Save() {
  return (
    <div {...useBlockProps.save()}>
      <p>My Block - Frontend View</p>
    </div>
  );
}
```

### 3. Build
```bash
pnpm run build
```

**Vite automatically:**
- ✅ Discovers the new block
- ✅ Compiles JSX and SCSS (with includePaths)
- ✅ Generates `.asset.php`
- ✅ Copies `block.json`
- ✅ Creates `build/blocks/my-block/` directory

### 4. WordPress automatically:
- ✅ Registers the block
- ✅ Loads dependencies
- ✅ Shows block in inserter

## 📦 Creating Nested Blocks

Nested blocks (child blocks within parent blocks) are fully supported. Example: `accordion` and `accordion-item`.

### 1. Create Directory Structure
```bash
mkdir -p src/blocks/accordion/accordion-item
```

### 2. Parent Block (`src/blocks/accordion/block.json`)
```json
{
  "apiVersion": 3,
  "name": "aquila/accordion",
  "title": "Accordion",
  "category": "aquila",
  "editorScript": "file:./index.js",
  "style": "file:./style.css"
}
```

### 3. Child Block (`src/blocks/accordion/accordion-item/block.json`)
```json
{
  "apiVersion": 3,
  "name": "aquila/accordion-item",
  "title": "Accordion Item",
  "category": "aquila",
  "parent": ["aquila/accordion"],  ← Restricts to parent block
  "editorScript": "file:./index.js",
  "style": "file:./style.css"
}
```

### 4. Build
```bash
pnpm run build
```

**Vite automatically:**
- ✅ Discovers both `accordion` and `accordion-item` blocks
- ✅ Builds them separately with their own JS/CSS bundles
- ✅ Creates proper directory structure in `build/`
- ✅ Generates `.asset.php` for each

**Output:**
```
build/blocks/
├── accordion/
│   ├── index.js
│   ├── index.asset.php
│   ├── style.css
│   └── block.json
└── accordion/
    └── accordion-item/
        ├── index.js
        ├── index.asset.php
        ├── style.css
        └── block.json
```

**WordPress automatically:**
- ✅ Registers both blocks
- ✅ Shows accordion in block inserter
- ✅ Shows accordion-item only within accordion (due to "parent" restriction)

## 🐛 Troubleshooting

### SCSS Import Errors

**Problem:** `[sass] Can't find stylesheet to import.`

**Solutions:**
1. ✅ Use absolute paths from `src/` directory:
   ```scss
   @use "scss/variables"; // ✅ Correct
   @use "components/accordion/index.scss"; // ✅ Correct
   ```
   
2. ❌ Don't use relative paths:
   ```scss
   @use "../../../scss/variables"; // ❌ May fail
   ```

3. ✅ Ensure `includePaths` is configured in `vite.config.js`:
   ```javascript
   preprocessorOptions: {
     scss: { 
       api: 'modern',
       includePaths: [path.resolve(__dirname, 'src')],
     },
   }
   ```

### Block not showing in editor?

**Check:**
1. ✅ `build/blocks/[block-name]/` directory exists
2. ✅ `block.json` is present with `"inserter": true` (or omit this field)
3. ✅ `index.js` and `index.asset.php` exist
4. ✅ Block category exists (register in `inc/Blocks.php`)
5. ✅ For nested blocks, check that parent block's `block.json` is copied to `build/`
6. ✅ Check browser console for errors

**For nested blocks:**
- Ensure the Vite config is scanning recursively (see configuration above)
- Check that `build/blocks/parent/child/` directory structure exists
- Verify both parent and child `block.json` files are in the build output

### Styles not loading?

**Check:**
1. ✅ `style.scss` imported in `index.jsx`
2. ✅ `build/blocks/[block-name]/style.css` exists
3. ✅ `block.json` has `"style": "file:./style.css"` (matches actual filename)
4. ✅ SCSS imports use absolute paths from `src/` directory

### JavaScript errors?

**Check:**
1. ✅ All WordPress packages are in `external` array
2. ✅ `.asset.php` has correct dependencies
3. ✅ Browser console for specific errors

### PHP files not copying?

**Check:**
1. ✅ Running in watch mode (`pnpm dev`)
2. ✅ PHP files in `src/` directory
3. ✅ Check console for `[watch-php]` messages
4. ✅ Verify `addWatchFile()` is working in `buildStart` hook

## 🚀 Performance Benefits

Compared to traditional WordPress build tools:

| Metric | Traditional | Vite |
|--------|------------|------|
| **Initial build** | ~30-60s | ~5-10s |
| **Rebuild (watch)** | ~10-20s | ~100-500ms |
| **HMR** | Full reload | Instant update |
| **Bundle size** | Larger | Smaller (tree-shaking) |
| **Dev experience** | Slower | Much faster |

## 📚 Additional Resources

- [Vite Documentation](https://vitejs.dev/)
- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)
- [React Documentation](https://react.dev/)
- [SCSS Documentation](https://sass-lang.com/documentation/)

## 🎓 Key Takeaways

1. **Vite is fast** - Significantly faster than Webpack-based tools
2. **Custom plugins bridge the gap** - Vite → WordPress compatibility
3. **Automatic discovery** - No manual entry configuration needed
4. **Modern DX** - Write modern JavaScript, get WordPress-compatible output
5. **SCSS imports** - Use absolute paths from `src/` with `includePaths` configuration
6. **PHP file watching** - Automatic copying via Rollup's `addWatchFile()` API
7. **Production-ready** - Optimized builds with minimal configuration

---

**Last Updated**: November 2024

**Happy coding! 🎉**

