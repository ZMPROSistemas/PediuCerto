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
	.dropdown-menu{
		box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);
		border-radius:15px;
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

	 .abrirCaixa{
	 	position: absolute;
	 	z-index: 998;
	 	height: 100px;
	 	top: 150px;
	    bottom: 0;
	    left: 0;
	    right: 0;
	 }
	 .cash-register{
	 	background-image: url('svg/cash-register-solid.svg');
	 	fill: #fff;
	 	size: 150px;
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
			<li class="breadcrumb-item" aria-current="page">Caixas</li>
			<!--li class="breadcrumb-item active" aria-current="page">Abrir e Fechar Caixa</li-->
		</ol>
	</nav>

	<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
			{{alertMsg}}
	</div>


	<div class="row">
		<div class="col-lg-12">
			<div ng-if="lista">

                <div show-on-desktop>
                    <div class="row bg-dark">
                        <div class="form-group col-md-6 col-10 pt-3 pb-0">

    <?php if (base64_decode($empresa_acesso) == 0) {?>

                            <label for="empresas">Empresas</label>
                            <select class="form-control form-control-sm capoTexto" id="empresa" ng-model="empresa" value="">
                                <option value=""> Todas Empresas</option>
                                <option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>

                            </select>

                                        <?php } else {
        echo utf8_encode($dados_empresa["em_fanta"]);
    }?>

                        </div>

                    </div>

                    <table class="table table-striped table-borderless" style="background-color: #FFFFFFFF; color: black;" ng-if="caixasVerifica >= 1">
                        <thead class="thead-dark">
                            <tr>
                                <th>Empresa</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>IP</th>
                                <th>Usuário</th>
                                <th>Ação</th>

                            </tr>

                        </thead>
                        <tbody>
                            <tr dir-paginate="log in logs| filter:{bc_empresa:empresa}  | orderBy:'sortKey':reverse | itemsPerPage:10">
                                <td>{{log.em_fanta}}</td>
                                <td>{{log.bc_descricao}}</td>
                                <td>{{log.bc_situacao}}</td>
                                <td>{{log.bc_data | date:'dd/MM/yyyy'}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>

                    </table>

                    <dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>


                </div>


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
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/mask/angular-money-mask.js"></script>

	<script src="js/jspdf.min.js"></script>
	<script src="js/jspdf.plugin.autotable.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial','angularUtils.directives.dirPagination','money-mask']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log) {

		    $scope.tab = 1;
			$scope.lista = true;
			$scope.ficha = false;
  			$scope.data = new Date();
  			$scope.urlBase = 'services/'
  			$scope.tipoAlerta = "alert-success";
			$scope.alertMsg = "Cadastro realizado com sucesso";
		

			$scope.dadosEmpresa=[];

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


		    $scope.MudarVisibilidade = function() {

		    	$scope.lista = !$scope.lista;
		    	$scope.ficha = !$scope.ficha;

		    };



			$scope.print = function(){
				gerarpdf();
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

	
		
		function loguin(){
			$('.login').toggle("slow");
		}
		function abrirCaixa(){
			$('.abrirCaixa').toggle("slow");
		}

		function senhaIn(e){
	 		$('#login').attr('type', 'password');
		}
		

		function senhaOut(){
			//$('#login').attr('type', 'text');
			//alert('certo');
		}

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