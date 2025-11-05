/**
 * Webpack configuration for the WP Component Viewer plugin.
 *
 * @package wp-component-viewer
 */

const path          = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		'admin': './assets/js/src/admin.js',
	},
	output: {
		path: path.resolve( __dirname, 'assets/js/dist' ),
		filename: '[name].js',
	},
};