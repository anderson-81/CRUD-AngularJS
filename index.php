<!DOCTYPE html>
<html lang="pt-br" ng-app="app">
    <head>
        <script src="js/angular.js" type="text/javascript"></script>
        <script src="js/angular-route.min.js" type="text/javascript"></script>
        <script src="js/angular-locale_pt-br.js" type="text/javascript"></script>
        <script src="js/controller.js" type="text/javascript"></script>
        <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
        <link rel="icon" href="imgs/icon_angularjs.png">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Sistema pequeno de Cadastro feito com AngularJS, Material Design Lite (ambos componentes da Google) no lado do cliente. No lado do servidor, PHP e SQLite.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Registration AngularJS</title>

        <!-- Page styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.min.css">
    	<link rel="stylesheet" href="css/mycss.css">
   
    </head>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Registration System</span>
                    <div class="mdl-layout-spacer"></div>
                    <br><br><br>
                    <nav class="mdl-navigation ocultar_celular">
                        <a href="#home" class="mdl-navigation__link">Home</a>
                        <a href="#cadastro" class="mdl-navigation__link" ng-controller="PessoaFisicaController" ng-click="LimparClick()">Registration</a>
                        <a href="#busca" class="mdl-navigation__link" ng-controller="PessoaFisicaController" ng-click="LimparClick()">Search</a>
                        <a href="#login" class="mdl-navigation__link">Login</a>
                    </nav>
                </div>
            </header>
            <div class="mdl-layout__drawer mostrar_celular">
                <span class="mdl-layout-title">Menu</span>
                <nav class="mdl-navigation">
                    <a href="#home" class="mdl-navigation__link">Home</a>
                    <a href="#cadastro" class="mdl-navigation__link" ng-controller="PessoaFisicaController" ng-click="LimparClick()">Registration</a>
                    <a href="#busca" class="mdl-navigation__link" ng-controller="PessoaFisicaController" ng-click="LimparClick()">Search</a>
                    <a href="#login" class="mdl-navigation__link" >Login</a>
                </nav>
            </div>

            <div class="mdl-layout__content">
                <main>
                    <div ng-view></div>

                    <script type="text/ng-template" id="cadastro.html" ng-controller="PessoaFisicaController" ng-cloak ng-init="Limpar()" ng-disabled="divReg">
                      <div class="mdl-grid" style="text-align:center;"  ng-show="ativo">
                          <div class="mdl-cell mdl-cell--12-col">
                                
                              <h6>Registration System</h6>
                              
                                <div ng-bind="token" style="display:none"></div>
                              
							  <input type="hidden" ng-model="codigo" value="">
                              
							  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <label class="mdl-textfield__label" for="nome">Name:</label>
                                  <input class="mdl-textfield__input" type="text" ng-model="nome" id="nome" style="color:black;" ng-focus="nome_focus">
                                  <span class="mdl-textfield__error">Only character and letter.</span>
                              </div>
                              <br>
                              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <label class="mdl-textfield__label" for="email">E-mail:</label>
                                  <input class="mdl-textfield__input" type="text" ng-model="email" id="email" style="color:black;" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                                  <span class="mdl-textfield__error">Invalid E-mail.</span>
                              </div>
                              <br>
                              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <label class="mdl-textfield__label" for="renda">Salary:</label>
                                  <input  class="mdl-textfield__input" type="number" ng-model="renda" id="renda" value="{{renda}}"  style="color:black;" required><br><br>            
                              </div>
                              <br>
                              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <label class="mdl-textfield__label" for="dataNasc" id="name">Data of Birth:</label>
                                  <input class="mdl-textfield__input" type="date" ng-model="dataNasc" value="{{dataNasc}}" required style="color:black;"><br><br>            
                              </div>
                              <br>
                              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                              <label class="mdl-textfield__label" for="sexo">Genre:</label>
                                  <select class="mdl-textfield__input" required value="{{sexo}}" id="sexo" ng-model="sexo" required>            
                                      <option value="M">Male</option>
                                      <option value="F">Female</option>
                                  </select><br><br>
                              </div>
                              <br>
                              <button ng-click="Excluir()" ng-show="showBtnEditar" class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-disabled="acao">Delete</button>
                              <button ng-click="Limpar()" class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop">Clear</button>
                              <button ng-click="Editar()" ng-show="showBtnEditar" class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-disabled="acao">Edit</button>
                              <button ng-click="Incluir()" ng-show="showBtnIncluir" class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-disabled="acao">Insert</button>
                           </div>
                      </div>
                    </script>



                    <script type="text/ng-template" id="home.html" ng-cloak>

                        <div class="mdl-grid" style="text-align:center;">
                        <div class="mdl-cell mdl-cell--12-col" style="text-align:left;">
                        <h1>Home</h1>
                        <h4>Registration System</h4>
                        <p>This system aims to show the example of AngularJS technologies together with PHP and SQLite.</p>  
                        <p style="font-size:18px;">
							AngularJS is an open-source JavaScript framework, maintained by Google that assists<br>
							the single-page applications run. Your goal is to increase applications that can<br>
							be accessed by a web browser, it was built under the model-view-view model pattern (MVVM)<br>
							in an effort to facilitate both the development and testing of applications.<br>
						</p>
                        <img src="imgs/AngularJS-medium.png" class="logoAngular"><br>
                        <img src="imgs/php.png" class="logo">
                        <img src="imgs/sqlite-logo.png" class="logo">
                        </div>
                        </div>
                    </script>

                    <script type="text/ng-template" id="login.html" ng-controller="UsuarioController">
                        <div class="mdl-grid" style="text-align:center;">
                        <div class="mdl-cell mdl-cell--12-col">
                        <h6>Login</h6>
                
                         <div ng-bind="token" style="display:none"></div>
                        
                        <div ng-show="divLogin">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <label class="mdl-textfield__label" for="login">User:</label>
                            <input class="mdl-textfield__input" type="text" ng-model="login" style="color:black;">
                            </div>
                            <br>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <label class="mdl-textfield__label" for="senha">Password:</label>
                            <input class="mdl-textfield__input" type="password" ng-model="senha" style="color:black;" >
                            </div>
                            <br>
                            <button class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-click="EfetuarLogin()" ng-disabled="acao">Login</button>
                        </div>
                        <button class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-click="DestruirSessao()" ng-show="btnDeslogar" ng-disabled="acao">Logout</button>
                        </div>
                        </div>
                    </script>

                    <script type="text/ng-template" id="busca.html" ng-controller="PessoaFisicaController" ng-cloak>
                        <div class="mdl-grid" style="text-align:center;" ng-show="ativo">
                            <div class="mdl-cell mdl-cell--12-col">
                                <h6>Search Registration</h6>
                                <div ng-bind="token" style="display:none"></div>
                                <input type="hidden" ng-model="codigoExclusao" id="codigoExclusao">
                                <span class="tituloBusca">Enter the search criteria :</span><br>
                                <label class="mdl-radio mdl-js-radio" for="chkOpcao" style="margin-left:30%;">
                                    <input type="radio" id="chkOpcao" name="opcao" class="mdl-radio__button" checked>
                                    <span class="mdl-radio__label" ng-click="LimparConsulta()">For Name</span>
                                </label>
                                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="chkOpcao2">
                                    <input type="radio" id="chkOpcao2" name="opcao" class="mdl-radio__button" >
                                    <span class="mdl-radio__label" ng-click="LimparConsulta()">For Code</span>
                                </label><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-right:18%;">
                                    <label class="mdl-textfield__label" for="dado">Data for search:</label>
                                    <input class="mdl-textfield__input" type="text" ng-model="dado" id="dado" ng-focus="dado_focus" style="color:black;">
                                </div>
                                <br>
                                <button id="btnBuscar" ng-click="Buscar()" class="mdl-button mdl-js-button mdl-button--primary mdl-button--raised mdl-js-ripple-effect botao_celular botao_desktop" ng-disabled="acao">Search</button>
                                <br><br>
                                <div id="divResultado" ng-show="showres">
                                    <div style="margin-left:32%;">
                                        <label>Filter by Name:</label><br>
                                        <input type="search" ng-model="filtro"><br><br>
                                    </div>
                                    <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp tabela_celular">
                                        <thead>
                                            <tr> 	
                                                <th>CODE</th>
                                                <th class="mdl-data-table__cell--non-numeric">NAME</th>
                                                <th class="mdl-data-table__cell--non-numeric ocultar_celular">EMAIL</th>
                                                <th class="ocultar_celular">SALARY</th>
                                                <th class="mdl-data-table__cell--non-numeric ocultar_celular">DATE BIRTH</th>
                                                <th class="mdl-data-table__cell--non-numeric ocultar_celular">GENRE</th>
                                                <th class="mdl-data-table__cell--non-numeric">EDIT</th>	
                                                <th class="mdl-data-table__cell--non-numeric">DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="pes in pessoas | filter:filtro | orderBy:'NOME'">
                                                <td>{{pes.CODIGO}}</td>
                                                <td class="mdl-data-table__cell--non-numeric">{{pes.NOME | uppercase}}</td>
                                                <td class="mdl-data-table__cell--non-numeric ocultar_celular">{{pes.EMAIL | lowercase}}</td>
                                                <td class="ocultar_celular">{{pes.RENDA | currency}}</td>
                                                <td>{{pes.DATANASCIMENTO | date : format : timezone}}</td>
                                                <td>{{pes.SEXO}}</td>	
                                                <td><a href="#cadastro" ng-click="SelecionarPessoaFisica(pes)"><img src="imgs/edit.ico" class="iconsearch"></a></td>
                                                <td><a href="#busca" ng-click="Excluir_Na_Lista(pes)" ng-disabled="acao"><img src="imgs/delete.ico" class="iconsearch"></a></td>
                                            </tr>
                                         </tbody>    
                                     </table>
                                </div>
                            </div>
                    </script>
                </main>
            </div>
        </div>
    </body>
</html>	

