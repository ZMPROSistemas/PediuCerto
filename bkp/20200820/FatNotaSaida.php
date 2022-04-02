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

</style>

			<div ng-controller="ZMProCtrl" ng-init="modificaBusca(empresa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">	 
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Faturamento</li>
						<li class="breadcrumb-item active" aria-current="page">Notas de Saída</li>
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
								<div class="col-6 pl-2"><span style="color:black;"><b>Notas de Vendas</b></span></div>
								<div class="col-6 pl-2"><span style="color:black;"><b>Itens da Nota: {{documento}}</b></span></div>
							</div>
						</div>
					    <div class="card col-12 p-0" style="border:none; background-color: #999999FF;">
					    	<div class="row">
							    <div class="table-responsive col-6 px-0" style="overflow: hidden; background-color: white;">
									<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nf_nf')">Nota</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nf_modelo')">Modelo</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nf_emis')">Emissão</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nf_clraz')">Cliente</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('nf_natop')">CFOP</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('nf_totnf')">Total</th>
												<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('nf_es')">E/S</th>
											</tr>
										</thead>
										<tbody>
											<tr dir-paginate="nota in dadosNota | orderBy:'sortKey':reverse | itemsPerPage:10" ng-click="ConsultaNotaSaida(nota)" >
												<td style="text-align: left;" ng-bind="nota.nf_nf"></td>
												<td style="text-align: left;" ng-bind="nota.nf_modelo"></td>
												<td style="text-align: left;" ng-bind="nota.nf_emis | date:'dd/MM/yyyy'" ></td>
												<td style="text-align: left;max-width: 180px;" ng-bind="nota.nf_clraz" class="d-inline-block text-truncate"></td>
												<td style="text-align: right;" ng-bind="nota.nf_natop"></td>
												<td style="text-align: right;" ng-bind="nota.nf_totnf | currency: 'R$ '"></td>
												<td style="text-align: center;" ng-bind="nota.nf_es"></td>
											</tr>
										</tbody>
									</table>
								</div>

							    <div class="table-responsive col-6 px-0" style="overflow: auto; background-color: white; border-left: 8px #999999FF solid;">
									<table class="table table-sm table-striped" style="background-color: white; color: black; width: 100%; border-left: 1px solid #E5E5E5FF;" >
										<thead class="thead-dark">
											<tr style="font-size: 1em !important;">
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nfi_prod')">Cód</th>
												<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('nfi_desc')">Descrição</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('nfi_quant')">Qtde</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('nfi_preco')">Unitário</th>
												<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('nfi_total')">Total</th>
											</tr>
										</thead>
										<tbody ng-init="itens_somados = 0">
											<tr ng-repeat="itens in itensNota | orderBy:'sortKey':reverse" >
												<td style="text-align: left;" ng-bind="itens.nfi_prod" ></td>
												<td style="text-align: left;" ng-bind="itens.nfi_desc" class="d-inline-block text-truncate"></td>
												<td style="text-align: right;" ng-bind="itens.nfi_quant | number" ></td>
												<td style="text-align: right;" ng-bind="itens.nfi_valor | currency:' '" ></td>
												<td style="text-align: right;" ng-bind="itens.nfi_total | currency:'R$ '" ></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="container col-12 p-2" style="border:none; background-color: #999999FF;">
							<div class="row align-items-center">
						    	<div class="col-6" style="text-align: left;">
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Registros: <b>{{dadosNota.length}}</b></span>
							    	</div>
								</div>
						    	<div class="col-6" style="text-align: center;">
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Protocolo: <b>{{tipodocto}}</b></span>
							    	</div>
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Chave NF-E: <b>{{chaveNFe}}</b></span>
							    	</div>
									<div class="row justify-content-start">
							    		<span style="color: #303030FF;">Itens: <b>{{somaQtd}}</b></span>
							    	</div>
								</div>
							</div>
						</div>
						<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
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
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
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
			$scope.itens_somados = '';
			$scope.documento = '';
			$scope.tipodocto = '';
			$scope.chaveNFe = '';
			$scope.somaQtd = '';
			$scope.dinheiro = false;
		    $scope.tab = 1;
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.itensNota = [];
			$scope.dadosNota = [];
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


		    var relatorioNotasSaida = function (empresa, dataI, dataF) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?relatorio=S&dadosNotaSaida=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF
				}).then(function onSuccess(response){
					$scope.dadosNota=response.data.result[0];
			}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar notas. Caso este erro persista, contate o suporte.");
				});
			};

			//relatorioVendas();

			$scope.modificaBusca = function (empresa ,dataI, dataF){
				$scope.empresa = empresa;
				$scope.dataI = dataI;
	    		$scope.dataF = dataF;	
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
			relatorioNotasSaida($scope.empresa, $scope.dataI, $scope.dataF);
//			console.log(empresa + '-' + dataI + '-' + dataF + '-' );

			}

			/*var buscaAutomatica = setInterval(busca, 6000);

			/*$scope.buscaAutom = function() {
				if automatizarBusca == false {
					clearInterval(buscaAutomatica);
				}
			}*/
		    
		    $scope.ConsultaNotaSaida = function (nota) {
				$scope.tipodocto = nota.nf_prot_uso;
		    	$scope.chaveNFe = nota.nf_chavenfe;
		    	$scope.documento = nota.nf_nf;
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaNota.php?relatorio=S&itensNotaSaida=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI=1&dataF=1&nf_id='+nota.nf_id
				}).then(function onSuccess(response){
					$scope.itensNota=response.data.result[0];
					SomaQtdeItens();	
				}).catch(function onError(response){
					alert("Erro ao consultar nota.");
				});
			};

	    	var SomaQtdeItens = function(){

	    		$scope.somaQtd = $scope.itensNota.reduce(function (accumulador, total) {return accumulador + parseFloat(total.nfi_quant);}, 0);
		    
		    }


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