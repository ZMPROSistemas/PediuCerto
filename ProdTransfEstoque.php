<?php


include 'varInicio.php';
include 'conecta.php';
include './services/conectaPDO.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

/*if (!isset($_SESSION['arrayProdutos'])){

	$_SESSION['arrayProdutos'] = buscarListaProdutos($pdo, base64_decode($empresa));
	//echo base64_decode($empresa);

}

$cacheProdInfo = buscarCacheProdutos($conexao, $pdo, base64_decode($empresa), base64_decode($empresa_acesso));

if (!isset($_SESSION['cacheProd'])){
	$_SESSION['cacheProd'] = $cacheProdInfo['ca_produto'];
	//echo "entrou 2";
} else if ($_SESSION['cacheProd'] !=  $cacheProdInfo['ca_produto']) {
		//echo "entrou 3";
		$_SESSION['arrayProdutos'] = buscarListaProdutos($pdo, base64_decode($empresa));
		$_SESSION['cacheProd'] = $cacheProdInfo['ca_produto'];
}*/

//echo "Cod ". $_SESSION['cacheProd'];

//var_dump($_SESSION['arrayProdutos']);

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

/*function buscarListaProdutos($pdo, $empresa) {

	$retorno = array();

	$sql = "SELECT pd_id, pd_cod, pd_desc from produtos where pd_empresa = $empresa;";
						
	$listaprod =$pdo->prepare($sql);
	//$listaprod->bindValue(":empresa", $empresa);
	$listaprod->execute();
	$retorno = $listaprod->fetchAll(PDO::FETCH_ASSOC);
	
	//echo $sql;
	return $retorno;

}

function buscarCacheProdutos($conexao, $pdo, $matriz, $empresa) {
	if ($empresa == 0) {
		$empresa = $matriz;
	}

	$sql = "SELECT ca_produto from cache where ca_empresa = $empresa;";
	//echo $sql;
	$query = mysqli_query($conexao, $sql);
	$row = mysqli_fetch_assoc($query);
	
	if ($row['ca_produto'] == null) {
		$cod = rand(1000,9999);
		$sqlcache = "INSERT INTO cache (ca_matriz, ca_empresa ,ca_produto, ca_grupo, ca_subgrupo, ca_info)value($matriz,$empresa, $cod, $cod, $cod, $cod);";
		$queryInsert = mysqli_query($conexao, $sqlcache);
		$_SESSION['arrayProdutos'] = buscarListaProdutos($pdo, $empresa);
	}

	return $row;

}*/

?>

<style>

	.alert{display: none;}

	.text-capitalize {
	  text-transform: capitalize; }

	.md-fab:hover, .md-fab.md-focused {
	  background-color: #000 !important; }

	p.note {
	  font-size: 1.2rem; }

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

	.tableFixHead { overflow-y: auto; height: 100px; }
	.tableFixHead thead th { position: sticky; top: 0; }

	/* Just common table stuff. Really. */
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }

	.tracejado {
		border:1px dashed gray; 
	}

</style>

			<div ng-controller="ZMProCtrl">	 
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Produtos</li>
						<li class="breadcrumb-item active" aria-current="page">Transferência de Estoque</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 py-0 px-2">
						<div show-on-desktop>

							<div ng-if="true">

								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
										<form class="my-0 py-0">
											<div class="form-row justify-content-between align-items-center">
				
												<div class="col-auto">
													<label>Filtros</label>
												</div>
<?php if (base64_decode($empresa_acesso) == 0) {?>
												<div class="col-auto">
													<select class="form-control form-control-sm" id="empresaOrigem" ng-model="empresaOrigem">
														<option value="">Empresa de Origem</option>
														<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
													</select>
												</div>

												<div class="col-auto">
													<select class="form-control form-control-sm" id="empresaDestino" ng-model="empresaDestino">
														<option value="">Empresa de Destino</option>
														<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
													</select>
												</div>
<?php } else {
echo $dados_empresa["em_fanta"];
}?>
												<div class="col-1">
													<input type="text" value="" class="form-control form-control-sm" id="item" ng-model="item" placeholder="Cod Item">
												</div>

												<div class="col-auto">
													<label for="dataI">Período </label>
												</div>
												<div class="col-auto">
													<input date-range-picker id="daterange2" name="daterange2" class="form-control form-control-sm date-picker" type="text" min="'2001-01-01'" max="'2100-12-31'" ng-model="date" required/>
													<md-tooltip md-direction="top" md-visible="tooltipData">Clique em Pesquisar</md-tooltip>
												</div>
												<!--input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">
												</div>
												<div class="col-auto">
													<label for="dataF">até </label>
												</div>
												<div class="col-auto">
													<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}"-->

												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-left" style="border: none;" ng-click="modificaBusca(empresaOrigem, empresaDestino, item, date.startDate, date.endDate)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipPesquisar">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
													<!--md-button class="btnSalvar pull-right" style="border: none;" style="color: green;" ng-disabled="!contasPagas[0]" ng-click="print()">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
														<i class="fas fa-print"></i> Imprimir
													</!--md-button-->
												</div>
											</div>
										</form>
										<div class="card col-12 p-0 mt-0" style="border:none; background-color: rgba(0,0,0, .15);">
											<div class="row">
												<div class="col-7 pl-0"><span style="color:gainsboro;">Transferências</span></div>
												<div class="col-5 pl-0"><span style="color:gainsboro;">Itens da Transferência: {{documento}}</span></div>
											</div>
										</div>
										<div class="card col-12 p-0" style="border:none; background-color:rgba(0,0,0, .8); ">
											<div class="row">
												<div class="table-responsive tableFixHead col-7 p-0" style="border:none !important; background-color: white; height: 65vh;">
													<table class="table table-sm table-striped pb-0" style="background-color: #FFFFFFFF; color: black; cursor: pointer; ">
														<thead class="thead-dark">
															<tr >
																<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tr_cod')">Cod</th>
																<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tr_data')">Data</th>
																<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('tr_saida')">Empresa Saída</th>
																<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('tr_entrada')">Empresa Destino</th>
																<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('tr_enviado')">Enviado</th>
															</tr>
														</thead>
														<tbody >
															<tr ng-repeat="transf in dadosTransf | orderBy:'-tr_data'" ng-click="ConsultaTransf(transf)" ng-blur="LimpaItens()">
																<td style="text-align: left;" ng-bind="transf.tr_cod"></td>
																<td style="text-align: left;" ng-bind="transf.tr_data | date:'dd/MM/yyyy'"></td>
																<td style="text-align: center;" ng-bind="transf.emp_saida"></td>
																<td style="text-align: center;" ng-bind="transf.emp_entrada"></td>
																<td style="text-align: center;" ng-bind="transf.tr_enviado"></td>
															</tr >
														</tbody>
													</table>
												</div>

												<div class="table-responsive tableFixHead col-5 px-0" style="background-color: white; border-left: 8px rgba(0,0,0, .8) solid; height: 65vh;">
													<table class="table table-sm table-striped" style="background-color: white; color: black;">
														<thead class="thead-dark">
															<tr>
																<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tri_prod')">Cod</th>
																<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tri_desc')">Descrição</th>
																<th scope="col" style="font-weight: normal; text-align: center;" ng-click="ordenar('tri_quant')">Qtde</th>
																<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('tri_data')">Data Entrada</th>
															</tr>
														</thead>
														<tbody ng-init="itens_somados = 0">
															<tr ng-repeat="itens in itensTransf | orderBy:'sortKey':reverse" >
																<td ng-bind="itens.tri_prod" ></td>
																<td style="text-align: left;" ng-bind="itens.tri_desc" class="d-inline-block text-truncate"></td>
																<td style="text-align: center;" ng-bind="itens.tri_quant | number" ></td>
																<td style="text-align: right;" ng-bind="itens.tri_data | date:'dd/MM/yyyy'" ></td>
																<td style="display: none;" ng-init="$parent.itens_somados = $parent.itens_somados ++ itens.tri_quant"></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="card-footer p-2">
											<div class="form-row align-items-center">
												<div class="col-6 pl-0" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: grey;" ng-click="mudarVisibilidade()">Registros: <b>{{dadosTransf.length}}</b></span>
													</div>
												</div>
												<div class="col-6 pr-0" style="text-align: right;">
													<span style="color: grey;">Itens: <b>{{itens_somados}}</b></span>
												</div>
											</div>
										</div>	
									</div>
								</div>
<?php if (substr($me_empresa, 1, 1) == 'S') {?>
<!--								<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="mudarVisibilidade()" style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Fazer uma Transferência de Estoque</md-tooltip>
									<i class="fa fa-plus"></i>
								</md-button>-->
<?php }?>								
							</div>
							<div ng-if="false">
<?php
	//include 'pages/novaTransfEstoque.php';
?>
								<?=json_encode($_SESSION['arrayProdutos'])?>
								<div class="card border-dark col-12" style="background-color:rgba(0,0,0, .65); ">
									<div class="row">
										<h5 class="col-12 text-left p-0 mb-0 mt-2 pt-2">Nova Transferência </h5>
									</div>
									<hr class="tracejado">
									<div class="row">
										<form class="col-6 p-0 pr-2" autocomplete="off" id="transferencia">
											<div class="form-row">
												<div class="form-group col-6">
													<label for="tr_data">Data da Transferência</label>
													<input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}" >
												</div>
												<div class="form-group col-6">
													<label for="tr_lancado">Lançado por</label>
													<select class="form-control form-control-sm" ng-model="transferencia.tr_lancado" id="tr_lancado" required>
														<option value="">Selecione um Colaborador</option>
														<option ng-repeat="func in dadosColaboradores" ng-value="func.pe_cod" >{{func.pe_nome}}</option>
													</select>
												</div>
												<div class="form-group col-6">
													<label for="tr_saida">Empresa de Saída</label>
													<select class="form-control form-control-sm" ng-model="transferencia.tr_saida" id="tr_saida" required>
														<option ng-value="">Selecione uma Empresa</option>
														<option ng-repeat="empLoc in dadosEmpresa" ng-value="empLoc.em_cod_local" >{{empLoc.em_fanta}}</option>
													</select>
												</div>
												<div class="form-group col-6">
													<label for="tr_entrada">Empresa Destino</label>
													<select class="form-control form-control-sm" ng-model="transferencia.tr_entrada" id="tr_entrada" required>
														<option ng-value="">Selecione uma Empresa</option>
														<option ng-repeat="empDest in dadosEmpresa" ng-value="empDest.em_cod_local" >{{empDest.em_fanta}}</option>
													</select>
												</div>
												<div class="form-group col-6">
													<label for="tr_pedido">Pedido por</label>
													<input type="text" class="form-control form-control-sm" id="tr_pedido" ng-model="transferencia.tr_pedido">
												</div>
												<div class="form-group col-6">
													<label for="tr_autorizado">Autorizado por</label>
													<input type="text" class="form-control form-control-sm" id="tr_autorizado" ng-model="transferencia.tr_autorizado">
												</div>
											</div>
											<hr class="tracejado p-0">
											<div class="form-row">
												<div class="form-group col-3">
													<label for="tri_prod">Código</label>
													<input type="text" class="form-control form-control-sm" id="tri_prod" ng-model="tri_prod" onKeyUp="tabenter(event,getElementById('tri_quant'))" ng-blur="pesquisaProduto(tri_prod)">
												</div>
												<div class="form-group col-7">
													<label for="tri_desc">Descrição</label>
													<input type="text" class="form-control form-control-sm" id="tri_desc" ng-model="tri_desc" ng-disabled="true">
												</div>
												<div class="form-group col-2">
													<label>Quantidade</label>
													<div class="input-group">
														<input type="text" class="form-control form-control-sm" id="tri_quant" ng-model="tri_quant" onfocus="this.focus();this.select()" ng-blur="adicionaProdutoTransf(tri_prod, tri_desc, tri_quant)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onKeyUp="tabenter(event,getElementById('btnIncluir'))" >
														<!-- LEMBRAR DE NO PRIMEIRO LANÇAMENTO, SALVAR DADOS NA TABELA TRANSFERÊNCIA E PEGAR O tr_cod -->
														<div class="input-group-btn">
															<button type="button" class="btn btn-outline-dark" id="btnIncluir" ng-click="adicionaProdutoTransf(tri_prod, tri_desc, tri_quant)" style="color: white; border: none">
																<i class="fas fa fa-plus" ></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</form>

										<div class="table-responsive col-6 px-0" style="overflow:auto; background-color: white; height: 62vh;">
											<table class="table table-sm table-striped" style="width: 100%; color: black;">
												<thead class="thead-dark">
													<tr>
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tri_prod')">Cód</th>
														<th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('tri_desc')">Descrição</th>
														<th scope="col" style="font-weight: normal; text-align: right;" ng-click="ordenar('tri_quant')">Qtde</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="itens in listaNovaTransf | orderBy:reverse:true" >
														<td style="text-align: left;" ng-bind="itens.tri_prod"></td>
														<td style="text-align: left;" ng-bind="itens.tri_desc"></td>
														<td style="text-align: right;" ng-bind="itens.tri_quant"></td>
														<td ng-click="excluirProdutoTransf(itens)"><i class="fas fa-trash"></i></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-6 pl-0" style="text-align: left;">
											<div class="row justify-content-start">
												<span style="color:gray;">Só é permitida a transferência de itens com código</span>
											</div>
											<div class="row justify-content-start">
												<span style="color:gray;">Itens Lançados: <b>{{somaItensLancados}}</b></span>
											</div>
										</div>
										<div class="ml-auto m-0 p-0">
											<md-button class="btnCancelar pull-left" style="border: none;" ng-click="mudarVisibilidade()"> 
											<!-- SÓ POR ENQUANTO. LEMBRAR DE, AO CANCELAR, VERIFICAR SE TEM ALGUMA TRANSFERÊNCIA INICIADA (PERGUNTAR SE DESEJA EXCLUIR OU MANTER PRA CONTINUAR DEPOIS). -->
												<md-tooltip md-direction="top" md-visible="tooltipPesquisar">Cancelar e Fechar</md-tooltip>
												<i class="fas fa-arrow-circle-left"></i> Cancelar
											</md-button>
											<md-button class="btnSalvar pull-left" style="border: none;" ng-if="itensTranf[0]" ng-click="lancarArrayProdTransf()" style="color: green;">
												<md-tooltip md-direction="top" md-visible="tooltipPesquisar">Salvar e Fechar</md-tooltip>
												<i class="fas fa-save"></i> Salvar
											</md-button>
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
	<script src="js/material-components-web.min.js"></script>
	<script src="js/md-data-table.js"></script>
	<script src="js/bootstrap-autocomplete.min.js"></script>
	<script src="js/moment-with-locales.min.js"></script>
	<script src="js/moment-pt-br.js"></script>
    <script src="js/daterangepicker.min.js"></script>
    <script src="js/angular-daterangepicker.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>
<!--	<script type="text/javascript" src="js/swx-session-storage.min.js"></script>
	<script type="text/javascript" src="js/swx-local-storage.min.js"></script>-->


    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','daterangepicker']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

	    	'use strict';
	    	this.isOpen = false;
			$scope.lista = true;
			$scope.ficha = false;
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
			$scope.somaItensLancados = 0;
			$scope.total = 0;
		    $scope.tab = 1;
			$scope.listaNovaTransf = [];
			$scope.tri_prod = '';
			$scope.tri_desc = '';
			$scope.tri_quant = 1;
			$scope.urlBase = 'services/'
			$scope.item = '';
			$scope.itens_somados = '';
			$scope.empresaOrigem = '';
			$scope.empresaDestino = '';
			$scope.dataI = dataInicial();
    		$scope.dataF = dataHoje();
    		$scope.situacao = 1;
			$scope.empresa = <?=base64_decode($empresa)?>;
			$scope.empresaAcesso = <?=base64_decode($empresa_acesso)?>;	
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

			$scope.date = {
				startDate: moment().subtract(1, "months"),
				endDate: moment()
			};

			$scope.verificaDados = function(){
		    	$scope.tipoAlerta = "alert-warning";
				$scope.alertMsg = "*Campos Obrigatórios Devem Ser Preenchidos!"
				chamarAlerta();
		    }

		    $scope.mudarVisibilidade = function() {
				$scope.lista = !$scope.lista;
				$scope.ficha = !$scope.ficha;
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

		    var relatorioTransf = function () {
				//alert($scope.dataF);
				$http({
					method: 'GET',
					url: $scope.urlBase+'Estoque.php?&dadosTransferencias=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresaOrigem='+$scope.empresaOrigem+'&empresaDestino='+$scope.empresaDestino+'&item='+$scope.item+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
					$scope.dadosTransf=response.data.result[0];
				}).catch(function onError(response){
				
				});
			};

			relatorioTransf();

			$scope.modificaBusca = function (empresaOrigem, empresaDestino, item, dataI, dataF){
				$scope.empresaOrigem = empresaOrigem;
				$scope.empresaDestino = empresaDestino;
				$scope.dataI = dataI.format("YYYY-MM-DD");
				$scope.dataF = dataF.format("YYYY-MM-DD");
				$scope.item = item;
	    		busca();
			}

			var busca = function(){ 
			<?php if (base64_decode($empresa_acesso) != 0) {?>
				$scope.empresaOrigem = <?=$dados_usuario['us_empresa_acesso']?>;
			<?php }?>
				relatorioTransf();
			}
		    
		    $scope.ConsultaTransf = function (transf) {
		    	$scope.documento = transf.tr_cod;
				$http({
					method: 'GET',
					url: $scope.urlBase+'Estoque.php?&itensTransf=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&dataI=1&dataF=1&tr_id='+transf.tr_id
				}).then(function onSuccess(response){
					$scope.itensTransf=response.data.result[0];
				}).catch(function onError(response){
					alert("erro");
				});
			};

			/*var atualizaitensTransf = function(){
				var cache = $sessionStorage.get('listaNovaTransf');

				angular.forEach(cache, function(value, key){
					$scope.listaNovaTransf.push(cache[key]);
				});
			}
			atualizaitensTransf();*/

		    $scope.LimpaItens = function () {
				$scope.itensTransf='';
				$scope.itens_somados = 0;
			};

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
			};

			/*$scope.produtosEmpresa = <?=json_encode($_SESSION['arrayProdutos'])?>;

			$scope.pesquisaProduto = function(pd_cod){
				var existe = [];
				existe = $scope.produtosEmpresa.find(item => item.pd_cod == pd_cod);
				//alert(existe);
				if (existe == undefined) {
					$scope.tipoAlerta = "alert-info";
					$scope.alertMsg = "Não existe produto com este código."
					chamarAlerta();
					setarFoco();
				} else {
					$scope.tri_desc = existe.pd_desc;
				}
			}


			$scope.adicionaProdutoTransf = function(pd_cod, pd_desc, pd_qtde){
				//alert($scope.empresa);

				if (pd_cod == undefined) {
					pd_cod = '';
				}
				if (pd_qtde == undefined) {
					pd_qtde = '';
				}
				if(pd_cod != '' && pd_qtde != ''){

					/*var filtroPesquisaArray = [];
					filtroPesquisaArray = $scope.produtosEmpresa.filter(item => item.pd_cod == pd_cod);
					var pesquisaArray = filtroPesquisaArray.find(item => item.pd_empresa == $scope.empresa);
					console.log(pesquisaArray);

					var pesquisaArray = $scope.produtosEmpresa.find(item => item.pd_cod == pd_cod);
					console.log(pesquisaArray);
					if (pesquisaArray != undefined) {
						$scope.produto = pesquisaArray;
						if ($scope.produto != ''){
							//$scope.qtde = pd_qtde;
							adicionaProdutoArray($scope.produto.pd_cod, $scope.produto.pd_desc, pd_qtde);
							//alert("funcao");
						}
					} else {
						alert("Produto não encontrado!");
					}
					/*$http({
						method: 'GET',
						url: $scope.urlBase+'Produtos.php?consultaProduto=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod+'&empresa='+$scope.empresa
						}).then(function onSuccess(response){
							$scope.produto = response.data.result[0];
							if ($scope.produto[0].pd_cod != ''){
								$scope.qtde = pd_qtde;
								adicionaProdutoArray($scope.produto[0].pd_cod, $scope.produto[0].pd_desc, $scope.produto[0].pd_un, $scope.produto[0].pd_custo, $scope.produto[0].pd_vista, $scope.produto[0].pd_subgrupo);
							}
						}).catch(function onError(response){
						alert("Produto inexistente!");
					});
					//limparCamposInsert();
					setarFoco();
				};	

			}

			var adicionaProdutoArray = function (pd_cod, pd_desc, pd_qtde) {

				var posicao = $scope.listaNovaTransf.findIndex((user, index, array) => user.tri_prod === pd_cod);					
				//alert(posicao);
				
				if (posicao === -1) {

					var obj = {
						tri_prod: pd_cod,
						tri_desc: pd_desc,
						tri_quant:  parseInt(pd_qtde)
					};

					$scope.listaNovaTransf.push(obj);						


				} else {

					$scope.listaNovaTransf[posicao].tri_quant += parseInt(pd_qtde);

				}
				$sessionStorage.remove('listaNovaTransf');
				$sessionStorage.put('listaNovaTransf', $scope.listaNovaTransf);
				$scope.tri_quant = 1;
				$scope.tri_prod = '';
				$scope.tri_desc = '';
			}

			$scope.lancarArray = function() {

				if ($scope.empresaAcesso == undefined || $scope.empresaAcesso == 0 || $scope.empresaAcesso == null || $scope.empresaAcesso == '') {
					$('#modalEmpresa').modal('show');
				} else {
					$('#modalEmpresa').modal('hide');
					SalvarTransferencia();
				}

			}

			$scope.sairTransferencia = function (produto) {
					
				$('#modalConfirmaSair').modal('show');
					
			}

			$scope.abrirModalExclusao = function (produto) {
				$scope.excluirProd = produto.cei_prod;
					
				$('#modalExclusao').modal('show');
					
			}

			$scope.excluirItem = function () {
					
				var index = $scope.listaNovaTransf.findIndex((user, index, array) => user.tri_prod === $scope.excluirProd);
				//alert(index);
				$scope.listaNovaTransf.splice(index,1);
				setarFoco();

			}

			var SalvarTransferencia = function(){

				var listaNovaTransf = $scope.listaNovaTransf;
				var dadosTransferencia = $scope.transferencia

				$http({
					method: 'POST',
					headers: {
					'Content-Type':'application/json'
					},
					data: {
						dadosTransferencia:dadosTransferencia,
						listaNovaTransf:listaNovaTransf
					},
					url: $scope.urlBase+'Estoque.php?novaTransferencia=S&e=<?=$empresa?>&eA='+$scope.empresaAcesso

				}).then(function onSuccess(response){
					$scope.LimparCancelar();
					$scope.retStatus = response.data.result[0];
					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Transferência realizada com sucesso!";
					chamarAlerta();
								
				}).catch(function onError(response){
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro ao lançar Transferência!";
						chamarAlerta();
				})
			};*/





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

	    $(document).ready(function () {
	        $("#sidebar").mCustomScrollbar({
	            theme: "minimal"
	        });

	        $('#sidebarCollapse').on('click', function () {
	            $('#sidebar, #content').toggleClass('active');
	            $('.collapse.in').toggleClass('in');
	            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
			});
			moment.locale('pt-br');
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

		/*function setarFoco() {

			document.getElementById("tri_prod").select();

		}*/

	</script>

</body>
</html>