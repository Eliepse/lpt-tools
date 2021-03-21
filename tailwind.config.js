module.exports = {
	purge: [
		'./resources/**/*.blade.php',
		'./resources/**/*.js',
		'./resources/**/*.vue',
	],
	darkMode: false, // or 'media' or 'class'
	theme: {
		fontFamily: {
			sans: ["Arial", "Microsoft YaHei New", "Microsoft Yahei UI", "sans-serif"],
			serif: ["Georgia", "Times New Roman", "KaiTi", "serif"],
		},
		extend: {},
	},
	variants: {
		extend: {},
	},
	plugins: [],
}
