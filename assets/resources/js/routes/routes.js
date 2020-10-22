app.config([
    "$routeProvider",
    function ($routeProvider) {
        $routeProvider
            .when("/home", {
                templateUrl: "home.html",
            })
            .when("/person/:id", {
                templateUrl: "form.html",
                controller: "PersonController",
            })
            .when("/new", {
                templateUrl: "form.html",
                controller: "PersonController",
            })
            .when("/list", {
                templateUrl: "list.html",
                controller: "PersonController",
            })
            .when("/login", {
                templateUrl: "login.html",
                controller: "LoginController",
            })
            .otherwise({
                redirectTo: "/home",
            });
    },
]);