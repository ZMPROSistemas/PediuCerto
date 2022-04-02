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
$em_razao = "";
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

</style>
			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Administrativo</li>
						<li class="breadcrumb-item active" aria-current="page">Empresas</li>
					</ol>
				</nav>


	  			<div class="row" style="font-size: 0.9em !important">
					<div class="col-lg-12">
						<div ng-if="lista">
					    	<div class="row bg-dark m-0">
								<div class="form-group col-md-6 col-12 pt-3">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm" id="BuscaRápida" placeholder="Pesquisa Rápida">
										<div class="input-group-btn">
											<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;">
												<i class="fas fa fa-search" ></i>
											</button>
										</div>
									</div>
						    	</div>
						    </div>

						    <md-content>
						    	<md-list class="p-0" flex>
							    	<md-subheader class="md-no-sticky" style="background-color:#212529; color:#fff;">
									    <span>Empresas Cadastradas</span>
							    	</md-subheader>
						    		<md-list-item class="md-3-line striped" ng-repeat="empresa in dadosEmpresa" ng-click="null">
						    			<img ng-src="{{empresa.em_path_logo_nfe}}" class="md-avatar"/>
						    			<div class="md-list-item-text" layout="column">
						    				<h3><b>{{empresa.em_cod}} - {{empresa.em_razao | limitTo:50}}{{empresa.em_razao.length >= 50 ? '...' : ''}} :: <small>{{empresa.em_fanta | limitTo:50}}{{empresa.em_fanta.length >= 50 ? '...' : ''}}</small></b></h3>
						    				<h3>{{empresa.em_end | limitTo:50}}{{empresa.em_end.length >= 50 ? '...' :''}} - {{empresa.em_cid | limitTo:30}}{{empresa.em_cid.length >= 30 ? '...' : ''}}</h3>
						    				<h3>{{empresa.em_fone}}</h3>
						    			</div>
			    		 				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false" style="vertical-align: middle;">
											<md-fab-trigger>
									            <md-button aria-label="menu" class="md-warn">
								                	<md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>
									                <i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #000; font-size: 15px;"></i>
								                </md-button>
									        </md-fab-trigger>
									        <md-fab-actions>
								            	<md-button type="submit" class="md-fab md-raised md-mini" style="background-color:#585570;">
							                      	<i class="fa fa-trash-alt" aria-label="menu" style="color:#fff; size: 35px;"></i>
							                  	</md-button>
							                  	<md-button type="submit" ng-click="editarEmpresa(empresa.em_cod)" class="md-fab md-raised md-mini" style="background-color:#585570;">
							                      	<i class="fa fa-edit" aria-label="menu" style="color:#fff"></i>
							                  	</md-button>
							            	</md-fab-actions>
			    		 				</md-fab-speed-dial>
						    		</md-list-item>
							    	<md-divider></md-divider>
						    	</md-list>
						    </md-content>

						    <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
								<md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
	                      		<i class="fa fa-plus"></i>
	                    	</md-button>

		             	</div> <!--Final lista -->

						<div ng-if="ficha">
							<div class="jumbotron p-2">
								<form id="CadEmpresa">
									<div class="form-row">

										<div class="form-group col-md-4 col-10">
											<label for="em_cnpj">CNPJ ou CPF</label>
											<div class="input-group">
												<input type="text" id="cpf_cnpj" class="form-control form-control-sm" ng-modal="cnpj" value="{{cnpj}}" placeholder="Somente números" ng-keyup="cadastrarEmpresa(cnpj)">{{cnpj}}
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" id="pesquisarCNPJ">
														<i class="fas fa fa-search" ></i>
													</button>
												</div>
											</div>
										</div>

										<div class="form-group col-md-4 col-4">
											<label for="em_insc">Insc. Estadual ou RG</label>
											<input type="number" class="form-control form-control-sm" id="em_insc" ng-bind="empresa.em_insc">
										</div>

										<div class="form-group col-md-4 col-6">
											<label for="em_tributo">Responsável</label>
											<input type="text" class="form-control form-control-sm" id="em_responsavel" ng-bind="empresa.em_responsavel">
										</div>

										<div class="form-group col-md-6 col-12">
											<label for="em_razao">Razao Social / Nome</label>
											<input type="text" class="form-control form-control-sm" id="em_razao" ng-modal="empresa.em_razao">
										</div>

										<div class="form-group col-md-6 col-12">
											<label for="em_fanta">Nome Fantasia</label>
											<input type="text" class="form-control form-control-sm" id="em_fanta" ng-bind="empresa.em_fanta">
										</div>

										<div class="form-group col-md-3 col-7">
											<label for="em_email">Email</label>
											<input type="email" class="form-control form-control-sm" id="em_email" ng-bind="empresa.em_email" placeholder="Email">
										</div>

										<div class="form-group col-md-2 col-5">
											<label for="em_cep">CEP</label>
											<div class="input-group">
												<input type="text" class="form-control form-control-sm" id="em_cep" ng-bind="empresa.em_cep">
												<div class="input-group-btn">
													<button type="button" class="btn btn-outline-dark btn-sm" style="color: white;" id="pesquisarCEP">
														<i class="fas fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>

										<div class="form-group col-md-6 col-9">
											<label for="em_end">Endereço</label>
											<input type="text" class="form-control form-control-sm" id="em_end" ng-bind="empresa.em_end">
										</div>

										<div class="form-group col-md-1 col-3">
											<label for="num_end">Número</label>
											<input type="text" class="form-control form-control-sm" id="em_end_num" ng-bind="empresa.em_end_num">
										</div>

										<div class="form-group col-md-3 col-4">
											<label for="em_bairro">Bairro</label>
											<input type="text" class="form-control form-control-sm" id="em_bairro" ng-bind="empresa.em_bairro">
										</div>

										<div class="form-group col-md-4 col-6">
											<label for="em_cidade">Cidade</label>
											<input type="text" class="form-control form-control-sm" id="em_cid" ng-bind="empresa.em_cid">
										</div>

										<div class="form-group col-md-2 col-2">
											<label for="em_uf">Estado</label>
											<select class="form-control form-control-sm" id="em_uf">
												<option selected >Selecione</option>
												<option  ng-repeat="uf in UF" value="{{uf.key}}">{{uf.value}}</option>
											</select>
										</div>

										<div class="form-group col-md-3 col-5">
											<label for="em_fone">Telefone</label>
											<input type="number" class="form-control form-control-sm" id="em_fone" ng-bind="empresa.em_fone" placeholder="Somente números, com DDD">
										</div>

										<div class="form-group col-md-4 col-12">
											<label for="em_cont_nome">Contador</label>
											<input type="text" class="form-control form-control-sm" id="em_cont_nome" ng-bind="empresa.em_cont_nome">
										</div>

										<div class="form-group col-md-4 col-6">
											<label for="em_cont_email">Email do Contador</label>
											<input type="email" class="form-control form-control-sm" id="em_cont_email" ng-bind="empresa.em_cont_email" placeholder="Email do Contador">
										</div>

										<div class="form-group col-md-4 col-6">
											<label for="em_cont_fone">Telefone do Contador</label>
											<input type="number" class="form-control form-control-sm" id="em_cont_fone" ng-bind="empresa.em_cont_fone" placeholder="Somente n?meros, com DDD">
										</div>
									</div>

									<md-button class="btnCancelar" ng-click="MudarVisibilidade(2)" style="border: 1px solid #bf0000; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button class="btnSalvar" style="border: 1px solid #279B2D; border-radius: 5px;" ng-click="SalvarEmpresa()"><i class="fas fa-save"></i> Salvar</md-button>

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

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;

			$scope.urlBase="services/";
			$scope.dadosEmpresa=[];
		    $scope.UF = [
				{ key: "AC", value: "Acre" },
				{ key: "AL", value: "Alagoas" },
				{ key: "AP", value: "Amapá" },
				{ key: "AM", value: "Amazonas" },
				{ key: "BA", value: "Bahia" },
				{ key: "CE", value: "Ceará" },
				{ key: "DF", value: "Distrito Federal" },
				{ key: "ES", value: "Espírito Santo" },
				{ key: "GO", value: "Goiás" },
				{ key: "MA", value: "Maranhão" },
				{ key: "MT", value: "Mato Grosso" },
				{ key: "MS", value: "Mato Grosso do Sul" },
				{ key: "MG", value: "Minas Gerais" },
				{ key: "PA", value: "Pará" },
				{ key: "PB", value: "Paraíba" },
				{ key: "PR", value: "Paraná" },
				{ key: "PE", value: "Pernambuco" },
				{ key: "PI", value: "Piauí" },
				{ key: "RJ", value: "Rio de Janeiro" },
				{ key: "RN", value: "Rio Grande do Norte" },
				{ key: "RS", value: "Rio Grande do Sul" },
				{ key: "RO", value: "Rondônia" },
				{ key: "RR", value: "Roraima" },
				{ key: "SC", value: "Santa Catarina" },
				{ key: "SP", value: "São Paulo" },
				{ key: "SE", value: "Sergipe" },
				{ key: "TO", value: "Tocantins" }
			];
			$scope.empresa=[];
			$scope.cadastrar_alterar = 'C';

		    $scope.MudarVisibilidade = function(e) {

		     	if (e == 1) {

		     		$scope.lista = !$scope.lista;
		    		$scope.ficha = !$scope.ficha;
		     	}
		     	
		     	if (e == 2) {
		     		$scope.lista = true;
					$scope.ficha = false;
		     	}

		    }

		    $scope.cadastrarEmpresa = function(em_cnpj){
		    	$scope.empresa=[{
		    		cnpj : em_cnpj,
		    	}];

		    	console.log($scope.empresa);
		    }

		    $scope.isSet = function(tabNum) {
		      return $scope.tab === tabNum;
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

			dadosEmpresa();

			$scope.SalvarEmpresa = function () {
				$http({
					method: 'GET',
					url: $scope.urlBase+'SalvaCad.php?insereEmpresa=S'
				}).then(function onSuccess(response){
					MudarVisibilidade(2);
					LimparCampos();
				}).catch(function onError(response){
					alert("Erro ao salvar informações. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			$scope.LimparCampos = function(form) {

				document.getElementById(this).reset();
			};

			function formatarCampo(campoTexto) {
			    if (campoTexto.value.length == 11) {
			        campoTexto.value = campoTexto.value.mask('000.000.000-00');
			    } else if (campoTexto.value.length == 14) {
			        campoTexto.value = campoTexto.value.mask('00.000.000/0000-00');
			    } else {

			    }
			};

			function retirarFormatacao(campoTexto) {
			    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
			};

		}).run(function($rootScope, devices){

			$rootScope.devices = devices.list;

		}).config(function(devicesProvider){

			devicesProvider.set('big','(min-width:425px)');

		});

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


		$(document).ready(function(){

			$('#pesquisarCEP').on('click', function(e) {
				e.preventDefault();
				var cep = $('#em_cep').val().replace(/[^0-9]/g, '');
				if(cep.length == 8) {
				    $.ajax({

				        url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/',

				        dataType: 'json',

				        success: function(resposta){

				          $("#em_end").val(resposta.logradouro);
				          $("#em_end_num").val(resposta.complemento);
				          $("#em_bairro").val(resposta.bairro);
				          $("#em_cid").val(resposta.localidade);
				          $("#em_uf").val(resposta.uf);

				          $("#em_end_num").focus();
				        }
					});
				} else {
					alert('CEP inválido');
				}
			});
		});

		$(document).ready(function(){

			$('#pesquisarCNPJ').on('click', function(e) {
				e.preventDefault();
				var cnpj = $('#em_cnpj').val().replace(/[^0-9]/g, '');
				if(cnpj.length == 14) {
					$.ajax({
					url:'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
					method:'GET',
					dataType: 'jsonp',
					complete: function(xhr){
					response = xhr.responseJSON;
					if(response.status == 'OK') {
						$('#em_razao').val(response.nome);
						$('#em_fanta').val(response.fantasia);
						$('#em_cep').val(response.cep);
						$('#em_end').val(response.logradouro);
						$('#em_bairro').val(response.bairro);
						$('#em_cid').val(response.municipio);
						$('#em_uf').val(response.uf);
						$('#em_email').val(response.email);
						} else {
							alert(response.message);
						}
					}
				});
				} else {
					alert('CNPJ inválido');
				}
			});
		});

		$(document).ready(function() {
			history.pushState('data','titulo','Empresas');
		});	

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
		}

	</script>

</body>
</html>