<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$ano = date('Y');
$mes = date('m');
$hoje = date('Y-m-d');
$data = date("d/m/Y H:i:s");

?>

<style>

	.alert {
		display: none;
	}

	.text-capitalize {
  		text-transform: capitalize; 
	}

	#tabela {
		display: none;
	}

	#tabela2 {
		display: none;
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

	.table td {
		vertical-align: middle;
	}

	.table-responsive { 

		overflow:scroll;
		background-color:#ffffff;

	}

	pre { 
	
		font-family: 'Baloo 2', cursive;
		font-size: 1.1em;
	    font-weight: 300;
		line-height: 1.7em;
		margin-bottom: 0px;
	
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

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Relatório de Resultados</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
				  {{alertMsg}}
				</div>

                <div class="row">
					<div class="col-lg-12 pt-0 px-2">

                        <div show-on-desktop>
                            <div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body py-0 px-2 m-0">
                                    <form class="my-0 pt-0">
                                        <div class="form-row align-items-center" ng-init="empresa = '<?=base64_decode($empresa)?>'">
        <?php if (base64_decode($empresa_acesso) == 0) {?>
                                            <div class="col-auto ml-2">
                                                <label for="dataI">Informe a empresa</label>
                                            </div>
                                            <div class="col-auto">
                                                <select class="form-control form-control-sm" id="empresa" ng-model="empresa">
                                                    <option value="">Selecione</option>
                                                    <option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
                                                </select>
                                            </div>
        <?php } else {
        echo $dados_empresa["em_fanta"];
        }?>
                                            <div class="col-auto ml-3">
                                                <label for="dataI">Escolha o mês </label>
                                            </div>
                                            <div class="col-auto">
												<input type="month" class="form-control form-control-sm" id="dataF" value="{{dataF | date: 'yyyy-MM'}}" ng-model="dataF" >
                                             </div>
                                            <!--<div class="col-auto">
                                                <label for="dataF">até </label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" class="form-control form-control-sm"  ng-model="dataF" >
                                            </div>-->
											<div class="col-auto">
												<md-button class="btnPesquisar pull-left" style="border: none;" ng-click="MudaEmpresa(empresa, dataF | date: 'yyyy', dataF | date: 'MM')">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                                                    <i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
											</div>
											<div class="col-auto ml-auto">
												<md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px;" ng-click="print()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
													<i class="fas fa-print"></i> Imprimir
												</md-button>
											</div>
										</div >
                                     </form>

                                    <div class="table-responsive p-0 mb-2" style="overflow-x:hidden; overflow-y:hidden; background-color: #FFFFFFFF !important; color: black; border:none;">
                                        <table class="table table-sm table-striped" style="background-color: #FFFFFFFF !important; color: black;">
                                            <thead class="thead-dark" style="font-size: 1em !important;">
                                                <tr>
                                                    <th scope="col-auto" style="text-align: left;">Descrição</th> 
                                                    <th scope="col-auto" style="text-align: right;">Valor</th>
                                                 </tr>
                                            </thead>
											<tbody>
												<tr style=" font-weight: bold; text-align: left;font-size: 1em !important;">
													<td>1. Receitas</td>
													<td></td>
												</tr>
												<tr style="font-weight: normal; font-size: 1.1em !important;">
													<td style="text-align: left;"><pre>&#09;Vendas no mês</pre></td>
													<td style="text-align: right;" ng-bind="totalVendasMes.totalVenda | currency: 'R$ '"></td>
												</tr>
												<tr style="font-weight: bold; text-align: left;font-size: 1em !important;">
													<td>2. Custos Variáveis</td>
													<td></td>
												</tr>
												<tr style="font-weight: normal; font-size: 1.1em !important;">
													<td style="text-align: left;"><pre class="mb-0" >&#09;Custo da Mercadoria Vendida</pre></td>
													<td style="text-align: right;" ng-bind="CustoMercadoriasMes.totalCompra | currency: 'R$ '"></td>
												</tr>
												<tr style="font-weight: bold; text-align: left;font-size: 1em !important;">
													<td>3. Lucro Bruto (1 - 2)</td>
													<td></td>
												</tr>
												<tr style="font-weight: normal; font-size: 1.1em !important;">
													<td style="text-align: left;"><pre>&#09;Vendas no mês - Custo da Merc. Vendida</td></pre>
													<td style="text-align: right;">{{(totalVendasMes.totalVenda - CustoMercadoriasMes.totalCompra) | currency: 'R$ '}}</td>
												</tr>
												<tr style=" font-weight: bold; text-align: left;font-size: 1em !important;">
													<td>4. Custos Fixos</td>
													<td ></td>
												</tr>
												<tr style="font-weight: normal; font-size: 1.1em !important;" ng-repeat="custo in CustosFixosMes">
													<td style="text-align: left;"><pre>&#09;<span ng-bind="custo.ct_desc_hist"></span></pre></td>
													<td style="text-align: right;" ng-bind="custo.ct_valor | currency: 'R$ '"></td>
												</tr>
												<tr style="font-weight: bold; text-align: left;font-size: 1em !important;">
													<td>5. Lucro Liquido (3 - 4)</td>
													<td></td>
												</tr>
												<tr style="font-weight: normal; font-size: 1.1em !important;">
													<td style="text-align: left;"><pre>&#09;Lucro Bruto - Custos Fixos</pre></td>
													<td style="text-align: right;"><b>{{(totalVendasMes.totalVenda - CustoMercadoriasMes.totalCompra - somaValores) | currency: 'R$ '}}</b></td>
												</tr>
											</tbody>
										</table>
									</div><!-- Final Desktop -->
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--
					Tabela Clone para Impressão
				-->

				<table id="tabela">
					<thead>
						<tr>
							<th>Descrição</th> 
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1. Receitas</td>
							<td></td>
						</tr>
						<tr>
							<td><pre>&#09;Vendas no mês</pre></td>
							<td ng-bind="totalVendasMes.totalVenda | currency: 'R$ '"></td>
						</tr>
						<tr>
							<td>2. Custos Variáveis</td>
							<td></td>
						</tr>
						<tr>
							<td><pre>&#09;Custo da Mercadoria Vendida</pre></td>
							<td ng-bind="CustoMercadoriasMes.totalCompra | currency: 'R$ '"></td>
						</tr>
						<tr>
							<td>3. Lucro Bruto (1 - 2)</td>
							<td></td>
						</tr>
						<tr>
							<td><pre>&#09;Vendas no mês - Custo da Merc. Vendida</pre></td>
							<td>{{(totalVendasMes.totalVenda - CustoMercadoriasMes.totalCompra) | currency: 'R$ '}}</td>
						</tr>
						<tr>
							<td>4. Custos Fixos</td>
							<td ></td>
						</tr>
						<tr ng-repeat="custo in CustosFixosMes">
							<td><pre>&#09;{{custo.ct_desc_hist}}</pre></td>
							<td ng-bind="custo.ct_valor | currency: 'R$ '"></td>
						</tr>
						<tr >
							<td>5. Lucro Liquido (3 - 4)</td>
							<td></td>
						</tr>
						<tr>
							<td><pre>&#09;Lucro Bruto - Custos Fixos</pre></td>
							<td><b>{{(totalVendasMes.totalVenda - CustoMercadoriasMes.totalCompra - somaValores) | currency: 'R$ '}}</b></td>
						</tr>
					</tbody>
				</table>

				<table id="tabela2">
					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>Mês/Ano</td>
							<td>{{dataF | date: 'MM/yyyy'}}</td>
						</tr>
						<tr>
							<td>Valor total</td>
							<td>{{(totalVendasMes.totalVenda - CustoMercadoriasMes.totalCompra - somaValores) | currency: 'R$ '}}</td>
						</tr>
					</tbody>
				</table>

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
	<script src="js/angular-locale_pt-br.js"></script>

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

	    	'use strict';
	    	this.isOpen = false;

			$scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.ordem = 0;
			$scope.urlBase = 'services/';
			$scope.qtde = 1;
			$scope.somaValores = 0;
            $scope.empresa = <?=base64_decode($empresa)?>;
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
 			$scope.empresaAcesso = <?=base64_decode($empresa_acesso)?>;	
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.ano = <?=$ano?>;
			$scope.mes = '<?=$mes?>';

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

			$scope.paginacao=[];


			$scope.logPagination = function (page, limit) {
			    console.log('page: ', page);
			    console.log('limit: ', limit);
			}

			$scope.setTab = function(newTab){
			    $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		    	return $scope.tab === tabNum;
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
			
			$scope.MudaEmpresa = function(empresa, anoBusca, mesBusca) {

				$scope.empresa = empresa;
				$scope.ano = anoBusca;
				$scope.mes = mesBusca;
				TotalVendas();
				TotalCustoMercadorias();
				TotalCustosFixos();

			}

            function dataInicial(soma=0) {

                var data = new Date();
                data.setDate(data.getDate()-30);
                var dia = '01';
                var mes = data.getMonth()+1;
                var ano = data.getFullYear();
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
                });
            };
        <?php if (base64_decode($empresa_acesso) == 0) {?>
            dadosEmpresa();
        <?php }?>

			var TotalVendas = function () {
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcRelatorioResultados.php?TotalVendas=S&empresa='+$scope.empresa+'&ano='+$scope.ano+'&mes='+$scope.mes
                }).then(function onSuccess(response){
                    $scope.totalVendasMes=response.data.result[0];
				}).catch(function onError(response){
                    $scope.resultado=response.data;
                    alert("Erro ao carregar Vendas. Caso este erro persista, contate o suporte.");
				});
			};
			TotalVendas();

			var TotalCustoMercadorias = function () {
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcRelatorioResultados.php?TotalCustoMercadorias=S&empresa='+$scope.empresa+'&ano='+$scope.ano+'&mes='+$scope.mes
                }).then(function onSuccess(response){
                    $scope.CustoMercadoriasMes=response.data.result[0];
				}).catch(function onError(response){
                    $scope.resultado=response.data;
                    alert("Erro ao carregar Custos Variáveis. Caso este erro persista, contate o suporte.");

				});

			};
			TotalCustoMercadorias();
			
			var TotalCustosFixos = function () {

				$scope.tipoAlerta = "alert-info";
                $scope.alertMsg = "Aguarde! Pesquisando..."
				chamarAlerta();

				$http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcRelatorioResultados.php?TotalCustosFixos=S&empresa='+$scope.empresa+'&ano='+$scope.ano+'&mes='+$scope.mes
                }).then(function onSuccess(response){
                    $scope.CustosFixosMes=response.data.result[0];
					SomaCustoFixo();
				}).catch(function onError(response){
                    $scope.resultado=response.data;
                    alert("Erro ao carregar Custos Fixos. Caso este erro persista, contate o suporte.");
                });
			};
			TotalCustosFixos();

			var SomaCustoFixo = function(){

				$scope.somaValores = $scope.CustosFixosMes.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);

			}

			$scope.print = function(){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();

				/*$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';
				
				for (var i = 0; i < $scope.relatorio.length; i++) {
						$scope.relatorioPrint.push($scope.relatorio[i]);
						console.log($scope.relatorioPrint);
				}
				*/

				setTimeout(function() {
					gerarpdf();
					//chamarAlerta();
				},	1000);

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

	    $(document).ready(function () {
	        $("#sidebar").mCustomScrollbar({
	            theme: "minimal"
	        });

	        $('#sidebarCollapse').on('click', function () {
	            $('#sidebar, #content').toggleClass('active');
	            $('.collapse.in').toggleClass('in');
	            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
			});

			$(this).find('#codProd').focus();

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

			var DataReferencia = document.getElementById("dataF").value;
			var arrData = DataReferencia.split('-');
			var InicioPesquisa = (arrData[1] + ' de ' + arrData[0]);

			var header = function (data) {

				doc.addImage(LogoEmp, 'GIF', 10, 10, 60, 60);
				doc.setTextColor(40);
				doc.setFontSize(16);
				doc.setFontStyle('bold');
				doc.text("Relatório de Resultados", 85, 27);
				doc.setFontSize(11);
				doc.setTextColor(40);
				doc.setFontStyle('bold');
				doc.text("<?=$nomeEmp?>", 85, 40);
				doc.setFontSize(8);
				doc.setFontStyle('normal');
				doc.text("Emitido em <?=$data?>", 460, 20);
				//doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
				doc.setFontSize(9);
				doc.text("Empresa: " + empresa , 85, 50);
				doc.text("Mês e Ano de Referência: " + InicioPesquisa, 85, 60);

			}

			doc.autoTable(data1.columns, data1.rows,{
				beforePageContent: header,
				margin: {top: 72, right: 10, bottom: 20, left: 10},
				styles: {halign: 'center', theme: 'grid', fontSize: (number = 8), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
				columnStyles: {
					0: {halign: 'left'},
					1: {halign: 'right'}},
				rowStyles: {1: {fontSize: (number = 11)}},
				tableLineColor: [189, 195, 199],
				tableLineWidth: 0.75,
				headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
				bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
				alternateRowStyles: {fillColor: [250, 250, 250]},

				drawRow: function (row, data) {
					// Colspan
					doc.setFontStyle('bold');
					doc.setFontSize(10);
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
	        styles: {halign: 'center', theme: 'grid', fontSize: (number = 8), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
	        columnStyles: {0: {halign: 'left'},1: {halign: 'right'}},
	        rowStyles: {1: {fontSize: (number = 11)}},
	        tableLineColor: [189, 195, 199],
	        tableLineWidth: 0.75,
	        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
	        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
	        alternateRowStyles: {fillColor: [250, 250, 250]},

		    });

			window.open(doc.output('bloburl'),'_blank');

		};

		
	</script>

</body>
</html>