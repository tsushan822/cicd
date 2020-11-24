let mix = require('laravel-mix');
let exec = require('child_process').exec;
let path = require('path');

mix
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/website.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .copy('node_modules/sweetalert2/dist/sweetalert2.min.js', 'public/js/sweetalert.min.js')
    .sass('resources/sass/app-rtl.scss', 'public/css')
    .then(() => {
        exec('node_modules/rtlcss/bin/rtlcss.js public/css/app-rtl.css ./public/css/app-rtl.css');
    })
    .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/laravel/spark-aurelius/resources/assets/js'),
                'node_modules'
            ],
            alias: {
                'vue$': mix.inProduction() ? 'vue/dist/vue.min' : 'vue/dist/vue.js'
            }
        }
    });

mix.js('resources/assets/js/app.js', 'public/tenant')
    .js('resources/assets/js/zentreasury.js', 'public/js/zentreasury.js')
    .sass('resources/assets/sass/zentreasury.scss', 'public/css')
    .version();

mix.sass('resources/assets/sass/customers/dan01.scss', 'public/css/customers');

mix.copy('resources/assets/js/custom/toggle.js', 'public/js/custom/toggle.js');

mix.copy('node_modules/gaugeJS/dist/gauge.min.js', 'public/js/from_node/gauge.min.js');
mix.copy('node_modules/jspdf/dist/jspdf.min.js', 'public/js/from_node/jspdf.min.js');
mix.copy('node_modules/handsontable/dist/handsontable.full.js', 'public/js/from_node/handsontable.full.js');
mix.copy('node_modules/hot-formula-parser/dist/formula-parser.min.js', 'public/js/from_node/formula-parser.min.js');

mix.copy('resources/assets/js/backend-datatable/backend-datatable-button-override.js', 'public/vendor/datatables/backend-datatable-button-override.js');
mix.copy('resources/assets/js/backend-datatable/backend-datatable-button-override.js', 'public/vendor/datatables/backend-datatable-button-override.js');

mix.copy(
    'node_modules/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
    'public/app/css/vendor/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'
);
mix.copy(
    'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    'public/app/css/vendor/datatables.net-bs/css/dataTables.bootstrap.css'
);
mix.copy('node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
    'public/app/css/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

mix.copyDirectory(
    'node_modules/famfamfam-flags/dist/sprite',
    'public/vendor/famfamfam'
);
mix.copyDirectory(
    'node_modules/famfamfam-flags/dist/png',
    'public/vendor/famfamfam/png'
);

//datepicker
mix.copyDirectory(
    'node_modules/jquery-ui-dist/jquery-ui.js',
    'public/js/vendor'
);

//datepicker
mix.copy(
    'node_modules/jquery-ui-dist/jquery-ui.min.js',
    'public/js/vendor'
);

mix.copyDirectory(
    'resources/assets/sass/handsontable',
    'public/css/vendor/handsontable'
);

mix.copyDirectory(
    'resources/assets/js/vendor/handsontable',
    'public/js/vendor/handsontable'
);
mix.copyDirectory(
    'resources/assets/js/vendor/datatables',
    'public/js/vendor/datatables'
);
mix.copyDirectory(
    'resources/auth-assets',
    'public/auth-assets'
);
mix.copyDirectory(
    'resources/assets/sass/jquery-ui-1-12-1-custom',
    'public/css/vendor/jquery-ui-1-12-1-custom'
);

mix.scripts([
    'resources/assets/js/custom/form/jquery.inputmask.bundle.js',
    'resources/assets/js/custom/form/customform.js'

], 'public/js/zentreasury-form.js').version();

mix.scripts([
    'resources/assets/js/datepickerDate.js',
    'resources/assets/js/tabs.js'
], 'public/js/custom/deals.js').version();

mix.babel([
    'resources/assets/js/fxdeals/calcSpotAndFwdpts.js',
    'resources/assets/js/fxdeals/crossCcyAmt.js',
    'resources/assets/js/fxdeals/accountdropdown.js',
], 'public/js/custom/fx_deals.js').version();

mix.babel([
    'resources/assets/js/datatable-buttons-search-styling/datatable-buttons-search-styling.js',
], 'public/js/datatable-buttons-search-styling/datatable-buttons-search-styling.js').version();

mix.babel([
    'resources/assets/js/mdb/modules/material-select.js',
], 'public/js/material-select.js').version();

mix.babel([
    'resources/assets/js/import/import.js',
], 'public/js/custom/import.js').version();

mix.babel([
    'resources/assets/js/audit-trail/audit_trail.js',
], 'public/js/custom/audit_trail.js').version();

mix.babel([
    'resources/assets/js/website-components/js-scripts/nav-toggler.js',
], 'public/app/website-components/nav-toggler.js').version();

mix.copyDirectory('node_modules/orgchart/src/js',
    'public/app/js/vendor/orgchart');

mix.js('resources/assets/js/report-components/app.js', 'public/app/report-components');
mix.js('resources/assets/js/notification-components/app.js', 'public/app/notification-components');
mix.js('resources/assets/js/website-components/app.js', 'public/app/website-components');


if (mix.inProduction()) {
    mix.version();
}
