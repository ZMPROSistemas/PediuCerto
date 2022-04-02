<!DOCTYPE html>
<html lang="pt-br" ng-app="ZMPro" ng-cloak>

    <head>

        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-square310x310logo" content="icon_largetile.png">
        <meta name="msapplication-TileImage" content="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>ZM Pro - Administrativo</title>

        <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-180x180.png" />
        <link rel="stylesheet" href="css/angular-material.min.css">
        <link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/mCustomScrollbar.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.css" rel="stylesheet"/> 
       
<!--
        <script src=“js/angular.min.js”></script>
-->
        <script src="js/solid.js"></script>
        <script src="js/fontawesome.min.js"></script>

        <!-- Fim -->

    </head>

<body media-styles>

<div ng-controller="ZMProCtrl">

    <div class="modal fade" id="exibirEmp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exibirEmp">Empresa Existente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card" style="width: 18rem; color:#000; margin:0 auto;">

                <div class="alert alert-warning" role="alert">
                    Ao gerar um novo token para {{empresa[0].em_razao}}, <br>
                    alguns <br>
                    - Recursos,<br>
                    -Dependências,<br>
                    -Service, <br>
                    pode para de funcionar, se desejar continuar avise o desenvolvedor
                </div>
                <div class="card-header">
                    <span>ID: {{empresa[0].em_cod}} </span> - {{empresa[0].em_razao}}
                </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Token: {{empresa[0].token}}</li>
                    </ul>  
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Canselar</button>
            <button type="button" class="btn btn-primary" ng-click="gerarToken(empresa[0].em_cod)">Trocar Token</button>
        </div>
        </div>
    </div>
    </div>

    <form style="width:20%; margin:0 auto; margin-top:20px;">

    <div class="form-group">
        <label for="exampleInputEmail1">ID Empresa</label>
        <input type="text" class="form-control" ng_model="IDempresa" value="" ng-enter="verToken(IDempresa)">
        
    </div>
    <button type="submit" class="btn btn-primary" ng-click="verToken(IDempresa)"; style="width:100%">Gerar Token</button>

    </form>

    <div class="alert alert-primary" role="alert" style="width:20%; margin:0 auto; margin-top:20px; {{alerta}}">
        Token: {{token}}
    </div>

</div>





    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/jquery.mask.js"></script>
	

    <script  id="INLINE_PEN_JS_ID">
        angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

            $scope.urlBase="services/";
            $scope.empresa=[];
            $scope.token;
            $scope.alerta =  'display: none;';

            $scope.gerarToken = function(id){
                $http({
					method: 'GET',
					url: $scope.urlBase+ 'verToken.php?geraToken=S&empresa='+id
				}).then(function onSuccess(response){
                    $scope.token = response.data;
                    $scope.alerta = 'display: block;';
                    $('#exibirEmp').modal('hide');
                }).catch(function onError(response){

                })

            }

            $scope.verToken = function(id){
                $http({
					method: 'GET',
					url: $scope.urlBase+'verToken.php?verToken=S&empresa='+id
				}).then(function onSuccess(response){

                    $scope.retorno = response.data;

                    if ($scope.retorno[0].token == 'null') {
                        $scope.gerarToken(id);
                    }else{
                        $scope.empresa= response.data;
                        $('#exibirEmp').modal('show');
                    }
                    
                }).catch(function onError(response){

                });
            }
        }).directive('ngEnter', function () {
		   return function (scope, element, attrs) {
		     element.bind("keydown keypress", function (event) {
		       if(event.which === 13) {
		         scope.$apply(function (){
		           scope.$eval(attrs.ngEnter);
		         });
		         event.preventDefault();
		       }
             });
            }
        });
		   
    </script>
    
    </body>