const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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
    mix.sass('app.scss').webpack('app.js').version('js/app.js');
    mix.sass('app.scss').webpack('admin-app.js').version('js/admin-app.js');
    mix.sass('main.scss').webpack('main.js').version('js/main.js');
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/bootstrap');
    mix.copy('node_modules/font-awesome/fonts/','public/fonts/');
    mix.copy('node_modules/font-awesome/css/font-awesome.min.css','public/css');
    mix.copy('node_modules/freelancer/js/freelancer.min.js','public/js');
    mix.copy('node_modules/freelancer/css/freelancer.min.css','public/css');
    mix.copy('node_modules/ace/assets/js/','public/js/ace');
    mix.copy('node_modules/ace/assets/css/','public/css/ace');
    mix.copy('node_modules/jssor-slider/js/jssor.slider.min.js','public/js');
});
