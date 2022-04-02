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

	.alert{
		display: none;
	}

	.text-capitalize {
	  text-transform: capitalize; 
	}

	.md-fab:hover, .md-fab.md-focused {
	  background-color: #000 !important; 
	}

	p.note {
	  font-size: 1.2rem; 
	}

	.lock-size {
	  min-width: 300px;
	  min-height: 300px;
	  width: 300px;
	  height: 300px;
	  margin-left: auto;
	  margin-right: auto; 
	}

	md-content {
		color: rgba(255,255,255) !important;
		background-color: transparent !important;
	}
	md-tabs-canvas{
		background-color: rgba(0,0,0,0.6);
	}
	md-tabs .md-tab.md-active{
		color: rgb(255 255 255);
	}
	md-tabs .md-tab {
    	color: rgb(255 255 255 / 54%);
	}

	.vencendo {
		color: blue;
	}
    
	.quitada {
        color: #00008B;
		cursor: pointer;
    }

	.atrasado {
		color: red;
		cursor: pointer;
	}

	.faturado {
		color: black;
	}

	.aberta {
		color: green;
	}

</style>

			<div ng-controller="ZMProCtrl" >	 
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Faturamento</li>
						<li class="breadcrumb-item active" aria-current="page">Ordens de Serviço</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">
						<md-tabs md-dynamic-height md-border-bottom>
<?php
include 'pages/pageListarOS.php';
include 'pages/pageContasPagarOS.php';
include 'pages/pageContasReceberOS.php';
?>
						</md-tabs>
<?php
include 'Modal/ListaContasReceberOS.php';
?>

					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Page Content  -->

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
	<script src="js/angular-locale_pt-br.js"></script>

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

		    $scope.tab = 1;
			$scope.urlBase = 'services/'
			$scope.empresa = '';
			$scope.filtroNome = '';
			$scope.filtroPedido = '';
			$scope.buscaNome = '';
			$scope.buscaDocto = '';
			$scope.totalReceber = 0;
			$scope.fornecedor = '';
			$scope.quitado = 'N';
			$scope.cliente = '';
			$scope.dataI = '2000-01-01';
			$scope.dataF = '2120-12-31';
			$scope.dataH = dataHoje();
    		$scope.situacaoOS = '1';
			$scope.ativo = 'S';
			$scope.pageSize = 10;
			$scope.arrayNull = true;
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.pagination = {
		        current: 1
    		};

			$scope.ordenar = function(keyname){
		    	$scope.sortKey = keyname;
		    	$scope.reverse = !$scope.reverse;
		    };

		    $scope.verificaDados = function(){
		    	$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "*Campos Obrigatórios Devem Ser Preenchidos!"
				chamarAlerta();
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
		    
            var dadosEmpresa = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaCad.php?dadosEmpresa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>'
				}).then(function onSuccess(response){
					$scope.dadosEmpresa=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Erro ao carregar empresas. Caso este erro persista, contate o suporte."
					chamarAlerta();
				});
			};
<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			var dadosOS = function () {
				$scope.arrayNull = true;
				$scope.ordemServico = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcOrdemServico.php?listaOS=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&nome='+$scope.filtroNome+'&pedido='+$scope.filtroPedido+'&situacao='+$scope.situacaoOS
				}).then(function onSuccess(response){
					$scope.ordemServicoBruto=response.data.result[0];
					$scope.arrayNull = false;
					if ($scope.ordemServicoBruto == '') {
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhuma Ordem de Servico encontrada."
						chamarAlerta();
					} 
					verificaSituacao();
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Erro ao pesquisar Ordens de Serviço. Persistindo, consulte o Suporte."
					chamarAlerta();
				});
			};

			var verificaSituacao = function () {
				var situacaoSemFiltro = $scope.situacaoOS;
				var arraySemFiltro = $scope.ordemServicoBruto;
				if (situacaoSemFiltro == '1') {
					$scope.ordemServico = arraySemFiltro.filter(item => item.situacao == 'Aberta');
				} else if (situacaoSemFiltro == '2') {
					var arraySemFiltro2 = arraySemFiltro.filter(item => item.situacao == 'Fechada');
					$scope.ordemServico = arraySemFiltro2.filter(item => (item.bloq == null || item.bloq == ''));
				} else if (situacaoSemFiltro == '3') {
					var arraySemFiltro2 = arraySemFiltro.filter(item => item.situacao == 'Fechada');
					$scope.ordemServico = arraySemFiltro2.filter(item => (item.bloq != null && item.bloq != ''));
				} else if (situacaoSemFiltro == '4') {
					var arraySemFiltro2 = arraySemFiltro.filter(item => item.situacao == 'Fechada');
					$scope.ordemServico = arraySemFiltro2.filter(item => (item.quitado == 'N' && item.atrasado == 'SIM'));
				} else {
					$scope.ordemServico = arraySemFiltro;
				}
			}

			var dadosContasReceber = function () {
				$scope.totalReceberCliente = 0;
				$scope.contasReceberCliente = '';
				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcOrdemServico.php?listaContaReceber=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&fornecedor='+$scope.fornecedor
				}).then(function onSuccess(response){
					$scope.contasReceberCliente=response.data.result[0];
					$scope.totalReceberCliente = $scope.contasReceberCliente.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
					$('#contasReceberOS').modal('show');
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Erro ao pesquisar Conta a Receber. Persistindo, consulte o Suporte."
					chamarAlerta();
				});
			};

			$scope.modificaBusca = function (empresa, filtroNome, filtroPedido, situacaoOS, itensPagina){
				if (empresa == undefined || empresa == null) {empresa = '';}
				if (filtroNome == undefined || filtroNome == null) {filtroNome = '';}
				if (filtroPedido == undefined || filtroPedido == null) {filtroPedido = '';}
				if (situacaoOS == undefined || situacaoOS == null) {situacaoOS = '';}
				$scope.empresa = empresa;
	    		$scope.filtroNome = filtroNome;	
				$scope.filtroPedido = filtroPedido;	
				$scope.situacaoOS = situacaoOS;	
				$scope.pageSize = itensPagina;
	    		busca();
			}

			var busca = function(){
				/*alert("alguma");*/

				<?php if (base64_decode($empresa_acesso) != 0) {?>
					$scope.empresa = <?=$dados_usuario['us_empresa_acesso']?>;
				<?php }?>
				dadosOS();
			}

			busca();

			//$scope.buscaAutomatica = setInterval(busca, 60000);

			$scope.abrirConta = function (OS) {

				if (OS.os_cliente != undefined && OS.os_cliente != null && OS.os_cliente != '') {
					$scope.empresa = OS.os_empresa;
					$scope.fornecedor = OS.os_cliente;
					dadosContasReceber();
				} else {
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Erro ao pesquisar. Persistindo, consulte o Suporte."
					chamarAlerta();
				}

			}

			var restTotalContasPagar = function(){
				var arrayVencidos = $scope.contasPagar.filter(item => item.ct_vencto < $scope.dataI);
				$scope.valorVencido = arrayVencidos.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				var arrayHoje = $scope.contasPagar.filter(item => item.ct_vencto == $scope.dataI);
				$scope.valorHoje = arrayHoje.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				var arrayAVencer = $scope.contasPagar.filter(item => item.ct_vencto > $scope.dataI);
				$scope.valorAVencer = arrayAVencer.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);				
				// var arrayVencidos = $scope.contasPagar.filter(item => item.ct_vencto < $scope.dataI);
				// $scope.valorVencido = arrayVencidos.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				// var arrayHoje = $scope.contasPagar.filter(item => item.ct_vencto == $scope.dataI);
				// $scope.valorHoje = arrayHoje.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);
				// var arrayAVencer = $scope.contasPagar.filter(item => item.ct_vencto > $scope.dataI);
				// $scope.valorAVencer = arrayAVencer.reduce(function (accumulador, total) {return accumulador + parseFloat(total.ct_valor);}, 0);

			}

			var contasPagar = function (){
				$scope.arrayNull = true;
				$scope.contasPagar = [];
				//$scope.url_teste=$scope.urlBase+'srvcContaPagar.php?listaContasPagar=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&buscaNome='+$scope.buscaNome+'&buscaDocto='+$scope.buscaDocto;
				
						// $scope.arrayNull = false;			
						// $scope.tipoAlerta = "alert-info";
						// $scope.alertMsg = $scope.url_teste
						// chamarAlerta();

				$http({
					method:'GET',
					url: $scope.urlBase+'srvcContaPagar.php?listaContasPagar=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&buscaNome='+$scope.buscaNome+'&buscaDocto='+$scope.buscaDocto
				}).then(function onSuccess(response){
					$scope.contasPagar = response.data;
					if ($scope.contasPagar.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhuma Conta a Pagar encontrada."
						chamarAlerta();
					}
					$scope.arrayNull = false;
					restTotalContasPagar();
				}).catch(function onError(response){
					$scope.arrayNull = false;			
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Erro ao pesquisar Contas a Pagar. Caso persista, contate o suporte."
					chamarAlerta();
				});
			}

			contasPagar();

			$scope.contasPagarLista = function (empresafilial, fornecedor, documento, itensPagina){

				if (empresafilial == undefined || empresafilial == null) {empresafilial = '';}
				if (fornecedor == undefined || fornecedor == null) {fornecedor = '';}
				if (documento == undefined || documento == null) {documento = '';}

				$scope.empresa = empresafilial;
				$scope.buscaNome = fornecedor;
				$scope.buscaDocto = documento;
				$scope.pageSize = itensPagina;
				contasPagar();
			}

			var contasReceber = function (){
				$scope.contasReceber = '';
				$scope.arrayNull = true;
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&listaContaReceberFast=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+$scope.empresa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF+'&vencida=FALSE&cliente='+$scope.cliente+'&quitado=N'
				}).then(function onSuccess(response){
					$scope.contasReceber = response.data.result[0];
					if ($scope.contasReceber.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhuma resultado encontrado."
						chamarAlerta();
					}
					//restTotalContasReceber(dataI,dataF,empresafilial, cliente, canc);
					$scope.arrayNull = false;			
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlerta();

				});

			}
			contasReceber();

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

			$scope.contasReceberLista = function (empresafilial, cliente, itensPagina){
				if (empresafilial == undefined || empresafilial == null) {empresafilial = '';}
				if (cliente == undefined || cliente == null) {cliente = '';}
				$scope.empresa = empresafilial;
				$scope.cliente = cliente;
				$scope.pageSize = itensPagina;

				contasReceber();
				totalContaReceberFast();
			}


			$scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
			};
			
			$scope.mudaSituacaoOS = function(st) {
				$scope.situacaoOS = st;
			}

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
		   
        /*$(document).ready(function () {

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

        });*/

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