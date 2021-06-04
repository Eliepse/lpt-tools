module.exports = {
	purge: [
		'./resources/**/*.blade.php',
		'./resources/**/*.js',
		'./resources/**/*.vue',
	],
	darkMode: false, // or 'media' or 'class'
	theme: {
		fontFamily: {
			sans: ["Noto Sans SC", "Microsoft YaHei New", "Microsoft Yahei UI", "sans-serif"],
			serif: ["Georgia", "Times New Roman", "KaiTi", "serif"],
			mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', "Liberation Mono", "Courier New", 'monospace'],
		},
		extend: {},
	},
	variants: {
		extend: {},
	},
	plugins: [],
};
