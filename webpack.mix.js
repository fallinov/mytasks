let mix = require('laravel-mix');

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

//Pour fusionner plusieurs
mix.js('resources/assets/js/app.js', 'public/js') //js(entrée, sortie)
    .sass('resources/assets/sass/app.scss', 'public/css');  //sass(entree, sortie)
