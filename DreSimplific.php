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

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}

	.table-responsive { 
		height:370px;  
		overflow:scroll;
		background-color:#ffffff;
	}

</style>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">DRE Simplificada</li>
					</ol>
				</nav>
				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">
					    	<div class="row bg-dark p-2 col-12" >
					    		<form class="col-6">
									<div class="form-row align-items-center">
	<?php if (base64_decode($empresa_acesso) == 0) {?>
										<div class="col-6">
											<select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="modificaBusca(empresa)">
												<option value="">Selecione a Empresa</option>
												<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
											</select>
										</div>
	<?php } else {
	echo $dados_empresa["em_fanta"];
	}?>
								    </div>
						   		</form>
						   	</div>
							<div class="table-responsive px-0" style="overflow: hidden;" ng-if="empresa != ''">
								<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1em !important;">
											<th scope="col" style=" font-weight: normal; text-align: left;">Descrição</th>
											<th scope="col" style=" font-weight: normal; text-align: left;" >Entrada</th>
											<th scope="col" style=" font-weight: normal; text-align: left;">Saída</th>
											<th scope="col" style=" font-weight: normal; text-align: right;" >Saldo</th>
											<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr style=" font-weight: bold; text-align: left;font-size: 1.1em !important;">
											<td>Receitas</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr style=" font-weight: normal; font-size: 1em !important;">
											<td style="text-align: center;">Vendas no mês</td>
											<td>{{totaisVendas[0].total | currency: 'R$ '}}</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr style=" font-weight: bold; text-align: left;font-size: 1.1em !important;">
											<td>Custos Fixos</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr style="font-weight: normal; font-size: 1em !important;" ng-repeat="desp in despesasFixas" >
											<td style="text-align: right;" ng-bind="desp.cf_nome"></td>
											<td></td>
											<td style="text-align: right;" ng-bind="desp.cf_valor | currency:'R$ '"></td>
											<td></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
													
														<a class="dropdown-item" ng-click="">Visualizar</a>
	<?php if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item"  ng-click="">Editar</a>
	<?php } ?>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="">Excluir</a>
	<?php }?>
					                                </div>
					                            </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- Final Desktop -->
							<div class="container col-12 p-2" style="border:none; background-color: #999999FF;">
								<div class="row align-items-center">
							    	<div class="col-4" style="text-align: left;">
										<div class="row justify-content-start">
								    		<span style="color: #303030FF;">Consolidação: <b>{{dadosProdutos.length}}</b></span>
								    	</div>
									</div>
								</div>
							</div>	
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							<md-button class="md-fab md-fab-bottom-right color-default-btn" style="position: fixed; z-index: 999; background-color:#279B2D;" ng-if="empresa != ''" ng-click="abrirModalCusto()">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
                      			<i class="fa fa-plus"></i>
    	                	</md-button>

							<div class="modal fade" id="ModalCadCusto" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" ng-init="cf_historico = ''">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 style="color:black;" class="modal-title" id="TituloModalCentralizado">Cadastrar Custo Fixo</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<select class="form-control form-control-sm" id="historico" ng-model="cf_historico">
												<option value="">Selecione o Histórico</option>
												<option ng-repeat="dados in dadosHistorico | filter: {ht_dc:'D'}" ng-value="dados.ht_id">{{dados.ht_descricao}} </option>
											</select>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											<button type="button" class="btn btn-primary" ng-if="cf_historico != ''" ng-click="salvarCustoFixo(empresa, cf_historico)" data-dismiss="modal">Salvar</button>
										</div>
									</div>
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
	<script src="js/jquery.mask.min.js"></script>
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/material-components-web.min.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.empresa = '';
			$scope.urlBase = 'services/';
    		$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";
			$scope.dataI = dataInicial();
			$scope.dataF = dataHoje();
			$scope.funcionario = '';

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
	            data.setDate(data.getDate());
	            var dia = 1;
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

		    $scope.abrirModalCusto = function () {
//		    	$('#formConta').get(0).reset();
			    $('#ModalCadCusto').modal('show');
				dadosHistorico();
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

			$scope.salvarCustoFixo = function(empresa, dados){
	            $http({
	                method: 'GET',
	                url: $scope.urlBase + 'totais_venda.php?salvar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa='+empresa+'&cf_nome='+dados+'&cf_historico='+dados
	            }).then(function onSuccess(response){
	                
	                if (response.data <= 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Cadastro Não Pode Ser Atualizado";
						chamarAlerta();
					}

					else if(response.data >= 1){
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
						chamarAlerta();
	                }
	            }).catch(function onError(response){

				});
				window.location.reload();

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
				});
			};

<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			$scope.modificaBusca = function (empresa){
				$scope.empresa = empresa;
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
				totaisVendas($scope.empresa, $scope.dataI, $scope.dataF, $scope.funcionario);
				despesasFixas($scope.empresa);

			}

		    var totaisVendas = function (empresa, dataI, dataF, funcionario) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'totais_venda.php?relatorio=S&totaisVendas=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario
				}).then(function onSuccess(response){
					$scope.totaisVendas=response.data.result[0];
			}).catch(function onError(response){
				});
			};

		    var despesasFixas = function (empresa) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'totais_venda.php?relatorio=S&despesasFixas=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa
				}).then(function onSuccess(response){
					$scope.despesasFixas=response.data.result[0];
			}).catch(function onError(response){
				});
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

		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		});


		function tabenter(event,campo){
			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.focus();
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

	</script>


</body>
</html>