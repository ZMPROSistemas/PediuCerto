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
	th:focus{
		outline: none;
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

			<div ng-controller="ZMProCtrl" ng-init="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd', subgrupo)">
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
						<li class="breadcrumb-item active" aria-current="page">Relatório De Ranking De Produtos</li>

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

						    	<div class="form-group col-md-2 col-2 pt-3">
						    		<label for="periodo">SubGrupo</label>
						    		<select name="subgrupo" class="form-control form-control-sm capoTexto" id="subgrupo" ng-model="subgrupo" value="">
						    			<option value="">Todos SubGrupo</option>
						    			<option ng-repeat="sub in dadosSubgrupo" value="{{sub.sbp_codigo}}">{{sub.sbp_descricao}}</option>
						    			option
						    		</select>

						    	</div>

						    	<div class="form-group col-md-1 col-1" style="margin-right: -10px !important; margin-left: -34px !important;">
								   <div style="margin-top: 35px;">
								   	<label></label>

									<button class="btn btn-outline-dark" lass="btn btn-outline-dark" style="color: white;"ng-click="busca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd', subgrupo)"><i class="fas fa-search"></i></button>
								</div>
								<div class="form-group col-md-2 col-2" style="margin-left: 34px !important; margin-top: -40px;">
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
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vdi_prod')">Código
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')">Empresa
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vdi_descricao')">Descrição
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('qnt')">Quant
											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('total')">Total
											</th>

										</tr>

									</thead>
									<tbody>
										<tr dir-paginate="relatorio in relatorio|itemsPerPage:10|orderBy:sortKey:reverses" ng-click="null">
											<td ng-bind="relatorio.vdi_prod"></td>
											<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
											<td ng-bind="relatorio.vdi_descricao"></td>
											<td ng-bind="relatorio.qnt"></td>
											<td ng-bind="relatorio.total |currency:'R$'"></td>
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
							<th>Código</th>
							<th>Empresa</th>
							<th>Descrição</th>
							<th>Quant</th>
							<th>Total</th>
						</tr>
					</thead>

					<tbody>
						
						<!--tr ng-repeat="relatorio in relatorioPrint|orderBy:sortKey:reverses">

							<td ng-bind="relatorio.vdi_prod"></td>
							<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
							<td ng-bind="relatorio.vdi_descricao"></td>
							<td ng-bind="relatorio.qnt"></td>
							<td ng-bind="relatorio.total"></td>
						</tr-->
					</tbody>

				</table>

				<table id="tabela2">
					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>Quantidade</td>
							<td>{{relatorioTotalQtsValor[0].qnt}}</td>
						</tr>
						<tr>
							<td>Valor total</td>
							<td>{{relatorioTotalQtsValor[0].total | currency:'R$ '}}</td>
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
			$scope.dadosSubgrupo=[];
			$scope.relatorio = [];
			$scope.relatorioTotal = [];
			$scope.relatorioTotalQtsValor=[];


			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();

    		//$scope.dataI = '2011-01-01';
    		//$scope.dataF = '2011-01-30';

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

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
			 var relatorioRegistro = function (empresa, dataI, dataF, subgrupo) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rank_produto.php?relatorio=S&dadosRelatorio=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&subgrupo='+subgrupo
				}).then(function onSuccess(response){
					$scope.relatorio=response.data.result[0];
					tabelaPDF(empresa, dataI, dataF, subgrupo);
					$scope.progresiveBar = false;
				}).catch(function onError(response){
					$scope.relatorio=response.data;
					$scope.progresiveBar = false;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalRegistro = function (empresa, dataI, dataF, subgrupo) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rank_produto.php?dadosRelatorio=S&relatorioTotalRegistro=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&subgrupo='+subgrupo
				}).then(function onSuccess(response){
					$scope.relatorioTotal=response.data.result[0];
				}).catch(function onError(response){
					$scope.relatorio=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			var relatorioTotalQtsValor = function (empresa, dataI, dataF, subgrupo) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rank_produto.php?dadosRelatorio=S&relatorioTotalQtsValor=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&subgrupo='+subgrupo
				}).then(function onSuccess(response){
					$scope.relatorioTotalQtsValor=response.data.result[0];
				}).catch(function onError(response){
					$scope.relatorio=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			$scope.busca = function(empresa, dataI, dataF, subgrupo){

				$scope.relatorio = [];
			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				if (empresa == undefined) {
					empresa = '';
				}
				if (subgrupo == undefined) {
					subgrupo = '';
				}

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>

				relatorioRegistro(empresa, dataI, dataF, subgrupo);
				relatorioTotalRegistro(empresa, dataI, dataF, subgrupo);
				relatorioTotalQtsValor(empresa, dataI, dataF, subgrupo);

				console.log(dataI+'--'+dataF);

			}

				$scope.print = function(){
					//$scope.relatorioPrint=[];
					chamarAlerta();

	    			$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';
					/*
	   				for (var i = 0; i < $scope.relatorio.length; i++) {
	   					 	$scope.relatorioPrint.push($scope.relatorio[i]);
	   					 	console.log($scope.relatorioPrint);
	   				}
					*/

					setTimeout(function() {
						gerarpdf();
						chamarAlerta();
					},	1000);

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

function tabelaPDF(empresa, dataI, dataF, subgrupo) {

			var itens = "", url ='services/relatorio_rank_produto.php?relatorio=S&dadosRelatorio=S&js=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&subgrupo='+subgrupo
			$.ajax({
				url: url,
				cache: false,
				dataType: "json",
				beforeSend: function() {
					
				},
				error: function() {
				
				},
				success: function(retorno) {
					for(var i = 0; i<retorno.length; i++){
						itens += "<tr>";
						itens += "<td>" + retorno[i].vdi_prod + "</td>";
						itens += "<td>" + retorno[i].em_fanta + "</td>";
						itens += "<td>" + retorno[i].vdi_descricao + "</td>";
						itens += "<td>" + retorno[i].qnt + "</td>";
						itens += "<td> R$ " + retorno[i].total + "</td>";
						
						
					}
					$("#tabela tbody").html(itens);
				}
			})
			
		};

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
		        doc.text("Relatório De Ranking De Produtos", 85, 27);
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
        		doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 76);


    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'left'},
		        	1: {halign: 'left'},
		        	2: {halign: 'left'},
		        	3: {halign: 'left'},
		        	4: {halign: 'right'}},
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