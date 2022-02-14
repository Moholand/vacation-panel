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

mix.combine([
        'resources/css/main_layout.css',
        'resources/css/sidebar.css',
        'resources/css/header.css'
    ], 'public/css/main.css')

mix.combine([
        'resources/css/welcome_layout.css',
        'resources/css/navbar.css',
        'resources/css/authentication.css'
    ], 'public/css/welcome.css')

mix.postCss('resources/css/all.css', 'public/css')
    .postCss('resources/css/create_vacation_profile.css', 'public/css')
    .postCss('resources/css/departments.css', 'public/css')
    .options({
        processCssUrls: false
    });

// Change this location later!
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
