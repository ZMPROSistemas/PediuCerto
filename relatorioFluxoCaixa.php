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

	#tabela{display: none;}
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

</style>

<!--			<div ng-controller="ZMProCtrl" ng-init="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">

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
						<li class="breadcrumb-item active" aria-current="page">Fluxo de Caixa</li>
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

											<div class="col-auto ml-2">
												<label for="dataI">Período de </label>
											</div>
											<div class="col-auto">
												<input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">
											</div>
											<div class="col-auto">
												<label for="dataF">até </label>
											</div>
											<div class="col-auto">
												<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">
											</div>
											<div class="ml-auto m-0 p-0">
												<md-button class="btnPesquisar pull-right" style="border: 1px solid white; border-radius: 5px;" ng-click="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
												<md-button class="btnImprimir pull-right" style="border: 1px solid green; border-radius: 5px;" ng-disabled="!relatorioFC[0]" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
												<md-button class="btnSalvar pull-right" id="csv" style="border: 1px solid yellow; border-radius: 5px;" ng-click="exportarCsv()" ng-disabled="!relatorioFC[0]" >
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
														<th></th>
														<th scope="col" style=" font-weight: normal; text-align:left;" ng-click="ordenar('ct_emissao')">Documento</th>
														<th scope="col" style=" font-weight: normal; text-align:center;" ng-click="ordenar('ct_emissao')">Parcela</th>
														<th scope="col" style=" font-weight: normal; text-align:left;" ng-click="ordenar('em_fanta')">Cliente / Fornecedor</th>
														<th scope="col" style=" font-weight: normal; text-align:right;" ng-click="ordenar('ct_valor')">Receber</th>
														<th scope="col" style=" font-weight: normal; text-align:right;" ng-click="ordenar('ct_valor')">Pagar</th>
														<th scope="col" style=" font-weight: normal; text-align:right;" ng-click="ordenar('ct_receber_pagar')">Saldo</th>
													</tr>

												</thead>
												<tbody ng-repeat="relatorio in relatorioFC | unique: 'ct_vencto'" ng-init="saldo = saldo + (TotalDiarioReceber(relatorio.ct_vencto) - TotalDiarioPagar(relatorio.ct_vencto))">
													<tr>
														<td colspan="12"><b>{{relatorio.ct_vencto | date : 'dd/MM/yyyy'}}</b></td>
													</tr>
													<tr ng-repeat="dados in relatorioFC | filter:{ct_vencto:relatorio.ct_vencto}">
														<td></td>
														<td align="left">{{dados.ct_docto}}</td>
														<td align="center">{{dados.ct_parc}}</td>
														<td align="left">{{dados.ct_nome}}</td>
														<td align="right">{{dados.ct_valor_receber == '0' ? '' : (dados.ct_valor_receber | currency: 'R$ ')}}</td>
														<td align="right">{{dados.ct_valor_pagar == '0' ? '' : (dados.ct_valor_pagar | currency: 'R$ ')}}</td>
														<td align="right"></td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style="text-align:right;" >Totais do Dia: </td>
														<td style="text-align:right;" ><b>{{TotalDiarioReceber(relatorio.ct_vencto) | currency: 'R$ '}}</b></td>
														<td style="text-align:right;" ><b>{{TotalDiarioPagar(relatorio.ct_vencto) | currency: 'R$ '}}</b></td>
														<td style="text-align:right;"><b>{{saldo | currency: 'R$ '}}</b></td>
													</tr>
												</tbody>
												<tfooter>
													<td colspan="12" style="text-align:right;" >Total para o Período Selecionado: <b>{{TotalGeral | currency:'R$ '}}</b></td>
												</tfooter>
											</table>
											<div ng-if="arrayNull == true">
												<div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
													Aguarde... Pesquisando!
												</div>
											</div>
										</div>

							<!--div show-on-mobile>
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
							    </md-content>-->


							<!-- Final Desktop -->
										<div class="card-footer p-0 pb-2">
											<div class="form-row align-items-center">
												<div class="col-6" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: white;">Saldo Líquido: <b class="col-auto">{{somaSaldoLiquido | currency:'R$ '}}</b></span>
													</div>
												</div>
												<div class="col-6" style="text-align: right;">
													<div class="row justify-content-end">
														<span style="color: grey;">Saldo Médio (em %): <b>{{mediaSaldoPerc | number: 2}}%</b></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
						</div>
					</div>
				</div>

				<table id="tabela">
					<thead>
						<tr>
							<th></th>
							<th>Documento</th>
							<th>Parcela</th>
							<th>Cliente / Fornecedor</th>
							<th>Receber</th>
							<th>Pagar</th>
							<th>Saldo</th>
						</tr>
					</thead>
					<tbody ng-repeat="relatorio in relatorioFC | unique: 'ct_vencto'" ng-init="saldo = (TotalDiarioReceber(relatorio.ct_vencto) - TotalDiarioPagar(relatorio.ct_vencto))">
						<tr>
							<td colspan="12"><b>{{relatorio.ct_vencto | date : 'dd/MM/yyyy'}}</b></td>
						</tr>
						<tr ng-repeat="dados in relatorioFC | filter:{ct_vencto:relatorio.ct_vencto}">
							<td></td>
							<td>{{dados.ct_docto}}</td>
							<td>{{dados.ct_parc}}</td>
							<td>{{dados.ct_nome}}</td>
							<td>{{dados.ct_valor_receber == '0' ? '' : (dados.ct_valor_receber | currency: 'R$ ')}}</td>
							<td>{{dados.ct_valor_pagar == '0' ? '' : (dados.ct_valor_pagar | currency: 'R$ ')}}</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>Totais do Dia: </td>
							<td><b>{{TotalDiarioReceber(relatorio.ct_vencto) | currency: 'R$ '}}</b></td>
							<td><b>{{TotalDiarioPagar(relatorio.ct_vencto) | currency: 'R$ '}}</b></td>
							<td><b>{{saldo | currency: 'R$ '}}</b></td>
						</tr>
					</tbody>
					<tfooter>
						<td colspan="12" >Total para o Período Selecionado: <b>{{TotalGeral | currency:'R$ '}}</b></td>
					</tfooter>
				</table>

				<table id="tabela2">
					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>Valor Venda</td>
							<td>{{somaValorVenda | currency:'R$ '}}</td>
						</tr>
						<tr>
							<td>Descontos</td>
							<td>{{somaValorDesconto | currency:'R$ '}}</td>
						</tr>
						<tr>
							<td>Valor Total</td>
							<td>{{somaValorTotal | currency:'R$ '}}</td>
						</tr>
						<tr>
							<td>Custo das Vendas</td>
							<td>{{somaValorCusto | currency:'R$ '}}</td>
						</tr>
						<tr>
							<td>Saldo Líquido</td>
							<td>{{somaSaldoLiquido | currency:'R$ '}}</td>
						</tr>
						<tr>
							<td>Saldo Médio (em %)</td>
							<td>{{mediaSaldoPerc | number: 2}}%</td>
						</tr>
					</tbody>
				</table>
			</div>

	<script src="js/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui/0.4.0/angular-ui.min.js"></script>
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

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','ui.directives', 'ui.filters']);
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
			var somaReceberDia = 0;
			var somaPagarDia = 0;
			var SubTotal = 0;
			var TotalGeral = 0;
			$scope.TotalDia = 0;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.dadosEmpresa=[];
			$scope.empresa = '';
			$scope.relatorio = [];
			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();
			$scope.Dia = '1970-01-01';
			$scope.arrayNull = true; 
    		//$scope.dataI = '2011-01-01';
    		//scope.dataF = '2011-01-30';

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

			 var relatorioRegistro = function () {
				 $scope.relatorioFC = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcRelatorioFluxoCaixa.php?relatorio=S&dadosRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.relatorioFC=response.data.result[0];
					$scope.totalPagar = 0;
					$scope.totalReceber = 0;
					$scope.TotalGeral = ($scope.relatorioFC.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_receber);}, 0)) - ($scope.relatorioFC.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_pagar);}, 0));
					//totalPesquisado();
					if ($scope.relatorioFC == '') {
						$scope.arrayNull = false;
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlertaNormal();
					}
					$scope.arrayNull = false;
					//$scope.progresiveBar = false;
				}).catch(function onError(response){
					$scope.relatorioFC=response.data;
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlertaNormal();
				});
			};
			relatorioRegistro();

			var somaValorPagar = function () {
				 $scope.relatorioFC = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcRelatorioFluxoCaixa.php?relatorio=S&somaPagar=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.somaPagarFC=response.data.result[0];
					//totalPesquisado();
					//$scope.progresiveBar = false;
				}).catch(function onError(response){

				});
			};
			somaValorPagar();

			var somaValorReceber = function () {
				 $scope.relatorioFC = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcRelatorioFluxoCaixa.php?relatorio=S&somaReceber=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.somaReceberFC=response.data.result[0];
					//totalPesquisado();
				}).catch(function onError(response){

				});
			};
			somaValorReceber();


			$scope.TotalDiarioReceber = function (vencto) {

				if (vencto != undefined) {
					var somaReceberDia = 0;
					var filtroPesquisaArray = $scope.relatorioFC.filter(item => item.ct_vencto == vencto);
					somaReceberDia = filtroPesquisaArray.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_receber);}, 0);
					return somaReceberDia;
				}
			}

			$scope.TotalDiarioPagar = function (vencto) {

				if (vencto != undefined) {
					var somaPagarDia = 0;
					var filtroPesquisaArray = $scope.relatorioFC.filter(item => item.ct_vencto == vencto);
					somaPagarDia = filtroPesquisaArray.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_pagar);}, 0);
					return somaPagarDia;
				}
			}

			$scope.SubTotalDiario = function (vencto) {

				if (vencto != undefined) {
					var filtroPesquisaArray = $scope.relatorioFC.filter(item => item.ct_vencto == vencto);
					var somaReceberDia = filtroPesquisaArray.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_receber);}, 0);
					var somaPagarDia = filtroPesquisaArray.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor_pagar);}, 0);
					SubTotal = (parseFloat(somaReceberDia) - parseFloat(somaPagarDia)) + $scope.TotalDia;
					//console.log(SubTotal);
					return SubTotal;
				}
			}

			/*var totalPesquisado = function(){

				
			
				$scope.somaValorTotal = $scope.relatorioPV.reduce(function (accumulador, total) {return accumulador + parseFloat(total.vd_total);}, 0);
				$scope.somaValorCusto = $scope.relatorioPV.reduce(function (accumulador, total) {return accumulador + parseFloat(total.vd_custo);}, 0);
				$scope.somaSaldoLiquido = ($scope.somaValorTotal - $scope.somaValorCusto);
				$scope.mediaSaldoPerc = (((($scope.somaValorTotal * 100) / $scope.somaValorCusto) - 100));
			}

			var relatorioTotalRegistro = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_vendas.php?relatorio=S&relatorioTotalRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotal=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotal=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalGrupoBy = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_vendas.php?relatorio=S&relatorioTotalGrupoBy=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotalGrupoBy=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotalGrupoBy=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};*/

			$scope.busca = function(empresa, dataI, dataF){
				$scope.relatorioPV = '';
				$scope.arrayNull = true;
				//$scope.progresiveBar = true;
				$scope.empresa = empresa;
				$scope.dataI = dataI;
				$scope.dataF = dataF;

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				if (empresa == undefined) {
					empresa = '';
				}

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				relatorioRegistro();
				somaValorReceber();
				somaValorPagar();
				console.log(dataI+'--'+dataF);

			}

			$scope.print = function(){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();
				gerarpdf();
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
			//var subgrupo = document.getElementById('subgrupo').options[document.getElementById('subgrupo').selectedIndex].innerText;
			var DataInicio = document.getElementById("dataI").value;
    		var DataFim = document.getElementById("dataF").value;
    		var arrData = DataInicio.split('-');
    		var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);
    		var arrDataF = DataFim.split('-');
    		var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);

    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Relatório de Fluxo de Caixa", 85, 27);
		        doc.setFontSize(12);
		        doc.setTextColor(40);
		        doc.setFontStyle('normal');
		        doc.text("<?=$nomeEmp?>", 85, 42);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
		        doc.setFontSize(9);
		        doc.text("Empresa Selecionada: " + empresa , 85, 52);
		        //doc.text("Subgrupo: " + subgrupo , 85, 66);
        		doc.text("Período Selecionado: " + InicioPesquisa + " até " + FimPesquisa , 85, 62);

    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 77, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'left'},
		        	1: {halign: 'left'},
		        	2: {halign: 'center'},
		        	3: {halign: 'left'},
		        	4: {halign: 'right'},
		        	5: {halign: 'right'},
		        	6: {halign: 'right'}},

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