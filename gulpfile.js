const elixir = require('laravel-elixir');

var path = require('path');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('styles.scss')
        .webpack('app.js', null, null, {
            resolve: {
                extensions: ['', '.js', '.vue', '.html'],
                alias: {
                  app: path.resolve(__dirname, 'resources/assets/js')
                }
            }
        }).copy('resources/assets/bower/font-awesome-sass/assets/fonts/**/*', 'public/fonts/');
});
