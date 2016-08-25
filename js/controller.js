var app = angular.module("app", ['ngRoute']);

app.config(["$routeProvider", function ($routeProvider) {

        $routeProvider
                .when("/cadastro", {
                    templateUrl: "cadastro.html",
                    controller: "PessoaFisicaController"
                })
                .when("/busca", {
                    templateUrl: "busca.html",
                    controller: "PessoaFisicaController"
                })
                .when("/home", {
                    templateUrl: "home.html"
                })
                .when("/login", {
                    templateUrl: "login.html",
                    controller: "UsuarioController"
                })
                .otherwise({
                    redirectTo: "home"
                })
    }]);

app.controller("PessoaFisicaController", function ($scope, $http, $rootScope, $window, $location) {

    $scope.ativo = false;
    
    
    $scope.GerarToken = function () {
        $http.post("token.php").success(function (data) {
            $scope.token = data;
        });
    }
    
    $scope.LimparClick = function () {

        $scope.edicao = 0;
    }

    $scope.$on('$viewContentLoaded', function () {

        $scope.TestarSessao();

        $scope.GerarToken();

        if ($scope.edicao != 1) {
            $scope.showBtnEditar = false;
            $scope.showBtnIncluir = true;
            $scope.LimparConsulta();
            $scope.Limpar();
        } else {
            $scope.showBtnEditar = true;
            $scope.showBtnIncluir = false;
        }
    });

    $scope.titulo = "Registration System";
    $scope.showres = false;

    $scope.Buscar = function () {

        var chkOpcao = document.getElementById("chkOpcao");
        var opcao = 0;
        var token = $scope.token;
        if (chkOpcao.checked) {
            opcao = 4;
            if ($scope.dado == undefined)
            {
                $scope.dado = "%";
            }
        } else {
            if ($scope.dado != undefined)
            {
                if (parseInt($scope.dado) == "NaN")
                {
                    alert("Invalid value for search by code.");
                    $scope.LimparConsulta();
                } else
                {
                    opcao = 5;
                }
            } else {
                alert("No code was reported to search by code.");
                $scope.LimparConsulta();
            }
        }

        if (opcao == 4 || opcao == 5)
        {
            $scope.acao = true;
            $http.post("Execucao.php", {opcao: opcao, dado: $scope.dado, token:token}).success(function (data, status, headers, config) {
                if (data != "") {
                    $scope.showres = true;
                    $scope.pessoas = data;
                    $scope.edicao = 1;
                    $scope.acao = false;
                    $scope.GerarToken();
                } else {
                    alert("No records with this criteria.");
                    $scope.LimparConsulta();
                    $scope.edicao = 0;
                    $scope.acao = false;
                    $scope.GerarToken();
                }
            });
        }
        
        
    }

    $scope.LimparConsulta = function () {
        $scope.showres = false;
        $scope.dado = "";
        $scope.edicao = 0;
    }

    $scope.InputCodigo = function () {
        $scope.tipo = "number";
    }

    $scope.Incluir = function () {
        var opcao = 1;
        $scope.acao = true;
        $http.post("Execucao.php", {opcao: opcao, nome: $scope.nome, email: $scope.email, renda: $scope.renda, dataNasc: $scope.dataNasc, sexo: $scope.sexo, token: $scope.token}).success(function (data, status, headers, config) {
            alert(data);
            $scope.acao = false;
            $scope.Limpar();
            $scope.GerarToken();
        });
    }

    $scope.Editar = function () {

        if (confirm("Do You want to confirm editing?") == true)
        {
            var opcao = 2;
            var token = $scope.token;
            $scope.acao = true;
            $http.post("Execucao.php", {opcao: opcao, codigo: $scope.codigo, nome: $scope.nome, email: $scope.email, renda: $scope.renda, dataNasc: $scope.dataNasc, sexo: $scope.sexo, token:token}).success(function (data, status, headers, config) {
                alert(data);
                $scope.acao = false;
                $scope.GerarToken();
            });
        }
    }

    $scope.Excluir = function () {

        if (confirm("Do You want to confirm deleting?") == true)
        {
            $scope.acao = true;
            var opcao = 3;
            var token = $scope.token;
            $http.post("Execucao.php", {opcao: opcao, codigo: $scope.codigo, token:token}).success(function (data, status, headers, config) {
                $scope.acao = false;
                alert(data);
                $scope.showBtnEditar = false;
                $scope.showBtnIncluir = true;
                $scope.edicao = 0;
                $scope.Limpar();
                $scope.GerarToken();
            });
        }
    }

    $scope.LimparClick = function () {
        $rootScope.codigo = 0;
        $rootScope.nome = "";
        $rootScope.email = "";
        $rootScope.renda = "";
        $rootScope.sexo = "M";
        var dataCad = new Date();
        dataCad.setYear(dataCad.getYear() - 18);
        $rootScope.dataNasc = dataCad;
        $rootScope.showBtnEditar = false;
        $rootScope.showBtnIncluir = true;
        $rootScope.edicao = 0;
    }

    $scope.Limpar = function () {
        $scope.codigo = 0;
        $scope.nome = "";
        $scope.email = "";
        $scope.renda = "";
        $scope.sexo = "M";
        var dataCad = new Date();
        dataCad.setYear(dataCad.getYear() - 18);
        $scope.dataNasc = dataCad;
        $scope.showBtnEditar = false;
        $scope.showBtnIncluir = true;
        $scope.edicao = 0;
    }

    $scope.Excluir_Na_Lista = function (pes) {

        $scope.acao = true;
        var confirmacao = confirm("Do You want to confirm deleting?");
        if (confirmacao == 1)
        {
            var opcao = 3;
            var codigo = pes.CODIGO;
            var token = $scope.token;

            $http.post("Execucao.php", {opcao: opcao, codigo: codigo, token:token}).success(function (data, status, headers, config) {
                alert(data);
                $scope.edicao = 0;
                $scope.LimparConsulta();
                $scope.Limpar();
                $scope.acao = false;
                $scope.GerarToken();
            });
        } else
        {
            alert("Registration Individual was not deleted.");
            $scope.acao = false;
        }
    }

    $scope.TestarSessao = function () {
        var opcao = 7;
        $http.post("Execucao.php", {opcao: opcao}).success(function (data, status, headers, config) {
            if (data == 0)
            {
                $location.path('/home');
                alert("User not authenticated.");
            } else {
                $scope.ativo = true;
            }
        });
    }

    $scope.SelecionarPessoaFisica = function (pes) {
        $rootScope.codigo = pes.CODIGO;
        $rootScope.nome = pes.NOME;
        $rootScope.email = pes.EMAIL;
        $rootScope.renda = pes.RENDA;
        $rootScope.dataNasc = pes.DATANASCIMENTO;
        $rootScope.sexo = pes.SEXO;
        $rootScope.edicao = 1;
    }



});

app.controller("UsuarioController", function ($scope, $http, $location) {
	
	$scope.login = "admin";
    $scope.senha = "121181";

    $scope.GerarToken = function () {
        $http.post("token.php").success(function (data) {
            $scope.token = data;
        });
    }

    $scope.$on('$viewContentLoaded', function () {

        $scope.TestarSessao();
        
        $scope.GerarToken(); 
    });

    $scope.EfetuarLogin = function () {

        var login = $scope.login;
        var senha = $scope.senha;
        var token = $scope.token;
        var opcao = 6;

        $scope.acao = true;
        $http.post("Execucao.php", {opcao: opcao, login: login, senha: senha, token: token}).success(function (data, status, headers, config) {
            if (data == 1)
            {
                $scope.Limpar();
                alert("User authenticated.");
                $location.path('/home');
                $scope.ativo = true;
                $scope.acao = false;
            } else
            {
                alert("User not authenticated.");
                $scope.ativo = false;
                $scope.Limpar();
                $scope.acao = false;
            }
            
            $scope.GerarToken(); 
        });
    }

    $scope.Limpar = function () {
        $scope.login = "admin";
        $scope.senha = "121181";
    }

    $scope.DestruirSessao = function () {
        var opcao = 8;
        $scope.acao = true;
        $http.post("Execucao.php", {opcao: opcao}).success(function (data, status, headers, config) {
            $scope.acao = false;
            alert(data);
            $location.path('/home');
        });
    }

    $scope.TestarSessao = function () {
        var opcao = 7;
        $http.post("Execucao.php", {opcao: opcao}).success(function (data, status, headers, config) {
            if (data == 1)
            {
                $scope.divLogin = false;
                $scope.btnDeslogar = true;
                $scope.ativo = false;
                $scope.statusLog = "Logoff";
            } else
            {
                $scope.divLogin = true;
                $scope.btnDeslogar = false;
                $scope.ativo = true;
                $scope.statusLog = "Logon";
            }
        });
    }
});

