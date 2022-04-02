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
    	max-height:480px;
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

	.NF {

		color: red;
	}

</style>

			<div ng-controller="ZMProCtrl" ng-init="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">	 
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0 mt-1">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Faturamento</li>
						<li class="breadcrumb-item active" aria-current="page">Vendas</li>
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
									<div class="col-auto ml-3">
										<!--<select class="form-control form-control-sm" id="funcionario" ng-model="funcionario" ng-change="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" ng-if="empresa != ''">
											<option value="">Todos os Vendedores</option>
											<option ng-repeat="vendedor in dadosColaborador" value="{{vendedor.pe_cod}}">{{vendedor.pe_nome}} </option>
										</select>-->
									</div>
							    	<div class="col-auto ml-3">
							    		<label for="dataI">Período de </label>
									</div>
							    	<div class="col-auto">
										<input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}" ng-keydown="pararBuscaAutom()">
									</div>
							    	<div class="col-auto">
							    		<label for="dataF">até </label>
									</div>
							    	<div class="col-auto">
										<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">
									</div>
							    	<div class="col-auto">
										<div class="input-group-btn">
											<button type="button" class="btn btn-outline-dark btn-sm" onclick="pararBuscaAutom()" ng-click="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')" style="color: white;">
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
								<div class="col-7 pl-2"><span style="color:black;"><b>Pedidos de Vendas</b></span></div>
								<div class="col-5 pl-2"><span style="color:black;"><b>Itens da Venda: {{documento}} </b></span></div>
							</div>
						</div>
					    <div class="card col-12 p-0" style="border:none; background-color: #999999FF;">
					    	<div class="row">
							    <div class="table-responsive col-7 px-0" style="overflow: hidden; background-color: white;">
									<table class="table table-sm table-striped pb-0" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('vd_doc')">Doc</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('vd_emissao')">Emissão</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('vd_hora')">Horário</th>
												<th scope="col" style="font-weight: normal;" ng-click="ordenar('vd_nome')">Cliente</th>
												<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('vd_empr')">Empresa</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('vd_total')">Valor Total</th>
											</tr>
										</thead>
										<tbody >
											<tr dir-paginate="vendas in dadosVendas | orderBy:'sortKey':reverse | itemsPerPage:10" ng-click="ConsultaVenda(vendas)" ng-blur="LimpaItens()" ng-class="vendas.vd_nf != 0 ? 'NF': ''">
												<td style="text-align: left;" ng-bind="vendas.vd_doc"></td>
												<td style="text-align: left;" ng-bind="vendas.vd_emis | date:'dd/MM/yyyy'"></td>
												<td style="text-align: left;" ng-bind="vendas.vd_hora"></td>
												<td style="max-width: 180px;" ng-bind="vendas.vd_nome" class="d-inline-block text-truncate"></td>
												<td style="text-align: center;" ng-bind="vendas.em_fanta"></td>
												<td style="text-align: right;" ng-bind="vendas.vd_total | currency:'R$ '"></td>
											</tr >
										</tbody>
									</table>
								</div>

							    <div class="table-responsive col-5 px-0" style="overflow: auto; background-color: white; border-left: 8px #999999FF solid;">
									<table class="table table-sm table-striped" style="background-color: white; color: black; width: 100%; border-left: 1px solid #E5E5E5FF;">
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('vdi_prod')">Cód</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('vdi_descricao')">Descrição</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('vdi_valprod')">Original</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('vdi_quant')">Qtde</th>
												<th scope="col" style="font-weight: normal; text-align: right;">Desconto</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('vdi_preco')">Unit</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('vdi_total')">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="itens in itensVenda | orderBy:'sortKey':reverse" >
												<td ng-bind="itens.vdi_prod" ></td>
												<td style="max-width: 180px;" ng-bind="itens.vdi_descricao" class="d-inline-block text-truncate"></td>
												<td style="text-align: right;" ng-bind="itens.vdi_valprod | currency:''" ></td>
												<td style="text-align: right;" ng-bind="itens.vdi_quant | number" ></td>
												<td style="text-align: right;"> {{(100-((itens.vdi_preco - itens.vdi_valdescto) / itens.vdi_valprod * 100))| number:1}} %</td>
												<td style="text-align: right;" ng-bind="(itens.vdi_preco - itens.vdi_valdescto) | currency:''" ></td>

												<td style="text-align: right;" ng-bind="(itens.vdi_preco - itens.vdi_valdescto)*itens.vdi_quant | currency:''" ></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="container col-12 p-2" style="border:none; background-color: #999999FF;" ng-repeat="totais in totaisVendas">
							<div class="row align-items-center">
						    	<div class="col-2" style="text-align: left;">
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Registros: <b>{{dadosVendas.length}}</b></span>
							    	</div>
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Ticket Médio: <b>{{totais.total / dadosVendas.length  | currency:'R$ '}}</b></span>
							    	</div>
									<div class="row justify-content-start" ng-repeat="custo in calcularCusto" ng-if="VerCustoMedio">
							    		<span style="color: #303030FF;">Custo Médio: <b>{{custo.custo / dadosVendas.length | currency:'R$ '}}</b></span>
							    	</div>
								</div>
								<div class="col-2" >
									<div class="row justify-content-end">
							    		<span style="color: black;">Dinheiro: <b>{{totais.dinheiro | currency:'R$ '}}</b></span>
							    	</div>
									<div class="row justify-content-end">
							    		<span style="color: black;">Cartão: <b>{{totais.cartao | currency:'R$ '}}</b></span>
							    	</div>
									<div class="row justify-content-end">
							    		<span style="color: black;">Prazo: <b>{{totais.prazo | currency:'R$ '}}</b></span>
							    	</div>
								</div>
						    	<div class="col-6" style="text-align: left;">
						    		<h3 style="color: black;">Total: <b>{{totais.total | currency:'R$ '}}</b> <small> / </small><b style="color: #7F0000FF;">{{totais.totalred | currency:'R$ '}}</b></h3>
								</div>
						    	<div class="col-2" style="text-align: right;">
						    		<span style="color: #303030FF;">Itens <b>{{itensVenda.length}}</b></span>
								</div>
							</div>
						</div>	
						<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope mb-0"></dir-pagination-controls>
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
	<script src="js/dirPagination.js"></script>	
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/md-data-table.js"></script>

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

			$scope.total = 0;

		    $scope.tab = 1;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.cliente_fornecedor = 'pe_colaborador = "S" and pe_vendedor'
			$scope.dadosVendas = [];
			
			$scope.vendas=[{
				vd_id : '',
				vd_doc : '',
				vd_emis: '',
				vd_hora : '',
				vd_nf : '',
				vd_nome : '',
				vd_total : '',
				em_fanta : '',
			}];

			$scope.documento = '';
			$scope.VerCustoMedio = false;
			$scope.itensVenda = [];
			$scope.dadosColaborador = [];

			$scope.itens=[{
				vdi_prod : '',
				vdi_descricao: '',
				vdi_quant : '',
				vdi_preco : '',
				vdi_valprod : '',
				vdi_custo : '',	
				vdi_valdescto : '',	
				vdi_total : '',
			}];

			$scope.aguarde = false;
			$scope.automatizarBusca = true;
			$scope.funcionario = '';
			$scope.empresa = '';
			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();
    		$scope.situacao = 1;
			$scope.ativo = 'S';

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

    		$scope.EsperaBusca = function() {

			    $scope.aguarde = true;

    		}

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
			//        alert("idtreinoAluno");
				});
			};
<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

		    var totaisVendas = function (empresa, dataI, dataF, funcionario) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&totaisVendas=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario
				}).then(function onSuccess(response){
					$scope.totaisVendas=response.data.result[0];
			}).catch(function onError(response){
				});
			};

		    var calcularCusto = function (empresa, dataI, dataF, funcionario) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&calcularCusto=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario
				}).then(function onSuccess(response){
					$scope.calcularCusto=response.data.result[0];
			}).catch(function onError(response){
				});
			};

			var dadosColaborador = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosColaborador=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar colaboradores. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosColaborador();

			var dadosColaboradoresFiltro = function (empresa) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S&empresa='+empresa
				}).then(function onSuccess(response){
					$scope.dadosColaborador=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

		    var relatorioVendas = function (empresa, dataI, dataF, funcionario) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&dadosVendas=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario
				}).then(function onSuccess(response){
					$scope.dadosVendas=response.data.result[0];
					totaisVendas(empresa, dataI, dataF, funcionario);
					calcularCusto(empresa, dataI, dataF, funcionario);
				}).catch(function onError(response){
				});
			};

			//relatorioVendas();

			$scope.modificaBusca = function (empresa,dataI,dataF,funcionario) {
				$scope.empresa = empresa;
				$scope.dataI = dataI;
	    		$scope.dataF = dataF;	
				$scope.funcionario = '';
	    		dadosColaboradoresFiltro($scope.empresa);
	    		busca();
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
			relatorioVendas($scope.empresa, $scope.dataI, $scope.dataF, $scope.funcionario);
//			console.log(empresa + '-' + dataI + '-' + dataF + '-' );

			}

			$scope.buscaAutomatica = setInterval(busca, 30000);

			var pararBuscaAutom = function () {
				alert("busca");
				clearInterval(buscaAutomatica);
				
			}
		    
		    $scope.ConsultaVenda = function (vendas) {
		    	$scope.documento = vendas.vd_doc;
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&itensVenda=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI=1&dataF=1&vd_id='+vendas.vd_id
				}).then(function onSuccess(response){
					$scope.itensVenda=response.data.result[0];
				}).catch(function onError(response){
					alert("erro");
				});
			};

		    $scope.LimpaItens = function () {

				$scope.itensVenda='';
				$scoppe.documento='';
			};

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

		  }).config(function($mdDateLocaleProvider) {
		   		$mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out','Nov','Dez'];
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