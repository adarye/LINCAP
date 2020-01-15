const mix = require('laravel-mix');

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

mix.setPublicPath('../theme/vue').
js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css');

mix.browserSync({
    proxy: 'http://lincap.linco.com.co',
    open: false,
});
mix.disableNotifications();