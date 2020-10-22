app.controller("PersonController", function (
    $scope,
    $location,
    $rootScope,
    $routeParams,
    appService
) {
    $scope.lock = true;
    $scope.edition = false;
    $scope.show = true;
    $scope.errors = [];

    //#region messageModal
    function CreateModalForDefaultData(opc) {
        $scope.messageModal = (opc == 0) ? "These a trial version: The data for inclusion will is automatically provided." : "These a trial version: The data for edition or exclusion will is automatically provided.";
        $("#modalDefault").modal("show");
    }
    //#endregion

    function checkSession(method) {
        appService.checkSession().then(
            function (response) {
                if (response != 1) {
                    $rootScope.$emit("setAlert", { opc: 5 });
                    $location.path("/home");
                } else {
                    method();
                }
            },
            function (error) { }
        );
    }

    function unlock() {
        $scope.lock = false;
    }

    function getToken() {
        appService.getToken().then(
            function (response) {
                $scope.token = JSON.parse(response);
                setTimeout(unlock(), 5000);
            },
            function (error) {
                $rootScope.$emit("setAlert", { opc: 0 });
                $location.path("/home");
            }
        );
    }

    //#region 
    function setPersonData(...params) {
        var person = params[0][0];
        if (person !== undefined) {
            $scope.physicalperson = {
                id: person.ID,
                name: "John Lee 02",
                email: "email@crudangularjs.com",
                salary: "R$ 7777,77",
                birthday: "01/02/1990",
                gender: "M",
            };
        } else {
            $scope.physicalperson = {
                id: "",
                name: "John Lee 01",
                email: "email@crudangularjs.com",
                salary: "R$ 3333,33",
                birthday: "02/01/1980",
                gender: "M",
            };
        }
    }
    //#endregion

    function setSalaryMask(salary) {
        var status = false;
        if (salary >= 1000) {
            status = true;
        }
        var p1 = salary.replace(".", ",");
        if (status) {
            if (salary >= 1000) {
                var p2 = p1.substr(0, 1) + ".";
                var p3 = p2 + p1.substr(1, p1.length);
            }
        }
        return p3 !== undefined ? p3 : p1;
    }

    function toggleDate(date) {
        var formatted = "";
        return /^\d{2}\/\d{2}\/\d{4}$/.test(date)
            ? formatted.concat(
                date.substring(6, 10),
                "-",
                date.substring(3, 5),
                "-",
                date.substring(0, 2)
            )
            : formatted.concat(
                date.substring(8, 10),
                "/",
                date.substring(5, 7),
                "/",
                date.substring(0, 4)
            );
    }

    function setResponseToTable(people) {
        $("#tbPeople").DataTable({
            lengthChange: false,
            data: people,
            order: [[0, "desc"]],
            columns: [
                { data: "ID", className: "text-center" },
                { data: "NAME", className: "text-left" },
                {
                    data: null,
                    className: "text-center",
                    render: function (data, type, row) {
                        return new moment(data[6]).format("DD/MM/yyyy");
                    },
                },
                {
                    data: null,
                    className: "text-center",
                    render: function (data, type, row) {
                        return (
                            '<a class="btn btn-info btn-select" href="#/person/' +
                            data[0] +
                            '">SELECT</a>'
                        );
                    },
                    targets: -1,
                },
            ],
        });

        //#region 
        var currentRow = $("#tbPeople").find("tbody");
        var col1 = currentRow.find("tr > td:eq(0)");
        if (col1[0].innerHTML == 11) {
            var cols = [];
            for (var i = 0; i < 4; i++) {
                cols = cols + currentRow.find("tr > td:eq(" + i + ")").css('background-color', '#67efa3');
            }
        }
        //#endregion
    }

    if ($location.$$path == "/list") {
        $scope.show = false;
        $scope.getAll = function () {
            appService.getToken().then(
                function (response) {
                    $scope.token = JSON.parse(response);
                    appService.getAll($scope.token, "").then(
                        function (response) {
                            if (response.length === 0) {
                                $rootScope.$emit("setAlert", { opc: 7 });
                                $scope.show = true;
                            } else {
                                setResponseToTable(response);
                                $scope.show = true;
                                unlock();
                            }
                        },
                        function (error) {
                            $rootScope.$emit("setAlert", { opc: 0 });
                            $location.path("/home");
                        }
                    );
                },
                function (error) {
                    $rootScope.$emit("setAlert", { opc: 0 });
                    $location.path("/home");
                }
            );
        };
        checkSession($scope.getAll);
    }

    //#region 
    $scope.showDefaultModal = function (opc) {
        CreateModalForDefaultData(opc);
    }
    //#endregion

    if ($location.$$path == "/new") {
        checkSession(getToken);
        setPersonData({});
        $scope.insert = function () {
            $scope.lock = true;
            appService.checkSession().then(
                function (response) {
                    if (response != 1) {
                        $rootScope.$emit("setAlert", { opc: 5 });
                        $location.path("/home");
                    } else {
                        salary = $scope.physicalperson.salary
                            .replace("R$ ", "")
                            .replace(".", "")
                            .replace(",", ".");

                        birthday = toggleDate($("#birthday").val());

                        appService
                            .insert(
                                $scope.token,
                                $scope.physicalperson.name,
                                $scope.physicalperson.email,
                                salary,
                                birthday,
                                $scope.physicalperson.gender
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
                                            getToken();
                                        } else {
                                            if (response == 1) {
                                                setPersonData({}); //cleanForm();
                                                $rootScope.$emit("setAlert", { opc: 8 });
                                                $rootScope.$emit("checkSession", {});
                                                $location.path("/list");
                                            }
                                            if (response == -1) {
                                                $rootScope.$emit("setAlert", { opc: 0 });
                                                $location.path("/home");
                                            }
                                            //#region 
                                            if (response == 0) {
                                                $rootScope.$emit("setAlert", { opc: 12 });
                                                $location.path("/list");
                                            }
                                            //#endregion
                                        }
                                    } else {
                                        $rootScope.$emit("setAlert", { opc: 0 });
                                        $location.path("/home");
                                    }
                                },
                                function (error) {
                                    $rootScope.$emit("setAlert", { opc: 0 });
                                    $location.path("/home");
                                }
                            );
                    }
                },
                function (error) {
                    $rootScope.$emit("setAlert", { opc: 0 });
                    $location.path("/home");
                }
            );
        };
    }

    if (/\/person\/[1-9]\d*$/.test($location.$$path)) {
        $scope.show = false;

        $scope.setModalData = function (opc) {
            switch (opc) {
                case 1:
                    $scope.question = "Do you want edit physical person?";
                    $scope.classes = "btn btn-warning";
                    $scope.method = $scope.edit;
                    break;
                case 2:
                    $scope.question = "Do you want delete physical person?";
                    $scope.classes = "btn btn-danger";
                    $scope.method = $scope.delete;
                    break;
            }
            $("#modalRegistration").modal("show");
        };

        $scope.getById = function () {
            appService.getToken().then(
                function (response) {
                    $scope.token = JSON.parse(response);
                    appService.getById($scope.token, $routeParams.id).then(
                        function (response) {
                            if (response[0] !== undefined) {

                                //#region 
                                CreateModalForDefaultData(1);
                                //#endregion

                                setPersonData(response);
                                $scope.edition = true;
                                $scope.show = true;
                                $scope.lock = false;
                                getToken();
                            } else {
                                $rootScope.$emit("setAlert", { opc: 9 });
                                $location.path("/list");
                            }
                        },
                        function (error) {
                            $rootScope.$emit("setAlert", { opc: 0 });
                            $location.path("/home");
                        }
                    );
                },
                function (error) {
                    $rootScope.$emit("setAlert", { opc: 0 });
                    $location.path("/home");
                }
            );
        };

        $scope.edit = function () {
            $scope.lock = true;
            appService.checkSession().then(
                function (response) {
                    if (response != 1) {
                        $rootScope.$emit("setAlert", { opc: 5 });
                        $location.path("/home");
                    } else {
                        salary = $scope.physicalperson.salary
                            .replace("R$ ", "")
                            .replace(".", "")
                            .replace(",", ".");

                        birthday = toggleDate($("#birthday").val());

                        appService
                            .edit(
                                $scope.token,
                                $scope.physicalperson.id,
                                $scope.physicalperson.name,
                                $scope.physicalperson.email,
                                salary,
                                birthday,
                                $scope.physicalperson.gender
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
                                            getToken();
                                        } else {
                                            if (response == 1) {
                                                setPersonData({});
                                                $rootScope.$emit("setAlert", { opc: 10 });
                                                $rootScope.$emit("checkSession", {});
                                                $location.path("/list");
                                            }
                                            if (response == -1) {
                                                $rootScope.$emit("setAlert", { opc: 0 });
                                                $location.path("/home");
                                            }

                                            if (response == 0) {
                                                $rootScope.$emit("setAlert", { opc: 13 });
                                                $location.path("/list");
                                            }
                                        }
                                    } else {
                                        $rootScope.$emit("setAlert", { opc: 0 });
                                        $location.path("/home");
                                    }
                                },
                                function (error) {
                                    $rootScope.$emit("setAlert", { opc: 0 });
                                    $location.path("/home");
                                }
                            );
                    }
                },
                function (error) {
                    $rootScope.$emit("setAlert", { opc: 0 });
                    $location.path("/home");
                }
            );
        };

        $scope.delete = function () {
            $scope.lock = true;
            appService.checkSession().then(
                function (response) {
                    if (response != 1) {
                        $rootScope.$emit("setAlert", { opc: 5 });
                        $location.path("/home");
                    } else {
                        appService
                            .delete($scope.token, $scope.physicalperson.id)
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
                                            getToken();
                                        } else {
                                            if (response == 1) {
                                                setPersonData({});
                                                $rootScope.$emit("setAlert", { opc: 11 });
                                                $rootScope.$emit("checkSession", {});
                                                $location.path("/list");
                                            }
                                            if (response == -1) {
                                                $rootScope.$emit("setAlert", { opc: 0 });
                                                $location.path("/home");
                                            }

                                            if (response == 0) {
                                                $rootScope.$emit("setAlert", { opc: 14 });
                                                $location.path("/list");
                                            }
                                        }
                                    } else {
                                        $rootScope.$emit("setAlert", { opc: 0 });
                                        $location.path("/home");
                                    }
                                },
                                function (error) {
                                    $rootScope.$emit("setAlert", { opc: 0 });
                                    $location.path("/home");
                                }
                            );
                    }
                },
                function (error) {
                    $rootScope.$emit("setAlert", { opc: 0 });
                    $location.path("/home");
                }
            );
        };
        checkSession($scope.getById);
    }
});