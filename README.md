# WordPress Example - Modern Development Setup

A modern WordPress development environment demonstrating best practices for theme and plugin development with contemporary build tools and monorepo architecture.

## 🏗️ Architecture Overview

This `wp-content` directory showcases a production-ready WordPress setup using:

- **Monorepo Management**: PNPM workspaces
- **Modern Build Tools**: @wordpress/scripts with custom webpack configuration
- **Component Architecture**: Reusable blocks and components
- **Type Safety**: TypeScript support (optional), PHP namespaces and modern JavaScript

## 📦 Technology Stack

### Package Management
- **PNPM** (v10.15.1+): Fast, disk-efficient package manager
- **PNPM Workspaces**: Manages multiple packages (themes/plugins) in a single repository

### Build Tools

#### Aquila Theme (@wordpress/scripts)
- **@wordpress/scripts**: Official WordPress build tooling with custom webpack configuration
- **Webpack**: Module bundler (used internally by @wordpress/scripts)
- **React** (v19+): For building interactive block editor components
- **Sass**: CSS preprocessing via webpack loaders
- **PostCSS + Autoprefixer**: CSS post-processing (built-in)
- **TypeScript**: Optional type safety for non-block files
- **Custom Webpack Plugins**:
  - `CopyPhpFilesPlugin`: Copies PHP files from src to build
  - `BlockAssetsPlugin`: Handles block.json and render.php copying
  - `CleanupScssEntriesPlugin`: Removes unnecessary JS files from CSS builds
  - `RenameBlockCssPlugin`: Renames index.css → style.css for WordPress conventions
- **Features**:
  - Automatic entry point discovery (blocks, components, SCSS)
  - Automatic `.asset.php` generation for dependency management
  - Recursive block scanning (supports nested blocks)
  - SVG imports as React components (@svgr/webpack)
  - RTL CSS generation

#### Todo-List Plugin (@wordpress/scripts)
- **@wordpress/scripts**: Official WordPress build tooling
- **Webpack**: Module bundler (used internally by @wordpress/scripts)
- Automatic `.asset.php` generation for dependency management

### WordPress Integration
- **Block API v3**: Modern Gutenberg block development
- **Server-side Rendering**: Dynamic blocks with PHP render callbacks
- **Block.json Metadata**: Declarative block configuration
- **WordPress Hooks & Filters**: Extensible architecture

## 🎯 Key Features

### 1. **@wordpress/scripts + Custom Webpack Configuration**
The Aquila theme demonstrates how to extend @wordpress/scripts with custom webpack configuration:

```javascript
// Custom webpack plugin for WordPress block CSS naming conventions
class RenameBlockCssPlugin {
  apply(compiler) {
    compiler.hooks.compilation.tap('RenameBlockCssPlugin', (compilation) => {
      // Renames index.css → style.css in-memory before writing to disk
      compilation.hooks.processAssets.tap({
        name: 'RenameBlockCssPlugin',
        stage: compilation.PROCESS_ASSETS_STAGE_OPTIMIZE_TRANSFER,
      }, (assets) => {
        // In-memory renaming for optimal performance
      });
    });
  }
}
```

**Benefits:**
- 🎯 WordPress standards and best practices out-of-the-box
- 📦 Optimized production builds with automatic dependency extraction
- 🔧 Modern JavaScript (ES2020+) with optional TypeScript
- 🎨 SCSS/PostCSS support with RTL CSS generation
- 🚀 Fast rebuilds with webpack's caching
- 🔄 Automatic WordPress externals (React, @wordpress/* packages)

### 2. **Automatic Entry Point Discovery**
The custom webpack configuration automatically discovers all entry points:

```javascript
function getEntries() {
  const entries = {};

  // Automatically finds:
  // - All blocks (recursive scan supports nested blocks)
  // - All components
  // - All SCSS files
  // - Global entry point

  return entries;
}
```

**Benefits:**
- ✅ No manual entry configuration needed
- ✅ Supports nested blocks (e.g., accordion/accordion-item)
- ✅ Automatic SCSS compilation
- ✅ Scalable architecture

### 3. **Monorepo with PNPM Workspaces**
Efficient workspace management across themes and plugins:

```json
{
  "workspaces": [
    "themes/aquila*"
  ]
}
```

**Benefits:**
- 🚀 Parallel execution across packages
- 📦 Shared dependencies
- 🔧 Consistent tooling

### 4. **Custom Gutenberg Blocks**
Theme includes custom blocks with advanced features:

**Aquila Theme Blocks:**
- `aquila/accordion` + `aquila/accordion-item`: Nested block pattern
- `aquila/tile-carousel` + `aquila/image-tile`: Interactive carousel with nested tiles
- `aquila/notice`: Server-side rendered notice block
- `aquila/todo-list`: Interactive todo list block
- `aquila/related-articles`: Dynamic content block

**Features:**
- ✅ Server-side rendering with `render.php`
- ✅ Nested block support (parent/child relationships)
- ✅ RichText editing with WordPress block editor
- ✅ Custom attributes and supports
- ✅ Automatic dependency injection via `.asset.php`
- ✅ Frontend interactivity with view.js scripts

### 5. **Asset Management**
Sophisticated asset handling system powered by webpack's DependencyExtractionWebpackPlugin:

```php
// Automatic .asset.php generation by @wordpress/scripts
<?php return array(
  'dependencies' => array(
    'react-jsx-runtime',
    'wp-block-editor',
    'wp-blocks',
    'wp-components',
    'wp-element',
    'wp-i18n'
  ),
  'version' => '304bc867941f7fe38749'
);
```

**Features:**
- 📝 Auto-generated dependency manifests with accurate WordPress package detection
- 🔄 Content-based version hashing for cache busting
- 🎯 Scoped CSS per component/block (named style.css for WordPress conventions)
- 📦 WordPress externals automatically configured (React, @wordpress/* not bundled)
- 🌍 Automatic RTL CSS generation for internationalization

## 📁 Directory Structure

```
wp-content/
├── package.json              # Root workspace config
├── pnpm-workspace.yaml       # PNPM workspace definition
├── README.md                 # This file
│
├── themes/
│   └── aquila/              # Custom theme with @wordpress/scripts
│       ├── src/
│       │   ├── blocks/      # Custom Gutenberg blocks (nested support)
│       │   │   ├── accordion/
│       │   │   │   └── accordion-item/  # Nested child block
│       │   │   ├── tile-carousel/
│       │   │   │   └── image-tile/      # Nested child block
│       │   │   ├── notice/
│       │   │   ├── todo-list/
│       │   │   └── related-articles/
│       │   ├── components/  # Reusable components
│       │   │   ├── accordion/
│       │   │   ├── button/
│       │   │   ├── cards/
│       │   │   ├── grid/
│       │   │   └── tile-carousel/
│       │   ├── scss/        # Global SCSS files
│       │   ├── style.scss   # Main stylesheet
│       │   └── index.js     # Entry point
│       ├── build/           # Compiled assets (auto-generated)
│       │   ├── blocks/      # Compiled blocks with .asset.php files
│       │   ├── components/  # Compiled components
│       │   └── css/         # Compiled stylesheets
│       ├── inc/             # PHP classes (OOP)
│       ├── docs/            # Documentation
│       │   ├── README.build.md      # Build system guide ⭐
│       │   ├── README.fonts.md      # Font configuration
│       │   └── README.theme-json.md # theme.json guide
│       ├── webpack.config.js # Custom webpack configuration ⭐
│       ├── tsconfig.json    # TypeScript configuration
│       ├── theme.json       # WordPress design tokens
│       └── package.json     # Theme dependencies
│
└── plugins/
    └── todo-list/           # Plugin with @wordpress/scripts
        ├── src/             # Source files
        └── build/           # Compiled blocks
```

## 🚀 Getting Started

### Prerequisites
- Node.js 20.19+ or 22.12+
- PNPM 10+
- WordPress 6.7+
- PHP 7.4+

### Installation

1. **Install dependencies:**
```bash
cd wp-content
pnpm install
```

2. **Development mode (with file watching):**
```bash
# Run all workspaces in dev mode
pnpm dev

# Or run specific theme
cd themes/aquila
pnpm run dev
```

3. **Production build:**
```bash
# Build all workspaces
pnpm build

# Or build specific theme
cd themes/aquila
pnpm run build
```

4. **Type checking (optional):**
```bash
cd themes/aquila
pnpm run type-check
```

### Using NVM (Node Version Manager)
```bash
cd wp-content
nvm use          # Uses .nvmrc if present
pnpm dev
```

## 🔧 Development Workflow

### Theme Development (Aquila)
```bash
# Development with watch mode (from theme directory)
cd themes/aquila
pnpm run dev

# Production build
pnpm run build

# Type checking (TypeScript)
pnpm run type-check

# Linting
pnpm run lint
pnpm run lint:fix

# CSS linting
pnpm run lint:css
pnpm run lint:css:fix

# Format code
pnpm run format
```

### Plugin Development (Todo-List)
```bash
cd plugins/todo-list

# Development
npm start

# Production build
npm run build
```

## 🎨 Creating Custom Blocks

### 1. Create Block Structure
```
src/blocks/my-block/
├── block.json          # Block metadata
├── index.jsx          # Registration
├── edit.jsx           # Editor component
├── save.jsx           # Save component (or null for dynamic)
├── render.php         # Server-side rendering (optional)
└── style.scss         # Block styles
```

### 2. Block.json Configuration
```json
{
  "apiVersion": 3,
  "name": "aquila/my-block",
  "title": "My Block",
  "category": "aquila",
  "editorScript": "file:./index.js",
  "style": "file:./style.css",
  "render": "file:./render.php",
  "viewScript": "file:./view.js"
}
```

### 3. Webpack Auto-handles:
- ✅ Compiles JSX to JavaScript (Babel)
- ✅ Processes SCSS to CSS (sass-loader + MiniCssExtractPlugin)
- ✅ Generates `.asset.php` with WordPress dependencies (DependencyExtractionWebpackPlugin)
- ✅ Copies `block.json` and `render.php` to build (BlockAssetsPlugin)
- ✅ Renames CSS files to WordPress conventions (RenameBlockCssPlugin)
- ✅ Generates RTL CSS automatically
- ✅ Externalizes WordPress globals (React, @wordpress/*)

## 🔍 Why @wordpress/scripts?

The Aquila theme uses @wordpress/scripts with custom webpack configuration for several key reasons:

| Aspect | Benefit |
|--------|---------|
| **WordPress Standards** | 🎯 Follows official WordPress development practices |
| **Dependency Management** | 📦 Automatic and accurate WordPress package detection |
| **WordPress Externals** | 🔄 Built-in support for wp.*, React as globals |
| **RTL Support** | 🌍 Automatic RTL CSS generation for internationalization |
| **Asset PHP Files** | ✅ Reliable `.asset.php` generation with correct dependencies |
| **Community Support** | 👥 Large WordPress developer community using same tools |
| **Plugin Ecosystem** | 🔌 Compatible with WordPress plugin development |
| **Maintenance** | 🛠️ Maintained by WordPress core team |
| **Customizable** | ⚙️ Easily extended with custom webpack plugins |

**Custom Webpack Configuration Additions:**
- Automatic entry point discovery (blocks, components, SCSS)
- Nested block support (recursive scanning)
- WordPress CSS naming conventions (style.css)
- TypeScript support (optional)
- SVG as React components
- PHP file copying from src to build

## 🏆 Best Practices Demonstrated

1. **Separation of Concerns**: PHP classes in `/inc`, JS/CSS in `/src`, build output in `/build`
2. **Namespacing**: PHP namespaces (`Aquila\Theme`)
3. **Singleton Pattern**: For theme initialization
4. **Server-side Rendering**: Dynamic blocks with `render.php`
5. **Asset Optimization**: Minification, tree-shaking, automatic WordPress externals
6. **Type Safety**: TypeScript support (optional for non-block files), PHP type hints
7. **WordPress Standards**: Following official build tooling and conventions
8. **Recursive Block Registration**: Automatic discovery and registration of nested blocks
9. **CSS Naming Conventions**: WordPress-standard `style.css` for blocks
10. **Dependency Management**: Automatic `.asset.php` generation with accurate dependencies
11. **Monorepo Benefits**: Shared dependencies, consistent tooling via PNPM workspaces

## 📚 Additional Resources

### WordPress & Block Development
- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)
- [@wordpress/scripts Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)

### Build Tools & JavaScript
- [Webpack Documentation](https://webpack.js.org/)
- [React Documentation](https://react.dev/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [PNPM Workspaces](https://pnpm.io/workspaces)

### Theme Documentation
- [Aquila Theme Build System Guide](./themes/aquila/docs/README.build.md)
- [Aquila Block Development Guide](./themes/aquila/src/blocks/README.md)
- [Font Configuration](./themes/aquila/docs/README.fonts.md)
- [Theme.json Documentation](./themes/aquila/docs/README.theme-json.md)

## 🤝 Contributing

This is an example project demonstrating modern WordPress development practices. Feel free to use it as a reference or starting point for your own projects.

## 📝 License

GPL-3.0-or-later (WordPress compatible)

---

**Last Updated**: January 2025

**Built with ❤️ using @wordpress/scripts, custom webpack configuration, and modern WordPress development practices**

