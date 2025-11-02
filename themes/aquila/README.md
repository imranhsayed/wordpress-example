# Aquila Theme - WordPress Block Theme

A modern WordPress theme built with Vite for blazing-fast development and optimized production builds. This theme demonstrates how to integrate modern build tooling with WordPress's block editor and theme architecture.

> 📖 **For detailed Vite configuration and build system documentation, see [README.vite.md](./README.vite.md)**

## 📁 Project Structure

```
aquila/
├── src/                          # Source files
│   ├── blocks/                   # Custom Gutenberg blocks
│   │   ├── accordion/            # Parent block
│   │   │   ├── accordion-item/  # Nested child block ⭐
│   │   │   │   ├── block.json
│   │   │   │   ├── index.js
│   │   │   │   ├── edit.jsx
│   │   │   │   ├── save.jsx
│   │   │   │   ├── render.php
│   │   │   │   ├── editor.scss
│   │   │   │   └── style.scss
│   │   │   ├── block.json
│   │   │   ├── index.js
│   │   │   ├── edit.jsx
│   │   │   ├── save.jsx
│   │   │   ├── render.php
│   │   │   └── style.scss
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
│   ├── scss/                     # Global SCSS files
│   │   └── _variables.scss      # SCSS variables (breakpoints, etc.)
│   ├── style.scss               # Main theme stylesheet
│   └── index.js                 # Main entry point
│
├── build/                        # Compiled output (auto-generated)
│   ├── blocks/
│   │   ├── accordion/
│   │   │   ├── accordion-item/  # Nested block compiled ⭐
│   │   │   │   ├── index.js
│   │   │   │   ├── index.asset.php
│   │   │   │   ├── style.css
│   │   │   │   ├── block.json
│   │   │   │   └── render.php
│   │   │   ├── index.js
│   │   │   ├── index.asset.php
│   │   │   ├── style.css
│   │   │   ├── block.json
│   │   │   └── render.php
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
│   ├── Blocks.php               # Block registration (recursive)
│   └── helpers/
│       └── custom-functions.php # Helper functions
│
├── template-parts/               # Template partials
├── vite.config.js               # Vite configuration ⭐
├── package.json                 # Dependencies
└── functions.php                # Theme initialization
```

## 🎯 WordPress Integration

### How Blocks are Registered (Recursively)

**PHP Side** (`inc/Blocks.php`):
```php
// WordPress recursively scans build/blocks/ directory for all block.json files
$iterator = new \RecursiveIteratorIterator(
  new \RecursiveDirectoryIterator(
    'build/blocks',
    \RecursiveDirectoryIterator::SKIP_DOTS
  ),
  \RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
  if ($item->isDir() && file_exists($item->getPathname() . '/block.json')) {
    $blocks[] = $item->getPathname();
  }
}

// Registers all discovered blocks (including nested ones)
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

**Supports nested blocks:**
- ✅ `build/blocks/accordion/block.json`
- ✅ `build/blocks/accordion/accordion-item/block.json` ← Nested block!
- ✅ `build/blocks/notice/block.json`
- ✅ Any level of nesting is supported

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

## 📖 Documentation

- **[README.vite.md](./README.vite.md)** - Complete Vite configuration guide
  - Entry point discovery
  - CSS co-location plugin
  - WordPress IIFE wrapper
  - Block metadata generation
  - PHP file watching
  - SCSS configuration with includePaths
  - Build configuration
  - Development workflow
  - Troubleshooting

- **[src/blocks/README.md](./src/blocks/README.md)** - Block development guide
  - How WordPress loads block styles
  - Save function with InnerBlocks.Content
  - How render.php works
  - Dynamic vs static blocks
  - Common patterns

## 🛠️ Quick Start

### Development
```bash
pnpm install
pnpm run dev
```

### Production Build
```bash
pnpm run build
```

For detailed build system documentation, see [README.vite.md](./README.vite.md).

## 📚 Additional Resources

- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)
- [React Documentation](https://react.dev/)
- [README.vite.md](./README.vite.md) - Complete Vite configuration guide
- [src/blocks/README.md](./src/blocks/README.md) - Block development guide

---

**Last Updated**: November 2024

**Happy coding! 🎉**
