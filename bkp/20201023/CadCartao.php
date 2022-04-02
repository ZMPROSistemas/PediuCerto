<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

?>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Cadastro Cartões</li>
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
						<div ng-if="lista">
					    	<div class="row bg-dark" >
								<div class="form-group col-md-6 col-12 pt-3">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm" id="BuscaRápida" placeholder="Pesquisa Rápida">
										<div class="input-group-btn">
											<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;">
												<i class="fas fa fa-search" ></i>
											</button>
										</div>
									</div>
						    	</div>
						    </div>
					    	<md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
							      <span>Lista de Cartões</span>
					    	</md-subheader>
				    		<md-list>
				    		 	<md-list-item class="md-3-line" ng-repeat="dados in dadosFornecedor" ng-click="null">
				    		 		<div class="md-list-item-text" layout="row" layout-align="space-around center">
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="80" ng-bind=""></div>
				    		 			<div flex="10">
				    		 				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false">
				    		 					<md-fab-trigger>
									                <md-button aria-label="menu" class="md-warn">
									                  <!--
									                  <md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>
									                -->
									                  <i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #212529; font-size: 15px;"></i>
									                </md-button>
									            </md-fab-trigger>
									            <md-fab-actions>
									            	<md-button type="submit" aria-label="{{item.name}}" name="op" value="2" class="md-fab md-raised md-mini">
								                     	<i class="fa fa-address-card" aria-label="menu" style="color:#01255e; size: 35px;"></i>
								                  	</md-button>
								                  	<md-button type="submit" aria-label="{{item.name}}" name="op" value="3" class="md-fab md-raised md-mini">
								                     	<i class="fa fa-dollar" aria-label="menu" style="color:#016306"></i>
								                  	</md-button>
									            </md-fab-actions>
				    		 				</md-fab-speed-dial>
				    		 			</div>
				    		 		</div>
				    		 	</md-list-item>
				    		 	<md-divider ></md-divider>
				    		</md-list>
							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
	                      		<i class="fa fa-plus"></i>
    	                	</md-button>
					    </div>

						<div ng-if="ficha">
				  			<div class="row justify-content-center" style="height: 100px;">
								<div class="card border-dark mb-3" style="width: 30rem; background-color:rgba(0,0,0, .65);">
									<div class="card-header">
										<form>
											<div class="form-row">
												<div class="form-group col-12">
													<label for="bandeira">Bandeira do Cartão</label>
													<input type="text" class="form-control" id="bandeira">
												</div>
											</div>
										</form>
									</div>
									<div class="card-body">
										<form>
											<div class="form-row">
												<div class="form-group col-4">
													<label for="prazo">Prazo (dias)</label>
													<input type="number" class="form-control" id="prazo">
												</div>

												<div class="form-group col-4">
													<label for="txVista">Taxa a Vista (%)</label>
													<input type="number" class="form-control" id="" ng-model="txVista" >
												</div>
												<div class="form-group col-4">
													<label for="txPrazo">Taxa a Prazo (%)</label>
													<input type="number" class="form-control" id="txPrazo" >
												</div>
											</div>
										</form>
									</div>
									<div class="card-footer">
										<button type="submit" class="btn btn-outline-success" ng-click="SalvarCliente()" ng-if="VerificaObrigatorios"><i class="fas fa-save"></i> Salvar</button>
										<button type="submit" class="btn btn-outline-danger" style="color: white;" ng-click="MudarVisibilidade()"><i class="fas fa-window-close"></i> Cancelar</button>
									</div>
								</div>
							</div>
					    </div>

						<div class="jumbotron p-3" ng-if="carregado2">
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

		        <!-- Page Content  -->

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
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/dirPagination.js"></script>	
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;

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

		    $scope.MudarVisibilidade = function() {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;

		    }

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