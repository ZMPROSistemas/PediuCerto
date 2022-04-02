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

	.formBtn .md-button:hover{
		background-color: #fff !important;
		color:#666;
	}

</style>
			<div ng-controller="ZMProCtrl">
		  		<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Cadastro</li>
						<li class="breadcrumb-item active" aria-current="page">Empresas</li>
					</ol>
				</nav>


	  			<div class="row" >
					<div class="col-lg-12">
<!--		  				<div show-on-mobile>
							<h2>Mobile</h2>
						</div>

						<div show-on-tablet>
							<h2>Tablet</h2>
						</div>

						<div show-on-laptop>
							<h2>Laptop</h2>
						</div>

						<div show-on-desktop>
							<h2>Desktop</h2>
						</div>  -->

						<!--
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" ng-click="tab=1" ng-class="{'active' : tab==1}">Lista</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" ng-click="tab=2">Ficha</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" ng-click="tab=3" ng-class="{'active' : tab==3}">NF-e/NFC-e</a>
							</li>
						</ul>
						-->

						<div ng-if="lista">

						    	<md-toolbar layout="row" class="md-hue-3" style="background-color:#000; color:#fff;">
							      <div class="md-toolbar-tools" layout="row" layout-align="space-around center">

							      	<div flex="10">Código</div>
									<div flex="20">Razão Social / Nome</div>
									<div flex="20">Nome Fantasia</div>
									<div flex="25">Endereço</div>
									<div flex="10">Cidade</div>
									<div flex="10">Telefone</div>
									<div flex="10"> Opção </div>

							      </div>
							    </md-toolbar>

							    <md-content>

							    	<md-list>

							    		<md-list-item ng-repeat="empresa in dadosEmpresa" ng-click="null">
							    			<div flex="10" ng-bind="empresa.em_cod"></div>
					    		 			<div flex="20">{{empresa.em_razao | limitTo:20}}{{empresa.em_razao.length >= 20 ? '...' : ''}}</div>
					    		 			<div flex="20">{{empresa.em_fanta | limitTo:20}}{{empresa.em_fanta.length >= 20 ? '...' : ''}}</div>
					    		 			<div flex="25">{{empresa.em_end | limitTo:20}}{{empresa.em_end.length >= 20 ? '...' :''}}</div>
					    		 			<div flex="10">{{empresa.em_cid | limitTo:10}}{{empresa.em_cid.length >= 10 ? '...' : ''}}</div>
					    		 			<div flex="10" ng-bind="empresa.em_fone"></div>
					    		 			<div flex="10">

					    		 				<md-fab-speed-dial ng-hide="hidden" md-direction="left" md-open="isOpen" class="md-scale md-fab-top-right" ng-mouseenter="isOpen=true" ng-mouseleave="isOpen=false" style="margin-top: -20px;">

					    		 				 <md-fab-trigger>
									                <md-button aria-label="menu" class="md-warn">

									                  <md-tooltip md-direction="top" md-visible="tooltipVisible">Menu</md-tooltip>

									                  <i class="fa fa-ellipsis-v color-default-icon" aria-label="menu" style="color: #000; font-size: 15px;"></i>

									                </md-button>

										         </md-fab-trigger>

											        <md-fab-actions>

										            	<md-button type="submit" aria-label="{{item.name}}" class="md-fab md-raised md-mini" style="background-color:#585570;">

									                      <i class="fa fa-trash-alt" aria-label="menu" style="color:#fff; size: 35px;"></i>

									                  	</md-button>

									                  	<md-button type="submit" aria-label="{{item.name}}" ng-click="editarEmpresa(empresa.em_cod)" class="md-fab md-raised md-mini" style="background-color:#585570;">

									                      <i class="fa fa-edit" aria-label="menu" style="color:#fff"></i>

									                  	</md-button>

									            	</md-fab-actions>


					    		 				</md-fab-speed-dial>

					    		 			</div>

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

		             	<div class="jumbotron p-3">

							<form id="CadEmpresa">

								<div layout="row" class="formBtn" layout-align="end center">


									<md-button ng-click="MudarVisibilidade(2)" style="border: 1px solid #fff; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>

									<md-button style="border: 1px solid #fff; border-radius: 5px;"
									><i class="fas fa-save"></i> Salvar</md-button>

								</div>

								<div class="form-row">

									<div class="form-group col-md-2 col-4">
										<label for="em_cod">Código</label>
										<input type="number" class="form-control" ng-bind="empresa.em_cod" disabled>
									</div>

									<div class="form-group col-md-5 col-8">
										<label for="em_cnpj">CNPJ ou CPF</label>
										<div class="input-group">
											<input type="text" class="form-control" ng-bind="empresa.em_cnpj" placeholder="Somente números">
											<div class="input-group-btn">
												<button type="button" class="btn btn-default" id="pesquisarCNPJ">
													<i class="fas fa fa-search" ></i>
												</button>
											</div>
										</div>
									</div>

									<div class="form-group col-md-5 col-12">
										<label for="em_insc">Insc. Estadual ou RG</label>
										<input type="number" class="form-control" id="em_insc" ng-bind="empresa.em_insc">
									</div>

								</div>

								<div class="form-group">
									<label for="em_razao">Razao Social / Nome</label>
									<input type="text" class="form-control" id="em_razao" ng-bind="empresa.em_razao">
								</div>

								<div class="form-group">
									<label for="em_fanta">Nome Fantasia</label>
									<input type="text" class="form-control" id="em_fanta" ng-bind="empresa.em_fanta">
								</div>

								<div class="form-row">

									<div class="form-group col-md-3 col-5">
										<label for="em_cep">CEP</label>
										<div class="input-group">
											<input type="text" class="form-control" id="em_cep" ng-bind="empresa.em_cep">
											<div class="input-group-btn">
												<button type="button" class="btn btn-default" id="pesquisarCEP">
													<i class="fas fa fa-search"></i>
												</button>
											</div>
										</div>
									</div>

									<div class="form-group col-md-7 col-7">
										<label for="em_end">Endereço</label>
										<input type="text" class="form-control" id="em_end" ng-bind="empresa.em_end">
									</div>

									<div class="form-group col-md-2 col-3">
										<label for="num_end">Número</label>
										<input type="text" class="form-control" id="em_end_num" ng-bind="empresa.em_end_num">
									</div>

									<div class="form-group col-md-4 col-9">
										<label for="em_bairro">Bairro</label>
										<input type="text" class="form-control" id="em_bairro" ng-bind="empresa.em_bairro">
									</div>

									<div class="form-group col-md-6 col-9">
										<label for="em_cidade">Cidade</label>
										<input type="text" class="form-control" id="em_cid" ng-bind="empresa.em_cid">
									</div>

									<div class="form-group col-md-2 col-3">

										<label for="em_uf">Estado</label>
										<select class="form-control" id="em_uf">
											<option selected >Selecione</option>
											<option  ng-repeat="uf in UF" value="{{uf.key}}">{{uf.value}}</option>

										</select>

									</div>

								</div>

								<div class="form-row">
									<div class="form-group col-md-4 col-5">
										<label for="em_fone">Telefone</label>
										<input type="number" class="form-control" id="em_fone" ng-bind="empresa.em_fone" placeholder="Somente números, com DDD">
									</div>

									<div class="form-group col-md-4 col-7">
										<label for="em_email">Email</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">@</span>
											</div>
											<input type="email" class="form-control" id="em_email" ng-bind="empresa.em_email" placeholder="Email">
										</div>
									</div>

									<div class="form-group col-md-4 col-12">
										<label for="em_tributo">Responsável</label>
										<input type="text" class="form-control" id="em_responsavel" ng-bind="empresa.em_responsavel">
									</div>

								</div>

								<div class="form-row">
									<div class="form-group col-md-4 col-12">
										<label for="em_cont_nome">Contador</label>
										<input type="text" class="form-control" id="em_cont_nome" ng-bind="empresa.em_cont_nome">
									</div>
									<div class="form-group col-md-4 col-6">
										<label for="em_cont_email">Email do Contador</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">@</span>
											</div>
											<input type="email" class="form-control" id="em_cont_email" ng-bind="empresa.em_cont_email" placeholder="Email do Contador">
										</div>
									</div>
									<div class="form-group col-md-4 col-6">
										<label for="em_cont_fone">Telefone do Contador</label>
										<input type="number" class="form-control" id="em_cont_fone" ng-bind="empresa.em_cont_fone" placeholder="Somente números, com DDD">
									</div>
								</div>


							</form>

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
	<script src="https://rawgithub.com/IlanFrumer/angular-match-media/0.1.1/angular-match-media.js"></script>

	<!-- agular material -->

	<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-animate.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-aria.min.js"></script>

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.css">
	<link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet">
	<script src="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


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

		    $scope.setTab = function(newTab) {
		      $scope.tab = newTab;
		    };

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

		    $scope.editarEmpresa = function(id){
		    	console.log(id);
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

			var SalvarEmpresa = function (em_razao,em_fanta,em_end,em_end_num,em_bairro,em_cid,em_uf,em_cep,em_cnpj,em_insc,em_fone,em_email,em_responsavel,em_cont_nome,em_cont_fone,em_cont_email) {
				$http({
					method: 'GET',
					url: $scope.urlBase+'SalvaCad.php?insereEmpresa=S&em_razao='+em_razao+'&em_fanta='+em_fanta+'&em_end='+em_end+'&em_end_num='+em_end_num+'&em_bairro='+em_bairro+'&em_cid='+em_cid+'&em_uf='+em_uf+'&em_cep='+em_cep+'&em_cnpj='+em_cnpj+'&em_insc='+em_insc+'&em_fone='+em_fone+'&em_email='+em_email+'&em_responsavel='+em_responsavel+'&em_cont_nome='+em_cont_nome+'&em_cont_fone='+em_cont_fone+'&em_cont_email='+em_cont_email
				}).then(function onSuccess(response){
			        alert("Empresa cadastrada com sucesso!");
					LimparCampos();
				}).catch(function onError(response){
					alert("Erro ao salvar informações. Caso este erro persista, contate o suporte.");
			//        alert("idtreinoAluno");
				});
			};

			$scope.LimparCampos = function(form) {

				document.getElementById(this).reset();
			}

			function formatarCampo(campoTexto) {
			    if (campoTexto.value.length <= 11) {
			        campoTexto.value = mascaraCpf(campoTexto.value);
			    } else {
			        campoTexto.value = mascaraCnpj(campoTexto.value);
			    }
			}

			function retirarFormatacao(campoTexto) {
			    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
			}

			function mascaraCpf(valor) {
			    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
			}

			function mascaraCnpj(valor) {
			    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
			}

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

	</script>

	<script>

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

	</script>

</body>
</html>