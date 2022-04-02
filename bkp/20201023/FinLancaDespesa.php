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

	.table-overflow {
    	max-height:430px;
    	overflow-x:auto;
	}

	.table-responsive{
		height:340px;  
		overflow:scroll;
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

	.dropdown-menu li ul li{
		border:1px solid #c0c0c0; 
		display:block; 
		width:150px;
		list-style-type: none;
	}
</style>
			<div ng-controller="ZMProCtrl" ng-init="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Lancar Despesas</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>
				
	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">
<!--		
							<div show-on-desktop>
							
								<div class="row bg-dark p-2 col-12">
								
								<form class="col-12">
								
									<div class="form-row align-items-center">
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
											<select class="form-control form-control-sm" id="cliente" ng-model="cliente">
												<option value="">Todos os Fornecedores</option>
												<option ng-repeat="dadosCliente in dadosFornecedores" value="{{dadosCliente.pe_cod}}">{{dadosCliente.pe_nome}} </option>
											</select>
										</div>

										<div class="col-auto ml-2" ng-init="canc = 'N'">
											<select class="form-control form-control-sm" id="canc" ng-model="canc">
												<option value="N">Em Aberto</option>
												<option value="S">Cancelados</option>
											</select>
										</div>
										
								    	<div class="col-auto ml-1">
								    		<label for="dataI">De </label>
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
												<button type="button" class="btn btn-outline-dark btn-sm" ng-click="contasPagarLista(dataI | date : 'yyyy-MM-dd', dataF | date : 'yyyy-MM-dd', empresa, cliente, canc)" style="color: white;">
													<i class="fas fa fa-search" ></i>
												</button>
											</div>
								    	</div>

								    </div>
								</form>
								
							</div>

							<div class="table-responsive px-0" style="overflow: auto;">

								<table class="table tabel-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1em !important;">
											
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')">Empresa</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_docto')">Docto</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_nome')">Fornecedor</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_vencto')">Emissão</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_valor')">Valor</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_tipdoc')">Paga?</th>
											<th scope="col" style=" font-weight: normal;">Ação</th>
											
										</tr>
									</thead>
									<tbody>
									<tr ng-repeat="contasPagar in contasPagar | orderBy:'sortKey'" ng-class="contasPagar.ct_vencta == 'Vencido' ? 'venc' : contasPagar.ct_vencta == 'Hoje' ? 'vencH':''">
										
											<td><span ng-if="contasPagar.ct_canc == 'S'" class="badge badge-light" style="background-color:rgb(230, 9, 40); color:#fff; margin-right:5px;">Cancelado</span>{{contasPagar.em_fanta | limitTo:20}}{{contasPagar.em_fanta.length >= 20 ? '...' : ''}}</td>
											<td>{{contasPagar.ct_docto}}</td>
											<td>{{contasPagar.ct_nome | limitTo:20}}{{contasPagar.ct_nome.length >= 20 ? '...' : ''}}</td>
											<td>{{contasPagar.ct_vencto | date : 'dd/MM/yyyy'}}</td>
											<td>{{contasPagar.ct_valor | currency: 'R$'}}</td>
											<td>{{contasPagar.dc_sigla}}</td>
											<td>

												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
														<i class="fas fa-ellipsis-v"></i> 
													</button>
													<div class="dropdown-menu">
<?php if (substr($me_compraA_Pagar, 3,1) == 'S') {?>
														<a class="dropdown-item" ng-click="buscarCont(contasPagar)">Baixar</a>
<?php } ?>
														<a class="dropdown-item" ng-click="excluir(contasPagar,1)">Excluir	</a>
													</div>
												</div>

											</td>
											

										</tr>
									</tbody>

								</table>

							</div>
							
							<div class="container col-12 p-2" style="border:none; background-color: #999999FF; color: black;">
								<div class="row align-items-center">
									<div class="col-3" style="text-align: left;">
										<div class="row justify-content-start">

												<button type="button" class="btn btn-sm" style="background-color: #de0000"></button><span style="color: black;">Vencidas: </span><span ng-if="canc == 'N'" color="#000"><b>{{totalContasPagar[0].ct_valorVencida | currency: ' R$ '}}</b></span>
											
										</div>

										<div class="row justify-content-start">

												<button type="button" class="btn btn-sm" style="background-color: #0034cf"></button><span style="color: black;">Vencendo hoje: </span><span ng-if="canc == 'N'" color="#000"><b>{{totalContasPagar[0].ct_valorHoje | currency: ' R$ '}}</b></span>
											
										</div>

										<div class="row justify-content-start">

												<button type="button" class="btn btn-sm" style="background-color: #000"></button><span style="color: black;">A Vencer: </span><span ng-if="canc == 'N'" color="#000"><b>{{totalContasPagar[0].ct_valorAvencer | currency: ' R$ '}}</b></span>
											
										</div>

									</div>

								</div>
							</div>

						</div>

						<div class="modal fade" id="baixarConta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" style="color:#000;">Baixar Conta</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button><br>

										

									</div>
									
									
									<div class="modal-body">
									<div style="color:#000;">
										<span style="font-weight:bold;">Nome Fornecedor: </span> <span> {{contas[0].ct_nome}} </span><br>
										<span style="font-weight:bold;">Docto: </span> <span> {{contas[0].ct_docto}} </span>
										<span style="font-weight:bold; margin-left:15px;">Parcela: </span> <span> {{contas[0].ct_parc}} </span>
										
										<span style="font-weight:bold; margin-left:15px;">Vencto.: </span> <span> {{contas[0].ct_vencto | date: 'dd/MM/yyyy'}} </span>
										
									</div>
									<hr>

										<div class="row">
											<div class="col-6">
												<label style="color:#000;">Data Do Pagamento</label>
												<input type="date" class="form-control form-control-sm" ng-model="dataBaixa" value="{{dataBaixa}}">
											</div>

											<div class="col-6" ng-init="valorBaixa = contas[0].ct_valor">
												<label style="color:#000;">Valor</label>
												<input type="text" class="form-control form-control-sm" ng-model="cont.valorBaixa" ng-value="contas[0].ct_valor" disabled money-mask>
											</div>

										</div>

										<div class="row">
											<div class="col-6">

											<label style="color:#000;">Forma De Pagamento</label>
												<select class="form-control form-control-sm" name="tipoDocto" id="tipoDocto" ng-model="tipoDocto">
													<option ng-repeat="tipoDoctos in tipoDoctos" value="{{tipoDoctos.dc_codigo}}" ng-if="tipoDoctos.dc_empr == contas[0].ct_empresa && (tipoDoctos.dc_sigla == 'DN' || tipoDoctos.dc_sigla == 'CA' || tipoDoctos.dc_sigla == 'CH')">{{tipoDoctos.dc_descricao}} </option>
												</select>

												<label style="color:#000;">Caixas</label>
												<select class="form-control form-control-sm" name="caixa" id="caixa" ng-model="caixa" ng-disabled="statusCheck == false">
													<option ng-repeat="caixa in caixas" value="{{caixa.bc_codigo}}" ng-if="caixa.bc_situacao == 'Aberto'">{{caixa.bc_descricao}} </option>
												</select>
											</div>
											<div class="col-6">

												<div>
													 
													<md-switch md-invert ng-model="statusCheck" class="fa-pull-right" ng-change="verCaixa(statusCheck)" style="margin-right:28px;">
														<span style="color:#000;">LanÃ§ar baixa no caixa</span>
													</md-switch>
												</div>
											
											</div>
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

					    <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="abrirModalLancar()" style="position: fixed; z-index: 999; background-color:#279B2D;">
							<md-tooltip md-direction="top" md-visible="tooltipVisible">Adicionar Conta</md-tooltip>
	                      	<i class="fa fa-plus"></i>

	                   	</md-button>
<?php }?>	
-->
						<!--md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
		                      	<i class="fa fa-plus"></i>
    	                </md-button-->

<?php

include 'Modal/LancarDespesas.php';

?>
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
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log, $window) {

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
			$scope.cliente_fornecedor = 'pe_fornecedor';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.empresafilial = ''; //undefined
			$scope.quitado = 'N';
			$scope.dinheiro = false;
			$scope.selecionarCaixa = false;
			$scope.numParcelas = 1;
			$scope.itens_somados = '';
			$scope.documento = '';
			$scope.bc_cod_func='<?=$us_cod?>';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.dataI = dataHoje();
			$scope.ct_emissao = dataHoje();
			$scope.itensNota = [];
			$scope.dadosNota = [];
			$scope.tipoDoctos=[];

			$scope.contas = [{
				ct_canc: '',
				ct_cliente_forn: '',
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

		    

			$scope.goPagina = function() {
			    $('#ModalContaPagar').modal('toggle');
			    $window.location.href = "/CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>";
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
				} else{
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

			var abrirModalLancar = function () {
				$scope.selecionarCaixa = false;
				$scope.dinheiro = false;
		    	//$('#formConta').get(0).reset();
			    //$('#ModalLancarDespesas').modal('show');
    			dadosFormaPagto();
				dadosHistorico();
			};
			
			abrirModalLancar();
			$scope.contasPagarLista = function (dataI,dataF,empresafilial, cliente, canc){

				restcontasPagar(dataI,dataF,empresafilial, cliente, canc);
			}

			$scope.buscarCont = function(conta){
				$http({
					method:'GET',
					url: $scope.urlBase + 'contas.php?buscarConta=S&ct_id='+conta.ct_id+'&token=<?=$token?>&empresa_matriz=<?=$empresa?>&us_id=<?=$us_id?>&quitado='+$scope.quitado+'&RecPag=P'
				}).then(function onSuccess(response){
					$scope.contas=response.data.result[0];
					$('#baixarConta').modal();
					
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
				
				$('#ModalContaPagar').modal('hide');
				
				window.location.reload();

				$scope.LimpaItens();
				
			};

		    $scope.LimpaItens = function () {
		    	$scope.CaixasAbertos = '';
				$scope.numParcelasNota('2020-01-01', 1, 0);
				$scope.selecionarCaixa = false;
				$scope.dadosFormaPagto = [];
				$scope.dadosHistorico = [];
				abrirModalLancar();
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

		function somenteNumeros(e) {
			var charCode = e.charCode ? e.charCode : e.keyCode;
			// charCode 8 = backspace   
			// charCode 9 = tab
			if (charCode != 8 && charCode != 9) {
				// charCode 48 equivale a 0   
				// charCode 57 equivale a 9
				if (charCode < 48 || charCode > 57) {
					return false;
				}
			}
		}

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