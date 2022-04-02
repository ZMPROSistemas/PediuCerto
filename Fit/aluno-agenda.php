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


    });

  </script>
  
  <style>


      html { 
        right: 0;
        top: 0;
        scroll-behavior: smooth;
      }

      body {
        position: relative;
        background-color: black;
        color: white;
        margin-top: 100px;
        margin: 0;
        padding: 0;
      }   

      i.fas, i.fab, i.far {
        color: white;
      }

      video{
        width: 100%;
      }

      nav > .nav.nav-tabs {
        margin-top: 55px;
        color:black;
        background:grey;

      }

      nav > div a.nav-item.nav-link {
        border: none;
        color:black;
        background:grey;

      }

      nav > div a.nav-item.nav-link.active {

        border: none;
        color:white;
        background:black;

      }

      .painel {
          max-height: 600px;
      }


    </style>

  </head>

	<body ng-controller="ZMFitCtrl">

		<nav class="navbar fixed-top navbar-dark bg-dark" ng-repeat="a in dadosAluno">
		  	<a class="navbar-brand" href="#" >
		    	<img src="icons/03.png" width="30" height="30" class="d-inline-block align-top" alt="">
		    	<a aria-label="Toggle navigation"> <span ng-bind="a.nome"></span></a>
		  	</a>
		</nav>


	</body>

	<footer>

	    <nav class="navbar fixed-bottom navbar-dark bg-dark">
	      	<div class="container d-flex justify-content-between">
		        <a href="index.php" class="navbar-brand d-flex"><i class="fas fa-home"></i></a>
		        <a href="aluno-treino.php" class="navbar-brand d-flex"><i class="fas fa-dumbbell"></i></a>
		        <a href="aluno-avaliacao.php" class="navbar-brand d-flex"><i class="fas fa-notes-medical"></i></a>
		        <a href="aluno-financeiro.php" class="navbar-brand d-flex"><i class="fas fa-hand-holding-usd"></i></a>
		        <a href="aluno-mensagens.php" class="navbar-brand d-flex"><i class="fab fa-whatsapp"></i></i></a>
	      	</div>
	    </nav>
	</footer>



  
</html>