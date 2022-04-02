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

	.table-responsive { 
		overflow:scroll;
		background-color:#ffffff;
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
            <li class="breadcrumb-item" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Históricos Bancários</li>
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

    <div class="row">
		<div class="col-lg-12 pt-0 px-2">
            <div ng-if="lista">

                <div show-on-desktop>
                    <div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
						<div class="card-body py-0 px-2 m-0">
                            <form class="my-0 py-2">
                                <div class="form-row">
                                    <div class="col-auto ml-2">
                                        <label for="dataI">Filtrar Resultados</label>
                                    </div>
                                    <div class="col-4"> 
                                        <input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mb-2" style="overflow: hidden;">
                                <table class="table table-sm table-striped pb-0" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
                                    <thead class="thead-dark">
                                        <tr style="font-size: 0.9em !important; font-weight: normal;">
                                            <th scope="col" style="text-align: left;" ng-click="ordenar('ht_cod')">Código</th>
                                            <th scope="col" style="text-align: left;" ng-click="ordenar('ht_descricao')">Descrição</th>
                                            <th scope="col" style="text-align: center;" ng-click="ordenar('ht_dc')">Débito/Crédito</th>
                                            <th scope="col" style="text-align: center;" ng-click="ordenar('ht_custo_fixo')">Despesa Fixa</th>
                                            <th scope="col" style="text-align: center;">Ação</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <tr dir-paginate="hist in listaHistoricoBancario | filter: buscaRapida | orderBy:'sortKey':reverse | itemsPerPage:20">
                                            <td style="text-align: left;" ng-bind="hist.ht_cod"></td>
                                            <td style="text-align: left;"  ng-bind="hist.ht_descricao"></td>
                                            <td style="text-align: center;">
                                                <span ng-if="hist.ht_dc == 'D'">Débito</span>
                                                <span ng-if="hist.ht_dc == 'C'">Crédito</span>
                                            </td>
                                            <td style="text-align: center;">
                                                <md-checkbox ng-model="hist.ht_custo_fixo" ng-disabled="true" style="margin-bottom:0px;"></md-checkbox>
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
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>

                <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="MudarVisibilidade(1)" style="position: fixed; z-index: 999; background-color:#279B2D;">
                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
                    <i class="fa fa-plus"></i>
                </md-button>
            </div>

            <div ng-if="ficha">
                <div class="row justify-content-center">
                    <div class="card border-dark" style="width: 25rem; background-color:rgba(0,0,0, .65);">
                        <div class="card-header">
                            <div class="form-row">
                                <h5 style="color: white !important;">Cadastro de Histórico Bancário</h5>
                            </div>
                        </div>
                            
                        <div class="card-body">
                                <div class="form-group" ng-init="historicoBancario.ht_descricao = historicoBancario[0].ht_descricao">
                                <label for="nomeGrupo">Nome do Histórico</label>
                                <input type="text" autocomplete="nope" class="form-control" id="nomeHistorico" ng-model="historicoBancario.ht_descricao" value="historicoBancario.ht_descricao">
                            </div>
                            <div class="form-group" ng-init="historicoBancario.ht_dc = historicoBancario[0].ht_dc">
                                <label for="nomeGrupo">Tipo</label>
                                <select class="form-control" name="ht_dc" id="ht_dc" ng-model="historicoBancario.ht_dc">
                                    <option value="D" selected>Débito</option>
                                    <option value="C">Crédito</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <md-checkbox ng-init="historicoBancario.ht_custo_fixo = historicoBancario[0].ht_custo_fixo" ng-model="historicoBancario.ht_custo_fixo" >Custo Fixo</md-checkbox>
                            </div>
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
<script src="js/md-data-table.js"></script>

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
                ht_custo_fixo:'',
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
            if (hist.ht_cod > 499 && hist.ht_cod < 506) {

                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Este histórico não pode ser alterado!";
                chamarAlerta();

            } else {
                $http({
                method: 'GET',
                url: $scope.urlBase + 'historico_banc.php?historico=S&buscar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&grp_id='+hist.ht_id
                }).then(function onSuccess(response){
                    $scope.historicoBancario = response.data.result[0];
                    console.log($scope.historicoBancario);
                    $scope.MudarVisibilidade(2);
                }).catch(function onError(response){

                });
            };
		}

        $scope.editarSalvar = function(hist){

            if (hist.ht_cod > 499 && hist.ht_cod < 506) {

                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Este histórico não pode ser alterado!";
                chamarAlerta();
               
            } else {

                if(hist.ht_descricao == undefined){

                    $scope.tipoAlerta = "alert-warning";
                    $scope.alertMsg = "Informe O Nome Do Histórico!";
                    chamarAlerta();
                
                } else if (hist.ht_dc == undefined){
                
                    $scope.tipoAlerta = "alert-warning";
                    $scope.alertMsg = "Informe O Tipo Do Histórico!";
                    chamarAlerta();
                
                } else if (hist.ht_descricao == ''){

                    $scope.tipoAlerta = "alert-warning";
                    $scope.alertMsg = "Informe O Nome Do Histórico!";
                    chamarAlerta();

                } else if (hist.ht_dc == ''){
                
                    $scope.tipoAlerta = "alert-warning";
                    $scope.alertMsg = "Informe O Tipo Do Histórico!";
                    chamarAlerta();
                
                } else {

                    if ($scope.mudarEditarSalvar == 1) {
                        $scope.salvarHist(hist);
                    }

                    if ($scope.mudarEditarSalvar == 2) {
                        $scope.editarHist(hist);
                    }
                }
            }
        }

        $scope.salvarHist = function(hist){
 
            $scope.MudarVisibilidade(1);
                $http({
                    method: 'GET',
                    url: $scope.urlBase + 'historico_banc.php?historico=S&salvar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&ht_descricao='+hist.ht_descricao+'&ht_dc='+hist.ht_dc+'&ht_custo_fixo='+hist.ht_custo_fixo
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
                    url: $scope.urlBase + 'historico_banc.php?historico=S&editar=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&ht_descricao='+hist.ht_descricao+'&ht_dc='+hist.ht_dc+'&ht_custo_fixo='+hist.ht_custo_fixo+'&ht_id='+$scope.historicoBancario[0].ht_id
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

            if (hist.ht_cod > 499 && hist.ht_cod < 506) {

                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Este histórico não pode ser alterado!";
                chamarAlerta();

            } else {

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
                
                $scope.cancela = function(){
                $scope.grupoProduto =[];
                $scope.MudarVisibilidade(1);

                }
            }
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