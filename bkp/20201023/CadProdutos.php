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

	.table-responsive.estoque-tabe{
		height:30	0px;  
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
						<li class="breadcrumb-item active" aria-current="page">Cadastro</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>
<?php
	include './Modal/estoque/movimentacao_cardex.php';
	include 'Modal/ImagemProduto.php';
?>
	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">
						<div ng-if="lista">

							<div show-on-desktop>
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
    			                        <form class="my-0 pt-0">
                			                <div class="form-row align-items-center">
												
												<div class="col-auto">
                                        			<label>Filtros</label>
												</div>

												<div class="col-auto">
													<input type="text" value="" class="form-control form-control-sm" id="codigo" ng-model="codigo" placeholder="Todos os Códigos">
												</div>

												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Todos os Produtos">
												</div>

												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="marca" ng-model="marca" placeholder="Todas as Marcas">
												</div>

												<div class="col-auto">
													<select class="form-control form-control-sm" id="subgrupo" ng-model="subgrupo">
														<option value="">Todos os SubGrupos</option>
														<option ng-repeat="sub in dadosSubGrupo" ng-value="sub.sbp_id">{{sub.sbp_descricao}}</option>
													</select>
												</div>

												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="busca(codigo, buscaRapida, marca, subgrupo)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
												</div>
											</div>
										</form>

												<!--<div class="col-3" style="text-align: right;">
									    	md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
												<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
						                      	<i class="fas fa-print" style=""></i> Imprimir
				    	                	</md-button
								    	</div>-->

										<div class="table-responsive p-0 mb-0" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Código</th>
														<th scope="col" style=" font-weight: normal; text-align: left; width:400px">Nome</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Marca</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Subgrupo</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">À Vista</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">A Prazo</th>
														<th scope="col" style=" font-weight: normal; text-align: center;width:20px">Ação</th>
													</tr>
												</thead>
												<tbody style="line-height: 2em; margin:0px; padding:0px;">
													<tr dir-paginate="prod in dadosProdutos | itemsPerPage: pageSize" total-items="totalItems" current-page="pagination.current"> 
														<td style="text-align: left;" ng-bind="prod.pd_cod"></td>
														<td style="text-align: left;" ng-bind="prod.pd_desc"></td>
														<td style="text-align: left;" ng-bind="prod.pd_marca"></td>
														<td style="text-align: left;" ng-bind="prod.sbp_descricao"></td>
														<td style="text-align: right;" ng-bind="prod.pd_vista | currency:'R$ '"></td>
														<td style="text-align: right;" ng-bind="prod.pd_prazo | currency:'R$ '"></td>
														<td style="text-align: right;" class="ml-auto m-0 p-0">
															<md-menu>
																<md-button ng-click="$mdOpenMenu()" class="md-icon-button md-mini pull-right m-0 p-0">
																	<i class="fas fa-ellipsis-v m-0 p-0"></i> 
																</md-button>
																<md-menu-content class="dropdown" >
																	<md-menu-item >
																		<md-button ng-click="visualizarProduto(prod, 'V', true)">Visualizar</md-button>
																	</md-menu-item>
																	<md-menu-item >
				<?php if (substr($me_empresa, 2, 1) == 'S') {?>
																		<md-button ng-click="visualizarProduto(prod, 'E', false)">Editar</md-button>
				<?php } ?>
																	</md-menu-item>
																	<md-menu-item >
				<?php if (substr($me_empresa, 3, 1) == 'S') {?>
																		<md-button ng-click="excluirProduto(prod, 'R')">Excluir</md-button>
				<?php }?>
																	</md-menu-item>
																</md-menu-content>
															</md-menu>
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
										<div class="card-footer p-0 pb-2">
											<div class="form-row align-items-center">
												<div class="col-12" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: grey;">Exibindo <b>{{startItem}}</b> a <b>{{endItem}}</b> de <b>{{totalItems}}</b> Registros</span>
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope" on-page-change="mudarPagina(newPageNumber)"></dir-pagination-controls>	

									<!--div class="form-row align-items-center">
											<div class="col-12" ">
												Registros: {{dadosProdutos.length}}</b></span>
											</div>
										</div-->
							</div>	

							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="verificaCodigo()" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
                      			<i class="fa fa-plus"></i>
    	                	</md-button>
						</div>

						<div ng-if="ficha">
							
						<?php if (base64_decode($em_ramo) == 2){
							
							include "resource/views/estoque/estoque_em_ramo2.php";
						}elseif(base64_decode($em_ramo) == 1){
							include "resource/views/estoque/estoque_em_ramo1.php";
						}
						?>
							 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

		        <!-- Page Content  -->

    <script src="js/angular.min.js"></script>
   	<!--<script src="js/ng-img-crop.js"></script>-->
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/dirPagination.js"></script>
	<script src="js/mask/angular-money-mask.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.0.4/ng-file-upload.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.js"></script>
    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','money-mask','ngFileUpload', 'ngImgCrop', 'angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $window) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.campo = false;
			$scope.urlBase = 'services/';
    		$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.estoque = '';				
			$scope.cadastrar_alterar = '';
			$scope.retStatus = '';
			$scope.empresa = '';
			$scope.dadosGrupos=[];
			$scope.estoque = [];
			$scope.currentPage = 1;
			$scope.totalItems = 0;
			$scope.pageSize = 20;
			$scope.searchNome = '';
			$scope.searchCodigo = '';
			$scope.searchMarca = '';
			$scope.searchSubGrupo = '';
			$scope.pagination = {
		        current: 1
    		};

			$scope.sort = function (keyname) {
				$scope.sortBy = keyname;   //set the sortBy to the param passed
				$scope.reverse = !$scope.reverse; //if true make it false and vice versa
			}

			$scope.mudarPagina = function(pagAtual) {
				$scope.currentPage = pagAtual;
				buscarProdutos();
			}

			var originatorEv;
			this.openMenu = function($mdOpenMenu, ev) {
				originatorEv = ev;
				$mdOpenMenu(ev);
			};

			$scope.produto = [{
				pd_cod:'',
				pd_ean:'',
				pd_codinterno:'',
				pd_un:'',
				pd_lanca_site:'S',
				pd_disk:'',
				pd_desc:'',
				pd_subgrupo:'',
				pd_marca:'',
				pd_localizacao:'',
				pd_cst:'',
				pd_ncm:'',
				pd_csosn:'',
				pd_custo:'',
				pd_vista:'',
				pd_markup:'',
				pd_grade:'',
				pd_foto_url:'',
				pd_observ:'',
				es_est:'',
				pd_ativo: '',
				pd_composicao:'',
				pd_st:false,
			}];

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

			$scope.ordenar = function(keyname){
		    	$scope.sortKey = keyname;
		    	$scope.reverse = !$scope.reverse;
		    };

		    $scope.verificaDados = function(){
		    	$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "*Campos Obrigatórios Devem Ser Preenchidos!"
				chamarAlerta();
		    }

		    var dadosEmpresa = function () {	
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaCad.php?dadosEmpresa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosEmpresa=response.data.result[0];
					dadosSubGrupo();
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
				});
			};
<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			var dadosSubGrupo =function(empresa){
				$http({
					method: 'GET',
					url: $scope.urlBase + 'subgrupo.php?subgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&empresa='
				}).then(function onSuccess(response){
					$scope.dadosSubGrupo = response.data.result[0];
					dadosGrupos();
				}).catch(function onError(response){
					dadosGrupos();
				});
			}

			var dadosGrupos = function(){
				$http({
					method: 'GET',
					url: $scope.urlBase+'grupoProduto.php?dadosgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosGrupos= response.data.result[0];

				}).catch(function onError(response){
				})
			}

/*			var dadosProdutosSimplificado = function (pagina, nome, grupo, subgrupo) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?dadosProdutosSimplificado=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&searchNome='+nome+'&searchGrupo='+grupo+'&searchSubGrupo='+subgrupo+'&page='+pagina
					}).then(function onSuccess(response){
						$scope.dadosProdutos=response.data.result[0];
						if ($scope.dadosProdutos.length <1) {
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Empresa não possui produtos cadastrados!";
							chamarAlerta();
						}
					}).catch(function onError(response){
				});
			};

			dadosProdutosSimplificado();*/

			var buscarProdutos = function() {
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?dadosProdutosSimplificado=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&searchCodigo='+$scope.searchCodigo+'&searchNome='+$scope.searchNome+'&searchMarca='+$scope.searchMarca+'&searchSubGrupo='+$scope.searchSubGrupo+'&page='+$scope.currentPage+'&size='+$scope.pageSize
				}).then(function onSuccess(response){					
					$scope.dadosProdutos = response.data.listaProdutos;
					$scope.totalItems = response.data.totalCount;
					$scope.startItem = ($scope.currentPage - 1) * $scope.pageSize + 1;
					$scope.endItem = $scope.currentPage * $scope.pageSize;
				}).catch(function onError(response){

				});

			}

			buscarProdutos();

			/*$scope.buscarProdutos = function(pagNum) {
					$scope.dadosProdutos = [];
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?dadosProdutosSimplificado=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&searchNome='+$scope.searchNome+'&searchGrupo='+$scope.searchGrupo+'&searchSubGrupo='+$scope.searchSubGrupo+'&page='+pagNum+'&size='+$scope.pageSize
				}).then(function onSuccess(response){					
					$scope.totalItems = response.data.totalCount;
					$scope.startItem = ($scope.currentPage - 1) * $scope.pageSize + 1;
					$scope.endItem = $scope.currentPage * $scope.pageSize;
					if ($scope.endItem > $scope.totalCount) {$scope.endItem = $scope.totalCount;};
					$scope.dadosProdutos = response.data.listaProdutos;
				}).catch(function onError(response){

				});

			}*/

			/*$scope.buscarProdutos($scope.currentPage);*/

			var buscarEstoque = function(pd_cod){
				
				$http({
					method: 'GET',
					url: $scope.urlBase+'Estoque.php?estoqueSimplificado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod
				}).then(function onSuccess(response){
					$scope.estoque = response.data.result[0];
				}).catch(function onError(response){

				});
			}

			$scope.visualizarProduto = function(prod, tipo, modo){
				MudarVisibilidade2(tipo, modo);
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?visualizarProdutos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_id='+prod.pd_id
					}).then(function onSuccess(response){
						$scope.produto = response.data.result[0];
						if ($scope.produto[0].pd_foto_url == null || $scope.produto[0].pd_foto_url == "" || $scope.produto[0].pd_foto_url == undefined){
							//alert($scope.produto[0].pd_foto_url);
							$scope.produto[0].pd_foto_url =	$scope.urlImage ;
						} else {
							$scope.urlImage = $scope.produto[0].pd_foto_url;
						}
						console.log($scope.produto);
						buscarEstoque($scope.produto[0].pd_cod);
					}).catch(function onError(response){
				});
			};

			$scope.restMovEstoqueConsulta = function(estoque){
				$http({
					method:'GET',
					url: $scope.urlBase+'Estoque.php?movimento_cardex=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+estoque.es_prod+'&es_empr='+estoque.es_empr
				}).then(function onSuccess(response){
					$scope.movEstoqueConsulta = response.data.result[0];
				}).catch(function onError(response){

				})
			}

			$scope.busca = function(codigo, nome, marca, subgrupo){

				if (codigo == undefined || codigo == null) {codigo = '';}
				if (nome == undefined || nome == null) {nome = '';}
				if (marca == undefined || marca == null) {marca = '';}
				if (subgrupo == undefined || subgrupo == null) {subgrupo = '';}

				$scope.searchCodigo = codigo;
				$scope.searchNome = nome;
				$scope.searchMarca = marca;
				$scope.searchSubGrupo = subgrupo;
				$scope.currentPage = 1;
				buscarProdutos();

			}
			
			$scope.verificaCodigo = function(){
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?verificarCodigo=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&campo=S&valor=S'
					}).then(function onSuccess(response){
						$scope.verificaCod=response.data.result[0];
						//$scope.produto[0].pd_cod = $scope.verificaCod[0].pd_cod+1;
						$scope.MudarVisibilidade('N');
						$scope.produto[0].pd_foto_url = $scope.urlImage;
					}).catch(function onError(response){
				});
			};

 			$scope.sairCadastro = function() {

				window.location.reload();

			}

			$scope.AdicionarProduto = function(produto) {

				SalvarProdutos(produto);

			};

		    var SalvarProdutos = function (item) {

		    	//alert("entrou");
		    	
				var prod = $scope.produto;

				$http({
					
					method: 'POST',
					 headers: {
			           'Content-Type':'application/json'
			         },
			          data: {
			           prod:prod,
			          },
			          url: $scope.urlBase+'SalvaProdutos.php?SalvarProduto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cadastrar_alterar='+$scope.cadastrar_alterar

				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Produto adicionada com sucesso!";

						$scope.lista = !$scope.lista;
						$scope.ficha = !$scope.ficha;

						$scope.produto = [{
							pd_cod:'',
							pd_ean:'',
							pd_codinterno:'',
							pd_un:'',
							pd_lanca_site:'S',
							pd_disk:'',
							pd_desc:'',
							pd_subgrupo:'',
							pd_marca:'',
							pd_localizacao:'',
							pd_cst:'',
							pd_ncm:'',
							pd_csosn:'',
							pd_custo:'',
							pd_vista:'',
							pd_markup:'',
							pd_grade:'',
							pd_foto_url:'',
							pd_observ:'',
							es_est:'',
							pd_ativo: '',
							pd_composicao:'',
							pd_st:false,
						}];
						
						dadosProdutosSimplificado($scope.empresa);
						chamarAlerta();
									

					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar produto!";
						chamarAlerta();
						
					}
									
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar produto!";
						chamarAlerta();
						
				});

			};

			$scope.excluirProduto = function(prod, e){
				$http({
					method: 'GET',
					url: $scope.urlBase+'SalvaProdutos.php?deletarProduto=S&prodCod='+btoa(prod.pd_id)+'&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cadastrar_alterar='+e
				}).then(function onSuccess(response){
					
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Produto deletado com sucesso!";
						dadosProdutosSimplificado($scope.empresa);
						chamarAlerta();

					}else if ($scope.retStatus[0].status == 'ERROR') {						
						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao deletar produto!";
						chamarAlerta();
						
					}

				}).catch(function onError(response){

				})
			}

		    $scope.MudarVisibilidade = function(tipo) {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;
				$scope.cadastrar_alterar = tipo;
				$scope.campo = false;

		    };

		    var MudarVisibilidade2 = function(tipo, modo) {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;
				$scope.cadastrar_alterar = tipo;
				$scope.campo = modo;
				

			};
			
			$scope.markup = function(pd_custo, pd_vista, pd_prazo){
				
				var pd_custo = pd_custo.replace("R$","");
				var pd_vista = pd_vista.replace("R$","");


				pd_custo = pd_custo.replace("$","");
				pd_custo = pd_custo.replace(",",".");

				
				pd_vista = pd_vista.replace("$","");
				pd_vista = pd_vista.replace(",",".");


				$scope.produto[0].pd_markup = ((pd_vista*100)/pd_custo)-100;

				console.log(pd_custo+ ' - ' +pd_vista + ' - ' + pd_prazo)
			}

			$scope.imageCropResult = null;
	        $scope.showImageCropper = false;

	        $scope.$watch('imageCropResult', function(newVal) {
	            if (newVal) {
	        	    console.log('imageCropResult', newVal);
	            }
	            
			});
			$scope.fileImage='produto';
		<?php 
			include 'controller/uploadImage.js';
		?>
			
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

		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		});


		function somenteNumeros(e) {
			var charCode = e.charCode ? e.charCode : e.keyCode;
			// charCode 8 = backspace   
			// charCode 9 = tab
			if (charCode != 8 && charCode != 9) {
				// charCode 48 equivale a 0   
				// charCode 57 equivale a 9
				if (charCode < 48 || charCode > 57) {
					return false;
				}
			}
		}

	</script>


</body>
</html>