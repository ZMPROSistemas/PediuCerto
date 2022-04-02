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

.alert{display: none;}

	.text-capitalize {
	  text-transform: capitalize; }


	.md-fab:hover, .md-fab.md-focused {
	  background-color: #000 !important; }

	p.note {
	  font-size: 1.2rem; }

	.lock-size {
	  min-width: 300px;
	  min-height: 300px;
	  width: 300px;
	  height: 300px;
	  margin-left: auto;
	  margin-right: auto; }

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

	.dropdown-menu li:hover ul, .dropdown-menu li.dropdown-over ul{
		display:block;
	}

	.dropdown-menu li ul li{
		border:1px solid #c0c0c0; 
		display:block; 
		width:150px;
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
    
    .cropArea {
      background: #E4E4E4;
      overflow: hidden;
      width:600px;
      height:350px;
    }

	md-content {
		color: rgba(255,255,255) !important;
		background-color: transparent !important;
	}
	md-tabs-canvas{
		background-color: rgba(0,0,0,0.6);
	}
	md-tabs .md-tab.md-active{
		color: rgb(255 255 255);
	}
	md-tabs .md-tab {
    	color: rgb(255 255 255 / 54%);
	}

</style>

			<div ng-controller="ZMProCtrl">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Produtos</li>
						<li class="breadcrumb-item active" aria-current="page">Subgrupos de Produtos</li>
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

				<?php
					include "Modal/ImagemProduto.php";
				?>

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

											<div class="col-auto">
												<select class="form-control form-control-sm" id="grupo" ng-model="grupo">
													<option value="">Todos os Grupos</option>
													<option ng-repeat="grupo in listagrupoProduto" ng-value="grupo.grp_codigo">{{grupo.grp_descricao}} </option>
												</select>
											</div>

											<div class="ml-auto m-0 p-0">
												<md-button class="btnPesquisar pull-right" style="border: 1px solid white; border-radius: 5px;" ng-click="busca(buscaRapida, grupo)" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
												<md-button class="btnImprimir pull-right" style="border: 1px solid green; border-radius: 5px;" ng-disabled="!listaSubgrupoProduto[0]" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
												<md-button class="btnSalvar pull-right" id="csv" style="border: 1px solid yellow; border-radius: 5px;" ng-click="exportarCsv()" ng-disabled="!listaSubgrupoProduto[0]" >
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
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('sbp_codigo')">Código</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('sbp_descricao')">Descrição</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('sbp_grupo_desc')">Grupo</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="sub in listaSubgrupoProduto | orderBy:'sortKey':reverse | itemsPerPage:20">
														<td style="text-align: left;" ng-bind="sub.sbp_codigo"></td>
														<td style="text-align: left;" ng-bind="sub.sbp_descricao"></td>
														<td style="text-align: left;" ng-bind="sub.sbp_grupo_desc"></td>
														<td style="text-align: center;">
															<div class="btn-group dropleft">
																<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
																	<i class="fas fa-ellipsis-v"></i> 
																</button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" ng-click="buscarGrupo(sub)">Editar</a>
																	<a class="dropdown-item" ng-click="excluir(sub,1)">Excluir</a>
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
														<span style="color: grey;">Quantidade Total: <b>{{listaSubgrupoProduto.length}}</b></span>
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
											<?php
												if (base64_decode($em_ramo) == 1){
											?>
												<div class="row">
													<div class="col-4">
														<img src="{{urlImage}}" alt="" style="float: left; margin-right:10px; border-radius: 10px; width:100px;">
													</div>

													<div class="col-4">
														<label>Imagem</label>
														<button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
															<i class="far fa fa-image"></i>
														</button>
													</div>
												</div>
											<?php
												}
											?>
										</form>
									</div>
									<div class="card-body">
										<form>
											<div class="form-row">
												<div class="form-group col-12" ng-init="selecionaSubGrupo.sbp_descricao = selecionaSubGrupo[0].sbp_descricao">
													<label for="nomeSubGp">Nome do Sub-Grupo</label>
													<input type="text" class="form-control capoTexto" id="nomeSubGp" ng-model="selecionaSubGrupo.sbp_descricao" value="{{selecionaSubGrupo.sbp_descricao}}" autocomplete="off">
												</div>
											<?php
												if (base64_decode($em_ramo) == 1){
											?>	
												<md-checkbox ng-init="selecionaSubGrupo.sbp_lanca_site = selecionaSubGrupo[0].sbp_lanca_site" ng-model="selecionaSubGrupo.sbp_lanca_site">
													Lançar Site
												</md-checkbox>
												
												<md-checkbox md-invert ng-init="selecionaSubGrupo.sbp_destaca_site = selecionaSubGrupo[0].sbp_destaca_site" ng-model="selecionaSubGrupo.sbp_destaca_site" aria-label="Destacar no site" style="margin-left:10px;">
													Destacar no site
												</md-checkbox>

											<?php
												}
											?>
											</div>
											<div class="form-row">
												<div class="form-group col-12" ng-init="selecionaSubGrupo.sbp_grupo = selecionaSubGrupo[0].sbp_grupo">
													<label for="GP">Selecione o Grupo </label>
													<select class="form-control form-control-sm js-example-basic-single js-states" id="id_label_single" ng-model="selecionaSubGrupo.sbp_grupo" ng-value="">
														<option ng-repeat="grupo in listagrupoProduto" value="{{grupo.grp_codigo}}">{{grupo.grp_descricao}}</option>
													</select>
												</div>
											</div>
										</form>
									</div>
									<div class="card-footer">
										<button type="submit" class="btn btn-outline-danger" style="color: white;" ng-click="cancelar(1)"><i class="fas fa-window-close"></i> Cancelar</button>
										<button type="submit" class="btn btn-outline-success" ng-click="editarSalvar(selecionaSubGrupo)"><i class="fas fa-save"></i> Salvar</button>
									</div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.0.4/ng-file-upload.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.js"></script>

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>
	
	<script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination','ngFileUpload', 'ngImgCrop']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $window) {

	    	'use strict';
	    	this.isOpen = false;

			$scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.sbp_descricao = '';
			$scope.grupo = '';
			$scope.listaSubgrupoProduto = [];
			$scope.listagrupoProduto = [];
			$scope.arrayNull = true;
			$scope.mudarEditarSalvar = 1;
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

			$scope.selecionaSubGrupo = [{
				sbp_id:'',
				sbp_codigo:'',
				sbp_descricao:'',
				sbp_grupo:'',
				sbp_imagem:'',
				sbp_lanca_site: true,
				sbp_destaca_site:false
			}];

		    $scope.MudarVisibilidade = function(e) {
				
		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;
				$scope.mudarEditarSalvar = e;
			}

			$scope.cancelar = function(e) {
		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;
				$scope.mudarEditarSalvar = e;
				$scope.selecionaSubGrupo = [{
					sbp_id:'',
					sbp_codigo:'',
					sbp_descricao:'',
					sbp_grupo:'',
					sbp_imagem:'https://zmsys.com.br/images/produto.jpg',
					sbp_lanca_site: true,
					sbp_destaca_site:false
				}];
				$scope.urlImage = 'https://zmsys.com.br/images/produto.jpg'
			}
			//$scope.sbp_lanca_site = $scope.selecionaSubGrupo[0].sbp_lanca_site;

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

			var dadosSubGrupo =function(){
				$scope.arrayNull = true;
				$http({
					method: 'GET',
					url: $scope.urlBase + 'subGrupoProduto.php?dadosSubGrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&descricao='+$scope.sbp_descricao+'&grupo='+$scope.grupo
				}).then(function onSuccess(response){
					$scope.listaSubgrupoProduto = response.data.result[0];
					if ($scope.listaSubgrupoProduto.length <1) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Empresa não possui clientes cadastrados!";
						chamarAlerta();
					}
					$scope.arrayNull = false;
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.arrayNull = false;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
				});
			}
			dadosSubGrupo();

			$scope.busca = function(descricao, grupo) {
				if (descricao == undefined) {
					descricao = '';
				}
				if (grupo == undefined) {
					grupo = '';
				}
				$scope.sbp_descricao = descricao;
				$scope.grupo = grupo;
				dadosSubGrupo();
			}

			var dadosGrupo =function(){
				$http({
					method: 'GET',
					url: $scope.urlBase + 'grupoProduto.php?dadosgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.listagrupoProduto = response.data.result[0];
				}).catch(function onError(response){

				});
			}
			dadosGrupo();

			$scope.buscarGrupo = function(sub){
				$scope.mudarEditarSalvar = 2;
				$http({
					method: 'GET',
					url: $scope.urlBase + 'subGrupoProduto.php?dadosSubGrupo=S&buscar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&sub_id='+sub.sbp_id
				}).then(function onSuccess(response){
					$scope.selecionaSubGrupo = response.data.result[0];
					$scope.selecionar = $scope.selecionaSubGrupo[0].sbp_grupo;
					$scope.urlImage = $scope.selecionaSubGrupo[0].sbp_imagem;
					$scope.MudarVisibilidade(2);
				}).catch(function onError(response){

				});
			}

			$scope.editarSalvar = function(sub){
				console.log(sub);
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
					url: $scope.urlBase + 'subGrupoProduto.php?dadosSubGrupo=S&editar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&sbp_id='+$scope.selecionaSubGrupo[0].sbp_id+'&sbp_desc='+sub.sbp_descricao+'&sbp_Grup='+sub.sbp_grupo+'&imageSub='+$scope.urlImage+'&lancarSite='+sub.sbp_lanca_site+'&DestacarSite='+sub.sbp_destaca_site
				}).then(function onSuccess(response){
					$scope.MudarVisibilidade(1);
					$scope.retStatus = response.data.result;
					
					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
						chamarAlertaMg();
					}

					else if($scope.retStatus[0].status == 'ERROR'){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Cadastro Não Pode Ser Atualizado!";
						chamarAlertaMg();
					}

					dadosSubGrupo();
					$scope.MudarVisibilidade(1);
					$scope.cancela();
					$scope.urlImage = 'https://zmsys.com.br/images/produto.jpg'
				}).catch(function onError(response){

				});
			}

			$scope.salvarGrupo = function(sub){

				if(sub.sbp_descricao == undefined){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Nome Do SubGrupo!";
					chamarAlertaMg();

				}
				else if(sub.sbp_descricao == ''){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Nome Do SubGrupo!";
					chamarAlertaMg();
				}

				else if(sub.sbp_grupo == undefined){

					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Grupo!";
					chamarAlertaMg();

				}
				else if(sub.sbp_grupo == ''){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Informe O Grupo!";
					chamarAlertaMg();
				}

				else{
					$scope.MudarVisibilidade(1);
					$http({
					method: 'GET',
					url: $scope.urlBase + 'subGrupoProduto.php?dadosSubGrupo=S&salvar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&sbp_desc='+sub.sbp_descricao+'&sbp_Grup='+sub.sbp_grupo+'&imageSub='+$scope.urlImage+'&lancarSite='+sub.sbp_lanca_site+'&DestacarSite='+sub.sbp_destaca_site
					}).then(function onSuccess(response){
						
						if (response.data <= 0) {
							$scope.tipoAlerta = "alert-danger";
							$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
							chamarAlertaMg();
						}

						else if(response.data >= 1){
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
							chamarAlertaMg();
						}
						dadosSubGrupo();
						$scope.MudarVisibilidade(1);
						$scope.cancela();
						$scope.urlImage = 'https://zmsys.com.br/images/produto.jpg'
					}).catch(function onError(response){

					});
				}
								
			}

			$scope.excluir = function(sub,e){
				if(e == 1){
					excluir();
					$scope.id = sub.sbp_id;
				}
				else if(e == 2){

					$http({
						method: 'GET',
						url: $scope.urlBase + 'subGrupoProduto.php?dadosSubGrupo=S&excluir=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&sbp_id='+sub
					}).then(function onSuccess(response){
						$scope.retStatus = response.data.result[0];
						
						if ($scope.retStatus[0].status == 'ERROR') {
							$scope.tipoAlerta = "alert-danger";
							$scope.alertMsg = "Cadastro Não Pode Ser Excluido!";
							chamarAlertaMg();
						}
						else if($scope.retStatus[0].status == 'SUCCESS'){
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Cadastro Excluido Com Sucesso";
							chamarAlertaMg();
						}
						dadosSubGrupo();

					}).catch(function onError(response){

					});
					excluir();
				}
			}
			
			$scope.fileImage='subGrupo';
			<?php 
				include 'controller/uploadImage.js';
			?>

			$scope.cancela = function(){
				$scope.grupoProduto =[];
				$scope.MudarVisibilidade(1);
				$scope.urlImage = 'https://zmsys.com.br/images/produto.jpg'
			}

		});
 
		$(document).ready(function() {
			$('.js-example-basic-single').select2();
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