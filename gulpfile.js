var elixir = require('laravel-elixir');
require('laravel-elixir-sass-compass');

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

elixir(function(mix) {
    mix
        .compass('app.scss')
        .scripts(['dashboard.js'], 'public/js/dashboard.js')
        .scripts([
            '../../assets/bower/jquery/dist/jquery.min.js',
            '../../assets/bower/bootstrap-sass/assets/javascripts/bootstrap.min.js',
            '../../assets/bower/vue/dist/vue.min.js'
        ], 'public/js/vendor.js')
        .copy(
            'resources/assets/bower/bootstrap-sass/assets/fonts/bootstrap',
            'public/fonts/bootstrap'
        )
    ;
});
