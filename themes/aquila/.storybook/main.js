export default {
	framework: {
		name: '@storybook/html-webpack5',
		options: {},
	},
	stories: [
		'../src/components/**/*.stories.@(js|jsx|ts|tsx|mdx)',
	],
	addons: [
		'@storybook/addon-essentials',
		'@storybook/addon-interactions',
	],
};
