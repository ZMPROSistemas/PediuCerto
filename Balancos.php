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

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}

	.table-overflow {
    	max-height:480px;
    	overflow-x:auto;
	}

	.table-responsive{
		height:405px;  
		overflow:scroll;
	}

	thead tr:nth-child(1) th{
	    background: white;
	    position: sticky;
	    top: 0;
	    z-index: 10;
	}

	.aberto {

		color: red;
	}

	.normal {

		color: black;
	}

</style>

			<div ng-controller="ZMProCtrl" ng-init="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">	 
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0 mt-1">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Produtos</li>
						<li class="breadcrumb-item active" aria-current="page">Balanços</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 998">
				  {{alertMsg}}
				</div>

				<div class="row">
					<div class="col-lg-12 pt-0 px-2">

						<div show-on-desktop>

							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body py-0 px-2 m-0">
									<form class="my-0 pt-0">
										<div class="form-row justify-content-between align-items-center">
			
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
											<div class="col-auto ml-3">
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

											<div class="ml-auto m-0 ">
												<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" style="color: white;">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
													<i class="fas fa fa-search" ></i> Pesquisar
												</md-button>
											</div>
										</div>
									</div>
								</form>
								<div class="card col-12 p-0 mt-2" style="border:none; background-color: rgba(0,0,0, .25);">
									<div class="row">
										<div class="col-6 pl-2"><span style="color:gainsboro;">Balanços</span></div>
										<div class="col-6 pl-2"><span style="color:gainsboro;">Itens do Balanço <b>{{documento}}</b></span></div>
									</div>
								</div>
								<div class="card col-12 p-0" style=" border:none; background-color:rgba(0,0,0, .8); ">
									<div class="row ">
										<div class="table-responsive col-6 px-0" style="overflow: auto; background-color: white;">
											<table class="table table-sm table-striped pb-0" style="background-color: #FFFFFFFF; color: black; cursor: pointer; ">
												<thead class="thead-dark">
													<tr style="font-size: 0.9em !important;">
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar(ce_id)">Cod</th>
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar(ce_data)">Data</th>
														<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar(ce_empresa)">Empresa</th>
														<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar(ce_aberto)">Status</th>
														<th scope="col" style="font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="balanco in dadosBalanco | orderBy:reverse:true" ng-class="balanco.ce_aberto == 'S' ? 'aberto' : 'normal'" ng-click="ConsultaBalanco(balanco)">
														<td style="text-align: left;" ng-bind="balanco.ce_id"></td>
														<td style="text-align: left;" ng-bind="balanco.ce_data | date: 'dd/MM/yyyy'"></td>
														<td style="text-align: center;" ng-bind="balanco.ce_empresa"></td>
														<td style="text-align: center;" ng-bind="balanco.ce_aberto"></td>
														<td style="text-align: center;">
															<div class="btn-group dropleft">
																<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
																	<i class="fas fa-ellipsis-v"></i> 
																</button>
																<div class="dropdown-menu">

				<?php if (substr($me_empresa, 2, 1) == 'S') {?>
																	<a class="dropdown-item" ng-click="tipoFechaBalanco(balanco)">Fechar Balanço</a>
				<?php } ?>
				<?php if (substr($me_empresa, 3, 1) == 'S') {?>
																	<a class="dropdown-item" >Reverter Balanco</a>
				<?php }?>

																</div>
															</div>
														</td>

													</tr >
												</tbody>
											</table>
										</div>

										<div class="modal fade bd-example-modal-lg" id="ModalTipoFechamento" tabindex="-1" role="dialog"  aria-hidden="true" aria-labelledby="TextoModal1">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 style="color: red !important; text-align: center;" class="modal-title" id="TextoModal1">ATENÇÃO!</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														
														<h4 style="color: black !important; text-align: center;" >Manter estoque não contado</h4>
														<p style="color: black !important; text-align: center;" >Escolhendo esta opção, o estoque dos produtos não contados será mantido.</p>
														</br>
														<h4 style="color: black !important; text-align: center;" >Zerar estoque não contado</h4>
														<p style="color: black !important; text-align: center;" >Escolhendo esta opção, o estoque dos produtos não contados será zerado.</p>

													</div>
													<div class="modal-footer align-content-between" >
														<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="fecharBalancoSemZerar(numBalanco)">MANTER ESTOQUE NÃO CONTADO</button>
														<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="fecharBalancoZerando(numBalanco)">ZERAR ESTOQUE NÃO CONTADO</button>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade bd-example-modal-lg" id="ModalTemCerteza" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="TextoModal2">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-body">
														<h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal2">Tem certeza de que deseja fechar este balanço?</h5>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
														<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="tipoFechaBalanco(balanco)">Sim, continuar!</button>
													</div>
												</div>
											</div>
										</div>

										<div class="table-responsive col-6 px-0" style="overflow: auto; background-color: white; border-left: 8px rgba(0,0,0, .8) solid;">
											<table class="table table-sm table-striped" style="font-size: 0.9em !important; background-color: white; color: black; width: 100%; border-left: 1px solid #E5E5E5FF;">
												<thead class="thead-dark" style="border-left: 1px solid black">
													<tr>
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cei_prod')">Cod</th>
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cei_desc')">Produto</th>
														<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cei_qntanterior')">Qtde Anterior</th>	
														<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cei_qntcontado')">Qtde Contada</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="item in itensBalanco | orderBy:'sortKey':reverse" >
														<td ng-bind="item.cei_prod" ></td>
														<td style="max-width: 280px;" ng-bind="item.cei_desc" class="d-inline-block text-truncate"></td>
														<td style="text-align: right;" ng-bind="item.cei_qntanterior | number" ></td>
														<td style="text-align: right;" ng-bind="item.cei_qntcontado | number" ></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="card-footer p-2">
									<div class="form-row align-items-center">
										<div class="col-4" style="text-align: left;">
											<div class="row justify-content-start">
												<span style="color: grey;">Registros: <b class="col-auto">{{}}</b></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				 	
					    <div layout="row" layout-sm="column" layout-align="space-around" ng-if = "aguarde">
					      	<md-progress-circular md-mode="indeterminate"></md-progress-circular>
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
  	<script src="js/angular-locale_pt-br.js"></script>


    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

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

			$scope.total = 0;
		    $scope.tab = 1;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.documento = '';
			$scope.aguarde = false;
			$scope.funcionario = '';
			$scope.numBalanco = ''
			$scope.empresa = '';
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
    		$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.itensBalanco = [];
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

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

		    function dataInicial(soma=0) {

	            var data = new Date();
	            data.setDate(data.getDate()-30);
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
				});
			};
			<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			$scope.modificaBusca = function (empresa,dataI,dataF) {
				$scope.empresa = empresa;
				$scope.dataI = dataI;
	    		$scope.dataF = dataF;	
	    		busca();
			}

			var busca = function(){ 

				listaBalancos($scope.empresa, $scope.dataI, $scope.dataF);

			}

		    var listaBalancos = function (empresa, dataInicial, dataFinal) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaBalanco.php?&listaBalanco=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataInicial+'&dataF='+dataFinal
				}).then(function onSuccess(response){
					$scope.dadosBalanco=response.data.result[0];
				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Erro ao Acessar Balanços da Empresa!"
					chamarAlerta();
				});
			};

		    $scope.ConsultaBalanco = function (balanco) {
		    	$scope.documento = balanco.ce_id;
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaBalanco.php?&consultaBalanco=S&ce_id='+balanco.ce_id
				}).then(function onSuccess(response){
					$scope.itensBalanco=response.data.result[0];
				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Erro ao Consultar Este Balanço!"
					chamarAlerta();
				});
			};

		    $scope.reverterBalanco = function (balanco) {

					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = ""
					chamarAlerta();

			}


		    $scope.fecharBalanco = function (balanco) {

 				$('#ModalTemCerteza').modal('show');

			}
			
		    $scope.tipoFechaBalanco = function (balanco) {
				var aberta = balanco.ce_aberto;
				$scope.numBalanco = balanco.ce_id;
		    	if (aberta == 'S') {
					$('#ModalTipoFechamento').modal('show');
		    	} else {
		    		alert("Balanço já fechado!");
		    	}
    		};

			$scope.fecharBalancoSemZerar = function(numBalanco) {
				if (numBalanco == '' || numBalanco == undefined) {
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Número de Balanço Inexistente.";
					chamarAlerta();
				} else {
					$http({
						method: 'GET',
						url: $scope.urlBase+'SalvaBalanco.php?&fecharBalancoSemZerar=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&ce_id='+numBalanco
					}).then(function onSuccess(response){
						//alert(response);
						$scope.retStatus = response.data.result[0];
						if ($scope.retStatus[0].status == 'true') {
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Balanço Fechado com sucesso!";
							chamarAlerta();
							busca();
						} else {
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Verifique Status do Balanço";
							chamarAlerta();
						}
						window.location.reload();
					}).catch(function onError(response){
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Erro ao Fechar Este Balanço!"
						chamarAlerta();
						window.location.reload();						
					});
					//window.location.reload();
				}	
			};

			$scope.fecharBalancoZerando = function(numBalanco) {
				if (numBalanco == '' || numBalanco == undefined) {
					alert("erro");
				} else {
					$http({
						method: 'GET',
						url: $scope.urlBase+'SalvaBalanco.php?&fecharBalancoZerando=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&ce_id='+numBalanco
					}).then(function onSuccess(response){

						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Balanço Fechado com sucesso!";
						chamarAlerta();
						busca();
					}).catch(function onError(response){
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Erro ao Fechar Este Balanço!"
						chamarAlerta();
						window.location.reload();	
					});
					//window.location.reload();	
				};
			};

			$scope.LimpaItens = function () {

				$scope.itensBalanco = '';
				$scope.documento = '';
				$scope.numBalanco = '';
		
			};

			$scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

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

	</script>

</body>

</html>