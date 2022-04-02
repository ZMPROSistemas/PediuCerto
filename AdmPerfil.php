<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$us_id = 1;

$em_cep = "";
$em_end = "";
$em_cidade = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";

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

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

	}
	.table th {
		cursor:pointer;
		background: black !important;
	}

	#mdCheckbox div {
		clear: both; 
	}

	#mdCheckbox legend {
		color: #3F51B5; 
		font-size: 1.1em; 
		padding-left: 8px; 
	}

	#mdCheckbox legend code {
		color: #3F51B5;
	}

	#mdCheckbox p {
		padding-left: 8px; 
	}

	#mdCheckbox.info {
		padding-left: 13px; 
	}

	#mdCheckbox div.standard {
		padding: 8px;
		padding-left: 15px; 
	}

	#mdCheckbox fieldset.standard {
		height: 100%; 
	}
	md-tabs .md-tab {
		color:white !important;
		font-style: normal;
	}

	md-tabs .md-tab.md-active {
		color:#0094FFFF !important;
		font-size: 1.1em; 
	}


</style>

			<div ng-controller="ZMProCtrl">	
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Administrativo</li>
						<li class="breadcrumb-item active" aria-current="page">Perfil</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">

						<div ng-if="lista">
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
<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
			                                <i class="fas fa fa-print"></i> 
			                            </a>-->
									</div>
						    	</div>
						    </div>

							<table class="table table-striped table-borderless" style="background-color: #FFFFFFFF; color: black;">
								<thead class="thead-dark">
									<tr style="font-size: 1.1em !important;">
										<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_cod')">Código</th>
										<th scope="col" style=" font-weight: normal;" ng-click="ordenar('pe_nome')">Usuário</th>
										<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
									</tr>
								</thead>
								<tbody>
									<tr dir-paginate="cliente in dadosCliente | filter:buscaRapida | orderBy:'sortKey':reverse | itemsPerPage:10">
										<td ng-bind="cliente.pe_cod"></td>
										<td ng-bind="cliente.pe_nome"></td>
										<td style="text-align: center;">
											<div class="btn-group dropleft">
												<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
				                                    <i class="fas fa-ellipsis-v"></i> 
				                                </button>
				                                <div class="dropdown-menu">
<?php if (substr($me_empresa, 2, 1) == 'S') {?>
				                                	<a class="dropdown-item" ng-click="editarCliente(cliente.pe_id)">Editar</a>
<?php } ?>
<?php if (substr($me_empresa, 3, 1) == 'S') {?>
				                                	<a class="dropdown-item" ng-click="excluirCliente(cliente.pe_id, cliente.pe_nome)">Excluir</a>
<?php }?>
				                                </div>
				                            </div>
										</td>
									</tr>
								</tbody>
							</table>
							<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							<div class="dropleft">
								<md-button class="md-fab md-fab-bottom-right color-default-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: fixed; z-index: 999; background-color:#279B2D;">
									<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
			                      	<i class="fa fa-plus"></i>
	    	                	</md-button>
	    	                	<div class="dropdown-menu">
									<form class="px-4 py-3">
										<span class="dropdown-item"><b>Cadastrar Novo Perfil</b></span>
										<div class="dropdown-divider"></div>
										<div class="form-group">
											<label for="CadPerfil">Nome do Perfil</label>
											<input type="text" class="form-control" id="CadPerfil">
										</div>
										<button type="submit" class="btn btn-primary">Cadastrar</button>
									</form>
								</div>
							</div>
						</div>

						<div ng-if="ficha">
				  			<div class="row" style="background-color: transparent !important; background: rgba(0, 0, 0, .3) !important;" >
								<div class="col-lg-12">
									<legend class="pl-2 pt-2 my-0"><small><i class="fa fa-user"></i>  </small></legend>
									<div class="panel-body p-0">
										<md-content id="TabColaborador" style="background-color: transparent !important; background: rgba(0, 0, 0, .65) !important;">
											<md-tabs md-dynamic-height md-border-bottom >
												<md-tab label="Principal">
													<md-content id="mdCheckbox" class="md-padding" style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Clientes</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Fornecedores</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox class="md-primary" ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab  label="Produtos">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Cadastro de Produtos</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Grupo de Produtos</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Subgrupo de Produtos</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Lançamento de Estoque</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Saída de Estoque</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Transferência de Estoque</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Alterar Preços</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Etiquetas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab label="Financeiro">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Contas a Receber</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Contas Recebidas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Contas a Pagar</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Contas Pagas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Cartões a Receber</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Cartões Recebidos</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Cadastro de Cartões</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Tenho que ver</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab  label="Caixa">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Abrir Caixa</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Fechar Caixa</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Fechamentos Realizados</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Selecionar Caixa</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Movimentar Caixa</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Cadastro de Caixas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Históricos Bancários</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab  label="Faturamento">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Vendas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Notas de Saída</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Notas de Entrada</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>CFOP</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>NCM</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab  label="Administrativo">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Empresas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Colaboradores</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Usuários do Sistema</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Perfil</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Impressoras</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Log do Sistema</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Ajuda</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
												<md-tab  label="Relatório">
													<md-content id="mdCheckbox" class="md-padding" 	style="background-color: white !important;">
														<div layout="row" layout-align="end end" >
															<md-checkbox ng-click="toggle(item, selected)">
																<span><b>Selecionar Tudo</b></span>
															</md-checkbox>
														</div>
														<md-divider class="pb-2"></md-divider>
														<div layout="row" layout-wrap>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard" >
																	<div layout="row" layout-align="space-around center" flex class="mt-1">
																		<div flex="25">
																			<legend>Relação de Vendas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Ranking de Produtos</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Relação de Contas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Posição de Vendas</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Posição de Estoque ($)</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100" style="background-color: #E5E5E5FF;">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Contagem de Estoque</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
															<div flex="100" flex-gt-sm="100">
																<fieldset class="standard pt-2" >
																	<div layout="row" layout-align="space-around center" flex>
																		<div flex="25">
																			<legend>Exclusões do Sistema</legend>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Habilita Menu</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Inserir</span>
																			</md-checkbox>
																		</div>
																		<div flex="20">
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Alterar</span>
																			</md-checkbox>
																		</div>
																		<div flex>
																			<md-checkbox ng-click="toggle(item, selected)">
																				<span>Exluir</span>
																			</md-checkbox>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</md-content>
												</md-tab>
											</md-tabs>
										</md-content>
									</div>
									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="cliente.pe_nome" ng-click="cadastrarCliente(cliente.pe_nome, cliente.pe_fanta, cliente.pe_cpfcnpj, cliente.pe_rgie, cliente.pe_nascto, cliente.pe_cep, cliente.pe_endereco, cliente.pe_end_num, cliente.pe_end_comp, cliente.pe_bairro, cliente.pe_cidade, cliente.pe_uf, cliente.pe_fone, cliente.pe_email, cliente.pe_limite, cliente.pe_obs)"><i class="fas fa-save" id="BotaoSalvar"></i> Salvar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="!cliente.pe_nome" ng-click="verificaDados()"><i class="fas fa-save"></i> Salvar</md-button>
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
	<script src="js/material-components-web.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/dirPagination.js"></script>	
	<script src="https://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
			$scope.situacao = 1;
			$scope.ativo = 'S';
			$scope.urlBase = 'services/'
			$scope.dadosPerfil=[];

			$scope.perfil=[{
				pe_id : '',
				pe_cod: '',
				pe_nome : '',
				pe_fanta : '',
				pe_cpfcnpj : '',
				pe_rgie : '',
				pe_nascto : '',
				pe_cep : '',
				pe_endereco : '',
				pe_end_num : '',
				pe_end_comp : '',
				pe_bairro : '',
				pe_cidade : '',
				pe_uf : '',
				pe_fone : '',
				pe_email : '',
				pe_limite : '',
				pe_obs : '',
			}];

		    $scope.isSet = function(tabNum){
		    	return $scope.tab === tabNum;
		    };

		    $scope.MudarVisibilidade = function() {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;

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