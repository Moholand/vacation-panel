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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.postCss('resources/css/main.css', 'public/css')
    .postCss('resources/css/enter_layout.css', 'public/css')
    .postCss('resources/css/base_layout.css', 'public/css')
    .postCss('resources/css/navbar.css', 'public/css')
    .postCss('resources/css/sidebar.css', 'public/css')
    .postCss('resources/css/header.css', 'public/css')
    .postCss('resources/css/authentication.css', 'public/css')
    .postCss('resources/css/create_vacation_profile.css', 'public/css')
    .postCss('resources/css/departments.css', 'public/css')
    .options({
        processCssUrls: false
    });

// Change this location later!
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
