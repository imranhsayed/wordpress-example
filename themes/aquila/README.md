# Aquila Theme - Vite + WordPress Integration

A modern WordPress theme built with **Vite** for blazing-fast development and optimized production builds. This theme demonstrates how to integrate Vite's modern build tooling with WordPress's block editor and theme architecture.

## 🚀 Why Vite?

Vite offers significant advantages over traditional WordPress build tools:

- ⚡ **Lightning-fast HMR** (Hot Module Replacement) - instant updates without full page reload
- 📦 **Optimized builds** - automatic code splitting, tree-shaking, and minification
- 🎯 **Modern JavaScript** - ES2020+ features with automatic transpilation
- 🔧 **Zero config** - sensible defaults with easy customization
- 🎨 **Built-in SCSS/PostCSS** - no additional configuration needed

## 📁 Project Structure

```
aquila/
├── src/                          # Source files
│   ├── blocks/                   # Custom Gutenberg blocks
│   │   ├── notice/
│   │   │   ├── block.json       # Block metadata
│   │   │   ├── index.jsx        # Block registration
│   │   │   ├── edit.jsx         # Editor component
│   │   │   ├── save.jsx         # Save component
│   │   │   ├── render.php       # Server-side rendering
│   │   │   └── style.scss       # Block styles
│   │   └── todo-list/           # Another block
│   ├── components/               # Reusable components
│   │   ├── accordion/
│   │   └── button/
│   ├── style.scss               # Main theme stylesheet
│   └── index.js                 # Main entry point
│
├── build/                        # Compiled output (auto-generated)
│   ├── blocks/
│   │   └── notice/
│   │       ├── index.js         # Compiled JS (IIFE format)
│   │       ├── index.asset.php  # WordPress dependencies
│   │       ├── style.css        # Compiled CSS
│   │       ├── block.json       # Copied metadata
│   │       └── render.php       # Copied PHP template
│   ├── components/
│   ├── index.js                 # Main theme JS
│   └── style.css                # Main theme CSS
│
├── inc/                          # PHP classes
│   ├── AquilaTheme.php          # Main theme class
│   ├── Assets.php               # Asset enqueuing
│   ├── Blocks.php               # Block registration
│   └── helpers/
│       └── custom-functions.php # Helper functions
│
├── template-parts/               # Template partials
├── vite.config.js               # Vite configuration ⭐
├── package.json                 # Dependencies
└── functions.php                # Theme initialization
```

## ⚙️ Vite Configuration Explained

The `vite.config.js` file is the heart of the build system. Here's what each part does:

### 1. Entry Point Discovery

```javascript
function getEntries() {
  const entries = {};
  
  // Auto-discover all blocks
  const blocksDir = path.resolve(__dirname, 'src/blocks');
  for (const dir of fs.readdirSync(blocksDir)) {
    entries[`blocks/${dir}/index`] = path.resolve(blocksDir, dir, 'index.jsx');
  }
  
  // Auto-discover all components
  const componentsDir = path.resolve(__dirname, 'src/components');
  for (const dir of fs.readdirSync(componentsDir)) {
    entries[`components/${dir}/index`] = path.resolve(componentsDir, dir, 'index.js');
  }
  
  // Main entry
  entries['index'] = path.resolve(__dirname, 'src/index.js');
  
  return entries;
}
```

**What it does:**
- Automatically finds all blocks and components
- Creates separate entry points for each
- Enables code splitting (each block/component gets its own JS/CSS)
- No need to manually add entries when creating new blocks

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

### 4. Block Metadata & Asset Generation

```javascript
function copyBlockJson() {
  return {
    name: 'copy-block-json',
    writeBundle(options, bundle) {
      // 1. Copy block.json files
      fs.copyFileSync(srcBlockJson, destBlockJson);
      
      // 2. Copy render.php files
      fs.copyFileSync(srcRenderPhp, destRenderPhp);
      
      // 3. Generate .asset.php files
      const dependencies = detectDependencies(sourceCode);
      fs.writeFileSync(assetPhpPath, 
        `<?php return array('dependencies' => array(${dependencies}), 'version' => '${version}');`
      );
    }
  };
}
```

**What it does:**

#### a) Copies `block.json`
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

#### b) Copies `render.php`
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

#### c) Generates `.asset.php`
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
1. Scans all `.js/.jsx` files in the block directory
2. Finds `import` statements
3. Maps WordPress packages to their script handles:
   - `@wordpress/blocks` → `wp-blocks`
   - `@wordpress/i18n` → `wp-i18n`
   - `react/jsx-runtime` → `react-jsx-runtime`
4. Generates the `.asset.php` file automatically

### 5. Build Configuration

```javascript
export default defineConfig({
  plugins: [
    react({ include: '**/*.{js,jsx,ts,tsx}' }),
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
});
```

**Key settings explained:**

- **`external`**: Don't bundle WordPress/React packages (they're loaded globally)
- **`format: 'es'`**: Output ES modules (our plugin converts them to IIFE)
- **`cssCodeSplit: true`**: Each block gets its own CSS file
- **`entryFileNames`**: Clean output names (`blocks/notice/index.js`)

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
   ├─> Processes SCSS to CSS
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

6. Output to build/ directory
   └─> Ready for WordPress!
```

## 🎯 WordPress Integration

### How Blocks are Registered

**PHP Side** (`inc/Blocks.php`):
```php
// WordPress scans build/blocks/ directory
$blocks = glob('build/blocks/*/block.json');

foreach ($blocks as $block) {
  // Registers block using metadata
  register_block_type_from_metadata($block);
  
  // WordPress automatically:
  // 1. Reads block.json
  // 2. Enqueues editorScript (index.js)
  // 3. Loads dependencies from index.asset.php
  // 4. Enqueues style (style.css)
  // 5. Uses render callback (render.php) if specified
}
```

**JavaScript Side** (`src/blocks/notice/index.jsx`):
```javascript
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,    // Editor component
  save: Save,    // Save component (or null for dynamic)
});
```

### Asset Enqueuing

**Frontend Assets** (`inc/Assets.php`):
```php
public function enqueue_frontend_assets() {
  // Main theme styles
  wp_enqueue_style('aquila-frontend-style', 
    get_theme_file_uri('build/style.css')
  );
  
  // Main theme scripts
  wp_enqueue_script('aquila-frontend-script',
    get_theme_file_uri('build/index.js'),
    [], // Dependencies from index.asset.php
    null,
    true
  );
}
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
- Refresh browser to see changes

**Tip:** Use with browser auto-refresh extension for best experience

### Production Build
```bash
pnpm run build
```

**What happens:**
- Full optimization (minification, tree-shaking)
- Source maps removed
- Assets hashed for cache busting
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

**`src/blocks/my-block/style.scss`:**
```scss
.wp-block-aquila-my-block {
  padding: 20px;
  background: #f0f0f0;
}
```

### 3. Build
```bash
pnpm run build
```

**Vite automatically:**
- ✅ Discovers the new block
- ✅ Compiles JSX and SCSS
- ✅ Generates `.asset.php`
- ✅ Copies `block.json`
- ✅ Creates `build/blocks/my-block/` directory

### 4. WordPress automatically:
- ✅ Registers the block
- ✅ Loads dependencies
- ✅ Shows block in inserter

## 🐛 Troubleshooting

### Block not showing in editor?

**Check:**
1. ✅ `build/blocks/[block-name]/` directory exists
2. ✅ `block.json` is present
3. ✅ `index.js` and `index.asset.php` exist
4. ✅ Block category exists (register in `inc/Blocks.php`)
5. ✅ Check browser console for errors

### Styles not loading?

**Check:**
1. ✅ `style.scss` imported in `index.jsx`
2. ✅ `build/blocks/[block-name]/style.css` exists
3. ✅ `block.json` has `"style": "file:./style.css"`

### JavaScript errors?

**Check:**
1. ✅ All WordPress packages are in `external` array
2. ✅ `.asset.php` has correct dependencies
3. ✅ Browser console for specific errors

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

## 🎓 Key Takeaways

1. **Vite is fast** - Significantly faster than Webpack-based tools
2. **Custom plugins bridge the gap** - Vite → WordPress compatibility
3. **Automatic discovery** - No manual entry configuration needed
4. **Modern DX** - Write modern JavaScript, get WordPress-compatible output
5. **Production-ready** - Optimized builds with minimal configuration

---

**Happy coding! 🎉**

