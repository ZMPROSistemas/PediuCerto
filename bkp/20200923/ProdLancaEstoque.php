<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

?>

<style>

	.alert {
		display: none;
	}

	.text-capitalize {
  		text-transform: capitalize; 
	}

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;
		border: none !important;
	}
	.table th {
		cursor:pointer;
		background: black !important;
		border: none !important;
	}

	.table-responsive { 
		height:auto;  
		overflow:scroll;
		background-color:#ffffff;

	}

	.md-button {
		padding: 4px 4px 0 4px;
		margin: 4px 4px 4px 4px;
		min-width: 88px;
		border-radius: 3px;
		font-size: 26px;
		text-align: center;
		text-transform: uppercase;
		text-decoration:none;
		border: none;
		outline: none;
	}	

</style>

			<div ng-controller="ZMProCtrl">	

				<div show-on-desktop>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb p-0">
							<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Lançamento Simplificado de Estoque</li>
						</ol>
					</nav>

					<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
					{{alertMsg}}
					</div>

					<div class="row">
						<div class="col-lg-12 pt-0 px-2">
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body p-2 m-0">
									<form id="formProd">
										<div class="form-row">
											<div class="form-group col-10">
												<label>Produto <span> - {{produtoEncontrado[0].pd_desc}}</span></label>
												<input autofocus type="text" class="form-control form-control-sm" id="codProd" autocomplete="off" ng-model="formProd.codProd" placeholder="Informe o Código do Produto" onKeyUp="tabenter(event,getElementById('qtde'))" ng-blur="buscaProduto(formProd.codProd)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
											</div>
											<div class="form-group col-2">
												<label>Quantidade</label>
												<div class="input-group" ng-init="formProd.qtde  = 1">
													<input type="text" class="form-control form-control-sm" id="qtde" autocomplete="off" ng-value="formProd.qtde" ng-model="formProd.qtde" onKeyUp="tabenter(event,getElementById('btnIncluir'))" onfocus="this.focus();this.select()" ng-blur="pesquisaProdutoDesktop(formProd.codProd, formProd.qtde)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
													<div class="input-group-btn">
														<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="pesquisaProdutoDesktop(formProd.codProd, formProd.qtde)" style="color: white; border: none">
															<i class="fas fa fa-plus" ></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="table-responsive px-0" style="overflow-y:hidden; overflow-x:hidden; background-color: #FFFFFFFF !important; color: black; border:none; height:360px !important;">
										<table class="table table-sm table-striped" style="background-color: #FFFFFFFF !important; color: black; border:none;">
											<thead class="thead-dark" style="font-weight: normal !important; font-size: 0.8em !important;">
												<tr>
													<th scope="col" style="text-align: left;">Código</th>
													<th scope="col" style="text-align: left;">Descrição</th> 
													<th scope="col" style="text-align: right;">Quant</th>
													<th scope="col" style="text-align: right;">Venda</th>
													<th scope="col" style="text-align: right;"></th>
												</tr>
											</thead>
											<tbody style="font-size: 0.9em !important;">
												<tr dir-paginate="produto in produtoLista | itemsPerPage:10 | orderBy:reverse:true ">
													<td style="text-align: left;" ng-bind="produto.cei_prod"></td>
													<td style="text-align: left;" class="d-inline-block text-truncate" ng-bind="produto.cei_desc"></td>
													<td style="text-align: right;" ng-bind="produto.cei_qntcontado"></td>
													<td style="text-align: right;" scope="col-flex" ng-bind="produto.cei_venda | currency: ' '">Venda</td>
													<td style="text-align: right;">
														<div class="btn-group dropleft">
<?php

include 'Modal/estoque/confirmaExclusao.php';

?>															
															<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(produto)">
																<i class="fas fa-trash"></i> 
															</button>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
								<div class="card-footer p-2">
									<div class="form-row align-items-center">
										<div class="col-6">
											<button class="btn btn-outline-danger" style="color: white;"  ng-click="sairLancamento()"><i class="fas fa-window-close"></i> Cancelar</button>
											<button class="btn btn-outline-success" ng-if="produtoLista[0].cei_prod != undefined" ng-click="lancarArray()" style="color: white;" ><i class="fas fa-save"></i> Salvar</button>
										</div>
										<div class="col-6"  style="text-align: right;">
											<a style="color: grey;">Registros: <b>{{produtoLista.length}}</b></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div show-on-laptop>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb p-0">
							<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Lançamento Simplificado de Estoque</li>
						</ol>
					</nav>

					<div class="alert {{tipoAlerta}} col-6" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
					{{alertMsg}}
					</div>

					<div class="row">
						<div class="col-12 pt-0 px-2">
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body p-2 m-0">
									<form id="formProd">
										<div class="form-row">
											<div class="form-group col-10">
												<label>Produto <span> {{formProd.codProd}}</span></label>
												<input autofocus type="text" class="form-control form-control-sm" id="codProd" ng-value="produtoEncontrado[0].pd_desc" ng-model="formProd.codProd" placeholder="Informe o Código do Produto" autocomplete="off" onKeyUp="tabenter(event,getElementById('qtde'))" ng-blur="buscaProduto(formProd.codProd)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
											</div>
											<div class="form-group col-2">
												<label>Quantidade</label>
												<div class="input-group" ng-init="formProd.qtde  = 1">
													<input type="text" class="form-control form-control-sm" id="qtde" autocomplete="off" ng-value="formProd.qtde" ng-model="formProd.qtde" onKeyUp="tabenter(event,getElementById('btnIncluir'))" onfocus="this.focus();this.select()" ng-blur="pesquisaProdutoDesktop(formProd.codProd, formProd.qtde)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
													<div class="input-group-btn">
														<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="pesquisaProdutoDesktop(formProd.codProd, formProd.qtde)" style="color: white; border: none">
															<i class="fas fa fa-plus" ></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="table-responsive px-0" style="overflow-y:hidden; overflow-x:hidden; background-color: #FFFFFFFF !important; color: black; border:none; height:360px !important;">
										<table class="table table-sm table-striped" style="background-color: #FFFFFFFF !important; color: black; border:none;">
											<thead class="thead-dark" style="font-weight: normal !important; font-size: 0.9em !important;">
												<tr>
													<th scope="col" style="text-align: left;">Código</th>
													<th scope="col" style="text-align: left;">Descrição</th> 
													<th scope="col" style="text-align: right;">Quant</th>
													<th scope="col" style="text-align: right;">Venda</th>
													<th scope="col" style="text-align: right;"></th>
												</tr>
											</thead>
											<tbody style="font-size: 0.9em !important;">
												<tr dir-paginate="produto in produtoLista | itemsPerPage:10 | orderBy:reverse:true ">
													<td style="text-align: left;" ng-bind="produto.cei_prod"></td>
													<td style="text-align: left;" class="d-inline-block text-truncate" ng-bind="produto.cei_desc"></td>
													<td style="text-align: right;" ng-bind="produto.cei_qntcontado"></td>
													<td style="text-align: right;" scope="col-flex" ng-bind="produto.cei_venda | currency: ' '">Venda</td>
													<td style="text-align: right;">
														<div class="btn-group dropleft">
<?php

include 'Modal/estoque/confirmaExclusao.php';

?>															
															<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(produto)">
																<i class="fas fa-trash"></i> 
															</button>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
								<div class="card-footer p-2">
									<div class="form-row align-items-center">
										<div class="col-6">
											<button class="btn btn-outline-danger" style="color: white;"  ng-click="sairLancamento()"><i class="fas fa-window-close"></i> Cancelar</button>
											<button class="btn btn-outline-success" ng-if="produtoLista[0].cei_prod != undefined" ng-click="lancarArray()" style="color: white;" ><i class="fas fa-save"></i> Salvar</button>
										</div>
										<div class="col-6"  style="text-align: right;">
											<span style="color: grey;">Registros: <b>{{produtoLista.length}}</b></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div show-on-tablet>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb p-0 mt-3 mx-1">
							<li class="breadcrumb-item active" aria-current="page">Lançamento Simplificado de Estoque</li>
						</ol>
					</nav>

					<div class="alert {{tipoAlerta}} col-6" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
					{{alertMsg}}
					</div>

					<div class="row">
						<div class="col-12 p-0">
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65);">
								<div class="card-body p-1 m-0">
									<form id="formProd">
										<div class="form-row">
											<div class="form-group col-12 input-group mb-1">
												<!--<label for="">Produto</label>-->
												<input autofocus type="text" class="form-control form-control-sm" id="codProd" ng-model="formProd.codProd" placeholder="Informe o Código do Produto" ng-blur="pesquisaProduto(formProd.codProd)" autocomplete="off" onKeyUp="tabenter(event,getElementById('btnIncluir'))" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="pesquisaProduto(formProd.codProd)" style="color: white; border: none">
														<i class="fas fa fa-plus" ></i>
													</button>
												</div>
											</div>
										</div>
									</form>

									<table class="table table-sm table-striped px-0 m-0" style="background-color: #FFFFFFFF; color: black;">
										<thead class="thead-dark" style="font-size: 0.9em !important;">
											<tr>
												<th col-auto style=" font-weight: normal; text-align: left;">Produto</th>
												<th col-auto style=" font-weight: normal; text-align: right;">Quant</th>
												<th col-auto style="text-align: right;"></th>
											</tr>
										</thead>
										<tbody style="font-weight: normal !important; font-size: 1em !important;">
											<tr ng-repeat="produto in produtoLista | orderBy:reverse:true">
												<td style="text-align: left;"><span style="font-size: 1em !important;">{{produto.cei_prod}}<span style="font-size: 0.7em !important;max-width: 150px;">&nbsp;&nbsp; {{produto.cei_desc}}</span></span></td>
												<!--td style="text-align: center; max-width: 250px;" ng-bind=""></!--td-->
												<td style="text-align: right; font-weight: bold !important;" ng-bind="produto.cei_qntcontado"></td>
												<td style="text-align: right;">
													<div>
<?php

include 'Modal/estoque/confirmaExclusao.php'; 

?>															
														<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(produto)">
															<i class="fas fa-trash"></i> 
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<md-button class="md-fab md-fab-bottom-left color-default-btn" md-ripple-size="auto" ng-if="produtoLista[0].cei_prod != undefined" ng-click="sairLancamento()" style="position: fixed; z-index: 999; background-color:red;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Cancelar</md-tooltip>
									<i class="fas fa-times"></i>

								</md-button>
								<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-if="produtoLista[0].cei_prod != undefined" ng-click="lancarArray()"  style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Salvar</md-tooltip>
									<i class="fas fa-save"></i> 
								</md-button>
							</div>
						</div>
					</div>
				</div>

				<div show-on-mobile>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb p-0 mt-3 mx-1">
							<li class="breadcrumb-item active" aria-current="page">Lançamento Simplificado de Estoque</li>
						</ol>
					</nav>

					<div class="alert {{tipoAlerta}} col-6" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
					{{alertMsg}}
					</div>

					<div class="row">
						<div class="col-12 p-0">
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65);">
								<div class="card-body p-1 m-0">
									<form id="formProd">
										<div class="form-row">
											<div class="form-group col-12 input-group mb-1">
												<!--<label for="">Produto</label>-->
												<input autofocus type="text" class="form-control form-control-sm" id="codProd" ng-model="formProd.codProd" placeholder="Informe o Código do Produto" ng-blur="pesquisaProduto(formProd.codProd)" autocomplete="off" onKeyUp="tabenter(event,getElementById('btnIncluir'))" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="pesquisaProduto(formProd.codProd)" style="color: white; border: none">
														<i class="fas fa fa-plus" ></i>
													</button>
												</div>
											</div>
										</div>
									</form>

									<!--md-list>
										<md-list-item ng-repeat="produto in produtoLista | orderBy:reverse:true" class="noright">
											<p>{{ produto.cei_prod }} - {{produto.cei_desc}}</p>
											<h4 style="text-align: right;" ng-bind="produto.cei_qntcontado"></h4>
											<div>
												<md-icon class="md-secondary md-dark" ng-click="abrirModalExclusao(produto)" aria-label="Excluir" >
													<i class="fas fa-trash"></i>
												</md-icon>
											</div>
										</md-list-item>
									</!--md-list-->
									
									<table class="table table-sm table-striped px-0 m-0" style="background-color: #FFFFFFFF; color: black;">
										<thead class="thead-dark" style="font-size: 0.9em !important;">
											<tr>
												<th col-auto style=" font-weight: normal; text-align: left;">Produto</th>
												<th col-auto style=" font-weight: normal; text-align: right;">Quant</th>
												<th col-auto style="text-align: right;"></th>
											</tr>
										</thead>
										<tbody style="font-weight: normal !important; font-size: 1em !important;">
											<tr ng-repeat="produto in produtoLista | orderBy:reverse:true">
												<td style="text-align: left;"><span style="font-size: 1em !important;">{{produto.cei_prod}}<span style="font-size: 0.7em !important;max-width: 150px;">&nbsp;&nbsp; {{produto.cei_desc}}</span></span></td>
												<!--td style="text-align: center; max-width: 250px;" ng-bind=""></!--td-->
												<td style="text-align: right; font-weight: bold !important;" ng-bind="produto.cei_qntcontado"></td>
												<td style="text-align: right;">
													<div>
<?php

include 'Modal/estoque/confirmaExclusao.php'; 

?>															
														<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(produto)">
															<i class="fas fa-trash"></i> 
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<md-button class="md-fab md-fab-bottom-left color-default-btn" md-ripple-size="auto" ng-if="produtoLista[0].cei_prod != undefined" ng-click="sairLancamento()" style="position: fixed; z-index: 999; background-color:red;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Cancelar</md-tooltip>
									<i class="fas fa-times"></i>

								</md-button>
								<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-if="produtoLista[0].cei_prod != undefined" ng-click="lancarArray()"  style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Salvar</md-tooltip>
									<i class="fas fa-save"></i> 
								</md-button>
							</div>
						</div>
					</div>
				</div>



				<div class="modal fade" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="ModalSelecionaEmpresa" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 style="color: black !important;"  class="modal-title" >Escolha a Empresa - {{empresaAcesso}}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<select class="form-control" id="empresa" ng-model="empresa" ng-change="alteraEmpresa(empresa)">
									<option value="">Selecione a Empresa</option>
									<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary" ng-if="empresaAcesso != '' && empresaAcesso != undefined" ng-click="lancarArray()">Salvar</button>
							</div>
						</div>
					</div>
				</div>

			</div>
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
	<script src="js/dirPagination.js"></script>	
	<script src="js/angular-locale_pt-br.js"></script>


    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.ordem = 0;
			$scope.urlBase = 'services/';
			$scope.produto = '';
			$scope.produtoEncontrado = '';
			$scope.formProd = [];
			$scope.excluirProd = '';
			$scope.qtde = 1;
			$scope.pd_cod = '';
			$scope.produtoLista = [];
			$scope.empresa = <?=base64_decode($empresa)?>;
			$scope.empresaAcesso = <?=base64_decode($empresa_acesso)?>;	
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

			$scope.setTab = function(newTab){
			    $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		    	return $scope.tab === tabNum;
		    };

			$scope.buscaProduto = function(pd_cod, empresa){
				if (pd_cod == undefined) {
					pd_cod = '';
				}
				if(pd_cod != ''){
					$http({
						method: 'GET',
						url: $scope.urlBase+'Produtos.php?consultaProduto=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod+'&empresa='+$scope.empresa
						}).then(function onSuccess(response){
							$scope.produtoEncontrado = response.data.result[0];
						}).catch(function onError(response){
							alert("Produto inexistente!");
					});
				};
			}

		    var dadosEmpresa = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaCad.php?dadosEmpresa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosEmpresa=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
				});
			};

<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>
			
			$scope.pesquisaProduto = function(pd_cod, empresa){

				if (pd_cod == undefined) {
					pd_cod = '';
				}
				if(pd_cod != ''){
					$http({
						method: 'GET',
						url: $scope.urlBase+'Produtos.php?consultaProduto=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod+'&empresa='+$scope.empresa
						}).then(function onSuccess(response){
							$scope.produto = response.data.result[0];
							if ($scope.produto[0].pd_cod != ''){
								adicionaProdutoArray($scope.produto[0].pd_cod, $scope.produto[0].pd_desc, $scope.produto[0].pd_un, $scope.produto[0].pd_custo, $scope.produto[0].pd_vista, $scope.produto[0].pd_subgrupo);
							}
						}).catch(function onError(response){
						alert("Produto inexistente!");
					});
					limparForm();
					setarFoco();
				};	

			}

			$scope.alteraEmpresa = function(empresa) {

				$scope.empresaAcesso = empresa;

			}

			$scope.pesquisaProdutoDesktop = function(pd_cod, pd_qtde, empresa){

				if (pd_cod == undefined) {
					pd_cod = '';
				}
				if (pd_qtde == undefined) {
					pd_qtde = '';
				}
				if(pd_cod != '' && pd_qtde != ''){
					$http({
						method: 'GET',
						url: $scope.urlBase+'Produtos.php?consultaProduto=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod+'&empresa='+$scope.empresa
						}).then(function onSuccess(response){
							$scope.produto = response.data.result[0];
							if ($scope.produto[0].pd_cod != ''){
								$scope.qtde = pd_qtde;
								adicionaProdutoArray($scope.produto[0].pd_cod, $scope.produto[0].pd_desc, $scope.produto[0].pd_un, $scope.produto[0].pd_custo, $scope.produto[0].pd_vista, $scope.produto[0].pd_subgrupo);
							}
						}).catch(function onError(response){
						alert("Produto inexistente!");
					});
					limparForm();
					setarFoco();
				};	

			}

			var adicionaProdutoArray = function (pd_cod, pd_desc, pd_un, pd_custo, pd_vista, pd_subgrupo) {

				if (pd_desc == undefined) {
					pd_desc = null;
				}

				if (pd_un == undefined) {
					pd_un = null;
				}

				if (pd_custo == undefined) {
					pd_custo = null;
				}

				if (pd_vista == undefined) {
					pd_vista = null;
				}

				if (pd_subgrupo == undefined) {
					pd_subgrupo = null;
				}

				var posicao = $scope.produtoLista.findIndex((user, index, array) => user.cei_prod === pd_cod);					
				//alert(posicao);
				
				if (posicao === -1) {

					var obj = {
						cei_prod: pd_cod,
						cei_desc: pd_desc,
						cei_un: pd_un,
						cei_custo: pd_custo,
						cei_venda: pd_vista,
						cei_desc_sub_grupo: pd_subgrupo,
						cei_qntcontado: parseInt($scope.qtde)
					};

					$scope.produtoLista.push(obj);						


				} else {

					$scope.produtoLista[posicao].cei_qntcontado += parseInt($scope.qtde);

				}
				$scope.qtde = 1;
			}

			$scope.lancarArray = function() {

				if ($scope.empresaAcesso == undefined || $scope.empresaAcesso == 0 || $scope.empresaAcesso == null || $scope.empresaAcesso == '') {
					$('#modalEmpresa').modal('show');
				} else {
					$('#modalEmpresa').modal('hide');
					SalvarBalanco();
				}

			}

			$scope.sairLancamento = function (produto) {
				      
				$('#modalConfirmaSair').modal('show');
					  
			}

			$scope.abrirModalExclusao = function (produto) {
				$scope.excluirProd = produto.cei_prod;
				      
				$('#modalExclusao').modal('show');
					  
			}

			$scope.excluirItem = function () {
				      
				var index = $scope.produtoLista.findIndex((user, index, array) => user.cei_prod === $scope.excluirProd);
				//alert(index);
				$scope.produtoLista.splice(index,1);
				setarFoco();

			}

			var SalvarBalanco = function(){

				var listaProdutos = $scope.produtoLista;

				$http({
					
					method: 'POST',
					headers: {
					'Content-Type':'application/json'
					},
					data: {
					listaProdutos:listaProdutos
					},
					url: $scope.urlBase+'SalvaBalanco.php?salvarBalanco=S&e=<?=$empresa?>&eA='+$scope.empresaAcesso

				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];
				
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Estoque atualizado com sucesso!";
						chamarAlerta();


								
				}).catch(function onError(response){
/*						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao lançar balanço!";
						chamarAlerta();*/

				})
				LimparTela();

			};

		    function LimparTela() {

		    	$scope.produtoLista = [];
				$scope.tipoAlerta = "alert-success";
				$scope.alertMsg = "Itens Lançados no Balanço!";
				chamarAlerta();
				

			};
			
			function limparForm() {

				document.getElementById("formProd").reset();
				$scope.formProd = {};
				$scope.formProd.qtde = 1;
			}
			
		}).config(function($mdDateLocaleProvider) {
				$mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out', 'Nov', 'Dez'];
				$mdDateLocaleProvider.Months = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
				$mdDateLocaleProvider.days = ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta','Sexta', 'Sabado'];
				$mdDateLocaleProvider.shortDays = ['D', 'S', 'T', 'Q', 'Q','S','S'];

		}).filter('numberFixedLen', function () {
			return function (n, len) {
				var num = parseInt(n, 10);
				len = parseInt(len, 10);
				if (isNaN(num) || isNaN(len)) {
					return n;
				}
				num = ''+num;
				while (num.length < len) {
					num = '0'+num;
				}
				return num;
			};
		});

		angular.module("ZMPro").directive("datDir", DatDir);

		function DatDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();
						}
					}

					$(element).mask('00/00/0000', options);

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length < 10) {//verifica a quantidade de digitos.
							mask = "00/00/0000";
						}
					$(element).mask(mask, options);//aplica a mascara novamente
					}
				}
			}
		};

		angular.module("ZMPro").directive("moneyDir", MoneyDir);

		function MoneyDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();
						}
					}

					$(element).mask('999.999.990,00', {reverse: true});

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length > 3) {//verifica a quantidade de digitos.
							mask = "999.999.990,00";
						}
					$(element).mask(mask, options);//aplica a mascara novamente
					}
				}
			}
		};

	    $(document).ready(function () {
	        $("#sidebar").mCustomScrollbar({
	            theme: "minimal"
	        });

	        $('#sidebarCollapse').on('click', function () {
	            $('#sidebar, #content').toggleClass('inactive');
	            $('.collapse.in').toggleClass('in');
	            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
			});

			$(this).find('#codProd').focus();

	    });

		$('body').on('click', function(){ 
			window.onbeforeunload = function(){ 
				return 'Os dados ainda não foram salvos, deseja sair mesmo assim?'; 
			};
		});

		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};

		function tabenter(event,campo){

			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.focus();
			}
		};
		
		function setarFoco() {

			document.getElementById("codProd").select();

		}

	</script>


</body>
</html>