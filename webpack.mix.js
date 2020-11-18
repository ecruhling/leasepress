const mix = require('laravel-mix')
require('@tinypixelco/laravel-mix-wp-blocks')
require('laravel-mix-purgecss')
require('laravel-mix-copy-watched')

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
mix
	.js('assets/js/admin.js', 'scripts')
	.js('assets/js/public.js', 'scripts')
	.js('assets/js/settings.js', 'scripts')
	// .extract(); // extracts all imported node_modules into a separate vendor.js file

// Other Assets
mix
	.copyWatched('assets/images/**', 'dist/images')
	.copyWatched('assets/fonts/**', 'dist/fonts')

// Options
mix
	.autoload({ jquery: ['$', 'window.jQuery'] })
	.options({ processCssUrls: false })
	.sourceMaps(false, 'source-map')
	.version()
