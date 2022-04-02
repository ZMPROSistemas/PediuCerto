<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

?>
<style>
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

	.table-responsive{
		overflow:scroll;
		background-color:#ffffff;
	}

</style>
			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Contas Recebidas</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>
				
				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">
						<div ng-if="lista">
						
							<div show-on-desktop>
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0 pt-0">
                			                <div class="form-row align-items-center" >
	
												<div class="col-auto">
                                        			<label>Filtrar</label>
												</div>
												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="buscaCliente" ng-model="buscaCliente" placeholder="Todos os Clientes">
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

										<!--div class="col-2 ml-2" ng-init="canc = 'N'">
											<select class="form-control form-control-sm" id="canc" ng-model="canc">
												<option value="N">Em Abertos</option>
												<option value="S">Cancelados</option>
											</select>
										</div-->
										
										<!--div class="col-auto">
											<div class="input-group-btn">
												<button type="button" class="btn btn-outline-dark btn-sm" ng-click="restContasReceber();" style="color: white;">
													<i class="fas fa fa-search" ></i>
												</button>
											</div>
								    	</div-->

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
													<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="ContasRecebidas(dataI | date : 'yyyy-MM-dd', dataF | date : 'yyyy-MM-dd', empresa, buscaCliente)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
												</div>
											</div>
										</form>

										<div class="table-responsive p-0 mb-2" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important; font-weight: normal;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_docto')">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parcela</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_nome')">Cliente</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_vencto')">Vencto</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Valor</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_pagto')">Pagto</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valorpago')">Valor Recebido</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_tipdoc')">Tipo Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_vendedor')">Colaborador</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="contas in contasRecebidos | orderBy:'-ct_pagto' | itemsPerPage:20">
														<td align="left" ng-bind="contas.ct_empresa"></td>
														<td align="right" ng-bind="contas.ct_docto"></td>
														<td align="center" ng-bind="contas.ct_parc"></td>
														<td align="left" ng-bind="contas.ct_nome | limitTo:20"></td>
														<td align="right" ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
														<td align="right" ng-bind="contas.ct_valor | currency: 'R$ '"></td>
														<td align="right" ng-bind="contas.ct_pagto | date : 'dd/MM/yyyy'"></td>
														<td align="right" ng-bind="contas.ct_valorpago | currency: 'R$ '"></td>
														<td align="center" ng-bind="contas.ct_tipdoc"></td>
														<td align="left" ng-bind="contas.ct_vendedor | limitTo:20"></td>
														<td style="text-align: center;">
															<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;"  data-toggle="tooltip" data-placement="top" title="Clique para mais informações" ng-click="verContaRecebida(contas)">
																<i class="fas fa-ellipsis-v"></i> 
															</button>
														</td>
<?php
	include 'modal/exibirContaRecebida.php';
?>													</tr>
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
													<span style="color: white;">Recebido em Dinheiro: <b class="col-auto">{{totalcontasRecebidas[0].dinheiro | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<span style="color: white;">Recebido no Cartão: <b class="col-auto">{{totalcontasRecebidas[0].cartao | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<span style="color: white;">Outros Recebimentos: <b class="col-auto">{{totalcontasRecebidas[0].outros | currency: 'R$ '}}</b></span>
												</div>
											</div>

											<div class="col-4" style="text-align: left;">
												<span style="color: white;">Total Recebido no Período: <b>{{totalcontasRecebidas[0].total | currency: 'R$ '}}</b></span>
											</div>

											<div class="col-4" style="text-align: right;">
												<span style="color: grey;">Registros: <b>{{contasRecebidos.length}}</b></span>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
						</div>
						
						<!--md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
		                      	<i class="fa fa-plus"></i>
						</md-button-->
						
					</div>
					<div ng-if="ficha">
					</div>
				</div>
			</div>

							<!--
							<div show-on-desktop>
						    	<div class="row bg-dark" >
									<div class="form-group col-md-6 col-10 pt-3 pb-0">
										<div class="input-group">
											<input type="text" class="form-control form-control-sm pb-0" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
											<div class="input-group-btn">
												<button type="button" class="btn btn-outline-dark" style="color: white;">
													<i class="fas fa fa-search"></i>
												</button>
											</div>
										</div>
							    	</div>
									<div class="form-group col-md-6 col-2 pt-2 pb-0 m-0">
										<div style="text-align: right;">
									    	<md-button class="btnSalvar pull-right p-0" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
												<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
						                      	<i class="fas fa-print" style=""></i> Imprimir
				    	                	</md-button>
			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
				                                <i class="fas fa fa-print"></i>
				                            </a>
										</div>
							    	</div>
							    </div>
				
								<div class="jumbotron p-3">
									<form>
										<div class="form-row">
											<div class="form-group col-md-3 col-6">
												<label for="em_cod">Documento</label>
												<input type="number" class="form-control" id="em_cod" disabled>
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="em_cnpj">Parcela</label>
												<input type="number" class="form-control" id="em_cnpj" placeholder="Somente números">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="em_insc">Emissão</label>
												<input type="number" class="form-control" id="em_insc">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="em_insc">Vencimento</label>
												<input type="number" class="form-control" id="em_insc">
											</div>
											<div class="form-group col-md-1 col-2">
												<label for="em_end">Código</label>
												<input type="text" class="form-control" id="em_end">
											</div>
											<div class="form-group col-md-11 col-10">
												<label for="num_end">Cliente</label>
												<div class="input-group">
													<input type="text" class="form-control" id="num_end">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default" ng-click="BuscarCNPJ(em_cnpj)">
															<i class="fas fa fa-search" ></i>
														</button>
													</div>
												</div>
											</div>
											<div class="form-group col-md-6 col-12">
												<label for="em_end">Vendedor</label>
												<input type="text" class="form-control" id="em_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="num_end">Valor</label>
												<input type="text" class="form-control" id="num_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="num_end">Tipo Pagto</label>
												<input type="text" class="form-control" id="num_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="em_end">Bloqueto</label>
												<input type="text" class="form-control" id="em_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="num_end">Local Cobrança</label>
												<input type="text" class="form-control" id="num_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="em_end">Centro de Custo</label>
												<input type="text" class="form-control" id="em_end">
											</div>
											<div class="form-group col-md-3 col-6">
												<label for="num_end">Banco</label>
												<input type="text" class="form-control" id="num_end">
											</div>
										</div>
										<div class="form-group">
											<label for="em_razao">Observações</label>
											<textarea class="form-control" id="em_razao" rows="3"></textarea>
										</div>
										<button type="submit" class="btn btn-outline-light" ng-click="SalvarCliente()"><i class="fas fa-save"></i> Salvar</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>Page Content  -->
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
	<script src="js/dirPagination.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.contasRecebidos=[];
			$scope.dadosCliente=[];
			$scope.totalcontasRecebidos=[];
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
			$scope.dataHoje = new Date();
			$scope.cliente_fornecedor = 'pe_cliente';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.empresa = ''; //undefined
			$scope.cliente = '';
			$scope.quitado = 'S';
			$scope.observacao = '';
			$scope.arrayNull = true;

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
			$scope.ordenar = function(keyname){
		      $scope.sortKey = keyname;
		      $scope.reverse = !$scope.reverse;
		    };

		    $scope.sortKey = function(keyname){
		        $scope.sortBy = keyname;   
		        $scope.reverse = !$scope.reverse; 
			};

			$scope.mudarEmpresa = function(empresa) {

				$scope.empresa = empresa;

			}
			
			/*var dadosCliente = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?receber_pagar=S&dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			//dadosCliente();

			var restTotalcontasRecebidos = function(dataI,dataF,empresafilial){
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&totalContasReceber=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+empresafilial+'&cliente='+cliente+'&canc='+canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.totalcontasRecebidos = response.data.result[0];
				}).catch(function onError(response){

				});
			}*/

			$scope.verContaRecebida = function(conta){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?buscarContaID=S&ct_id=' + conta.ct_id
				}).then(function onSuccess(response){
					$scope.contaDoCliente = response.data.result[0];
					$scope.observacao = $scope.contaDoCliente[0].ct_obs;
        			$('#verContaRecebida').modal().show;					
				}).catch(function onError(response){
					alert("erro");

				});
			}

			var restcontasRecebidos = function (){
				$scope.contasRecebidos = '';
				$scope.arrayNull = true;

				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&listaContaRecFast=S&token=<?=$token?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&cliente='+$scope.cliente+'&quitado=S'
				}).then(function onSuccess(response){
					$scope.contasRecebidos = response.data.result[0];
					if ($scope.contasRecebidos == '') {
						$scope.arrayNull = false;
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlertaNormal();
					}
					//restTotalcontasRecebidos(dataI,dataF,empresafilial);
					$scope.arrayNull = false;
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
	                $scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlertaNormal();

				});
			};
			restcontasRecebidos();

			var totalContasRecebidasFast = function (){ 
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?receber=S&totalContaRecFast=S&token=<?=$token?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&cliente='+$scope.cliente+'&quitado=S'
				}).then(function onSuccess(response){
					$scope.totalcontasRecebidas=response.data.result[0];
				}).catch(function onError(response){

				});
			};
			totalContasRecebidasFast();


			$scope.ContasRecebidas = function (dataI, dataF, empresafilial, cliente){
				$scope.dataI = dataI;
				$scope.dataF = dataF;
				$scope.empresa = empresafilial;
				if (cliente == undefined) {
					$scope.cliente = '';
				} else {
					$scope.cliente = cliente;
				}
				restcontasRecebidos();
				totalContasRecebidasFast();
			}

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

		});

		<?php
			include 'controller/funcoesBasicas.js';
		?>

		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
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

	</script>


</body>
</html>