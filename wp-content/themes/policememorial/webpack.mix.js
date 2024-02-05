const mix = require("laravel-mix");
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

//  npx tailwindcss -i ./src/frontend/css/frontend.css -o ./assets/frontend/css/frontend.css

mix.webpackConfig({ stats: { children: false } })
	// .js("src/backend/js/backend.js", "assets/backend/js")
	// .js("src/backend/js/metabox.js", "assets/backend/js")
	// .postCss("src/backend/css/backend.css", "assets/backend/css", [
	// 	require("postcss-import"),
	// 	require("tailwindcss"),
	// 	require("autoprefixer"),
	// ])
	// .postCss("src/backend/css/metabox.css", "assets/backend/css", [
	// 	require("postcss-import"),
	// 	require("tailwindcss"),
	// 	require("autoprefixer"),
	// ])
	.postCss("src/frontend/css/frontend.css", "assets/frontend/css", [
		require("postcss-import"),
		require("tailwindcss"),
		require("autoprefixer"),
	])
	// .js("src/frontend/js/frontend.js", "assets/frontend/js")
	// .react()
	.sourceMaps(false, "source-map")
	.disableSuccessNotifications();
