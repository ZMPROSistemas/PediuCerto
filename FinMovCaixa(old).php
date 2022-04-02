<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';
//include 'services/caixas.php';
setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

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

    .modal .pagination>li>a, .pagination>li>span {
		color: white;	
		background-color: rgba(33, 37, 41, 0.9);
    	border: 1px solid transparent;
	}
	 
</style>

			<div ng-controller="ZMProCtrl">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb p-0">
						<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
						<li class="breadcrumb-item" aria-current="page">Financeiro</li>
						<li class="breadcrumb-item active" aria-current="page">Movimento de Caixa</li>
					</ol>
				</nav>

				<div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>
				
				<div class="row">
					<div class="col-lg-12 pt-0 px-2">
                        <div show-on-desktop>
                        
                            <div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
                                <div class="card-body py-0 px-2 m-0">
                                    <form class="my-0 py-2">
                                        <div class="form-row">

                                            <div class="col-auto ml-2">
                                                <label>Selecione</label>
                                            </div>

                                            <div class="col-auto">
                                                <select class="form-control form-control-sm" id="caixa" ng-model="caixa" ng-change="verificaCaixas(empresa, caixa)">
                                                    <option value="">Estado do Caixa</option>
                                                    <option value="A">Aberto</option>
                                                    <option value="F">Fechado</option>
                                                </select>
                                            </div>

<?php if (base64_decode($empresa_acesso) == 0) {?>
                                            <div class="col-auto" ng-if="caixa">
                                                <select class="form-control form-control-sm" id="empresa" ng-model="empresa" ng-change="verificaCaixas(empresa, caixa)">
                                                    <option value="">Selecione uma Empresa</option>
                                                    <option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
                                                </select>
                                            </div>
                                <?php } else {
echo utf8_encode($dados_empresa["em_fanta"]);
}?>
                                            <div class="col-auto" ng-show="caixa">
                                                <select class="form-control form-control-sm" id="nomeCaixa" ng-model="nomeCaixa">
                                                    <option value="">Selecione um Caixa</option>
                                                    <option ng-repeat="caixa in caixasAbertos" ng-value="caixa.bc_codigo">{{caixa.bc_descricao}} </option>
                                                </select>
                                            </div>
                                            <div class="col-auto ml-3" ng-if="caixa == 'F'">
                                                <label for="dataI">Período de </label>
                                            </div>
                                            <div class="col-auto" ng-if="caixa == 'F'">
                                                <input type="date" class="form-control form-control-sm" id="dataI" ng-model="dataI" value="{{dataI}}">
                                            </div>
                                            <div class="col-auto" ng-if="caixa == 'F'">
                                                <label for="dataF">até </label>
                                            </div>
                                            <div class="col-auto" ng-if="caixa == 'F'">
                                                <input type="date" class="form-control form-control-sm" id="dataF" ng-model="dataF" value="{{dataF}}">
                                            </div>
                                            <div class="col-auto ml-3" ng-if="caixa">
                                                <label for="dataI">Linhas</label>
                                            </div>
                                            <div class="col-auto" ng-init="itensPagina = 10" ng-show="caixa">
                                                <select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
                                                    <option ng-value="10" ng-selected="true">10</option>
                                                    <option ng-value="20">20</option>
                                                    <option ng-value="50">50</option>
                                                </select>
                                            </div>

                                            <div class="ml-auto m-0 p-0" ng-if="caixa == 'A'"><!-- -->
                                                <md-button class="btnPesquisar pull-right py-0 my-0" style="border: none;" ng-click="pesquisaCaixaAberto(empresa, nomeCaixa, itensPagina)" style="color: white;">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                                                    <i class="fas fa fa-search" ></i> Pesquisar
                                                </md-button>
                                            </div>

                                            <div class="ml-auto m-0 p-0" ng-if="caixa == 'F'">
                                                <md-button class="btnPesquisar pull-right py-0 my-0" style="border: none;" ng-click="pesquisaCaixaFechado(empresa, nomeCaixa, dataI | date: 'yyyy-MM-dd', dataF | date: 'yyyy-MM-dd', itensPagina)" style="color: white;">
                                                    <md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                                                    <i class="fas fa fa-search" ></i> Pesquisar
                                                </md-button>
                                            </div>

                                        </div>
                                    </form>

                                    <div class="table-responsive p-0"  style="overflow: hidden; font-size: 0.9em !important; " >
                                        <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                                            <thead class="thead-dark">
                                                <tr style="font-weight: normal;">
                                                    <th scope="col" style=" font-weight: normal; text-align: left;">Documento</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: left;">Emissão</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: left;">Histórico</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: left;" ng-if="caixa == 'F'">Observações</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: center;">D/C</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: center;">Tipo Docto</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: left;">Descrição</th>
                                                    <th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr dir-paginate="caixa in movCaixas | orderBy:'sortKey':reverse | itemsPerPage:pageSize">
                                                    <td style="text-align: left;" ng-bind="caixa.cx_docto"></td>
                                                    <td style="text-align: left;" ng-bind="caixa.cx_emissao | date:'dd/MM/yyyy'"></td>
                                                    <td style="text-align: left;" ng-bind="caixa.ht_descricao"></td>
                                                    <td style="text-align: left;" ng-bind="caixa.cx_obs" ng-if="caixa == 'F'"></td>
                                                    <td style="text-align: center;" ng-bind="caixa.cx_dc"></td>
                                                    <td style="text-align: center;" ng-bind="caixa.dc_sigla"></td>
                                                    <td style="text-align: left;" ng-bind="caixa.cx_nome"></td>
                                                    <td style="text-align: right;" ng-bind="caixa.cx_valor | currency: 'R$ '"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-row align-items-center">
                                        <div class="col-6 pl-0" style="text-align: left;">
                                            <div class="row justify-content-start">
                                                <span style="color: gray;">Soma Crédito: <b>{{somaCredito | currency: 'R$ '}}</b></span>
                                            </div>
                                            <div class="row justify-content-start">
                                                <span style="color: gray;">Soma Débito: <b>{{somaDebito | currency: 'R$ '}}</b></span>
                                            </div>
                                            <div class="row justify-content-start">
                                                <span style="color: gray;">Subtotal: <b>{{(somaCredito - somaDebito) | currency: 'R$ '}}</b></span>
                                            </div>
                                        </div>
                                        <div class="col-6" style="text-align: right;">
                                            <span style="color: gray;">Registros: <b>{{movCaixas.length}}</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
                    </div>
                </div>
			</div>  
	    </div>
	</div>

	<script src="js/popper.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/dirPagination.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/mask/angular-money-mask.js"></script>

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination','money-mask']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.caixa= '';
			$scope.nomeCaixa = '';
			$scope.pageSize = 10;
			$scope.somaCredito = 0;
			$scope.somaDebito = 0;
  			$scope.data = new Date();
  			$scope.urlBase = 'services/'
  			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
            $scope.empresa = '';
            $scope.dataI = dataInicial();
            $scope.dataF = dataHoje();
            $scope.totaisCaixas = '';

            function dataHoje(soma=0) {

                var data = new Date();
                data.setDate(data.getDate() );
                var dia = data.getDate();
                var mes = data.getMonth()+1;
                var ano = data.getFullYear();
                if (dia<=9){
                dia='0'+dia;
                }
                if (mes<=9){
                mes='0'+mes;
                }
                //return [dia, mes, ano].join('/');

                return [ano, mes, dia].join('-');

            };

            function dataInicial(soma=0) {

                var data = new Date();
                data.setDate(data.getDate() );
                var dia = data.getDate();
                var mes = data.getMonth();
                var ano = data.getFullYear();
                if (dia<=9){
                dia='0'+dia;
                }
                if (mes<=9){
                mes='0'+mes;
                }
                //return [dia, mes, ano].join('/');

                return [ano, mes, dia].join('-');

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
<?php if (base64_decode($empresa_acesso) == 0) {?>
			dadosEmpresa();
<?php }?>

			var listaMovCaixaAberto = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?movCaixaAberto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa
				}).then(function onSuccess(response){
                    $scope.movCaixas= response.data.result[0];
					var arrayCredito = $scope.movCaixas.filter(item => item.cx_dc == 'C');
					//alert(arrayCredito[0].cx_valor);
					var arrayDebito = $scope.movCaixas.filter(item => item.cx_dc == 'D');
					$scope.somaCredito = arrayCredito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
					$scope.somaDebito = arrayDebito.reduce(function (accumulador, total) {return accumulador + parseFloat(total.cx_valor);}, 0);
                    totaisMovCaixaAberto();
				}).catch(function onError(response){
					$scope.resultado = response.data;
				});
            };
            
			var totaisMovCaixaAberto = function (){

				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?totaisCaixaAberto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa
				}).then(function onSuccess(response){
                    $scope.totaisCaixas= response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado = response.data;
				});
            };

            var listaMovCaixaFechado = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?movCaixaFechado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
                    $scope.movCaixas= response.data.result[0];
                    totaisMovCaixaFechado();
				}).catch(function onError(response){
					$scope.resultado = response.data;
				});
            };
            
			var totaisMovCaixaFechado = function (){
				$http({
					method:'GET',
					url: $scope.urlBase + 'srvcMovCaixa.php?totaisCaixaFechado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&caixa='+$scope.caixa+'&dataI='+$scope.dataI+'&dataF='+$scope.dataF
				}).then(function onSuccess(response){
                    $scope.totaisCaixas= response.data.result[0];
				}).catch(function onError(response){
					$scope.resultado = response.data;
				});
            };

            $scope.verificaCaixas = function(empresa, open) {
				$scope.caixasAbertos = '';
				if (empresa == undefined || empresa == null) {
					$scope.empresa = '';
				} else {
					$scope.empresa = empresa;
				}

                if (open == 'A') {
					//alert(open);
					$http({
                        method:'GET',
                        url: $scope.urlBase + 'srvcMovCaixa.php?verificaCaixa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&situacao='+open
                    }).then(function onSuccess(response){
                        $scope.caixasAbertos= response.data.result[0];
                    }).catch(function onError(response){
                        $scope.resultado = response.data;
                        $scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Não há caixas abertos no momento.";
						chamarAlerta();
                    });
				
				} else if (open == 'F') {
					$http({
                        method:'GET',
                        url: $scope.urlBase + 'srvcMovCaixa.php?verificaCaixa=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&empresa='+$scope.empresa+'&situacao='+open
                    }).then(function onSuccess(response){
                        $scope.caixasAbertos= response.data.result[0];
                    }).catch(function onError(response){
                        $scope.resultado = response.data;
                        $scope.tipoAlerta = "alert-warning";
						$scope.alertMsg = "Não há caixas fechados no momento.";
						chamarAlerta();
                    });
				}
            }

            $scope.pesquisaCaixaAberto = function(empresa, nomeCaixa, itensPagina){
				//alert(nomeCaixa);

                if (empresa == undefined || empresa == null) {
                    $scope.empresa = '';
                } else {
                    $scope.empresa = empresa;
                }
                $scope.caixa = nomeCaixa;
                $scope.pageSize = itensPagina;
                listaMovCaixaAberto();

            }

            $scope.pesquisaCaixaFechado = function(empresa, nomeCaixa, dataInicial, dataFinal, itensPagina){

                if (empresa == undefined || empresa == null) {
                    $scope.empresa = '';
                } else {
                    $scope.empresa = empresa;
                }
                $scope.caixa = nomeCaixa;
                $scope.itensPagina = itensPagina;
                $scope.dataI = dataInicial;
                $scope.dataF = dataFinal;
                listaMovCaixaFechado();

            }

            $scope.print = function(tipoRelatorio){
				var caixa = $scope.movCaixa[0].bc_descricao
				console.log(tipoRelatorio. caixa);
				gerarpdf(tipoRelatorio, caixa);
			}


		}).directive('ngEnter', function () {
		   return function (scope, element, attrs) {
		     element.bind("keydown keypress", function (event) {
		       if(event.which === 13) {
		         scope.$apply(function (){
		           scope.$eval(attrs.ngEnter);
		         });
		         event.preventDefault();
		       }
		     });
		   };

		 }).directive("moneyDir", function MoneyDir() {

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
		});


		function chamarAlerta(){
			$('.alert').toggle("slow");
			setTimeout( function() {
				$('.alert').toggle("slow");
			},3000);
		};

		function gerarpdf(tipoRelatorio,caixa) {
			var tipoRel = tipoRelatorio;
			var cx = caixa;
			<?php if (base64_encode($logoEmp) != null) {?>
				var LogoEmp = new Image();
    			LogoEmp.src = 'data:image/jpeg;base64,<?=$logoEmp?>';
    			//LogoEmp.src = 'imagens_empresas/1/logo/LogoZMPro.png';
			<?php } else {?>
	
				var LogoEmp = new Image();
    			LogoEmp.src = 'images/Logo ZM Pro1.png';
    			//LogoEmp.src = 'imagens_empresas/1/logo/LogoZMPro.png';

			<?php }?>

			var doc = new jsPDF('p', 'pt', 'a4');
			var data1 = doc.autoTableHtmlToJson(document.getElementById("movimento"));
			var rows = data1.rows;
			
<?php if (base64_decode($empresa_acesso) == 0) {?>
    		var empresa = document.getElementById('empresa').options[document.getElementById('empresa').selectedIndex].innerText;
<?php } else {?>
			var empresa = '<?=$dados_empresa["em_fanta"]?>';
<?php }?>
			var header = function (data) {
    			doc.addImage(LogoEmp, 'GIF', 10, 15, 60, 60);
    			doc.setTextColor(40);
		        doc.setFontSize(16);
		        doc.setFontStyle('bold');
		        doc.text(tipoRel, 85, 27);
		        doc.setFontSize(12);
		        doc.setTextColor(40);
		        doc.setFontStyle('italic');
		        doc.text("<?=$nomeEmp?>", 85, 47);
		        doc.setFontSize(8);
		        doc.setFontStyle('normal');
		        doc.text("Emitido em <?=$data?>", 460, 20);
		        //doc.text(" | Total de Vendas: " + (linhas.length - 1), 460, 75);
		        doc.setFontSize(9);
				doc.text("Empresa: " + empresa , 85, 56);
				doc.text(cx , 85, 66);
		        //doc.text("Subgrupo: " + subgrupo , 85, 66);
        		//doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 76);
			}
			
			doc.autoTable(data1.columns, data1.rows,{
				beforePageContent: header,
    			margin: {top: 80, right: 10, bottom: 20, left: 10},
				styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
				
				columnStyles: {
					0: {halign: 'left',cellWidth: 60}, 
					1: {halign: 'center', cellWidth: 50}, 
					2: {halign: 'right', cellWidth: 60},

					rowStyles: {1: {fontSize: (number = 11)}},
					tableLineColor: [189, 195, 199],
					tableLineWidth: 0.75,
					headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
					bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
					alternateRowStyles: {fillColor: [250, 250, 250]},

					drawRow: function (row, data) {
						doc.setFontStyle('bold');
						doc.setFontSize(8);
						if ($(row.raw[0]).hasClass("innerHeader")) {
							c.setTextColor(200, 0, 0);
							doc.setFillColor(110,214,84);
							doc.rect(data.settings.margin.left, row.y, data.table.width, 20, 'F');
							doc.autoTableText("", data.settings.margin.left + data.table.width / 2, row.y + row.height / 2, {
								halign: 'center',
		                    	valign: 'middle'
							});
						};

						if (row.index % 5 === 0) {
		                	var posY = row.y + row.height * 6 + data.settings.margin.bottom;
		                	if (posY > doc.internal.pageSize.height) {
		                    	data.addPage();
		                	}
		            	}
						
					}
				}
			});

			window.open(doc.output('bloburl'),'_blank');

		}

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