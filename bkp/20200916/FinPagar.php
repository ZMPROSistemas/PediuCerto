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
	
	.alert{display: none;}

	.text-capitalize {
	  text-transform: capitalize; }

	.md-fab:hover, .md-fab.md-focused {
	  background-color: #000 !important; }

	p.note {
	  font-size: 1.2rem; }

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

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}


	thead tr:nth-child(1) th{
	    background: white;
	    position: sticky;
	    top: 0;
	    z-index: 10;
	}

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
		-moz-box-shadow:0 3px 10px 0 #CCC;
		-webkit-box-shadow:0 3px 10px 0 #ccc;
		list-style-type: none;
		
	}

	.dropdown-menu li:hover ul, .dropdown-menu li.dropdown-over ul{
		display:block;
	}

	.table-responsive { 
		overflow:scroll;
		background-color:#ffffff;
	}

	.dropdown-menu li ul li{
		border:1px solid #c0c0c0; 
		display:block; 
		width:150px;
		list-style-type: none;
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
                			                <div class="form-row align-items-center">
												
												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="buscaFornec" ng-model="buscaFornec" placeholder="Procura Rápida">
												</div>

												<div class="col-auto ml-2">
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
												<div class="col-auto">
													<md-button class="btnPesquisar pull-left" style="border: none;" ng-click="contasPagarLista('','', empresa,'','')" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
												</div>
											</div>
										</form>

										<div class="table-responsive p-0 mb-2" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_docto')">Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parcela</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_nome')">Fornecedor</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_vencto')">Vencto</th>
														<th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Valor</th>
														<th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_tipdoc')">Tipo Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
														
													</tr>
												</thead>
												<tbody>
													
													<tr dir-paginate="contasPagar in contasPagar | filter:{ct_nome:buscaFornec} | filter:{ct_canc:canc} | orderBy:'sortKey' | itemsPerPage:20" ng-class="contasPagar.ct_vencta == 'Vencido' ? 'venc' : contasPagar.ct_vencta == 'Hoje' ? 'vencH':''">
													
														<td><span ng-if="contasPagar.ct_canc == 'S'" class="badge badge-light" style="background-color:red; color:#fff; margin-right:5px; text-align: left;">Cancelado</span>{{contasPagar.em_fanta | limitTo:25}}{{contasPagar.em_fanta.length >= 20 ? '...' : ''}}</td>
														<td ng-bind="contasPagar.ct_docto" align="left"></td>
														<td style="text-align: center;" ng-bind="contasPagar.ct_parc" align="center"></td>
														<td style="text-align: left;" ng-bind="contasPagar.ct_nome | limitTo:25"></td>
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
																	<a class="dropdown-item" ng-click="buscarCont(contasPagar,'B')">Baixar</a>
			<?php } ?>
			<?php if (substr($me_compraA_Pagar, 3,1) == 'S') {?>
																	<a class="dropdown-item" ng-click="editConta(contasPagar,'E')">Editar</a>
			<?php } ?>
																	<a class="dropdown-item" ng-click="excluir(contasPagar,1)">Excluir</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									
									<div class="card-footer p-2">
										<div class="form-row align-items-center">
											<div class="col-12" style="text-align: left;">
												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #de0000"></button>
													<span class="col-auto">Vencidas: <b class="col-auto">{{totalContasPagar[0].ct_valorVencida | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #0034cf"></button>
													<span class="col-auto">Vencendo hoje: <b class="col-auto">{{totalContasPagar[0].ct_valorHoje | currency: 'R$ '}}</b></span>
												</div>

												<div class="row justify-content-start">
													<button type="button" class="btn btn-sm" style="background-color: #000"></button>
													<span class="col-auto">A Vencer: <b class="col-auto">{{totalContasPagar[0].ct_valorAvencer | currency: 'R$ '}}</b></span>
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
												<span style="font-weight:bold;">Nome Fornecedor: </span> <span> {{contas[0].ct_nome}} </span><br>
												<span style="font-weight:bold;">Docto: </span> <span> {{contas[0].ct_docto}} </span>
												<span style="font-weight:bold; margin-left:15px;">Parcela: </span> <span> {{contas[0].ct_parc}} </span>
												<span style="font-weight:bold; margin-left:15px;">Vencto.: </span> <span> {{contas[0].ct_vencto | date: 'dd/MM/yyyy'}} </span>
												<hr>
												<form class="col-12">
													<div class="form-row">
														<div class="form-group col-6">
															<label>Data Do Pagamento</label>
															<input type="date" class="form-control form-control-sm" ng-model="dataBaixa" value="{{dataBaixa}}">
														</div>
														<div class="form-group col-6" ng-init="valorBaixa = contas[0].ct_valor">
															<label>Valor</label>
															<input type="text" class="form-control form-control-sm" ng-model="cont.valorBaixa" ng-value="contas[0].ct_valor | currency: 'R$ '" disabled>
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
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
											<button type="button" class="btn btn-primary" ng-click="baixarContaPaga(caixa,statusCheck,dataBaixa,cont.valorBaixa,tipoDocto)">Baixar</button>
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

include 'Modal/ContasPagar.php';
include 'Modal/editarContasPagar.php';

?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/dirPagination.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.statusCheck = false;
			$scope.urlBase = 'services/';
			$scope.contasPagar=[];
			$scope.dadosCliente=[];
			$scope.totalContasPagar=[];
			$scope.contas=[];
			$scope.caixas=[];
			$scope.dataI = dataHoje();
			$scope.cliente_fornecedor = 'pe_fornecedor';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.notaParcelas = [];
			var empresafilial = ''; //undefined
			$scope.quitado = 'N';
			$scope.dinheiro = false;
			$scope.selecionarCaixa = false;
			$scope.numParcelas = 1;
			$scope.itens_somados = '';
			$scope.documento = '';
			$scope.bc_cod_func='<?=$us_cod?>';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.dataBaixa = dataHoje();
			$scope.ct_emissao = dataHoje();
			$scope.itensNota = [];
			$scope.dadosNota = [];
			$scope.tipoDoctos = [];
			$scope.arrayContas = [];
			
			$scope.contas = [{
				ct_canc: '',
				ct_cliente_forn: '',
				ct_cliente_forn_id: '',
				ct_docto: '',
				ct_emissao: '',
				ct_empresa: '',
				ct_id: '',
				ct_idlocal: '',
				ct_matriz: '',
				ct_nome: '',
				ct_pagto: '',
				ct_parc: '',
				ct_quitado: '',
				ct_receber_pagar: '',
				ct_tipdoc: '',
				ct_tipo_ocorrencia: '',
				ct_valor: '',
				ct_valorpago: '',
				ct_vencta: '',
				ct_vencto: '',
				ct_vendedor: '',
				em_fanta: '',
				vendedor: '',
			}]
			
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
		    	$('#formConta').get(0).reset();
			    $('#ModalContaPagar').modal('show');
    			dadosFormaPagto();
				dadosHistorico();
    		};

			$scope.goPagina = function() {
			    $('#ModalContaPagar').modal('toggle');
			    $window.location.href = "http://sistema.zmpro.com.br/CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>";
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

			var caixas = function (empresa){
				$http({
					method:'GET',
					url: $scope.urlBase + 'caixas.php?caixa=S&contrCaixa=S&&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&bc_cod_func=' + $scope.bc_cod_func
				}).then(function onSuccess(response){
					$scope.caixas= response.data.result[0];
				}).catch(function onError(response){
					$scope.caixa = response.data;
				});
			};
			caixas();

		    $scope.ConsultaCaixa = function (tipo) {
		    	if (tipo == 1) {
					$scope.dinheiro = true;
					$http({
						method: 'GET',
						url: $scope.urlBase+'ConsultaNota.php?relatorio=S&CaixasAbertos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
					}).then(function onSuccess(response){
						$scope.CaixasAbertos=response.data.result[0];
					}).catch(function onError(response){
				});
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
				
		    	$scope.notaParcelas = '';
		    	if (numParcelas > 12) {
		    	} else if (numParcelas < 1) {
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
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosFornecedores=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosCliente();

			var restTotalContasPagar = function(dataI,dataF,empresafilial, cliente, canc){
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?pagar=S&totalContasPagar=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+empresafilial+'&cliente='+cliente+'&canc='+canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.totalContasPagar = response.data.result[0];
				}).catch(function onError(response){

				});
			}

			var restcontasPagar = function (dataI,dataF,empresafilial, cliente, canc){
				if (dataI == undefined) {
					dataI = '';
				}
				if (dataF == undefined) {
					dataF = '';
				}
				if (empresafilial == undefined) {
					empresafilial='';
				}
				if (cliente == undefined) {
					cliente = '';
				}
				if (canc == undefined) {
					canc = 'N';
				}

				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?pagar=S&listaContasPagar=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+empresafilial+'&cliente='+cliente+'&canc='+canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.contasPagar = response.data.result[0];
					restTotalContasPagar(dataI,dataF,empresafilial, cliente, canc);
				}).catch(function onError(response){

				});
			}

			restcontasPagar();

			$scope.contasPagarLista = function (dataI,dataF,empresafilial, cliente, canc){

				restcontasPagar(dataI,dataF,empresafilial, cliente, canc);
			}

			$scope.editConta = function (conta,e){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?buscarContaID=S&ct_id='+conta.ct_id+'&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=$us_id?>&quitado='+$scope.quitado+'&RecPag=P'
				}).then(function onSuccess(response){
					$scope.contas=response.data.result[0];
					if (e == 'B') {
						$('#baixarConta').modal();
					}
					else if(e == 'E'){
						$('#editarContaAPagar').modal();
					}
					
				}).catch(function onError(){

				})
			}


			$scope.buscarCont = function(conta,e){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?buscarConta=S&ct_id='+conta.ct_id+'&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=$us_id?>&quitado='+$scope.quitado+'&RecPag=P'
				}).then(function onSuccess(response){
					$scope.contas=response.data.result[0];
					if (e == 'B') {
						$('#baixarConta').modal();
					}
					else if(e == 'E'){
						$('#editarContaAPagar').modal();
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
			          url: $scope.urlBase+'contas.php?baixarConta=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=base64_decode($us_id)?>'
					}).then(function onSuccess(response){

						$scope.retStatus = response.data.result[0];

						if ($scope.retStatus[0].status == 'SUCCESS') {
							$('#baixarConta').modal('hide');
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Conta Baixada!";
							chamarAlerta();
							restcontasPagar();
						}
						else if($scope.retStatus[0].status == 'ERROR'){
							
							$('#baixarConta').modal('hide');
							$scope.tipoAlerta = "alert-danger";
							$scope.alertMsg = "Conta NÃ£o Pode Ser Baixada!";
							chamarAlerta();
							restcontasPagar();
						}
						console.log($scope.retStatus);
					}).catch(function onError(){

					})
				}
				
			}

			$scope.excluir =function(contasPagar,e){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?excluir=S&ct_id='+contasPagar.ct_id+'&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=$us_id?>'
				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];
					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Conta Excluida!";
						chamarAlerta();
						restcontasPagar();
					}
					else if($scope.retStatus[0].status == 'ERROR'){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Conta NÃ£o Pode Ser Excluida!";
						chamarAlerta();
						restcontasPagar();
					}
										
				}).catch(function onError(){

				})
			}

			$scope.alterarVencimento = function (parc, novoValor) {
			      
			    var index = $scope.notaParcelas.indexOf(parc);
			    $scope.notaParcelas[index].vencimento = novoValor; 

			};
			
		    $scope.AdicionarDespesa = function (despesa, selecionarCaixa, bc_codigo, ct_emissao) {

		    	if (selecionarCaixa == true) {
		    		if (bc_codigo == null) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Selecione Um Caixa";
						chamarAlerta();
					} else {
						enviarDespesa(despesa, selecionarCaixa, bc_codigo, ct_emissao);
					}
		    	} else {
					enviarDespesa(despesa, selecionarCaixa, bc_codigo, ct_emissao);
				}
			}

			function enviarDespesa(despesa, selecionarCaixa, bc_codigo, ct_emissao){
			
				var despesa = despesa;
				var parcelas = $scope.notaParcelas;

				$http({
					
					method: 'POST',
						headers: {
						'Content-Type':'application/json'
						},
						data: {
						despesa:despesa,
						parcelas:parcelas
						},
						url: $scope.urlBase+'SalvaDespesa.php?SalvarDespesa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cx='+selecionarCaixa+'&bc_codigo='+btoa(bc_codigo)+'&ct_emissao='+ct_emissao

				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Despesa adicionada com sucesso!";
						chamarAlerta();
						

						$('#ModalContaPagar').modal('hide');

					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						
					}
									
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						
						$('#ModalContaPagar').modal('hide');
				});
				

				$scope.LimpaItens();
				restcontasPagar();
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

						  url: $scope.urlBase+'contas.php?editarContaID=S&us_id=<?=$us_id?>&e=<?=$empresa?>'
						
				}).then(function onSuccess(response){
						
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Despesa alterada com sucesso!";
						chamarAlerta();
						
						$('#editarContaAPagar').modal('hide');


					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();

						$('#editarContaAPagar').modal('hide');
					}
									
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						
						$('#editarContaAPagar').modal('hide');
				});
					
				window.location.reload();

				//console.log(editarConta);

			}


			$scope.editarDespesa = function(empresa, parc, mudarVencimento, mudarValor, mudarTipoDocto, descricao, fornecedor){
				alert(fornecedor);
				if (empresa == "") {
					empresa = $scope.contas[0].ct_empresa;
				}
				if (parc == "") {
					parc = $scope.contas[0].ct_parc;
				}
				if (mudarVencimento == "") {
					mudarVencimento = $scope.contas[0].ct_vencto;
				}
				if (mudarValor == "") {
					mudarValor = $scope.contas[0].ct_valor;
				}
				if (mudarValor =="R$0,00") {
					mudarValor = $scope.contas[0].ct_valor;
				}
				if (mudarValor =="$0,00") {
					mudarValor = $scope.contas[0].ct_valor;
				}
				if (mudarValor =="0,00") {
					mudarValor = $scope.contas[0].ct_valor;
				}
				if (mudarTipoDocto == null || mudarTipoDocto == 'undefined' || mudarTipoDocto == '') {
					mudarTipoDocto = $scope.contas[0].ct_tipdoc;
				}
				if(descricao == null || descricao == 'undefined' || descricao == ''){
					descricao = $scope.contas[0].ct_obs;
				}
				if(fornecedor == null || fornecedor == 'undefined' || fornecedor == ''){
					alert($scope.contas[0].ct_cliente_fornecedor_id);
					fornecedor = $scope.contas[0].ct_cliente_fornecedor_id;
				}
				var ct_id = $scope.contas[0].ct_id;
				var ct_docto = $scope.contas[0].ct_docto;
				var editarConta=[{
					'ct_id': ct_id,
					'ct_docto': ct_docto,
					'empresa': empresa,
					'parc' : parc,
					'mudarVencimento' : mudarVencimento,
					'mudarValor' : mudarValor,
					'mudarTipoDocto' : mudarTipoDocto,
					'ct_obs': descricao,
					'ct_cliente_forn':fornecedor
				}];

				$http({
						
						method: 'POST',
						 headers: {
				           'Content-Type':'application/json'
				         },
				          data: {
							editarConta
						  },
						  url: $scope.urlBase+'SalvaDespesa.php?editarDespesa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cx=false&bc_codigo=null&ct_emissao='+ct_emissao
						
				}).then(function onSuccess(response){
						
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Despesa adicionada com sucesso!";
						chamarAlerta();
						restcontasPagar();

						$('#editarContaAPagar').modal('hide');

					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						$('#editarContaAPagar').modal('hide');
					}
									
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar despesa!";
						chamarAlerta();
						
						$('#editarContaAPagar').modal('hide');
				});
					
					$('#editarContaAPagar').modal('hide');
					$scope.fornecedor='';
				//console.log(editarConta);

			}
			
		    $scope.LimpaItens = function () {
		    	$scope.CaixasAbertos = '';
				$scope.numParcelasNota = [];
				$scope.selecionarCaixa = false;
				$scope.dadosFormaPagto = [];
				$scope.dadosHistorico = [];
				document.getElementById('numDocumento').value='';
				document.getElementById('selectFornecedor').value='';
				//document.getElementById('ct_emissao').value='';
				$scope.ct_emissao = dataHoje();
				document.getElementById('formaPagto').value='';

				document.getElementById('descHistorico').value='';
				document.getElementById('inputValor').value='';
				document.getElementById('histPagto').value='';
				document.getElementById('qtdParcelas').value='1';
				document.getElementById('caixa').value='';

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
				campo.focus();
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

	</script>


</body>
</html>