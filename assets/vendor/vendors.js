var basePathVendorJS = "/assets/vendor/";
var basePathVendorCSS = "/assets/vendor/";

var jquery = [
    { name: 'jquery.dataTables.min.js', path: basePathVendorJS + 'jquery/dataTables/jquery.dataTables.min.js' },
    { name: 'jquery.maskMoney.min.js', path: basePathVendorJS + 'jquery/maskMoney/jquery.maskMoney.min.js' },
    { name: 'jquery.dataTables.min.css', path: basePathVendorCSS + 'jquery/dataTables/jquery.dataTables.min.css' },
];

var angularjs = [
    { name: 'angular.min.js', path: basePathVendorJS + 'angularjs/angular.min.js' },
    { name: 'angular-route.min.js', path: basePathVendorJS + 'angularjs/angular-route.min.js' },
    { name: 'angular-locale_pt-br.js', path: basePathVendorJS + 'angularjs/angular-locale_pt-br.js' },
];

var moment = [
    { name: 'moment-with-locales.js', path: basePathVendorJS + 'moment.js/moment-with-locales.js' }
];

var bootstrap = [
    { name: 'bootstrap.min.js', path: basePathVendorJS + 'bootstrap/js/bootstrap.min.js' },
    { name: 'bootstrap.min.css', path: basePathVendorJS + 'bootstrap/css/bootstrap.min.css' },
    { name: 'bootstrap-datetimepicker.js', path: basePathVendorJS + 'bootstrap/datetimepicker/bootstrap-datetimepicker.js' },
    { name: 'bootstrap-datetimepicker.css', path: basePathVendorCSS + 'bootstrap/datetimepicker/bootstrap-datetimepicker.css' },
];

var list = [
    angularjs, moment, bootstrap, jquery,
];

list.forEach((item) => {
    item.forEach((file) => {
        if (/.\.css$/.test(file.name)) {
            $('head').append("<link rel=\"stylesheet\" type=\"text/css\" href=" + file.path + ">");
        } else {
            $('head').append("<script src=" + file.path + "></script>");
        }
    });
});
