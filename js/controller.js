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
			templateUrl: "home.html",
			controller: "UsuarioController"
		})
		.when("/login", {
			templateUrl: "login.html",
			controller: "UsuarioController"
		})
		.otherwise({
			redirectTo: "home"
		})
}]);


app.filter('offset', function () {
	return function (input, start) {
		start = parseInt(start, 10);
		return input.slice(start);
	};
});


app.controller("PessoaFisicaController", function ($scope, $http, $rootScope, $window, $location, $log) {


	$scope.ativo = false;
	$scope.errors = [];
	$scope.pessoas = [];

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
			if ($scope.dado == undefined) {
				$scope.dado = "%";
			}
		} else {
			if ($scope.dado != undefined) {
				if (parseInt($scope.dado) == "NaN") {
					ShowInfoModal("Information", "Invalid value for search by code.");
					$scope.LimparConsulta();
				} else {
					opcao = 5;
				}
			} else {
				ShowInfoModal("Information", "No code was reported to search by code.");
				$scope.LimparConsulta();
			}
		}

		if (opcao == 4 || opcao == 5) {
			$scope.acao = true;
			$http.post("Execucao.php", {
				opcao: opcao,
				dado: $scope.dado,
				token: token
			}).success(function (data, status, headers, config) {
				if (data != "") {
					$scope.showres = true;
					$scope.pessoas = data;
					$scope.edicao = 1;
					$scope.acao = false;
					$scope.GerarToken();
				} else {
					ShowInfoModal("Information", "No records with this criteria.");
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


	//Validations:
	$scope.SetErro = function (error) {
		$scope.showError = true;
		$scope.errors.push(error);
	}


	//http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
	function ValidarEmail(email) {
		if (email != "") {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}

		return false;
	}

	function ValidarRenda(renda) {

		if (renda != "") {
			try {
				parseFloat(renda);
				if (renda > 0) {
					return true;
				}

				return false;
			} catch (e) {

				return false;
			}


		}
		return false;

	}

	function ValidarDataNasc(dataNasc) {


		if (dataNasc != "") {
			var data18 = new Date();
			data18.setFullYear(data18.getFullYear() - 18);

			var dia = dataNasc.substring(0, 2);
			var mes = dataNasc.substring(3, 5);
			var ano = dataNasc.substring(6, 10);
			var mes_inteiro = parseInt(mes);
			var dateCompare = new Date(ano, mes_inteiro - 1, dia);

			if (dateCompare <= data18) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	function ValidarSexo(sexo) {

		if (sexo != "") {
			var re = /^[MF]{1}$/;
			return re.test(sexo);
		}
		return false;
	}


	$scope.Validacao = function () {

		var flag = true;
		$scope.showError = false;

		if (($scope.nome == undefined) || ($scope.nome == "")) {
			$scope.SetErro("Empty Name.");
			flag = false;
		}

		if (($scope.email != undefined) || ($scope.email != "") || ($scope.email != "undefined")) {
			if (!ValidarEmail($scope.email)) {
				$scope.SetErro("Invalid Email.");
				flag = false;
			}
		} else {
			$scope.SetErro("Empty Email.");
			flag = false;
		}

		if (($scope.renda != undefined) || ($scope.renda != "")) {
			if (!ValidarRenda($scope.renda)) {
				$scope.SetErro("Invalid Salary.");
				flag = false;
			}
		} else {
			$scope.SetErro("Empty Salary.");
			flag = false;
		}

		if ($scope.dataNasc != undefined) {
			if (!ValidarDataNasc($scope.dataNasc)) {
				$scope.SetErro("Invalid Date of Birth.");
				flag = false;
			}
		}

		if ($scope.dataNasc == "") {
			$scope.SetErro("Empty Date of Birth.");
			flag = false;
		}

		if ($scope.dataNasc == undefined) {
			$scope.SetErro("Empty Date of Birth.");
			flag = false;
		}

		if (($scope.sexo != undefined) || ($scope.sexo != "")) {
			if (!ValidarSexo($scope.sexo)) {
				$scope.SetErro("Invalid Gender.");
				flag = false;
			}
		} else {
			$scope.SetErro("Empty Gender.");
			flag = false;
		}

		return flag;
	}


	$scope.Incluir = function () {
		var opcao = 1;
		//$scope.acao = true;
		$scope.errors = [];
		if ($scope.Validacao()) {
			$http.post("Execucao.php", {
				opcao: opcao,
				nome: $scope.nome,
				email: $scope.email,
				renda: $scope.renda,
				dataNasc: $scope.dataNasc,
				sexo: $scope.sexo,
				token: $scope.token
			}).success(function (data, status, headers, config) {
				ShowInfoModal("Information", data);
				$scope.acao = false;
				$scope.Limpar();
				$scope.GerarToken();
			});
		} else {
			$scope.GerarToken();
		}
	}

	$scope.Editar = function () {


		if ($scope.Validacao()) {
			var opcao = 2;
			var token = $scope.token;
			$scope.acao = true;
			$http.post("Execucao.php", {
				opcao: opcao,
				codigo: $scope.codigo,
				nome: $scope.nome,
				email: $scope.email,
				renda: $scope.renda,
				dataNasc: $scope.dataNasc,
				sexo: $scope.sexo,
				token: token
			}).success(function (data, status, headers, config) {
				ShowInfoModal("Information", data);
				$scope.acao = false;
				$scope.GerarToken();
			});
		} else {
			$scope.GerarToken();
		}
	}

	$scope.Excluir = function () {

		$scope.acao = true;
		var opcao = 3;
		var token = $scope.token;
		$http.post("Execucao.php", {
			opcao: opcao,
			codigo: $scope.codigo,
			token: token
		}).success(function (data, status, headers, config) {
			$scope.acao = false;
			ShowInfoModal("Information", data);
			$scope.showBtnEditar = false;
			$scope.showBtnIncluir = true;
			$scope.edicao = 0;
			$scope.Limpar();
			$scope.GerarToken();
		});
	}

	$scope.LimparClick = function () {
		$rootScope.codigo = 0;
		$rootScope.nome = "";
		$rootScope.email = "";
		$rootScope.renda = "";
		$rootScope.sexo = "M";
		$rootScope.dataNasc = GerarDataAtual18();
		$rootScope.showBtnEditar = false;
		$rootScope.showBtnIncluir = true;
		$rootScope.edicao = 0;
	}

	function GerarDataAtual18() {

		var date = new Date();
		date.setFullYear(date.getFullYear() - 18);
		var date_str = date.toLocaleDateString();

		/*

		var day = date_str.substring(7,9);
		var month = date_str.substring(5,6);
		var year = date_str.substring(0,4);

		var month_integer = parseInt(month);

		if(month_integer < 10)
		{
		    month = "0" + month_integer;
		}

		month_integer = parseInt(month) + 1;
		return(day + "/" + month + "/" + year);


		*/

		return date_str;

	}


	$scope.Limpar = function () {
		$scope.codigo = 0;
		$scope.nome = "";
		$scope.email = "";
		$scope.renda = "";
		$scope.sexo = "M";

		$scope.dataNasc = GerarDataAtual18();

		$scope.showBtnEditar = false;
		$scope.showBtnIncluir = true;
		$scope.edicao = 0;
	}


	$scope.Excluir_Na_Lista = function (pes) {

		$scope.acao = true;
		var confirmacao = confirm("Do You want to confirm deleting?");
		if (confirmacao == 1) {
			var opcao = 3;
			var codigo = pes.CODIGO;
			var token = $scope.token;

			$http.post("Execucao.php", {
				opcao: opcao,
				codigo: codigo,
				token: token
			}).success(function (data, status, headers, config) {
				ShowInfoModal("Information", data);
				$scope.edicao = 0;
				$scope.LimparConsulta();
				$scope.Limpar();
				$scope.acao = false;
				$scope.GerarToken();
			});
		} else {
			ShowInfoModal("Information", "Registration Individual was not deleted.");
			$scope.acao = false;
		}
	}

	$scope.TestarSessao = function () {
		var opcao = 7;
		$http.post("Execucao.php", {
			opcao: opcao
		}).success(function (data, status, headers, config) {
			if (data == 0) {
				$location.path('/login');
				ShowInfoModal("Information", "User not authenticated.");
				LinkLogin(0);
			} else {
				$scope.ativo = true;
				LinkLogin(1);
			}
		});
	}

	/*
	function FormatarData(data)
	{
	    var data_format = "";

	    if((data != "") || (data != "null") || (data != null))
	    {
	        var day = data.substring(8,10);
	        var month = data.substring(5,7);
	        var year = data.substring(0,4);
	        data_format = day + "/" + month + "/" + year;
	    }

	    if((data == "null") || (data == null))
	    {
	        data_format = "";
	    }

	    console.log(data_format);
	    return data_format;
	}
	*/


	$scope.SelecionarPessoaFisica = function (pes) {
		$rootScope.codigo = pes.CODIGO;
		$rootScope.nome = pes.NOME;
		$rootScope.email = pes.EMAIL;
		$rootScope.renda = pes.RENDA;
		$rootScope.dataNasc = pes.DATANASC;
		$rootScope.sexo = pes.SEXO;
		$rootScope.edicao = 1;
	}


	$scope.itemsPerPage = 10;
	$scope.currentPage = 0;
	$scope.items = [];

	for (var i = 0; i < 50; i++) {
		$scope.items.push({
			id: i,
			name: "name " + i,
			description: "description " + i
		});
	}

	$scope.prevPage = function () {
		if ($scope.currentPage > 0) {
			$scope.currentPage--;
		}
	};

	$scope.prevPageDisabled = function () {
		return $scope.currentPage === 0 ? "disabled" : "";
	};

	$scope.pageCount = function () {
		return Math.ceil($scope.items.length / $scope.itemsPerPage) - 1;
	};

	$scope.nextPage = function () {
		if ($scope.currentPage < $scope.pageCount()) {
			$scope.currentPage++;
		}
	};

	$scope.nextPageDisabled = function () {
		return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
	};


});

app.controller("UsuarioController", function ($scope, $http, $location) {

	$scope.login = "admin";
	$scope.senha = "121181";
	$scope.messageLogs = [];

	$scope.GerarToken = function () {
		$http.post("token.php").success(function (data) {
			$scope.token = data;
		});
	}

	$scope.$on('$viewContentLoaded', function () {

		$scope.TestarSessao();
		$scope.GerarToken();
	});

	$scope.SetMessageLogin = function (message) {
		$scope.showMessage = true;
		$scope.messageLogs.push(message);
	}

	$scope.EfetuarLogin = function () {

		$scope.showMessage = false;
		var login = $scope.login;
		var senha = $scope.senha;
		var token = $scope.token;
		var opcao = 6;

		$scope.acao = true;
		$http.post("Execucao.php", {
			opcao: opcao,
			login: login,
			senha: senha,
			token: token
		}).success(function (data, status, headers, config) {
			if (data == 1) {
				$scope.Limpar();
				ShowInfoModal("Information", "User authenticated.");
				$location.path('/home');
				$scope.ativo = true;
				$scope.btnDeslogar = true;
				LinkLogin(1);
			} else {
				//$scope.acao = false;
				$scope.SetMessageLogin("User not authenticated.");
				//$scope.ativo = false;
				$scope.Limpar();
				$scope.acao = true;
				LinkLogin(0);
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
		$http.post("Execucao.php", {
			opcao: opcao
		}).success(function (data, status, headers, config) {
			$scope.acao = false;
			ShowInfoModal("Information", data);
			LinkLogin(0);
			$location.path('/home');
		});
	}

	$scope.TestarSessao = function () {
		var opcao = 7;
		$http.post("Execucao.php", {
			opcao: opcao
		}).success(function (data, status, headers, config) {
			if (data == 1) {
				$scope.divLogin = false;
				$scope.btnDeslogar = true;
				$scope.ativo = false;
				LinkLogin(1);
			} else {
				$scope.divLogin = true;
				$scope.btnDeslogar = false;
				$scope.ativo = true;
				LinkLogin(0);
			}


		});
	}
});

function ShowInfoModal(title, message) {
	$("#titleModal").text(title);
	$("#textModal").text(message);
	$("#infoModal").modal("show");
}


function LinkLogin(statusLogin) {
	if (statusLogin == 1) {
		$("#linkLogin").empty();
		$("#linkLogin").off();
		$("#linkLogin").append("<span class='glyphicon glyphicon-log-in'></span> Logoff");
		$("#linkLogin").click(function (event) {
			$("#confirmLogoutModal").modal("show");
		});
		$("#linkLogin").attr("href", "#");
		console.log("LinkLogin executado...");

	} else {
		$("#linkLogin").empty();
		$("#linkLogin").off();
		$("#linkLogin").append("<span class='glyphicon glyphicon-log-in'></span> Logon");
		$("#linkLogin").attr("href", "#login");
	}
}