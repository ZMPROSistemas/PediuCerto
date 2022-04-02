<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

$em_cep = "";
$em_end = "";
$em_cid = "";
$em_bairro = "";
$em_uf = "";
$num_end = "";
$em_razao = "1";
$em_fanta = "";
$em_end_num = "";
$em_fone = "";
$em_email = "";
$em_insc = "";

?>

<style>

	.btnCancelar:hover{
		background-color: #bf0000 !important;
		color:#fff;
	}

	.btnSalvar:hover{
		background-color: #279B2D !important;
		color:#fff;
	}

	/* alerta*/

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
	  margin-right: auto; 
	}

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
						<li class="breadcrumb-item active" aria-current="page">Empresas</li>
					</ol>
				</nav>
				<!--<button type="" ng-click="verarray()" style="display:none">ver array</button>-->

				<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
				  {{alertMsg}}
				</div>


	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">
					    	<div class="row bg-dark m-0">
								<div class="form-group col-md-6 col-12 pt-3">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
										<div class="input-group-btn">
											<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;">
												<i class="fas fa fa-search" ></i>
											</button>
										</div>
									</div>
						    	</div>
						    </div>
<!--
					    	<md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
							    <span>Empresas Cadastradas</span>
					    	</md-subheader>
-->
							<div show-on-desktop>
								<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
									<thead class="thead-dark">
										<tr style="font-size: 1.1em !important;">
											<th scope="col" style=" font-weight: normal;">Código</th>
											<th scope="col" style=" font-weight: normal;">Razão Social</th>
											<th scope="col" style=" font-weight: normal;">Nome Fantasia</th>
											<th scope="col" style=" font-weight: normal;">Cidade</th>
											<th scope="col" style=" font-weight: normal;">Telefone</th>
											<th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody >
										<tr ng-repeat="emp in dadosEmpresa | filter:buscaRapida | orderBy:'sortKey':reverse " >
											<td ng-bind="emp.em_cod"></td>
											<td ng-bind="emp.em_razao"></td>
											<td ng-bind="emp.em_fanta"></td>
											<td ng-bind="emp.em_cid"></td>
											<td ng-bind="emp.em_fone"></td>
											<td style="text-align: center;">
												<div class="btn-group dropleft">
													<button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
					                                    <i class="fas fa-ellipsis-v"></i> 
					                                </button>
					                                <div class="dropdown-menu">
		<?php if (substr($me_empresa, 3, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="editarEmpresa(emp.em_cod)">Editar</a>

		<?php }if (substr($me_empresa, 2, 1) == 'S') {?>
					                                	<a class="dropdown-item" ng-click="excluirEmpresa(emp.em_cod, emp.em_cnpj)">Excluir</a>

		<?php }?>
					                                </div>
					                            </div>
											</td>
										</tr>
									</tbody>
								</table>
								<dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
							</div><!-- Final Desktop -->

							    			<!--
							    			<div flex="5" ng-if="cliente.pe_foto != ''">
							    				<img src="imagens_empresas/<?=base64_decode($us_id)?>/cliente_fornecedor/{{cliente.pe_foto}}" class="md-avatar" alt="">
							    			</div>

							    			<div flex="5" ng-if="cliente.pe_foto == ''">
							    				<img src="images/imgpadrao.jpeg" class="md-avatar" alt="">
							    			</div>

							    		-->



<?php if (substr($me_empresa, 1, 1) == 'S') {?>

						    <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
		                      		<i class="fa fa-plus"></i>

		                   	</md-button>
<?php }?>

		             	</div> <!--Final lista -->

						<div ng-if="ficha">
			             	<div class="jumbotron p-2">
								<form id="CadEmpresa" autocomplete="off">
									<div class="form-row">
										<div class="form-group col-md-4 col-10">
											<label for="em_cnpj">CPF / CNPJ*</label>
											<div class="input-group" ng-init="empresa.em_cnpj = empresa[0].em_cnpj">
												<input type="text" id="em_cnpj" class="form-control form-control-sm" ng-model="empresa.em_cnpj" ng-value="empresa.em_cnpj" placeholder="Somente Números" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_insc'))" ng-blur="formatarCNPJ(empresa.em_cnpj)" maxlength="14">
												<div class="input-group-btn" ng-if="empresa.em_cnpj.length >= 14 ? BotaoPesquisaCNPJ = true : BotaoPesquisaCNPJ = false" ng-show="BotaoPesquisaCNPJ">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" ng-click="pesquisarCNPJ(empresa.em_cnpj)">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>

										<div class="form-group col-md-4 col-4" ng-init="empresa.em_insc = empresa[0].em_insc">
											<label for="em_insc">RG / Insc. Estadual</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="em_insc" ng-model="empresa.em_insc" ng-value="empresa.em_insc" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_responsavel'))">
										</div>

										<div class="form-group col-md-4 col-6" ng-init="empresa.em_responsavel = empresa[0].em_responsavel">
											<label for="em_responsavel">Contato / Responsável</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="em_responsavel" ng-model="empresa.em_responsavel" ng-value="empresa.em_responsavel" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_razao'))">
										</div>

										<div class="form-group col-md-6 col-12" ng-init="empresa.em_razao = empresa[0].em_razao">
											<label for="em_razao">Nome / Razao Social*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio" id="em_razao" ng-model="empresa.em_razao" ng-value="empresa.em_razao" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_fanta'))">
										</div>

										<div class="form-group col-md-6 col-12" ng-init="empresa.em_fanta = empresa[0].em_fanta">
											<label for="em_fanta">Apelido / Nome Fantasia*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio capoTexto" id="em_fanta" ng-model="empresa.em_fanta" ng-value="empresa.em_fanta" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_email'))">
										</div>

										<div class="form-group col-md-3 col-7" ng-init="empresa.em_email = empresa[0].em_email">
											<label for="em_email">Email*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio" id="em_email" ng-model="empresa.em_email" ng-value="empresa.em_email" placeholder="Email" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_cep'))">
										</div>

										<div class="form-group col-md-2 col-5">
											<label for="em_cep">CEP*</label>
											<div class="input-group" ng-init="empresa.em_cep = empresa[0].em_cep">
												<input type="text" class="form-control form-control-sm campoObrigatorio" ng-blur="formatarCampo(empresa.em_cep)" id="em_cep" ng-model="empresa.em_cep" ng-value="empresa.em_cep" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_end_num'))" cep-dir>
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" id="cep" ng-click="pesquisarCEP(empresa.em_cep)">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>

										<div class="form-group col-md-6 col-9" ng-init="empresa.em_end = empresa[0].em_end">
											<label for="em_end">Endereço*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio capoTexto" id="em_end" ng-model="empresa.em_end" ng-value="empresa.em_end" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_end_num'))" >
										</div>

										<div class="form-group col-md-1 col-3" ng-init="empresa.em_end_num = empresa[0].em_end_num">
											<label for="em_end_num">Número*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio" id="em_end_num" ng-model="empresa.em_end_num" ng-value="empresa.em_end_num"  autocomplete="off" onKeyUp="tabenter(event,getElementById('em_bairro'))" >
										</div>

										<div class="form-group col-md-3 col-4" ng-init="empresa.em_bairro = empresa[0].em_bairro">
											<label for="em_bairro">Bairro*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio capoTexto" id="em_bairro" ng-model="empresa.em_bairro" ng-value="empresa.em_bairro" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_cid'))" >
										</div>

										<div class="form-group col-md-4 col-6" ng-init="empresa.em_cid = empresa[0].em_cid">
											<label for="em_cid">Cidade*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio capoTexto" id="em_cid" ng-model="empresa.em_cid" ng-value="empresa.em_cid" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_uf'))">
										</div>

										<div class="form-group col-md-2 col-2" ng-init="empresa.em_uf = empresa[0].em_uf">
											<label for="em_uf">Estado*</label>
											<select class="form-control form-control-sm campoObrigatorio" id="em_uf" ng-model="empresa.em_uf" ng-value="em_uf" onKeyUp="tabenter(event,getElementById('em_fone'))" >
												<option selected >Selecione</option>
<?php

foreach ($UF as $UF) {?>
												<option value="<?=$UF['sigla']?>"><?=$UF['nome']?></option>
<?php }?>
											</select>
										</div>

										<div class="form-group col-md-3 col-5" ng-init="empresa.em_fone = empresa[0].em_fone">
											<label for="em_fone">Telefone*</label>
											<input type="text" class="form-control form-control-sm campoObrigatorio" id="em_fone" ng-model="empresa.em_fone" ng-value="empresa.em_fone" placeholder="Somente números, com DDD" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_cont_nome'))" phone-dir>
										</div>

										<div class="form-group col-md-4 col-7" ng-init="empresa.em_cont_nome = empresa[0].em_cont_nome">
											<label for="em_cont_nome">Contador</label>
											<input type="text" class="form-control form-control-sm capoTexto" id="em_cont_nome" ng-model="empresa.em_cont_nome" ng-value="empresa.em_cont_nome" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_cont_email'))" >
										</div>

										<div class="form-group col-md-2 col-6" ng-init="empresa.em_cont_email = empresa[0].em_cont_email">
											<label for="em_cont_email">Email do Contador</label>
											<input type="email" class="form-control form-control-sm" id="em_cont_email" ng-model="empresa.em_cont_email" ng-value="empresa.em_cont_email" placeholder="Email do Contador" autocomplete="off" onKeyUp="tabenter(event,getElementById('em_cont_fone'))">
										</div>

										<div class="form-group col-md-4 col-6" ng-init="empresa.em_cont_fone = empresa[0].em_cont_fone">
											<label for="em_cont_fone">Telefone do Contador</label>
											<input type="text" class="form-control form-control-sm" id="em_cont_fone" ng-model="empresa.em_cont_fone" ng-value="empresa.em_cont_fone" placeholder="Somente números, com DDD" autocomplete="off"  onKeyUp="tabenter(event,getElementById('BotaoSalvar'))" phone-dir>
										</div>

										<div class="form-group col-md-2 col-6" ng-init="empresa.em_logo = empresa[0].em_logo">
											<label for="em_logo_em">Logo</label>

											<md-button ng-click='click()' class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;">Carregar Logo</md-button>

											<img src="{{empresa[0].em_logo}}" class="md-3-line" width="50" style="margin-left: 20px;" alt="">
											<!--<input name="logo" type="file" class="form-control form-control-sm" ng-model="empresa.em_logo" ng-value="empresa.em_logo">-->
										</div>
									</div>

									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="empresa.em_cnpj && empresa.em_razao && empresa.em_fanta && empresa.em_email && empresa.em_cep && empresa.em_end && empresa.em_end_num && empresa.em_bairro && empresa.em_cid && empresa.em_uf && empresa.em_fone" ng-click="cadastrarEmpresa(empresa.em_cnpj,empresa.em_insc,empresa.em_responsavel,empresa.em_razao,empresa.em_fanta,empresa.em_email,empresa.em_cep,empresa.em_end,empresa.em_end_num,empresa.em_bairro,empresa.em_cid,empresa.em_uf,empresa.em_fone,empresa.em_cont_nome,empresa.em_cont_email,empresa.em_cont_fone, empresa.em_logo)"><i class="fas fa-save"></i> Salvar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-if="!empresa.em_cnpj || !empresa.em_razao || !empresa.em_fanta || !empresa.em_email || !empresa.em_cep || !empresa.em_end || !empresa.em_end_num || !empresa.em_bairro || !empresa.em_cid || !empresa.em_uf || !empresa.em_fone" ng-click="verificaDados()"><i class="fas fa-save"></i> Salvar</md-button>

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

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;

			$scope.urlBase="services/";
			$scope.dadosEmpresa=[];

			$scope.empresa=[{

					em_cod:'',
		    		em_cnpj: '',
		    		em_insc: '',
		    		em_responsavel: '',
		    		em_razao: '',
		    		em_fanta: '',
		    		em_email: '',
		    		em_cep: '',
		    		em_end: '',
		    		em_comp: '',
		    		em_end_num: '',
		    		em_bairro: '',
		    		em_cid: '',
		    		em_uf: '',
		    		em_fone: '',
		    		em_cont_nome: '',
		    		em_cont_email: '',
		    		em_cont_fone: '',
		    		em_logo: '',
		    	}];

			$scope.empresaCad=[];
			$scope.cadastrar_alterar = 'C';

			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro Realizado com sucesso";

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

		    };

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

		    $scope.click = function() {
		      $scope.data.alert = "Seu navegador não suporta HTML 5 type='File'"
		    }

		    var fileSelect = document.createElement('input');
    		fileSelect.type = 'file';

    		if (fileSelect.disabled) {
		      return;
		    }

		    $scope.click = function() { //activate function to begin input file on click
		      fileSelect.click();
		    }

		    fileSelect.onchange = function() {

		    	var f = fileSelect.files[0],
	    		r = new FileReader();

	    		r.onloadend = function(e) {
	    			$scope.empresa[0].em_logo = e.target.result;
	    			$scope.$apply();
	    			console.log($scope.empresa[0].em_logo);
	    			//console.log($scope.data.b64.replace(/^data:image\/(png|jpg);base64,/, ""));
	    		}
	    		r.readAsDataURL(f);
		    };

		    $scope.cadastrarEmpresa = function(em_cnpj, em_insc, em_responsavel, em_razao, em_fanta, em_email, em_cep, em_end, em_end_num, em_bairro, em_cid, em_uf, em_fone, em_cont_nome, em_cont_email, em_cont_fone){

		    	var em_comp = null;

		    	if (em_cnpj == undefined) {
		    		em_cnpj = null;
		    	}
		    	if (em_insc == undefined) {
		    		em_insc = null;
		    	}
		    	if (em_responsavel == undefined) {
		    		em_responsavel = null;
		    	}
		    	if (em_razao == undefined) {
		    		em_razao = null;
		    	}
		    	if (em_fanta == undefined) {
		    		em_fanta = null;
		    	}
		    	if (em_email == undefined) {
		    		em_email = null;
		    	}
		    	if (em_cep == undefined) {
		    		em_cep = null;
		    	}

		    	if (em_end_num == undefined) {
		    		em_end_num = null;
		    	}
		    	if (em_bairro == undefined) {
		    		em_bairro = null;
		    	}
		    	if (em_uf == undefined) {
		    		em_uf = null;
		    	}
		    	if (em_fone == undefined) {
		    		em_fone = null;
		    	}
		    	if (em_cont_nome == undefined) {
		    		em_cont_nome = null;
		    	}
		    	if (em_cont_email == undefined) {
		    		em_cont_email = null;
		    	}
		    	if (em_cont_fone == undefined) {
		    		em_cont_fone = null;
		    	}
		    	if (em_cid == undefined) {
		    		em_cid = null;
		    	}
		    	if (em_end == undefined) {
		    		em_end = null;
		    	}
		    	/*if (em_logo == undefined) {
		    		em_logo = null;
		    	}*/

		    	$scope.empresa[0].em_cnpj = em_cnpj;
	    		$scope.empresa[0].em_insc = em_insc;
	    		$scope.empresa[0].em_responsavel = em_responsavel;
	    		$scope.empresa[0].em_razao = em_razao;
	    		$scope.empresa[0].em_fanta = em_fanta;
	    		$scope.empresa[0].em_email = em_email;
	    		$scope.empresa[0].em_cep = em_cep;
	    		$scope.empresa[0].em_end = em_end;
	    		$scope.empresa[0].em_comp = em_comp;
	    		$scope.empresa[0].em_end_num = em_end_num;
	    		$scope.empresa[0].em_bairro = em_bairro;
	    		$scope.empresa[0].em_cid = em_cid;
	    		$scope.empresa[0].em_uf = em_uf;
	    		$scope.empresa[0].em_fone = em_fone;
	    		$scope.empresa[0].em_cont_nome = em_cont_nome;
	    		$scope.empresa[0].em_cont_email = em_cont_email;
	    		$scope.empresa[0].em_cont_fone = em_cont_fone;
	    		//$scope.empresa[0].em_logo = em_logo;

		    	SalvarEmpresa();
		    	MudarVisibilidadeLista(2);
		    	console.log($scope.empresa);
		    }

		    $scope.isSet = function(tabNum) {
		      return $scope.tab === tabNum;
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

			var SalvarEmpresa = function () {

				var	empresa = $scope.empresa;

				$http({
					method: 'POST',
					 headers: {
			           'Content-Type':'application/json'
			         },
			          data: {
			          	empresa
			          },
			          url: $scope.urlBase+'SalvaCad.php?editarCadastrar='+$scope.cadastrar_alterar+'&e=+<?=$empresa?>&cnpn_matriz=<?=$cnpj_matriz?>&ramo=<?=$em_ramo?>&us=<?=$us?>'
				}).then(function onSuccess(response){
					dadosEmpresa();

					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						if ($scope.cadastrar_alterar == 'C') {
							$scope.alertMsg = "Erro A Realizar Cadastro!";
						}
						if ($scope.cadastrar_alterar == 'C') {
							$scope.alertMsg = "Erro Ao Editar Cadastro!";
						}
						chamarAlerta();

					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";

						if ($scope.cadastrar_alterar == 'C') {
						$scope.alertMsg = "Cadastro Realizado com sucesso!";
						}

						if ($scope.cadastrar_alterar == 'E') {
							$scope.alertMsg = "Cadastro Editado com sucesso!";
						}
						chamarAlerta();
					}

					LimparCampos();
				}).catch(function onError(response){

				})

			};

			$scope.editarEmpresa = function(em_cod){

				$http({
					method: 'GET',
					url: $scope.urlBase+'pesquisaEmpresa.php?id='+em_cod
				}).then(function onSuccess(response){
					$scope.empresa=response.data.result[0];

					$scope.cadastrar_alterar = 'E';
					MudarVisibilidadeLista(1);
				}).catch(function onError(response){
					$scope.resultado=response.data;
					alert("Erro ao carregar empresas. Caso este erro persista, contate o suporte.");

				});

			}

			$scope.excluirEmpresa = function(em_cod,em_cnpj){
				$http({
					method: 'GET',
					url: $scope.urlBase+'excluirEmpresa.php?id='+em_cod+'&us=<?=$us?>&cnpj='+em_cnpj
				}).then(function onSuccess(response){
					dadosEmpresa();

					if (response.data == 0) {
						$scope.tipoAlerta = "alert-danger";
						$scope.alertMsg = "Erro A Empresa Não pode Ser Excluida!";
						chamarAlerta();
					}
					if (response.data == 1) {
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Exclusão Realizado com sucesso!";
						chamarAlerta();
					}

				}).catch(function onError(response){
					alert("Erro ao deletar empresas. Caso este erro persista, contate o suporte.");
				});
			};

			$scope.pesquisarCEP = function(cep){

				var cep = cep.replace(/\D/g, '');
				$http({
					method: 'GET',
					url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
				}).then(function onSuccess(response){
					$scope.empresacep = response.data;
					$scope.empresa.em_end = $scope.empresacep['logradouro'];
					$scope.empresa.em_comp = $scope.empresacep['complemento'];
					$scope.empresa.em_bairro = $scope.empresacep['bairro'];
					$scope.empresa.em_cid = $scope.empresacep['localidade'];
					$scope.empresa.em_uf = $scope.empresacep['uf'];
				}).catch(function onError(response){

				});
			};

//busca CNPJ

			$scope.pesquisarCNPJ = function(cnpj){


				$http({
					method: 'GET',
					url: $scope.urlBase+'api/pesquisaCNPJ.php?cnpj='+cnpj+''
				  //url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj+''
				  //url: 'https://www.receitaws.com.br/v1/cnpj/03728505000165'
				}).then(function onSuccess(response) {
					console.log(response.data.nome);
					$scope.empresa.em_razao = response.data.nome;
					$scope.empresa.em_fanta = response.data.fantasia
					$scope.empresa.em_bairro = response.data.bairro;
					$scope.empresa.em_end = response.data.logradouro;
					$scope.empresa.em_end_num = response.data.numero;
					$scope.empresa.em_cep = response.data.cep;
					$scope.empresa.em_cid = response.data.municipio;
					$scope.empresa.em_uf = response.data.uf;
				  }, function onError(response) {

				  });

			};

			$scope.formatarCNPJ = function(cpfcnpj){

				$http({
					method: 'GET',
					url: $scope.urlBase+'api/formataCPFCNPJ.php?cpfcnpj='+cpfcnpj+''
				}).then(function onSuccess(response) {
					console.log(response.data);
					$scope.empresa.em_cnpj = response.data;
				  }, function onError(response) {
				  });

			};


			$scope.verarray = function(){
				console.log($scope.empresa)
			}


			var LimparCampos = function(form) {

				//document.getElementById(this).reset();
				$scope.empresa=[{

					em_cod:'',
		    		cnpj : '',
		    		em_insc: '',
		    		em_responsavel: '',
		    		em_razao: '',
		    		em_fanta: '',
		    		em_email: '',
		    		em_cep: '',
		    		em_end: '',
		    		em_comp: '',
		    		em_end_num: '',
		    		em_bairro: '',
		    		em_cid: '',
		    		em_uf: '',
		    		em_fone: '',
		    		em_cont_nome: '',
		    		em_cont_email: '',
		    		em_cont_fone: '',
		    		em_logo: '',
		    	}];

			}

			function retirarFormatacao(campoTexto) {
			    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
			};


		}).run(function($rootScope, devices){

			$rootScope.devices = devices.list;

		}).config(function(devicesProvider){

			devicesProvider.set('big','(min-width:425px)');

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

	</script>

	<script>


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

		function tabenter(event,campo){
			var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (tecla==13) {
				campo.focus();
			}
		};


		document.onkeydown = function () {
		   switch (event.keyCode) {
		     case 116 :
		         window.location.href ='CadEmpresas.php?u=<?=$usuario1?>&s=<?=$senha1?>';
		        event.keyCode = 0;
		        return false;
		      case 82 :
		        if (event.ctrlKey) {
		           window.location.href ='CadEmpresas.php?u=<?=$usuario1?>&s=<?=$senha1?>';
		          // event.returnValue = false;
		          event.keyCode = 0;
		          return false;
		   		}
		 	}
		};


//alerta

		$(document).ready(function(){
			$('.alert').hide();
		});

		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};

	</script>



</body>
</html>