<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
include 'services/getIp.php';
include 'services/logNavegacao.php';

date_default_timezone_set('America/Bahia');

$ip = get_client_ip();

$data = date('Y-m-d');
$hora = date('H:i:s');

//logNavegacao($conexao, $data, $hora, $ip, base64_decode($us_id), 'Acessou Contas A Receber', base64_decode($empresa_acesso), base64_decode($empresa));

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

?>
<style>

	#tabela{display: none;}
	#tabela2{display: none;}

	.venc{
		/*text-decoration: line-through #de0000;*/
		/*background: transparent url('images/strike.png') 0 50% repeat-x;*/
		color:#de0000;
		
	}

	.vencH{
		/*text-decoration: line-through #de0000;*/
		/*background: transparent url('images/strike.png') 0 50% repeat-x;*/
		color:#0034cf;
		
	}

	.table-responsive { 
		overflow:scroll;
		background-color:#ffffff;
	}

	.alert-conta{
	position: relative;
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
	}


</style>
			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Contas a Receber</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>
				
				<div class="row" style="font-size: 0.9em !important">
				  	<div class="col-lg-12 pt-0 px-2">
						<div ng-if="lista">
						
							<div show-on-desktop>
							
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
    			                        <form class="my-0 pt-0">
                			                <div class="form-row align-items-center ">
	
												<div class="col-auto">
                                        			<label>Filtrar</label>
												</div>

												<div class="col-auto">
													<input type="text" value="" class="form-control form-control-sm text-left" id="buscaFornec" ng-model="buscaFornec" placeholder="Todos os Clientes">
												</div>
			<?php if (base64_decode($empresa_acesso) == 0) {?>
												<div class="col-auto">
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

												<!--div class="col-auto ml-2">
													<md-switch md-invert ng-model="status" ng-change="mudarStatus(status)">Em Aberto
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Baixar Conta</md-tooltip>
													</md-switch>
												</!--div>-->

												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="ContasReceber(dataI | date : 'yyyy-MM-dd', dataF | date : 'yyyy-MM-dd', empresa, buscaFornec)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
													<md-button class="btnSalvar pull-right" style="border: none;" style="color: green;" ng-disabled="!contasReceber[0]" ng-click="print()">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
														<i class="fas fa-print"></i> Imprimir
													</md-button>
												</div>
											</div>
										</form>
										
								    	<!--div class="col-auto">
											<select class="form-control form-control-sm" id="canc" ng-model="canc">
												<option value="">Todas as Contas</option>
												<option value="N">Em Aberto</option>
												<option value="S">Cancelados</option>
											</select>
										</div-->
										<div class="table-responsive p-0 mb-2" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_docto')">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parcela</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_nome')">Cliente</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_vencto')">Vencto</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Valor</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_tipdoc')">Tipo Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_vendedor')">Vendedor</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody style="line-height: 2em; margin:0px; padding:0px;">
													<tr dir-paginate="contasReceber in contasReceber | orderBy:'sortKey' | itemsPerPage:20" ng-class="contasReceber.ct_vencto < dataPagto ? 'venc' : contasReceber.ct_vencto == dataPagto ? 'vencH':''" ng-dblclick="clienteSelecionadoOK(contasReceber.ct_id, contasReceber.ct_cliente_forn, contasReceber.ct_nome)">
														<td align="left" ng-bind="contasReceber.em_fanta"></td>
														<td align="left" ng-bind="contasReceber.ct_docto"></td>
														<td align="center" ng-bind="contasReceber.ct_parc"></td>
														<td align="left" ng-bind="contasReceber.ct_nome | limitTo:25"></td>
														<td align="right" ng-bind="contasReceber.ct_vencto | date : 'dd/MM/yyyy'"></td>
														<td align="right" ng-bind="contasReceber.ct_valor | currency: 'R$ '"></td>
														<td align="center" ng-bind="contasReceber.ct_tipdoc"></td>
														<td align="left" ng-bind="contasReceber.ct_vendedor | limitTo:20" class="d-inline-block text-truncate"></td>
														<td style="text-align: center;" class="ml-auto m-0 p-0">
															<md-menu>
																<md-button ng-click="$mdOpenMenu()" class="md-icon-button md-mini pull-right m-0 p-0">
																	<i class="fas fa-ellipsis-v m-0 p-0"></i> 
																</md-button>
																<md-menu-content class="dropdown" >
																	<md-menu-item >
																		<md-button  ng-click="clienteSelecionadoOK(contasReceber.ct_id, contasReceber.ct_cliente_forn, contasReceber.ct_nome)">Receber</md-button>
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
									</div>
							
									<div class="card-footer p-2">
										<div class="form-row align-items-center">
											<div class="col-4" style="text-align: left;">
												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #de0000"></button>
													<span style="color: white;" class="col-auto">Atrasadas: <b class="col-auto">{{totalcontasReceber[0].vencidas | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #0034cf"></button>
													<span style="color: white;" class="col-auto">Vencendo hoje: <b class="col-auto">{{totalcontasReceber[0].vencendo | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #000"></button>
													<span style="color: white;" class="col-auto">A Receber: <b class="col-auto">{{totalcontasReceber[0].a_vencer | currency: 'R$ '}}</b></span>
												</div>
											</div>
											<div class="col-8" style="text-align: right;">
												<span style="color: grey;">Registros: <b>{{contasReceber.length}}</b></span>
											</div>
										</div>
									</div>
								</div>
							</div>
								
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>

							<md-button class="md-fab md-fab-bottom-right color-default-btn" data-toggle="modal" data-target="#baixarContaReceber" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Baixar Conta</md-tooltip>
								<i class="fas fa-sort-down"></i>
							</md-button>

<?php 
	include 'Modal/conta_receber/baixar_conta_receber.php';
	include 'Modal/conta_receber/selecionaCliente.php';
	include 'Modal/conta_receber/reciboContasBaixadas.php';
?>

						</div>
					</div>
				</div>

				<table id="tabela">
					<thead>
						<tr>
							<th>Empresa</th>
							<th>Docto</th>
							<th>Parcela</th>
							<th>Fornecedor</th>
							<th>Vencto</th>
							<th>Valor</th>
							<th>Pagto</th>
							<th>Valor Pago</th>
							<th>Tipo Docto</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="contas in contasPagas | orderBy:'-ct_pagto'">
							<td ng-bind="contas.em_fanta"></td>
							<td ng-bind="contas.ct_docto"></td>
							<td ng-bind="contas.ct_parc"></td>
							<td ng-bind="contas.ct_nome"></td>
							<td ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
							<td ng-bind="contas.ct_valor | currency: 'R$ '"></td>
							<td ng-bind="contas.ct_pagto | date : 'dd/MM/yyyy'"></td>
							<td ng-bind="contas.ct_valorpago | currency: 'R$ '"></td>
							<td ng-bind="contas.dc_sigla"></td>
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
							<td>Valor Pago no Período</td>
							<td>{{totalcontasPagas | currency: 'R$ '}}</td>
						</tr>
						<tr>
							<td>Quantidade de Registros</td>
							<td>{{contasPagas.length}}</td>
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
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/dirPagination.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log, $window) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.bc_cod_func='<?=$us_cod?>';
			$scope.contasReceber=[];
			$scope.dadosCliente=[];
			$scope.totalcontasReceber=[];
			$scope.caixas=[];
			$scope.empresa = '';
			$scope.cliente = '';
			$scope.caixaAberto = false;
			$scope.dataI = '1970-01-01';
			$scope.dataF = '2100-12-31';
			$scope.dataPagto = dataHoje();
			$scope.cliente_fornecedor = 'pe_cliente';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.empresafilial = ''; //undefined
			$scope.vencida = 'FALSE';
			$scope.quitado = 'N';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "";
			$scope.status = true;
			$scope.canc = 'N';
			$scope.arrayNull = true;

			$scope.ordenar = function(keyname){
		      $scope.sortKey = keyname;
		      $scope.reverse = !$scope.reverse;
		    };

		   $scope.sortKey = function(keyname){
		        $scope.sortBy = keyname;   
		        $scope.reverse = !$scope.reverse; 
			};

			//$scope.dataHoje = new Date();

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
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
			
			/*var dadosCliente = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			//dadosCliente();*/

			$scope.mudarStatus = function(status){

				if (status == true) {
					$scope.canc = 'N'
				}else{
					$scope.canc ='S';
				}
			}
			
			/*var restTotalContasReceber = function(dataI,dataF,empresafilial, cliente, canc){
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&totalContasReceber=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&cliente='+$scope.cliente+'&canc='+$scope.canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado+'&empresa='+$scope.empresa
				}).then(function onSuccess(response){
					$scope.totalcontasReceber = response.data.result[0];
				}).catch(function onError(response){

				});
			}*/

			var restContasReceber = function (){
				$scope.contasReceber = '';
				$scope.arrayNull = true;
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&listaContaReceberFast=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&vencida='+$scope.vencida+'&cliente='+$scope.cliente+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.contasReceber = response.data.result[0];
					if ($scope.contasReceber.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlertaNormal();
					}
					//restTotalContasReceber(dataI,dataF,empresafilial, cliente, canc);
					$scope.arrayNull = false;			
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlertaNormal();

				});

			}
			restContasReceber();

			var totalContaReceberFast = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?receber=S&totalContaReceberFast=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&cliente='+$scope.cliente+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.totalcontasReceber=response.data.result[0];
				}).catch(function onError(response){

				});
			};
			totalContaReceberFast();

			var caixas = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'caixas.php?caixa=S&contrCaixa=S&&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&bc_cod_func=' + $scope.bc_cod_func
				}).then(function onSuccess(response){
					$scope.caixas= response.data.result[0];
					if ($scope.caixas[0].bc_id != null){
						$scope.caixaAberto = false;
					} else {
						$scope.caixaAberto = true;
					}
				}).catch(function onError(response){
					$scope.caixa = response.data;
					$scope.caixaAberto = false;
				});
			};
			caixas();

			<?php
				include 'controller/seachCliente.js';
			?>

			$scope.ContasReceber = function (dataI, dataF, empresafilial, cliente){
				$scope.dataI = dataI;
				$scope.dataF = dataF;
				$scope.empresa = empresafilial;
				if (cliente == undefined) {
					$scope.cliente = '';
				} else {
					$scope.cliente = cliente;
				}
				restContasReceber();
				totalContaReceberFast();
			}

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

		}).directive('ngEnter', function () {
		   return function (scope, element, attrs) {
		     element.bind("keydown keypress", function (event) {
		       if(event.which === 13) {
		         scope.$apply(function (){
		           scope.$eval(attrs.ngEnter);
		         });
		         event.preventDefault();
		       }else if(event.which === 9){
				scope.$apply(function (){
		           scope.$eval(attrs.ngEnter);
		         });
		         event.preventDefault();
			   }
		     });
		   };

		 });

		angular.module("ZMPro").directive("moneyDir", MoneyDir);

		function MoneyDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();		
						}
					}

					$(element).mask('999999990,00', {reverse: true});

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length > 3) {//verifica a quantidade de digitos.
							mask = "999999990,00";
						}
					$(element).mask(mask, options);//aplica a mascara novamente
					}
				}
			}
		};
		
		<?php
			include 'controller/funcoesBasicas.js';
		?>

	
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