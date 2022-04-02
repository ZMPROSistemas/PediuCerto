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

	p.note {
	  font-size: 1.2rem; }

	.lock-size {
	  min-width: 300px;
	  min-height: 300px;
	  width: 300px;
	  height: 300px;
	  margin-left: auto;
	  margin-right: auto; }

	.pagination>li>a, .pagination>li>span {
	    position: relative;
	    float: left;
	    padding: 6px 12px;
	    line-height: 1.42857143;
	    text-decoration: none;
	    color: white;
	    background-color: rgba(0, 0, 0, 0.25);
	    border: 1px solid transparent;
	    margin-left: -1px;
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

	.dropdown-menu li ul li{
		border:1px solid #c0c0c0; 
		display:block; 
		width:150px;
		list-style-type: none;
	}

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}

	.table-overflow {
    	max-height:430px;
    	overflow-x:auto;
	}

	.table-responsive{
		height:360px;  
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
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Faturamento</li>
						<li class="breadcrumb-item active" aria-current="page">Compras</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
				    	<div class="row bg-dark p-2 col-12" >
				    		<form class="col-12">
								<div class="form-row align-items-center">
<?php if (base64_decode($empresa_acesso) == 0) {?>
									<div class="col-auto">
										<select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">
											<option value="">Todas as Empresas</option>
											<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
										</select>
									</div>
<?php } else {
echo $dados_empresa["em_fanta"];
}?>
									<!--<div class="col-auto ml-3">
										<select class="form-control form-control-sm" id="funcionario" ng-model="funcionario" ng-change="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" ng-if="empresa != ''">
											<option value="">Todos os Vendedores</option>
											<option ng-repeat="vendedor in dadosColaborador" value="{{vendedor.pe_cod}}">{{vendedor.pe_nome}} </option>
										</select>
									</div>-->
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
							    	<div class="col-auto">
										<div class="input-group-btn">
											<button type="button" class="btn btn-outline-dark btn-sm"  ng-click="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" style="color: white;">
												<i class="fas fa fa-search" ></i>
											</button>
										</div>
							    	</div>
<!--							    	<div class="col-auto inset">
										<md-switch ng-model="automatizarBusca" aria-label="Switch 1" ng-change="buscaAutom(automatizarBusca)"></md-switch>
									</div>-->
							    </div> 
							</form>
						</div>
						<div class="card col-12 p-0" style="border:none; background-color: #999999FF;">
							<div class="row">
								<div class="col-6 pl-2"><span style="color:black;"><b>Notas de Compras</b></span></div>
								<div class="col-6 pl-2"><span style="color:black;"><b>Itens da Nota: {{documento}}</b></span></div>
							</div>
						</div>
					    <div class="card col-12 p-0" style="border:none; background-color: #999999FF;">
					    	<div class="row">
							    <div class="table-responsive col-6 px-0" style="overflow: auto; background-color: white;">
									<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cp_nota')">Nota</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cp_emis')">Emissão</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cp_fnraz')">Fornecedor</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cp_valor')">Total</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('emp_empresa')">Empresa</th>
												<th scope="col" style="font-weight: normal; text-align: center;">Ação</th>
											</tr>
										</thead>
										<tbody >
											<tr ng-repeat="nota in dadosNota | orderBy:'sortKey':reverse"  ng-class="nota.cp_aberto == 'S' ? 'aberto' : 'normal'" ng-click="ConsultaNotaEntrada(nota)" >
												<td style="text-align: left;" ng-bind="nota.cp_nota"></td>
												<td style="text-align: left;" ng-bind="nota.cp_emis | date:'dd/MM/yyyy'" ></td>
												<td style="text-align: left;max-width: 180px;" ng-bind="nota.cp_fnraz" class="d-inline-block text-truncate"></td>
												<td style="text-align: right;" ng-bind="nota.cp_valor | currency:' '" ></td>
												<td style="text-align: left;max-width: 100px;" ng-bind="nota.emp_entrada" class="d-inline-block text-truncate"></td>
												<td style="text-align: center;">
													<button type="button" class="btn btn-outline-light p-0" ng-dblclick="confirmarNota(nota)" style="border-width: 0; color: black;">
					                                    <i ng-class="nota.cp_aberto == 'S' ? 'fas fa-genderless' : 'fas fa-check'"></i> 
					                                </button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="modal fade" id="confNota" tabindex="-1" role="dialog" aria-labelledby="confNotaModal" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="color: black;" >
										<div class="modal-content">
											<div class="modal-header">
												<h3 style="color: black !important;" >Confirmar Compra</h3>
											</div>
											<div class="modal-body">
												<div class="container-fluid">
													<form id="formNota">
													    <div class="row" >
													    	<input type="hidden" ng-bind="dadosNotaCompra[0].cp_empresa">
													    	<input type="hidden" ng-bind="dadosNotaCompra[0].cp_matriz">
													      	<div class="col-auto">
													      		<label>Nota</label>
																<h5 style="color: black !important;" ng-bind="dadosNotaCompra[0].cp_nota"></h5>
															</div>
													      	<div class="col-4">
													      		<label>Fornecedor</label>
																<h5 style="text-align: left; color: black !important;" ng-bind="dadosNotaCompra[0].cp_fnraz | limitTo:30"></h5>
															</div>
													      	<div class="col-auto">
													      		<label>Valor da Compra</label>
																<h5 style="text-align: right; color: black !important;" ng-bind="dadosNotaCompra[0].cp_valor | currency: 'R$ '" id="valorCompra" ng-model="valorCompra"></h5>
															</div>
													      	<div class="col-2">
													      		<label>Adicional</label>
																<input style="text-align: right; color: black !important;" type="number" class="form-control" value="0" id="adicionalCompra" ng-model="adicionalCompra">
															</div>
													      	<div class="col-auto">
													      		<label>Valor Total</label>
																<h5 style="text-align: right; color: black !important;">{{totalCompra | currency: 'R$ '}}</h5>
																<input style="text-align: right; color: black !important;" type="hidden" class="form-control" ng-bind="totalCompra =+ dadosNotaCompra[0].cp_valor + adicionalCompra" ng-model="totalCompra" id="totalCompra">
															</div>
														</div>

													    <div class="row">
															<div class="form-group col-md-5" >
																<label for="formaPagto">Forma de Pagamento</label>
																<select class="form-control" id="formaPagto" ng-model="ct_tipdoc" ng-blur="ConsultaCaixa(ct_tipdoc)" onKeyUp="tabenter(event,getElementById('formaPagto'))">
																	<option value="">Selecione a Forma de Pagamento</option>
																	<option ng-repeat="forma in dadosFormaPagto" value="{{forma.dc_codigo}}">{{forma.dc_descricao}} </option>
																</select>
															</div>
															<div class="form-group col-md-5" >
																<label for="formaPagto">Histórico Pagamento</label>
																<select class="form-control" id="formaPagto" ng-model="ct_historico" ng-change="numParcelasNota(dadosNotaCompra[0].cp_emis, totalCompra, numParcelas, ct_tipdoc)">
																	<option value="">Selecione o Histórico</option>
																	<option ng-repeat="historico in dadosHistorico" value="{{historico.ht_cod}}" ng-if="historico.ht_dc == 'D'" >{{historico.ht_descricao}}</option>
																</select>
															</div>
															<div class="form-group col-md-2">
																<label for="qtdParcelas">Qtde. Parcelas</label>
																<input type="number" class="form-control" id="numParcelas" value="1" ng-model="numParcelas" ng-blur="numParcelasNota(dadosNotaCompra[0].cp_emis, totalCompra, numParcelas, ct_tipdoc)" onKeyUp="tabenter(event,getElementById('dataVencto'))">
															</div>
														</div>

													    <div class="row" ng-show="dinheiro">
													    	<div class="col-4 mt-0" >
														    	<md-switch ng-model="selecionarCaixa" class="fa-pull-right" ng-disabled="numParcelas != 1">
	    															Lançar no Caixa
	  															</md-switch>
	  														</div>
													    	<div class="col-8" ng-show="selecionarCaixa">
																<select class="form-control" id="caixa" ng-model="bc_codigo" >
																	<option value="">Selecione o Caixa</option>
																	<option ng-repeat="caixa in CaixasAbertos" ng-value="caixa.bc_codigo">{{caixa.bc_descricao}} </option>
																</select>
	  														</div>
													    </div>

													    <div class="row" ng-repeat="parc in notaParcelas">
															<div class="form-group col-md-2" >
																<label for="qtdParcelas">Parcela</label>
																<input type="text" class="form-control" id="qtdParcelas" ng-model="parc.vezes" readonly>
															</div>
															<div class="form-group col-md-5" >
																<label>Vencimento</label>
																<input type="date" class="form-control" id="dataVencto" value="{{parc.vencimento}}" ng-model="parc.vencimento" ng-change="alterarVencimento(parc, parc.vencimento | date: 'yyyy-MM-dd')" >
															</div>
															<div class="form-group col-md-5" >
																<label>Valor por Parcela</label>
																<input type="text" class="form-control" id="valParcela" value="{{parc.parcela}}" ng-model="parc.parcela" ng-blur="alterarParcela(parc, parc.parcela)">
															</div>
														</div>
													</form>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Cancelar</button>
												<button type="button" class="btn btn-lg btn-primary" ng-click="AdicionarContaReceber(dadosNotaCompra[0].cp_id, dadosNotaCompra[0].cp_empresa, dadosNotaCompra[0].cp_matriz, dadosNotaCompra[0].cp_nota, dadosNotaCompra[0].cp_forn, dadosNotaCompra[0].cp_emis, dadosNotaCompra[0].cp_fnraz, ct_tipdoc, ct_historico, selecionarCaixa, bc_codigo, notaParcelas[0].vencimento, notaParcelas[0].parcela)" data-dismiss="modal" ng-if="ct_tipdoc && ct_historico && notaParcelas[0].vezes">Confirmar Compra</button>
											</div>
										</div>
									</div>
								</div>

							    <div class="table-responsive col-6 px-0" style="overflow: auto; background-color: white; border-left: 8px #999999FF solid;">
									<table class="table table-sm table-striped" style="background-color: white; color: black; width: 100%; border-left: 1px solid #E5E5E5FF;" >
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cpi_prod')">Cód</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('cpi_descricao')">Descrição</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cpi_quant')">Qtde</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cpi_preco')">Unitário</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('cpi_total')">Total</th>
											</tr>
										</thead>
										<tbody ng-init="itens_somados = 0">
											<tr ng-repeat="itens in itensNota | orderBy:'sortKey':reverse" >
												<td style="text-align: left;" ng-bind="itens.cpi_prod" ></td>
												<td style="text-align: left;" ng-bind="itens.cpi_descricao" class="d-inline-block text-truncate"></td>
												<td style="text-align: right;" ng-bind="itens.cpi_quant | number" ></td>
												<td style="text-align: right;" ng-bind="itens.cpi_preco | currency:' '" ></td>
												<td style="text-align: right;" ng-bind="itens.cpi_total | currency:' '" ></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="container col-12 p-2" style="border:none; background-color: #999999FF;">
							<div class="row align-items-center">
						    	<div class="col-6" style="text-align: left;">
						    		<span style="color: #303030FF;">Registros: <b>{{dadosNota.length}}</b></span>
								</div>
						    	<div class="col-4" style="text-align: left;">
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Tipo Documento: <b>{{tipodocto}}</b></span>
							    	</div>
								</div>
						    	<div class="col-2" style="text-align: right;">
						    		<span style="color: #303030FF;">Itens: <b>{{somaQtde}}</b></span>
								</div>
							</div>
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
	<script src="js/jquery.mask.min.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log, $window) {

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

			$scope.totalCompra = 0;
			$scope.total = 0;
			$scope.selecionarCaixa = false;
			$scope.tipodocto = '';
			$scope.somaQtde = '';
			$scope.dinheiro = false;
		    $scope.tab = 1;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.itensNota = [];
			$scope.dadosNota = [];
			
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

			$scope.contas = [];
			$scope.numParcelas = 1;
			$scope.itens_somados = '';
			$scope.documento = '';
			$scope.automatizarBusca = true;
			$scope.funcionario = '';
			$scope.empresa = '';
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
    		$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.bc_cod_func='<?=$us_cod?>';
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
		    
    		$scope.soma = function (){

	    		$scope.valorCompra = parseFloat($scope.valorCompra);
	    		$scope.adicionalCompra = parseFloat($scope.adicionalCompra);
	    		$scope.total = $scope.valorCompra + $scope.adicionalCompra;

    		};

		    $scope.confirmarNota = function (nota) {
		    	var aberto = nota.cp_aberto;
		    	var notaF = nota.cp_id;
		    	if (aberto == 'S') {
		    		ConsultaNota(notaF);
					$scope.selecionarCaixa = false;
					$scope.dinheiro = false;
			    	$('#formNota').get(0).reset();
				    $('#confNota').modal('show');
		    	} else {
		    		alert("Nota já confirmada!");
		    	}
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

		    var dadosFormaPagto = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?dadosFormaPagto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosFormaPagto=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar formas de pagamento. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosFormaPagto();

		    var dadosHistorico = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?dadosHistorico=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosHistorico=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar historico de pagamento. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosHistorico();

		    var ConsultaNota = function (notaF) {
		    	$scope.notaParcelas = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?relatorio=S&consultaNota=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI=1&dataF=1&cp_id='+notaF
				}).then(function onSuccess(response){
					$scope.dadosNotaCompra=response.data.result[0];
			}).catch(function onError(response){
				});
			};

		    $scope.ConsultaCaixa = function (tipo) {
		    	if (tipo == 1) {
					$scope.dinheiro = true;
					$http({
						method: 'GET',
						url: $scope.urlBase+'ConsultaNota.php?relatorio=S&CaixasAbertos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&bc_cod_func=' + $scope.bc_cod_func
						}).then(function onSuccess(response){
							$scope.CaixasAbertos=response.data.result[0];
						}).catch(function onError(response){
					});
				} else {
					$scope.dinheiro = false;
				}
			};

		    var relatorioNotasEntrada = function (empresa, dataI, dataF) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?relatorio=S&dadosNotaEntrada=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.dadosNota=response.data.result[0];
			}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar notas. Caso este erro persista, contate o suporte.");
				});
			};

			//relatorioVendas();

			$scope.modificaBusca = function (empresa,dataI,dataF){
				$scope.empresa = empresa;
				$scope.dataI = dataI;
	    		$scope.dataF = dataF;	
	    		busca();
			}

			$scope.alterarVencimentoArray = function (campo, novoValor) {
			      
			    var index = $scope.itensPedido.indexOf(campo);
			    $scope.notaParcelas.vencimento.splice(index,1, novoValor);     
				$scope.ordem=$scope.ordem-1;

			}

			var busca = function(){ 
				/*alert("alguma");*/
				

			<?php if (base64_decode($empresa_acesso) != 0) {?>
				$scope.empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>
			/*
				if ($scope.empresa == undefined) {
					empresa = '';
				}
				if ($scope.empresa == '') {
					empresa = '';
				}
				*/
			relatorioNotasEntrada($scope.empresa, $scope.dataI, $scope.dataF);
//			console.log(empresa + '-' + dataI + '-' + dataF + '-' );

			}

			/*var buscaAutomatica = setInterval(busca, 6000);

			/*$scope.buscaAutom = function() {
				if automatizarBusca == false {
					clearInterval(buscaAutomatica);
				}
			}*/
		    
		    $scope.ConsultaNotaEntrada = function (nota) {
				$scope.tipodocto = nota.dc_descricao;
		    	$scope.documento = nota.cp_nota;
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?relatorio=S&itensNotaEntrada=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI=1&dataF=1&cp_id='+nota.cp_id
				}).then(function onSuccess(response){
					$scope.itensNota=response.data.result[0];
					SomaQtdeItens();
				}).catch(function onError(response){
					alert("erro");
				});
			};

	    	var SomaQtdeItens = function(){

	    		$scope.somaQtde = $scope.itensNota.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cpi_quant);}, 0);
		    
		    }

		    $scope.AdicionarContaReceber = function (cp_id, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_emissao, ct_nome, ct_tipdoc, ct_historico, selecionarCaixa, bc_codigo, ct_pagto, ct_valorpago) {

		    	if (cp_id == undefined) {
		    		cp_id = null;
		    	}
		    	if (ct_empresa == undefined) {
		    		ct_empresa = null;
		    	}
		    	if (ct_matriz == undefined) {
		    		ct_matriz = null;
		    	}
		    	if (ct_docto == undefined) {
		    		ct_docto = null;
		    	}
		    	if (ct_cliente_forn == undefined) {
		    		ct_cliente_forn = null;
		    	}
		    	if (ct_emissao == undefined) {
		    		ct_emissao = null;
		    	}
		    	if (ct_nome == undefined) {
		    		ct_nome = null;
		    	}
		    	if (ct_tipdoc == undefined) {
		    		ct_tipdoc = null;
		    	}
		    	if (ct_historico == undefined) {
		    		ct_historico = null;
		    	}
		    	if (ct_pagto == undefined) {
		    		ct_pagto = null;
		    	}
		    	if (ct_valorpago == undefined) {
		    		ct_valorpago = null;
		    	}
		    	
				var obj = {
					cp_id: cp_id,
					ct_empresa: ct_empresa,
					ct_matriz: ct_matriz,
					ct_docto: parseInt(ct_docto),
					ct_cliente_forn: ct_cliente_forn,
					ct_emissao: ct_emissao,
					ct_nome: ct_nome,
					ct_tipdoc: ct_tipdoc,
					ct_historico: ct_historico,
					ct_pagto: ct_pagto,
					ct_valorpago: ct_valorpago
				};

				$scope.contas.push(obj);
			    SalvarContaReceber(selecionarCaixa, bc_codigo);
			    console.log($scope.contas);

		    };

		    var SalvarContaReceber = function (selecionarCaixa, bc_codigo) {

				var contas = $scope.contas;
				var parcelas = $scope.notaParcelas;

				$http({
					
					method: 'POST',
					 headers: {
			           'Content-Type':'application/json'
			         },
			          data: {
			           contas:contas,
			           parcelas:parcelas
			          },
			          url: $scope.urlBase+'SalvaCompra.php?cx='+selecionarCaixa+'&bc_codigo='+btoa(bc_codigo)

				}).then(function onSuccess(response){
					$scope.retStatus = response.data.result[0];

					if ($scope.retStatus[0].status == 'SUCCESS') {
						
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Compra adicionada com sucesso!";
						chamarAlerta();
						busca();
					} else if ($scope.retStatus[0].status == 'ERROR') {						
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar compra!";
						chamarAlerta();
						busca();
					}
									
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao adicionar compra!";
						chamarAlerta();
						busca();
				})
				window.location.reload();
				$scope.LimpaItens();
			};

		    $scope.LimpaItens = function () {
		    	$scope.CaixasAbertos = '';
				$scope.tipodocto = '';
				$scope.itensNota='';
				$scope.notaParcelas = '';

			};

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

			$scope.alterarVencimento = function (parc, novoValor) {
			      
			    var index = $scope.notaParcelas.indexOf(parc);
			    $scope.notaParcelas[index].vencimento = novoValor; 

			};

			$scope.alterarParcela = function (parc, novoValor) {
				
				var valParcela = novoValor.replace(',', '.');
			    var index = $scope.notaParcelas.indexOf(parc);
			    $scope.notaParcelas[index].parcela = valParcela; 

			};

		    $scope.numParcelasNota = function(cp_vencto, valor, numParcelas, ct_tipdoc) {
		    	$scope.notaParcelas = '';
		    	if (numParcelas > 12) {
		    		alert("Número de parcelas inválido.");
		    	} else if (numParcelas < 1) {
		    		alert("Número de parcelas inválido.");
		    	} else {
	  				$http({
					method: 'GET',
					url: $scope.urlBase+'NumParcelaCompra.php?vencimento='+cp_vencto+'&valorTotal='+valor+'&numParcelas='+numParcelas+'&ct_tipdoc='+ct_tipdoc
					}).then(function onSuccess(response){

						$scope.notaParcelas=response.data.result[0];

					}).catch(function onError(response){

					});
				}
		    };

		    $scope.alterarVencto = function(vencimento,key){
			  //alert(parcelaBoleto + '-'+key);
				$scope.notaParcelas[key].vencimento=notaParcelas;
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