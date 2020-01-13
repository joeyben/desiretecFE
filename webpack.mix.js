const mix = require('laravel-mix');
const WebpackRTLPlugin = require('webpack-rtl-plugin');

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

mix.setPublicPath('public')
    //Frontend js
    .js([
        'resources/js/frontend/app.js',
        'node_modules/bootstrap-select/js/bootstrap-select.js',
        'resources/js/sweetalert.min.js',
        'resources/js/plugins.js',
        'resources/js/jquerysession.js'
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
        'resources/js/layer/exitintent.js',
        'resources/js/layer/exitintent-new.js',
        // 'node_modules/js-cookie/src/js.cookie.js',
        'resources/js/layer/base.js',
        'resources/js/layer/rangeslider.js',
        'resources/js/layer/datepicker.js',
        'resources/js/layer/devicedetector.min.js',
        'resources/js/layer/touchswipe.js',
        'resources/js/layer/typeahead.js',
        'resources/js/layer/bootstrap3-typeahead.min.js',
        'resources/js/layer/tagsinput.min.js',
        'resources/js/layer/layer.js',
    ], 'public/js/layer.js')
    //Frontend css
    .sass('resources/sass/frontend/app.scss', 'public/css/frontend.css')
    .styles([
        'public/css/plugin/datatables/jquery.dataTables.min.css',
    ], 'public/css/frontend-custom.css')
    //Layer css
    .sass('resources/sass/frontend/layer/_datepicker.scss', 'public/css/layer/datepicker.css')
    .sass('resources/sass/frontend/layer/_layer.scss', 'public/css/layer/layer.css')
    .sass('resources/sass/frontend/layer/_layer-responsive.scss', 'public/css/layer/layer-responsive.css')
    .styles([
        'public/css/layer/datepicker.css',
        'public/css/layer/layer.css',
        'public/css/layer/layer-responsive.css',
    ], 'public/css/layer.css')
    //Copying all directories of tinymce to public folder
    .copy('resources/fonts', 'public/fonts')
    .copy('resources/img', 'public/img')
    .webpackConfig({
        plugins: [
            new WebpackRTLPlugin('/css/[name].rtl.css')
        ]
    })
    .version();
