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

	#tabela{display: none;}
	#tabela2{display: none;}
	.ordernar{cursor: pointer; margin-left: 15px;}
	th:focus{
		outline: none;
		background-color: #333 !important;
	}
	hr {
	  top: 15px;
	  clear: both;
	  width: 0;
	  height: 5px;
	  margin: 0 0 25px;
	  display: block;
	  position: relative;
	  background: rgb(26, 2, 175);
	}
	th:focus{
		outline: none;
	}
	

	@-webkit-keyframes progress {
	  to { width: 100%; }
	}
	@-moz-keyframes progress {
	  to { width: 100%; }
	}
	@keyframes progress {
	  to { width: 100%; }
	}

	@-webkit-keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}
	@-moz-keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}
	@keyframes blink {
	  50% { background: rgb(26, 226, 226); }
	}


	  @media print {}
	}



</style>

			<div ng-controller="ZMProCtrl" ng-init="busca(empresa,clientes,dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd')">
<!--
				<div show-on-mobile>
					<h2>Mobile</h2>
				</div>

				<div show-on-tablet>
					<h2>Tablet</h2>
				</div>

				<div show-on-laptop>
					<h2>Laptop</h2>
				</div>
<div show-on-desktop>-->

		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Relatório de Vendas</li>

						<!--<img src="data:image/jpeg;base64,<?=$logoEmp?>" alt="">-->

					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="top: 0; bottom: 0; left: 0; right: 0; margin: auto;  width: 150px; height: 100px; position: absolute; z-index: 999; align-items: center;">
				  {{alertMsg}} <i class="fas fa-file-alt" style="margin-left: 5px;"></i>
				  <!--<md-progress-linear md-mode="determinate" value="20"></md-progress-linear>-->

				  <hr style="{{progressClass}}"/>
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
					    	<div class="row bg-dark">
								<div class="form-group col-md-4 col-12 pt-3">

									<?php if (base64_decode($empresa_acesso) == 0) {?>

										<label for="empresas">Empresas</label>
										<select class="form-control form-control-sm capoTexto" id="empresa" ng-model="empresa" value="">
											<option value=""> Todas Empresas</option>
											<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
										</select>

									<?php } else {
										echo $dados_empresa["em_fanta"];
									}?>

						    	</div>

						    	<div class="form-group col-md-4 col-12 pt-3" ng-init="clientes = ''">
						    		<label for="cliente">Cliente</label>


						    		<select class="form-control form-control-sm capoTexto" id="cliente" ng-model="clientes" value="">
										<option value=""> Todos Cliente</option>
										<option ng-repeat="cli in dadosCliente | orderBy: 'pe_nome'" value="{{cli.pe_cod}}">{{cli.pe_nome}} </option>

									</select>

<!--
									<md-autocomplete md-no-cache="true" md-selected-item="selectedItem" md-items="cli in dadosCliente" md-search-text="searchText" md-item-text="cli.pe_nome"  md-escape-options="none" placeholder="Todos Os Clientes">
										<md-item-template>
									  		<span md-highlight-text="searchText" md-highlight-flags="^i">{{cli.pe_nome}}</span>
									  	</md-item-template>

									</md-autocomplete>

-->
						    	</div>

						    	<div class="form-group col-md-4 col-12 pt-3" ng-init="funcionario = ''">
						    		<label for="funcionario">Vendedores</label>

						    		<select class="form-control form-control-sm capoTexto" id="funcionario" ng-model="funcionario" value="" ng-disabled="empresa == null">
										<option value=""> Todos Vendedores</option>
										<option ng-repeat="cli in dadosColaborador | filter:{pe_empresa:empresa}" value="{{cli.pe_cod}}">{{cli.pe_nome}}</option>

									</select>
						    	</div>

						    	<div class="form-group col-md-2 col-12 pt-3">

						    		 <label for="periodo">Período</label>
						    		 <input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">

						    	</div>

						    	<div class="form-group col-md-2 col-12 pt-3">
						    		  <label for="periodo">a</label>
						    		 <input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">

						    	</div>


									<div class="form-group col-md-4 col-10 pt-3" ng-init="fPagamento = '0'">
									 <label for="fPagamento">Tipo</label>

							    		<select class="form-control form-control-sm capoTexto" id="fPagamento" ng-model="fPagamento" value="">
											<option value="0" selected> Todas Formas de Pagamento</option>
											<option ng-repeat="FormaPagamento in dadosFormadePagamento" value="{{FormaPagamento.dc_codigo}}">{{FormaPagamento.dc_descricao}}</option>

	<?php if (base64_decode($em_ramo) == 1) {?>

											<option value=""> Por Origem De Lançto. (Mesa/Comanda/Disk. Entrega</option>
	<?php }?>

										</select>

								</div>

								<div class="form-group col-md-2 col-10" style="margin-right: -10px !important; margin-left: -34px !important;">
								   <div style="margin-top: 35px;">
								   	<label></label>

									<button class="btn btn-outline-dark" lass="btn btn-outline-dark" style="color: white; width:20px;" ng-click="busca(empresa,clientes,dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd', funcionario, fPagamento)"><i class="fas fa-search"></i></button>

									<md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px;" ng-click="print()">
										<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
				                      	<i class="fas fa-print" style=""></i> Imprimir
		    	                	</md-button>
		    	                  </div>

						    	</div>

						    	<div class="col-md-2 dados" style="margin-left: -8px; padding: 0; width:180px;">

						    		<table>
						    			<thead>
						    				<tr>
						    					<th></th>
						    					<th></th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<tr>
						    					<td>Qnts. De Vendas:</td>
						    					<td  align="right">{{relatorioTotalRegistro[0].totalRegistro}}</td>
						    				</tr>

						    				<tr>
						    					<td style="width:30px;">Dinheiro:</td>
						    					<td align="right"> {{relatorioTotalGrupoBy[0].dinheiro | currency:'R$ '}}</td>
						    				</tr>

						    				<tr>
						    					<td>Cartão:</td>
						    					<td align="right">{{relatorioTotalGrupoBy[0].cartao | currency:'R$ '}}</td>
						    				</tr>

						    				<tr>
						    					<td>Boleto:</td>
						    					<td align="right"> {{relatorioTotalGrupoBy[0].boleto | currency:'R$ '}}</td>
						    				</tr>

						    				<tr>
						    					<td>Promissoria:</td>
						    					<td align="right">{{relatorioTotalGrupoBy[0].promissoria | currency:'R$ '}}</td>
						    				</tr>

						    			</tbody>
					    			</table>

						    	</div>

						    </div>


					    	<div show-on-desktop>

					    		<table class="table table-striped table-borderless" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1.1em !important;">

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_doc')">Docto.

											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('em_fanta')">Empresa.

											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_emis')">Emissão

											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_nome')">Cliente

											</th>


		<?php if (base64_decode($em_ramo) == 1) {?>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_taxa')"> Taxa

											</th>
		<?php }?>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_total')"> Valor Venda

											</th>

											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('vd_valor')" ng-if="tipoPg != 0">
												<span ng-if="tipoPg == 1">Val.Pago BL</span>
												<span ng-if="tipoPg == 2">Val.Pago CA</span>
												<span ng-if="tipoPg == 3">Val.Pago DN</span>
												<span ng-if="tipoPg == 4">Val.Pago PR</span>

											</th>

										</tr>

									</thead>
									<tbody>
										<tr dir-paginate="relatorio in relatorioVendas|itemsPerPage:10|orderBy:sortKey:reverses" ng-click="null">

											<td>{{relatorio.vd_doc | numberFixedLen:4}}</td>
											<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
							    			<td>{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</td>
							    			<td>{{relatorio.vd_nome}}</td>


<?php if (base64_decode($em_ramo) == 1) {?>
											<td>{{relatorio.vd_taxa|currency:'R$'}}</td>
<?php }?>
							    			<td align="center">{{relatorio.vd_total|currency:'R$'}}</td>
							    			<td align="center" ng-if="tipoPg != 0">
												<span ng-if="tipoPg == 1">{{relatorio.vd_vl_pagto_bl|currency:'R$'}}</span>
												<span ng-if="tipoPg == 2">{{relatorio.vd_vl_pagto_ca|currency:'R$'}}</span>
												<span ng-if="tipoPg == 3">{{relatorio.vd_vl_pagto_dn|currency:'R$'}}</span>
												<span ng-if="tipoPg == 4">{{relatorio.vd_vl_pagto_dp|currency:'R$'}}</span>

											</td>

										</tr>

									</tbody>
								</table>

								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>

					    	</div>


							<div show-on-mobile>
							<!--
								<md-toolbar layout="row" class="md-hue-3" style="background-color:#000; color:#fff;">
							      <div class="md-toolbar-tools" layout="row" layout-align="space-around center">

									<div flex="5">Docto.</div>
									<div flex="5">Forma</div>
									<div flex="20">Emissão</div>
									<div flex="30">Cliente</div>
									<div flex="15">Val. Prod</div>
<?php if (base64_decode($em_ramo) == 1) {?>
									<div flex="10"> Taxa </div>
<?php }?>

									<div flex="10"> Total </div>

							      </div>
							    </md-toolbar>

							    <md-content>
							    	<md-list class="p-0" flex>
							    		<md-list-item md-on-select="logItem" class="md-1-line" md-auto-select="options.autoSelect"  ng-repeat="relatorio in relatorioVendas|limitTo: query.limit: (query.page -1) * query.limit" ng-click="null" layout-align="space-around center">
							    			<div flex="5">{{relatorio.vd_doc | numberFixedLen:4}}</div>
							    			<div flex="">{{}}</div>
							    			<div flex="25">{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</div>
							    			<div flex="30">{{relatorio.vd_cli}} - {{relatorio.vd_nome}}</div>
							    			<div flex="15">{{relatorio.vd_valor|currency:'R$'}}</div>
<?php if (base64_decode($em_ramo) == 1) {?>
											<div flex="10">{{relatorio.vd_taxa|currency:'R$'}}</div>
<?php }?>
							    			<div flex="10">{{relatorio.vd_total|currency:'R$'}}</div>

							    			<md-divider></md-divider>
							    		</md-list-item>

							    	</md-list>
							    </md-content>


							</div>
						-->
							<!-- Final Desktop -->


							<div show-on-mobile>


							</div>






					</div>
				</div>

				
				<table id="tabela">
					<thead>
					<tr>
						<th>Docto.</th>
						<th>Empresa</th>
						<th>Emissão</th>
						<th>Cliente</th>

<?php if (base64_decode($em_ramo) == 1) {?>
						<th>Taxa</th>
<?php }?>
						<th>Valor Venda</th>

						<th id="valBL" ng-if="tipoPg == 1">
							<span id="valBL">Val.Pago BL</span>
						</th>
						<th id="valCA" ng-if="tipoPg == 2">
							<span id="valCA">Val.Pago CA</span>
						</th>
						<th id="valDN" ng-if="tipoPg == 3">
							<span id="valDN">Val.Pago DN</span>
						</th>
						<th id="valPR" ng-if="tipoPg == 4">
							<span id="valPR">Val.Pago PR</span>
						</th>

						<!--
						<th id="valBL" style="display:none">
							<span id="valBL">Val.Pago BL</span>
						</th>
						<th id="valCA" style="display:none">
							<span id="valCA">Val.Pago CA</span>
						</th>
						<th id="valDN" style="display:none">
							<span id="valDN">Val.Pago DN</span>
						</th>
						<th id="valPR" style="display:none">
							<span id="valPR">Val.Pago PR</span>
						</th>-->
					</tr>
				</thead>
				<tbody>
					<!--tr ng-repeat="relatorio in relatorioVendasPrint | orderBy:sortKey:reverses">
						<td>{{relatorio.vd_doc | numberFixedLen:4}}</td>
						<td>{{relatorio.em_fanta | limitTo:30}}{{relatorio.em_fanta.length >= 30 ? '...' : ''}}</td>
		    			<td>{{relatorio.vd_emis|date:'dd/MM/yyyy'}}</td>
		    			<td>{{relatorio.vd_nome}}</td>

<?php if (base64_decode($em_ramo) == 1) {?>
						<td>{{relatorio.vd_taxa|currency:'R$ '}}</td>
<?php }?>
		    			<td>{{relatorio.vd_total|currency:'R$ '}}</td>

		    			<td id="valBL" ng-if="tipoPg == 1">
						<span id="valBL">{{relatorio.vd_vl_pagto_bl | currency:'R$ '}}</span>
						</td>

						<td id="valCA" ng-if="tipoPg == 2">
							<span id="valCA">{{relatorio.vd_vl_pagto_ca | currency:'R$ '}}</span>
						</td>

						<td id="valDN" ng-if="tipoPg == 3">
							<span id="valDN">{{relatorio.vd_vl_pagto_dn | currency:'R$ '}}</span>
						</td>

						<td id="valPR" ng-if="tipoPg == 4">
							<span id="valPR">{{relatorio.vd_vl_pagto_dp | currency:'R$ '}}</span>
						</td-->

<!--
		    		<td id="valBL" style="display:none">
						<span id="valBL">{{relatorio.vd_vl_pagto_bl | currency:'R$ '}}</span>
					</td>

					<td id="valCA" style="display:none">
						<span id="valCA">{{relatorio.vd_vl_pagto_ca | currency:'R$ '}}</span>
					</td>

					<td id="valDN" style="display:none">
						<span id="valDN">{{relatorio.vd_vl_pagto_dn | currency:'R$ '}}</span>
					</td>

					<td id="valPR" style="display:none">
						<span id="valPR">{{relatorio.vd_vl_pagto_dp | currency:'R$ '}}</span>
					</td>
				-->
					<!--/tr-->
				</tbody>
				</table>

				<table id="tabela2" border="1">

					<thead>
						<th>Resumo</th>
						<th></th>
					</thead>

					<tbody>

						<tr>
	    					<td>Qnts. De Vendas:</td>
	    					<td  align="right">{{relatorioTotalRegistro[0].totalRegistro}}</td>
	    				</tr>

	    				<tr>
	    					<td>Dinheiro:</td>
	    					<td> {{relatorioTotalGrupoBy[0].dinheiro | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Cartão:</td>
	    					<td>{{relatorioTotalGrupoBy[0].cartao | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Boleto:</td>
	    					<td> {{relatorioTotalGrupoBy[0].boleto | currency:'R$ '}}</td>
	    				</tr>

	    				<tr>
	    					<td>Promissoria:</td>
	    					<td>{{relatorioTotalGrupoBy[0].promissoria | currency:'R$ '}}</td>
	    				</tr>

					</tbody>
				</table>

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
	<script src="js/dirPagination.js"></script>
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	

	<!--Gerar PDF -->


	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>


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
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.dadosEmpresa=[];
			$scope.dadosCliente= [];
			$scope.dadosColaborador = [];
			$scope.dadosFormadePagamento = [{'dc_codigo':'1','dc_descricao':'Boleto'},{'dc_codigo':'2','dc_descricao':'Cartão'},{'dc_codigo':'3','dc_descricao':'Dinheiro'},{'dc_codigo':'4','dc_descricao':'Promissoria'}];
			$scope.relatorioVendas = [];
			$scope.relatorioVendasPrint=[];
			$scope.relatorioTotalSoma = [];
			$scope.relatorioTotalRegistro = [];
			$scope.relatorioTotalCliente = [];
			$scope.relatorioTotalGrupoBy = [];

			$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();
    		//$scope.dataI = '2011-01-01';
    		//$scope.dataF = '2011-01-30';
    		$scope.cliente = 'pe_cliente';
    		$scope.colaborador = 'pe_vendedor';
    		$scope.situacao = 1;
			$scope.ativo = 'S';


			$scope.tipoAlerta = "alert-primary";
			$scope.alertMsg = "Gerando PDF";


			 $scope.logPagination = function (page, limit) {
			    console.log('page: ', page);
			    console.log('limit: ', limit);
			  }



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

			var dadosCliente = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosCliente();

			var dadosFuncionario = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.colaborador+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosColaborador=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosFuncionario();

			var relatorioVendasPaginate = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&pagination=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.paginacao=response.data.result[0];
				}).catch(function onError(response){

				});
			};


		    var relatorioVendas = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&dadosRegistro=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioVendas=response.data.result[0];
					$scope.progresiveBar = false;
					tabelaPDF(empresa,clientes,dataI,dataF,funcionario, fPagamento);
				}).catch(function onError(response){
					$scope.progresiveBar = false;
				});
			};

			var relatorioVendasTotal = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&relatorioTotalValor=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioTotalSoma=response.data.result[0];
				}).catch(function onError(response){

				});
			};

			var relatorioVendasTotalRegistro = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&relatorioTotalRegistro=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioTotalRegistro=response.data.result[0];
				}).catch(function onError(response){

				});
			};

			var relatorioVendasTotalCliente = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&relatorioTotalCliente=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioTotalCliente=response.data.result[0];

				}).catch(function onError(response){

				});
			};

			var relatorioTotalGrupoBy = function (empresa,clientes,dataI,dataF,funcionario, fPagamento) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'relatorio_rel_venda.php?relatorio=S&relatorioTotalGrupoBy=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
				}).then(function onSuccess(response){
					$scope.relatorioTotalGrupoBy=response.data.result[0];

				}).catch(function onError(response){

				});
			};


			$scope.busca = function(empresa,clientes,dataI,dataF,funcionario, fPagamento){

				this.tipoPg = 0;
			$scope.progresiveBar = true;
			<?php if (base64_decode($empresa_acesso) != 0) {?>
				var empresa = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>
				if (empresa == undefined) {
					empresa = '';
				}
				if (clientes == undefined) {
					clientes = '';
				}

				if (funcionario == undefined) {
					funcionario = '';
				}

				if (fPagamento == undefined) {
					fPagamento = '';
					this.tipoPg = 0;
				}

				if (fPagamento == 0) {
					this.tipoPg = 0;
				}

				else if(fPagamento == 1) {
					this.tipoPg = 1;
				}
				else if(fPagamento == 2) {
					this.tipoPg = 2;
				}

				else if(fPagamento == 3) {
					this.tipoPg = 3;
				}

				else if(fPagamento == 3) {
					this.tipoPg = 3;
				}

				else if(fPagamento == 4) {
					this.tipoPg = 4;
				}



				relatorioVendasPaginate(empresa,clientes,dataI,dataF,funcionario,fPagamento);
				relatorioVendas(empresa,clientes,dataI,dataF,funcionario,fPagamento);
				relatorioVendasTotal(empresa,clientes,dataI,dataF,funcionario,fPagamento);
				relatorioVendasTotalRegistro(empresa,clientes,dataI,dataF,funcionario,fPagamento);
				relatorioVendasTotalCliente(empresa,clientes,dataI,dataF,funcionario,fPagamento);
				relatorioTotalGrupoBy(empresa,clientes,dataI,dataF,funcionario, fPagamento);
				//console.log(empresa + '-' + clientes + '-' + dataI + '-' + dataF + '-' +funcionario + '-' + fPagamento);

			}

			$scope.print = function(){
				//$scope.relatorioVendasPrint=[];
				chamarAlerta();

    			$scope.progressClass = '-webkit-animation: progress 10s infinite; - moz-animation: progress 10s infinite; animation: progress 10s infinite;';
/*
   				for (var i = 0; i < $scope.relatorioVendas.length; i++) {
   					 	$scope.relatorioVendasPrint.push($scope.relatorioVendas[i]);
   					 	console.log($scope.relatorioVendasPrint);
   				}
*/
				setTimeout(function() {
					gerarpdf();
					chamarAlerta();
				},	1000);

			}



		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

		  }).config(function($mdDateLocaleProvider) {
		   $mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out','Nov','Dez'];
		   $mdDateLocaleProvider.Months  = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
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

	<script src="https://code.jquery.com/jquery-2.0.3.min.js" type="text/javascript"></script>

	<script type="text/javascript">

	function tabelaPDF(empresa,clientes,dataI,dataF,funcionario, fPagamento) {
			var selectFpg = document.getElementById('fPagamento').options[document.getElementById('fPagamento').selectedIndex].value;

			var itens = "", url ='./services/relatorio_rel_venda.php?relatorio=S&dadosRegistro=S&js=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+empresa+'&clientes='+clientes+'&dataI='+dataI+'&dataF='+dataF+'&funcionario='+funcionario+'&fPagamento='+fPagamento
			$.ajax({
				url: url,
				cache: false,
				dataType: "json",
				beforeSend: function() {
					//$("h2").html("Carregando...");
				},
				error: function() {
					//$("h2").html("Há algum problema com a fonte de dados");
				},
				success: function(retorno) {
					for(var i = 0; i<retorno.length; i++){
						itens += "<tr>";
						itens += "<td>" + retorno[i].vd_doc + "</td>";
						itens += "<td>" + retorno[i].em_fanta + "</td>";
						itens += "<td>" + retorno[i].vd_emis + "</td>";
						itens += "<td>" + retorno[i].vd_nome + "</td>";
						itens += "<td> R$ " + retorno[i].vd_total + "</td>";
						if(selectFpg != 0){
							if (selectFpg == 1) {
								itens += "<td> R$ " + retorno[i].vd_vl_pagto_bl + "</td>";
							}
							if (selectFpg == 2) {
								itens += "<td> R$ " + retorno[i].vd_vl_pagto_ca + "</td>";
							}
							if (selectFpg == 3) {
								itens += "<td> R$ " + retorno[i].vd_vl_pagto_dn + "</td>";
							}
							if (selectFpg == 4) {
								itens += "<td> R$ " + retorno[i].vd_vl_pagto_dp + "</td>";
							}
							
						}
						
						itens += "</tr>";
						
					}
					console.log(selectFpg);
					$("#tabela tbody").html(itens);
				}
			})
			
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
	    });

	    function chamarAlerta(){
			$('.alert').toggle("slow");
		};

		

		function gerarpdf() {
			alert(<?=base64_encode($logoEmp)?>);
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

    		//tipo de pesquisa
<?php if (base64_decode($empresa_acesso) == 0) {?>
    		var empresa = document.getElementById('empresa').options[document.getElementById('empresa').selectedIndex].innerText;
<?php } else {?>
			var empresa = '<?=$dados_empresa["em_fanta"]?>';
<?php }?>

			var cliente = document.getElementById('cliente').options[document.getElementById('cliente').selectedIndex].innerText;

			var funcionario = document.getElementById('funcionario').options[document.getElementById('funcionario').selectedIndex].innerText;

			var fPagamento = document.getElementById('fPagamento').options[document.getElementById('fPagamento').selectedIndex].innerText;

			var selectFpg = document.getElementById('fPagamento').options[document.getElementById('fPagamento').selectedIndex].value;

			var DataInicio = document.getElementById("dataI").value;
    		var DataFim = document.getElementById("dataF").value;

    		var arrData = DataInicio.split('-');
    		var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);

    		var arrDataF = DataFim.split('-');
    		var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);
/*
    		var valTipoPG document.getElementById('valTipoPG');
    		var valBL document.getElementById('valBL');
    		var valCA document.getElementById('valCA');
    		var valDN document.getElementById('valDN');
    		var valPR document.getElementById('valPR');
*//*
    		if (selectFpg == 0) {
	    		document.getElementById('valBL').style.display = "none";
	    		document.getElementById('valCA').style.display = "none";
	    		document.getElementById('valDN').style.display = "none";
	    		document.getElementById('valPR').style.display = "none";
    		}
    		else if (selectFpg == 1) {
    			document.getElementById('valBL').style.display = "block";
	    		document.getElementById('valCA').style.display = "none";
	    		document.getElementById('valDN').style.display = "none";
	    		document.getElementById('valPR').style.display = "none";
    		}
    		else if (selectFpg == 2) {
    			document.getElementById('valBL').style.display = "none";
	    		document.getElementById('valCA').style.display = "block";
	    		document.getElementById('valDN').style.display = "none";
	    		document.getElementById('valPR').style.display = "none";
    		}
    		else if (selectFpg == 3) {
    			document.getElementById('valBL').style.display = "none";
	    		document.getElementById('valCA').style.display = "none";
	    		document.getElementById('valDN').style.display = "block";
	    		document.getElementById('valPR').style.display = "none";
    		}
    		else if (selectFpg == 4) {
    			document.getElementById('valBL').style.display = "none";
	    		document.getElementById('valCA').style.display = "none";
	    		document.getElementById('valDN').style.display = "none";
	    		document.getElementById('valPR').style.display = "block";
    		}
*/
    		var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 70, 70);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text("Relatório Relação de Vendas", 85, 27);
		        doc.setFontSize(12);
		        doc.setTextColor(40);
		        doc.setFontStyle('italic');
		        doc.text("<?=$nomeEmp?>", 85, 47);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text("Total de Vendas: " + (linhas.length - 1), 460,);
		        doc.setFontSize(9);
		        //doc.text("Filtro De Busca Por " , 85, 56);
		        doc.text("Empresa: " + empresa , 85, 56);
		        doc.text("Cliente: " + cliente + " :: Vendedor: " + funcionario , 85, 66);
		        doc.text("Forma de Pagamento: " + fPagamento , 85, 76);
        		doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 86);


    		}

    		doc.autoTable(data1.columns, data1.rows,{
    			beforePageContent: header,
    			margin: {top: 90, right: 10, bottom: 20, left: 10},
		        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
		        columnStyles: {
		        	0: {halign: 'center'},
		        	1: {halign: 'left'},
		        	2: {halign: 'center'},
		        	3:{halign: 'left'},
		        	4:{halign: 'right'},
		        	5:{halign: 'right'}},

		        rowStyles: {1: {fontSize: (number = 11)}},
		        tableLineColor: [189, 195, 199],
		        tableLineWidth: 0.75,
		        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
		        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
		        alternateRowStyles: {fillColor: [250, 250, 250]},

		        drawRow: function (row, data) {
		            // Colspan
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
		               /*  data.cursor.y += 20; */
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
		    var data2 = doc.autoTableHtmlToJson(document.getElementById("tabela2"));
		    var rows = data2.rows;

		    doc.autoTable(data2.columns, data2.rows, {
	        startY: doc.autoTable.previous.finalY + 10,
	        margin: {top: 80, right: 10, bottom: 20, left: 450},
	        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
	        columnStyles: {0: {halign: 'left'}, 1: {halign: 'right'}},
	        rowStyles: {1: {fontSize: (number = 11)}},
	        tableLineColor: [189, 195, 199],
	        tableLineWidth: 0.75,
	        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
	        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
	        alternateRowStyles: {fillColor: [250, 250, 250]},

	    });


    		window.open(doc.output('bloburl'),'_blank');

		}

	</script>


</body>
</html>