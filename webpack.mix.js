const mix = require('laravel-mix');
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const webpack = require('webpack');
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

mix.options({
    processCssUrls: false
});

mix.setPublicPath('public')
    //Frontend js
    .js([
        'resources/js/frontend/app.js',
        'resources/js/sweetalert.min.js',
        'resources/js/plugins.js',
        'resources/js/jquerysession.js',
        'resources/js/bootstrap-select.js',
    ], 'public/js/frontend.js')
    //Datatable js
    .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'public/js/plugin/datatables/dataTables.bootstrap.min.js',
        'node_modules/datatables.net-buttons/js/dataTables.buttons.js',
        'node_modules/datatables.net-buttons/js/buttons.flash.js',
        'public/js/plugin/datatables/jszip.min.js',
        'public/js/plugin/datatables/pdfmake.min.js',
        'public/js/plugin/datatables/vfs_fonts.js',
        'node_modules/datatables.net-buttons/js/buttons.html5.js',
        'node_modules/datatables.net-buttons/js/buttons.print.js',
    ], 'public/js/dataTable.js')
    //Layer js
    .scripts([
        'resources/js/layer/jquery.js',
        'resources/js/layer/exitintent-new.js',
        'resources/js/layer/base.js',
        'resources/js/layer/rangeslider.js',
        'resources/js/layer/datepicker.js',
        'resources/js/layer/devicedetector.min.js',
        'resources/js/layer/touchswipe.js',
        'resources/js/layer/bootstrap3-typeahead.min.js',
        'resources/js/layer/tagsinput.min.js',
        'resources/js/layer/layer.js',
    ], 'public/js/layer.js')
    .scripts([
        'resources/js/layer/exitintent-new.js',
        'resources/js/layer/base.js'
    ], 'public/js/layer-njq.js')
    //Frontend css
    .sass('resources/sass/frontend/app.scss', 'public/css/frontend.css')
    //Layer css
    .sass('resources/sass/frontend/layer/_datepicker.scss', 'public/css/layer/datepicker.css')
    .sass('resources/sass/frontend/layer/_bootstrap-tagsinput.scss', 'public/css/layer/bootstrap-tagsinput.css')
    .sass('resources/sass/frontend/layer/_layer.scss', 'public/css/layer/layer.css')
    .sass('resources/sass/frontend/layer/_layer-responsive.scss', 'public/css/layer/layer-responsive.css')
    .styles([
        'public/css/layer/datepicker.css',
        'public/css/layer/bootstrap-tagsinput.css',
        'public/css/layer/layer.css',
        'public/css/layer/layer-responsive.css',
    ], 'public/css/layer.css')
    //Copying all directories of tinymce to public folder
    .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/img', 'public/img')
    .copyDirectory('resources/images', 'public/images')
    .webpackConfig({
        plugins: [
            new WebpackRTLPlugin('/css/[name].rtl.css'),
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
        ]
    });

if (mix.inProduction()) {
    mix.version();
}

