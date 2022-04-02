<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$us_id = 1;

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

?>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Cadastro</li>
						<li class="breadcrumb-item active" aria-current="page">Bancos</li>
					</ol>
				</nav>

	  			<div class="row">
					<div class="col-lg-12">
<!--		  				<div show-on-mobile>
							<h2>Mobile</h2>
						</div>

						<div show-on-tablet>
							<h2>Tablet</h2>
						</div>

						<div show-on-laptop>
							<h2>Laptop</h2>
						</div>

						<div show-on-desktop>
							<h2>Desktop</h2>
						</div>  -->
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" ng-click="tab=1" ng-class="{'active' : tab==1}">Lista</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" ng-click="tab=2" ng-class="{'active' : tab==2}">Ficha</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" ng-click="tab=3" ng-class="{'active' : tab==3}">Impressão</a>
							</li>
						</ul>
						<div class="tabs-container">
						    <div class="tab-content" ng-show="tab == 1">
						    	<div class="row bg-dark">
									<div class="form-group col-md-6 col-12  pt-3">
										<label for="em_cnpj">Procura Rápida</label>
										<div class="input-group">
											<input type="number" class="form-control" id="em_cnpj" placeholder="Pesquisa Geral">
											<div class="input-group-btn">
												<button type="button" class="btn btn-default">
													<i class="fas fa fa-search" ></i>
												</button>
											</div>
										</div>
							    	</div>
							    </div>
								<table class="table table-hover">
									<thead class="thead-dark">
										<tr>
											<th scope="col">Código</th>
											<th scope="col">Descrição</th>
											<th scope="col">Data</th>
											<th scope="col">Situação</th>
											<th scope="col">Número Conta</th>
										</tr>
									</thead>
									<tbody ng-repeat="empresa in dadosEmpresa">
										<tr class="table-light" style="color: black !important;">
											<th scope="row"><span ng-bind=""></span></th>
											<td><span ng-bind=""></span></td>
											<td><span ng-bind=""></span></td>
											<td><span ng-bind=""></span></td>
											<td><span ng-bind=""></span></td>
										</tr>
									</tbody>
								</table>
							</div>
						    <div class="tab-content" ng-show="tab == 2">
								<div class="jumbotron p-3">
									<form>
										<div class="form-row">
											<div class="form-group col-md-2 col-4">
												<label for="">Código</label>
												<input type="number" class="form-control" id="" disabled>
											</div>
											<div class="form-group col-md-10 col-12">
												<label for="">Nome Bandeira</label>
												<input type="text" class="form-control" id="">
											</div>
											<div class="form-group col-md-4 col-12">
												<label for="em_insc">Prazo (dias)</label>
												<input type="number" class="form-control" id="em_insc">
											</div>
											<div class="form-group col-md-4 col-12">
												<label for="">Taxa a Vista (%)</label>
												<input type="number" class="form-control" id="" ng-model="" >
											</div>
											<div class="form-group col-md-4 col-12">
												<label for="">Taxa a Prazo (%)</label>
												<input type="text" class="form-control" id="" >
											</div>
										</div>
										<button type="submit" class="btn btn-outline-light" ng-click="SalvarFornecedor()"><i class="fas fa-save"></i> Salvar</button>
									</form>
								</div>
						    </div>
						    <div class="tab-content" ng-show="tab == 3">
								<div class="jumbotron p-3">
									<form>
										<div class="form-row">
											<h3>Em produção</h3>
										</div>
									</form>
								</div>
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

			$scope.BuscarCEP = function(cep){

				alert("Banco de dados não encontrado.");

		    };

			$scope.BuscarCNPJ = function(cnpj){

				alert("Impossível acessar banco de dados.");

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