<?php
    include 'varInicio.php';
    include 'conecta.php';
    include 'funcoes-inicio.php';
    include 'cabecalho.php';

    
    setlocale(LC_ALL, 'pt_BR.utf-8');
    date_default_timezone_set('America/Bahia');
?>

<style>
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

</style>

    <div ng-controller="ZMProCtrl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-0">
            <li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item" aria-current="page">Produtos</li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
        </ol>
    </nav>

    <div class="alert {{tipoAlerta}} msg col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
        {{alertMsg}}
    </div>

    <div class="alert alert-dark excluir col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
        Deseja Excluir o Grupo <br>
            
        <button type="submit" class="btn btn-outline-danger" onclick="excluir()"><i class="fas fa-window-close"></i> Cancelar</button>
        <button type="submit" class="btn btn-outline-success" ng-click="excluir(id,2)"><i class="fas fa-save"></i> Excluir</button>
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
                                        <select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="modificaBusca(empresa)">
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
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
                            
                            <thead class="thead-dark">

                                <tr style="font-size: 1.1em !important;">
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ht_codinterno')">Código</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ht_codinterno')">Empresa</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ht_codinterno')">Descrição</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ht_codinterno')">Débito/Crédito</th>
                                    <th scope="col" style=" font-weight: normal;">Ação</th>
                                
                                </tr>

                            </thead>
                            <tbody>
                                <tr dir-paginate="hist in listaHistoricoBancario | filter: {ht_empresa: empresa} |filter: {ht_descricao:buscaRapida} | orderBy:'sortKey':reverse | itemsPerPage:10">
                                    <td style="text-align: left;" ng-bind="hist.ht_cod"></td>
                                    <td style="text-align: left;">{{hist.pd_empresa | limitTo:40}}{{hist.pd_empresa.length >= 40 ? '...' : ''}}</td>
                                    <td ng-bind="hist.ht_descricao"></td>
                                    <td>
                                        <span ng-if="hist.ht_dc == 'D'">Débito</span>
                                        <span ng-if="hist.ht_dc == 'C'">Crédito</span>
                                    </td>
                                    <td style="text-align: center;">

                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
                                                <i class="fas fa-ellipsis-v"></i> 
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" ng-click="buscarHist(hist)">Editar</a>
												<a class="dropdown-item" ng-click="excluir(hist,1)">Excluir	</a>
                                            </div>
                                        </div>
                                    </td>

                            </tbody>
                        
                        </table>
                        <dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
                        <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
                            <md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
                            <i class="fa fa-plus"></i>
                        </md-button>
                    </div>

                </div>
                <div ng-if="ficha">
                    <div class="row justify-content-center" style="height: 100px;">
                        <div class="card border-dark mb-3" style="width: 25rem; background-color:rgba(0,0,0, .65);">
                            <div class="card-header">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <label for="codGrupo">Cadastro De Histórico Bancário</label>
                                            
                                        </div>
                                    </div>

                                </form>
                            </div>
                            
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-12" ng-init="historicoBancario.ht_descricao = historicoBancario[0].ht_descricao">
                                            <label for="nomeGrupo">Nome Do Hisórico</label>
                                            <input type="text" autocomplete="nope" class="form-control" id="nomeHistorico" ng-model="historicoBancario.ht_descricao" value="historicoBancario.ht_descricao">
                                        </div>
                                        <div class="form-group col-12" ng-init="historicoBancario.ht_dc = historicoBancario[0].ht_dc">
                                            <label for="nomeGrupo">Tipo</label>
                                            <select class="form-control" name="ht_dc" id="ht_dc" ng-model="historicoBancario.ht_dc">
                                                <option value="D" selected>Débito</option>
                                                <option value="C">Crédito</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            
                            </div>
                            <div class="card-footer">
                                
                                <button type="submit" class="btn btn-outline-danger" style="color: white;" ng-click="cancela()"><i class="fas fa-window-close"></i> Cancelar</button>
                                <button type="submit" class="btn btn-outline-success" ng-click="editarSalvar(historicoBancario)"><i class="fas fa-save"></i> Salvar</button>
                            </div>
                        
                        </div>
                    
                    </div>
                
                </div>
        </div>
    </div>

    </dv>
</div>

<script src="js/angular.min.js"></script>
<script src="js/angular-animate.min.js"></script>
<script src="js/angular-messages.min.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/angular-match-media.js"></script>
<script src="js/angular-material.min.js"></script>
<script src="js/angular-aria.min.js"></script>
<script src="js/mCustomScrollbar.concat.min.js"></script>
<script src="js/material-components-web.min.js"></script>
<script src="js/jquery.mask.min.js"></script>
<script src="js/dirPagination.js"></script>	
<script src="js/angular-locale_pt-br.js"></script>
<script src="http://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>

<script  id="INLINE_PEN_JS_ID">
    angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','md.data.table','angularUtils.directives.dirPagination']);
    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $mdEditDialog, $log) {

        $scope.tab = 1;
        $scope.lista = true;
        $scope.ficha = false;
        $scope.urlBase = 'services/';
        $scope.empresa = '';
        $scope.listaHistoricoBancario=[];

        $scope.historicoBancario=[{
                ht_id:'',
                ht_descricao:'',
                ht_dc:'',
			}];
        $scope.mudarEditarSalvar = 1;
        $scope.tipoAlerta = "alert-success";
        $scope.alertMsg = "Cadastro Realizado com sucesso";

        $scope.ordenar = function(keyname){
            $scope.sortKey = keyname;
            $scope.reverse = !$scope.reverse;
        };

        $scope.MudarVisibilidade = function(e) {

            $scope.lista = !$scope.lista;
            $scope.ficha = !$scope.ficha;
            $scope.mudarEditarSalvar = e;

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


        var dadosHistoricoBancario = function () {	
            $http({
                method: 'GET',
                url: $scope.urlBase+'historico_banc.php?historico=S&lista=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>'
            }).then(function onSuccess(response){
                $scope.listaHistoricoBancario=response.data.result[0];
            }).catch(function onError(response){
                $scope.resultado=response.data;
               
            });
        };
        dadosHistoricoBancario();

        $scope.buscarHist = function(hist){
              
				$http({
					method: 'GET',
					url: $scope.urlBase + 'historico_banc.php?historico=S&buscar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&grp_id='+hist.ht_id
				}).then(function onSuccess(response){
                    $scope.historicoBancario = response.data.result[0];
                    console.log($scope.historicoBancario);
					$scope.MudarVisibilidade(2);
				}).catch(function onError(response){

				});
		}

        $scope.editarSalvar = function(hist){
            if(hist.ht_descricao == undefined){

                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Informe O Nome Do Histórico!";
                chamarAlerta();
                }

                else if(hist.ht_dc == undefined){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Informe O Tipo Do Histórico!";
                chamarAlerta();
                }
                else if(hist.ht_descricao == ''){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Informe O Nome Do Histórico!";
                chamarAlerta();
                }
                else if(hist.ht_dc == ''){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Informe O Tipo Do Histórico!";
                chamarAlerta();
                }

                else{

                    if ($scope.mudarEditarSalvar == 1) {
                        $scope.salvarHist(hist);
                    }

                    if ($scope.mudarEditarSalvar == 2) {
                        $scope.editarHist(hist);
                    }
                }
        }

        $scope.salvarHist = function(hist){
 
                $scope.MudarVisibilidade(1);
                    $http({
                        method: 'GET',
                        url: $scope.urlBase + 'historico_banc.php?historico=S&salvar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&ht_descricao='+hist.ht_descricao+'&ht_dc='+hist.ht_dc
                    }).then(function onSuccess(response){
                        
                        if (response.data <= 0) {
							$scope.tipoAlerta = "alert-danger";
							$scope.alertMsg = "Cadastro Não Pode Ser Atualizado";
							chamarAlerta();
						}

						else if(response.data >= 1){
							$scope.tipoAlerta = "alert-success";
							$scope.alertMsg = "Cadastro Atualizado Com Sucesso";
							chamarAlerta();
                        }
                        dadosHistoricoBancario();
                        $scope.MudarVisibilidade(1);
						$scope.cancela();
                    }).catch(function onError(response){

					});

            //console.log(hist);
        }

        $scope.editarHist = function(hist){
            $scope.MudarVisibilidade(1);
            $http({
					method: 'GET',
                    url: $scope.urlBase + 'historico_banc.php?historico=S&editar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&ht_descricao='+hist.ht_descricao+'&ht_dc='+hist.ht_dc+'&ht_id='+$scope.historicoBancario[0].ht_id
            }).then(function onSuccess(response){
                        
                if (response.data <= 0) {
                    $scope.tipoAlerta = "alert-danger";
                    $scope.alertMsg = "Cadastro Não Pode Ser Atualizado";
                    chamarAlerta();
                }

                else if(response.data >= 1){
                    $scope.tipoAlerta = "alert-success";
                    $scope.alertMsg = "Cadastro Atualizado Com Sucesso";
                    chamarAlerta();
                }
                dadosHistoricoBancario();
                $scope.MudarVisibilidade(1);
                $scope.cancela();
            }).catch(function onError(response){

            });
        }

        $scope.excluir = function(hist,e){
            if(e == 1){
                excluir();
                $scope.id = hist.ht_id;
                $scope.ht_descricao = hist.ht_descricao;
            }
            else if(e == 2){
                $http({
						method: 'GET',
                        url: $scope.urlBase + 'historico_banc.php?historico=S&excluir=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&ht_descricao='+$scope.ht_descricao+'&ht_id='+hist
                }).then(function onSuccess(response){
							
                    if (response.data <= 0) {
                        $scope.tipoAlerta = "alert-danger";
                        $scope.alertMsg = "Cadastro Não Pode Ser Excluido!";
                        chamarAlerta();
                    }
                    else if(response.data >= 1){
                        $scope.tipoAlerta = "alert-success";
                        $scope.alertMsg = "Cadastro Excluido Com Sucesso";
                        chamarAlerta();
                    }
                    dadosHistoricoBancario();

                }).catch(function onError(response){

                });
                excluir();
            }
        }

        $scope.cancela = function(){
            $scope.grupoProduto =[];
            $scope.MudarVisibilidade(1);
        }
        
    });
/*js*/
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
        $('.msg').toggle("slow");
        setTimeout( function() {
            $('.msg').toggle("slow");
        },3000);
    };

    function excluir(){
			$('.excluir').toggle("slow");
			
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