<?php

include 'cabecalho.php';


$idaluno = "538";


?>


    <script>
      angular.module("ZMFit",['ngMessages', 'angular.filter']);
      angular.module("ZMFit").controller("ZMFitCtrl", function ($scope, $http) {

     // body 


      $scope.appname = "ZM Fit - Cliente";
      $scope.caminhoVideo="../AcademiaNova/videos/";
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
          treinoAluno();
         }).catch(function onError(response){
          $scope.resultado=response.data;
          alert("Erro ao carregar seus treinos. Caso este erro persista, contate o suporte.");              
  //        alert("idtreinoAluno");
        });
      };      

      dadosAluno();

      var treinoAluno = function (){
        $http({
          method: 'GET',
          url: $scope.urlBase+'treino_lista.php?treinoAluno=S&idaluno='+<?=$idaluno?>
        }).then(function onSuccess(response){
          $scope.treinoAluno=response.data.result[0];
          exerciciosDoAluno();
//          alert("entrou");
         }).catch(function onError(response){
          $scope.resultado=response.data;
 //         alert("Erro ao carregar seus treinos. Caso este erro persista, contate o suporte.");              
  //        alert("idtreinoAluno");
        });
      };

      var exerciciosDoAluno = function (){
        $http({
          method: 'GET',
          url: $scope.urlBase+'treino_lista.php?exerciciosDoAluno=S&idaluno='+<?=$idaluno?>
        }).then(function onSuccess(response){
          $scope.exerciciosDoAluno=response.data.result[0];
//          alert("entrou");
         }).catch(function onError(response){
          $scope.resultado=response.data;
          alert("Erro ao carregar seus exercícios. Caso este erro persista, contate o suporte.");              
  //        alert("idtreinoAluno");
        });
      };

      $scope.serieItemAluno = function (id) {
        $http({
          method: 'GET',
          url: $scope.urlBase+'treino_lista.php?serieItemAluno=S&id='+id
        }).then(function onSuccess(response){
          $scope.serieItemAluno=response.data.result[0];

 //          alert("entrou");
         }).catch(function onError(response){
          $scope.resultado=response.data;
          alert("Erro ao carregar suas séries. Caso este erro persista, contate o suporte.");              
  //        alert("idtreinoAluno");
        }); 
      };

      $scope.activeAbaTreino=function(mudarTreino){
        $scope.actve=mudarTreino;
        //limparCampo();

      };

    });

  </script>
  
  <style>

  </style>

  </head>

  <body ng-controller="ZMFitCtrl">
    
    <nav class="navbar fixed-top navbar-dark bg-dark" ng-repeat="a in dadosAluno">
      <a class="navbar-brand" href="#" >
        <img src="icons/01.png" width="30" height="30" class="d-inline-block align-top" alt="">
        <a aria-label="Toggle navigation"> <span ng-bind="a.nome"></span>
          </a>
      </a>
    </nav>
    
    <nav>
      <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

        <a class="nav-item nav-link" ng-repeat="treino in treinoAluno" data-toggle="tab" ng-class="treino.ordem==actve ? 'active': ''" id="{{treino.idtreinoAluno}}" href="#p{{treino.idtreinoAluno}}" ng-click="activeAbaTreino(treino.ordem)" role="tab" aria-controls="{{treino.idtreinoAluno}}"><b><h6 ng-bind="treino.nome"></h6></b></a>

      </div>
    </nav>

    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
      <div class="tab-pane fade" ng-repeat="treino in treinoAluno" ng-class="treino.ordem==actve ? 'show active': ''" id="p{{treino.idtreinoAluno}}"  aria-labelledby="{{treino.idexercicioTreinoAluno}}" role="tabpanel">

        <div class="box-group" id="accordion" ng-repeat="z in exerciciosDoAluno | filter:{idtreinoAluno:treino.idtreinoAluno} | orderBy:'ordemExerc/1'">

          <div class="panel box box-gray painel" style="background-color: black;">
            <div class="box-header">
              <h4 class="box-title" ng-click="serieItemAluno(z.idexercicioTreinoAluno)" >
                 <a data-toggle="collapse" data-parent="#accordion" href="#iniciarTreino" aria-expanded="false" aria-controls="{{z.caminhoVideo}}" style="color: white !important;">
                  <h5 ng-bind="z.nomeEx"></h5>
                  <h6 class="mb-1">Séries x Repetições: <span ng-bind="z.series"></span> x <span ng-bind="z.repeticoes"></span></h6>
                  <h6 class="mb-1">Descanso: <span ng-bind="z.descanso"></span> segundos</h6>
                  <h6 class="mb-1">Dica: <span ng-bind="z.dica"></span></h6>
                </a>
              </h4>
             
            </div>
            <div id="iniciarTreino" class="panel-collapse collapse in">
              <div class="box-body">

                <video controls loop muted >
                  <source src='../AcademiaNova/videos/{{z.caminhoVideo}}' type="video/mp4">
                </video>

                <div class="btn-toolbar justify-content-between m-4" style="color: white !important;">
                  <div class="btn-group" role="group" ng-repeat="y in serieItemAluno">
                    <button type="button " class="btn btn-outline-light border">
                      <p class="m-0 text-left"><span ng-bind="y.series"></span> x</p>
                      <p class="m-0 text-left"><b><span ng-bind="y.carga"></span> Kg</b></p>
                      <small><span ng-bind="z.tipo_repeticoes"></span></small>
                    </button>
                  </div>
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
        <a href="aluno-avaliacao.php" class="navbar-brand d-flex"><i class="fas fa-notes-medical"></i></a>
        <a href="aluno-agenda.php" class="navbar-brand d-flex"><i class="fas fa-calendar-check"></i></a>
        <a href="aluno-financeiro.php" class="navbar-brand d-flex"><i class="fas fa-hand-holding-usd"></i></a>
        <a href="aluno-mensagens.php" class="navbar-brand d-flex"><i class="fab fa-whatsapp"></i></i></a>
      </div>
    </nav>
  </footer>



  
</html>
