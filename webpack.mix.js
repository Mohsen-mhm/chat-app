// webpack.mix.js

let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/laravel-echo-setup.js', 'public/js')
    .css('resources/css/app.css', 'public/css');
