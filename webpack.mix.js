const mix = require('laravel-mix');
require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.extend('i18n', function( webpackConfig, ...args ) {
    webpackConfig.module.rules.push({
        resourceQuery: /blockType=i18n/,
        type: 'javascript/auto',
        loader: '@intlify/vue-i18n-loader',
    })
});

mix.i18n().js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .tailwind()
   .purgeCss();
