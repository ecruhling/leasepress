const mix = require('laravel-mix')
require('@tinypixelco/laravel-mix-wp-blocks')
require('laravel-mix-purgecss')
require('laravel-mix-copy-watched')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

// mix.js('src/app.js', 'dist/').sass('src/app.scss', 'dist/')

// BrowserSync
mix
	.setPublicPath('./dist')
	.browserSync('test.resourceatlanta.test')

// SCSS
mix
	.sass('assets/scss/admin.scss', 'styles')
	.sass('assets/scss/public.scss', 'styles')
	.sass('assets/scss/settings.scss', 'styles')
	// .purgeCss({
	// 	extend: { content: [path.join(__dirname, 'index.php')] },
	// 	whitelist: require('purgecss-with-wordpress').whitelist,
	// 	whitelistPatterns: require('purgecss-with-wordpress').whitelistPatterns,
	// })

// JS
// mix
	.js('assets/js/admin.js', 'scripts')
	.js('assets/js/public.js', 'scripts')
	.js('assets/js/settings.js', 'scripts')
	// .extract();

// CoffeeScript
mix
	// .coffee('assets/coffee/admin.coffee', 'scripts')
	// .coffee('assets/coffee/public.coffee', 'scripts')
	// .coffee('assets/coffee/settings.coffee', 'scripts')

// Other Assets
mix
	.copyWatched('assets/images/**', 'dist/images')
	.copyWatched('assets/fonts/**', 'dist/fonts')

mix
	.autoload({ jquery: ['$', 'window.jQuery'] })
	.options({ processCssUrls: false })
	.sourceMaps(false, 'source-map')
	.version()
