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

	.linhaTable{
		line-height: 10px;
		cursor:pointer;
	}
</style>

			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Clientes</li>
<!--						<button type="" ng-click="verarray()" style="display:none">ver array</button> -->
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

				<?php
					include_once "modal/clientes/clienteInfo.php";
				?>

				<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12 pt-0 px-2">
						<div ng-if="lista">

							<div show-on-desktop>
								<div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
									<div class="card-body py-0 px-2 m-0">
    			                        <form class="my-0 pt-0">
                			                <div class="form-row align-items-center">
												
												<div class="col-auto">
                                        			<label>Filtros</label>
												</div>

												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="buscaCliente" ng-model="buscaCliente" placeholder="Todos os Clientes">
												</div>

												<div class="col-2">
													<input type="text" value="" class="form-control form-control-sm" id="buscaCidade" ng-model="buscaCidade" placeholder="Todas as Cidades">
												</div>

												<?php if (base64_decode($empresa_acesso) == 0) {?>
												<div class="col-2">
													<select class="form-control form-control-sm" id="empresa" ng-model="empresa">
														<option value="">Todas as Empresas</option>
														<option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
													</select>
													
												</div>
											<?php } else {
											echo $dados_empresa["em_fanta"];
											}?>							

												<div class="ml-auto m-0 p-0">
													<md-button class="btnPesquisar pull-right" style="border: none;" ng-click="busca(empresa, buscaCliente, buscaCidade)" style="color: white;">
														<md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
														<i class="fas fa fa-search" ></i> Pesquisar
													</md-button>
												</div>
											</div>
										</form>

										    	<!--md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
							                      	<i class="fas fa-print" style=""></i> Imprimir
					    	                	</md-button-->

			<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
						                                <i class="fas fa fa-print"></i> 
					                            </a>-->
					<!--ng-include src="" scope="" onload=""></ng-include>
					    	<md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
							      <span>Lista de Clientes</span>
					    	</md-subheader>  -->
										<div class="table-responsive p-0 mb-0" style="overflow: hidden;">
											<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
												<thead class="thead-dark">
													<tr style="font-size: 1em !important;">
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_cod')">Código</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_nome')">Nome</th>
														<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_endereco')">Endereço</th>
														
														<?php  if (base64_decode($em_cod) != 11)
															{//para ramo de adividade 2
														?>
															<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_cidade')">Cidade</th>
														
														<?php }  
															 if (base64_decode($em_cod) == 11)
															 {//para ramo de adividade 1 que seja empresa 11

														?>
															<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_cidade')">Bairro</th>
														<?php
															}
															if (base64_decode($em_cod) != 11)
															{//para ramo de adividade 2
														?>
															<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_fone')">Telefone</th>
														<?php
															}
														  	if (base64_decode($em_cod) == 11)
															{//para ramo de adividade 1 que seja empresa 11
														?>
															<th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_fone')">Celular</th>
														<?php
															}
														?>

														<?php
														  	if (base64_decode($em_cod) == 11)
															{//para ramo de adividade 1 que seja empresa 11
														?>
															<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
														<?php
															}
														?>
													</tr>
												</thead>
												<tbody style="line-height: 2em;">
													<tr dir-paginate="cliente in dadosCliente | orderBy:'sortKey':reverse | itemsPerPage: 20" >
														<td ng-bind="cliente.pe_cod" style=" font-weight: normal; text-align: left;" ></td>
														<td ng-bind="cliente.pe_nome" style=" font-weight: normal; text-align: left;" ></td>
														<td> {{cliente.pe_endereco}}, {{cliente.pe_end_num}}</td>
														
														<?php  if (base64_decode($em_cod) != 11){

														?>
															<td ng-bind="cliente.pe_cidade" style=" font-weight: normal; text-align: left;" ></td>

														<?php }
															if (base64_decode($em_cod) == 11)
															{//para ramo de adividade 1 que seja empresa 11

														?>
															<td ng-bind="cliente.pe_bairro" style=" font-weight: normal; text-align: left;" ></td>
														<?php }
														
														 if (base64_decode($em_cod) != 11)
															{//para ramo de adividade 2
														?>
															<td ng-bind="cliente.pe_fone" style=" font-weight: normal; text-align: left;" ></td>
														<?php
															}
														?>
														<!----------------->
														<?php  if (base64_decode($em_cod) == 11)
															{//para ramo de adividade 1 que seja empresa 11
														?>
															<td ng-bind="cliente.pe_celular" style="font-weight: normal; text-align: left;"></td>
														<?php
															}
														?>

														<?php
														  	if (base64_decode($em_cod) == 11)
															{//para ramo de adividade 1 que seja empresa 11
														?>

														<td style="text-align: center; padding:0px; margin:0px;">
															<?php //EM 04/11/2020, APÓS CONVERSA COM MICHEL, FOI DECIDIDO NÃO PERMITIR ALTERAÇÃO NEM EXCLUSÃO DE CLIENTES PARA NÃO DAR PROBLEMAS EM OUTROS LUGARES
															//Em 26/11/2020 alterado por Diogo, ira exibir somente para empresa 11 ?>
															<md-menu>
																<md-button ng-click="$mdOpenMenu()" style="padding:0px; margin:0px;">
																	<i class="fas fa-ellipsis-v"></i> 
																</md-button>
																<md-menu-content class="dropdown">
																
															<?php
														  	if (base64_decode($em_cod) == 11)
																{//para ramo de adividade 1 que seja empresa 11
															?>
																<md-menu-item>
																	<md-button ng-click="maisInfoCliente(cliente.pe_id)">Mais info</md-button>
																</md-menu-item>
															<?php
																}
															?>

																	<md-menu-item >
					<?php if (substr($me_empresa, 2, 1) == 'S') {?>
																		<md-button ng-click="editarCliente(cliente.pe_id)">Editar</md-button>
					<?php } ?>
																	</md-menu-item>

																	<md-menu-item>
					<?php if (substr($me_empresa, 3, 1) == 'S') {?>																				
																		<md-button ng-click="excluirCliente(cliente.pe_id, cliente.pe_nome)">Excluir</md-button>
					<?php }?>
																	</md-menu-item>
																</md-menu-content>
															</md-menu>
														</td>
														
														<?php
															}
														?>

													</tr>
												</tbody>
											</table> 
	
											<div ng-if="arrayNull == true">
												<div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
													Aguarde... Pesquisando!
												</div>
											</div>
	
										</div>
										<div class="card-footer p-0 pb-2">
											<div class="form-row align-items-center">
												<div class="col-3" style="text-align: left;">
													<div class="row justify-content-start">
														<span style="color: gray;">Registros: <b>{{dadosCliente.length}}</b></span>
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>									
							</div><!-- Final Desktop -->

<!--							<div show-on-laptop>
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
										<tr dir-paginate="cliente in dadosCliente | filter:buscaRapida | orderBy:'sortKey' | itemsPerPage:10">
											<td ng-bind="cliente.pe_cod"></td>
											<td ng-bind="cliente.pe_nome"></td>
											<td>{{cliente.pe_endereco}}, {{cliente.pe_end_num}}</td>
											<td ng-bind="cliente.pe_cidade"></td>
											<td ng-bind="cliente.pe_fone"></td>
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
							</div>

							<div show-on-tablet>

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
									<div class="form-group col-md-6 col-2 pt-3">
										<div style="text-align: right;">
			                                <button type="button" class="btn btn-outline-light btn-lg p-0" style="border: none; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
						                      	<i class="fas fa-print" style=""></i>
			                                </button>
	<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
				                                <i class="fas fa fa-print"></i> 
				                            </a>
										</div>
							    	</div>
							    </div>

								<md-content>
						    		<md-list flex>
						    			<md-list-item md-on-select="logItem" class="md-2-line" md-auto-select="options.autoSelect"  ng-repeat="cliente in dadosCliente|filter:buscaRapida|limitTo: query.limit: (query.page -1) * query.limit" ng-click="null">

							    			<div class="md-list-item-text">
							    				<h3><b>{{cliente.pe_nome | limitTo:80}}{{cliente.pe_nome.length >= 80 ? '...' : ''}}</b></h3>
							    				<h3>{{cliente.pe_cidade | limitTo:40}}{{cliente.pe_cidade.length >= 40 ? '...' : ''}} - {{cliente.pe_fone}}</h3>
							    			</div>

							    			<div class="md-list-item-text">
							    				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false" style="margin-top: -10px;">

						    		 				<md-fab-trigger>
										                <md-button aria-label="menu" class="md-warn">
										                	<md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>
										                	<i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #000; font-size: 15px;"></i>
										                </md-button>
											        </md-fab-trigger>
											        <md-fab-actions>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
										            	<md-button type="submit" aria-label="{{item.name}}" ng-click="excluirCliente(cliente.pe_id,cliente.pe_nome)" class="md-fab md-raised md-mini" style="background-color:#585570;">
									                    	<i class="fa fa-trash-alt" aria-label="menu" style="color:#fff; size: 35px;"></i>
									                  	</md-button>

	<?php }if (substr($me_empresa, 2, 1) == 'S') {?>
									                  	<md-button type="submit" aria-label="{{item.name}}" ng-click="editarCliente(cliente.pe_id)" class="md-fab md-raised md-mini" style="background-color:#585570;">
									                    	<i class="fa fa-edit" aria-label="menu" style="color:#fff"></i>
									                  	</md-button>
	<?php }?>

									            	</md-fab-actions>

					    		 				</md-fab-speed-dial>
							    			</div>
											<md-divider></md-divider>
						    			</md-list-item>
						    		</md-list>
						    	</md-content>
							</div>

							<div show-on-mobile>
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
									<div class="form-group col-md-6 col-2 pt-3">
										<div style="text-align: center;">
									    	<md-button class="btnSalvar p-0" style="border: none; border-radius: 5px;" onclick="gerarpdf()">
												<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
						                      	<i class="fas fa-print" style=""></i>
				    	                	</md-button>

	<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
				                                <i class="fas fa fa-print"></i> 
				                            </a>
										</div>
							    	</div>
							    </div>
								<md-content>
						    		<md-list flex>
						    			<md-list-item class="md-2-line" md-on-select="logItem" md-auto-select="options.autoSelect"  ng-repeat="cliente in dadosCliente|filter:buscaRapida|limitTo: query.limit: (query.page -1) * query.limit" ng-click="null">

							    			<div class="md-list-item-text">
							    				<h3><b>{{cliente.pe_nome | limitTo:80}}{{cliente.pe_nome.length >= 80 ? '...' : ''}}</b></h3>
							    				<h3>{{cliente.pe_cidade | limitTo:40}}{{cliente.pe_cidade.length >= 40 ? '...' : ''}} - {{cliente.pe_fone}}</h3>
							    			</div>

							    			<div class="md-list-item-text">
							    				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false" style="margin-top: -10px;">

						    		 				<md-fab-trigger>
										                <md-button aria-label="menu" class="md-warn">
										                	<md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>
										                	<i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #000; font-size: 15px;"></i>
										                </md-button>
											        </md-fab-trigger>
											        <md-fab-actions>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
										            	<md-button type="submit" aria-label="{{item.name}}" ng-click="excluirCliente(cliente.pe_id,cliente.pe_nome)" class="md-fab md-raised md-mini" style="background-color:#585570;">
									                    	<i class="fa fa-trash-alt" aria-label="menu" style="color:#fff; size: 35px;"></i>
									                  	</md-button>

	<?php }if (substr($me_empresa, 2, 1) == 'S') {?>
									                  	<md-button type="submit" aria-label="{{item.name}}" ng-click="editarCliente(cliente.pe_id)" class="md-fab md-raised md-mini" style="background-color:#585570;">
									                    	<i class="fa fa-edit" aria-label="menu" style="color:#fff"></i>
									                  	</md-button>
	<?php }?>

									            	</md-fab-actions>

					    		 				</md-fab-speed-dial>

							    			</div>
											<md-divider></md-divider>
						    			</md-list-item>
						    		</md-list>
						    	</md-content>
							</div>-->

						   <!--
						    <md-table-pagination md-limit="query.limit" md-page="query.page" md-total="{{paginacao[0].total}}" md-page-select="dadosCliente" md-boundary-links="options.boundaryLinks" md-on-paginate="logPagination" md-label="{page: 'Página:', rowsPerPage: 'Filas por página:', of: 'de'}"></md-table-pagination>
						-->

<!--							<md-table-pagination md-limit="query.limit" md-page="query.page" md-total="{{paginacao[0].total}}" md-page-select="dadosCliente" md-boundary-links="options.boundaryLinks" md-on-paginate="logPagination"></md-table-pagination> -->
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
											<div class="input-group" ng-init="cliente.pe_cpfcnpj = cliente[0].pe_cpfcnpj">
												<input type="text" id="pe_cpfcnpj" class="form-control form-control-sm" ng-model="cliente.pe_cpfcnpj" ng-value="cliente.pe_cpfcnpj" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_rgie'))" ng-blur="formatarCNPJ(cliente.pe_cpfcnpj)" maxlength="14">
												<div class="input-group-btn"  ng-if="cliente.pe_cpfcnpj.length >= 14 ? BotaoPesquisaCNPJ = true : BotaoPesquisaCNPJ = false" ng-show="BotaoPesquisaCNPJ">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" ng-click="pesquisarCNPJ(cliente.pe_cpfcnpj)" >
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-4 col-6" ng-init="cliente.pe_rgie = cliente[0].pe_rgie">
											<label for="pe_rgie">RG / Insc. Estadual</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_rgie" ng-model="cliente.pe_rgie" ng-value="cliente.pe_rgie" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_nascto'))">
										</div>
										<div class="form-group col-md-4 col-6" ng-init="cliente.pe_nascto = cliente[0].pe_nascto">
											<label for="pe_nascto">Nascimento / Início</label>
											<input type="text" class="form-control form-control-sm" id="pe_nascto" ng-model="cliente.pe_nascto" ng-value="cliente.pe_nascto" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_nome'))" maxlength="10" dat-dir>
										</div>
										<div class="form-group col-md-6 col-12" ng-init="cliente.pe_nome = cliente[0].pe_nome">
											<label for="pe_nome">Nome / Razão Social</label>
											<input type="text" class="form-control form-control-sm capoTexto campoObrigatorio" id="pe_nome" ng-model="cliente.pe_nome" ng-value="cliente.pe_nome" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_fanta'))">
										</div>
										<div class="form-group col-md-6 col-6" ng-init="cliente.pe_fanta = cliente[0].pe_fanta">
											<label for="pe_fanta">Apelido / Nome Fantasia</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_fanta" ng-model="cliente.pe_fanta" ng-value="cliente.pe_fanta" autocomplete="false" onKeyUp="tabenter(event,getElementById('pe_cep'))">
										</div>
										<div class="form-group col-md-2 col-6">
											<label for="pe_cep">CEP</label>
											<div class="input-group" ng-init="cliente.pe_cep = cliente[0].pe_cep">
												<input type="text" class="form-control form-control-sm capoTexto" id="pe_cep" ng-model="cliente.pe_cep" ng-value="cliente.pe_cep" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pesqCep'))" cep-dir>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" id="pesqCep" style="color: white;" ng-click="pesquisarCEP(cliente.pe_cep)" onKeyUp="tabenter(event,getElementById('pe_end_num'))" >
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-6 col-9" ng-init="cliente.pe_endereco = cliente[0].pe_endereco">
											<label for="pe_endereco">Endereço</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_endereco" ng-model="cliente.pe_endereco" ng-value="cliente.pe_endereco" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_num'))">
										</div>
										<div class="form-group col-md-1 col-3" ng-init="cliente.pe_end_num = cliente[0].pe_end_num">
											<label for="pe_end_num">Número</label>
											<input type="text" class="form-control form-control-sm" id="pe_end_num" ng-model="cliente.pe_end_num" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_comp'))">
										</div>
										<div class="form-group col-md-3 col-3" ng-init="cliente.pe_end_comp = cliente[0].pe_end_comp">
											<label for="pe_end_comp">Complemento</label>
											<input type="text" class="form-control form-control-sm" id="pe_end_comp" ng-model="cliente.pe_end_comp" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_bairro'))">
										</div>
										<div class="form-group col-md-3 col-5" ng-init="cliente.pe_bairro = cliente[0].pe_bairro">
											<label for="pe_bairro">Bairro</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_bairro" ng-model="cliente.pe_bairro" ng-value="cliente.pe_bairro" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_cidade'))">
										</div>
										<div class="form-group col-md-4 col-7" ng-init="cliente.pe_cidade = cliente[0].pe_cidade">
											<label for="pe_cidade">Cidade</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_cidade" ng-model="cliente.pe_cidade" ng-value="cliente.pe_cidade" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_uf'))">
										</div>
										<div class="form-group col-md-2 col-2" ng-init="cliente.pe_uf = cliente[0].pe_uf">
											<label for="pe_uf">Estado</label>
											<select class="form-control form-control-sm" id="pe_uf" ng-model="cliente.pe_uf" ng-value="cliente.pe_uf" onKeyUp="tabenter(event,getElementById('pe_fone'))">
												<option selected>Selecione</option>
<?php

foreach ($UF as $UF) {?>
												<option value="<?=$UF['sigla']?>"><?=$UF['nome']?></option>
<?php }?>

											</select>
										</div>
										<div class="form-group col-md-3 col-5" ng-init="cliente.pe_fone = cliente[0].pe_fone">
											<label for="pe_fone">Telefone</label>
											<input type="text" class="form-control form-control-sm" id="pe_fone" ng-model="cliente.pe_fone" ng-value="cliente.pe_fone" placeholder="Somente números, com DDD" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_email'))" phone-dir>
										</div>
										<div class="form-group col-md-4 col-5" ng-init="cliente.pe_email = cliente[0].pe_email">
											<label for="pe_email">Email</label>
											<input type="text" class="form-control form-control-sm" id="pe_email" ng-model="cliente.pe_email" ng-value="cliente.pe_email" placeholder="Email" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_limite'))">
										</div>
										<div class="form-group col-md-4 col-12" ng-init="cliente.pe_limite = cliente[0].pe_limite">
											<label for="pe_limite">Limite de Crédito (R$)</label>
											<input type="text" class="form-control form-control-sm" id="PE_LIMITE" ng-model="cliente.pe_limite" ng-value="cliente.pe_limite" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_obs'))" money-dir>
										</div>
										<div class="form-group col-md-4 col-12" ng-init="cliente.pe_obs = cliente[0].pe_obs">
											<label for="pe_obs">Observações</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_obs" ng-model="cliente.pe_obs" ng-value="cliente.pe_obs" autocomplete="off" onKeyUp="tabenter(event,getElementById('BotaoSalvar'))">
										</div>
									</div>

									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="cliente.pe_nome" ng-click="cadastrarCliente(cliente.pe_nome, cliente.pe_fanta, cliente.pe_cpfcnpj, cliente.pe_rgie, cliente.pe_nascto, cliente.pe_cep, cliente.pe_endereco, cliente.pe_end_num, cliente.pe_end_comp, cliente.pe_bairro, cliente.pe_cidade, cliente.pe_uf, cliente.pe_fone, cliente.pe_email, cliente.pe_limite, cliente.pe_obs)"><i class="fas fa-save" id="BotaoSalvar"></i> Salvar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="!cliente.pe_nome" ng-click="verificaDados()"><i class="fas fa-save"></i> Salvar</md-button>
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
   	<script src="js/angular-locale_pt-br.js"></script>
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
			
			var originatorEv;
			this.openMenu = function($mdOpenMenu, ev) {
				originatorEv = ev;
				$mdOpenMenu(ev);
			};

			$scope.arrayNull = false;
		    $scope.tab = 1;
			$scope.lista = true;
			$scope.BotaoPesquisaCNPJ = false;
			$scope.ficha = false;
			$scope.situacao = 1;
			$scope.cidade = '';
			$scope.nomeCliente = '';
			$scope.ativo = 'S';
			$scope.cliente_fornecedor = 'pe_cliente';
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
			$scope.dadosCliente=[];
			$scope.empresa = '';
			$scope.cadastrar_alterar = 'C';
			$scope.cliente=[{
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

/*			 $scope.logPagination = function (page, limit) {
			    console.log('page: ', page);
			    console.log('limit: ', limit);
			};*/

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

/*		    var dadosClienteTotal = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&totalLista=S'
				}).then(function onSuccess(response){
					$scope.paginacao=response.data.result[0];
				}).catch(function onError(response){

				});
			};

			dadosClienteTotal(); */

			var dadosCliente = function () {
				$scope.dadosCliente=[];
				$scope.arrayNull = true;
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S&empresa='+$scope.empresa+'&cliente='+$scope.nomeCliente+'&cidade='+$scope.cidade
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
					if ($scope.dadosCliente.length <1) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Empresa não possui clientes cadastrados!";
						chamarAlerta();
					}
					$scope.arrayNull = false;
				}).catch(function onError(response){
					$scope.resultado=response.data;
					$scope.arrayNull = false;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosCliente();

			$scope.busca = function(empresa, buscaCliente, buscaCidade) {
				if (buscaCliente == undefined) {
					buscaCliente = '';
				}
				if (buscaCidade == undefined) {
					buscaCidade = '';
				}
				if (empresa == undefined) {
					empresa = '';
				}
				$scope.nomeCliente = buscaCliente;
				$scope.cidade = buscaCidade
				$scope.empresa = empresa;
				dadosCliente();
			}

			/*$scope.dadosClienteComFiltro = function () {
				$scope.dadosCliente=[];
				$scope.arrayNull = true;
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosCliente=response.data.result[0];
					if ($scope.dadosCliente.length <1) {
						$scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Empresa não possui clientes cadastrados!";
						chamarAlerta();
					}
					$scope.arrayNull = false;
				}).catch(function onError(response){
					$scope.arrayNull = false;
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};*/

			$scope.cadastrarCliente = function(pe_nome, pe_fanta, pe_cpfcnpj, pe_rgie, pe_nascto, pe_cep, pe_endereco, pe_end_num, pe_end_comp, pe_bairro, pe_cidade, pe_uf, pe_fone, pe_email, pe_limite, pe_obs, pe_foto){

		    	var pe_comp = null;
		    	if (pe_nome == undefined) {
		    		pe_nome = null;
		    	}
		    	if (pe_fanta == undefined) {
		    		pe_fanta = null;
		    	}
		    	if (pe_cpfcnpj == undefined) {
		    		pe_cpfcnpj = null;
		    	}
		    	if (pe_rgie == undefined) {
		    		pe_rgie = null;
		    	}
		    	if (pe_nascto == undefined) {
		    		pe_nascto = null;
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
		    	if (pe_limite == undefined) {
		    		pe_limite = 0;
		    	}
		    	if (pe_obs == undefined) {
		    		pe_obs = null;
		    	}

				$scope.cliente[0].pe_nome = pe_nome;
				$scope.cliente[0].pe_fanta = pe_fanta;
				$scope.cliente[0].pe_cpfcnpj= pe_cpfcnpj;
				$scope.cliente[0].pe_rgie = pe_rgie;
				$scope.cliente[0].pe_nascto = pe_nascto;
				$scope.cliente[0].pe_cep = pe_cep;
				$scope.cliente[0].pe_endereco = pe_endereco;
				$scope.cliente[0].pe_end_num = pe_end_num;
				$scope.cliente[0].pe_end_comp = pe_end_comp;
				$scope.cliente[0].pe_bairro = pe_bairro;
				$scope.cliente[0].pe_cidade = pe_cidade;
				$scope.cliente[0].pe_uf = pe_uf;
				$scope.cliente[0].pe_fone = pe_fone;
				$scope.cliente[0].pe_email = pe_email;
				$scope.cliente[0].pe_limite = pe_limite;
				$scope.cliente[0].pe_obs = pe_obs;

		    	SalvarCliente();
		    	MudarVisibilidadeLista(2);
		    	console.log($scope.cliente);
		    }

		    var SalvarCliente = function () {
				var	cliente = $scope.cliente;

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
					dadosCliente();
				}).catch(function onError(response){
					LimparCampos();
			    	alert("Erro!");

				})

			};

			$scope.editarCliente = function(pe_id){

				$http({
					method: 'GET',
					url: $scope.urlBase+'pesquisaCliente.php?id='+pe_id
				}).then(function onSuccess(response){
					$scope.cliente=response.data.result[0];
					$scope.cadastrar_alterar = 'E';
					MudarVisibilidadeLista(1);
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao editar cliente. Caso este erro persista, contate o suporte.");

				});

			}

			$scope.excluirCliente = function(pe_id,pe_nome){
				$http({
					method: 'GET',
					url: $scope.urlBase+'excluirCliente.php?id='+pe_id+'&us=<?=$us?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&cliente='+pe_nome
				}).then(function onSuccess(response){
					dadosCliente();

					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro: o cliente não pode ser excluido!";
						chamarAlerta();
					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Exclusão realizada com sucesso!";
						chamarAlerta();
					}

				}).catch(function onError(response){
					alert("Erro ao excluir cliente. Caso este erro persista, contate o suporte.");
				});
			}

			var LimparCampos = function(form) {

				//document.getElementById(this).reset();
				$scope.cliente=[{
					pe_id : '',
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

			}

			$scope.verarray = function(){
				console.log($scope.fornecedor)
			}

			$scope.detalheItens = false

			$scope.maisInfoCliente = function(pe_cod){
				
				$scope.detalheItens = false

				$http({
					method: 'GET',
					url:  $scope.urlBase+'ConsultaClienteFornecedor.php?infoCliente=S&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&pe_cod='+pe_cod
				}).then(function onSuccess(response){
					
					$scope.infoCliente = response.data;
					console.log($scope.infoCliente);
					$("#InfoCliente").modal("show");
				}).catch(function onError(response){})
			}

			

			$scope.pedidoDescricaoItensBusca = function(pedido){
				
				$http({
					method:'GET',
					url: $scope.urlBase+ 'ConsultaClienteFornecedor.php?descricaoItens=S&ped_doc='+pedido.ped_doc+'&matriz='+pedido.ped_matriz+'&empresa='+pedido.ped_empresa
				}).then(function onSuccess(response){
					$scope.pedidoDescricaoItens=response.data;
					$scope.ped = pedido;
					$scope.detalheItens = true
				}).catch(function onError(response){
					//$scope.pedidoDescricaoItens=response.data.result[0];
				})
			};

			$scope.pesquisarCEP = function(cep){

				var cep = cep.replace(/\D/g, '');
				$http({
					method: 'GET',
					url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
				}).then(function onSuccess(response){
					$scope.clientecep = response.data;
					$scope.cliente.pe_endereco = $scope.clientecep['logradouro'];
					$scope.cliente.pe_end_num = $scope.clientecep['numero'];
					$scope.cliente.pe_end_comp = $scope.clientecep['complemento'];
					$scope.cliente.pe_bairro = $scope.clientecep['bairro'];
					$scope.cliente.pe_cidade = $scope.clientecep['localidade'];
					$scope.cliente.pe_uf = $scope.clientecep['uf'];
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
					$scope.cliente.pe_nascto = response.data.abertura;
					$scope.cliente.pe_nome = response.data.nome;
					$scope.cliente.pe_fanta = response.data.fantasia
					$scope.cliente.pe_cep = response.data.cep;
					$scope.cliente.pe_endereco = response.data.logradouro;
					$scope.cliente.pe_end_num = response.data.numero;
					$scope.cliente.pe_end_comp = response.data.complemento;
					$scope.cliente.pe_bairro = response.data.bairro;
					$scope.cliente.pe_cidade = response.data.municipio;
					$scope.cliente.pe_uf = response.data.uf;
					$scope.cliente.pe_fone = response.data.telefone;
					$scope.cliente.pe_email = response.data.email;
					$scope.cliente.pe_obs = response.data.situacao;
				  }, function onError(response) {

				  });
			};

			$scope.formatarCNPJ = function(cpfcnpj){

				$http({
					method: 'GET',
					url: $scope.urlBase+'api/formataCPFCNPJ.php?cpfcnpj='+cpfcnpj+''
				}).then(function onSuccess(response) {
					console.log(response.data);
					$scope.cliente.pe_cpfcnpj = response.data;
				  }, function onError(response) {
				  });

			};

			function isValidCpf(cpf) {
				cpf = cpf.replace(/[^\d]+/g, '');
				if (cpf == '') return false;
				// Elimina CPFs invalidos conhecidos    
				if (cpf.length != 11 ||
				cpf == "00000000000" ||
				cpf == "11111111111" ||
				cpf == "22222222222" ||
				cpf == "33333333333" ||
				cpf == "44444444444" ||
				cpf == "55555555555" ||
				cpf == "66666666666" ||
				cpf == "77777777777" ||
				cpf == "88888888888" ||
				cpf == "99999999999")
				return false;
				// Valida 1o digito 
				var add = 0;
				for (var i = 0; i < 9; i++)
				add += parseInt(cpf.charAt(i)) * (10 - i);
				var rev = 11 - (add % 11);
				if (rev == 10 || rev == 11)
				rev = 0;
				if (rev != parseInt(cpf.charAt(9)))
				return false;
				// Valida 2o digito 
				add = 0;
				for (i = 0; i < 10; i++)
				add += parseInt(cpf.charAt(i)) * (11 - i);
				rev = 11 - (add % 11);
				if (rev == 10 || rev == 11)
				rev = 0;
				if (rev != parseInt(cpf.charAt(10)))
				return false;
				return true;
			};


		}).config(function($mdDateLocaleProvider, $httpProvider, $locationProvider) {
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
		})

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
	    });

	    function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},4000);
		};

		function tabenter(event,campo){
			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.select();
			}
		};

	</script>

</body>
</html>