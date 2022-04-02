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

	.alert {
		display: none;
	}

	.text-capitalize {
  		text-transform: capitalize; 
	}

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;
		border: none !important;
	}
	.table th {
		cursor:pointer;
		background: black !important;
		border: none !important;
	}

	.table-responsive { 
		height:auto;  
		overflow:scroll;
		background-color:#ffffff;

	}

</style>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
                        <li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Despesas Fixas</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999 !important;">
				  {{alertMsg}}
				</div>

                <div class="row">
					<div class="col-lg-12 pt-0 px-2">

                        <div show-on-desktop>
                            <div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body p-2 m-0">
                                    <form id="formDespesas">
										<div class="form-row align-items-center" ng-init="empresa = '<?=base64_decode($empresa)?>'">
                                            <?php if (base64_decode($empresa_acesso) == 0) {?>
                                            <div class="form-group col-4">
                                                 <select class="form-control" ng-model="empresa" id="empresa">
                                                     <option ng-repeat="empr in dadosEmpresa" ng-value="empr.em_cod" >{{empr.em_fanta}} </option>
                                                </select>
                                            </div>
                                            <?php } else {
                                            echo $dados_empresa["em_fanta"];
                                            }?>
                                        </div>
                                    </form>

                                    <div class="table-responsive px-0" style="overflow-y:hidden; overflow-x:hidden; background-color: #FFFFFFFF !important; color: black; border:none; height:420px !important;">
                                        <table class="table table-striped" style="background-color: #FFFFFFFF !important; color: black; border:none;">
                                            <thead class="thead-dark" style="font-weight: normal !important;">
                                                <tr>
                                                    <th scope="col" style="text-align: left;">Código</th>
                                                    <th scope="col" style="text-align: left;">Empresa</th> 
                                                    <th scope="col" style="text-align: left;">Descrição Despesa</th>
													<th scope="col" style="text-align: right;">Ativo</th>
													<th scope="col" style="text-align: center;">Ação</th>													
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="custo in dadosCustosFixos | filter:{cf_empresa:empresa}" >
                                                    <td style="text-align: left; " ng-bind="custo.cf_id"></td>
                                                    <td style="text-align: left;" ng-bind="custo.em_fanta" class="d-inline-block text-truncate"></td>
                                                    <td style="text-align: left;" ng-bind="custo.cf_nome" ></td>
													<td style="text-align: right;" ng-bind="custo.cf_ativo" ></td>
													<td style="text-align: center;">
														<div class="btn-group dropleft">
<?php

include 'Modal/estoque/confirmaExclusaoCustoFixo.php'; 

?>															
															<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(custo)">
																<i class="fas fa-trash"></i> 
															</button>
														</div>
													</td>
	                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
 
                                <div class="card-footer p-2">
                                    <div class="form-row align-items-center">
                                         <div class="col-12" style="text-align: right;">
                                            <span style="color: grey;">Registros: <b>{{dadosCustosFixos.length}}</b></span>
                                        </div>
                                    </div>
								</div>

								<div class="modal fade" id="modalSelectHistotico" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 style="color: black !important;" class="modal-title" >Escolha o Histórico da Despesa Fixa</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body" ng-init="historico = ''">
												<label style="color: black !important;">Histórico da Despesa</label>
												<select class="form-control" ng-model="historico" id="historico">
													<option value="">Selecione</option>
													<option ng-repeat="historico in dadosHistorico" ng-value="{{historico.ht_id}}">{{historico.ht_descricao}} </option>
												</select>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
												<button type="button" class="btn btn-primary" ng-if="historico != '' && historico != undefined" data-dismiss="modal" ng-click="salvaTipoDespesa(empresa, historico)">Salvar</button>
											</div>
										</div>
									</div>
								</div>
                            </div>
						</div>

<!--							<div show-on-mobile>
							<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
								<div class="card-body p-2 m-0">
									<form id="formProd">
										<div class="form-row">
											<div class="form-group col-12 input-group">
												<input autofocus type="text" class="form-control form-control-sm" id="codProd" ng-model="formProd.codProd" placeholder="Informe o Código do Produto" ng-blur="pesquisaProduto(formProd.codProd)" onKeyUp="tabenter(event,getElementById('btnIncluir'))" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="pesquisaProduto(formProd.codProd)" style="color: white; border: none">
														<i class="fas fa fa-plus" ></i>
													</button>
												</div>
											</div>
										</div>
									</form>

									<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; border:none">
										<thead class="thead-dark pt-0" style="font-weight: normal !important; font-size: 0.9em !important;">
											<tr>
												<th scope="col" style="text-align: left;">Código</th>
												<th scope="col" style="text-align: center;">Descrição</th>
												<th scope="col" style="text-align: right;">Quant</th>
												<th scope="col" style="text-align: right;"></th>
											</tr>
										</thead>
										<tbody style="font-weight: normal !important; font-size: 0.9em !important;">
											<tr ng-repeat="produto in produtoLista | orderBy:reverse:true">
												<td style="text-align: left;" ng-bind="produto.cei_prod"></td>
												<td style="text-align: center; max-width: 250px;" class="d-inline-block text-truncate" ng-bind="produto.cei_desc"></td>
												<td style="text-align: right;" ng-bind="produto.cei_qntcontado"></td>
												<td style="text-align: right;">
													<div>
<?php

//include 'Modal/estoque/confirmaExclusao.php'; 

?>															
														<button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="abrirModalExclusao(produto)">
															<i class="fas fa-trash"></i> 
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<md-button class="md-fab md-fab-bottom-left color-default-btn" ng-if="produtoLista[0].cei_prod != undefined" ng-click="LimparTela()" style="position: fixed; z-index: 999; background-color:red;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Cancelar</md-tooltip>
									<i class="fas fa-window-close"></i>
								</md-button>
								<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-if="produtoLista[0].cei_prod != undefined" ng-click="lancarArray()"  style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Salvar</md-tooltip>
									<i class="fas fa-save"></i>
								</md-button>
							</div>
						</div>-->

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
	<script src="js/angular-locale_pt-br.js"></script>


    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ordem = 0;
			$scope.urlBase = 'services/';
			$scope.qtde = 1;
			$scope.empresaSelecionada = <?=base64_decode($empresa)?>;
			$scope.historicoSelecionado = '';
			$scope.lancar = false;
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
 			$scope.empresaAcesso = <?=base64_decode($empresa_acesso)?>;	
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

			$scope.mudarStatus = function(){
				$scope.lancar = true;
		    };

            $scope.setTab = function(newTab){
			    $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		    	return $scope.tab === tabNum;
		    };

		    $scope.alteraEmpresa = function(empr){
		    	$scope.empresaSelecionada = empr;
		    };

		    $scope.selecionaHistorico = function(hist){
		    	$scope.historicoSelecionado = hist;
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
                var dia = '01';
                var mes = data.getMonth()+1;
                var ano = data.getFullYear();
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
                });
			};

			var carregaDados = function () {

                $http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcDespesasFixas.php?historico=S&token=<?=$token?>'
                }).then(function onSuccess(response){
					$scope.dadosHistorico=response.data.result[0];
				}).catch(function onError(response){
                    $scope.resultado=response.data;
                    alert("Erro ao carregar Historico. Caso este erro persista, contate o suporte.");
                });
			};
			
			var carregaCustoFixo = function () {

				$http({
					method: 'GET',
					url: $scope.urlBase+'srvcDespesasFixas.php?custos=S&token=<?=$token?>'
				}).then(function onSuccess(response){
					$scope.dadosCustosFixos=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar Historico. Caso este erro persista, contate o suporte.");
				});
			};

			dadosEmpresa();
			carregaDados();
			carregaCustoFixo();

            $scope.salvaTipoDespesa = function (empresa, ht_id) {

                $http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcDespesasFixas.php?salvar=S&empresa='+empresa+'&ht_id='+ht_id
 				}).then(function onSuccess(response){
					
					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Cadastro Inserido Com Sucesso";
					chamarAlerta();

				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Erro ao inserir Cadastro!";
					chamarAlerta();
				});

			}

			$scope.excluirItem = function (item) {
				      
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'srvcDespesasFixas.php?excluir=S&cf_id='+item
 				}).then(function onSuccess(response){
					
					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Cadastro Excluido Com Sucesso";
					chamarAlerta();

				}).catch(function onError(response){
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Erro ao inserir Cadastro!";
					chamarAlerta();
				});

			}


			$scope.abrirModalExclusao = function (custo) {
				      
				$('#modalExclusaoCusto').modal('show');
							
			}

			$scope.abrirModalHistorico = function (empresa) {
				      
				$('#modalSelectHistotico').modal('show');

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

	    $(document).ready(function () {
	        $("#sidebar").mCustomScrollbar({
	            theme: "minimal"
	        });

	        $('#sidebarCollapse').on('click', function () {
	            $('#sidebar, #content').toggleClass('active');
	            $('.collapse.in').toggleClass('in');
	            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
			});

			$(this).find('#codProd').focus();

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