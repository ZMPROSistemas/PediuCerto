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

	/*#tabela{display: block;}*/
	#tabela2{display: none;}
	.ordernar{cursor: pointer; margin-left: 15px;}
	th:focus{
		outline: none;
		background-color: #333 !important;
	}
	hr {
	  top: 15px;
	  clear: both;
	  width: 0;
	  height: 5px;
	  margin: 0 0 25px;
	  display: block;
	  position: relative;
	  background: rgb(26, 2, 175);
	}
	@-webkit-keyframes progress {
	  to { width: 100%; }
	}
	@-moz-keyframes progress {
	  to { width: 100%; }
	}
	@keyframes progress {
	  to { width: 100%; }
	}

	@-webkit-keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}
	@-moz-keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}
	@keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}
	  @media print {}
	}
	}



</style>

<!--			<div ng-controller="ZMProCtrl" ng-init="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd',subgrupo,estoque)">

				<div show-on-mobile>
					<h2>Mobile</h2>
				</div>

				<div show-on-tablet>
					<h2>Tablet</h2>
				</div>

				<div show-on-laptop>
					<h2>Laptop</h2>
				</div>
<div show-on-desktop>-->

			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Relatórios</li>
						<li class="breadcrumb-item active" aria-current="page">Posição Financeira de Estoque</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>

				<div class="row" style="font-size: 0.9em !important">
				  	<div class="col-lg-12 pt-0 px-2">

						<div show-on-desktop>
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body py-0 px-2 m-0">
									<form class="my-0 pt-2">
										<div class="form-row justify-content-between pb-2">

											<div class="col-auto">
												<label>Filtros</label>
											</div>

											<?php if (base64_decode($empresa_acesso) == 0) {?>
											<div class="col-2">
												<select class="form-control form-control-sm" id="empresa" ng-model="empresa">
													<option value="">Todas as Empresas</option>	
													<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
												</select>
											</div>
											<?php } else {
												echo $dados_empresa["em_fanta"];
											}?>

											<div class="col-2">
												<select name="subgrupo" class="form-control form-control-sm" id="subgrupo" ng-model="subgrupo" value="">
													<option value="">Todos os Subgrupos</option>
													<option ng-repeat="sub in dadosSubgrupo" value="{{sub.sbp_codigo}}">{{sub.sbp_descricao}}</option>
													option
												</select>
											</div>

											<div class="col-2" ng-init="estoque = '3'">
												<select name="estoque" class="form-control form-control-sm capoTexto" id="estoque" ng-model="estoque" value="">
													<option value="0" selected="selected">Somente Positivo</option>
													<option value="1">Somente Negativo</option>
													<option value="3">Estoque Positivo e Negativo</option>
												</select>
											</div>

											<div class="ml-auto m-0 p-0">
												<md-button class="btnPesquisar pull-right" style="border: 1px solid white; border-radius: 5px;" ng-click="busca(empresa, subgrupo, estoque)" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
												<md-button class="btnImprimir pull-right" style="border: 1px solid green; border-radius: 5px;" ng-disabled="!relatorioRanking[0]" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
												<md-button class="btnSalvar pull-right" id="csv" style="border: 1px solid yellow; border-radius: 5px;" ng-click="exportarCsv()" ng-disabled="!relatorioRanking[0]" >
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
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_cod')">Cod</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')" style="width: 180px">Empresa</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_desc')">Descrição</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_un')">UN</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('descricao')">SubGrupo</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('es_est')">Est</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('es_est')">Custo</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pd_vista')">Vista</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('c_total')">C.Total</th>
														<th scope="col" style=" font-weight: normal;" ng-click="ordenar('v_total')">V.Total</th>
													</tr>
												</thead>
												<tbody ng-repeat="relatorioSubGrupo in relatorioSubGrupo">
													<th colspan="10" id="subG"><b>{{relatorioSubGrupo.descricao}}</b></th>
													<tr ng-repeat="relatorio in relatorio | filter:{descricao:relatorioSubGrupo.descricao} | orderBy:sortKey:reverses" ng-click="null">
									<!--<tr ng-repeat="relatorio in relatorio | orderBy:sortKey:reverses" ng-click="null">
										<td rowspan="10" ng-repeat="relatorioSubGrupo in relatorioSubGrupo | filter:{descricao:relatorio.descricao} | limitTo: 1">
											<b>{{relatorioSubGrupo.descricao}}</b>
										</td>-->
														<td ng-bind="relatorio.pd_cod"></td>
														<td>{{relatorio.em_fanta | limitTo:20}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
														<td style="width: 180px">{{relatorio.pd_desc}}</td>
														<td ng-bind="relatorio.pd_un"></td>
														<td>{{relatorio.descricao | limitTo:10}}{{relatorio.descricao.length >= 10 ? '...' : ''}}</td>
														<td>
															<span ng-if="relatorio.es_est != null">{{relatorio.es_est | number:0}}</span>
															<span ng-if="relatorio.es_est == null">0</span>
														</td>
														<td>{{relatorio.pd_custo | number:2}}</td>
														<td>{{relatorio.pd_vista | number:2}}</td>
														<td>
															<span ng-if="relatorio.c_total != null">{{relatorio.c_total | number:2}}</span>
															<span ng-if="relatorio.c_total == null"> 0.00</span>
														</td>
														<td>
															<span ng-if="relatorio.v_total != null">{{relatorio.v_total | number:2}}</span>
															<span ng-if="relatorio.v_total == null"> 0.00</span>
														</td>
													</tr>
													<tr ng-repeat="relatorioTotalGrupoBy in relatorioTotalGrupoBy | filter:{descricao:relatorioSubGrupo.descricao}">
														<td colspan="5" align="right">Qnt</td>
														<td>{{relatorioTotalGrupoBy.es_est | number:0}}</td>

														<td colspan="2" align="right">Total do Grupo</td>
														<td>{{relatorioTotalGrupoBy.c_total | number:2}}</td>
														<td>{{relatorioTotalGrupoBy.v_total | number:2}}</td>
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
												<div class="col-6" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: white;">Valor Total: <b class="col-auto">{{relatorioTotal[0].valor_total | currency:'R$ '}}</b></span>
													</div>
												</div>
												<div class="col-6" style="text-align: right;">
													<div class="row justify-content-end">
														<span style="color: grey;">Quantidade Total: <b>{{relatorioTotal[0].quant_total | number}}</b></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
				    	</div>


						<div show-on-mobile>
							<md-toolbar layout="row" class="md-hue-3" style="background-color:#000; color:#fff;">
								<div class="md-toolbar-tools" layout="row" layout-align="space-around center">
								</div>
							</md-toolbar>

							<md-content>
								<md-list class="p-0" flex>
									<md-list-item md-on-select="logItem" class="md-1-line" md-auto-select="options.autoSelect"  ng-repeat="" ng-click="null" layout-align="space-around center">
										<md-divider></md-divider>
									</md-list-item>
								</md-list>
							</md-content>
						</div><!-- Final Desktop -->
<!--
						<md-table-pagination md-limit="query.limit" md-page="query.page" md-total="{{paginacao[0].total}}" md-page-select="dadosCliente" md-boundary-links="options.boundaryLinks" md-on-paginate="logPagination"></md-table-pagination>
-->
					</div>
				</div>
<!--
				<table id="tabela">
					<thead>
						<tr>
							<th>Data</th>
							<th>Empresa</th>
							<th>Venda</th>
							<th>Custo</th>
							<th>Descto</th>
							<th>Saldo</th>
							<th>% Saldo</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{relatorio.vd_emis | date: 'dd/MM/yyyy'}}</td>
							<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
							<td>{{relatorio.total}}</td>
							<td>{{relatorio.custo| number : 2}}</td>
							<td>{{relatorio.descto}}</td>
							<td>{{relatorio.saldo}}</td>
							<td>{{relatorio.saldoPorc}}</td>
						</tr>
					</tbody>

				</table>
-->
				<table id="tabela2">
					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>Qnt. Total</td>
							<td>R$ {{relatorioTotalGeral[0].es_est}}</td>
						</tr>
						<tr>
							<td>Custo Total</td>
							<td>R$ {{relatorioTotalGeral[0].c_total}}</td>
						</tr>
						<tr>
							<td>Venda T</td>
							<td>R$ {{relatorioTotalGeral[0].v_total}}</td>
						</tr>
					</tbody>
				</table>
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

	    	$scope.selected = [];
	    	$scope.options = {
			    autoSelect: true,
			    boundaryLinks: true,
			    //largeEditDialog: true,
			    //pageSelector: true,
			    rowSelection: true
			  };

			  $scope.query = {
			    order: 'name',
			    limit: 10,
			    page: 1
			  };

		    $scope.tab = 1;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.dadosEmpresa=[];
			$scope.dadosSubgrupo=[];
			$scope.relatorioSubGrupo=[];
			$scope.relatorio = [];
			$scope.relatorioTotal = [];
			$scope.relatorioTotalGrupoBy=[];
			$scope.relatorioTotalGeral=[];
			$scope.empresa = '';
			$scope.estoque = '';
			$scope.subgrupo = '';
			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();
			$scope.arrayNull = true;
    		//$scope.dataI = '2011-01-01';
    		//scope.dataF = '2011-01-30';

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

			$scope.progresiveBar = false;

			$scope.logPagination = function (page, limit) {
			    console.log('page: ', page);
			    console.log('limit: ', limit);
			}

			$scope.ordenar = function(keyname){
		      $scope.sortKey = keyname;
		      $scope.reverse = !$scope.reverse;
		    };

		    function dataHoje(soma=0) {

	            var data = new Date();
	            data.setDate(data.getDate() );
	            var dia = data.getDate();
	            var mes = data.getMonth()+1;
	            var ano = data.getFullYear();
	            if (dia<=9){
	              dia='0'+dia;
	            }
	            if (mes<=9){
	              mes='0'+mes;
	            }
	            //return [dia, mes, ano].join('/');

	            return [ano, mes, dia].join('-');

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
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};
<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			var subgrupo = function(){
				$http({
					method: 'GET',
					url: $scope.urlBase+'subgrupo.php?&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosSubgrupo=response.data.result[0];
				}).catch(function onError(response){
					$scope.subgrupo=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			}
			subgrupo();

			 var relatorioSubGrupo = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_estoque.php?relatorio=S&relatorioSubGrupo=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&subgrupo='+$scope.subgrupo+'&estoque='+$scope.estoque+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.relatorioSubGrupo=response.data.result[0];
					//$scope.progresiveBar = false;
				}).catch(function onError(response){
					$scope.relatorioSubGrupo=response.data;
					//$scope.progresiveBar = false;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			 var relatorioRegistro = function (empresa, dataI, dataF,subgrupo,estoque) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_estoque.php?relatorio=S&dadosRelatorio=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&subgrupo='+$scope.subgrupo+'&estoque='+$scope.estoque+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.relatorio=response.data.result[0];
					$scope.progresiveBar = false;
				}).catch(function onError(response){
					$scope.relatorio=response.data;
					$scope.progresiveBar = false;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalRegistro = function (empresa, dataI, dataF, subgrupo,estoque) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_estoque.php?relatorio=S&relatorioTotalRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&subgrupo='+subgrupo+'&estoque='+estoque+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotal=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotal=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalGrupoBy = function (empresa, dataI, dataF, subgrupo, estoque) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_estoque.php?relatorio=S&relatorioTotalGrupoBy=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&subgrupo='+subgrupo+'&estoque='+estoque+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotalGrupoBy=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotalGrupoBy=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalGeral = function (empresa, dataI, dataF, subgrupo, estoque) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_estoque.php?relatorio=S&relatorioTotal=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&subgrupo='+subgrupo+'&estoque='+estoque+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotalGeral=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotalGeral=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};



			$scope.busca = function(empresa, dataI, dataF, subgrupo, estoque){

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				if (empresa == undefined) {
					empresa = '';
				}

				if (subgrupo == undefined) {
					subgrupo = '';
				}
				if (estoque == undefined) {
					estoque = 0;
				}
				$scope.empresa = empresa;
				$scope.dataI = dataI;
				$scope.dataF = dataF;
				$scope.subgrupo = subgrupo;
				$scope.estoque = estoque;
//				$scope.progresiveBar = true;
				$scope.relatorio = [];
				$scope.relatorioTotal = [];
				$scope.relatorioTotalGrupoBy=[];
				$scope.relatorioTotalGeral=[];

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				relatorioSubGrupo();
				relatorioRegistro();
				relatorioTotalRegistro(empresa, dataI, dataF,subgrupo,estoque);
				relatorioTotalGrupoBy(empresa, dataI, dataF, subgrupo, estoque);
				relatorioTotalGeral(empresa, dataI, dataF, subgrupo, estoque);

				//console.log(dataI+'--'+dataF);

			}


			$scope.print = function(){
				chamarAlerta();

    			$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';

				setTimeout(function() {
					gerarpdf();
					chamarAlerta();
				},	3000);

			}



		  }).config(function($mdDateLocaleProvider) {
		   $mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out','Nov','Dez'];
		   $mdDateLocaleProvider.Months  = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
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

	    function chamarAlerta(){
			$('.alert').toggle("slow");

		};

		function gerarpdf() {
<?php if (base64_encode($logoEmp) != null) {?>
			var LogoEmp = new Image();
    		LogoEmp.src = 'data:image/jpeg;base64,<?=$logoEmp?>';
    		//LogoEmp.src = 'imagens_empresas/1/logo/LogoZMPro.png';
<?php } else {?>

			var LogoEmp = new Image();
    		LogoEmp.src = 'images/Logo ZM Pro1.png';
    		//LogoEmp.src = 'imagens_empresas/1/logo/LogoZMPro.png';

<?php }?>
    		var doc = new jsPDF('p', 'pt', 'a4');

    		var data1 = doc.autoTableHtmlToJson(document.getElementById("tabela"));
    		var rows = data1.rows;

    		//tipo de pesquisa
<?php if (base64_decode($empresa_acesso) == 0) {?>
    		var empresa = document.getElementById('empresa').options[document.getElementById('empresa').selectedIndex].innerText;
<?php } else {?>
			var empresa = '<?=$dados_empresa["em_fanta"]?>';
<?php }?>

			var subgrupo = document.getElementById('subgrupo').options[document.getElementById('subgrupo').selectedIndex].innerText;

			var subG = document.getElementById('subG');


			//var DataInicio = document.getElementById("dataI").value;
    		//var DataFim = document.getElementById("dataF").value;

    		//var arrData = DataInicio.split('-');
    		//var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);

    		//var arrDataF = DataFim.split('-');
    		//var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);


    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Relatório de Posição Financeira de Estoque", 85, 27);
		        doc.setFontSize(12);
		        doc.setTextColor(40);
		        doc.setFontStyle('italic');
		        doc.text("<?=$nomeEmp?>", 85, 47);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
		        doc.setFontSize(9);
		        doc.text("Empresa: " + empresa , 85, 56);
		        doc.text("Subgrupo: " + subgrupo , 85, 66);
        		//doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 76);


    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},

		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.05},

		        columnStyles: {
		        0: {halign: 'center', cellWidth: 30}, //cod
		        1: {halign: 'left', cellWidth: 80}, //emp
		        2: {halign: 'left', cellWidth: 125}, //desc
		        3: {halign: 'center', cellWidth: 35}, //un
		        4: {halign: 'right', cellWidth: 65}, //subG
		        5: {halign: 'right', cellWidth: 35}, //est
		        6: {halign: 'right', cellWidth: 40}, //cust
		        7: {halign: 'right', cellWidth: 45}, //vista
		        8: {halign: 'right', cellWidth: 55}, //c.total
		        9: {halign: 'right', cellWidth: 55}, //v.total
		    	},

		        rowStyles: {4: {fontSize: (number = 11)}},
		        tableLineColor: [189, 195, 199],
		        tableLineWidth: 0.45,
		        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
		        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
		        alternateRowStyles: {fillColor: [250, 250, 250]},


		        drawRow: function (row, data) {
		            // Colspan
		            doc.setFontStyle('bold');
		            doc.setFontSize(8);
		            if ($(row.raw[0]).hasClass("innerHeader")) {
		                doc.setTextColor(200, 0, 0);
		                doc.setFillColor(110,214,84);
		                //subG.doc.setFillColor(110,0,84);
		                doc.rect(data.settings.margin.left, row.y, data.table.width, 20, 'F');
		                doc.autoTableText("", data.settings.margin.left + data.table.width / 2, row.y + row.height / 2, {
		                    halign: 'center',
		                    valign: 'middle',
		                });

		               /*  data.cursor.y += 20; */
		            };

		            if (row.index % 5 === 0) {
		                var posY = row.y + row.height * 6 + data.settings.margin.bottom;
		                if (posY > doc.internal.pageSize.height) {
		                    data.addPage();
		                }
		            }
		        },


    		});

    		//Tabela de Totais
		    var data2 = doc.autoTableHtmlToJson(document.getElementById("tabela2"));
		    var rows = data2.rows;

		    doc.autoTable(data2.columns, data2.rows, {
	        startY: doc.autoTable.previous.finalY + 10,
	        margin: {top: 80, right: 10, bottom: 20, left: 450},
	        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
	        columnStyles: {0: {halign: 'left'},1: {halign: 'right'}},
	        rowStyles: {1: {fontSize: (number = 11)}},
	        tableLineColor: [189, 195, 199],
	        tableLineWidth: 0.75,
	        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
	        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
	        alternateRowStyles: {fillColor: [250, 250, 250]},

	    });


    		window.open(doc.output('bloburl'),'_blank');

		}

	</script>


</body>
</html>