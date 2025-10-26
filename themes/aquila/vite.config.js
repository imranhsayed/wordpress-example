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
		for (const dir of fs.readdirSync(blocksDir)) {
			const possibleFiles = ['index.js', 'index.jsx', 'index.ts', 'index.tsx'];
			for (const file of possibleFiles) {
				const entry = path.resolve(blocksDir, dir, file);
				if (fs.existsSync(entry)) {
					entries[`blocks/${dir}/index`] = entry;
					break;
				}
			}
		}
	}
	
	// --- Global entry ---
	entries['index'] = path.resolve(__dirname, 'src/index.js');
	
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
				'react': 'React',
				'react-dom': 'ReactDOM',
				'react/jsx-runtime': 'ReactJSXRuntime',
			};

			for (const [fileName, chunk] of Object.entries(bundle)) {
				if (chunk.type === 'chunk' && chunk.isEntry) {
					let code = chunk.code;
					
					// Replace ES module imports with WordPress globals
					for (const [module, global] of Object.entries(wpGlobals)) {
						const importRegex = new RegExp(`import\\s*{([^}]+)}\\s*from\\s*['"]${module.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}['"];?`, 'g');
						code = code.replace(importRegex, (match, imports) => {
							const parts = imports.split(',').map(i => i.trim());
							const destructure = parts.map(p => {
								const [imported, alias] = p.split(' as ').map(s => s.trim());
								return alias ? `${imported}: ${alias}` : imported;
							}).join(', ');
							return `const { ${destructure} } = ${global};`;
						});
					}
					
					// Wrap in IIFE
					chunk.code = `(function() {\n'use strict';\n${code}\n})();`;
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
			// Copy block.json files for blocks and generate .asset.php
			const blocksDir = path.resolve(__dirname, 'src/blocks');
			if (fs.existsSync(blocksDir)) {
				for (const dir of fs.readdirSync(blocksDir)) {
					const srcBlockJson = path.resolve(blocksDir, dir, 'block.json');
					const destBlockJson = path.resolve(__dirname, 'build/blocks', dir, 'block.json');
					
					if (fs.existsSync(srcBlockJson)) {
						// Ensure destination directory exists
						const destDir = path.dirname(destBlockJson);
						if (!fs.existsSync(destDir)) {
							fs.mkdirSync(destDir, { recursive: true });
						}
						
						// Copy the file
						fs.copyFileSync(srcBlockJson, destBlockJson);
						console.log(`✓ Copied block.json for ${dir}`);
					}
					
					// Also copy render.php if it exists
					const srcRenderPhp = path.resolve(blocksDir, dir, 'render.php');
					const destRenderPhp = path.resolve(__dirname, 'build/blocks', dir, 'render.php');
					
					if (fs.existsSync(srcRenderPhp)) {
						fs.copyFileSync(srcRenderPhp, destRenderPhp);
						console.log(`✓ Copied render.php for ${dir}`);
					}
					
					// Generate .asset.php file for the block
					const blockIndexJs = `blocks/${dir}/index.js`;
					if (bundle[blockIndexJs]) {
						const chunk = bundle[blockIndexJs];
						
						// Read ALL source files in the block directory to detect imports
						const blockSrcDir = path.resolve(blocksDir, dir);
						let allSourceCode = '';
						
						// Read all .js, .jsx, .ts, .tsx files in the block directory
						if (fs.existsSync(blockSrcDir)) {
							const files = fs.readdirSync(blockSrcDir);
							for (const file of files) {
								if (/\.(js|jsx|ts|tsx)$/.test(file)) {
									const filePath = path.resolve(blockSrcDir, file);
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
						const assetPhpPath = path.resolve(__dirname, 'build/blocks', dir, 'index.asset.php');
						fs.writeFileSync(assetPhpPath, assetPhpContent);
						console.log(`✓ Generated index.asset.php for ${dir} with dependencies: [${depsArray.join(', ')}]`);
					}
				}
			}
		},
	};
}

export default defineConfig( {
	plugins: [
		react( {
			include: '**/*.{js,jsx,ts,tsx}', // <— enable JSX transform for .js files too
		} ),
		wrapInIIFE(), // Convert ES modules to IIFE with WordPress globals
		placeCssWithEntry(),
		copyBlockJson(),
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
				},
			},
		},
	},
	css: {
		postcss: './postcss.config.js',
		preprocessorOptions: {
			scss: { api: 'modern' },
		},
	},
	resolve: { alias: { '@': path.resolve( __dirname, './src' ) } },
} );
