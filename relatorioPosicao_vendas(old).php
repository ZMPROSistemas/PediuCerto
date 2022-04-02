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
	}
	}



</style>

			<div ng-controller="ZMProCtrl" ng-init="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">
<!--
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

		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Relatório Posição De Vendas</li>

					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="top: 0; bottom: 0; left: 0; right: 0; margin: auto;  width: 150px; height: 100px; position: absolute; z-index: 999; align-items: center;">
				  {{alertMsg}} <i class="fas fa-file-alt" style="margin-left: 5px;"></i>
				  <!--<md-progress-linear md-mode="determinate" value="20"></md-progress-linear>-->

				  <hr style="{{progressClass}}"/>
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">

					    	<div class="row bg-dark">

					    		<div class="form-group col-md-4 col-12 pt-3">

									<?php if (base64_decode($empresa_acesso) == 0) {?>

										<label for="empresas">Empresas</label>

										<select class="form-control form-control-sm capoTexto" id="empresa" ng-model="empresa" value="">
											<option value=""> Todas Empresas</option>
											<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>

										</select>

									<?php } else {
	echo $dados_empresa["em_fanta"];
}?>

						    	</div>
						    	<div class="form-group col-md-2 col-12 pt-3">

						    		<label for="periodo">Período</label>
						    		<input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">

						    	</div>

						    	<div class="form-group col-md-2 col-12 pt-3">
						    		<label for="periodo">a</label>
						    		<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">

						    	</div>

						    	<div class="form-group col-md-2 col-10" style="margin-right: -10px !important; margin-left: -34px !important;">
								   <div style="margin-top: 40px;">
								   	<label></label>

									<button class="btn btn-outline-dark" lass="btn btn-outline-dark" style="color: white;" ng-click="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')"><i class="fas fa-search"></i></button>

		    	                  </div>

						    	</div>

						    	<div class="form-group col-md-2 col-10" style="margin-left: 40px !important;">
						    		<div style="margin-top: 35px;">
						    			<LABEL></LABEL>
										<md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px;" ng-click="print()">
											<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
					                      	<i class="fas fa-print" style=""></i> Imprimir
		    	                	</md-button>
		    	                	</div>
						    	</div>



						    </div>

					    	<div show-on-desktop>

					    		<table class="table table-striped table-borderless" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1.1em !important;">
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_emis')">Data
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')">Empresa
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_doc')">Venda
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('custo')">Custo
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('descto')">Descto
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('saldo')">Saldo
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('saldoPorc')">% Saldo
											</th>

										</tr>

									</thead>
									<tbody>
										<tr dir-paginate="relatorio in relatorio|itemsPerPage:10|orderBy:sortKey:reverses" ng-click="null">
											<td ng-bind="relatorio.vd_emis| date: 'dd/MM/yyyy'"></td>
											<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
											<td ng-bind="relatorio.total | currency : 'R$ '"></td>
											<td ng-bind="relatorio.custo | currency : 'R$ '"></td>
											<td ng-bind="relatorio.descto |currency:'R$'"></td>
											<td ng-bind="relatorio.saldo |currency:'R$'"></td>
											<td>{{relatorio.saldoPorc}}%</td>
										</tr>

									</tbody>
								</table>





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




							<div show-on-mobile>


							</div>

<!--
						<md-table-pagination md-limit="query.limit" md-page="query.page" md-total="{{paginacao[0].total}}" md-page-select="dadosCliente" md-boundary-links="options.boundaryLinks" md-on-paginate="logPagination"></md-table-pagination>
-->
						<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>




					</div>
				</div>

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
						<tr ng-repeat="relatorio in relatorioPrint|orderBy:sortKey:reverses">
							<td>{{relatorio.vd_emis | date: 'dd/MM/yyyy'}}</td>
							<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
							<td>{{relatorio.total}}</td>
							<td>{{relatorio.custo| number : 2}}</td>
							<td>{{relatorio.descto}}</td>
							<td>{{relatorio.saldo}}</td>
							<td>{{relatorio.saldoPorc}}%</td>
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
							<td>Venda</td>
							<td>R$ {{relatorioTotalGrupoBy[0].total}}</td>
						</tr>
						<tr>
							<td>Custo</td>
							<td>R$ {{relatorioTotalGrupoBy[0].custo}}</td>
						</tr>
						<tr>
							<td>Descto</td>
							<td>R$ {{relatorioTotalGrupoBy[0].descto}}</td>
						</tr>
						<tr>
							<td>Saldo</td>
							<td>R$ {{relatorioTotalGrupoBy[0].saldo}}</td>
						</tr>
						<tr>
							<td>Saldo Média %</td>
							<td>{{relatorioTotalGrupoBy[0].saldoPorc / relatorioTotal[0].total | number : 2}}%</td>
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
	<script src="js/dirPagination.js"></script>
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

	<!--Gerar PDF -->


	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>


    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

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
			$scope.relatorio = [];
			$scope.relatorioPrint = [];
			$scope.relatorioTotal = [];
			$scope.relatorioTotalGrupoBy=[];


			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();

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

			 var relatorioRegistro = function (empresa, dataI, dataF) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_vendas.php?relatorio=S&dadosRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF
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

			var relatorioTotalRegistro = function (empresa, dataI, dataF) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_vendas.php?relatorio=S&relatorioTotalRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotal=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotal=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalGrupoBy = function (empresa, dataI, dataF) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_posicao_vendas.php?relatorio=S&relatorioTotalGrupoBy=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.relatorioTotalGrupoBy=response.data.result[0];

				}).catch(function onError(response){
					$scope.relatorioTotalGrupoBy=response.data;

					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};



			$scope.busca = function(empresa, dataI, dataF){

				$scope.progresiveBar = true;
				$scope.relatorio = [];
				$scope.relatorioTotal = [];
				$scope.relatorioTotalGrupoBy=[];

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				if (empresa == undefined) {
					empresa = '';
				}


			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				relatorioRegistro(empresa, dataI, dataF);
				relatorioTotalRegistro(empresa, dataI, dataF);
				relatorioTotalGrupoBy(empresa, dataI, dataF);

				console.log(dataI+'--'+dataF);

			}


			$scope.print = function(){
				$scope.relatorioVendas=[];
				chamarAlerta();

    			$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';

   				for (var i = 0; i < $scope.relatorio.length; i++) {
   					 	$scope.relatorioPrint.push($scope.relatorio[i]);
   					 	console.log($scope.relatorioVendas);
   				}

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
		        doc.text("Relatório Posição De Vendas", 85, 27);
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
		        //doc.text("Subgrupo: " + subgrupo , 85, 66);
        		doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 66);


    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'center'},
		        	1: {halign: 'left'},
		        	2: {halign: 'right'},
		        	3: {halign: 'right'},
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