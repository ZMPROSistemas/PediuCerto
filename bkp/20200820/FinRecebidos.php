<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

?>
<style>
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

	.table-responsive{
		height:340px;  
		overflow:scroll;
		background-color:#ffffff;
	}

</style>
			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Contas Recebidas</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>
				
	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">
						
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
										<div class="col-2 ml-2">
											<select class="form-control form-control-sm" id="empresa" ng-model="cliente">
												<option value="">Todos as Clientes</option>
												<option ng-repeat="dadosCliente in dadosCliente" value="{{dadosCliente.pe_cod}}">{{dadosCliente.pe_nome}} </option>
											</select>
										</div>

										<!--div class="col-2 ml-2" ng-init="canc = 'N'">
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
								    	</div-->

								    	<div class="col-auto ml-1">
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
												<button type="button" class="btn btn-outline-dark btn-sm" ng-click="ContasRecebidas(dataI | date : 'yyyy-MM-dd', dataF | date : 'yyyy-MM-dd', empresa, cliente, canc)" style="color: white;">
													<i class="fas fa fa-search" ></i>
												</button>
											</div>
								    	</div>

								    </div>
								</form>
								
							</div>

							<div class="table-responsive px-0" style="overflow: auto;">

								<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1.1em !important;">
											
										<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')">Emp</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_docto')">Docto</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_parc')">Parcela</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_nome')">Nome Cliente</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_vencto')">Vencto.</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_vencto')">Valor</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_vencto')">Pagto.</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_valor')">Valor</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_tipdoc')">Tipo Docto</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vendedor')">Colaborador</th>
										</tr>
									</thead>
									<tbody>
									<tr dir-paginate="contasRecebidos in contasRecebidos | orderBy:'sortKey' | itemsPerPage:10">
										
									<td>{{contasRecebidos.em_fanta | limitTo:20}}{{contasRecebidos.em_fanta.length >= 20 ? '...' : ''}}</td>
											<td align="center">{{contasRecebidos.ct_docto}}</td>
											<td align="center">{{contasRecebidos.ct_parc}}</td>
											<td>{{contasRecebidos.ct_nome | limitTo:20}}{{contasRecebidos.ct_nome.length >= 20 ? '...' : ''}}</td>
											<td>{{contasRecebidos.ct_vencto | date : 'dd/MM/yyyy'}}</td>
											<td>{{contasRecebidos.ct_valor | currency: 'R$'}}</td>
											<td>{{contasRecebidos.ct_pagto | date : 'dd/MM/yyyy'}}</td>
											<td>{{contasRecebidos.ct_valorpago | currency: 'R$'}}</td>
											<td align="center">{{contasRecebidos.dc_sigla}}</td>
											<td>{{contasRecebidos.vendedor | limitTo:20}}{{contasRecebidos.vendedor.length >= 20 ? '...' : ''}}</td>

										</tr>
									</tbody>

								</table>

							</div>
							
							<div class="container col-12 p-2" style="border:none; background-color: #999999FF; color: black;">
								<div class="row align-items-center">
									<div class="col-3" style="text-align: left;">

										<span style="color: black;"> Total Recebido : </span>{{totalcontasRecebidos[0].ct_valorpago | currency: 'R$ '}}</span>
											
									</div>

								</div>
							</div>

							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							
						</div>
						
						<!--md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
		                      	<i class="fa fa-plus"></i>
    	                </md-button-->

					</div>

					<div ng-if="ficha">

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
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.urlBase = 'services/';
			$scope.contasRecebidos=[];
			$scope.dadosCliente=[];
			$scope.totalcontasRecebidos=[];

			$scope.dataHoje = new Date();

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
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
			$scope.cliente_fornecedor = 'pe_cliente';
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.empresafilial = ''; //undefined
			$scope.quitado = 'S';

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
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?receber_pagar=S&dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosCliente();

			var restTotalcontasRecebidos = function(dataI,dataF,empresafilial, cliente, canc){
				$http({
					method:'GET',
					url: $scope.urlBase+'contas.php?receber=S&totalContasReceber=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+empresafilial+'&cliente='+cliente+'&canc='+canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.totalcontasRecebidos = response.data.result[0];
				}).catch(function onError(response){

				});
			}

			var restcontasRecebidos = function (dataI,dataF,empresafilial, cliente, canc){
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
					url: $scope.urlBase+'contas.php?receber=S&listaContasReceber=S&token=<?=$token?>&empresa_matriz=<?=$empresa?>&empresa_filial='+empresafilial+'&cliente='+cliente+'&canc='+canc+'&us_id=<?=$us_id?>&dataI='+dataI+'&dataF='+dataF+'&quitado='+$scope.quitado
				}).then(function onSuccess(response){
					$scope.contasRecebidos = response.data.result[0];
					restTotalcontasRecebidos(dataI,dataF,empresafilial, cliente, canc);
				}).catch(function onError(response){

				});
			}

			restcontasRecebidos();

			$scope.ContasRecebidas = function (dataI,dataF,empresafilial, cliente, canc){

				restcontasRecebidos(dataI,dataF,empresafilial, cliente, canc);
			}

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
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

	</script>


</body>
</html>