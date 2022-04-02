<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
//include 'services/caixas.php';
setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

?>
<style>

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

	 .modal .pagination>li>a, .pagination>li>span {
		color: white;	
		background-color: rgba(33, 37, 41, 0.9);
    	border: 1px solid transparent;
	 }
	 .tracejado {
		border:1px dashed gray;
	}
	 
</style>

			<div ng-controller="ZMProCtrl">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Administrativo</li>
						<li class="breadcrumb-item active" aria-current="page">Cálculo de Percentual de Rateio</li
>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>
				
				<div class="row">
					<div class="col-lg-12 pt-0 px-2">
						<div ng-if="lista">
						
							<div show-on-desktop>
							
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0 py-2">

                                            <div class="form-row">
												<div class="col-auto">
                                        			<label>Para realizar um novo cálculo, informe o período:</label>
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
                                                    <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="calcularPRC(dataI | date : 'yyyy-MM-dd', dataF | date : 'yyyy-MM-dd')" >
                                                        <md-tooltip md-direction="top" md-visible="tooltipVisible">Novo Cálculo</md-tooltip>
                                                        <i class="fas fa-calculator"></i> Calcular
                                                    </md-button>
                                                </div>
								    		</div>

                                        </form>
                                        <div class="card col-12 p-0 mt-0" style="border:none; background-color: rgba(0,0,0, .15);" ng-if="!semLista">
                                            <div class="row">
                                                <span style="color:gainsboro;">RESULTADOS DO ÚLTIMO CÁLCULO</span>
                                            </div>
                                        </div>
										<div class="table-responsive p-0"  style="overflow: hidden;" ng-if="!semLista">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;" ng-if="!semLista">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important; font-weight: normal;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Percentual Salvo</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">Data do Último Cálculo</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Período Informado</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="calc in listaPRC | orderBy:'sortKey':reverse">
														<td style="text-align: left;" ng-bind="calc.em_fanta"></td>
														<td style="text-align: center;">{{calc.prc_percentual | number: 2}}%</td>
														<td style="text-align: right;" ng-bind="calc.prc_data"></td>
														<td style="text-align: center;" ng-bind="calc.prc_obs"></td>
													</tr>
												</tbody>
											</table>
                                        </div>
                                        <div class="jumbotron jumbotron-fluid" ng-if="semLista">
                                            <div class="container">
                                                <h1 class="display-4">Que pena!</h1>
                                                <p class="lead">Não há registros de Percentual de Rateio de Contas no sistema.</p>
                                                <hr class="my-4" style="border-color:rgba(33, 37, 41, 0.9);">
                                                <p>Vamos iniciar um novo cálculo? Basta informar o período aí em cima e clicar em Calcular.</p>
                                            </div>
                                        </div>
										<div class="card col-12 p-0 mt-0" style="border:none; background-color: rgba(0,0,0, .15);" ng-if="novoCalculo">
											<hr class="tracejado"></hr>
                                            <div class="row">
                                                <span style="color:gainsboro;">CÁLCULO ATUAL </span>
                                            </div>
                                        </div>
										<div class="table-responsive"  style="overflow: hidden;" ng-if="novoCalculo">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important; font-weight: normal;">
                                                        <th scope="col" style=" font-weight: normal; text-align: left;"></th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">Vendas no Período</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Percentual Calculado</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Percentual Selecionado</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">Período Informado</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="calculo in calcPRC | orderBy:'sortKey':reverse">
                                                        <td align="center">
                                                            <input type="checkbox" id="selectConta" ng-model="selectConta" ng-change="selecionarConta(calculo,selectConta)">
                                                        </td>
														<td style="text-align: left;" ng-bind="calculo.em_fanta"></td>
														<td style="text-align: right;" ng-bind="calculo.vd_total | currency: 'R$ '"></td>
														<td style="text-align: center;">{{((calculo.vd_total * 100) / calculo.vd_somaperiodo) | number: 2}}%</td>
														<td style="text-align: center;">{{selectConta == true ? (((calculo.vd_total * 100) / somaperiodo) | number: 2) : ''}}%</td>
														<td style="text-align: right;" >{{dataI | date: 'dd/MM/yyyy'}} a {{dataF | date: 'dd/MM/yyyy'}}</td>
													</tr>
												</tbody>
											</table>
										</div>
                                    </div>

									<div class="card-footer pt-0 mt-0" ng-if="calcPRC">
										<div class="form-row align-items-center">
											<div class="col-6" style="text-align: left;" ng-if="!mudaAviso">
												<i style="font-size: 2em !important;" class="fas fa-angle-up"></i> 
												<br>
												<span class="pull-left" style="color: white;">Selecione as empresas que farão parte do novo cálculo</span>
                                                <md-button class="btnOk pull-left " style="border: 1px solid green; border-radius: 5px;" ng-if="somaperiodo > 0" ng-click="mudarAviso()">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Pronto</md-tooltip>
                                                    <i class="fas fa-check"></i> Pronto
                                                </md-button>
                                                <md-button class="btnCancelar pull-left" style="border: 1px solid red; border-radius: 5px;" ng-click="MudarVisibilidade()">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Cancelar</md-tooltip>
                                                    <i class="fas fa-ban"></i> Não
                                                </md-button>
                                             </div>
                                            <div class="col-6" style="text-align: left;" ng-if="mudaAviso">
                                                <label class="pull-left">Após verificar as informações acima, deseja confirmar este novo cálculo? </label>
                                                <br>
                                                <md-button class="btnCancelar pull-left" style="border: 1px solid red; border-radius: 5px;" ng-click="limparCalculo()">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Cancelar</md-tooltip>
                                                    <i class="fas fa-ban"></i> Não
                                                </md-button>
                                                <md-button class="btnSalvar pull-left" id="csv" style="border: 1px solid green; border-radius: 5px;" ng-click="salvarCalculos()">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Salvar</md-tooltip>
                                                    <i class="fas fa-save"></i> Sim
                                                </md-button>
                                            </div>
                                            <div class="col-6" style="text-align: right;" >
                                                <span class="pull-right" style="color: grey;">Valor Total das Empresas: <b>{{calcPRC[0].vd_somaperiodo | currency: 'R$ '}}</b></span>
                                                <br>
                                                <span class="pull-right" style="color: grey;">Valor Total das Empresas Selecionadas: <b>{{somaperiodo | currency: 'R$ '}}</b></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>  
	    </div>
	</div>

	<script src="js/popper.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
            $scope.lista = true;
            $scope.semLista = false;
            $scope.novoCalculo = false;
            $scope.ficha = false;
            $scope.somaperiodo = 0;
            $scope.mudaAviso = false;
            $scope.arrayCalculados = [];
            $scope.data = new Date();
            $scope.dataI = dataInicial();
            $scope.dataF = dataHoje();
  			$scope.urlBase = 'services/'
  			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
			$scope.dadosEmpresa=[];
			$scope.status = 'A';

			function dataInicial(soma=0) {

                var data = new Date();
                data.setDate(data.getDate() );
                var dia = data.getDate();
                var mes = data.getMonth();
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

			<?php if (base64_decode($empresa_acesso) == 0) {?>
				$scope.bc_cod_func='';
			<?php } else {?>
				$scope.bc_cod_func='<?=$us_cod?>';
			<?php }?>

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

            var buscaPRC = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcPercRateio.php?listaPRC=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
                    $scope.listaPRC=response.data.result[0];
                    if ($scope.listaPRC.length == 0) {
                        $scope.semLista = true;
                    } else {
                        $scope.semLista = false;
                    }
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Erro ao carregar Percentuais de Rateio. Caso este erro persista, contate o suporte."
					chamarAlerta();
			//        alert("idtreinoAluno");
				});
            };
            buscaPRC();

            $scope.calcularPRC = function (inicioPeriodo, fimPeriodo) {
                $scope.dataI = inicioPeriodo;
                $scope.dataF = fimPeriodo;
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcPercRateio.php?calcularPRC=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
                    $scope.calcPRC = response.data.result[0];
                    //$scope.somaperiodo = $scope.calcPRC[0].ct_somaperiodo;
                    $scope.novoCalculo = true;
                    $scope.semLista = false;
                    if ($scope.calcPRC.length == 0) {
                        $scope.tipoAlerta = "alert-warning";
                        $scope.alertMsg = "Não foi possível calcular com os dados informados."
                        chamarAlerta();
                   } 
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Erro ao realizar os cálculos. Caso este erro persista, contate o suporte."
					chamarAlerta();
			//        alert("idtreinoAluno");
				});
            };

            $scope.selecionarConta = function(calculo, selectConta) {

                if (selectConta == true) {

                    $scope.arrayCalculados.push(calculo);
                }
                if (selectConta == false) {
                    var index = $scope.arrayCalculados.indexOf(calculo);
                    $scope.arrayCalculados.splice(index, 1);
                }
                $scope.somaperiodo = $scope.arrayCalculados.reduce(function (accumulador, total) {return accumulador + parseFloat(total.vd_total);}, 0);
			}
			
			$scope.salvarCalculos = function(){

				var calculados = $scope.arrayCalculados;

				$http({
				method: 'POST',
				headers: {'Content-Type':'application/json'},
				data: {
					calculados:calculados,
				},
				url: $scope.urlBase+'srvcPercRateio.php?gravarPRC=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&somaPeriodo='+$scope.somaperiodo+'&obs='+$scope.dataI +' a '+$scope.dataF
				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];
					alert($scope.retStatus[0].status);
					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Cálculo Cadastrado com Sucesso";
						chamarAlerta();
						buscaPRC();
					}
					else if($scope.retStatus[0].status == 'ERROR'){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao cadastrar o cálculo";
						chamarAlerta();
					}
					console.log($scope.retStatus);

				}).catch(function onError(){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Xiiii.... Deu ruim!";
						chamarAlerta();
				})
				$scope.MudarVisibilidade();
				$scope.tipoAlerta = "alert-success";
				$scope.alertMsg = "Pronto. Verifique os novos valores.";
				chamarAlerta();
			}

			$scope.mudarAviso = function () {

				$scope.mudaAviso = !$scope.mudaAviso;
			}

			$scope.limparCalculo = function() {

				$scope.mudarAviso();
			}

            $scope.MudarVisibilidade = function() {

				window.location.reload();

		    };

			$scope.print = function(tipoRelatorio){
				var caixa = $scope.movCaixa[0].bc_descricao
				console.log(tipoRelatorio. caixa);
				gerarpdf(tipoRelatorio, caixa);
			}


		});

		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};

	
		
		function loguin(){
			$('.login').toggle("slow");
		}
		function abrirCaixa(){
			$('.abrirCaixa').toggle("slow");
		}

		function senhaIn(e){
	 		$('#login').attr('type', 'password');
		}
		

		function senhaOut(){
			//$('#login').attr('type', 'text');
			//alert('certo');
		}

		function gerarpdf(tipoRelatorio,caixa) {
			var tipoRel = tipoRelatorio;
			var cx = caixa;
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
			var data1 = doc.autoTableHtmlToJson(document.getElementById("movimento"));
			var rows = data1.rows;
			
<?php if (base64_decode($empresa_acesso) == 0) {?>
    		var empresa = document.getElementById('empresa').options[document.getElementById('empresa').selectedIndex].innerText;
<?php } else {?>
			var empresa = '<?=$dados_empresa["em_fanta"]?>';
<?php }?>
			var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text(tipoRel, 85, 27);
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
				doc.text(cx , 85, 66);
		        //doc.text("Subgrupo: " + subgrupo , 85, 66);
        		//doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 76);


			}
			
			doc.autoTable(data1.columns, data1.rows,{
				beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
				styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
				
				columnStyles: {
					0: {halign: 'left',cellWidth: 60}, 
					1: {halign: 'center', cellWidth: 50}, 
					2: {halign: 'right', cellWidth: 60},
					

					rowStyles: {1: {fontSize: (number = 11)}},
					tableLineColor: [189, 195, 199],
					tableLineWidth: 0.75,
					headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
					bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
					alternateRowStyles: {fillColor: [250, 250, 250]},

					drawRow: function (row, data) {
						doc.setFontStyle('bold');
						doc.setFontSize(8);
						if ($(row.raw[0]).hasClass("innerHeader")) {
							c.setTextColor(200, 0, 0);
							doc.setFillColor(110,214,84);
							doc.rect(data.settings.margin.left, row.y, data.table.width, 20, 'F');
							doc.autoTableText("", data.settings.margin.left + data.table.width / 2, row.y + row.height / 2, {
								halign: 'center',
		                    	valign: 'middle'
							});
						};

						if (row.index % 5 === 0) {
		                	var posY = row.y + row.height * 6 + data.settings.margin.bottom;
		                	if (posY > doc.internal.pageSize.height) {
		                    	data.addPage();
		                	}
		            	}
						
					}
				}
			});

			window.open(doc.output('bloburl'),'_blank');

		}

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