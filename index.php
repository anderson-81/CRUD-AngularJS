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
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="css/bootstrap-datepicker.css">
      <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="js/ui-bootstrap-tpls-0.11.0.js"></script>
      <link rel="stylesheet" href="css/style.css">
      <link rel="shortcut icon" href="img/angularjs.ico" type="image/x-icon" />

      <style>
       
       

      </style>


</head>
<body>
    <nav class="navbar navbar-inverse" role="navigation">
         <div class="container">
            <div class="navbar-header">
               <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button> 
               <a class="navbar-brand" href="#">.:CrudAJS.</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li class="padLink"><a href="#home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                  <li class="padLink"><a href="#cadastro" ng-controller="PessoaFisicaController" ng-click="LimparClick()"><span class="glyphicon glyphicon-edit"></span> Registration</a></li>
                  <li class="padLink"><a href="#busca" ng-controller="PessoaFisicaController" ng-click="LimparClick()"><span class="glyphicon glyphicon-search"></span> Search</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li class="padLink"><a href="#login" ng-controller="UsuarioController" id="linkLogin"><span class="glyphicon glyphicon-log-in"></span> Logon</a></li>
               </ul>
            </div>
         </div>
      </nav>

      <div ng-view></div>

      
      <script type="text/ng-template" id="home.html" ng-controller="UsuarioController" ng-cloak>
        <div id="home" class="container">
            <h1 class="color2">Home</h1>
            <div class="jumbotron">
                Prototype of a Physical Person registration system that shows the AngularJS's use (client-side), with PHP (server-side) and SQLite database. Front-end using the framework BootStrap.
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
      </script>

       <script type="text/ng-template" id="login.html" ng-controller="UsuarioController">
          <div class="container">
             <h1>.:Login.</h1>
             <div ng-show="divLogin" class="col-md-4">

                 <div class="form-group">
                    <input type="hidden" class="form-control" ng-model="token" required>
                 </div>

                 <div class="form-group">
                    <div class="divMessageLogin" ng-show="showMessage">
                      <ul>
                          <li ng-repeat="messageLog in messageLogs">{{messageLog}}</li>
                      </ul>
                    </div>
                 </div>
 
                 <div class="form-group">
                    <label for="login" class="control-label">Login</label>
                    <input type="text" class="form-control" ng-model="login" required>
                 </div>
 
                 <div class="form-group">
                    <label for="login" class="control-label">Password</label>
                    <input type="password" class="form-control" ng-model="senha" required>
                 </div>
 
                 <div class="form-group">
                      <button ng-click="EfetuarLogin()" class="col-md-4 btn btn-success">Login</button>
                 </div>
             </div>
         </div>
      </script>
         


      <script type="text/ng-template" id="cadastro.html" ng-controller="PessoaFisicaController" ng-cloak ng-init="Limpar()" ng-disabled="divReg">
         <div ng-show="ativo">
                 <div id="cadastro" class="container">
                     <h1>.:Registration.</h1>

                      <div class="col-md-8">


                         <div class="form-group">
                             <input type="hidden" ng-bind="token">
                             <input type="hidden" ng-model="codigo" value="">
                         </div>
         
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
                             <input type="text" data-date-format="dd/mm/yyyy" class="form-control" data-provide="datepicker" readonly ng-model="dataNasc" value="{{dataNasc}}" required>
                         </div>
         
                         <div class="form-group">
                             <label for="sexo" class="control-label">Genre</label>
                             <select required value="{{sexo}}" class="form-control" id="sexo" ng-model="sexo" required>
                                 <option value="M">Male</option>
                                 <option value="F">Female</option>
                             </select>
                         </div>
         
                         <div class="form-group">
                             <button class="col-md-2 btn btn-default" ng-click="Limpar()">Clear</button>
                             <button ng-click="Incluir()" class="col-md-2 btn btn-success" ng-show="showBtnIncluir" ng-disabled="acao">Insert</button>
                             <button class="col-md-2 btn btn-info" ng-show="showBtnEditar" ng-disabled="acao"  data-toggle="modal" data-target="#confirmEditModal">Edit</button>
                             <button class="col-md-2 btn btn-danger" ng-show="showBtnEditar" ng-disabled="acao"  data-toggle="modal" data-target="#confirmDeleteModal">Delete</button>
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


      <script type="text/ng-template" id="busca.html" ng-controller="PessoaFisicaController" ng-cloak>
         <div ng-show="ativo">
            <div class="container">
                <h1>.:Search.</h1>
                
                <div class="form-group">
                  <input type="hidden" ng-bind="token">
                  <input type="hidden" ng-model="codigoExclusao" id="codigoExclusao">
                </div>

                <h3>Enter the search criteria :</h3>
         
                <div class="form-group">
                  <label class="radio-inline">
                  <input type="radio" ng-click="LimparConsulta()" id="chkOpcao" checked name="opcao">FOR NAME</label>
                  <label class="radio-inline">
                  <input type="radio" ng-click="LimparConsulta()" id="chkOpcao2" name="opcao">FOR CODE</label>
                </div>
                
                <h4>Data for Search</h4>
              
                <div class="form-group">
                    <div class="row col-md-4">
                        <input type="text" ng-model="dado" class="form-control" id="dado" ng-focus="dado_focus">
                    </div>
                    <button id="btnBuscar" ng-click="Buscar()" class="col-md-1 btn btn-info" ng-disabled="acao">Search</button>
                </div>
                
                <div class="row"><p></p></div>
                  
                  <div id="divResultado" ng-show="showres">
                  
                    <div class="span3 form-group">
                      <hr>
                        <label class="control-label">Filter by Name:</label>
                        <input class="form-control input-normal" type="search" ng-model="filtro" required>
                      <hr>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-condensed" ng-model="pageSize" id="pageSize">
                        <thead>
                          <tr>
                            <th>CODE</th>
                            <th>NAME</th>
                            <th class="visible-sm">EMAIL</th>
                            <th class="visible-sm">SALARY</th>
                            <th class="visible-sm">DATE BIRTH</th>
                            <th class="visible-sm">GENRE</th>
                            <th>SELECT</th>
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
                            <td><a href="#cadastro" ng-click="SelecionarPessoaFisica(pes)"><img class="imgAction" src="img/select.png"></a></td>
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
      </script>
      
      <script type="text/javascript" src="js/bootstrap-datepicker.pt-BR.min.js"></script>
      <script>
         $("#dataNasc").datepicker({
             format: 'pt-BR',
             startDate: '-3d'
         });
      </script>
      
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
      <div id="confirmLogoutModal" class="modal fade" role="dialog" ng-controller="UsuarioController">
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
     
   </body>
</html>