app.service("appService", function ($http, $q) {
    var url = window.location.protocol + "//" + window.location.hostname + "/api/index.php";

    $http.defaults.headers.post["Content-Type"] =
        "application/x-www-form-urlencoded; charset=UTF-8";

    function baseMethod(...params) {
        var deferred = $q.defer();
        var data = {};
        switch (params[0]) {
            case 1:
                data = {
                    option: params[0],
                    token: params[1],
                    name: params[2],
                    email: params[3],
                    salary: params[4],
                    birthday: params[5],
                    gender: params[6],
                };
                break;
            case 2:
                data = {
                    option: params[0],
                    token: params[1],
                    id: params[2],
                    name: params[3],
                    email: params[4],
                    salary: params[5],
                    birthday: params[6],
                    gender: params[7],
                };
                break;
            case 3:
                data = {
                    option: params[0],
                    token: params[1],
                    id: params[2],
                };
                break;
            case 4:
                data = {
                    option: params[0],
                    token: params[1],
                    data: params[2],
                };
                break;
            case 5:
                data = {
                    option: params[0],
                    token: params[1],
                    data: params[2],
                };
                break;
            case 6:
                data = {
                    option: params[0],
                    token: params[1],
                    username: params[2],
                    password: params[3],
                };
                break;
            default:
                data = {
                    option: params[0],
                };
                break;
        }

        $http({
            data: data,
            method: "POST",
            url: url,
        })
            .success(function (response, status, headers, config) {
                deferred.resolve(response, status, headers, config);
            })
            .error(function (response, status, headers, config) {
                deferred.reject(response, status, headers, config);
            });
        return deferred.promise;
    }

    function login(token, username, password) {
        return baseMethod(6, token, username, password);
    }

    function insert(token, name, email, salary, birthday, gender) {
        return baseMethod(1, token, name, email, salary, birthday, gender);
    }

    function edit(token, id, name, email, salary, birthday, gender) {
        return baseMethod(
            2,
            token,
            id,
            name,
            email,
            salary,
            birthday,
            gender
        );
    }

    function destroy(token, id) {
        return baseMethod(3, token, id);
    }

    function getAll(token, name) {
        return baseMethod(4, token, name);
    }

    function getById(token, id) {
        return baseMethod(5, token, id);
    }

    function checkSession() {
        return baseMethod(7);
    }

    function logoff() {
        return baseMethod(8);
    }

    function getToken() {
        return baseMethod(9);
    }

    return {
        login: login,
        insert: insert,
        edit: edit,
        delete: destroy,
        getAll: getAll,
        getById: getById,
        checkSession: checkSession,
        logoff: logoff,
        getToken: getToken,
    };
});