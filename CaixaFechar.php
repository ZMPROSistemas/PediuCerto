<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$us_id = 1;

?>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Caixa</li>
						<li class="breadcrumb-item active" aria-current="page">Fechamento</li>
					</ol>
				</nav>
 
	  			<div class="row justify-content-center" style="height: 100%;">
					<div class="card border-dark" style="width: 25rem; background-color:rgba(0,0,0, .65);">
						<div class="card-header">
							<h4>Fechamento de Caixa</h4>
						</div>
						<div class="card-body">
							<h5 class="card-title">Caixa: <b>Empresa</b></h5>
							<p class="card-text">Data: <span ng-non-bindable>{{1288323623006 | date:'dd/MM/yyyy HH:mm: Z'}}</span>:
   <span>{{1288323623006 | date:'dd/MM/yyyy HH:mm'}}</span><br></p>
							<label for="em_cod">Valor</label>
							<input type="number" class="form-control" id="em_cod">
								<a href="#" class="btn btn-outline-light mt-3 ">Abrir Caixa</a>
								<a href="#" class="btn btn-outline-light mt-3">Cancelar</a>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>

		        <!-- Page Content  -->

    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>

    <script>

	    angular.module("ZMPro",['ngMessages']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http) {

		    $scope.tab = 1;

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

			$scope.SalvarEmpresa = function(){

				alert("Não foi possível salvar. Código da empresa não encontrado.");

		    };
			
		});
          
	</script>


	<script type="text/javascript">

	    $(document).ready(function () {
	        $("#sidebar").mCustomScrollbar({
	            theme: "minimal"
	        });

	        $('#sidebarCollapse').on('click', function () {
	            $('#sidebar, #content').toggleClass('active');
	            $('.collapse.in').toggleClass('in');
	            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
	        });
	    });

	</script>


</body>
</html>