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

	.daterangepicker.fancy-border:before {
		border-bottom: 5px solid rebeccapurple;
	}

	#daterange2.picker-open {
		background: black;
		color: white;
	}

</style>
			<div ng-controller="ZMProCtrl" >
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Contas Pagas</li>
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
                			                <div class="form-row align-items-center">
	
												<div class="col-auto">
                                        			<label>Filtrar</label>
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

												<div class="col-auto"> 
													<input type="text" value="" class="form-control form-control-sm" id="buscaFornec" ng-model="buscaFornec" placeholder="Fornecedores">
												</div>
												<!--<div class="col-2 ml-2">
													<select class="form-control form-control-sm" id="cliente" ng-model="cliente">
														<option value="">Escolha o Fornecedor</option>
														<option ng-repeat="dadosCliente in dadosCliente" value="{{dadosCliente.pe_cod}}">{{dadosCliente.pe_nome}} </option>
													</select>
												</div>

											div class="col-2 ml-2" ng-init="canc = 'N'">
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
											</div

												<div class="col-2 ml-2">
													<select class="form-control form-control-sm" id="periodo" ng-model="periodo">
														<option value="">Escolha o Período</option>
														<option value="mounth">Último Mês</option>
														<option value="2 mounths">Último Bimestre</option>
														<option value="6 mounths">Último Semestre</option>
														<option value="year">Último Ano</option>
													<md-content layout="column" layout-gt-sm="row"
																layout-padding ng-cloak>
														<div layout="column" flex-order="1" flex-order-gt-sm="0">
															<md-subheader>Data Inicial</md-subheader>
															<md-calendar ng-model="dataI"></md-calendar>
														</div>
														<div layout="column" flex-order="1" flex-order-gt-sm="1">
															<md-subheader>Data Final</md-subheader>
															<md-calendar ng-model="dataF"></md-calendar>
														</div>
													</md-content>
												</div>
													</select>
												</div>-->

												<div class="col-auto">
													<label for="dataI">Período </label>
												</div>
												<div class="col-auto">
													<input date-range-picker id="daterange2" name="daterange2" class="form-control form-control-sm date-picker" type="text"	min="'2001-01-01'" max="'2100-12-31'" ng-model="date" ng-blur="tooltipPesquisar()" required/>
													<md-tooltip md-direction="top" md-visible="tooltipData">Clique em Pesquisar</md-tooltip>

												<!--input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">
												</div>
												<div class="col-auto">
													<label for="dataF">até </label>
												</div>
												<div class="col-auto">
													<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}"-->
												</div>
												<div class="col-auto">
													<label for="itensPagina">Linhas</label>
												</div>
												<div class="col-auto" ng-init="itensPagina = 10">
													<select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
														<option ng-value="10" ng-selected="true">10</option>
														<option ng-value="20">20</option>
														<option ng-value="50">50</option>
													</select>
												</div>

												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-left" style="border: none;" ng-click="ContasPagas(date.startDate, date.endDate, empresa, buscaFornec, itensPagina)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipPesquisar">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
													<md-button class="btnSalvar pull-right" style="border: none;" style="color: green;" ng-disabled="!contasPagas[0]" ng-click="print()">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
														<i class="fas fa-print"></i> Imprimir
													</md-button>
												</div>
											</div>
										</form>
	<!--						    <div class="card col-12 p-0" style="border:none; background-color: #999999FF;">
									<div class="row">
										<div class="table-responsive px-0" style="background-color: white;">
											<table class="table table-sm table-striped pb-0" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
								<div class="table-responsive px-0" style="overflow: auto;">
									<table class="table table-striped pb-0" style="background-color: #FFFFFFFF; color: black;">
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
											</tr>
										</thead>
										<tbody dir-paginate="contasPagar in contasPagar | orderBy:'sortKey' | itemsPerPage:10" >
											<tr ng-class="contasPagar.ct_vencta == 'Vencido' ? 'venc' : contasPagar.ct_vencta == 'Hoje' ? 'vencH':''">
											
												<td><span ng-if="contasPagar.ct_canc == 'S'" class="badge badge-light" style="background-color:red;); color:#fff; margin-right:5px; text-align: left;">Cancelado</span>{{contasPagar.em_fanta | limitTo:20}}{{contasPagar.em_fanta.length >= 20 ? '...' : ''}}</td>
												<td ng-bind="contasPagar.ct_docto" align="left"></td>
												<td style="text-align: center;" ng-bind="contasPagar.ct_parc" align="center"></td>
												<td style="text-align: left;" ng-bind="contasPagar.ct_nome | limitTo:20"></td>
												<td style="text-align: left;" ng-bind="contasPagar.ct_vencto | date : 'dd/MM/yyyy'"></td>
												<td style="text-align: right;" ng-bind="contasPagar.ct_valor | currency: 'R$ '"></td>
												<td align="center" ng-bind="contasPagar.dc_sigla"></td>
												<td style="text-align: center;">
													<div class="btn-group dropleft">
														<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
															<i class="fas fa-ellipsis-v"></i> 
														</button>
														<div class="dropdown-menu">
	<?php if (substr($me_compraA_Pagar, 3,1) == 'S') {?>
															<a class="dropdown-item" ng-click="buscarCont(contasPagar)">Baixar</a>
	<?php } ?>
															<a class="dropdown-item" ng-click="excluir(contasPagar,1)">Excluir</a>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
	<!--								</div>
								</div>-->
										<div class="table-responsive p-0" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<th scope="col" style=" font-weight: normal; text-align: left; width:30px;" ng-click="ordenar('ct_docto')">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parc.</th>
														<th scope="col" style=" font-weight: normal; text-align: left; width:30px;" ng-click="ordenar('ct_vencto')">Vencto</th>
														<th scope="col" style=" font-weight: normal; text-align: left; width:30px;" ng-click="ordenar('ct_pagto')">Pagto</th>
														<!--th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</!--th-->
														<th scope="col" style=" font-weight: normal; text-align: left; width:400px;" ng-click="ordenar('ct_nome')">Fornecedor</th>
														<th scope="col" style=" font-weight: normal; text-align: right; width:100px;" ng-click="ordenar('ct_valor')">Valor Original</th>
														<th scope="col" style=" font-weight: normal; text-align: right; width:100px;" ng-click="ordenar('ct_valorpago')">Valor Pago</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;" ng-click="ordenar('ct_rateia')" ng-if="!unicaEmp">Rateada</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;" ng-click="ordenar('em_cod_local')">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;" ng-click="ordenar('dc_sigla')">Tp.Docto.</th>
														<th scope="col" style=" font-weight: normal; text-align: left" ng-click="ordenar('ht_descricao')">Histórico</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="contas in contasPagas | orderBy:'-ct_pagto' | itemsPerPage:pageSize">
														<!--td ng-bind="contas.em_fanta | limitTo:20" style="text-align: left;"></!--td-->
														<td ng-bind="contas.ct_docto" align="left" style="width:30px"></td>
														<td ng-bind="contas.ct_parc" align="center"></td>
														<td ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'" style="text-align: left;"></td>
														<td ng-bind="contas.ct_pagto | date : 'dd/MM/yyyy'" style="text-align: left;"></td>
														<td ng-bind="contas.ct_nome" style="text-align: left;"></td>
														<td ng-bind="contas.ct_valor | currency: 'R$ '" style="text-align: right;"></td>
														<td ng-bind="contas.ct_valorpago | currency: 'R$ '"  style="text-align: right;"></td>
														<td ng-bind="contas.ct_rateia != 'S' ? 'N' : 'S'" align="center" ng-if="!unicaEmp"></td>
														<td ng-bind="contas.em_cod_local" align="center"></td>
														<td ng-bind="contas.dc_sigla" align="center"></td>
														<td ng-bind="contas.ht_descricao" align="left"></td>
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

									<div class="card-footer p-2 mt-0">
										<div class="form-row align-items-center">
											<div class="col-6">
												<span style="text-align: left; ">Total Pago no Período: <b class="col-auto">{{totalcontasPagas | currency: 'R$ '}}</b></span>
											</div>
											<div class="col-6" style="text-align: right;">
												<span style="color: grey;">Registros: <b>{{contasPagas.length}}</b></span>
											</div>
										</div>
									</div>

									<!--<div class="card-footer p-2">
										<div class="form-row align-items-center">
											<div class="col-3">
												<span style="text-align: left; ">Total Recebido: <b class="col-auto">{{totalcontasRecebidos[0].ct_valorpago | currency: 'R$ '}}</b></span>
											</div>
										</div>
									</div>-->

								</div>
							</div>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							
							<!--md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
									<i class="fa fa-plus"></i>
							</md-button-->

						</div>
					</div>
				</div>

				<table id="tabela">
					<thead>
						<tr>
							<th>Docto</th>
							<th>Parcela</th>
							<th>Vencto</th>
							<th>Pagto</th>
							<th>Fornecedor</th>
							<th>$ Original</th>
							<th>& Pago</th>
							<th ng-if="!unicaEmp">Rateada</th>
							<th>Forma Pagto</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="contas in contasPagas | orderBy:'-ct_pagto'">
							<td ng-bind="contas.ct_docto"></td>
							<td ng-bind="contas.ct_parc"></td>
							<td ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
							<td ng-bind="contas.ct_pagto | date : 'dd/MM/yyyy'"></td>
							<td ng-bind="contas.ct_nome | limitTo:30"></td>
							<td ng-bind="contas.ct_valor | currency: 'R$ '"></td>
							<td ng-bind="contas.ct_valorpago | currency: 'R$ '"></td>
							<td ng-bind="contas.ct_rateia != 'S' ? 'N' : 'S'" ng-if="!unicaEmp"></td>
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
	<!--		                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
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
			</div>
		</div>
	</div>
		        Page Content  -->

    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/dirPagination.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/md-data-table.js"></script>
	<script src="js/moment-with-locales.min.js"></script>
	<script src="js/moment-pt-br.js"></script>
    <script src="js/daterangepicker.min.js"></script>
    <script src="js/angular-daterangepicker.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">
	
		angular.module("ZMPro",['ngAnimate','ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination','daterangepicker']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.contasPagas = [];
			$scope.dadosCliente=[];
			$scope.totalcontasPagas = 0;
			$scope.abrirCalendario = false;
			$scope.pageSize = 10;
			$scope.dataI = dataInicial();
			$scope.dataF = dataHoje();
			$scope.dataHoje = new Date();
			$scope.cliente_fornecedor = 'pe_fornecedor';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.empresa = ''; //undefined
			$scope.fornecedor = '';
			$scope.quitado = 'S';
			$scope.observacao = '';
			$scope.arrayNull = true;
			$scope.unicaEmp = true;
			$scope.startDate = dataInicial();
    		$scope.endDate = dataHoje();

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

			$scope.date = {
				startDate: moment().subtract(1, "months"),
				endDate: moment()
			};
		
			$scope.setStartDate = function () {
				$scope.date.startDate = moment().subtract(4, "days").toDate();
			};

			$scope.setRange = function () {
				$scope.date = {
					startDate: moment().subtract(5, "days"),
					endDate: moment()
				};
			};

			//Watch for date changes
			$scope.$watch('date', function(newDate) {
				console.log('New date set: ', newDate);
			}, false);

			var dadosEmpresa = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaCad.php?dadosEmpresa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosEmpresa=response.data.result[0];
					if ($scope.dadosEmpresa.length > 1) {
						$scope.unicaEmp = false;
					} else {
						$scope.unicaEmp = true;
					}
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

			var restcontasPagas = function (){
				$scope.contasPagas = '';
				$scope.arrayNull = true;
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagas.php?listaContasPagas=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&buscaNome='+$scope.fornecedor+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.contasPagas = response.data;
					$scope.arrayNull = false;
					if ($scope.contasPagas == '') {
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlertaNormal();
					}
					$scope.totalcontasPagas = $scope.contasPagas.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valorpago);}, 0);
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlertaNormal();
				});
			}

			restcontasPagas();

			$scope.ContasPagas = function (dataI, dataF, empresafilial, fornecedor, itensPagina){

				if (empresafilial == undefined || empresafilial == null) {empresafilial = '';}
				if (fornecedor == undefined || fornecedor == null) {fornecedor = '';}
				if (dataI == undefined || dataI == null || dataI == '') {dataI = dataInicial();}
				if (dataF == undefined || dataF == null || dataF == '') {dataF = dataHoje();}
				$scope.empresa = empresafilial;
				$scope.fornecedor = fornecedor;
				$scope.pageSize = itensPagina;
				$scope.dataI = dataI.format("YYYY-MM-DD");
				$scope.dataF = dataF.format("YYYY-MM-DD");

				restcontasPagas();
			}

			$scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

			$scope.print = function(){

				$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();
				gerarpdf($scope.dataI, $scope.dataF);

			}

		}).config(function($mdDateLocaleProvider) {
				$mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out', 'Nov', 'Dez'];
				$mdDateLocaleProvider.Months = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
				$mdDateLocaleProvider.days = ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta','Sexta', 'Sabado'];
				$mdDateLocaleProvider.shortDays = ['D', 'S', 'T', 'Q', 'Q','S','S'];
			
		});

		angular.bootstrap(document, ['ZMPro']);

		function gerarpdf(dataI, dataF) {
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
			var fornecedorSelect = document.getElementById('buscaFornec').value.innerText;
			var DataInicio = dataI;
    		var DataFim = dataF;
    		var arrData = DataInicio.split('-');
    		var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);
    		var arrDataF = DataFim.split('-');
    		var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);
    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 10, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Contas Pagas", 85, 27);
		        doc.setFontSize(11);
		        doc.setTextColor(40);
		        doc.setFontStyle('normal');
		        doc.text("<?=$nomeEmp?>", 85, 42);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text("Total de Vendas: " + (linhas.length - 1), 460,);
		        doc.setFontSize(8);
				if (empresa != '' || fornecedorSelect != undefined) {
					doc.text("Selecionado por " , 85, 52);
				}
				if (empresa != '') {
		        	doc.text("Empresa: " + empresa , 85, 62);					
				} 
				if (fornecedorSelect != undefined) {
					doc.text("Fornecedor: " + fornecedorSelect , 85, 72);
				} else {
					doc.text("Fornecedores: Todos" , 85, 72);					
				}
        		doc.text("Período Selecionado: " + InicioPesquisa + " até " + FimPesquisa , 85, 82);
    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 95, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'left'},
		        	1: {halign: 'center'},
		        	2: {halign: 'left'},
		        	3: {halign: 'left'},
		        	4: {halign: 'left'},
		        	5: {halign: 'right'},
		        	6: {halign: 'right'},
		        	7: {halign: 'center'},
		        	8: {halign: 'center'}},
		        rowStyles: {1: {fontSize: (number = 10)}},
		        tableLineColor: [189, 195, 199],
		        tableLineWidth: 0.75,
		        headerStyles: {fillColor: [100, 100, 100], fontSize: 9},
		        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
		        alternateRowStyles: {fillColor: [250, 250, 250]},

		        drawRow: function (row, data) {
		            // Colspan
		            doc.setFontStyle('bold');
		            doc.setFontSize(7);
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
				margin: {top: 80, right: 10, bottom: 20, left: 400},
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
			moment.locale('pt-br');
	    });

	</script>

</body>
</html>