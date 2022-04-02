<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';


setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

?>

<head>

</head>

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
		height:1080px;  
		overflow:scroll;
		background-color:#ffffff;
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


			<div ng-controller="ZMProCtrl" ng-init="modificaBusca(empresa)">	
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
					<div class="col-lg-12">
						<div ng-if="lista">
					    	<div class="row bg-dark p-2 col-12" >
					    		<form class="col-12">
									<div class="form-row align-items-center">
	<?php if (base64_decode($empresa_acesso) == 0) {?>
										<div class="col-auto" ng-init="empresa = '<?=base64_decode($empresa)?>'">
											<select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="modificaBusca(empresa)">
												
												<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
											</select>
										</div>
	<?php } else {
	echo $dados_empresa["em_fanta"];
	}?>
										<div class="col-auto">
											<select class="form-control form-control-sm" id="grupo" ng-model="grupo">
												<option ng-value="">Todas os Grupos</option>
												<option ng-repeat="grupo in dadosGrupos" ng-value="grupo.grp_codigo">{{grupo.grp_descricao}} </option>
											</select>
										</div>
										<div class="col-auto">

										<select class="form-control form-control-sm" id="subgrupo" ng-model="subgrupo">
											<option ng-value="">Todos os SubGrupos</option>
											<option ng-repeat="sub in dadosSubGrupo | filter:{sbp_empresa:empresa} " ng-value="sub.sbp_descricao">{{sub.sbp_descricao}}</option>
										</select>

										</div>
										<div class="input-group col-4 pt-2">
											<input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
											<div class="input-group-btn">
												<button type="button" class="btn btn-outline-dark">
													<i class="fas fa fa-search"></i>
												</button>
											</div>
										</div>
										<!--<div class="col-3" style="text-align: right;">
									    	md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
												<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
						                      	<i class="fas fa-print" style=""></i> Imprimir
				    	                	</md-button
								    	</div>-->
								    </div>
						   		</form>
						   	</div>
							<div class="table-responsive px-0" style="overflow-y:auto ; overflow-x:hidden;">
								<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1em !important;">
											<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('pd_cod')">Código</th>
											
											<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pd_desc')">Nome</th>
											<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pd_subgrupo')">Subgrupo</th>
											<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pd_marca')">Marca</th>
											<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('pd_vista')">À Vista</th>
											<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('pd_prazo')">A Prazo</th>
											<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr dir-paginate="prod in dadosProdutos | filter: buscaRapida | filter: {pd_subgrupo:subgrupo} | orderBy:'sortKey':reverse | itemsPerPage:20" >
											<td style="text-align: right;" ng-bind="prod.pd_cod"></td>
											
											<td style="text-align: left;" ng-bind="prod.pd_desc"></td>
											<td style="text-align: left;" ng-bind="prod.pd_subgrupo"></td>
											<td style="text-align: left;" ng-bind="prod.pd_marca"></td>
											<td style="text-align: right;" ng-bind="prod.pd_vista | currency:'R$ '"></td>
											<td style="text-align: right;" ng-bind="prod.pd_prazo | currency:'R$ '"></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
													
														<a class="dropdown-item" ng-click="visualizarProduto(prod, 'V', true)">Visualizar</a>
	<?php if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item"  ng-click="visualizarProduto(prod, 'E', false)">Editar</a>
	<?php } ?>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="excluirProduto(prod, 'R')">Excluir</a>
	<?php }?>
					                                </div>
					                            </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- Final Desktop -->
							<div class="container col-12 p-2" style="border:none; background-color: #999999FF;">
								<div class="row align-items-center">
							    	<div class="col-4" style="text-align: left;">
										<div class="row justify-content-start">
								    		<span style="color: #303030FF;">Registros: <b>{{dadosProdutos.length}}</b></span>
								    	</div>
									</div>
								</div>
							</div>	
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
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
	<script src="js/mask/angular-money-mask.js"></script>
	<script src="js/dirPagination.js"></script>	
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.0.4/ng-file-upload.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.js"></script>
    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','money-mask','md.data.table','angularUtils.directives.dirPagination','ngFileUpload', 'ngImgCrop']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log, $window) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.campo = false;
			$scope.empresa = '';
			$scope.urlBase = 'services/';
    		$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.estoque = '';				
			$scope.dadosProdutos = [];
			$scope.cadastrar_alterar = '';
			$scope.retStatus = '';
			$scope.empresa = <?=base64_decode($empresa)?>;

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

		    var dadosProdutosSimplificado = function (empresa) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'Produtos.php?dadosProdutosSimplificado=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa
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

			var dadosSubGrupo =function(empresa){
				$http({
					method: 'GET',
					url: $scope.urlBase + 'subgrupo.php?subgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&empresa='
				}).then(function onSuccess(response){
					$scope.dadosSubGrupo = response.data.result[0];
				}).catch(function onError(response){

				});
			}
			$scope.dadosGrupos=[];
			var grupos = function(){
				$http({
					method: 'GET',
					url: $scope.urlBase+'grupoProduto.php?dadosgrupo=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosGrupos= response.data.result[0];
				}).catch(function onError(response){

				})
			}

			grupos();

			$scope.estoque = [];
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
						
						if ($scope.produto[0].pd_foto_url != null){
							$scope.urlImage = $scope.produto[0].pd_foto_url;
						}
						else if ($scope.produto[0].pd_foto_url != ""){
							$scope.urlImage = $scope.produto[0].pd_foto_url;
						}else{
						$scope.produto[0].pd_foto_url =	$scope.urlImage ;
						}
						console.log($scope.produto);
						buscarEstoque($scope.produto[0].pd_cod);
					}).catch(function onError(response){
				});
			};

			$scope.restMovEstoqueConsulta = function(){
				$http({
					method:'GET',
					url: $scope.urlBase+'Estoque.php?movimento_cardex=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+$scope.produto[0].pd_cod
				}).then(function onSuccess(response){
					$scope.movEstoqueConsulta = response.data.result[0];
				}).catch(function onError(response){

				})
			}

			
			
			$scope.modificaBusca = function (empresa){
				$scope.empresa = empresa;
	    		busca();
			}

			var busca = function(){
					/*alert("alguma");*/
					

				<?php if (base64_decode($empresa_acesso) != 0) {?>
					$scope.empresa = <?=$dados_usuario['us_empresa_acesso']?>;
				<?php }?>
				/*
					if ($scope.empresa == undefined) {
						empresa = '';
					}
					if ($scope.empresa == '') {
						empresa = '';
					}
					*/
				dadosProdutosSimplificado($scope.empresa);

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


		function tabenter(event,campo){
			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.focus();
			}
		};

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