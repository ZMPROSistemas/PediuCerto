<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";
$data = date("d/m/Y H:i:s");
?>

<style>

	#tabela{display: none;}
	#tabela2{display: none;}
	.ordernar{cursor: pointer; margin-left: 15px;}
	th:focus{
		outline: none;
		background-color: #333 !important;
	}
/*	hr {
	  top: 15px;
	  clear: both;
	  width: 0;
	  height: 5px;
	  margin: 0 0 25px;
	  display: block;
	  position: relative;
	  background: rgb(26, 2, 175);
	}
	th:focus{
		outline: none;
	}*/
	

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
	



</style>

<!--			<div ng-controller="ZMProCtrl" ng-init="busca(empresa,clientes,dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">

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
						<li class="breadcrumb-item active" aria-current="page">Relação de Vendas</li>
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

											<div class="col-3">
												<input type="text" value="" class="form-control form-control-sm text-left" id="clientes" ng-model="clientes" placeholder="Todos os Clientes">
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

											<div class="col-3">
												<input type="text" value="" class="form-control form-control-sm text-left" id="funcionario" ng-model="funcionario"  placeholder="Todos os Vendedores">
											</div>

											<div class="col-3">
												<select class="form-control form-control-sm" id="fPagamento" ng-model="fPagamento" value="">
													<option value=""> Todas as Formas de Pagamento</option>
													<option ng-repeat="FormaPagamento in dadosFormadePagamento" value="{{FormaPagamento.dc_codigo}}">{{FormaPagamento.dc_descricao}}</option>
												<?php if (base64_decode($em_ramo) == 1) {?>
													<option value=""> Por Origem De Lançamento (Mesa/Comanda/Disk Entrega)</option>
												<?php } ?>
												</select>
											</div>
										</div>

										<div class="d-flex">
											<div class="pt-2 mr-0">
												<label for="dataI">Período de </label>
											</div>
											<div class="p-2 pt-1">
												<input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">
											</div>
											<div class="p-2 pt-1">
												<label for="dataF">até </label>
											</div>
											<div class="p-2 pt-1">
												<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">
											</div>
											<div class="ml-auto m-0 p-0">
												<md-button class="btnPesquisar pull-right" style="border: 1px solid white; border-radius: 5px;" ng-click="busca(empresa,clientes,dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd', funcionario, fPagamento)" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
												<md-button class="btnImprimir pull-right" style="border: 1px solid green; border-radius: 5px;" ng-disabled="!relatorioVendas[0]" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
												<md-button class="btnSalvar pull-right" id="csv" style="border: 1px solid yellow; border-radius: 5px;" ng-click="exportarCsv()" ng-disabled="!relatorioVendas[0]" >
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
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('vd_doc')">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('vd_nome')">Cliente</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('nome_func')">Vendedor</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('vd_emis')">Emissão</th>
					<?php if (base64_decode($em_ramo) == 1) {?>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('vd_taxa')">Taxa</th>
					<?php }?>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('vd_total')"> Forma Pagto</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('vd_total')"> Valor Venda</th>
														<!--th scope="col text-left" style=" font-weight: normal;" ng-click="ordenar('vd_valor')" ng-if="tipoPg != 0">
															<span ng-if="tipoPg == 1">Val.Pago BL</span>
															<span ng-if="tipoPg == 2">Val.Pago CA</span>
															<span ng-if="tipoPg == 3">Val.Pago DN</span>
															<span ng-if="tipoPg == 4">Val.Pago PR</span>
														</!--th-->
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="relatorio in relatorioVendas | itemsPerPage:20 | orderBy:sortKey:reverse" ng-click="null">
														<td align="left">{{relatorio.vd_doc}}</td>
														<td align="left">{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
														<td align="left">{{relatorio.vd_nome}}</td>
														<td align="left">{{relatorio.nome_func}}</td>
														<td align="right">{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</td>

			<?php if (base64_decode($em_ramo) == 1) {?>
														<td>{{relatorio.vd_taxa|currency:'R$ '}}</td>
			<?php }?>
														<td align="center">{{relatorio.tipo_docto}}
														<td align="right">{{relatorio.vd_total|currency:'R$ '}}</td>
															<!--span ng-if="tipoPg == 1"></!--span>
															<span ng-if="tipoPg == 2">{{relatorio.vd_vl_pagto_ca|currency:'R$ '}}</span>
															<span ng-if="tipoPg == 3">{{relatorio.vd_vl_pagto_dn|currency:'R$ '}}</span>
															<span-- ng-if="tipoPg == 4">{{relatorio.vd_vl_pagto_dp|currency:'R$ '}}</span-->
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

										<div class="card-footer p-0">
											<div class="form-row align-items-center">
												<div class="col-6" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: white;">Vendas em Dinheiro: <b class="col-auto">{{relatorioTotalGrupoBy[0].dinheiro | currency:'R$ '}}</b></span>
													</div>
													<div class="row justify-content-start">
														<span style="color: white;">Vendas no Cartão: <b class="col-auto">{{relatorioTotalGrupoBy[0].cartao | currency:'R$ '}}</b></span>
													</div>
													<div class="row justify-content-start">
														<span style="color: white;">Vendas no Boleto: <b class="col-auto">{{relatorioTotalGrupoBy[0].boleto | currency:'R$ '}}</b></span>
													</div>
													<div class="row justify-content-start">
														<span style="color: white;">Vendas na Promissória: <b class="col-auto">{{relatorioTotalGrupoBy[0].promissoria | currency:'R$ '}}</b></span>
													</div>
												</div>
												<div class="col-6" style="text-align: right;">
													<div class="row justify-content-end">
														<span style="color: grey;">Número de Vendas no Período: <b>{{relatorioVendas.length}}</b></span>
													</div>
													<div class="row justify-content-end">
														<span style="color: grey;">Valor em Vendas no Período: <b>{{relatorioTotalGrupoBy[0].total | currency:'R$ '}}</b></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
				    	</div>


							<div show-on-mobile>
							<!--
								<md-toolbar layout="row" class="md-hue-3" style="background-color:#000; color:#fff;">
							      <div class="md-toolbar-tools" layout="row" layout-align="space-around center">

									<div flex="5">Docto.</div>
									<div flex="5">Forma</div>
									<div flex="20">Emissão</div>
									<div flex="30">Cliente</div>
									<div flex="15">Val. Prod</div>
<?php if (base64_decode($em_ramo) == 1) {?>
									<div flex="10"> Taxa </div>
<?php }?>

									<div flex="10"> Total </div>

							      </div>
							    </md-toolbar>

							    <md-content>
							    	<md-list class="p-0" flex>
							    		<md-list-item md-on-select="logItem" class="md-1-line" md-auto-select="options.autoSelect"  ng-repeat="relatorio in relatorioVendas|limitTo: query.limit: (query.page -1) * query.limit" ng-click="null" layout-align="space-around center">
							    			<div flex="5">{{relatorio.vd_doc | numberFixedLen:4}}</div>
							    			<div flex="">{{}}</div>
							    			<div flex="25">{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</div>
							    			<div flex="30">{{relatorio.vd_cli}} - {{relatorio.vd_nome}}</div>
							    			<div flex="15">{{relatorio.vd_valor|currency:'R$'}}</div>
<?php if (base64_decode($em_ramo) == 1) {?>
											<div flex="10">{{relatorio.vd_taxa|currency:'R$'}}</div>
<?php }?>
							    			<div flex="10">{{relatorio.vd_total|currency:'R$'}}</div>

							    			<md-divider></md-divider>
							    		</md-list-item>

							    	</md-list>
							    </md-content>

						-->
							</div>

							<!-- Final Desktop -->

							<div show-on-mobile>

							</div>

					</div>
				</div>

				<!-- TABELA CLONE PARA IMPRESSAO -->
				
				<table id="tabela">
					<thead>
						<tr>
							<th>Docto</th>
							<th>Empresa</th>
							<th>Cliente</th>
							<th>Vendedor</th>
							<th>Emissão</th>
		<?php if (base64_decode($em_ramo) == 1) {?>
							<th>Taxa</th>
		<?php }?>
							<th>Forma Pagto</th>
							<th>Valor Venda</th>

						<!--
						<th id="valBL" style="display:none">
							<span id="valBL">Val.Pago BL</span>
						</th>
						<th id="valCA" style="display:none">
							<span id="valCA">Val.Pago CA</span>
						</th>
						<th id="valDN" style="display:none">
							<span id="valDN">Val.Pago DN</span>
						</th>
						<th id="valPR" style="display:none">
							<span id="valPR">Val.Pago PR</span>
						</th>-->
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="relatorio in relatorioVendas | orderBy:sortKey:reverse">
							<td>{{relatorio.vd_doc}}</td>
							<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
							<td>{{relatorio.vd_nome}}</td>
							<td>{{relatorio.nome_func}}</td>
							<td>{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</td>

<?php if (base64_decode($em_ramo) == 1) {?>
							<td>{{relatorio.vd_taxa|currency:'R$ '}}</td>
<?php }?>
							<td align="center">{{relatorio.tipo_docto}}
							<td align="right">{{relatorio.vd_total|currency:'R$ '}}</td>

<!--
		    		<td id="valBL" style="display:none">
						<span id="valBL">{{relatorio.vd_vl_pagto_bl | currency:'R$ '}}</span>
					</td>

					<td id="valCA" style="display:none">
						<span id="valCA">{{relatorio.vd_vl_pagto_ca | currency:'R$ '}}</span>
					</td>

					<td id="valDN" style="display:none">
						<span id="valDN">{{relatorio.vd_vl_pagto_dn | currency:'R$ '}}</span>
					</td>

					<td id="valPR" style="display:none">
						<span id="valPR">{{relatorio.vd_vl_pagto_dp | currency:'R$ '}}</span>
					</td>
				-->
						</tr>
					</tbody>
				</table>

				<table id="tabela2" border="1">

					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>

					<tbody>

	    				<tr>
	    					<td>Dinheiro:</td>
	    					<td>{{relatorioTotalGrupoBy[0].dinheiro | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Cartão:</td>
	    					<td>{{relatorioTotalGrupoBy[0].cartao | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Boleto:</td>
	    					<td> {{relatorioTotalGrupoBy[0].boleto | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Promissoria:</td>
	    					<td>{{relatorioTotalGrupoBy[0].promissoria | currency:'R$ '}}</td>
	    				</tr>

						<tr>
	    					<td>Valor Total em Vendas:</td>
	    					<td>{{relatorioTotalGrupoBy[0].total | currency:'R$ '}}</td>
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
			$scope.empresa = '';
			$scope.clientes = '';
			$scope.funcionario = '';
			$scope.fPagamento = '';
			$scope.urlBase = 'services/'
			$scope.dadosEmpresa=[];
			$scope.dadosColaborador = [];
			$scope.dadosFormadePagamento = [{'dc_codigo':'1','dc_descricao':'Boleto'},{'dc_codigo':'2','dc_descricao':'Cartão'},{'dc_codigo':'3','dc_descricao':'Dinheiro'},{'dc_codigo':'4','dc_descricao':'Promissória'}];
			//$scope.relatorioVendas = [];
			$scope.relatorioTotalGrupoBy = [];
			$scope.arrayNull = true;

			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();
    		//$scope.dataI = '2011-01-01';
    		//$scope.dataF = '2011-01-30';
    		$scope.cliente = 'pe_cliente';
    		$scope.colaborador = 'pe_vendedor';
    		$scope.situacao = 1;
			$scope.ativo = 'S';

			$scope.tipoAlerta = "alert-primary";
			$scope.alertMsg = "Gerando PDF";

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

		    var relatorioVendas = function () {
				$scope.relatorioVendas=[];
				$scope.arrayNull = true;
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcRelatorioVendas.php?relatorio=S&dadosRegistro=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&clientes='+$scope.clientes+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&funcionario='+$scope.funcionario+'&fPagamento='+$scope.fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioVendas=response.data.result[0];
					if ($scope.relatorioVendas == '') {
						$scope.arrayNull = false;
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlertaNormal();
					}
					$scope.arrayNull = false;
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlertaNormal();
					//$scope.progresiveBar = false;
				});
			};
			relatorioVendas();

			var relatorioTotalGrupoBy = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcRelatorioVendas.php?relatorio=S&relatorioTotalGrupoBy=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&clientes='+$scope.clientes+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&funcionario='+$scope.funcionario+'&fPagamento='+$scope.fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioTotalGrupoBy=response.data.result[0];

				}).catch(function onError(response){

				});
			};
			relatorioTotalGrupoBy();

			$scope.busca = function(empresa,clientes,dataI,dataF,funcionario, fPagamento){

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>
				if (empresa == undefined) {
					empresa = '';
				}
				if (clientes == undefined) {
					clientes = '';
				}

				if (funcionario == undefined) {
					funcionario = '';
				}

				if (fPagamento == undefined) {
					fPagamento = '';
				}

				$scope.empresa = empresa;
				$scope.clientes = clientes;
				$scope.funcionario = funcionario;
				$scope.fPagamento = fPagamento;
				$scope.dataI = dataI;
	    		$scope.dataF = dataF;

				relatorioVendas();
				relatorioTotalGrupoBy();

			}

			$scope.print = function(){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();
				//$scope.relatorioVendasPrint=[];
/*				chamarAlerta();

    			$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';

   				for (var i = 0; i < $scope.relatorioVendas.length; i++) {
   					 	$scope.relatorioVendasPrint.push($scope.relatorioVendas[i]);
   					 	console.log($scope.relatorioVendasPrint);
   				}
*/
//				setTimeout(function() {
					gerarpdf();
					//chamarAlerta();
//				},	1000);

			}



		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

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
		
		function exportarCsv(){
			$("#tabela").tableHTMLExport({type:'csv',filename:'Relatorio_Vendas.csv'});
		};

		<?php
			include 'controller/funcoesBasicas.js';
		?>

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
			var cliente = document.getElementById('clientes').value;
			var funcionario = document.getElementById('funcionario').value;
			var fPagamento = document.getElementById('fPagamento').options[document.getElementById('fPagamento').selectedIndex].innerText;
			var selectFpg = document.getElementById('fPagamento').options[document.getElementById('fPagamento').selectedIndex].value;
			var DataInicio = document.getElementById("dataI").value;
    		var DataFim = document.getElementById("dataF").value;
    		var arrData = DataInicio.split('-');
    		var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);
    		var arrDataF = DataFim.split('-');
    		var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);

    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 70, 70);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Relação de Vendas", 85, 27);
		        doc.setFontSize(11);
		        doc.setTextColor(40);
		        doc.setFontStyle('normal');
		        doc.text("<?=$nomeEmp?>", 85, 41);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text("Total de Vendas: " + (linhas.length - 1), 460,);
		        doc.setFontSize(8);
				doc.text("Selecionado por " , 85, 51);
				if (empresa != '') {
		        	doc.text("Empresa: " + empresa , 85, 62);					
				} 
				if (cliente != '') {
					doc.text("Cliente: " + cliente , 300, 62);
				} else{
					doc.text("Cliente: Todos os Clientes" , 300, 62);					
				}
				if (funcionario != '') {
					doc.text("Vendedor: " + funcionario , 85, 72);					
				} else {
					doc.text("Vendedor: Todos os Vendedores" , 85, 72);					
				}
				if (fPagamento != '') {
			        doc.text("Forma de Pagamento: " + fPagamento , 300, 72);					
				};
        		doc.text("Período Selecionado: " + InicioPesquisa + " até " + FimPesquisa , 85, 85);
    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 95, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'left'},
		        	1: {halign: 'left'},
		        	2: {halign: 'left'},
		        	3:{halign: 'left'},
		        	4:{halign: 'right'},
		        	5:{halign: 'center'},
		        	6:{halign: 'right'}},

		        rowStyles: {1: {fontSize: (number = 11)}},
		        tableLineColor: [189, 195, 199],
		        tableLineWidth: 0.75,
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
		                doc.rect(data.settings.margin.left, row.y, data.table.width, 20, 'F');
		                doc.autoTableText("", data.settings.margin.left + data.table.width / 2, row.y + row.height / 2, {
		                    halign: 'center',
		                    valign: 'middle'
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
				columnStyles: {0: {halign: 'left'}, 1: {halign: 'right'}},
				rowStyles: {1: {fontSize: (number = 11)}},
				tableLineColor: [189, 195, 199],
				tableLineWidth: 0.75,
				headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
				bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
				alternateRowStyles: {fillColor: [250, 250, 250]},
		    });
			//windows.print();
	   		window.open(doc.output('bloburl'),'_blank');

		}

	</script>

</body>
</html>