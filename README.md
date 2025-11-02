# WordPress Example - Modern Development Setup

A modern WordPress development environment demonstrating best practices for theme and plugin development with contemporary build tools and monorepo architecture.

## 🏗️ Architecture Overview

This `wp-content` directory showcases a production-ready WordPress setup using:

- **Monorepo Management**: PNPM workspaces
- **Modern Build Tools**: Vite for theme assets, @wordpress/scripts for plugins
- **Component Architecture**: Reusable blocks and components
- **Type Safety**: PHP namespaces and modern JavaScript

## 📦 Technology Stack

### Package Management
- **PNPM** (v10.15.1+): Fast, disk-efficient package manager
- **PNPM Workspaces**: Manages multiple packages (themes/plugins) in a single repository

### Build Tools

#### Aquila Theme (Vite-based)
- **Vite** (v7.1.9): Lightning-fast build tool with HMR
- **React** (v19.2.0): For building interactive block editor components
- **Sass**: CSS preprocessing
- **PostCSS + Autoprefixer**: CSS post-processing
- **Custom Vite Plugins**:
  - `wrapInIIFE()`: Converts ES modules to WordPress-compatible IIFE format
  - `placeCssWithEntry()`: Co-locates CSS with JS bundles
  - `copyBlockJson()`: Handles WordPress block metadata and generates `.asset.php` files

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

### 1. **Vite + WordPress Integration**
The Aquila theme demonstrates how to use Vite (a modern, fast build tool) with WordPress:

```javascript
// Custom Vite plugin wraps ES modules in IIFE for WordPress compatibility
function wrapInIIFE() {
  // Converts: import { registerBlockType } from '@wordpress/blocks'
  // To: const { registerBlockType } = wp.blocks
}
```

**Benefits:**
- ⚡ Instant HMR (Hot Module Replacement)
- 📦 Optimized production builds
- 🔧 Modern JavaScript (ES2020+)
- 🎨 SCSS/PostCSS support

### 2. **Monorepo with PNPM Workspaces**
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

### 3. **Custom Gutenberg Blocks**
Both theme and plugin include custom blocks:

**Aquila Theme Blocks:**
- `aquila/notice`: Server-side rendered notice block
- `aquila/todo-list`: Interactive todo list block

**Features:**
- ✅ Server-side rendering with `render.php`
- ✅ RichText editing with WordPress block editor
- ✅ Custom attributes and supports
- ✅ Automatic dependency injection via `.asset.php`

### 4. **Asset Management**
Sophisticated asset handling system:

```php
// Automatic .asset.php generation by Vite
<?php return array(
  'dependencies' => array('wp-blocks', 'wp-i18n', 'wp-block-editor', 'react-jsx-runtime'),
  'version' => 'mh8azskx'
);
```

**Features:**
- 📝 Auto-generated dependency manifests
- 🔄 Version hashing for cache busting
- 🎯 Scoped CSS per component/block
- 📦 Code splitting and lazy loading

## 📁 Directory Structure

```
wp-content/
├── package.json              # Root workspace config
├── pnpm-workspace.yaml       # PNPM workspace definition
│
├── themes/
│   └── aquila/              # Custom theme with Vite
│       ├── src/
│       │   ├── blocks/      # Custom Gutenberg blocks
│       │   ├── components/  # Reusable components
│       │   ├── style.scss   # Main stylesheet
│       │   └── index.js     # Entry point
│       ├── build/           # Compiled assets
│       ├── inc/             # PHP classes (OOP)
│       ├── vite.config.js   # Vite configuration
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
pnpm run build --watch
```

3. **Production build:**
```bash
# Build all workspaces
pnpm build

# Or build specific theme
cd themes/aquila
pnpm run build
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

# Development with watch mode( Run from the root )
pnpm dev

# Production build
pnpm build

# Linting
pnpm lint

# Format code
pnpm format
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
  "render": "file:./render.php"
}
```

### 3. Vite Auto-handles:
- ✅ Compiles JSX to JavaScript
- ✅ Processes SCSS to CSS
- ✅ Generates `.asset.php` with dependencies
- ✅ Copies `block.json` and `render.php` to build
- ✅ Wraps code in WordPress-compatible IIFE

## 🔍 Key Differences: Vite vs @wordpress/scripts

| Feature | Vite (Aquila) | @wordpress/scripts (Plugin) |
|---------|---------------|----------------------------|
| **Speed** | ⚡ Extremely fast (ESBuild) | 🐢 Slower (Webpack) |
| **HMR** | ✅ Instant | ⏱️ Slower |
| **Config** | Custom `vite.config.js` | Minimal config needed |
| **Output** | ES modules → IIFE (custom) | IIFE (automatic) |
| **Asset Files** | Custom plugin generates | Automatic |
| **Learning Curve** | Steeper (custom setup) | Easier (WordPress standard) |

## 🏆 Best Practices Demonstrated

1. **Separation of Concerns**: PHP classes in `/inc`, JS/CSS in `/src`
2. **Namespacing**: PHP namespaces (`Aquila\Theme`)
3. **Singleton Pattern**: For theme initialization
4. **Server-side Rendering**: Dynamic blocks with `render.php`
5. **Asset Optimization**: Code splitting, minification, tree-shaking
6. **Type Safety**: JSDoc comments, PHP type hints
7. **Monorepo Benefits**: Shared dependencies, consistent tooling

## 📚 Additional Resources

- [Vite Documentation](https://vitejs.dev/)
- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [PNPM Workspaces](https://pnpm.io/workspaces)

## 🤝 Contributing

This is an example project demonstrating modern WordPress development practices. Feel free to use it as a reference or starting point for your own projects.

## 📝 License

GPL-3.0-or-later (WordPress compatible)

---

**Built with ❤️ using modern web technologies and WordPress**

