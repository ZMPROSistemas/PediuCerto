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
<style>
	.pagination>li>a, .pagination>li>span {
	    position: relative;
	    float: left;
	    padding: 6px 12px;
	    line-height: 1.42857143;
	    text-decoration: none;
	    color: white;
	    background-color: rgba(0, 0, 0, 0.1);
	    border: 1px solid transparent;
	    margin-left: -1px;
	}

	.dropdown-menu a{
		color:#333;
		text-decoration:none; 
		padding:5px ;
		display:block; 
		background:white;
		cursor:pointer;
	 }
	 
	.dropdown-menu a:hover{
		background:#333;
		color:#fff !important;
		-moz-box-shadow:0 3px 10px 0 #CCC;
		-webkit-box-shadow:0 3px 10px 0 #ccc;
		list-style-type: none;
	}

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}

	.table-responsive { 
		overflow:scroll;
		background-color:#ffffff;
	}
	.table-responsive.estoque-tabe{
		overflow:scroll;
		background-color:#ffffff;
	}

</style>

			<!--<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Produtos</li>
						<li class="breadcrumb-item active" aria-current="page">Grupos de Produtos </li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} msg col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

				<div class="alert alert-dark excluir col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  Deseja Excluir o Grupo <br>
					  
				  	<button type="submit" class="btn btn-outline-danger" onclick="excluir()"><i class="fas fa-window-close"></i> Cancelar</button>
					<button type="submit" class="btn btn-outline-success" ng-click="excluir(id,2)"><i class="fas fa-save"></i> Excluir</button>
				</div>


	  			<div class="row">
					<div class="col-lg-12">
						<div ng-if="lista">
							<div class="row bg-dark p-2 col-12">
								<form class="col-12">
									<div class="form-row align-items-center">-->

			<div ng-controller="ZMProCtrl">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Produtos</li>
						<li class="breadcrumb-item active" aria-current="page">Grupos de Produtos</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
					{{alertMsg}}
				</div>

				<div class="alert alert-dark excluir col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				Deseja Excluir o Grupo <br>
					
					<button type="submit" class="btn btn-outline-danger" onclick="excluir()"><i class="fas fa-window-close"></i> Cancelar</button>
					<button type="submit" class="btn btn-outline-success" ng-click="excluir(id,2)"><i class="fas fa-save"></i> Excluir</button>
				</div>

				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">

						<div show-on-desktop ng-if="lista">
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body py-0 px-2 m-0">
									<form class="my-0 pt-2">
										<div class="form-row justify-content-between pb-2">
			
											<div class="col-auto">
												<label>Filtro</label>
											</div>

											<div class="col-3">
												<input type="text" value="" class="form-control form-control-sm text-left" id="BuscaRápida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
											</div>

											<div class="ml-auto m-0 p-0">
												<md-button class="btnPesquisar pull-right" style="border: 1px solid white; border-radius: 5px;" ng-click="busca(buscaRapida)" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
												<md-button class="btnImprimir pull-right" style="border: 1px solid green; border-radius: 5px;" ng-disabled="!listagrupoProduto[0]" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
												<md-button class="btnSalvar pull-right" id="csv" style="border: 1px solid yellow; border-radius: 5px;" ng-click="exportarCsv()" ng-disabled="!listagrupoProduto[0]" >
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Exportar</md-tooltip>
													<i class="fas fa-save"></i> Exportar
												</md-button>
											</div>
										</div>
									</form>	
							    	<div show-on-desktop>
										<div class="table-responsive p-0 mb-0" style="overflow: hidden;">
											<table class="table table-sm table-striped" id="example" style="background-color: #FFFFFFFF; color: black">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_codinterno')">Código</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_codinterno')">Descrição</th>
														<th scope="col" style=" font-weight: normal; text-align:center;">Ação</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="sub in listagrupoProduto | orderBy:'sortKey':reverse | itemsPerPage:20">
														<td ng-bind="sub.grp_codigo"></td>
														<td ng-bind="sub.grp_descricao"></td>
														<td style="text-align: center;">
															<div class="btn-group dropleft">
																<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
																	<i class="fas fa-ellipsis-v"></i> 
																</button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" ng-click="buscarGrupo(sub)">Editar</a>
																	<a class="dropdown-item" ng-click="excluir(sub,1)">Excluir	</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
											<div ng-if="arrayNull == true">
												<div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
													Aguarde... Pesquisando!
												</div>
											</div>
										</div>

										<div class="card-footer p-0 py-2">
											<div class="form-row align-items-center">
												<div class="col-6" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: grey;">Quantidade Total: <b>{{listagrupoProduto.length}}</b></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
	                      		<i class="fa fa-plus"></i>
    	                	</md-button>
					    </div>

						<div ng-if="ficha">
				  			<div class="row justify-content-center" style="height: 100px;">
								<div class="card border-dark mb-3" style="width: 25rem; background-color:rgba(0,0,0, .65);">
									<div class="card-header">
										<form>
											<div class="form-row">
												<div class="form-group col-6">
													<label for="codGrupo">Cadastro De Grupo</label>
													<!--input type="number" class="form-control" id="codGrupo" readonly-->
												</div>
											</div>
										</form>
									</div>
									<div class="card-body">
										<form>
											<div class="form-row">
												<div class="form-group col-12" ng-init="grupoProduto.grp_descricao = grupoProduto[0].grp_descricao">
													<label for="nomeGrupo">Nome do Grupo</label>
													<input type="text" autocomplete="off" class="form-control capoTexto" id="nomeGrupo" ng-model="grupoProduto.grp_descricao" value="grupoProduto.grp_descricao">
												</div>
											</div>
										</form>
									</div>
									<div class="card-footer">
										
										<button type="submit" class="btn btn-outline-danger" style="color: white;" ng-click="cancela()"><i class="fas fa-window-close"></i> Cancelar</button>
										<button type="submit" class="btn btn-outline-success" ng-click="editarSalvar(grupoProduto)"><i class="fas fa-save"></i> Salvar</button>
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
   	<script src="js/angular-locale_pt-br.js"></script>

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>
	
	<script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $window) {

	    	'use strict';
	    	this.isOpen = false;

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.listagrupoProduto = [];
			$scope.descricaoGrupo = '';
			$scope.grupoProduto=[{
				grp_id:'',
				grp_descricao:'',
			}];
			$scope.mudarEditarSalvar = 1;
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

		    $scope.MudarVisibilidade = function(e) {
		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;
				$scope.mudarEditarSalvar = e;
			}

			var dadosEmpresa = function () {	
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaCad.php?dadosEmpresa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosEmpresa=response.data.result[0];
					//dadosSubGrupo();
				}).catch(function onError(response){
					
				});
			};
			<?php if (base64_decode($empresa_acesso) == 0) {?>
				dadosEmpresa();
			<?php }?>

			
			var dadosGrupo =function(){
				$http({
					method: 'GET',
					url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&descricao='+$scope.descricaoGrupo
				}).then(function onSuccess(response){
					$scope.listagrupoProduto = response.data.result[0];
				}).catch(function onError(response){

				});
			}
			dadosGrupo();

			$scope.busca = function(descricao) {
				if (descricao == undefined) {
					descricao = '';
				}
				$scope.descricaoGrupo = descricao;
				dadosGrupo();
			}

			$scope.buscarGrupo = function(sub){
				$scope.mudarEditarSalvar = 2;
				$http({
					method: 'GET',
					url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&buscar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&grp_id='+sub.grp_id
				}).then(function onSuccess(response){
					$scope.grupoProduto = response.data.result[0];
					$scope.MudarVisibilidade(2);
				}).catch(function onError(response){

				});
			}

			$scope.editarSalvar = function(sub){

				if ($scope.mudarEditarSalvar == 1) {
					$scope.salvarGrupo(sub);
				}

				if ($scope.mudarEditarSalvar == 2) {
					$scope.editarGrupo(sub);
				}
			}

			$scope.editarGrupo = function(sub){
				$http({
					method: 'GET',
					url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&editar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&grp_id='+$scope.grupoProduto[0].grp_id+'&grp_desc='+sub.grp_descricao
				}).then(function onSuccess(response){
					$scope.MudarVisibilidade(1);
					if (response.data <= 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Cadastro Não Pode Ser Atualizado!";
						chamarAlertaMg();
					}
					else if(response.data >= 1){
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
						chamarAlertaMg();
					}
					dadosGrupo();
					$scope.MudarVisibilidade(1);
					$scope.cancela();
				}).catch(function onError(response){

				});
			}

			$scope.salvarGrupo = function(sub){

				if(sub.grp_descricao == undefined){

					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Nome Do Grupo!";
					chamarAlertaMg();

				}
				else if(sub.grp_descricao == ''){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Nome Do Grupo!";
					chamarAlertaMg();
				}
				else{
					$scope.MudarVisibilidade(1);
					$http({
					method: 'GET',
					url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&salvar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&grp_desc='+sub.grp_descricao
					}).then(function onSuccess(response){
						
						if (response.data <= 0) {
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
							chamarAlertaMg();
						}

						else if(response.data >= 1){
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
							chamarAlertaMg();
						}
						dadosGrupo();
						$scope.MudarVisibilidade(1);
						$scope.cancela();
					}).catch(function onError(response){

					});
				}
				
			}


			$scope.excluir = function(sub,e){
				if(e == 1){
					excluir();
					$scope.id = sub.grp_id;
				}
				else if(e == 2){

					$http({
						method: 'GET',
						url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&excluir=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&grp_id='+sub
						}).then(function onSuccess(response){
							
							if (response.data <= 0) {
								$scope.tipoAlerta = "alert-danger";
								$scope.alertMsg = "Cadastro Não Pode Ser Excluido!";
								chamarAlertaMg();
							}
							else if(response.data >= 1){
								$scope.tipoAlerta = "alert-success";
								$scope.alertMsg = "Cadastro Excluido Com Sucesso";
								chamarAlertaMg();
							}
							dadosGrupo();

						}).catch(function onError(response){

						});
						excluir();
				}
				
			}



			$scope.cancela = function(){
				$scope.grupoProduto =[];
				$scope.MudarVisibilidade(1);
			}
		});
          
		<?php
			include 'controller/funcoesBasicas.js';
		?>

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