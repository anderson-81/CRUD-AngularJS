<!DOCTYPE html>
<html lang="pt-br" ng-app="app">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/angular.js" type="text/javascript"></script>
      <script src="js/angular-route.min.js" type="text/javascript"></script>
      <script src="js/angular-locale_pt-br.js" type="text/javascript"></script>
      <script src="js/controller.js" type="text/javascript"></script>
      <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="css/bootstrap-datepicker.css">
      <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="js/ui-bootstrap-tpls-0.11.0.js"></script>
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
         <div class="container">
            <div class="navbar-header">
               <button class="navbar-toggle marginButton" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand marginTitle" href="#">.::CrudAJS:.</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li class="padLink"><a href="#home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                  <li class="padLink"><a href="#cadastro" ng-controller="PessoaFisicaController" ng-click="LimparClick()"><span class="glyphicon glyphicon-edit"></span> Registration</a></li>
                  <li class="padLink"><a href="#busca" ng-controller="PessoaFisicaController" ng-click="LimparClick()"><span class="glyphicon glyphicon-search"></span> Search</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li class="padLink"><a href="#login" ng-controller="UsuarioController" ng-click="OpenLogout()" id="linkLogin"><span class="glyphicon glyphicon-log-in"></span> Logon</a></li>
               </ul>
            </div>
         </div>
      </nav>
      <div ng-view></div>
      <script type="text/ng-template" id="cadastro.html" ng-controller="PessoaFisicaController" ng-cloak ng-init="Limpar()" ng-disabled="divReg">
         <div ng-show="ativo">
             <div class="wrapper" role="main">
                 <div id="cadastro" class="container">
                     <h1>.::Registration:.</h1>
         
                     <div role="form">
         
                         <div ng-bind="token" class="divToken"></div>
                         <input type="hidden" ng-model="codigo" value="">
         
                         <div class="form-group" id="divErrors">
                             <div class="divErrors" ng-show="showError">
                                 <ul id="listError">
                                     <li ng-repeat="error in errors">{{error}}</li>
                                 </ul>
                             </div>
                         </div>
         
                         <div class="form-group">
                             <label for="nome" class="control-label">Name</label>
                             <input type="text" class="form-control" ng-model="nome" id="nome" value="{{nome}}" ng-focus="nome_focus" required>
                         </div>
         
                         <div class="form-group">
                             <label for="email" class="control-label">Email</label>
                             <input type="text" class="form-control" ng-model="email" id="email" value={{email}} required>
                         </div>
         
                         <div class="form-group">
                             <label for="renda" class="control-label">Salary</label>
                             <input type="text" class="form-control" ng-model="renda" id="renda" value="{{renda}}" required>
                         </div>
         
                         <div class="form-group">
                             <label for="dataNasc" class="control-label">Date Of Birth</label>
                             <input type="text" data-date-format="dd/mm/yyyy" class="form-control" data-provide="datepicker" ng-model="dataNasc" value="{{dataNasc}}" required>
                         </div>
         
                         <div class="form-group">
                             <label for="sexo" class="control-label">Genre</label>
                             <select required value="{{sexo}}" class="form-control" id="sexo" ng-model="sexo" required>
                                 <option value="M">Male</option>
                                 <option value="F">Female</option>
                             </select>
                         </div>
         
                         <div class="form-group">
                             <!--
                             <button ng-click="Limpar()" class="btn span2">Clear</button>
                             <button ng-click="Incluir()" class="btn btn-success span2 " ng-show="showBtnIncluir" ng-disabled="acao">Insert</button>
                             <button ng-click="Editar()" class="btn btn-info span2" ng-show="showBtnEditar" ng-disabled="acao">Edit</button>
                             <button ng-click="Excluir()" class="btn btn-danger span2" ng-show="showBtnEditar" ng-disabled="acao">Delete</button>
                             -->
         
                             <button class="btn span2 btn-default">Clear</button>
                             <button ng-click="Incluir()" class="btn btn-success span2 " ng-show="showBtnIncluir" ng-disabled="acao">Insert</button>
                             <button class="btn btn-info span2" ng-show="showBtnEditar" ng-disabled="acao"  data-toggle="modal" data-target="#confirmEditModal">Edit</button>
         
         
                             <button class="btn btn-danger span2" ng-show="showBtnEditar" ng-disabled="acao"  data-toggle="modal" data-target="#confirmDeleteModal">Delete</button>
                     
                         </div>
         
                     </div>
                 </div>
             </div>
         </div>
         
         
         <div id="confirmDeleteModal" class="modal fade" role="dialog">
               <div class="modal-dialog">
                 <div class="modal-content modal-sm">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Question</h4>
                   </div>
                   <div class="modal-body">
                     <p>Do you want delete Physical Person?</p>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                     <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="Excluir()">Yes</button>           
                   </div>
                 </div>
               </div>
             </div>
         
         
           <div id="confirmEditModal" class="modal fade" role="dialog">
               <div class="modal-dialog">
                 <div class="modal-content modal-sm">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Question</h4>
                   </div>
                   <div class="modal-body">
                      <p>Do you want edit Physical Person?</p>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                     <button type="button" class="btn btn-warning" data-dismiss="modal" ng-click="Editar()">Yes</button>      
                   </div>
                 </div>
               </div>
             </div>    
         
         
      </script>


      <script type="text/ng-template" id="home.html" ng-controller="UsuarioController" ng-cloak>
         <div class="wrapper" role="main">
         <div id="home" class="container">
            <h1 class="color2">Home</h1>
            <hr>
            <div class="jumbotron jumbotron-fluid">
              <div class="container">
                <h1 class="display-3">.::CrudAJS:.</h1>
                <p class="lead">Prototype of a Physical Person registration system that shows the AngularJS's use (client-side), with PHP (server-side) and SQLite database. Front-end using the framework BootStrap.</p>
              </div>
            </div>
            <div class="row col-md-12">
               <div class="col-md-offset-9">
                  <img class="logoJ" src="img/logoa.png">
               </div>
            </div>
            <div class="row col-md-12">
               <div class="col-md-offset-9">
                  <img class="offset-md-1 logoP" src="img/logop.png">
                  <img class="offset-md-1 logoS" src="img/logos.png">
                  <img class="offset-md-1 logoB" src="img/logob.png">
               </div>
            </div>
         </div>
      </div>
      </script>




      <script type="text/ng-template" id="login.html" ng-controller="UsuarioController">
         <div ng-bind="token" class="divToken"></div>
         <div class="wrapper" role="main">
             <div class="container">
                 <div role="form">
         
                     <h1>.::Login:.</h1>
         
                     <div ng-show="divLogin">
         
                         <div class="form-group">
                             <div class="row">
                                 <div class="span6">
                                     <div class="divMessageLogin" ng-show="showMessage">
                                         <ul>
                                             <li ng-repeat="messageLog in messageLogs">{{messageLog}}</li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>
         
                         <div class="form-group">
                             <div class="row">
                                 <label for="login" class="control-label span4">Login</label>
                             </div>
                             <div class="row">
                                 <input type="text" class="form-control span4" ng-model="login" required>
                             </div>
                         </div>
         
                         <div class="form-group">
                             <div class="row">
                                 <label for="login" class="control-label span4">Password</label>
                             </div>
                             <div class="row">
                                 <input type="password" class="form-control span4" ng-model="senha" required>
                             </div>
                         </div>
         
                         <div class="form-group">
                             <div class="row">
                                 <button ng-click="EfetuarLogin()" class="btn btn-success span2">Login</button>
                             </div>
                         </div>
                     </div>
                     <div class="row col-md-12" ng-show="btnDeslogar" ng-disabled="acao">
                       <button type="button" class="offset10 btn btn-info btn-lg" data-toggle="modal" data-target="#confirmLogoutModal">Logout</button>
                     </div>
                 </div>
             </div>
         </div>
            <div id="confirmLogoutModal" class="modal fade" role="dialog">
               <div class="modal-dialog">
                 <div class="modal-content modal-sm">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Question</h4>
                   </div>
                   <div class="modal-body">
                      <p>Do you want close session?</p>
                   </div>
                   <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="DestruirSessao()">Yes</button>      
               </div>
                 </div>
               </div>
             </div>    
         
         
           
         
         
         
      </script>
      <script type="text/ng-template" id="busca.html" ng-controller="PessoaFisicaController" ng-cloak>
         <div ng-show="ativo">
             <div class="wrapper" role="main">
                 <div class="container">
                     <div role="form">
                         <div ng-bind="token" class="divToken"></div>
                         <h1>.::Search:.</h1>
                         <input type="hidden" ng-model="codigoExclusao" id="codigoExclusao">
                         <h3>Enter the search criteria :</h3>
         
                         <div class="offset1 form-group">
                             <div class="row">
                                 <label class="radio-inline">
                                     <input type="radio" ng-click="LimparConsulta()" id="chkOpcao" checked name="opcao">FOR NAME</label>
                                 <label class="radio-inline">
                                     <input type="radio" ng-click="LimparConsulta()" id="chkOpcao2" name="opcao">FOR CODE</label>
                             </div>
                             <h4>Data for Search</h4>
         
                             <div class="input-append">
                                 <input type="text" ng-model="dado" class="form-control span4" id="dado" ng-focus="dado_focus">
                                 <button id="btnBuscar" ng-click="Buscar()" class="btn btn-info" ng-disabled="acao">Search</button>
                             </div>
                         </div>
         
                         <div id="divResultado" ng-show="showres">
         
                             <hr>
                             <div class="row">
                                 <label class="control-label span7">Filter by Name:</label>
                             </div>
                             <div class="row">
                                 <input class="form-control span2" type="search" ng-model="filtro">
                             </div>
                             <hr>
         
                             <div class="table-responsive">
                                 <table class="table" ng-model="pageSize" id="pageSize">
                                     <thead>
                                         <tr>
                                             <th>CODE</th>
                                             <th>NAME</th>
                                             <th class="visible-sm">EMAIL</th>
                                             <th class="visible-sm">SALARY</th>
                                             <th class="visible-sm">DATE BIRTH</th>
                                             <th class="visible-sm">GENRE</th>
                                             <th>EDIT</th>
                                             <th>DELETE</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr ng-repeat="pes in pessoas | filter:filtro | orderBy:'NOME' | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                             <td>{{pes.CODIGO}}</td>
                                             <td>{{pes.NOME | uppercase}}</td>
                                             <td class="visible-sm">{{pes.EMAIL | lowercase}}</td>
                                             <td class="visible-sm">{{pes.RENDA | currency}}</td>
                                             <td class="visible-sm">{{pes.DATANASC | date : format : timezone}}</td>
                                             <td class="visible-sm">{{pes.SEXO}}</td>
                                             <td>
                                                 <a href="#cadastro" ng-click="SelecionarPessoaFisica(pes)"><img class="imgAction" src="img/edit.ico"></a>
                                             </td>
                                             <td>
                                                 <a href="#busca" ng-click="Excluir_Na_Lista(pes)" ng-disabled="acao"><img class="imgAction" src="img/delete.ico"></a>
                                             </td>
                                         </tr>
                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <td>
                                                 <nav aria-label="Page navigation example">
                                                     <ul class="pagination">
                                                         <li class="page-item" ng-class="prevPageDisabled()">
                                                             <a href ng-click="prevPage()">« Prev</a>
                                                         </li>
                                                         <li class="page-item" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                                             <a href="#">{{n+1}}</a>
                                                         </li>
                                                         <li class="page-item" ng-class="nextPageDisabled()">
                                                             <a href ng-click="nextPage()">Next »</a>
                                                         </li>
                                                     </ul>
                                                 </nav>
                                     </tfoot>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
      </script>
      </div>
      <script type="text/javascript" src="js/bootstrap-datepicker.pt-BR.min.js"></script>
      <script>
         $("#dataNasc").datepicker({
             format: 'pt-BR',
             startDate: '-3d'
         });
      </script>
      <!-- Modals -->
      <div id="infoModal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" id="titleModal"></h4>
               </div>
               <div class="modal-body">
                  <p id="textModal"></p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>