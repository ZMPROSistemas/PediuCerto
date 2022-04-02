<?php

include 'cabecalho.php';


$idaluno = "538";


?>


    <script>
      angular.module("ZMFit",['ngMessages', 'angular.filter']);
      angular.module("ZMFit").controller("ZMFitCtrl", function ($scope, $http) {

     // body 


      $scope.appname = "ZM Fit - Cliente";
      $scope.urlBase="services/";
      $scope.dados=[];
      $scope.actve=1;

      var state='C';
      var ativo="S";

      var dadosAluno = function (){
        $http({
          method: 'GET',
          url: $scope.urlBase+'alunos.php?dadosAluno=S&idaluno='+<?=$idaluno?>
        }).then(function onSuccess(response){
          $scope.dadosAluno=response.data.result[0];
//          alert("entrou");
        }).catch(function onError(response){
          $scope.resultado=response.data;
          alert("Erro ao carregar seus treinos. Caso este erro persista, contate o suporte.");              
  //        alert("idtreinoAluno");
        });
      };      

      dadosAluno();

      var carregarAvaliacaoFisica = function function_name(){
        $http({
          method: 'GET',
          url: $scope.urlBase+'avaliacao_fisica.php?idaluno='+<?=$idaluno?>+'&state='+state
        }).then(function onSuccess(response){
          $scope.avaliacaoFisica=response.data.result[0];
        }).catch(function onError(response){
          $scope.resultado=response.data.result[0];
          alert("Erro ao carregar as avaliações. Caso este erro persista, contate o suporte.");              
        });
      };

      carregarAvaliacaoFisica();

    });

  </script>
  
  <style>

      .container {

          max-width: 768px;
          margin: 0 auto;
          bottom: 0;
          left: 0;
          right: 0;
          top: 0;
      }

  </style>

  </head>

	<body ng-controller="ZMFitCtrl">
    <div class="container" style="margin-top: 60px; margin-bottom: 50px;">
      <div class="row">
        <div class="col-12">
      		
          <nav class="navbar fixed-top navbar-dark bg-dark" ng-repeat="a in dadosAluno">
      		  	<a class="navbar-brand" href="#" >
      		    	<img src="icons/02.png" width="30" height="30" class="d-inline-block align-top" alt="">
      		    	<a aria-label="Toggle navigation" ng-bind="a.nome"></a>
      		  	</a>
      		</nav>

          <div class="box-group" id="accordion" ng-repeat="linha in avaliacaoFisica | orderBy:'-data'">

            <div class="panel box box-gray painel" style="background-color: black;">
              <div class="box-header">
                <h4 class="box-title">
                  <a class="my-0" data-toggle="collapse" data-parent="#accordion" href="#d{{linha.idavaliacao_fisica}}" aria-expanded="false" aria-controls="{{linha.idavaliacao_fisica}}" style="color: white !important;" >
                    <h5 ><span ng-bind="linha.protocolo"></span></h5> 
                    <small>
                      <dl class="row">
                        <dd class="col-2">Data:</dd>
                        <dd class="col-4" ng-bind="linha.data|date:'dd/MM/yyyy'"></dd>
                        <dd class="col-2">Idade:</dd>
                        <dd class="col-4" ng-bind="linha.idade_atual"></dd>
                        <dd class="col-2">Peso:</dd>
                        <dd class="col-4" ng-bind="linha.peso_atual | number:2"> Kg</dd>
                        <dd class="col-2">Gordura:</dd>
                        <dd class="col-4" ng-bind="linha.r_gordura_ideal_atual | number:2">%</dd>
                        <dd class="col-2">Peso Gordo:</dd>
                        <dd class="col-4" ng-bind="linha.r_peso_gordo | number:2">%</dd>                    
                        <dd class="col-2">Peso Magro:</dd>
                        <dd class="col-4" ng-bind="linha.r_peso_magro | number:2">Kg</dd>
                      </dl>
                    </small>
                  </a>
                </h4>
              </div>
              <div id="d{{linha.idavaliacao_fisica}}" class="panel-collapse collapse in">
                <div class="box-body">

                </div>
              </div>
            </div>
          
          </div>
        
        </div>
      </div>
    </div>
	</body>

	<footer>

	    <nav class="navbar fixed-bottom navbar-dark bg-dark">
	      	<div class="container d-flex justify-content-between">
		        <a href="index.php" class="navbar-brand d-flex"><i class="fas fa-home"></i></a>
		        <a href="aluno-treino.php" class="navbar-brand d-flex"><i class="fas fa-dumbbell"></i></a>
		        <a href="aluno-agenda.php" class="navbar-brand d-flex"><i class="fas fa-calendar-check"></i></a>
		        <a href="aluno-financeiro.php" class="navbar-brand d-flex"><i class="fas fa-hand-holding-usd"></i></a>
		        <a href="aluno-mensagens.php" class="navbar-brand d-flex"><i class="fab fa-whatsapp"></i></i></a>
	      	</div>
	    </nav>
	</footer>



  
</html>