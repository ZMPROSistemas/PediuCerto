<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
//include 'services/caixas.php';
setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

?>
<style>

	#tabela{display: none;}
	#tabela2{display: none;}

</style>

			<div ng-controller="ZMProCtrl">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Movimento de Caixa</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>
				
				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">
						<div show-on-desktop>

							<div ng-if="lista">
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0 py-2">
											<div class="form-row">
	
												<div class="col-auto ml-2">
                                        			<label>Filtrar</label>
												</div>

<?php if (base64_decode($empresa_acesso) == 0) {?>
												<div class="col-2">
													<select class="form-control form-control-sm capoTexto" id="empresa" ng-model="empresa" value="">
														<option value="">Todas as Empresas</option>
														<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
													</select>
												</div>
									<?php } else {
	echo utf8_encode($dados_empresa["em_fanta"]);
}?>
												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-right py-0 my-0" style="border: none;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Criar Caixa</md-tooltip>
														<i class="fas fa-wallet"></i> Novo Caixa
													</md-button>
												</div>

								    		</div>
										</form>

										<div class="table-responsive p-0"  style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important; font-weight: normal;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Empresa</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Caixa</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Situação</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Data</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
													</tr>
												</thead>
												<tbody style="line-height: 2em; margin:0px; padding:0px;">
													<tr ng-repeat="caixa in caixas | filter:{bc_empresa:empresa}">
														<td style="text-align: left;">{{caixa.em_fanta}}</td>
														<td style="text-align: left;">{{caixa.bc_descricao}}</td>
														<td style="text-align: left;">{{caixa.bc_situacao}}</td>
														<td style="text-align: center;">{{caixa.bc_data | date:'dd/MM/yyyy'}}</td>
														<td style="text-align: center;">
															<!-- EM 27/08/2020 FOI PEDIDO POR MICHEL PARA BLOQUEAR A CRIAÇÃO, ABERTURA E FECHAMENTO DE CAIXA PELA WEB -->
															<!-- EM 19/10/2020 FOI PEDIDO POR MICHEL PARA CRIAR A PARTE DE MOVIMENTAÇÃO DE CAIXA E BANCÁRIA (CAIXA E BANCOS) -->
															<!-- EM 10/11/2020 FOI PEDIDO POR MICHEL E ROGER PARA ALTERAR A FORMA COMO SÃO EXIBIDAS AS MOVIMENTAÇÕES DE CAIXA (USAR A FORMA ANTERIOR) -->
															<md-menu>
																<md-button ng-click="$mdOpenMenu()" class="md-icon-button md-mini pull-right m-0 p-0">
																	<i class="fas fa-ellipsis-v m-0 p-0"></i> 
																</md-button>
																<md-menu-content class="dropdown" >
																	<md-menu-item >
																	<?php if (substr($me_caixa_ab, 0,1) == 'S') {?>
																		<md-button ng-click="verificaCaixa(caixa, 'A')" ng-if="caixa.bc_situacao == 'ABERTO'">Lançamento Aberto</md-button>
																	<?php } ?>
																	</md-menu-item>
																	<md-menu-item >
																	<?php if (substr($me_caixa_fc, 0,1) == 'S') {?>
																		<md-button data-toggle="modal" data-target="#modalPeriodoPesquisa" ng-click="setarLinha(caixa)">Lançamento Fechado</md-button>
																	<?php } ?>
																	</md-menu-item>
																</md-menu-content>
															</md-menu>
															<div class="modal fade bd-example-modal-sm" id="modalPeriodoPesquisa" tabindex="-1" role="dialog" aria-labelledby="TituloModalPeriodoPesquisa" aria-hidden="true">
																<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
																	<div class="modal-content">
																		<div class="modal-header py-1">
																			<h5 class="modal-title" style="color: black !important;" id="TituloModalPeriodoPesquisa">Período</h5>
																		</div>
																		<div class="modal-body" >
																			<span style="color: black !important;">Informe o período a ser pesquisado</span>
																			<input date-range-picker id="daterange2" name="daterange2" class="form-control text-center date-picker" type="text"	min="'2001-01-01'" max="'2100-12-31'" ng-model="date" required/>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-primary"  data-dismiss="modal" ng-click="verificaCaixa(date, 'F')">Pesquisar</button>
																		</div>
																	</div>
																</div>
															</div>
															<!--div class="btn-group dropleft">
																<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
																	<i class="fas fa-ellipsis-v"></i>
																</button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" ng-click="abrirCaixa(caixa.bc_descricao, caixa.bc_id)" ng-if="caixa.bc_situacao == 'Fechado'">Abrir</a>
																	<a class="dropdown-item"  ng-click="loguin('F')" ng-if="caixa.bc_situacao == 'Aberto'">Fechar</a-->
																	<!--a class="dropdown-item"  ng-click="loguin('M')" ng-if="caixa.bc_situacao == 'Aberto'">Movimentar</a>
							<?php if (substr($me_caixa_ab, 0,1) == 'S') {?>
																	<a class="dropdown-item"  ng-if="caixa.bc_situacao == 'Aberto'">Lançamento aberto</a>
							<?php
								}
								if (substr($me_caixa_fc, 0,1) == 'S') {
							?>
																	<a class="dropdown-item" ng-click="verificaCaixa(caixa, 'F')">Lançamento Fechado</a>
							<?php } ?>
																	<a class="dropdown-item"  ng-click="loguin('V')">Verificar Caixa</a>
																</div-->
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div ng-if="fichaCxAberto">
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); "> 
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0 pt-1">
											<div class="form-row">
												<div class="form-group col-2">
													<label for="empresa">Empresa</label>
													<input type="text" class="form-control form-control-sm" id="empresa" ng-model="nomeEmpresa" disabled>
												</div>
	
												<div class="form-group col-2">
													<label for="nomecaixa">Nome do Caixa</label>
													<input type="text" class="form-control form-control-sm text-left" id="nomecaixa" ng-model="nomeCaixa" disabled>
												</div>
	
												<div class="form-group col-2">
													<label for="situacao">Situação</label>
													<input type="text" class="form-control form-control-sm" id="situacao" value="Aberto" disabled>
												</div>

												<div class="ml-auto m-0 p-0">
													<div class="form-row align-items-botton">
														<md-button class="btnImprimir pull-right py-0 my-0" style="border: none;" ng-disabled="!movCaixas[0] || arrayNull" ng-click="print()">
															<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
															<i class="fas fa-print"></i> Imprimir
														</md-button>
													</div>
												</div>
											</div>
										</form>

										<div class="table-responsive p-0"  style="overflow: hidden; font-size: 1em !important; ">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-weight: normal;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Documento</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Emissão</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Histórico</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Observações</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">D/C</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Tipo Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Descrição</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="caixa in movCaixas | orderBy:'sortKey':reverse | itemsPerPage:pageSize">
														<td style="text-align: left;" ng-bind="caixa.cx_docto"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_emissao | date:'dd/MM/yyyy'"></td>
														<td style="text-align: left;" ng-bind="caixa.ht_descricao"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_obs"></td>
														<td style="text-align: center;" ng-bind="caixa.cx_dc"></td>
														<td style="text-align: center;" ng-bind="caixa.dc_sigla"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_nome"></td>
														<td style="text-align: right;" ng-bind="caixa.cx_valor | currency: 'R$ '"></td>
													</tr>
												</tbody>
											</table>
												
											<div ng-if="arrayNull == true">
												<div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
													Aguarde... Pesquisando!
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer m-0 p-0 pb-2">
										<div class="form-row align-items-center">
											<div class="col-6 p-0" style="text-align: left;">
												<md-button class="btnCancelar pull-left py-0 my-0" style="border: none;"  ng-click="limparMovCaixas()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Voltar aos Caixas</md-tooltip>
													<i class="fas fa-arrow-circle-left"></i> Voltar
												</md-button>
											</div>
											<div class="col-6" style="text-align: right;">
												<span style="color: gray;">Registros: <b>{{movCaixas.length}}</b></span>
											</div>
										</div>
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							</div>

							<div ng-if="fichaCxFechado">
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); "> 
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0">
											<div class="form-row">
												<div class="form-group col-2">
													<label for="empresa">Empresa</label>
													<input type="text" class="form-control form-control-sm" id="empresa" ng-model="nomeEmpresa" disabled>
												</div>
	
												<div class="form-group col-2">
													<label for="caixa">Nome do Caixa</label>
													<input type="text" class="form-control form-control-sm text-left" id="nomecaixa" ng-model="nomeCaixa" disabled>
												</div>
	
												<div class="form-group col-2">
													<label for="situacao">Situação</label>
													<input type="text" class="form-control form-control-sm" id="situacao" value="Fechado" disabled>
												</div>

												<div class="form-group col-2">
													<label for="periodo">Período Selecionado</label>
													<input class="form-control form-control-sm text-center" type="text" ng-model="(dataI | date: 'dd/MM/yyyy') +' A '+ (dataF | date: 'dd/MM/yyyy')"  disabled/>
												</div>

												<div class="ml-auto m-0 p-0">
													<md-button class="btnImprimir pull-right" style="border: none;" ng-disabled="!movCaixas[0] || arrayNull" ng-click="print()">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
														<i class="fas fa-print"></i> Imprimir
													</md-button>
												</div>
											</div>
										</form>

										<div class="table-responsive p-0"  style="overflow: hidden; font-size: 0.9em !important; ">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-weight: normal;">
														<th scope="col" style=" font-weight: normal; text-align: left;">Documento</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Emissão</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Histórico</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Observações</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">D/C</th>
														<th scope="col" style=" font-weight: normal; text-align: center;">Tipo Docto</th>
														<th scope="col" style=" font-weight: normal; text-align: left;">Descrição</th>
														<th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
													</tr>
												</thead>
												<tbody>
													<tr dir-paginate="caixa in movCaixas | orderBy:'sortKey':reverse | itemsPerPage:pageSize">
														<td style="text-align: left;" ng-bind="caixa.cx_docto"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_emissao | date:'dd/MM/yyyy'"></td>
														<td style="text-align: left;" ng-bind="caixa.ht_descricao"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_obs"></td>
														<td style="text-align: center;" ng-bind="caixa.cx_dc"></td>
														<td style="text-align: center;" ng-bind="caixa.dc_sigla"></td>
														<td style="text-align: left;" ng-bind="caixa.cx_nome"></td>
														<td style="text-align: right;" ng-bind="caixa.cx_valor | currency: 'R$ '"></td>
													</tr>
												</tbody>
											</table>
												
											<div ng-if="arrayNull == true">
												<div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
													Aguarde... Pesquisando!
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer m-0 p-0 pb-2">
										<div class="form-row align-items-center">
											<div class="col-6 p-0" style="text-align: left;">
												<md-button class="btnCancelar pull-left py-0 my-0" style="border: none;"  ng-click="limparMovCaixas()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Voltar aos Caixas</md-tooltip>
													<i class="fas fa-arrow-circle-left"></i> Voltar
												</md-button>
											</div>
											<div class="col-6" style="text-align: right;">
												<div class="row justify-content-start">
													<span style="color: gray;">Soma Crédito: <b>{{totalCredito | currency: 'R$ '}}</b></span>
												</div>
												<div class="row justify-content-start">
													<span style="color: gray;">Soma Débito: <b>{{totalDebito | currency: 'R$ '}}</b></span>
												</div>
												<div class="row justify-content-start">
													<span style="color: gray;">Subtotal: <b>{{(totalCredito - totalDebito) | currency: 'R$ '}}</b></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							</div>
						</div>
                    </div>
				</div>
				
				<table id="tabela">
					<thead>
						<tr>
							<th>Docto</th>
							<th>Emissão</th>
							<th>Histórico</th>
							<th>Observações</th>
							<th>D/C</th>
							<th>Tipo Docto</th>
							<th>Descrição</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="caixa in movCaixas | orderBy:sortKey:reverse">
							<td>{{caixa.cx_docto}}</td>
							<td>{{caixa.cx_emissao | date:'dd/MM/yyyy'}}</td>
							<td>{{caixa.ht_descricao}}</td>
							<td>{{caixa.cx_obs}}</td>
							<td>{{caixa.cx_dc}}</td>
							<td>{{caixa.dc_sigla}}
							<td>{{caixa.cx_nome}}</td>
							<td>{{caixa.cx_valor | currency: 'R$ '}}</td>
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
	    					<td>Total Creditado</td>
	    					<td>{{totalCredito | currency: 'R$ '}}</td>
	    				</tr>
	    				<tr>
	    					<td>Total Debitado</td>
	    					<td>{{totalDebito | currency: 'R$ '}}</td>
	    				</tr>
	    				<tr>
	    					<td>Valor Final</td>
	    					<td>{{(totalCredito - totalDebito) | currency: 'R$ '}}</td>
	    				</tr>
						<tr>
	    					<td>Movimentações no Período</td>
	    					<td>{{movCaixas.length}}</td>
	    				</tr>
					</tbody>
				</table>

			</div>  
	    </div>
	</div>

	<script src="js/popper.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/dirPagination.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/moment-with-locales.min.js"></script>
	<script src="js/moment-pt-br.js"></script>
    <script src="js/daterangepicker.min.js"></script>
    <script src="js/angular-daterangepicker.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination','daterangepicker']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

			$scope.tab = 1;
			$scope.lista = true;
			$scope.fichaCxAberto = false;
			$scope.fichaCxFechado = false;
			$scope.caixa= '';
			$scope.nomeCaixa = '';
			$scope.pageSize = 20;
			$scope.totalCredito = 0;
			$scope.totalDebito = 0;
			$scope.somaCredito = 0;
			$scope.somaDebito = 0;
  			$scope.data = new Date();
  			$scope.urlBase = 'services/'
  			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
			$scope.empresa = '';
			$scope.nomeEmpresa = '';
			$scope.caixaSetado = '';
            $scope.dataI = dataInicial();
			$scope.dataF = dataHoje();
            $scope.totaisCaixas = '';
			$scope.arrayNull = false;

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
                data.setDate(data.getDate() );
                var dia = data.getDate();
                var mes = data.getMonth();
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

			$scope.date = {
				startDate: moment().subtract(1, "months"),
				endDate: moment()
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

			var caixas = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?listaCaixas=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa
				}).then(function onSuccess(response){
					$scope.caixas= response.data.result[0];
				}).catch(function onError(response){
					$scope.caixa = response.data;
				});
			};
<?php if (base64_decode($empresa_acesso) == 0) {?>
			caixas();
<?php }?>

			var listaMovCaixaAberto = function (){
				$scope.movCaixas = '';
				$scope.arrayNull = true;
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?movCaixaAberto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa
				}).then(function onSuccess(response){
                    $scope.movCaixas= response.data.result[0];
					if ($scope.movCaixas.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlerta();
					}
					var arrayCredito = $scope.movCaixas.filter(item => item.cx_dc == 'C');
					//alert(arrayCredito[0].cx_valor);
					var arrayDebito = $scope.movCaixas.filter(item => item.cx_dc == 'D');
					$scope.totalCredito = arrayCredito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
					$scope.totalDebito = arrayDebito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
					$scope.arrayNull = false;
                    //totaisMovCaixaAberto();
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.resultado = response.data;
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlerta();
				});
            };
            
            var listaMovCaixaFechado = function (){
				$scope.movCaixas = '';
				$scope.arrayNull = true;
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?movCaixaFechado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
                    $scope.movCaixas= response.data.result[0];
					if ($scope.movCaixas.length < 1){
						$scope.arrayNull = false;			
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Nenhum resultado encontrado."
						chamarAlerta();
					}
					var arrayCredito = $scope.movCaixas.filter(item => item.cx_dc == 'C');
					var arrayDebito = $scope.movCaixas.filter(item => item.cx_dc == 'D');
					$scope.totalCredito = arrayCredito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
					$scope.totalDebito = arrayDebito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
					$scope.arrayNull = false;			
                    //totaisMovCaixaFechado();
				}).catch(function onError(response){
					$scope.resultado = response.data;
					$scope.arrayNull = false;			
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Nenhum resultado encontrado."
					chamarAlerta();
				});
			};
			
			$scope.verificaCaixa = function (caixa, open) {

				if (open == 'A') {
					if (caixa.bc_id == undefined || caixa.bc_id == null || caixa.bc_id == ''){
						$scope.tipoAlerta = "alert-info";
						$scope.alertMsg = "Não foi possível realizar sua solicitação."
						chamarAlerta();
					} else {
					$scope.caixa = caixa.bc_codigo;
					$scope.nomeCaixa = caixa.bc_descricao;
					$scope.empresa = caixa.bc_empresa;
					$scope.nomeEmpresa = caixa.em_fanta;
					listaMovCaixaAberto();
					$scope.lista = false;
					$scope.fichaCxFechado = false;
					$scope.fichaCxAberto = true;
					}
				} else if (open == 'F') {
					$scope.dataI = caixa.startDate.format("YYYY-MM-DD");;
					$scope.dataF = caixa.endDate.format("YYYY-MM-DD");;
					$scope.caixa = $scope.caixaSetado.bc_codigo;
					$scope.nomeCaixa =  $scope.caixaSetado.bc_descricao;
					$scope.empresa = $scope.caixaSetado.bc_empresa;
					$scope.nomeEmpresa = $scope.caixaSetado.em_fanta;
					listaMovCaixaFechado();
					$scope.lista = false;
					$scope.fichaCxFechado = true;
					$scope.fichaCxAberto = false;
				}
			}

			$scope.setarLinha = function(caixa) {
				$scope.caixaSetado = caixa;
			}
            
			$scope.consultaCaixas = function (empresa) {
				$scope.limparMovCaixas();
				if (empresa == undefined || empresa == null || empresa == '') {
					$scope.empresa = '';
					$scope.limparMovCaixas();
					$scope.tipoAlerta = "alert-warning";
					$scope.alertMsg = "Você precisa escolher uma empresa.";
					chamarAlerta();
				} else {
					$scope.empresa = empresa;
					$http({
                        method:'GET',
                        url: $scope.urlBase + 'srvcMovCaixa.php?verificaCaixa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&situacao= '
                    }).then(function onSuccess(response){
                        $scope.caixasEmpresa= response.data.result[0];
                    }).catch(function onError(response){
                        $scope.resultado = response.data;
                    });
					
				}
			}

            $scope.verificaCaixas = function(empresa, open) {
				$scope.caixasAbertos = '';

                if (open == 'A') {
					//alert(open);
					$http({
                        method:'GET',
                        url: $scope.urlBase + 'srvcMovCaixa.php?verificaCaixa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&situacao='+open
                    }).then(function onSuccess(response){
                        $scope.caixasAbertos= response.data.result[0];
                    }).catch(function onError(response){
                        $scope.resultado = response.data;
                    });
				
				} else if (open == 'F') {
					$http({
                        method:'GET',
                        url: $scope.urlBase + 'srvcMovCaixa.php?verificaCaixa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&situacao='+open
                    }).then(function onSuccess(response){
                        $scope.caixasAbertos= response.data.result[0];
                    }).catch(function onError(response){
                        $scope.resultado = response.data;
                        $scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Não há caixas fechados no momento.";
						chamarAlerta();
                    });
				}
            }

            $scope.pesquisaCaixaAberto = function(empresa, nomeCaixa){
				//alert(nomeCaixa);

                if (empresa == undefined || empresa == null) {
                    $scope.empresa = '';
                } else {
                    $scope.empresa = empresa;
                }
                $scope.caixa = nomeCaixa;
                listaMovCaixaAberto();

            }

            $scope.pesquisaCaixaFechado = function(empresa, nomeCaixa, dataInicial, dataFinal){

                if (empresa == undefined || empresa == null) {
                    $scope.empresa = '';
                } else {
                    $scope.empresa = empresa;
                }
                $scope.caixa = nomeCaixa;
                $scope.dataI = dataInicial;
                $scope.dataF = dataFinal;
                listaMovCaixaFechado();

			}
			
			$scope.limparMovCaixas = function  () {
				window.location.reload();
			}

            $scope.print = function(){
				$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "Aguarde! Preparando Impressão..."
				chamarAlerta();
				gerarpdf($scope.dataI, $scope.dataF);

			}

		}).directive('ngEnter', function () {
			return function (scope, element, attrs) {
				element.bind("keydown keypress", function (event) {
					if(event.which === 13) {
						scope.$apply(function (){
							scope.$eval(attrs.ngEnter);
						});
						event.preventDefault();
					}
				});
			};

		 }).directive("moneyDir", function MoneyDir() {

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
		}).config(function($mdDateLocaleProvider) {
				$mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out', 'Nov', 'Dez'];
				$mdDateLocaleProvider.Months = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
				$mdDateLocaleProvider.days = ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta','Sexta', 'Sabado'];
				$mdDateLocaleProvider.shortDays = ['D', 'S', 'T', 'Q', 'Q','S','S'];
			
		});

		angular.bootstrap(document, ['ZMPro']);

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

			document.getElementById('empresa').selected();

		}

		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};
		

		function exportarCsv(){
			$("#tabela").tableHTMLExport({type:'csv',filename:'Movimento_Caixa.csv'});
		};

		function gerarpdf(dataI, dataF) {
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
<?php if (base64_decode($empresa_acesso) == 0) {?>
    		var empresa = document.getElementById('empresa').value;
<?php } else {?>
			var empresa = '<?=$dados_empresa["em_razao"]?>';
<?php }?>
			var empSelecionada = document.getElementById('empresa').value;
			//empSelecionada = empSelecionada.toUpperCase();
			var caixaSelecionado = document.getElementById('nomecaixa').value;
			var estadoCaixa = document.getElementById('situacao').value;
			var DataInicio = dataI;
    		var DataFim = dataF;
    		var arrData = DataInicio.split('-');
    		var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);
    		var arrDataF = DataFim.split('-');
    		var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);
			var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Movimento de Caixa", 85, 27);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
		        doc.setFontSize(9);
				doc.text("Empresa Selecionada: " + empSelecionada , 85, 40);
				doc.text("Caixa Selecionado: " + caixaSelecionado , 85, 51);
				//doc.text("Subgrupo: " + subgrupo , 85, 66);
				if (estadoCaixa == 'Fechado') {
					doc.text("Período: " + InicioPesquisa + " ATÉ " + FimPesquisa , 85, 62);
				}
			}
			
			doc.autoTable(data1.columns, data1.rows,{
				beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
				styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
				columnStyles: {
					0: {halign: 'left'}, 
					1: {halign: 'left'}, 
					2: {halign: 'left'},
					3: {halign: 'left'},
					4: {halign: 'center'},
					5: {halign: 'center'},
					6: {halign: 'left'},
					7: {halign: 'right'}},

				rowStyles: {1: {fontSize: (number = 11)}},
				tableLineColor: [189, 195, 199],
				tableLineWidth: 0.75,
				headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
				bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
				alternateRowStyles: {fillColor: [250, 250, 250]},

				drawRow: function (row, data) {
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
			if (estadoCaixa == 'Fechado') {
			
				var data2 = doc.autoTableHtmlToJson(document.getElementById("tabela2"));
				var rows = data2.rows;

				doc.autoTable(data2.columns, data2.rows, {
					startY: doc.autoTable.previous.finalY + 10,
					margin: {top: 80, right: 10, bottom: 20, left: 400},
					styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
					columnStyles: {0: {halign: 'left'}, 1: {halign: 'right'}},
					rowStyles: {1: {fontSize: (number = 11)}},
					tableLineColor: [189, 195, 199],
					tableLineWidth: 0.75,
					headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
					bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
					alternateRowStyles: {fillColor: [250, 250, 250]},
				});
			}
			//windows.print();
	   		window.open(doc.output('bloburl'),'_blank');
		}

	</script>

</body>
</html>