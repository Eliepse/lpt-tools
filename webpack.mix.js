const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableNotifications();

mix.js('resources/js/app.js', 'public/js')
	.vue();

mix
	.sass('resources/sass/styles.scss', 'public/css')
	.sass('resources/sass/onboarding.scss', 'public/css')
	.sass("resources/sass/app.scss", "public/css")
	.options({
		postCss: [
			require("tailwindcss"),
		],
	});

mix
	.copyDirectory('resources/images', 'public/images');

mix.js("resources/js/react/index.js", "public/js/react")
	.sass("resources/sass/antd.scss", "public/css")
	.options({
		postCss: [
			require("tailwindcss"),
		],
	})
	.react();

if (mix.inProduction()) {
	mix.version();
}