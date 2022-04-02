<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
include 'services/ConsultaCad.php';

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

if($empresa_acesso == 0){
	$empresaLista = dadosEmpresaAutorizado($conexao, base64_decode($us_id));
}else{
	$empresaLista = dadosEmpresa($conexao, base64_decode($us_id));
}

?>

<style>
	
	#tabela{display: none;}
	#tabela2{display: none;}

	.text-capitalize {
	  text-transform: capitalize; }

	.venc{
		color:#de0000;
	}

	.vencH{
		color:#0034cf;
	}

	.dropdown-menu li ul li{
		border:1px solid #c0c0c0; 
		display:block; 
		width:150px;
		list-style-type: none;
	}
	.tracejado {
		border:1px dashed gray;
	}
</style>
			<div ng-controller="ZMProCtrl" ng-init="">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
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
													<input type="text" value="" class="form-control form-control-sm" id="buscaFornec" ng-model="buscaFornec" placeholder="Todos os Fornecedores">
												</div>

												<div class="col-auto"> 
													<input type="text" value="" class="form-control form-control-sm" id="buscaDocto" ng-model="buscaDocto" placeholder="Todos os Documentos">
												</div>
												<div class="col-auto ml-3">
													<label for="itensPagina">Linhas</label>
												</div>
												<div class="col-auto" ng-init="itensPagina = 10">
													<select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
														<option ng-value="10" ng-selected="true">10</option>
														<option ng-value="20">20</option>
														<option ng-value="50">50</option>
													</select>
												</div>

												<!--<div class="col-auto">
													<select class="form-control form-control-sm" id="canc" ng-model="canc">
														<option value="">Todas as Contas</option>
														<option value="N">Em Aberto</option>
														<option value="S">Cancelados</option>
													</select>
												</div>

												<div class="col-auto">
													<select class="form-control form-control-sm" id="periodo" ng-model="periodoBusca">
														<option value="">Período</option>
														<option value="1">Hoje</option>
														<option value="7">1 Semana</option>
														<option value="30">1 Mês</option>
														<option value="90">3 Meses</option>
														<option value="120">6 Meses</option>
													</select>
												</div>
												<div class="col-auto">
													<div class="input-group-btn">
														<button type="button" class="btn btn-outline-dark btn-sm"  style="color: white;">
															<i class="fas fa fa-search" ></i>
														</button>
													</div>
												</div>-->
												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="contasPagarLista(empresa, buscaFornec, buscaDocto, itensPagina)" >
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
													<md-button class="btnImprimir pull-right" style="border: none;" ng-disabled="!contasPagar[0]" ng-click="print()">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
														<i class="fas fa-print"></i> Imprimir
													</md-button>
												</div>
											</div>
										</form>

										<div class="table-responsive p-0" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<!--th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</!--th-->
														<th scope="col" style=" font-weight: normal; text-align: left; width:30px;">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center; ">Parc.</th>
														<th scope="col" style=" font-weight: normal; text-align: left; width:30px;">Vencto</th>
														<th scope="col" style=" font-weight: normal; text-align: left; width:400px;">Fornecedor</th>
														<th scope="col" style=" font-weight: normal; text-align: right; width:100px;">Valor</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;" ng-if="!unicaEmp">Rateada</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: center; width:15px;">Tp.Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left">Histórico</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody style="line-height: 2em; margin:0px; padding:0px;">
                                                    <tr dir-paginate="contas in contasPagar | orderBy:'sortKey' | itemsPerPage:pageSize" ng-class="contas.ct_vencto < dataI ? 'venc' : contas.ct_vencto == dataI ? 'vencH':''">
                                                        <!--td ng-bind="contas.em_fanta | limitTo:27" align="left"></!--td-->
                                                        <td style="text-align: left; width:30px" ng-bind="contas.ct_docto"></td>
                                                        <td style="text-align: center;" ng-bind="contas.ct_parc"></td>
                                                        <td style="text-align: left;" ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
                                                        <td style="text-align: left;" ng-bind="contas.ct_nome"></td>
                                                        <td style="text-align: right;" ng-bind="contas.ct_valor | currency: 'R$ '"></td>
                                                        <td style="text-align: center;" ng-bind="contas.ct_rateia != 'S' ? 'N' : 'S'" ng-if="!unicaEmp"></td>
														<td style="text-align: center;" ng-bind="contas.em_cod_local"></td>
														<td style="text-align: center;" ng-bind="contas.dc_sigla"></td>
														<td style="text-align: left;" ng-bind="contas.ht_descricao"></td>
														<td style="text-align: center;" class="ml-auto m-0 p-0">
															<md-menu>
																<md-button ng-click="$mdOpenMenu()" class="md-icon-button md-mini pull-right m-0 p-0">
																	<i class="fas fa-ellipsis-v m-0 p-0"></i> 
																</md-button>
																<md-menu-content class="dropdown" >
																	<md-menu-item >
																	<?php if (substr($me_compraA_Pagar, 3,1) == 'S') {?>
																		<md-button ng-click="buscarCont(contas,'B')">Baixar</md-button>
																	<?php } ?>
																	</md-menu-item>
																	<md-menu-item >
																	<?php if (substr($me_compraA_Pagar, 3,1) == 'S') {?>
																		<md-button ng-click="editConta(contas,'E')">Editar</md-button>
																	<?php } ?>
																	</md-menu-item>
																	<md-menu-item >
																		<md-button ng-click="buscarCont(contas,1)">Excluir</md-button>
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
										
										<div class="card-footer p-2 pt-0">
											<div class="form-row align-items-center">
												<div class="col-12" style="text-align: left;">
													<div class="row justify-content-start">
														<button type="button" class="btn btn-sm" style="background-color: #de0000"></button>
														<span class="col-auto">Vencidas: <b class="col-auto">{{valorVencido | currency: 'R$ '}}</b></span>
													</div>

													<div class="row justify-content-start">
														<button type="button" class="btn btn-sm" style="background-color: #0034cf"></button>
														<span class="col-auto">Vencendo hoje: <b class="col-auto">{{valorHoje | currency: 'R$ '}}</b></span>
													</div>

													<div class="row justify-content-start">
														<button type="button" class="btn btn-sm" style="background-color: #000"></button>
														<span class="col-auto">A Vencer: <b class="col-auto">{{valorAVencer | currency: 'R$ '}}</b></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>

								<div class="modal fade" id="baixarConta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document" style="color: black;">	
										<div class="modal-content">
											<div class="modal-header mb-0">
												<h3 style="color: black;" class="modal-title">Baixar Conta</h3>
											</div>
											<div class="modal-body">		
												<div class="container-fluid">
													<form name="form" id="formBaixaConta">
														<div class="form-row">
															<div class="form-group col-3">
																<label>Docto</label>
																<h4 style="color: black !important;"> {{contas[0].ct_docto}} </h4>
															</div>
															<div class="form-group col-9">
																<label>Fornecedor</label>
																<input type="text" class="form-control form-control-sm" value="{{contas[0].ct_nome}}" disabled>
															</div>
															<div class="form-group col-5">
																<label>Parcela</label>
																<input type="text" class="form-control form-control-sm" value="{{contas[0].ct_parc}}" disabled>
															</div>
															<div class="form-group col-7">
																<label>Vencimento</label>
																<input type="date" class="form-control form-control-sm" value="{{contas[0].ct_vencto}}" disabled>
															</div>
														</div>
														<hr>
														<div class="form-row">
															<div class="form-group col-6">
																<label>Data Do Pagamento</label>
																<input type="date" class="form-control form-control-sm" ng-model="dataBaixa" value="{{dataBaixa}}">
															</div>
															<div class="form-group col-6" ng-init="valorBaixa = contas[0].ct_valor">
																<label>Valor</label>
																<input type="text" class="form-control form-control-sm text-right" ng-model="cont.valorBaixa" ng-value="contas[0].ct_valor" disabled>
															</div>
														</div>
														<div class="form-row">													
															<div class="form-group col-12">
																<label>Forma De Pagamento</label>
																<select class="form-control form-control-sm" name="tipoDocto" id="tipoDocto" ng-model="tipoDocto">
																	<option ng-repeat="tipoDoctos in tipoDoctos | filter:{dc_empr:<?=base64_decode($empresa)?>}" ng-value="tipoDoctos.dc_codigo" ng-if="(tipoDoctos.dc_sigla == 'DN' || tipoDoctos.dc_sigla == 'CA' || tipoDoctos.dc_sigla == 'CH')">{{tipoDoctos.dc_descricao}} </option>
																</select>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-6">
																<md-switch md-invert ng-model="statusCheck" class="fa-pull-left" ng-change="verCaixa(statusCheck)">
																	<span>Lançar baixa no caixa</span>
																</md-switch>
															</div>
															<div class="form-group col-6">
																<label>Caixas</label> 
																<select class="form-control form-control-sm" name="caixa" id="caixa" ng-model="caixa" ng-disabled="statusCheck == false">
																	<option ng-repeat="caixa in caixas" value="{{caixa.bc_codigo}}" ng-if="caixa.bc_situacao == 'Aberto'">{{caixa.bc_descricao}} </option>
																</select>
															</div>
														</div>
													</form>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" onclick="window.location.reload()" data-dismiss="modal">Cancelar</button>
												<button type="button" class="btn btn-primary" ng-if="tipoDocto" ng-click="baixarContaPaga(caixa,statusCheck,dataBaixa,cont.valorBaixa,tipoDocto)">Baixar</button>
											</div>
										</div>
									</div>
								</div>

								<div class="modal fade" id="excluirConta" tabindex="-1" role="dialog" aria-labelledby="TextoModal" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document"> 
										<div class="modal-content">
											<div class="modal-header mb-0">
												<h3 style="color: black;" class="modal-title">Excluir Conta</h3>
											</div>
											<div class="modal-body">
												<h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Tem certeza de que deseja excluir a conta {{contas[0].ct_docto}}?</h5>
											</div>
											<div class="modal-footer my-1 py-1">
												<button type="button" class="btn btn-secondary"data-dismiss="modal" >Não</button>
												<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="excluir(contas[0])">Sim, tenho certeza</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						
<?php if (substr($me_empresa, 1, 1) == 'S') {?>

							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="abrirModalPagar()" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Adicionar Conta</md-tooltip>
								<i class="fa fa-plus"></i>
							</md-button>
<?php }?>	

						<!--md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
		                      	<i class="fa fa-plus"></i>
    	                </md-button-->

<?php

//include 'Modal/ContasPagar.php';
include 'Modal/editarContasPagar.php';

?>
						
						</div>
						<div ng-if="ficha">
<?php

include 'pages/ContasPagar.php';

?>
						</div>
					</div>
				</div>

				<table id="tabela">
					<thead>
						<tr>
							<th>Docto</th>
							<th>Parcela</th>
							<th>Vencto</th>
							<th>Fornecedor</th>
							<th>Valor</th>
							<th ng-if="!unicaEmp">Rateada</th>
							<th>Tipo Docto</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="contas in contasPagar  | orderBy:'sortKey'">
							<td ng-bind="contas.ct_docto"></td>
							<td ng-bind="contas.ct_parc"></td>
							<td ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
							<td ng-bind="contas.ct_nome"></td>
							<td ng-bind="contas.ct_valor | currency: 'R$ '"></td>
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
							<td>Valor Vencido</td>
							<td>{{valorVencido | currency: 'R$ '}}</td>
						</tr>
						<tr>
							<td>Vencendo Hoje</td>
							<td>{{valorHoje | currency: 'R$ '}}</td>
						</tr>
						<tr>
							<td>Valor A Vencer</td>
							<td>{{valorAVencer | currency: 'R$ '}}</td>
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

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial', 'md.data.table', 'angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.statusCheck = false;
			$scope.urlBase = 'services/';
			$scope.contasPagar=[];
			$scope.dadosCliente=[];
			$scope.totalContasPagar=[];
			$scope.unicaEmp = true;
			$scope.contas=[];
			$scope.valorConta = 0;
			$scope.pageSize = 10;
			$scope.caixas=[];
			$scope.dataI = dataHoje();
			$scope.cliente_fornecedor = 'pe_fornecedor';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.notaParcelas = [];
			$scope.empresa = ''; 
			$scope.buscaNome = '';
			$scope.buscaDocto = '';
			$scope.quitado = 'N';
			$scope.arrayNull = true;
			$scope.dinheiro = false;
			$scope.selecionarCaixa = false;
			$scope.numParcelas = 1;
			$scope.qtdParcelas = 0;
			$scope.itens_somados = '';
			$scope.documento = '';
//			$scope.proximoDocto = '';
			$scope.bc_cod_func='<?=$us_cod?>';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.dataBaixa = dataHoje();
			$scope.dataVcto = '';
			$scope.ct_emissao = dataHoje();
			$scope.itensNota = [];
			$scope.dadosNota = [];
			$scope.tipoDoctos = [];
			$scope.arrayContas = [];
			$scope.valorVencido = 0;
			$scope.valorHoje = 0;
			$scope.valorAVencer = 0;

			$scope.dadosNota=[{
					cp_id: '',
					cp_nota: '',
					cp_emis: '',
					cp_forn: '',
					cp_fnraz: '',
					cp_valor: '',
					cp_aberto: '',
					cp_tipdoc: '',
					dc_descricao: '',
					cp_empresa: '',
					cp_matriz: '',
					emp_entrada: '',
			}];

			$scope.notaParcelas = [{
					ct_empresa:'',
					ct_matriz:'',
					ct_docto:'',
					ct_cliente_forn:'',
					ct_emissao:'',
					ct_nome:'',
					ct_tipdoc:'',
					ct_historico:'',
					ct_desc_hist:'',
			}];

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

			function dataFinal(soma=0) {

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

		    $scope.abrirModalPagar = function () {
				$scope.selecionarCaixa = false;
				$scope.dinheiro = false;
				$scope.lista = !$scope.lista;
				$scope.ficha = !$scope.ficha;
    			dadosFormaPagto();
				dadosHistorico();
				buscarRateios();
				
			    //$('#ModalContaPagar').modal('show');
    		};

			$scope.goPagina = function() {
			    //$('#ModalContaPagar').modal('toggle');
			    $window.location.href = "https://zmsys.com.br/CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>";
			};

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

			var caixas = function (empresa){
				$http({
					method:'GET',
					url: $scope.urlBase+'caixas.php?caixa=S&contrCaixa=S&&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&bc_cod_func='+$scope.bc_cod_func
				}).then(function onSuccess(response){
					$scope.caixas= response.data.result[0];
				}).catch(function onError(response){
					$scope.caixa = response.data;
				});
			};
			caixas();

		    $scope.ConsultaCaixa = function (tipo) {
				//alert(tipo);
		    	if (tipo == 1 || tipo == 2 || tipo == 4) {
					$scope.qtdParcelas = 1;
					$scope.dinheiro = true;
					$http({
						method: 'GET',
						url: $scope.urlBase+'ConsultaNota.php?relatorio=S&CaixasAbertos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
						}).then(function onSuccess(response){
							$scope.CaixasAbertos=response.data.result[0];
							if ($scope.CaixasAbertos.length == 0) {
								$scope.tipoAlerta = "alert-warning";
								$scope.alertMsg = "Não há Caixa Aberto";
								chamarAlerta();
							} else {
								//alert($scope.CaixasAbertos.length);
							}
						}).catch(function onError(response){
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Erro ao pesquisar Caixas";
							chamarAlerta();
						});
				} else {
					$scope.dinheiro = false;
				}
			};

			var tipoDoctos = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'tipoDoctos.php?documento=S&lista=S&us_id=<?=$us_id?>&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>'

				}).then(function onSuccess(response){
					$scope.tipoDoctos=response.data.result[0];
				}).catch(function onError(response){
					alert("erro");

				});
			}

			tipoDoctos();

		    $scope.numParcelasNota = function(ct_vencto, valor, numParcelas, tipoDocto) {
				//alert(tipoDocto);
				$scope.notaParcelas = '';
				var valorTrans = valor.replace(".", "");
				$scope.valorConta = valorTrans.replace(",", ".");
		    	if (numParcelas > 12) {
		    	} else if (numParcelas < 1) {
		    	} else if (numParcelas > 1 && tipoDocto == 1) {
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Forma de Pagamento escolhida não permite número maior de parcelas.";
					chamarAlerta();
					document.getElementById("qtdParcelas").select();
		    	} else {
	  				$http({
					method: 'GET',
					url: $scope.urlBase+'NumParcela.php?vencimento='+ct_vencto+'&valorTotal='+valor+'&numParcelas='+numParcelas+'&tipoDocto='+tipoDocto
					}).then(function onSuccess(response){

						$scope.notaParcelas=response.data.result[0];

					}).catch(function onError(response){

					});
				}
		    };

		    var dadosFormaPagto = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?dadosFormaPagto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosFormaPagto=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar formas de pagamento. Caso este erro persista, contate o suporte.");
				});
			};

		    var dadosHistorico = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?dadosHistorico=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosHistorico=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar historico de pagamento. Caso este erro persista, contate o suporte.");
				});
			};

			$scope.ordenar = function(keyname){
		      $scope.sortKey = keyname;
		      $scope.reverse = !$scope.reverse;
		    };

		   $scope.sortKey = function(keyname){
		        $scope.sortBy = keyname;   
		        $scope.reverse = !$scope.reverse; 
			};
			
			var dadosCliente = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcContaPagar.php?dadosFornecedor=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='
					//url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosFornecedores=response.data;
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosCliente();

			var restTotalContasPagar = function(){
				
				var arrayVencidos = $scope.contasPagar.filter(item => item.ct_vencto < $scope.dataI);
				$scope.valorVencido = arrayVencidos.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				var arrayHoje = $scope.contasPagar.filter(item => item.ct_vencto == $scope.dataI);
				$scope.valorHoje = arrayHoje.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				var arrayAVencer = $scope.contasPagar.filter(item => item.ct_vencto > $scope.dataI);
				$scope.valorAVencer = arrayAVencer.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);

			}

			var restcontasPagar = function (){
				$scope.arrayNull = true;
				$scope.contasPagar = [];
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?listaContasPagar=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&buscaNome='+$scope.buscaNome+'&buscaDocto='+$scope.buscaDocto
				}).then(function onSuccess(response){
					$scope.contasPagar = response.data;
					if ($scope.contasPagar.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlerta();
					}
					$scope.arrayNull = false;
					restTotalContasPagar();
				}).catch(function onError(response){
					$scope.arrayNull = false;			
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlerta();
				});
			}

			restcontasPagar();

			$scope.contasPagarLista = function (empresafilial, fornecedor, documento, itensPagina){

				if (empresafilial == undefined || empresafilial == null) {empresafilial = '';}
				if (fornecedor == undefined || fornecedor == null) {fornecedor = '';}
				if (documento == undefined || documento == null) {documento = '';}

				$scope.empresa = empresafilial;
				$scope.buscaNome = fornecedor;
				$scope.buscaDocto = documento;
				$scope.pageSize = itensPagina;
				restcontasPagar();
			}

			var buscarRateios = function(){
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcPercRateio.php?listaPRC=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
                    $scope.listaPRC=response.data.result[0];
					setarFoco();
				}).catch(function onError(response){

				});
			}

			$scope.buscarProximoDocto = function(){
				$scope.proximoDocto = '';
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?&proximoDocto=S&empresa_matriz=<?=$empresa?>'
				}).then(function onSuccess(response){
					$scope.proximoDocto = response.data;
					setarFoco();
				}).catch(function onError(response){

				});
			}

			$scope.editConta = function (conta,e){
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?buscarContaPagarID=S&ct_id='+conta.ct_id
				}).then(function onSuccess(response){
					$scope.contas=response.data;
					$scope.dataVcto = $scope.contas[0].ct_vencto;
					if (e == 'B') {
						$('#formBaixaConta').each (function(){this.reset();});
						$('#baixarConta').modal('show');
					}
					else if(e == 'E'){
						if ($scope.contas[0].ct_rateia == 'S') {
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Conta Rateada. Não é possível edição.";
							chamarAlerta();
						} else {
							$('#editarContaAPagar').modal();
						}
					}
					
				}).catch(function onError(){

				})
			}

			$scope.buscarCont = function(conta,e){
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?buscarContaPagarID=S&ct_id='+conta.ct_id
				}).then(function onSuccess(response){
					$scope.contas=response.data;
					if (e == 'B') {
						$('#baixarConta').modal();
					} else if(e == 'E') {
						if ($scope.contas[0].ct_rateia == 'S') {
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Conta Rateada. Não é possível edição.";
							chamarAlerta();
						} else {
							$('#editarContaAPagar').modal();
						}
					} else if(e == 1) {
						$('#excluirConta').modal();
					}
					
				}).catch(function onError(){

				})
			}
			
			$scope.baixarContaPaga = function(caixa,statusCheck,dataBaixa,valorBaixa,tipoDocto){
			
				if (tipoDocto == null) {
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Selecione Uma Forma De Pagamento";
					chamarAlerta();
				}
				else if(tipoDocto == null){
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Selecione Uma Forma De Pagamento";
					chamarAlerta();
				}else{
					if (statusCheck == true) {
						if (caixa == null) {
							$scope.tipoAlerta = "alert-warning";
							$scope.alertMsg = "Selecione Um Caixa";
							chamarAlerta();
						}else{
							enviarConta(caixa,statusCheck,dataBaixa,valorBaixa,tipoDocto)
						}
					}else{
						enviarConta(caixa,statusCheck,dataBaixa,valorBaixa,tipoDocto)
					}
				}

				function enviarConta(caixa,statusCheck,dataBaixa,valorBaixa,tipoDocto){
					var conta = $scope.contas;
					var dataBaixas = dataBaixa;
					var valor = valorBaixa;
					var caixa = caixa;
					var tipoDoctos = tipoDocto;

					if(valor = null){
						valor = 0;
					}
					if(caixa == null){
						caixa = 0;
					}

					$http({
					method: 'POST',
					 headers: {
			           'Content-Type':'application/json'
			         },
			          data: {
						contas:conta,
						valData:{
							dataBaixa:dataBaixas,
							valor: valor,
							tipoDoctos:tipoDoctos
						},
						lancaCaixa:{
							caixa:caixa,
							statusCheck:statusCheck
						}

			          },
			          url: $scope.urlBase+'srvcContaPagar.php?baixarConta=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=base64_decode($us_id)?>'
					}).then(function onSuccess(response){

						$scope.retStatus = response.data.result[0];

						if ($scope.retStatus[0].status == 'SUCCESS') {
							$('#baixarConta').modal('hide');
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Conta Baixada com Sucesso!";
							chamarAlerta();
						}
						else if($scope.retStatus[0].status == 'ERROR'){
							
							$('#baixarConta').modal('hide');
							$scope.tipoAlerta = "alert-danger";
							$scope.alertMsg = "Conta NÃ£o Pode Ser Baixada!";
							chamarAlerta();
						}
					}).catch(function onError(){
						$('#baixarConta').modal('hide');
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Conta NÃ£o Pode Ser Baixada!";
						chamarAlerta();
					})
					window.location.reload();
					console.log($scope.retStatus);
				}
			};

			$scope.excluir =function(conta){
				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?excluirConta=S&ct_id='+conta.ct_id+'&ct_rateia='+conta.ct_rateia+'&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=base64_decode($us_id)?>'
				}).then(function onSuccess(response){
					$('#excluirConta').modal('hide');
					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Conta Excluida com Sucesso!";
					chamarAlerta();
					restcontasPagar();
				}).catch(function onError(){
					$('#excluirConta').modal('hide');
					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Conta Não Podo ser Excluída";
					chamarAlerta();
					restcontasPagar();
				})
			};

		    $scope.AdicionarDespesa = function (despesa, bc_codigo, dataPagto) {
				//alert(valorPago);
				var selecionarCaixa = $scope.dinheiro;

		    	if (selecionarCaixa == true) {
					if (bc_codigo == null || bc_codigo == undefined || bc_codigo == '') {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Selecione Um Caixa";
						chamarAlerta();
					} else {
						enviarDespesa(despesa, selecionarCaixa, bc_codigo, dataPagto);
					}
		    	} else {
					enviarDespesa(despesa, selecionarCaixa, bc_codigo, dataPagto);
				}
			}
			
			function enviarDespesa(despesa, selecionarCaixa, bc_codigo, dataPagto){
				
				//alert(valorPago);

				if (despesa.ct_rateia == undefined) {
					despesa.ct_rateia = 'N';
				}
				if (despesa.ct_empresa == undefined) {
					despesa.ct_empresa = $scope.dadosEmpresa[0].em_cod;
				}
				despesa.ct_emissao = $scope.ct_emissao;
				//alert(despesa.ct_empresa);
			
				var despesa = despesa;
				var parcelas = $scope.notaParcelas;
				var rateio = $scope.listaPRC;

				$http({
					method: 'POST',
						headers: {
						'Content-Type':'application/json'
						},
						data: {
						despesa:despesa,
						rateio:rateio,
						parcelas:parcelas
						},
						url: $scope.urlBase+'SalvaDespesa.php?SalvarDespesa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cx='+selecionarCaixa+'&bc_codigo='+btoa(bc_codigo)+'&dataPagto='+btoa(dataPagto)

				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];
					console.log($scope.retStatus[0]);
					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Despesa adicionada com sucesso!";
						chamarAlerta();
						//$('#ModalContaPagar').modal('hide');
					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Verifique se a conta foi adicionada";
						chamarAlerta();
					}
				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Erro ao adicionar despesa!";
					chamarAlerta();
						//$('#ModalContaPagar').modal('hide');
				});
				$scope.LimpaItens();
				//restcontasPagar();
				window.location.reload();
			};

			$scope.verificaCampo = function(campo) {

				if (campo == undefined || campo == null || campo == '') {
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Campo NÃO pode ser vazio!"
					chamarAlerta();
				}
			}

			$scope.editarConta = function(){
				
				var editarConta = $scope.contas;

				$http({
					method: 'POST',
					headers: {
						'Content-Type':'application/json'
					},
					data:{
						editarConta
					},
					url: $scope.urlBase+'srvcContaPagar.php?editarConta=S&us_id=<?=$us_id?>&e=<?=$empresa?>'
				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];
					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Despesa alterada com sucesso!";
						chamarAlerta();
						$('#editarContaAPagar').modal('dispose');
					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						$('#editarContaAPagar').modal('dispose');
					}
				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Erro ao adicionar despesa!";
					chamarAlerta();
					$('#editarContaAPagar').modal('dispose');
				});
				$scope.LimpaItens();
				restcontasPagar();
				//window.location.reload();
				//console.log(editarConta);
			}

			$scope.alterarVencimento = function (parc, novoValor) {
			      
				var index = $scope.notaParcelas.indexOf(parc);
				$scope.notaParcelas[index].vencimento = novoValor; 
  
			};
			  
			$scope.LimpaItens = function () {
		    	$scope.CaixasAbertos = '';
				$scope.numParcelasNota = [];
				$scope.statusCheck = false;
				$scope.selecionarCaixa = false;
				$scope.dadosFormaPagto = [];
				$scope.dadosHistorico = [];
				//document.getElementById('proximoDocto').value='';
				//document.getElementById('selectFornecedor').value='';
				//document.getElementById('ct_emissao').value='';
				$scope.ct_emissao = dataHoje();
				/*document.getElementById('formaPagto').value='';
				document.getElementById('descHistorico').value='';
				document.getElementById('inputValor').value='';
				document.getElementById('histPagto').value='';
				document.getElementById('qtdParcelas').value='1';
				document.getElementById('caixa').value='';*/

			};
		    

		    $scope.verificaDados = function(){
		    	$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "*Campos Obrigatórios Devem Ser Preenchidos!"
				chamarAlerta();
		    }

			$scope.verCaixa = function(e){
				if (e == true) {
					
					if($scope.caixas[0].bc_situacao == 'Fechado'){
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Não Existe Caixa Aberto Para Esse Usuário";
						chamarAlerta();
					}
				}
			}

			$scope.parcelaData = function (parc,despesa){
				var index = $scope.notaParcelas.indexOf(parc);
				$scope.notaParcelas[index].vencimento = despesa
				console.log(index);
				console.log(parc);
				console.log(despesa);
				console.log($scope.notaParcelas);
			}

			$scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

			$scope.print = function(){

				$scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();
				gerarpdf();

			}

		}).config(['$qProvider', function ($qProvider) {
			$qProvider.errorOnUnhandledRejections(false);
			}
		
		]).config(function($mdDateLocaleProvider) {
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

		angular.module("ZMPro").directive("parcelaDir", ParcelaDir);
		function ParcelaDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();
						}
					}

					$(element).mask('0/00', options);

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length > 2) {//verifica a quantidade de digitos.
							mask = "99/99";
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

		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};

		function tabenter(event,campo){
			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.select();
			}
		};

		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
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
		
		function setarFoco() {

			document.getElementById('formConta').reset();
			document.getElementById("proximoDocto").select();

		}

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
			var fornecedorSelect = document.getElementById('buscaFornec').value.innerText;
			var doctoSelect = document.getElementById('buscaDocto').value.innerText;
    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 10, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Contas a Pagar", 85, 27);
		        doc.setFontSize(12);
		        doc.setTextColor(40);
		        doc.setFontStyle('normal');
		        doc.text("<?=$nomeEmp?>", 85, 42);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
		        doc.setFontSize(9);
				doc.text("Empresa: " + empresa , 85, 52);
				if (fornecedorSelect != undefined) {
					doc.text("Fornecedor Pesquisado: " + fornecedorSelect , 85, 62);
				}
				if (doctoSelect != undefined) {
					doc.text("Documento pesquisado: " + doctoSelect , 85, 72);
				}
    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'left'},
		        	1: {halign: 'center'},
		        	2: {halign: 'left'},
		        	3: {halign: 'left'},
		        	4: {halign: 'right'},
					5: {halign: 'center'},
					6: {halign: 'center'}},
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