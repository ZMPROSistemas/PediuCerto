<?php

include 'varInicio.php';
include 'conecta.php';
include './services/conectaPDO.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

$cidade = cidade($pdo, $em_cid);

function cidade($pdo, $cid){

    $sql = "SELECT * FROM cidades where cid_nome = :cid;";
    $stmt= $pdo->prepare($sql);
    $stmt->bindValue(":cid", $cid);
    $stmt->execute();
    $cidade = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cidade;
}

?>

<style>

    .alert{display: none;}


    @media print {}

</style>

<div ng-controller="ZMProCtrl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-0">
            <li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
            
            <li class="breadcrumb-item active" aria-current="page">Região e Taxas</li>
        </ol>
    </nav>
    
    <div class="alert {{tipoAlerta}} alert-1 col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
        {{alertMsg}}
    </div>

    <?php
        include_once 'Modal/bairros/bairros_e_barrosAtendidos.php';
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
                                        <input type="text" value="" class="form-control form-control-sm" id="buscaRegiaoT" ng-model="buscaRegiaoT" placeholder="Todas as Regiões">
                                    </div>

                                    <!--div class="ml-auto m-0 p-0">
                                        <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="busca(empresa, buscaCliente, buscaCidade)" style="color: white;">
                                            <md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                                            <i class="fas fa fa-search" ></i> Pesquisar
                                        </md-button>
                                    </div-->

                                </div>
                            </form>
                            <div class="table-responsive p-0 mb-0" style="overflow: hidden;">
                                <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                                    <thead class="thead-dark">
                                        <tr style="font-size: 1em !important;">
                                            <th scope="col" style="width:100px; font-weight: normal; text-align: left;" ng-click="ordenar('ba_id')">Código</th>
                                            <th scope="col" style="width:450px; font-weight: normal; text-align: left;" ng-click="ordenar('ba_nomebairro')">Bairro</th>
                                            <th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('ba_taxa')">Taixa</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="line-height: 2em;">
                                        <tr dir-paginate="dadosRegiao in dadosRegiao | filter:buscaRegiaoT | orderBy:'sortKey':reverse | itemsPerPage: 20" >
                                            <td ng-bind="dadosRegiao.ba_id" style=" font-weight: normal; text-align: left;"></td>
                                            <td ng-bind="dadosRegiao.ba_nomebairro" style=" font-weight: normal; text-align: left;"></td>
                                            <td style=" font-weight: normal; text-align: left;">{{dadosRegiao.ba_taxa | currency: 'R$ '}}</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>

                                <div ng-if="arrayNull == true">
                                    <div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
                                        Aguarde... Pesquisando!
                                    </div>
                                </div>

                            </div>
                            
                            <dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
                        </div>
                    </div>
                </div>

                <md-button class="md-fab md-fab-bottom-right color-default-btn" ng-click="addBairros();" style="position: fixed; z-index: 999; background-color:#279B2D;">
                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Novo</md-tooltip>
                    <i class="fa fa-plus"></i>
                </md-button>
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
    <script src="js/mask/angular-money-mask.js"></script>
    <script src="js/angular-locale_pt-br.js"></script>
    <script src="js/swx-session-storage.min.js"></script>
    <script src="js/swx-local-storage.min.js"></script>

	<!--Gerar PDF -->

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>
	
	<script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination', 'money-mask' ,'swxSessionStorage','swxLocalStorage']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $sessionStorage, $localStorage) {
            
            $scope.arrayNull = false;
            $scope.lista =   true;
            $scope.ficha = false;
            $scope.paginacao=[];
			$scope.urlBase = 'services/'
			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
			$scope.dadosRegiao=[];
            $scope.empresa = '';
            $scope.bairro = $sessionStorage.get('bairros');
            $scope.buscaBairros = '';

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

            $scope.populaBairro = function(){
                angular.forEach($scope.bairro, function(value, key){
                    $scope.bairro[key].br_select = false;
                    $scope.bairro[key].br_taxa = <?=$dados_empresa['em_taxa_entrega']?>;
                })
                
                angular.forEach($scope.dadosRegiaoTemp, function(value, key){
                    var find = $scope.bairro.find(item => item.br_id === $scope.dadosRegiaoTemp[key].ba_codbairro);
                    var index = $scope.bairro.indexOf(find);
                    $scope.bairro[index].br_select = true;
                    $scope.bairro[index].br_taxa = $scope.dadosRegiaoTemp[key].ba_taxa;
                })
            }
            
            $scope.MudarVisibilidade = function(e) {

		     	if (e == 1) {
		     		$scope.lista = !$scope.lista;
		    		$scope.ficha = !$scope.ficha;
		     	}
		     	if (e == 2) {
		     		$scope.lista = true;
					$scope.ficha = false;
					
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
		     	}

            }


            var bairro = function (){
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'bairros.php?todosBairros=S&cidade=<?=$cidade['cid_cod']?>'
                }).then(function onSuccess(response){
                    $scope.bairro = response.data;
                    $sessionStorage.remove('bairros');
                    $sessionStorage.put('bairros', $scope.bairro);
                }).catch(function onError(response){

                })
            }

            if ($scope.bairro == undefined) {
                bairro();
            }else if($scope.bairro[0].br_cid != "<?=$cidade['cid_cod']?>"){
                bairro();
            }

            var bairroAtendido = function(){
                $scope.arrayNull = true;
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'bairros.php?bairroAtendidos=S&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>'
                }).then(function onSuccess(response){
                    $scope.dadosRegiao = response.data;
                    $scope.arrayNull = false;
                }).catch(function onError(response){

                })
            }
            bairroAtendido();

            $scope.select = false;
            $scope.dadosRegiaoTemp=[];
            
            $scope.addBairros = function(){
                var index = 0;
               // $scope.dadosRegiaoTemp = $scope.dadosRegiao;
                
               angular.forEach($scope.dadosRegiao, function(value, key){
                    $scope.dadosRegiaoTemp.push($scope.dadosRegiao[key]);
               })

                // angular.forEach($scope.bairro, function(value, key){
                //     $scope.bairro[key].br_select = false;
                //     $scope.bairro[key].br_taxa = <?=$dados_empresa['em_taxa_entrega']?>;
                // })
                
                // angular.forEach($scope.dadosRegiaoTemp, function(value, key){
                //     var find = $scope.bairro.find(item => item.br_id === $scope.dadosRegiaoTemp[key].ba_codbairro);
                //     var index = $scope.bairro.indexOf(find);
                //     $scope.bairro[index].br_select = true;
                //     $scope.bairro[index].br_taxa = $scope.dadosRegiaoTemp[key].ba_taxa;
                // })

                $scope.populaBairro();

                if($scope.dadosRegiaoTemp.length != $scope.bairro.length){
                    $scope.select = false;
                }else{
                    $scope.select = true;
                }
                $("#bairros").modal("show");
            }

            $scope.addBairroBanco = function(e){
                
                //console.log("Vai dar certo "+e);
                $http({
                    method: 'GET',
                    url: $scope.urlBase+'bairros.php?addNovoBairro=S&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&cidade=<?=$cidade['cid_cod']?>&nomeBairro='+e
                }).then(function onSuccess(response){

                    console.log(response.data[0]);
                    bairro();
                    //bairroAtendido();
                    if(response.data[0].retorno == 'SUCCESS'){

                        $scope.retStatus = response.data[0].retorno;
                        $scope.tipoAlerta = "alert-success";
                        $scope.alertMsg = "Regiões atualizadas!";
                        chamarAlerta();
                    }else if(response.data[0].retorno == 'ERROR'){
                       
                        $scope.retStatus = response.data[0].retorno;
                        $scope.tipoAlerta = "alert-danger";
                        $scope.alertMsg = "Regiões não pode atualizadas!";
                        chamarAlerta();
                    }
                    //$scope.dadosRegiaoTemp = [];
                    //$("#bairros").modal("hide"); // fecha modal
                }).catch(function onError(response){
                    //$("#bairros").modal("hide"); // fecha modal
                });

                bairro();
                //$scope.addBairros();

                $scope.populaBairro();

                // angular.forEach($scope.bairro, function(value, key){
                //     $scope.bairro[key].br_select = false;
                //     $scope.bairro[key].br_taxa = <?=$dados_empresa['em_taxa_entrega']?>;
                // })
                
                // angular.forEach($scope.dadosRegiaoTemp, function(value, key){
                //     var find = $scope.bairro.find(item => item.br_id === $scope.dadosRegiaoTemp[key].ba_codbairro);
                //     var index = $scope.bairro.indexOf(find);
                //     $scope.bairro[index].br_select = true;
                //     $scope.bairro[index].br_taxa = $scope.dadosRegiaoTemp[key].ba_taxa;
                // })                
            }


            $scope.addBairroTemp = function(e){

                
                if(e.br_select == true){

                    var find = $scope.dadosRegiaoTemp.find(item => item.ba_codbairro === e.br_id);
                    var index = $scope.dadosRegiaoTemp.indexOf(find);
                    $scope.dadosRegiaoTemp.splice(index, 1);
                    
                }else if(e.br_select == false){

                    $scope.dadosRegiaoTemp.push({
                        'ba_codbairro': e.br_id,
                        'ba_codcidade': e.br_cid,
                        'ba_empresa': <?=base64_decode($empresa)?>,
                        'ba_matriz': <?=base64_decode($empresa)?>,
                        'ba_nomebairro': e.br_nome,
                        'ba_taxa': <?=$dados_empresa['em_taxa_entrega']?>
                    })
                
                }


                // angular.forEach($scope.bairro, function(value, key){
                //     $scope.bairro[key].br_select = false;
                //     $scope.bairro[key].br_taxa = <?=$dados_empresa['em_taxa_entrega']?>;
                // })

                // angular.forEach($scope.dadosRegiaoTemp, function(value, key){
                //     var find = $scope.bairro.find(item => item.br_id === $scope.dadosRegiaoTemp[key].ba_codbairro);
                //     var index = $scope.bairro.indexOf(find);
                //     $scope.bairro[index].br_select = true;
                //     $scope.bairro[index].br_taxa = $scope.dadosRegiaoTemp[key].ba_taxa;
                // })
                $scope.populaBairro();

                console.log($scope.dadosRegiaoTemp);
               // console.log($scope.bairro);
                
            }


            $scope.selectAll = function(select){
                
                console.log(select);

                angular.forEach($scope.bairro, function(value, key){
                    $scope.bairro[key].br_select = false;
                })

                if(select == false){

                    angular.forEach($scope.bairro, function(value, key){
                        var find = $scope.dadosRegiaoTemp.find(item => item.ba_codbairro === $scope.bairro[key].br_id);

                        if(find == undefined){
                            $scope.dadosRegiaoTemp.push({
                                'ba_codbairro': $scope.bairro[key].br_id,
                                'ba_codcidade': $scope.bairro[key].br_cid,
                                'ba_empresa': <?=base64_decode($empresa)?>,
                                'ba_matriz': <?=base64_decode($empresa)?>,
                                'ba_nomebairro': $scope.bairro[key].br_nome,
                                'ba_taxa': <?=$dados_empresa['em_taxa_entrega']?>
                            })
                        }

                        
                    });

                }else if (select == true){
                    $scope.dadosRegiaoTemp=[];
                }
                

                angular.forEach($scope.dadosRegiaoTemp, function(value, key){
                    var find = $scope.bairro.find(item => item.br_id === $scope.dadosRegiaoTemp[key].ba_codbairro);
                    var index = $scope.bairro.indexOf(find);
                    $scope.bairro[index].br_select = true;
                    $scope.bairro[index].br_taxa = $scope.dadosRegiaoTemp[key].ba_taxa;
                })


                console.log($scope.dadosRegiaoTemp);
            }
            $scope.taxaValor = function(taxa , e){
                
                if(taxa != undefined){

                    taxa = taxa.replace("R","");
                    taxa = taxa.replace("$","");
                    taxa = taxa.replace(",",".");

                    var find = $scope.dadosRegiaoTemp.find(item => item.ba_codbairro === e.br_id);
                    var index = $scope.dadosRegiaoTemp.indexOf(find);
                    $scope.dadosRegiaoTemp[index].ba_taxa = taxa;

                
                    var findBairro = $scope.bairro.find(item => item.br_id === find.ba_codbairro);
                    var index = $scope.bairro.indexOf(findBairro);
                    $scope.bairro[index].br_taxa = taxa;


                }

            }

            $scope.salvarRegiao = function(){
              var dadosBanco = $scope.dadosRegiaoTemp;
                $http({
                    method: "POST",
                    headers: {
                        'Content-Type':'application/json'
                    },
                    cache: false,
                    data:JSON.stringify({
                        regiao : dadosBanco,
                    }),
                    url: $scope.urlBase+'bairros.php?salvarRegiao=S&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>'
                }).then(function onSuccess(response){
                    console.log(response.data[0].retorno);
                    bairroAtendido();
                    if(response.data[0].retorno == 'SUCCESS'){

                        $scope.retStatus = response.data[0].retorno;
                        $scope.tipoAlerta = "alert-success";
                        $scope.alertMsg = "Regiões atualizadas!";
                        chamarAlerta();
                    }else if(response.data[0].retorno == 'ERROR'){
                       
                        $scope.retStatus = response.data[0].retorno;
                        $scope.tipoAlerta = "alert-danger";
                        $scope.alertMsg = "Regiões não pode atualizadas!";
                        chamarAlerta();
                    }
                    $scope.dadosRegiaoTemp = [];
                    $("#bairros").modal("hide");
                }).catch(function onError(response){
                    $("#bairros").modal("hide");
                })
            }

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
						var cleanVal = element[0].value(/\D/g, '');//pega o valor sem mascara
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

		<?php
			include 'controller/funcoesBasicas.js';
        ?>
        
    </script>