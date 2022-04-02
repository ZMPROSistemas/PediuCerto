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
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Lançamento Simplificado de Estoque</li>
					</ol>
				</nav>

	  			<div class="row">
					<div class="col-lg-12">
						<div class="card border-dark" style="background-color:rgba(0,0,0, .65); height: 75vh; z-index: 999;">
							<div class="card-header p-2">
								<div layout="row" layout-align="space-between start">
									<div show-on-desktop>
										<div class="col-flex">
											<md-switch class="m-0" aria-label="pedeQuantidade">Pedir Quantidade</md-switch>
											<md-switch class="m-0" aria-label="avisaLancado">Avisar Produto Já Lançado</md-switch>
										</div>
									</div>
									<div class="col-flex" ng-init="YesNo1 = 'false'">
										<md-switch class="m-0" aria-label="fixaItem">Fixar Item</md-switch>
										<md-switch class="m-0" aria-label="acresceItem">Acrescentar Item</md-switch>
										<md-switch class="m-0" aria-label="debitaItem">Debitar Item</md-switch>
									</div>
									<div class="col-flex" ng-init="YesNo2 = 'false'">
										<md-switch class="m-0" aria-label="estReal">Estoque Real</md-switch>
										<md-switch class="m-0" aria-label="estMinimo">Estoque Mínimo</md-switch>
										<!--<span>Quantidade Itens: <b>0</b></span>-->
									</div>
								</div>
							</div>
							<div class="card-body p-2">
								<div show-on-desktop>
									<form>
										<div class="form-row">
											<div class="form-group col-md-8 col-12">
												<label for="">Produto</label>
												<input type="text" class="form-control form-control-sm" id="BuscaRápida" placeholder="Informe o Código ou Nome do Produto">
											</div>
											<div class="form-group col-md-2">
												<label for="">Quantidade</label>
												<input type="number" class="form-control form-control-sm" id="">
											</div>
											<div class="form-group col-md-2">
												<label for="">Valor Unit.</label>
												<div class="input-group">
													<input type="text" class="form-control form-control-sm" id="" style="color: white !important; background-color: transparent; border-color: transparent;" readonly>
													<div class="input-group-btn">
														<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;">
															<i class="fas fa fa-plus" ></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<table class="table table-sm table-dark">
										<thead>
											<tr>
												<th scope="col-flex">Código</th>
												<th scope="col-flex">Descrição</th> 
												<th scope="col-flex">Quant</th>
												<th scope="col-flex">Venda</th>
												<th scope="col-flex">Total</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
								<div show-on-mobile>
									<form>
										<div class="form-row">
											<div class="form-group col-12">
												<label for="">Produto</label>
												<input type="text" class="form-control form-control-sm" id="BuscaRápida" placeholder="Informe o Código ou Nome do Produto">
											</div>
										</div>
									</form>
									<table class="table table-sm table-dark">
										<thead>
											<tr>
												<th scope="col-flex">Código</th>
												<th scope="col-flex">Descrição</th>
												<th scope="col-flex">Quant</th>
												<th scope="col-flex">Total</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer p-2">
								<form>
									<div class="form-row align-items-center">
										<div class="col-7">
											<button type="submit" ng-if="VerificaObrigatorios" class="btn btn-outline-success" ng-click="SalvarBalanco()"><i class="fas fa-save"></i> Salvar</button>
											<button type="submit" class="btn btn-outline-danger" style="color: white;"  ng-click="MudarVisibilidade()"><i class="fas fa-window-close"></i> Cancelar</button>
										</div>
										<!--<div class="col-2">
											<label style="font-size: 2em;">R$</label>
										</div>
										<div class="col-3">
											<input type="text" class="form-control" style="font-size: 2em; text-align: right; color: red !important; background-color: rgba(0,0,0, .5); border-color: transparent;" value="0,00" readonly>
										</div>-->
									</div>
								</form>
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
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/material-components-web.min.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

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

			$scope.pesquisaProduto = function(codigo){
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?visualizarProdutos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&codigo='+codigo
					}).then(function onSuccess(response){
						$scope.produto = response.data.result[0];
						console.log($scope.produto);
					}).catch(function onError(response){
				});
			};
			
			$scope.AdicionarProdutoLista = function(pd_id, pd_desc, pd_empresa, pd_matriz, pdi_val_desc, pdi_val_adicional, pdi_preco_total_item, pdi_total, pdi_obs, pdi_status){

		    	if (pdi_produto == undefined) {
		    		pdi_produto = null;
		    	}
		    	if (pdi_descricao == undefined) {
		    		pdi_descricao = null;
		    	}
		    	if (pdi_quantidade == undefined) {
		    		pdi_quantidade = null;
		    	}
		    	if (pdi_preco_base == undefined) {
		    		pdi_preco_base = null;
		    	}
		    	if (pdi_val_desc == undefined) {
		    		pdi_val_desc = null;
		    	}
		    	if (pdi_val_adicional == undefined) {
		    		pdi_val_adicional = null;
		    	}
		    	if (pdi_preco_total_item == undefined) {
		    		pdi_preco_total_item = null;
		    	}
		    	if (pdi_total == undefined) {
		    		pdi_total = null;
		    	}
		    	if (pdi_obs == undefined) {
		    		pdi_obs = null;
		    	}
		    	if (pdi_status == undefined) {
		    		pdi_status = null;
		    	}


				var obj = {
					ordem: $scope.ordem,
					pdi_produto: pdi_produto,
					pdi_descricao: pdi_descricao,
					pdi_quantidade: parseInt(pdi_quantidade),
					pdi_preco_base: parseFloat(pdi_preco_base),
					pdi_val_desc: parseFloat(pdi_val_desc),
					pdi_val_adicional: parseFloat(pdi_val_adicional),
					pdi_preco_total_item: parseFloat(pdi_preco_total_item),
					pdi_total: pdi_total,
					pdi_obs: pdi_obs,
					pdi_status: pdi_status,
					removido:'N'
				};

				$scope.itensPedido.push(obj);
				$scope.ordem=$scope.ordem+1;

			};

			$scope.SalvarBalanco = function(){

				alert("Não foi possível salvar.");

		    };

		    $scope.MudarVisibilidade = function() {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;

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