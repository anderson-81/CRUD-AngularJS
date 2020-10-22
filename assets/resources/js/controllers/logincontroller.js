app.controller("LoginController", function (
    $scope,
    $location,
    $rootScope,
    appService
) {
    if ($location.$$path == "/login") {
        $scope.unlogged = false;
        $scope.lock = true;

        appService.checkSession().then(
            function (response) {
                if (response == 1) {
                    $location.path("/home");
                    $rootScope.$emit("setAlert", { opc: 6 });
                } else {
                    $scope.gettoken();
                }
            },
            function (error) { }
        );

        $scope.cleanForm = function () {
            $scope.user = {
                username: "admin",
                password: "admin",
            };
        };

        $scope.cleanErrors = function () {
            $("#errors").hide();
            $scope.errors = [];
        };

        $scope.unlock = function () {
            $scope.lock = false;
        };

        $scope.validateKey = function (event) {
            /[^A-Za-z0-9]/.test(event.key)
                ? $("#" + event.target.id)
                    .val("")
                    .focus()
                : null;
        };

        $scope.gettoken = function () {
            appService.getToken().then(
                function (response) {
                    $scope.token = JSON.parse(response);
                    setTimeout($scope.unlock(), 5000);
                    $scope.cleanForm();
                    $scope.unlogged = true;
                },
                function (error) { }
            );
        };

        $scope.login = function () {
            appService.checkSession().then(
                function (response) {
                    if (response == 1) {
                        $location.path("/home");
                        $rootScope.$emit("setAlert", { opc: 6 });
                        $rootScope.$emit("checkSession", {});
                    } else {
                        $scope.lock = true;
                        appService
                            .login(
                                $scope.token,
                                $scope.user.username,
                                $scope.user.password
                            )
                            .then(
                                function (response) {
                                    $("#errors").hide();
                                    $("#alert").hide();
                                    if (response) {
                                        if (Array.isArray(response)) {
                                            $scope.errors = response;
                                            $("#errors").show();
                                            setTimeout(function () {
                                                $("#errors").hide();
                                                $scope.errors = [];
                                            }, 4000);
                                            $scope.cleanForm();
                                            $scope.gettoken();
                                        } else {
                                            if (response == 0) {
                                                $rootScope.$emit("setAlert", { opc: 3 });
                                                $scope.gettoken();
                                                $scope.cleanForm();
                                            }
                                            if (response == 1) {
                                                $rootScope.$emit("setAlert", { opc: 1 });
                                                $rootScope.$emit("checkSession", {});
                                                $location.path("/home");
                                            }
                                            if (response == -1) {
                                                $rootScope.$emit("setAlert", { opc: 2 });
                                                $location.path("/home");
                                            }
                                        }
                                    } else {
                                        $rootScope.$emit("setAlert", { opc: 2 });
                                        $location.path("/home");
                                    }
                                },
                                function (error) {
                                    $rootScope.$emit("setAlert", { opc: 2 });
                                    $location.path("/home");
                                }
                            );
                    }
                },
                function (error) { }
            );
        };
    }
});