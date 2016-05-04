var elixir = require('laravel-elixir');

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

elixir.config.sourcemaps = false;

elixir(function(mix) {

    mix.sass('app.scss', 'resources/assets/build/css/app.css');

    mix.styles([
        '../../../bower_components/font-awesome/css/font-awesome.css',
        '../../../bower_components/animate.css/animate.css',
        '../../../bower_components/simple-line-icons/css/simple-line-icons.css',
        '../../../bower_components/cropper/dist/cropper.css',
        '../../../bower_components/ContentTools/build/content-tools.min.css',
        '../../../bower_components/tooltipster/css/tooltipster.css',
        '../../../bower_components/sweetalert/dist/sweetalert.css',
        '../build/css/app.css'
    ], 'resources/assets/build/css/bear.css');

    mix.scripts([
        '../../../bower_components/jquery/dist/jquery.js',
        '../../../bower_components/jquery-form/jquery.form.js',
        '../../../bower_components/handlebars/handlebars.js',
        '../../../bower_components/dropzone/dist/dropzone.js',
        '../../../bower_components/cropper/dist/cropper.js',
        '../../../bower_components/Materialize/bin/materialize.js',
        '../../../bower_components/ContentTools/build/content-tools.js',
        '../../../bower_components/tooltipster/js/jquery.tooltipster.js',
        '../../../bower_components/riot-route/dist/route.js',
        '../../../bower_components/jquery-nestable/jquery.nestable.js',
        '../../../bower_components/sweetalert/dist/sweetalert.min.js',
        '../../../bower_components/fancybox/source/jquery.fancybox.js',
        '../../../bower_components/fancybox/source/helpers/jquery.fancybox-media.js',
        '../../../bower_components/moment/min/moment.min.js',
        '../../../bower_components/pikaday/pikaday.js',
        '../scripts/ba.functions.js',
        '../scripts/ba.app.js',
        '../scripts/ba.api.js',
        '../scripts/ba.route.js',
        '../scripts/ba.data.js',
        '../scripts/ba.ui.js',
        '../scripts/ba.ui.controls.js',
        '../scripts/ba.ui.controls.dropdown.js',
        '../scripts/ba.ui.controls.sorting.js',
        '../scripts/ba.ui.controls.menu.js',
        '../scripts/ba.ui.editor.js',
        '../scripts/ba.helpers.js',
        '../scripts/ba.vendor.js',
    ], 'resources/assets/build/js/bear.js');

    mix.copy([
        '../../../bower_components/font-awesome/fonts/',
        '../../../bower_components/simple-line-icons/fonts/'
    ], 'resources/assets/build/fonts');

    mix.copy('../../../bower_components/ContentTools/build/icons.woff', 'resources/assets/build/css');
    mix.copy('../../../bower_components/ContentTools/build/images/', 'resources/assets/build/css/images');
    mix.copy('resources/assets/images/', 'resources/assets/build/images');

    mix.copy('../../../bower_components/font-awesome/fonts/', 'resources/assets/build/fonts');
    mix.copy('../../../bower_components/fancybox/source/*.png', 'resources/assets/build/css');
    mix.copy('../../../bower_components/fancybox/source/*.gif', 'resources/assets/build/css');
});
