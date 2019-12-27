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
    .sass('resources/sass/frontend/app.scss', 'public/css/frontend.css')
    .styles([
        'public/css/plugin/datatables/jquery.dataTables.min.css',
    ], 'public/css/frontend-custom.css')
    .js([
        'resources/js/frontend/app.js',
        'resources/js/plugin/sweetalert/sweetalert.min.js',
        'node_modules/bootstrap-select/js/bootstrap-select.js',
        'resources/js/plugins.js'
    ], 'public/js/frontend.js')
    //Copying all directories of tinymce to public folder
    .copy('resources/fonts', 'public/fonts')
    .copy('resources/img', 'public/img')
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
    .webpackConfig({
        plugins: [
            new WebpackRTLPlugin('/css/[name].rtl.css')
        ]
    })
    .version();