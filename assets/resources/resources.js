var basePathResourcesJS = "/assets/resources/js/";
var basePathResourcesCSS = "/assets/resources/css/";

var app = [
    { name: 'app.js', path: basePathResourcesJS + 'app.js' }
];

var controllers = [
    { name: 'appcontroller.js', path: basePathResourcesJS + 'controllers/appcontroller.js' },
    { name: 'personcontroller.js', path: basePathResourcesJS + 'controllers/personcontroller.js' },
    { name: 'logincontroller.js', path: basePathResourcesJS + 'controllers/logincontroller.js' }
];

var services = [
    { name: 'alertservice.js', path: basePathResourcesJS + 'services/alertservice.js' },
    { name: 'appservice.js', path: basePathResourcesJS + 'services/appservice.js' }
];

var routes = [
    { name: 'routes.js', path: basePathResourcesJS + 'routes/routes.js' }
];

var styles = [
    { name: 'style.css', path: basePathResourcesCSS + 'style.css' }
];

var list = [
    app, controllers, services, routes, styles
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
