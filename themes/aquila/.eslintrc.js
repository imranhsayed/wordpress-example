module.exports = {
	extends: ['plugin:@wordpress/eslint-plugin/recommended'],
	env: {
		browser: true,
		node: true,
	},
	settings: {
		'import/resolver': {
			webpack: {
				config: './webpack.config.js',
			},
		},
	},
	rules: {
		'react/react-in-jsx-scope': 'off',
		'no-console': [
			'error',
			{
				allow: ['warn', 'error'],
			},
		],
	},
};
