/**
 * External dependencies
 */
const path = require( 'path' );
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' ); // eslint-disable-line import/no-extraneous-dependencies
const WebpackWatchedGlobEntries = require( 'webpack-watched-glob-entries-plugin' ); // eslint-disable-line import/no-extraneous-dependencies

/**
 * WordPress dependencies
 */
const { getAsBooleanFromENV } = require( '@wordpress/scripts/utils' );

const hasExperimentalModulesFlag = getAsBooleanFromENV(
	'WP_EXPERIMENTAL_MODULES',
);

let scriptConfig, moduleConfig;

if ( hasExperimentalModulesFlag ) {
	[
		scriptConfig,
		moduleConfig,
	] = require( '@wordpress/scripts/config/webpack.config' );
} else {
	scriptConfig = require( '@wordpress/scripts/config/webpack.config' );
}

// Extend the default config.
const sharedConfig = {
	...scriptConfig,
	plugins: [
		...scriptConfig.plugins,
		new RemoveEmptyScriptsPlugin(),
	],
};

// Generate a webpack config which includes setup for CSS extraction.
// Look for css/scss files and extract them into a build/css directory.
const styles = {
	...sharedConfig,
	entry: WebpackWatchedGlobEntries.getEntries(
		[
			path.resolve( __dirname, `src/scss/**/*.scss` ),
			path.resolve( __dirname, `src/layouts/**/*.scss` ),
		],
		{
			ignore: [
				path.resolve( __dirname, `src/scss/**/_*.scss` ),
				path.resolve( __dirname, `src/layouts/**/_*.scss` ),
			],
		},
	),
	output: {
		...sharedConfig.output,
		path: path.resolve( process.cwd(), 'build', 'css' ),
	},
	plugins: [
		...sharedConfig.plugins.filter(
			( plugin ) => {
				return plugin.constructor.name !== 'DependencyExtractionWebpackPlugin' && plugin.constructor.name !== 'CopyPlugin';
			},
		),
	],
};

const scripts = {
	...sharedConfig,
	entry: {
		...sharedConfig.entry(),
		...WebpackWatchedGlobEntries.getEntries(
			[
				path.resolve( __dirname, `src/js/**/*.js` ),
				path.resolve( __dirname, `src/layouts/**/*.js` ),
			],
			{
				ignore: [
					path.resolve( __dirname, `src/js/blocks/**/*.js` ),
					path.resolve( __dirname, `src/js/modules/**/*.js` ),
				],
			},
		)(),
	},
};

let moduleScripts = {};
if ( hasExperimentalModulesFlag ) {
	moduleScripts = {
		...moduleConfig,
		entry: {
			...WebpackWatchedGlobEntries.getEntries(
				[
					path.resolve( __dirname, `src/js/modules/**/*.js` ),
				],
			)(),
		},
		output: {
			...moduleConfig.output,
			path: path.resolve( process.cwd(), 'build', 'modules' ),
			filename: '[name].js',
		},
	};
}

const customExports = [ scripts, styles ];

if ( hasExperimentalModulesFlag ) {
	customExports.push( moduleScripts );
}

module.exports = customExports;
