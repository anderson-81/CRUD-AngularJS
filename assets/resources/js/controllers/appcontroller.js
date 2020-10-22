app.controller("AppController", function (
    $scope,
    $rootScope,
    $location,
    alertService,
    appService
) {
    $scope.logged = false;

    $rootScope.$on("setAlert", function (event, object) {
        var data = alertService.setAlert(object.opc);
        $("#alert").show();
        $scope.message = data.message;
        $scope.classes = data.classes;
        setTimeout(function () {
            $("#alert").hide();
        }, 4000);
    });

    $rootScope.$on("checkSession", function (event, object) {
        $scope.checkSession();
    });

    $scope.logoff = function () {
        appService.logoff().then(
            function (response) {
                $rootScope.$emit("checkSession", {});
                $rootScope.$emit("setAlert", { opc: 4 });
                $location.path("/");
            },
            function (error) {
                $rootScope.$emit("setAlert", { opc: 0 });
                $location.path("/");
            }
        );
    };

    $scope.checkSession = function () {
        appService.checkSession().then(
            function (response) {
                $scope.logged = response == 1;
            },
            function (error) { }
        );
    };

    $scope.showModalLogoff = function () {
        $("#modalLogoff").modal("show");
    };

    $scope.checkSession();
});