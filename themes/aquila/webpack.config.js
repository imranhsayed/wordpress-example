/**
 * External dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const fs = require( 'fs' );

/**
 * Discover entries for components & blocks
 */
function getEntries() {
	// Initialize.
	const entries = {};
	
	// Components.
	const componentsDir = path.resolve( __dirname, 'src/components' );
	
	// Check if components directory exists.
	if ( fs.existsSync( componentsDir ) ) {
		for( const dir of fs.readdirSync( componentsDir ) ) {
			const possibleFiles = [
				'index.js',
				'index.jsx',
				'index.ts',
				'index.tsx',
			];
			for( const file of possibleFiles ) {
				const entry = path.resolve( componentsDir, dir, file );
				if ( fs.existsSync( entry ) ) {
					entries[ `components/${ dir }/index` ] = entry;
					break;
				}
			}
		}
	}
	
	// --- Blocks ---
	const blocksDir = path.resolve( __dirname, 'src/blocks' );
	if ( fs.existsSync( blocksDir ) ) {
		// Recursively scan for blocks
		const scanBlocks = ( dir, basePath = '' ) => {
			for( const item of fs.readdirSync( dir ) ) {
				const itemPath = path.resolve( dir, item );
				const stat = fs.statSync( itemPath );
				
				if ( stat.isDirectory() ) {
					// Check if this directory has an index file (is a block)
					const possibleIndexFiles = [
						'index.js',
						'index.jsx',
						'index.ts',
						'index.tsx',
					];
					
					for( const file of possibleIndexFiles ) {
						const entry = path.resolve( itemPath, file );
						if ( fs.existsSync( entry ) ) {
							const entryKey = basePath
								? `blocks/${ basePath }/${ item }/index`
								: `blocks/${ item }/index`;
							entries[ entryKey ] = entry;
							break;
						}
					}
					
					// Also check for view.js file (frontend script for blocks)
					const possibleViewFiles = [
						'view.js',
						'view.jsx',
						'view.ts',
						'view.tsx',
					];
					for( const file of possibleViewFiles ) {
						const viewEntry = path.resolve( itemPath, file );
						if ( fs.existsSync( viewEntry ) ) {
							const viewEntryKey = basePath
								? `blocks/${ basePath }/${ item }/view`
								: `blocks/${ item }/view`;
							entries[ viewEntryKey ] = viewEntry;
							break;
						}
					}
					
					// Recursively scan subdirectories
					const newBasePath = basePath ? `${ basePath }/${ item }` : item;
					scanBlocks( itemPath, newBasePath );
				}
			}
		};
		
		scanBlocks( blocksDir );
	}
	
	// --- Global entry ---
	const globalEntry = path.resolve( __dirname, 'src/index.js' );
	if ( fs.existsSync( globalEntry ) ) {
		entries.index = globalEntry;
	}
	
	// --- SCSS files via JS wrappers ---
	const scssDir = path.resolve( __dirname, 'src/scss' );
	const jsWrappersDir = path.resolve( __dirname, 'src/js' );
	
	// Ensure js directory exists
	if ( ! fs.existsSync( jsWrappersDir ) ) {
		fs.mkdirSync( jsWrappersDir, { recursive: true } );
	}
	
	if ( fs.existsSync( scssDir ) ) {
		for( const file of fs.readdirSync( scssDir ) ) {
			// Only include .scss files that don't start with underscore (exclude partials)
			if ( file.endsWith( '.scss' ) && ! file.startsWith( '_' ) ) {
				const jsWrapperName = file.replace( '.scss', '.js' );
				const jsWrapperPath = path.resolve(
					jsWrappersDir,
					jsWrapperName,
				);
				
				// Create JS wrapper if it doesn't exist
				if ( ! fs.existsSync( jsWrapperPath ) ) {
					const wrapperContent = `// Auto-generated wrapper to compile ${ file }\nimport '../scss/${ file }';\n`;
					fs.writeFileSync( jsWrapperPath, wrapperContent );
				}
				
				// Add as entry - note: webpack will output to css/ folder via custom output configuration
				const entryKey = `css/${ file.replace( '.scss', '' ) }`;
				entries[ entryKey ] = jsWrapperPath;
			}
		}
	}
	
	return entries;
}

/**
 * Custom plugin to copy PHP files from src to build
 */
class CopyPhpFilesPlugin {
	apply( compiler ) {
		compiler.hooks.afterEmit.tap( 'CopyPhpFilesPlugin', () => {
			const srcDir = path.resolve( __dirname, 'src' );
			const buildDir = path.resolve( __dirname, 'build' );
			
			const copyPhpFiles = ( dir ) => {
				if ( ! fs.existsSync( dir ) ) {
					return;
				}
				
				const items = fs.readdirSync( dir );
				for( const item of items ) {
					const itemPath = path.resolve( dir, item );
					const stat = fs.statSync( itemPath );
					
					if ( stat.isDirectory() ) {
						copyPhpFiles( itemPath );
					} else if ( item.endsWith( '.php' ) ) {
						const relativePath = path.relative( srcDir, itemPath );
						const destPath = path.resolve( buildDir, relativePath );
						const destDir = path.dirname( destPath );
						
						if ( ! fs.existsSync( destDir ) ) {
							fs.mkdirSync( destDir, { recursive: true } );
						}
						
						fs.copyFileSync( itemPath, destPath );
					}
				}
			};
			
			// eslint-disable-next-line no-console
			console.log( '[copy-php] Copying PHP files...' );
			copyPhpFiles( srcDir );
			// eslint-disable-next-line no-console
			console.log( '[copy-php] ✓ PHP files copied' );
		} );
	}
}

/**
 * Custom plugin to copy block.json and generate .asset.php files
 */

/* eslint-disable no-console */
class BlockAssetsPlugin {
	apply( compiler ) {
		compiler.hooks.afterEmit.tap( 'BlockAssetsPlugin', () => {
			const processBlock = ( blockPath, relativePath ) => {
				const srcBlockJson = path.resolve( blockPath, 'block.json' );
				const destBlockJson = path.resolve(
					__dirname,
					'build/blocks',
					relativePath,
					'block.json',
				);
				
				if ( fs.existsSync( srcBlockJson ) ) {
					const destDir = path.dirname( destBlockJson );
					if ( ! fs.existsSync( destDir ) ) {
						fs.mkdirSync( destDir, { recursive: true } );
					}
					fs.copyFileSync( srcBlockJson, destBlockJson );
					console.log( `✓ Copied block.json for ${ relativePath }` );
				}
				
				// Copy render.php if it exists
				const srcRenderPhp = path.resolve( blockPath, 'render.php' );
				const destRenderPhp = path.resolve(
					__dirname,
					'build/blocks',
					relativePath,
					'render.php',
				);
				
				if ( fs.existsSync( srcRenderPhp ) ) {
					fs.copyFileSync( srcRenderPhp, destRenderPhp );
					console.log( `✓ Copied render.php for ${ relativePath }` );
				}
				
				// Generate .asset.php file
				const assetPhpPath = path.resolve(
					__dirname,
					'build/blocks',
					relativePath,
					'index.asset.php',
				);
				
				// Check if webpack already generated it (via DependencyExtractionWebpackPlugin)
				if ( fs.existsSync( assetPhpPath ) ) {
					console.log(
						`✓ index.asset.php already exists for ${ relativePath }`,
					);
				}
			};
			
			// Scan for blocks
			const blocksDir = path.resolve( __dirname, 'src/blocks' );
			if ( fs.existsSync( blocksDir ) ) {
				const scanBlocks = ( dir, basePath = '' ) => {
					for( const item of fs.readdirSync( dir ) ) {
						const itemPath = path.resolve( dir, item );
						const stat = fs.statSync( itemPath );
						
						if ( stat.isDirectory() ) {
							const relativePath = basePath
								? `${ basePath }/${ item }`
								: item;
							
							if (
								fs.existsSync(
									path.resolve( itemPath, 'block.json' ),
								)
							) {
								processBlock( itemPath, relativePath );
							}
							
							scanBlocks( itemPath, relativePath );
						}
					}
				};
				
				scanBlocks( blocksDir );
			}
		} );
	}
}

/* eslint-enable no-console */

/**
 * Custom plugin to clean up SCSS entry JS files
 */

/* eslint-disable no-console */
class CleanupScssEntriesPlugin {
	apply( compiler ) {
		compiler.hooks.afterEmit.tap(
			'CleanupScssEntriesPlugin',
			( compilation ) => {
				const outputPath = compilation.outputOptions.path;
				const cssDir = path.resolve( outputPath, 'css' );
				
				if ( fs.existsSync( cssDir ) ) {
					const files = fs.readdirSync( cssDir );
					let deletedCount = 0;
					
					files.forEach( ( file ) => {
						if ( file.endsWith( '.js' ) ) {
							const filePath = path.resolve( cssDir, file );
							fs.unlinkSync( filePath );
							deletedCount++;
						}
					} );
					
					if ( deletedCount > 0 ) {
						console.log(
							`✓ Cleaned up ${ deletedCount } SCSS entry JS file(s)`,
						);
					}
				}
			},
		);
	}
}

/* eslint-enable no-console */

/**
 * Custom plugin to rename index.css to style.css for blocks
 * Uses webpack's compilation assets to rename before writing to disk
 */

/* eslint-disable no-console */
class RenameBlockCssPlugin {
	apply( compiler ) {
		compiler.hooks.compilation.tap(
			'RenameBlockCssPlugin',
			( compilation ) => {
				compilation.hooks.processAssets.tap(
					{
						name: 'RenameBlockCssPlugin',
						// Run after assets are optimized but before they're emitted
						stage: compilation.PROCESS_ASSETS_STAGE_OPTIMIZE_TRANSFER,
					},
					( assets ) => {
						// Get list of assets to rename
						const assetsToRename = [];
						
						for( const assetName in assets ) {
							// Only rename CSS files in blocks/ directory
							if (
								assetName.startsWith( 'blocks/' ) &&
								( assetName.includes( '/index.css' ) ||
									assetName.includes( '/index-rtl.css' ) )
							) {
								assetsToRename.push( assetName );
							}
						}
						
						// Rename assets in webpack's compilation object (before writing to disk)
						for( const oldName of assetsToRename ) {
							const newName = oldName
								.replace( '/index.css', '/style.css' )
								.replace( '/index-rtl.css', '/style-rtl.css' );
							
							// Move the asset to the new name
							compilation.emitAsset( newName, assets[ oldName ] );
							
							// Delete the old asset name
							compilation.deleteAsset( oldName );
						}
						
						if ( assetsToRename.length > 0 ) {
							console.log(
								`✓ Renamed ${ assetsToRename.length } block CSS files: index.css → style.css`,
							);
						}
					},
				);
			},
		);
	}
}

/* eslint-enable no-console */

// Get all entries
const entries = getEntries();

module.exports = {
	...defaultConfig,
	entry: entries,
	output: {
		path: path.resolve( __dirname, 'build' ),
		filename: '[name].js',
		clean: true,
	},
	optimization: {
		...defaultConfig.optimization,
		// Disable code splitting to match Vite's manualChunks: undefined
		splitChunks: false,
	},
	externals: defaultConfig.externals,
	plugins: [
		...defaultConfig.plugins,
		new CopyPhpFilesPlugin(),
		new BlockAssetsPlugin(),
		new CleanupScssEntriesPlugin(),
		new RenameBlockCssPlugin(),
	],
	resolve: {
		...defaultConfig.resolve,
		alias: {
			'@': path.resolve( __dirname, './src' ),
		},
	},
	module: {
		...defaultConfig.module,
		rules: [
			// Filter out the default SVG rule from @wordpress/scripts
			...defaultConfig.module.rules.filter( ( rule ) => {
				// Remove the default file-loader rule for SVGs
				if ( rule.test && rule.test.toString().includes( 'svg' ) ) {
					return false;
				}
				return true;
			} ),
			// Handle SVG imports as React components
			{
				test: /\.svg$/,
				issuer: /\.(js|jsx|ts|tsx)$/,
				use: [ '@svgr/webpack' ],
			},
		],
	},
};
