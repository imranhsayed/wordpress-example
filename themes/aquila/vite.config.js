import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import fs from 'fs';

// --- discover entries for components & blocks ---
function getEntries() {
	const entries = {};
	
	// --- Components ---
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
	
	// --- Blocks ---
	const blocksDir = path.resolve(__dirname, 'src/blocks');
	if (fs.existsSync(blocksDir)) {
		// Recursively scan for blocks
		const scanBlocks = (dir, basePath = '') => {
			for (const item of fs.readdirSync(dir)) {
				const itemPath = path.resolve(dir, item);
				const stat = fs.statSync(itemPath);

				if (stat.isDirectory()) {
					// Check if this directory has an index file (is a block)
					const possibleFiles = ['index.js', 'index.jsx', 'index.ts', 'index.tsx'];
					let foundEntry = false;

					for (const file of possibleFiles) {
						const entry = path.resolve(itemPath, file);
						if (fs.existsSync(entry)) {
							const entryKey = basePath ? `blocks/${basePath}/${item}/index` : `blocks/${item}/index`;
							entries[entryKey] = entry;
							foundEntry = true;
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
	
	// --- Global entry ---
	entries['index'] = path.resolve(__dirname, 'src/index.js');

	// --- SCSS files via JS wrappers ---
	const scssDir = path.resolve(__dirname, 'src/scss');
	const jsWrappersDir = path.resolve(__dirname, 'src/js');

	// Ensure js directory exists
	if (!fs.existsSync(jsWrappersDir)) {
		fs.mkdirSync(jsWrappersDir, { recursive: true });
	}

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

	return entries;
}


// --- place each entry's CSS next to its JS (style.css, style2.css, ...)
function placeCssWithEntry() {
	return {
		name: 'place-css-with-entry',
		apply: 'build',
		generateBundle( options, bundle ) {
			// walk all output chunks
			for( const [ jsFileName, chunk ] of Object.entries( bundle ) ) {
				if ( chunk.type !== 'chunk' || ! chunk.isEntry ) continue;

				// Skip SCSS entries (css/* entries) - their CSS should stay in css/ folder with original names
				if ( jsFileName.startsWith( 'css/' ) ) continue;

				// vite adds metadata listing css assets this chunk imported
				const meta = chunk.viteMetadata;
				if ( ! meta || ! meta.importedCss || meta.importedCss.size === 0 ) continue;

				const jsDir = path.posix.dirname( jsFileName ); // use posix paths
				let idx = 0;

				for( const cssAssetName of meta.importedCss ) {
					const cssAsset = bundle[ cssAssetName ];
					if ( ! cssAsset ) continue;

					// first CSS -> style.css, additional ones -> style2.css, style3.css...
					const targetBase = idx === 0 ? 'style.css' : `style${ idx + 1 }.css`;
					const targetName = jsDir === '.' ? targetBase : `${ jsDir }/${ targetBase }`;

					// reassign and move
					cssAsset.fileName = targetName;
					bundle[ targetName ] = cssAsset;
					delete bundle[ cssAssetName ];

					idx++;
				}
			}
		},
	};
}

// --- wrap ES modules in IIFE for WordPress compatibility
function wrapInIIFE() {
	return {
		name: 'wrap-in-iife',
		apply: 'build',
		generateBundle(options, bundle) {
			// WordPress global mappings
			const wpGlobals = {
				'@wordpress/blocks': 'wp.blocks',
				'@wordpress/i18n': 'wp.i18n',
				'@wordpress/block-editor': 'wp.blockEditor',
				'@wordpress/components': 'wp.components',
				'@wordpress/data': 'wp.data',
				'@wordpress/element': 'wp.element',
				'@wordpress/api-fetch': 'wp.apiFetch',
				'@wordpress/hooks': 'wp.hooks',
				'@wordpress/dom-ready': 'wp.domReady',
				'@wordpress/server-side-render': 'wp.serverSideRender',
				'@wordpress/core-data': 'wp.coreData',
				'react': 'React',
				'react-dom': 'ReactDOM',
				'react/jsx-runtime': 'ReactJSXRuntime',
			};

			for (const [fileName, chunk] of Object.entries(bundle)) {
				if (chunk.type === 'chunk') {
					let code = chunk.code;

					// Replace ES module imports with WordPress globals
					for (const [module, global] of Object.entries(wpGlobals)) {
						// Handle named imports: import { foo, bar } from 'module'
						const namedImportRegex = new RegExp(`import\\s*{([^}]+)}\\s*from\\s*['"]${module.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}['"];?`, 'g');
						code = code.replace(namedImportRegex, (match, imports) => {
							const parts = imports.split(',').map(i => i.trim());
							const destructure = parts.map(p => {
								const [imported, alias] = p.split(' as ').map(s => s.trim());
								return alias ? `${imported}: ${alias}` : imported;
							}).join(', ');
							return `const { ${destructure} } = ${global};`;
						});

						// Handle default imports: import Foo from 'module'
						const defaultImportRegex = new RegExp(`import\\s+(\\w+)\\s+from\\s*['"]${module.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}['"];?`, 'g');
						code = code.replace(defaultImportRegex, (match, varName) => {
							return `const ${varName} = ${global};`;
						});
					}

					// Wrap in IIFE only for entry chunks
					if (chunk.isEntry) {
						chunk.code = `(function() {\n'use strict';\n${code}\n})();`;
					} else {
						chunk.code = code;
					}
				}
			}
		},
	};
}

// --- watch and copy PHP files during dev/watch mode (similar to CopyWebpackPlugin)
// Uses Rollup's native watch system via addWatchFile() + watchChange()
function watchPhpFiles() {
	const srcDir = path.resolve(__dirname, 'src');
	const buildDir = path.resolve(__dirname, 'build');
	let isWatchMode = false;

	// Copy PHP file to build directory maintaining structure
	const copyPhpFile = (srcPath) => {
		try {
			const relativePath = path.relative(srcDir, srcPath);
			const destPath = path.resolve(buildDir, relativePath);
			const destDir = path.dirname(destPath);

			// Ensure destination directory exists
			if (!fs.existsSync(destDir)) {
				fs.mkdirSync(destDir, { recursive: true });
			}

			// Copy the file
			fs.copyFileSync(srcPath, destPath);
			console.log(`✓ [watch-php] Copied ${relativePath}`);
		} catch (error) {
			console.error(`[watch-php] Error copying file:`, error);
		}
	};

	// Delete PHP file from build directory
	const deletePhpFile = (srcPath) => {
		try {
			const relativePath = path.relative(srcDir, srcPath);
			const destPath = path.resolve(buildDir, relativePath);
			if (fs.existsSync(destPath)) {
				fs.unlinkSync(destPath);
				console.log(`✓ [watch-php] Deleted ${relativePath}`);
			}
		} catch (error) {
			console.error(`[watch-php] Error deleting file:`, error);
		}
	};

	// Copy all existing PHP files initially
	const copyAllPhpFiles = (dir) => {
		if (!fs.existsSync(dir)) return;
		
		const items = fs.readdirSync(dir);
		for (const item of items) {
			const itemPath = path.resolve(dir, item);
			const stat = fs.statSync(itemPath);

			if (stat.isDirectory()) {
				copyAllPhpFiles(itemPath);
			} else if (item.endsWith('.php')) {
				// Calculate relative path from srcDir
				const relativePath = path.relative(srcDir, itemPath);
				const destPath = path.resolve(buildDir, relativePath);
				const destDir = path.dirname(destPath);

				if (!fs.existsSync(destDir)) {
					fs.mkdirSync(destDir, { recursive: true });
				}

				fs.copyFileSync(itemPath, destPath);
				console.log(`✓ [watch-php] Initial copy: ${relativePath}`);
			}
		}
	};

	// Recursively add all PHP files to Rollup's watch list
	const addPhpFilesToWatch = (dir, pluginContext) => {
		if (!fs.existsSync(dir)) return;
		
		const items = fs.readdirSync(dir);
		for (const item of items) {
			const itemPath = path.resolve(dir, item);
			const stat = fs.statSync(itemPath);

			if (stat.isDirectory()) {
				addPhpFilesToWatch(itemPath, pluginContext);
			} else if (item.endsWith('.php')) {
				try {
					// Register PHP file with Rollup's watch system
					// This is what makes watchChange() fire when files change
					pluginContext.addWatchFile(itemPath);
				} catch (error) {
					// Ignore errors if watch isn't available (non-watch mode)
				}
			}
		}
	};

	return {
		name: 'watch-php-files',
		buildStart(options) {
			isWatchMode = process.argv.includes('--watch');

			if (isWatchMode) {
				console.log(`[watch-php] Initializing PHP file watcher (using Rollup's watch system)...`);
				console.log(`[watch-php] Source: ${srcDir}`);
				console.log(`[watch-php] Destination: ${buildDir}`);

				// Register all PHP files with Rollup's watch system
				addPhpFilesToWatch(srcDir, this);
				console.log(`👁️  [watch-php] All PHP files registered with Rollup's watch system`);
			}
		},
		writeBundle() {
			// Copy PHP files after build completes (after emptyOutDir has cleared the directory)
			// This works for both watch and build modes
			console.log(`[watch-php] Copying PHP files to build directory...`);
			console.log(`[watch-php] Source: ${srcDir}`);
			console.log(`[watch-php] Destination: ${buildDir}`);
			copyAllPhpFiles(srcDir);
			console.log(`✓ [watch-php] PHP files copied to build directory`);
		},
		watchChange(id, change) {
			// This hook fires when ANY file in Rollup's watch list changes
			// We registered PHP files via addWatchFile(), so this fires when they change
			if (isWatchMode && id && id.endsWith('.php') && id.startsWith(srcDir)) {
				if (change.event === 'update' || change.event === 'create') {
					console.log(`[watch-php] File changed: ${path.relative(srcDir, id)}`);
					copyPhpFile(id);
				} else if (change.event === 'delete') {
					console.log(`[watch-php] File deleted: ${path.relative(srcDir, id)}`);
					deletePhpFile(id);
				}
			}
		},
	};
}

// --- copy block.json files to build directory and generate .asset.php files
function copyBlockJson() {
	return {
		name: 'copy-block-json',
		apply: 'build',
		writeBundle(options, bundle) {
			// Helper function to process a single block
			const processBlock = (blockPath, relativePath) => {
				const srcBlockJson = path.resolve(blockPath, 'block.json');
				const destBlockJson = path.resolve(__dirname, 'build/blocks', relativePath, 'block.json');

				if (fs.existsSync(srcBlockJson)) {
					// Ensure destination directory exists
					const destDir = path.dirname(destBlockJson);
					if (!fs.existsSync(destDir)) {
						fs.mkdirSync(destDir, { recursive: true });
					}

					// Copy the file
					fs.copyFileSync(srcBlockJson, destBlockJson);
					console.log(`✓ Copied block.json for ${relativePath}`);
				}

				// Also copy render.php if it exists
				const srcRenderPhp = path.resolve(blockPath, 'render.php');
				const destRenderPhp = path.resolve(__dirname, 'build/blocks', relativePath, 'render.php');

				if (fs.existsSync(srcRenderPhp)) {
					fs.copyFileSync(srcRenderPhp, destRenderPhp);
					console.log(`✓ Copied render.php for ${relativePath}`);
				}

				// Generate .asset.php file for the block
				const blockIndexJs = `blocks/${relativePath}/index.js`;
				if (bundle[blockIndexJs]) {
					// Read ALL source files in the block directory to detect imports
					let allSourceCode = '';

					// Read all .js, .jsx, .ts, .tsx files in the block directory
					if (fs.existsSync(blockPath)) {
						const files = fs.readdirSync(blockPath);
						for (const file of files) {
							if (/\.(js|jsx|ts|tsx)$/.test(file)) {
								const filePath = path.resolve(blockPath, file);
								allSourceCode += fs.readFileSync(filePath, 'utf-8') + '\n';
							}
						}
					}

					// Map of external modules to their WordPress handles
					const wpDependencies = {
						'@wordpress/blocks': 'wp-blocks',
						'@wordpress/i18n': 'wp-i18n',
						'@wordpress/block-editor': 'wp-block-editor',
						'@wordpress/components': 'wp-components',
						'@wordpress/data': 'wp-data',
						'@wordpress/element': 'wp-element',
						'@wordpress/api-fetch': 'wp-api-fetch',
						'@wordpress/hooks': 'wp-hooks',
						'@wordpress/dom-ready': 'wp-dom-ready',
						'@wordpress/server-side-render': 'wp-server-side-render',
						'@wordpress/core-data': 'wp-core-data',
					};

					const dependencies = new Set();

					// Detect dependencies from all source code
					for (const [module, handle] of Object.entries(wpDependencies)) {
						if (allSourceCode.includes(`from '${module}'`) ||
						    allSourceCode.includes(`from "${module}"`)) {
							dependencies.add(handle);
						}
					}

					// Always include react-jsx-runtime for JSX
					dependencies.add('react-jsx-runtime');

					// Convert Set to sorted array
					const depsArray = Array.from(dependencies).sort();

					// Generate a version hash based on file modification time
					const version = Date.now().toString(36);

					// Create .asset.php content
					const assetPhpContent = `<?php return array('dependencies' => array(${depsArray.map(d => `'${d}'`).join(', ')}), 'version' => '${version}');\n`;

					// Write .asset.php file
					const assetPhpPath = path.resolve(__dirname, 'build/blocks', relativePath, 'index.asset.php');
					fs.writeFileSync(assetPhpPath, assetPhpContent);
					console.log(`✓ Generated index.asset.php for ${relativePath} with dependencies: [${depsArray.join(', ')}]`);
				}
			};

			// Recursively scan for blocks
			const blocksDir = path.resolve(__dirname, 'src/blocks');
			if (fs.existsSync(blocksDir)) {
				const scanBlocks = (dir, basePath = '') => {
					for (const item of fs.readdirSync(dir)) {
						const itemPath = path.resolve(dir, item);
						const stat = fs.statSync(itemPath);

						if (stat.isDirectory()) {
							const relativePath = basePath ? `${basePath}/${item}` : item;

							// Check if this directory has a block.json (is a block)
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
		},
	};
}

// --- cleanup SCSS entry JS files and move CSS to css/ folder
function cleanupScssEntries() {
	return {
		name: 'cleanup-scss-entries',
		apply: 'build',
		generateBundle(options, bundle) {
			const toDelete = [];
			const toRename = [];

			// Get list of SCSS file names (without extension) from src/scss
			const scssDir = path.resolve(__dirname, 'src/scss');
			const scssFileNames = new Set();
			if (fs.existsSync(scssDir)) {
				for (const file of fs.readdirSync(scssDir)) {
					if (file.endsWith('.scss') && !file.startsWith('_')) {
						scssFileNames.add(file.replace('.scss', ''));
					}
				}
			}

			for (const [fileName, asset] of Object.entries(bundle)) {
				// Delete JS files from css/ folder (these are from scss-entries)
				if (fileName.startsWith('css/') && fileName.endsWith('.js')) {
					toDelete.push(fileName);
				}

				// Move CSS files generated from SCSS entries to css/ folder
				if (asset.type === 'asset' && fileName.endsWith('.css')) {
					const baseName = path.basename(fileName, '.css');
					// Check if this CSS file corresponds to an SCSS file
					if (scssFileNames.has(baseName) && !fileName.startsWith('css/')) {
						toRename.push({ from: fileName, to: `css/${fileName}` });
					}
				}
			}

			// Delete JS files
			for (const fileName of toDelete) {
				delete bundle[fileName];
			}

			// Rename/move CSS files
			for (const { from, to } of toRename) {
				const asset = bundle[from];
				asset.fileName = to;
				bundle[to] = asset;
				delete bundle[from];
			}

			if (toDelete.length > 0) {
				console.log(`✓ Cleaned up ${toDelete.length} SCSS entry JS file(s)`);
			}
			if (toRename.length > 0) {
				console.log(`✓ Moved ${toRename.length} CSS file(s) to css/ folder`);
			}
		},
	};
}

export default defineConfig( {
	plugins: [
		react( {
			include: '**/*.{js,jsx,ts,tsx}', // <— enable JSX transform for .js files too
		} ),
		watchPhpFiles(), // Watch and copy PHP files during dev mode
		wrapInIIFE(), // Convert ES modules to IIFE with WordPress globals
		placeCssWithEntry(),
		copyBlockJson(),
		cleanupScssEntries(), // Remove empty JS files from SCSS entries
	],
	build: {
		outDir: 'build',
		emptyOutDir: true,
		cssCodeSplit: true,
		rollupOptions: {
			input: getEntries(),
			external: [
				'react',
				'react-dom',
				'react/jsx-runtime',
				'@wordpress/element',
				'@wordpress/i18n',
				'@wordpress/components',
				'@wordpress/block-editor',
				'@wordpress/blocks',
				'@wordpress/data',
				'@wordpress/api-fetch',
				'@wordpress/hooks',
				'@wordpress/dom-ready',
				'@wordpress/server-side-render',
				'@wordpress/core-data',
			],
			output: {
				format: 'es', // ES modules format
				entryFileNames: ( chunk ) => `${ chunk.name }.js`,
				assetFileNames: `[name][extname]`,
				// Preserve module structure for WordPress
				preserveModules: false,
				// Use paths to map WordPress globals
				paths: {
					'react': 'react',
					'react-dom': 'react-dom',
					'react/jsx-runtime': 'react/jsx-runtime',
					'@wordpress/element': '@wordpress/element',
					'@wordpress/i18n': '@wordpress/i18n',
					'@wordpress/components': '@wordpress/components',
					'@wordpress/block-editor': '@wordpress/block-editor',
					'@wordpress/blocks': '@wordpress/blocks',
					'@wordpress/data': '@wordpress/data',
					'@wordpress/api-fetch': '@wordpress/api-fetch',
					'@wordpress/hooks': '@wordpress/hooks',
					'@wordpress/dom-ready': '@wordpress/dom-ready',
					'@wordpress/server-side-render': '@wordpress/server-side-render',
					'@wordpress/core-data': '@wordpress/core-data',
				},
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
	resolve: { alias: { '@': path.resolve( __dirname, './src' ) } },
} );
