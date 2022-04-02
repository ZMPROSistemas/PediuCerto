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

	.table th:focus {
		outline-color: transparent;
    	background: #333 !important;

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
						<li class="breadcrumb-item" aria-current="page">Administrativo</li>
						<li class="breadcrumb-item active" aria-current="page">Colaboradores</li>
<!--						<button type="" ng-click="verarray()" style="display:none;">ver array</button> -->
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>

	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">

							<div show-on-desktop>
						    	<div class="row bg-dark p-2 col-12" >
						    		<form class="col-12">
										<div class="form-row align-items-center">
		<?php if (base64_decode($empresa_acesso) == 0) {?>
											<div class="col-3">
												<select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="dadosColaboradorComFiltro(empresa)">
													<option value="">Todas as Empresas</option>
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
											<div class="col-3" style="text-align: right;">
										    	<md-button class="btnSalvar pull-right" style="border: 1px solid #279B2D; border-radius: 5px; right: 0 !important;" onclick="gerarpdf()">
													<md-tooltip md-direction="top" md-visible="tooltipVisible">Imprimir</md-tooltip>
							                      	<i class="fas fa-print" style=""></i> Imprimir
					    	                	</md-button>

			<!--			                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
						                                <i class="fas fa fa-print"></i> 
					                            </a>-->
									    	</div>
									    </div>
							   		</form>
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
										<tr dir-paginate="colaborador in dadosColaborador | filter:buscaRapida | orderBy:'sortKey':reverse | itemsPerPage:10">
											<td ng-bind="colaborador.pe_cod"></td>
											<td ng-bind="colaborador.pe_nome"></td>
											<td ng-bind="colaborador.pe_endereco"></td>
											<td ng-bind="colaborador.pe_cidade"></td>
											<td ng-bind="colaborador.pe_fone"></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
	<?php if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="editarColaborador(colaborador.pe_id)">Editar</a>
	<?php } ?>
	<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="excluirColaborador(colaborador.pe_id, colaborador.pe_nome)">Excluir</a>
	<?php }?>
					                                </div>
					                            </div>
											</td>


<!--					    		 				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-class="{ 'md-hover-full': hover }" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false">
					    		 				 	<md-fab-trigger>
									                	<md-button aria-label="menu" class="md-fab md-raised md-mini" ng-click="openDialog($event, item)">
									                  		<md-tooltip md-direction="top" md-visible="tooltipVisible" md-autohide="false">Menu</md-tooltip>
								                  			<i class="fa fa-ellipsis-v color-default-icon" aria-label="menu"></i>
									                	</md-button>
										         	</md-fab-trigger>

													<md-fab-actions>

											        <md-fab-actions>
										            	<md-button type="submit" aria-label="{{item.name}}"  class="md-fab md-raised md-mini" style="background-color:#585570;">
									                      <i class="fa fa-trash-alt" aria-label="menu" style="color:#fff;"></i>
									                  	</md-button>

									                  	<md-button type="submit" aria-label="{{item.name}}"  class="md-fab md-raised md-mini" style="background-color:#585570;">
									                      
									                  	</md-button>


									            	</md-fab-actions>
					    		 				</md-fab-speed-dial> -->

										</tr>
									</tbody>
								</table>
							    			<!--
							    			<div flex="5" ng-if="colaborador.pe_foto != ''">
							    				<img src="imagens_empresas/<?=base64_decode($us_id)?>/cliente_fornecedor/{{cliente.pe_foto}}" class="md-avatar" alt="">
							    			</div>

							    			<div flex="5" ng-if="colaborador.pe_foto == ''">
							    				<img src="images/imgpadrao.jpeg" class="md-avatar" alt="">
							    			</div>

							    		-->
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							</div><!-- Final Desktop -->
<!--							<div show-on-desktop>
							    <md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
							    <span>Lista de Colaboradores</span>
					    	</md-subheader>
				    		<md-list>
				    		 	<md-list-item class="md-3-line" ng-repeat="dados in dadosColaboradores" ng-click="null">
				    		 		<div class="md-list-item-text" layout="row" layout-align="space-around center">
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
				    		 			<div flex="10" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
				    		 			<div flex="20" ng-bind=""></div>
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
				    		</md-list>   -->
							<md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
	                      		<i class="fa fa-plus"></i>
    	                	</md-button>
					    </div>

					    <div ng-if="ficha">
							<div class="jumbotron p-3">
<!--							<md-content id="TabColaborador" style="background-color: transparent !important; background: rgba(0, 0, 0, .65) !important;">
								<md-tabs md-dynamic-height md-border-bottom>
									<md-tab label="Dados Pessoais">
										<md-content class="md-padding" style="background-color: transparent !important;"> -->
								<form>
									<div class="form-row">
										<div class="form-group col-md-10 col-12" ng-init="colaborador.pe_nome = colaborador[0].pe_nome">
											<label for="pe_nome">Nome</label>
											<input type="text" class="form-control form-control-sm capoTexto campoObrigatorio" id="pe_nome" ng-model="colaborador.pe_nome" ng-value="colaborador.pe_nome" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_vendedor'))">
										</div>
										<div class="form-group col-md-2 col-4" ng-init="colaborador.pe_vendedor = colaborador[0].pe_vendedor" style="text-align: center !important;">
											<label></label>
											<div class="form-check">
											    <div ng-if="colaborador.pe_vendedor == 'S'">
										            <input type="checkbox" ng-checked="true" class="form-check-input" id="pe_vendedor" ng-model="colaborador.pe_vendedor" ng-value="colaborador.pe_vendedor" onKeyUp="tabenter(event,getElementById('pe_cep'))"/>
													<label for="pe_vendedor">Vendedor</label>
											    </div>
											    <div ng-if="colaborador.pe_vendedor != 'S'">
										            <input type="checkbox" ng-checked="false" class="form-check-input" id="pe_vendedor" ng-model="colaborador.pe_vendedor" ng-value="colaborador.pe_vendedor" onKeyUp="tabenter(event,getElementById('pe_cep'))"/>
													<label for="pe_vendedor">Vendedor</label>
											    </div>
											</div>
										</div>
										<div class="form-group col-md-2 col-6">
											<label for="pe_cep">CEP</label>
											<div class="input-group" ng-init="colaborador.pe_cep = colaborador[0].pe_cep">
												<input type="text" class="form-control form-control-sm capoTexto" id="pe_cep" ng-model="colaborador.pe_cep" ng-value="colaborador.pe_cep" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pesqCep'))" cep-dir>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" id="pesqCep" style="color: white;" ng-click="pesquisarCEP(colaborador.pe_cep)" onKeyUp="tabenter(event,getElementById('pe_end_num'))">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-6 col-9" ng-init="colaborador.pe_endereco = colaborador[0].pe_endereco">
											<label for="pe_endereco">Endereço</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_endereco" ng-model="colaborador.pe_endereco" ng-value="colaborador.pe_endereco" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_num'))">
										</div>
										<div class="form-group col-md-1 col-3" ng-init="colaborador.pe_end_num = colaborador[0].pe_end_num">
											<label for="pe_end_num">Número</label>
											<input type="number" class="form-control form-control-sm" id="pe_end_num" ng-model="colaborador.pe_end_num" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_end_comp'))">
										</div>
										<div class="form-group col-md-3 col-3" ng-init="colaborador.pe_end_comp = colaborador[0].pe_end_comp">
											<label for="pe_end_comp">Complemento</label>
											<input type="text" class="form-control form-control-sm" id="pe_end_comp" ng-model="colaborador.pe_end_comp" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_bairro'))">
										</div>
										<div class="form-group col-md-4 col-5" ng-init="colaborador.pe_bairro = colaborador[0].pe_bairro">
											<label for="pe_bairro">Bairro</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_bairro" ng-model="colaborador.pe_bairro" ng-value="colaborador.pe_bairro" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_cidade'))">
										</div>
										<div class="form-group col-md-6 col-7" ng-init="colaborador.pe_cidade = colaborador[0].pe_cidade">
											<label for="pe_cidade">Cidade</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_cidade" ng-model="colaborador.pe_cidade" ng-value="colaborador.pe_cidade" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_uf'))">
										</div>
										<div class="form-group col-md-2 col-2" ng-init="colaborador.pe_uf = colaborador[0].pe_uf">
											<label for="pe_uf">Estado</label>
											<select class="form-control form-control-sm" id="pe_uf" ng-model="colaborador.pe_uf" ng-value="colaborador.pe_uf" onKeyUp="tabenter(event,getElementById('pe_fone'))">
												<option selected>Selecione</option>
<?php

foreach ($UF as $UF) {?>
												<option value="<?=$UF['sigla']?>"><?=$UF['nome']?></option>
<?php }?>

											</select>
										</div>
										<div class="form-group col-md-3 col-5" ng-init="colaborador.pe_fone = colaborador[0].pe_fone">
											<label for="pe_fone">Telefone 1</label>
											<input type="text" class="form-control form-control-sm" id="pe_fone" ng-model="colaborador.pe_fone" ng-value="colaborador.pe_fone" placeholder="Somente números, com DDD" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_celular'))" phone-dir>
										</div>
										<div class="form-group col-md-3 col-5" ng-init="colaborador.pe_celular = colaborador[0].pe_celular">
											<label for="pe_celular">Telefone 2</label>
											<input type="text" class="form-control form-control-sm" id="pe_celular" ng-model="colaborador.pe_celular" ng-value="colaborador.pe_celular" placeholder="Somente números, com DDD" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_email'))" phone-dir>
										</div>
										<div class="form-group col-md-3 col-5" ng-init="colaborador.pe_email = colaborador[0].pe_email">
											<label for="pe_email">Email</label>
											<input type="text" class="form-control form-control-sm" id="pe_email" ng-model="colaborador.pe_email" ng-value="colaborador.pe_email" placeholder="Email" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_funcao'))">
										</div>
										<div class="form-group col-md-3 col-6">
											<label for="pe_funcao">Função</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_funcao" ng-model="colaborador.pe_funcao" ng-value="colaborador.pe_funcao" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_cpfcnpj'))">
										</div>
										<div class="form-group col-md-3 col-12">
											<label for="pe_cpfcnpj">CPF</label>
											<div class="input-group" ng-init="colaborador.pe_cpfcnpj = colaborador[0].pe_cpfcnpj">
												<input type="text" id="pe_cpfcnpj" class="form-control form-control-sm" ng-model="colaborador.pe_cpfcnpj" ng-value="colaborador.pe_cpfcnpj" placeholder="Somente números" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_rgie'))" ng-blur="formatarCNPJ(colaborador.pe_cpfcnpj)" maxlength="14">
												<div class="input-group-btn"  ng-if="colaborador.pe_cpfcnpj.length >= 14 ? BotaoPesquisaCNPJ = true : BotaoPesquisaCNPJ = false" ng-show="BotaoPesquisaCNPJ">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" ng-click="pesquisarCNPJ(colaborador.pe_cpfcnpj)" >
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md-3 col-6" ng-init="colaborador.pe_rgie = colaborador[0].pe_rgie">
											<label for="pe_rgie">RG</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_rgie" ng-model="colaborador.pe_rgie" ng-value="colaborador.pe_rgie" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_obs'))">
										</div>
										<div class="form-group col-md-6 col-6">
											<label for="pe_funcao">Observações</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="pe_funcao" ng-model="colaborador.pe_funcao" ng-value="colaborador.pe_funcao" autocomplete="off" onKeyUp="tabenter(event,getElementById('BotaoSalvar))">
										</div>
									</div>
									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="colaborador.pe_nome" ng-click="cadastrarColaborador(colaborador.pe_nome, colaborador.pe_vendedor, colaborador.pe_cep, colaborador.pe_endereco, colaborador.pe_end_num, colaborador.pe_end_comp, colaborador.pe_bairro, colaborador.pe_cidade, colaborador.pe_uf, colaborador.pe_fone, colaborador.pe_celular, colaborador.pe_email, colaborador.pe_funcao, colaborador.pe_cpfcnpj, colaborador.pe_rgie, colaborador.pe_obs)"><i class="fas fa-save" id="BotaoSalvar"></i> Salvar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="!colaborador.pe_nome" ng-click="verificaDados()"><i class="fas fa-save"></i> Salvar</md-button>
								</form>
<!--										</md-content>
									</md-tab>
									<md-tab label="Dados Adicionais" >
										<md-content class="md-padding" style="background-color: transparent !important;">
											<form>
												<div class="form-row">
													<div class="form-group col-md-3 col-6">
														<label for="pe_cadastro">Admissão</label>
														<input type="text" class="form-control form-control-sm capoTexto" id="pe_cadastro" ng-model="colaborador.pe_cadastro" ng-value="colaborador.pe_cadastro" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_trabalho'))">
													</div>
													<div class="form-group col-md-4 col-3">
														<label for="pe_trabalho">Departamento</label>
														<input type="text" class="form-control form-control-sm capoTexto" id="pe_trabalho" ng-model="colaborador.pe_trabalho" ng-value="colaborador.pe_trabalho" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_regiao'))">
													</div>
													<div class="form-group col-md-3 col-3">
														<label for="pe_regiao">Código Interno</label>
														<input type="text" class="form-control form-control-sm capoTexto" id="pe_regiao" ng-model="colaborador.pe_regiao" ng-value="colaborador.pe_regiao" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_funcao'))">
													</div>
													<div class="form-group col-md-2 col-4" style="text-align: center !important;">
														<label></label>
														<div class="form-check">
															<input type="checkbox" class="form-check-input" id="check">
															<label for="check">Garçom</label>
														</div>
													</div>
													<div class="form-group col-md-3 col-5">
														<label for="pe_descto">Desconto Permitido</label>
														<input type="text" class="form-control form-control-sm capoTexto" id="pe_descto" ng-model="colaborador.pe_decto" ng-value="colaborador.pe_descto" autocomplete="off" onKeyUp="tabenter(event,getElementById('pe_funcao'))">
													</div>
													<div class="form-group col-md-2 col-4">
														<label for="">Comissionado</label>
														<select class="form-control form-control-sm" id="">
															<option selected>Selecione</option>
															<option ng-value="S">Sim</option>
															<option ng-value="N">Não</option>
														</select>
													</div>
													<div class="form-group col-md-2 col-4">
														<label for="">Comissão À Vista (%)</label>
														<input type="text" class="form-control form-control-sm" id="">
													</div>
													<div class="form-group col-md-2 col-4">
														<label for="">Comissão À Prazo</label>
														<input type="text" class="form-control form-control-sm" id="">
													</div>
													<div class="form-group col-md-3 col-5">
														<label for="">Pagamento da Comissão</label>
														<select class="form-control form-control-sm" id="">
															<option selected>Selecione</option>
															<option ng-value="Venda">Na Venda</option>
															<option ng-value="Recebimento">No Recebimento</option>
														</select>
													</div>
													<div class="form-group col-md-12 col-12">
														<label for="">Foto</label>
														<input type="file" class="form-control-file" id="">
													</div>
													<div class="form-group col-md-12 col-12">
														<label for="">Observações</label>
														<textarea rows="3" class="form-control form-control-sm" id=""></textarea>
													</div>

												</div> 
												<button type="submit" class="btn btn-outline-success" ng-click="SalvarCliente()" ng-if="VerificaObrigatorios"><i class="fas fa-save"></i> Salvar</button>
												<button type="submit" class="btn btn-outline-danger" style="color: white;" ng-click="MudarVisibilidade()"><i class="fas fa-window-close"></i> Cancelar</button>
											</form>
										</md-content>
									</md-tab>
								</md-tabs>
							</md-content> -->
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
	<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

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
			$scope.cliente_fornecedor = 'pe_colaborador';
			$scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.dadosColaborador=[];

			$scope.colaborador=[{
				pe_id : '',
				pe_cod: '',
				pe_nome : '',
				pe_vendedor : '',
				pe_cep : '',
				pe_endereco : '',
				pe_end_num : '',
				pe_end_comp : '',
				pe_bairro : '',
				pe_cidade : '',
				pe_uf : '',
				pe_fone : '',
				pe_celular : '',
				pe_email : '',
				pe_funcao : '',
				pe_cpfcnpj : '',
				pe_rgie : '',
				pe_obs : '',
			}];

			$scope.cadastrar_alterar = 'C';

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";

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


			var dadosColaborador = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S'
				}).then(function onSuccess(response){
					$scope.dadosColaborador=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar colaboradores. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			$scope.dadosColaboradorComFiltro = function (empresa) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'ConsultaClienteFornecedor.php?dadosCliente=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&situacao='+$scope.situacao+'&ativo='+$scope.ativo+'&dados=S&empresa='+empresa
				}).then(function onSuccess(response){
					$scope.dadosColaborador=response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar clientes. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			dadosColaborador();

			$scope.cadastrarColaborador = function(pe_nome, pe_vendedor, pe_cep, pe_endereco, pe_end_num, pe_end_comp, pe_bairro, pe_cidade, pe_uf, pe_fone, pe_celular,  pe_email, pe_funcao, pe_cpfcnpj, pe_rgie, pe_obs){

		    	var pe_comp = null;

		    	if (pe_nome == undefined) {
		    		pe_nome = null;
		    	}
		    	if (pe_vendedor == true) {
		    		pe_vendedor = 'S';
		    	} else {
		    		pe_vendedor = 'N';
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
		    	if (pe_celular == undefined) {
		    		pe_celular = null;
		    	}
		    	if (pe_email == undefined) {
		    		pe_email = null;
		    	}
		    	if (pe_funcao == undefined) {
		    		pe_funcao = null;
		    	}
		    	if (pe_cpfcnpj == undefined) {
		    		pe_cpfcnpj = null;
		    	}
		    	if (pe_rgie == undefined) {
		    		pe_rgie = null;
		    	}
		    	if (pe_obs == undefined) {
		    		pe_obs = null;
		    	}

				$scope.colaborador[0].pe_nome = pe_nome;
				$scope.colaborador[0].pe_vendedor = pe_vendedor;
				$scope.colaborador[0].pe_cep = pe_cep;
				$scope.colaborador[0].pe_endereco = pe_endereco;
				$scope.colaborador[0].pe_end_num = pe_end_num;
				$scope.colaborador[0].pe_end_comp = pe_end_comp;
				$scope.colaborador[0].pe_bairro = pe_bairro;
				$scope.colaborador[0].pe_cidade = pe_cidade;
				$scope.colaborador[0].pe_uf = pe_uf;
				$scope.colaborador[0].pe_fone = pe_fone;
				$scope.colaborador[0].pe_celular = pe_celular;
				$scope.colaborador[0].pe_email = pe_email;
				$scope.colaborador[0].pe_funcao = pe_funcao;
				$scope.colaborador[0].pe_cpfcnpj= pe_cpfcnpj;
				$scope.colaborador[0].pe_rgie = pe_rgie;
				$scope.colaborador[0].pe_obs = pe_obs;

		    	SalvarColaborador();
		    	MudarVisibilidadeLista(2);
		    	console.log($scope.colaborador);
		    }

		    var SalvarColaborador = function () {
				var	cliente = $scope.colaborador;

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

					//LimparCampos();
					dadosColaborador();
				}).catch(function onError(response){
			    	alert("Erro!");

				})

			};

			$scope.editarColaborador = function(pe_id){

				$http({
					method: 'GET',
					url: $scope.urlBase+'pesquisaCliente.php?id='+pe_id
				}).then(function onSuccess(response){
					$scope.colaborador=response.data.result[0];

					$scope.cadastrar_alterar = 'E';
					MudarVisibilidadeLista(1);
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao editar colaborador. Caso este erro persista, contate o suporte.");

				});

			}

			$scope.verarray = function(){
				console.log($scope.colaborador)
			}



			$scope.excluirColaborador = function(pe_id, pe_nome){
				$http({
					method: 'GET',
					url: $scope.urlBase+'excluirCliente.php?id='+pe_id+'&us=<?=$us?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&cliente='+pe_nome
				}).then(function onSuccess(response){
					dadosColaborador();

					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro: o colaborador não pode ser excluido!";
						chamarAlerta();
					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Exclusão realizada com sucesso!";
						chamarAlerta();
					}

				}).catch(function onError(response){
					alert("Erro ao excluir colaborador. Caso este erro persista, contate o suporte.");
				});
			}

			var LimparCampos = function(form) {

				//document.getElementById(this).reset();
				$scope.colaborador=[{
					pe_id : '',
					pe_nome : '',
					pe_fanta : '',
					pe_cpfcnpj : '',
					pe_rgie : '',
					pe_nascto : '',
					pe_cep : '',
					pe_endereco : '',
					pe_comp : '',
					pe_numero : '',
					pe_bairro : '',
					pe_cidade : '',
					pe_uf : '',
					pe_fone : '',
					pe_email : '',
					pe_limite : '',
					pe_obs : '',
				}];

			}

		    $scope.setTab = function(newTab){
		      $scope.tab = newTab;
		    };

		    $scope.isSet = function(tabNum){
		      return $scope.tab === tabNum;
		    };

		    $scope.MudarVisibilidade = function() {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;

		    }

			$scope.pesquisarCEP = function(cep){

				var cep = cep.replace(/\D/g, '');
				$http({
					method: 'GET',
					url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
				}).then(function onSuccess(response){
					$scope.clientecep = response.data;
					$scope.colaborador.pe_endereco = $scope.clientecep['logradouro'];
					$scope.colaborador.pe_end_num = $scope.clientecep['numero'];
					$scope.colaborador.pe_end_comp = $scope.clientecep['complemento'];
					$scope.colaborador.pe_bairro = $scope.clientecep['bairro'];
					$scope.colaborador.pe_cidade = $scope.clientecep['localidade'];
					$scope.colaborador.pe_uf = $scope.clientecep['uf'];
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
					$scope.colaborador.pe_nome = response.data.nome;
					$scope.colaborador.pe_cep = response.data.cep;
					$scope.colaborador.pe_endereco = response.data.logradouro;
					$scope.colaborador.pe_end_num = response.data.numero;
					$scope.colaborador.pe_end_comp = response.data.complemento;
					$scope.colaborador.pe_bairro = response.data.bairro;
					$scope.colaborador.pe_cidade = response.data.municipio;
					$scope.colaborador.pe_uf = response.data.uf;
					$scope.colaborador.pe_fone = response.data.telefone;
					$scope.colaborador.pe_email = response.data.email;
					$scope.colaborador.pe_obs = response.data.situacao;
				  }, function onError(response) {

				  });
			};

			$scope.formatarCNPJ = function(cpfcnpj){

				$http({
					method: 'GET',
					url: $scope.urlBase+'api/formataCPFCNPJ.php?cpfcnpj='+cpfcnpj+''
				}).then(function onSuccess(response) {
					console.log(response.data);
					$scope.colaborador.pe_cpfcnpj = response.data;
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