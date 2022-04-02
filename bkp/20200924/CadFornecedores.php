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

// Alterado 04/05/2020 Kleython

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
	    background-color: rgba(0, 0, 0, 0.1);
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

	.table-responsive{
		height:1080px;
		overflow:scroll;
		background-color:#ffffff;
	}

	.table th {
		cursor:pointer;
		background: black !important;
	}

</style>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-12">
						<div ng-if="lista">
					    	<div class="row bg-dark p-2 col-12" >
								<form class="col-12">

									<div class="form-row align-items-center" ng-init="empresa = '<?=base64_decode($empresa)?>'">
										
										<?php if (base64_decode($empresa_acesso) == 0) {?>
											<div class="col-3">
						
												<select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="dadosFornecedorComFiltro(empresa)" value="{{empresa}}">
													<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
												</select>
												
											</div>
										<?php } else {
										echo $dados_empresa["em_fanta"];
										}?>		

										<div class="input-group col-5 pt-2 ml-3">
												<input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark" style="color: white;">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
											<div class="col-auto" style="text-align: right;">
										    	<!--md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
							                      	<i class="fas fa-print" style=""></i> Imprimir
					    	                	</md-button-->

			<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
						                                <i class="fas fa fa-print"></i> 
					                            </a>-->
									    	</div>
									    </div>
							   		</form>

						   	</div>
							<div class="table-responsive px-0" style="overflow-y:auto ; overflow-x:hidden;">
								<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1em !important;">
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_cod')">Código</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_nome')">Nome</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_endereco')">Endereço</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_cidade')">Cidade</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_fone')">Telefone</th>
											<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr dir-paginate="fornecedor in dadosFornecedor | filter:buscaRapida | orderBy:'sortKey':reverse | itemsPerPage:20">
											<td ng-bind="fornecedor.pe_cod"></td>
											<td ng-bind="fornecedor.pe_nome"></td>
											<td ng-bind="fornecedor.pe_endereco"></td>
											<td ng-bind="fornecedor.pe_cidade"></td>
											<td ng-bind="fornecedor.pe_fone"></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
	<?php if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="editarFornecedor(fornecedor.pe_id)">Editar</a>
	<?php } ?>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="excluirFornecedor(fornecedor.pe_id, fornecedor.pe_nome)">Excluir</a>
	<?php }?>
					                                </div>
					                            </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="container col-12 p-2" style="border:none; background-color: #999999FF;">
								<div class="row align-items-center">
							    	<div class="col-4" style="text-align: left;">
										<div class="row justify-content-start">
								    		<span style="color: #303030FF;">Registros: <b>{{dadosFornecedor.length}}</b></span>
								    	</div>
									</div>
								</div>
							</div>	
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							<!-- Final Desktop -->

<!--							<div show-on-mobile>
						    	<div class="row bg-dark" >
									<div class="form-group col-md-6 col-10 pt-3 pb-0">
										<div class="input-group">
											<input type="text" class="form-control form-control-sm pb-0" id="buscaRápida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
											<div class="input-group-btn">
												<button type="button" class="btn btn-outline-dark" style="color: white;">
													<i class="fas fa fa-search"></i>
												</button>
											</div>
										</div>
							    	</div>
									<div class="form-group col-md-6 col-2 pt-2 pb-0 m-0">
										<div style="text-align: right;">
									    	<md-button class="btnSalvar pull-right p-0" style="border: none; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
												<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
						                      	<i class="fas fa-print" style=""></i> Imprimir
				    	                	</md-button>

				                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
				                                <i class="fas fa fa-print"></i> 
				                            </a>
										</div>
							    	</div>
							    </div>
								<table class="table table-striped table-borderless" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1.1em !important;">
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_cod')">Código</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_nome')">Nome</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_endereco')">Endereço</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_cidade')">Cidade</th>
											<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_fone')">Telefone</th>
											<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr dir-paginate="fornecedor in dadosFornecedor | filter:buscaRapida | orderBy:sortKey:reverse | itemsPerPage:10">
											<td ng-bind="fornecedor.pe_cod"></td>
											<td ng-bind="fornecedor.pe_nome"></td>
											<td ng-bind="fornecedor.pe_endereco"></td>
											<td ng-bind="fornecedor.pe_cidade"></td>
											<td ng-bind="fornecedor.pe_fone"></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
	<?php if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="editarFornecedor(fornecedor.pe_id)">Editar</a>
	<?php } ?>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="excluirFornecedor(fornecedor.pe_id, fornecedor.pe_nome)">Excluir</a>
	<?php }?>
					                                </div>
					                            </div>
											</td>
										</tr>
									</tbody>
								</table>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							</div><!-- Final Desktop -->

<!--						<div show-on-tablet>
							<h2>Tablet</h2>
						</div>

						<div show-on-laptop>
							<h2>Laptop</h2>
						</div>

							<h2>Desktop</h2>
						</div>  
					    	<md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
							      <span>Lista de Fornecedores</span>
					    	</md-subheader>
				    		<md-list>
				    		 	<md-list-item class="md-3-line" ng-repeat="dados in dadosFornecedor" ng-click="null">
				    		 		<div class="md-list-item-text" layout="row" layout-align="space-around center">
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="10">
				    		 				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false">
				    		 					<md-fab-trigger>
									                <md-button aria-label="menu" class="md-warn">
									                  <md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>
									               
									                  <i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #212529; font-size: 15px;"></i>
									                </md-button>
									            </md-fab-trigger>
									            <md-fab-actions>
									            	<md-button type="submit" aria-label="{{item.name}}" name="op" value="2" class="md-fab md-raised md-mini">
								                     	<i class="fa fa-address-card" aria-label="menu" style="color:#01255e; size: 35px;"></i>
								                  	</md-button>
								                  	<md-button type="submit" aria-label="{{item.name}}" name="op" value="3" class="md-fab md-raised md-mini">
								                     	<i class="fa fa-dollar" aria-label="menu" style="color:#016306"></i>
								                  	</md-button>
									            </md-fab-actions>
				    		 				</md-fab-speed-dial>
				    		 			</div>
				    		 		</div>
				    		 	</md-list-item>
				    		 	<md-divider ></md-divider>
				    		</md-list>-->
							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
	                      		<i class="fa fa-plus"></i>
    	                	</md-button>
					    </div> 
				    
					    <div ng-if="ficha">
							<div class="jumbotron p-3">
								<form autocomplete="off">
									<div class="form-row">
										<div class="form-group col-md-4 col-12">
											<label for="pe_cpfcnpj">CPF / CNPJ</label>
											<div class="input-group" ng-init="fornecedor.pe_cpfcnpj = fornecedor[0].pe_cpfcnpj">
												<input type="text" id="pe_cpfcnpj" class="form-control form-control-sm" ng-model="fornecedor.pe_cpfcnpj" ng-value="fornecedor.pe_cpfcnpj" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_rgie'))" ng-blur="formatarCNPJ(fornecedor.pe_cpfcnpj)" maxlength="14">
												<div class="input-group-btn"  ng-if="fornecedor.pe_cpfcnpj.length >= 14 ? BotaoPesquisaCNPJ = true : BotaoPesquisaCNPJ = false" ng-show="BotaoPesquisaCNPJ">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" ng-click="pesquisarCNPJ(fornecedor.pe_cpfcnpj)" >
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-4 col-6" ng-init="fornecedor.pe_rgie = fornecedor[0].pe_rgie">
											<label for="pe_rgie">RG / Insc. Estadual</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_rgie" ng-model="fornecedor.pe_rgie" ng-value="fornecedor.pe_rgie" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_nascto'))">
										</div>
<!--										<div class="form-group col-md-4 col-12">
											<label for="em_uf">O que Fornece?</label>
											<select class="form-control form-control-sm" id="em_uf"  value="<?=$em_uf?>">
												<option selected>Selecione</option>
												<option ng-value="Produtos">Produtos</option>
												<option ng-value="Insumos">Insumos</option>
												<option ng-value="Ambos">Ambos</option>
											</select>
										</div> -->
										<div class="form-group col-md-4 col-6" ng-init="fornecedor.pe_nascto = fornecedor[0].pe_nascto">
											<label for="pe_nascto">Nascimento / Início</label>
											<input type="text" class="form-control form-control-sm" id="pe_nascto" ng-model="fornecedor.pe_nascto" ng-value="fornecedor.pe_nascto" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_nome'))" maxlength="10" dat-dir>
										</div>
										<div class="form-group col-md-6 col-12" ng-init="fornecedor.pe_nome = fornecedor[0].pe_nome">
											<label for="pe_nome">Nome / Razão Social</label>
											<input type="text" class="form-control form-control-sm capoTexto campoObrigatorio" id="pe_nome" ng-model="fornecedor.pe_nome" ng-value="fornecedor.pe_nome" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_fanta'))">
										</div>
										<div class="form-group col-md-6 col-6" ng-init="fornecedor.pe_fanta = fornecedor[0].pe_fanta">
											<label for="pe_fanta">Apelido / Nome Fantasia</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_fanta" ng-model="fornecedor.pe_fanta" ng-value="fornecedor.pe_fanta" autocomplete="false" onKeyUp="tabenter(event,getElementById('pe_cep'))">
										</div>
										<div class="form-group col-md-2 col-6">
											<label for="pe_cep">CEP</label>
											<div class="input-group" ng-init="fornecedor.pe_cep = fornecedor[0].pe_cep">
												<input type="text" class="form-control form-control-sm capoTexto" id="pe_cep" ng-model="fornecedor.pe_cep" ng-value="fornecedor.pe_cep" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pesqCep))" cep-dir>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" id="pesqCep" style="color: white;" ng-click="pesquisarCEP(fornecedor.pe_cep)" onKeyUp="tabenter(event,getElementById('pe_end_num'))">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-6 col-9" ng-init="fornecedor.pe_endereco = fornecedor[0].pe_endereco">
											<label for="pe_endereco">Endereço</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_endereco" ng-model="fornecedor.pe_endereco" ng-value="fornecedor.pe_endereco" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_num'))">
										</div>
										<div class="form-group col-md-1 col-3" ng-init="fornecedor.pe_end_num = fornecedor[0].pe_end_num">
											<label for="pe_numero">Número</label>
											<input type="text" class="form-control form-control-sm" id="pe_numero" ng-model="fornecedor.pe_numero" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_comp'))">
										</div>
										<div class="form-group col-md-3 col-3" ng-init="fornecedor.pe_end_comp = fornecedor[0].pe_end_comp">
											<label for="pe_end_comp">Complemento</label>
											<input type="text" class="form-control form-control-sm" id="pe_end_comp" ng-model="fornecedor.pe_end_comp" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_bairro'))">
										</div>
										<div class="form-group col-md-3 col-5" ng-init="fornecedor.pe_bairro = fornecedor[0].pe_bairro">
											<label for="pe_bairro">Bairro</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_bairro" ng-model="fornecedor.pe_bairro" ng-value="fornecedor.pe_bairro" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_cidade'))">
										</div>
										<div class="form-group col-md-4 col-7" ng-init="fornecedor.pe_cidade = fornecedor[0].pe_cidade">
											<label for="pe_cidade">Cidade</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_cidade" ng-model="fornecedor.pe_cidade" ng-value="fornecedor.pe_cidade" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_uf'))">
										</div>
										<div class="form-group col-md-2 col-2" ng-init="fornecedor.pe_uf = fornecedor[0].pe_uf">
											<label for="pe_uf">Estado</label>
											<select class="form-control form-control-sm" id="pe_uf" ng-model="fornecedor.pe_uf" ng-value="fornecedor.pe_uf" onKeyUp="tabenter(event,getElementById('pe_fone'))">
												<option selected>Selecione</option>
<?php

foreach ($UF as $UF) {?>
												<option value="<?=$UF['sigla']?>"><?=$UF['nome']?></option>
<?php }?>

											</select>
										</div>
										<div class="form-group col-md-3 col-5" ng-init="fornecedor.pe_fone = fornecedor[0].pe_fone">
											<label for="pe_fone">Telefone</label>
											<input type="text" class="form-control form-control-sm" id="pe_fone" ng-model="fornecedor.pe_fone" ng-value="fornecedor.pe_fone" placeholder="Somente números, com DDD" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_email'))" phone-dir>
										</div>
										<div class="form-group col-md-4 col-5" ng-init="fornecedor.pe_email = fornecedor[0].pe_email">
											<label for="pe_email">Email</label>
											<input type="text" class="form-control form-control-sm" id="pe_email" ng-model="fornecedor.pe_email" ng-value="fornecedor.pe_email" placeholder="Email" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_obs'))">
										</div>
										<div class="form-group col-md-8 col-12" ng-init="fornecedor.pe_obs = fornecedor[0].pe_obs">
											<label for="pe_obs">Observações</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_obs" ng-model="fornecedor.pe_obs" ng-value="fornecedor.pe_obs" autocomplete="off" onKeyUp="tabenter(event,getElementById('BotaoSalvar'))">
										</div>
									</div>

									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="fornecedor.pe_nome" ng-click="cadastrarFornecedor(fornecedor.pe_cpfcnpj, fornecedor.pe_rgie, fornecedor.pe_nascto, fornecedor.pe_nome, fornecedor.pe_fanta, fornecedor.pe_cep, fornecedor.pe_endereco, fornecedor.pe_end_num, fornecedor.pe_end_comp, fornecedor.pe_bairro, fornecedor.pe_cidade, fornecedor.pe_uf, fornecedor.pe_fone, fornecedor.pe_email, fornecedor.pe_obs)"><i class="fas fa-save" id="BotaoSalvar"></i> Salvar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="!fornecedor.pe_nome" ng-click="verificaDados()"><i class="fas fa-save"></i> Salvar</md-button>
								</form>
							</div>
						</div>
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
	<script src="js/dirPagination.js"></script>	
	<script src="js/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

	    	'use strict';
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
			$scope.lista = true;
			$scope.BotaoPesquisaCNPJ = false;
			$scope.ficha = false;
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.cliente_fornecedor = 'pe_fornecedor';
			$scope.paginacao=[];
			$scope.urlBase = 'services/';
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
			$scope.dadosFornecedor=[];
			$scope.empresa = <?=base64_decode($empresa)?>;

			$scope.fornecedor=[{
				pe_id : '',
				pe_cod: '',
				pe_cpfcnpj : '',
				pe_rgie : '',
				pe_nascto : '',
				pe_nome : '',
				pe_fanta : '',
				pe_cep : '',
				pe_endereco : '',
				pe_end_num : '',
				pe_end_comp : '',
				pe_bairro : '',
				pe_cidade : '',
				pe_uf : '',
				pe_fone : '',
				pe_email : '',
				pe_obs : '',
			}];

			$scope.cadastrar_alterar = 'C';

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";

			$scope.ordenar = function(keyname){
		      $scope.sortKey = keyname;
		      $scope.reverse = !$scope.reverse;
		    };

		   $scope.sortKey = function(keyname){
		        $scope.sortBy = keyname;   
		        $scope.reverse = !$scope.reverse; 
		    };

		    $scope.MudarVisibilidade = function(e) {

		     	if (e == 1) {

		     		$scope.lista = !$scope.lista;
		    		$scope.ficha = !$scope.ficha;
		     	}
		     	if (e == 2) {
		     		$scope.lista = true;
					$scope.ficha = false;
					LimparCampos();
		     	}
		     	$scope.cadastrar_alterar = 'C';

		    }

		    var MudarVisibilidadeLista = function(e) {

		     	if (e == 1) {

		     		$scope.lista = !$scope.lista;
		    		$scope.ficha = !$scope.ficha;
		     	}
		     	if (e == 2) {
		     		$scope.lista = true;
					$scope.ficha = false;
					LimparCampos();
		     	}

		    }

		     $scope.verificaDados = function(){
		    	$scope.tipoAlerta = "alert-warning";

				$scope.alertMsg = "*Campos obrigatórios devem ser preenchidos!"
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

			var dadosFornecedor = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S&empresa='+$scope.empresa
				}).then(function onSuccess(response){
					$scope.dadosFornecedor=response.data.result[0];

					if ($scope.dadosFornecedor.length <1) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Empresa não possui fornecedores cadastrados!";
						chamarAlerta();
					}
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar fornecedores. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			$scope.dadosFornecedorComFiltro = function (empresa) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S&empresa='+empresa
				}).then(function onSuccess(response){
					$scope.dadosFornecedor=response.data.result[0];

					if ($scope.dadosFornecedor.length <1) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Empresa não possui fornecedores cadastrados!";
						chamarAlerta();
					}

				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosFornecedor();

			$scope.cadastrarFornecedor = function(pe_cpfcnpj, pe_rgie, pe_nascto, pe_nome, pe_fanta, pe_cep, pe_endereco, pe_end_num, pe_end_comp, pe_bairro, pe_cidade, pe_uf, pe_fone, pe_email, pe_obs){

		    	var pe_comp = null;

		    	if (pe_cpfcnpj == undefined) {
		    		pe_cpfcnpj = null;
		    	}
		    	if (pe_rgie == undefined) {
		    		pe_rgie = null;
		    	}
		    	if (pe_nascto == undefined) {
		    		pe_nascto = null;
		    	}
		    	if (pe_nome == undefined) {
		    		pe_nome = null;
		    	}
		    	if (pe_fanta == undefined) {
		    		pe_fanta = null;
		    	}
		    	if (pe_cep == undefined) {
		    		pe_cep = null;
		    	}
		    	if (pe_endereco == undefined) {
		    		pe_endereco = null;
		    	}
		    	if (pe_end_num == undefined) {
		    		pe_end_num = null;
		    	}
		    	if (pe_end_comp == undefined) {
		    		pe_end_comp = null;
		    	}
		    	if (pe_bairro == undefined) {
		    		pe_bairro = null;
		    	}
		    	if (pe_cidade == undefined) {
		    		pe_cidade = null;
		    	}
		    	if (pe_uf == undefined) {
		    		pe_uf = null;
		    	}
		    	if (pe_fone == undefined) {
		    		pe_fone = null;
		    	}
		    	if (pe_email == undefined) {
		    		pe_email = null;
		    	}
		    	if (pe_obs == undefined) {
		    		pe_obs = null;
		    	}

				$scope.fornecedor[0].pe_cpfcnpj= pe_cpfcnpj;
				$scope.fornecedor[0].pe_rgie = pe_rgie;
				$scope.fornecedor[0].pe_nascto = pe_nascto;
				$scope.fornecedor[0].pe_nome = pe_nome;
				$scope.fornecedor[0].pe_fanta = pe_fanta;
				$scope.fornecedor[0].pe_cep = pe_cep;
				$scope.fornecedor[0].pe_endereco = pe_endereco;
				$scope.fornecedor[0].pe_end_num = pe_end_num;
				$scope.fornecedor[0].pe_end_comp = pe_end_comp;
				$scope.fornecedor[0].pe_cidade = pe_cidade;
				$scope.fornecedor[0].pe_uf = pe_uf;
				$scope.fornecedor[0].pe_fone = pe_fone;
				$scope.fornecedor[0].pe_email = pe_email;
				$scope.fornecedor[0].pe_obs = pe_obs;


		    	SalvarFornecedor();
		    	MudarVisibilidadeLista(2);
		    	console.log($scope.fornecedor);
		    }

		    var SalvarFornecedor = function () {

				var cliente = $scope.fornecedor;

				$http({
					method: 'POST',
					 headers: {
			           'Content-Type':'application/json'
			         },
			          data: {
			           cliente
			          },
			          url: $scope.urlBase+'SalvaCadClienteFornecedor.php?editarCadastrar='+$scope.cadastrar_alterar+'&us_id=<?=$us_id?>&e=+<?=$empresa?>&eA=<?=$empresa_acesso?>&us=<?=$us?>&cliente_fornecedor='+$scope.cliente_fornecedor
				}).then(function onSuccess(response){

					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						if ($scope.cadastrar_alterar == 'C') {
							$scope.alertMsg = "Erro ao realizar cadastro!";
						}
						if ($scope.cadastrar_alterar == 'C') {
							$scope.alertMsg = "Erro ao editar cadastro!";
						}
						chamarAlerta();

					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";

						if ($scope.cadastrar_alterar == 'C') {
						$scope.alertMsg = "Cadastro realizado com sucesso!";
						}

						if ($scope.cadastrar_alterar == 'E') {
							$scope.alertMsg = "Cadastro editado com sucesso!";
						}
						chamarAlerta();
					}

					LimparCampos();
					dadosFornecedor();
				}).catch(function onError(response){

				})

			};

			$scope.editarFornecedor = function(pe_id){

				$http({
					method: 'GET',
					url: $scope.urlBase+'pesquisaCliente.php?id='+pe_id
				}).then(function onSuccess(response){
					$scope.fornecedor=response.data.result[0];

					$scope.cadastrar_alterar = 'E';
					MudarVisibilidadeLista(1);
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao editar fornecedor. Caso este erro persista, contate o suporte.");
				});

			}

			$scope.excluirFornecedor = function(pe_id, pe_nome){
				$http({
					method: 'GET',
					url: $scope.urlBase+'excluirCliente.php?id='+pe_id+'&us=<?=$us?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&cliente='+pe_nome
				}).then(function onSuccess(response){


					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro: o fornecedor não pode ser excluido!";
						chamarAlerta();
					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Exclusão realizada com sucesso!";
						chamarAlerta();
						dadosCliente();	
					}

				}).catch(function onError(response){
					alert("Erro ao excluir fornecedor. Caso este erro persista, contate o suporte.");
				});
			}

			var LimparCampos = function(form) {

				//document.getElementById(this).reset();
				$scope.fornecedor=[{
					pe_id : '',
					pe_cpfcnpj : '',
					pe_rgie : '',
					pe_nascto : '',
					pe_nome : '',
					pe_fanta : '',
					pe_cep : '',
					pe_endereco : '',
					pe_end_num : '',
					pe_end_comp : '',
					pe_bairro : '',
					pe_cidade : '',
					pe_uf : '',
					pe_fone : '',
					pe_email : '',
					pe_obs : '',
				}];

			}

			$scope.verarray = function(){
				console.log($scope.fornecedor)
			}

			$scope.pesquisarCEP = function(cep){

				var cep = cep.replace(/\D/g, '');
				$http({
					method: 'GET',
					url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
				}).then(function onSuccess(response){
					$scope.fornecedorcep = response.data;
					$scope.fornecedor.pe_endereco = $scope.fornecedorcep['logradouro'];
					$scope.fornecedor.pe_end_num = $scope.fornecedorcep['numero'];
					$scope.fornecedor.pe_end_comp = $scope.fornecedorcep['complemento'];
					$scope.fornecedor.pe_bairro = $scope.fornecedorcep['bairro'];
					$scope.fornecedor.pe_cidade = $scope.fornecedorcep['localidade'];
					$scope.fornecedor.pe_uf = $scope.fornecedorcep['uf'];
				}).catch(function onError(response){

				});

		    };

			$scope.pesquisarCNPJ = function(cnpj){

				$http({
					method: 'GET',
					url: $scope.urlBase+'api/pesquisaCNPJ.php?cnpj='+cnpj+''
				  //url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj+''
				  //url: 'https://www.receitaws.com.br/v1/cnpj/03728505000165'
				}).then(function onSuccess(response) {
					console.log(response.data.nome);
					$scope.fornecedor.pe_nascto = response.data.abertura;
					$scope.fornecedor.pe_nome = response.data.nome;
					$scope.fornecedor.pe_fanta = response.data.fantasia
					$scope.fornecedor.pe_cep = response.data.cep;
					$scope.fornecedor.pe_endereco = response.data.logradouro;
					$scope.fornecedor.pe_end_num = response.data.numero;
					$scope.fornecedor.pe_end_comp = response.data.complemento;
					$scope.fornecedor.pe_bairro = response.data.bairro;
					$scope.fornecedor.pe_cidade = response.data.municipio;
					$scope.fornecedor.pe_uf = response.data.uf;
					$scope.fornecedor.pe_fone = response.data.telefone;
					$scope.fornecedor.pe_email = response.data.email;
					$scope.fornecedor.pe_obs = response.data.situacao;
				  }, function onError(response) {

				  });
			};

			$scope.formatarCNPJ = function(cpfcnpj){

				$http({
					method: 'GET',
					url: $scope.urlBase+'api/formataCPFCNPJ.php?cpfcnpj='+cpfcnpj+''
				}).then(function onSuccess(response) {
					console.log(response.data);
					$scope.fornecedor.pe_cpfcnpj = response.data;
				  }, function onError(response) {
				  });

			};
			
		}).config(function($mdDateLocaleProvider) {
		   $mdDateLocaleProvider.shortMonths  = ['Jan', 'Fev', 'Mar', 'Abril','Maio', 'Jun', 'Jul','Ago', 'Set', 'Out','Nov','Dez'];
		   $mdDateLocaleProvider.Months  = ['Janeiro', 'Fevereiro', 'Março', 'Abril','Maio', 'Junho', 'Julho','Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
		   $mdDateLocaleProvider.days = ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta','Sexta', 'Sabado'];
		   $mdDateLocaleProvider.shortDays = ['D', 'S', 'T', 'Q', 'Q','S','S'];
		  });

		angular.module("ZMPro").directive('relogio', function($interval) {
			return {
				restrict: 'AE',
					link: function(scope, element, attrs) {

						var timer = $interval(function(){
							mudaTempo();
						},1000);

					function mudaTempo(){
						element.text((new Date()).toLocaleString());
					}
				}
			}
		});

		angular.module("ZMPro").directive("phoneDir", PhoneDir);

		function PhoneDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();
						}
					}

					$(element).mask('(00) 00000-0000', options);

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length > 10) {//verifica a quantidade de digitos.
							mask = "(00) 00000-0000";
						} else {
							mask = "(00) 0000-00009";
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

					$(element).mask('999.999.999,00', {reverse: true});

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length > 3) {//verifica a quantidade de digitos.
							mask = "999.999.999,00";
						}
					$(element).mask(mask, options);//aplica a mascara novamente
					}
				}
			}
		};

		angular.module("ZMPro").directive("cepDir", CepDir);

		function CepDir() {
			return {
				link : function(scope, element, attrs) {
					var options = {
						onKeyPress: function(val, e, field, options) {
							putMask();
						}
					}

					$(element).mask('00000-000', options);

					function putMask() {
						var mask;
						var cleanVal = element[0].value.replace(/\D/g, '');//pega o valor sem mascara
						if(cleanVal.length < 9) {//verifica a quantidade de digitos.
							mask = "00000-000";
						}
					$(element).mask(mask, options);//aplica a mascara novamente
					}
				}
			}
		};

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