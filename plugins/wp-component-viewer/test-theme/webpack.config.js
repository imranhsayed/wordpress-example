const path = require('path');
const glob = require('glob');
const autoprefixer = require('autoprefixer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const isProductionMode = process.env.NODE_ENV === 'production';

const COMPONENTS_DIR = path.resolve(__dirname, 'components');
const BUILD_DIR = path.resolve(__dirname, 'build');

const entry = {};

glob.sync(`${COMPONENTS_DIR}/**/index.js`).forEach((file) => {
	const name = path.relative(COMPONENTS_DIR, path.dirname(file));
	entry[name] = file;
});

glob.sync(`${COMPONENTS_DIR}/**/index.scss`).forEach((file) => {
	const name = path.relative(COMPONENTS_DIR, path.dirname(file));
	if (!entry[name]) entry[name] = file;
});

module.exports = {
	mode: isProductionMode ? 'production' : 'development',
	entry,
	output: {
		path: BUILD_DIR,
		filename: 'js/[name].js',
		assetModuleFilename: 'assets/[hash][ext][query]',
		clean: true,
	},
	devtool: 'source-map',
	resolve: {
		extensions: ['.js', '.scss'],
	},
	plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin({
			filename: 'css/[name].css',
		}),
	],
	module: {
		rules: [
			{
				test: /\.js$/,
				include: [COMPONENTS_DIR],
				exclude: /node_modules/,
				use: 'babel-loader',
			},
			{
				test: /\.(scss|css)$/,
				include: [COMPONENTS_DIR],
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [autoprefixer()],
							},
						},
					},
					'sass-loader',
				],
			},
		],
	},
};
