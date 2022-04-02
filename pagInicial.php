		<?php 
			include 'services/dashboard.php';
			$ano = date('Y');
			$mes = date('m');
			$hoje = date('Y-m-d');
			
			$todalCondicional = dashboardTotalCont($conexao, base64_decode($empresa));
			$totalVendasMes = dashboardTotalVendas($conexao,  base64_decode($empresa), $ano, $mes);
			$totalVendasMesValor = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, $mes);
			$totalVendasMesValorHoje = dashboardTotalVendasValorHoje($conexao,  base64_decode($empresa), $hoje);

			$jan = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '01');
			$fev = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '02');
			$mar = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '03');
			$abr = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '04');
			$mai = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '05');
			$jun = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '06');
			$jul = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '07');
			$ago = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '08');
			$set = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '09');
			$out = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '10');
			$nov = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '11');
			$dez = dashboardTotalVendasValor($conexao,  base64_decode($empresa), $ano, '12');
			
		?>
		<style>
			.large{
				font-size:2% !important;
			}
		</style>
			<div style="margin-top:23px;">
				<div class="row align-items-center">
					<div class="col-md-3 col-6">
						<div class="panel panel-orange panel-widget">
							<div class="row no-padding">
								<div class="col-sm-3 col-lg-5 widget-left">
									<h1 style="text-align: center;"><i class="fas fa-truck"></i></h1>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large m-0" style="font-size: 2em !important;"><?=$todalCondicional['total']?></div>
									<div class="text-muted m-0"><h6><small>Total Condicional</small></h6></div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-6">
						<div class="panel panel-orange panel-widget">
							<div class="row">
								<div class="col-sm-3 col-lg-5 widget-left">
									<h1 style="text-align: center;"><i class="fas fa-cart-arrow-down"></i></h1>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large" style="font-size: 2em !important;"><?=$totalVendasMes['total']?></div>
									<div class="text-muted"><h6><small>Total Vendas Mês</small></h6></div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-6">
						<div class="panel panel-teal panel-widget">
							<div class="row no-padding">
								<div class="col-sm-3 col-lg-5 widget-left">
									<h1 style="text-align: center;"><i class="fas fa-hand-holding-usd"></i></h1>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large text-truncate" style="font-size: 2em !important;"><?=number_format($totalVendasMesValor['total'],2, ',', '.')?></div>
									<div class="text-muted"><h6><small>Vendas Mês</small></h6></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-6">
						<div class="panel panel-red panel-widget">
							<div class="row no-padding">
								<div class="col-sm-3 col-lg-5 widget-left">
									<h1 style="text-align: center;"><i class="fas fa-hand-holding-usd"></i></h1>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large text-truncate" style="font-size: 2em !important;"><?=number_format($totalVendasMesValorHoje['total'],2, ',', '.')?></div>
									<div class="text-muted"><h6><small>Vendas Do Dia</small></h6></div>
								</div>
							</div>
						</div>
					</div>
				</div>

	  			<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
					    	<md-subheader class="md-no-sticky" style="background-color: transparent; color:#CECECEFF;">
							    <span>Gráfico de Vendas</span>
					    	</md-subheader>
							<div class="panel-body p-1">

								<canvas id="myChart" width="400" height="150" style="background-color: #CECECEFF !important"></canvas>

							</div>
						</div>
					</div><!--/.col-->
				</div>
			</div>
		</div>
	</div>

	<div class="overlay"></div>

    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/angular-chart.min.js"></script>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mCustomScrollbar.concat.min.js"></script>
	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $mdDialog) {

		$scope.valores = [
			[65, 59, 80, 81, 56, 55, 40],
			[28, 48, 40, 19, 86, 27, 90]
		];

	    var originatorEv;

	    $scope.openMenu = function($mdMenu, ev) {
	      originatorEv = ev;
	      $mdMenu.open(ev);
	    };
	});

</script>

<script>

	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['Jan/'+<?=substr($ano,2,2)?>, 'Fev/'+<?=substr($ano,2,2)?>, 'Mar/'+<?=substr($ano,2,2)?>, 'Abr/'+<?=substr($ano,2,2)?>, 'Mai/'+<?=substr($ano,2,2)?>, 'Jun/'+<?=substr($ano,2,2)?>, 'Jul/'+<?=substr($ano,2,2)?>, 'Ago/'+<?=substr($ano,2,2)?>, 'Set/'+<?=substr($ano,2,2)?>, 'Out/'+<?=substr($ano,2,2)?>, 'Nov/'+<?=substr($ano,2,2)?>, 'Dez/'+<?=substr($ano,2,2)?>],
	        datasets: [{
				label: 'Vendas',
	            data: [
					<?=$jan['total']?>,
					<?=$fev['total']?>,
					<?=$mar['total']?>,
					<?=$abr['total']?>,
					<?=$mai['total']?>,
					<?=$jun['total']?>,
					<?=$jul['total']?>,
					<?=$ago['total']?>,
					<?=$set['total']?>,
					<?=$out['total']?>,
					<?=$nov['total']?>,
					<?=$dez['total']?>,
				],
	            backgroundColor: [
	                'rgba(102, 0, 153, 0.5)',
	                'rgba(191, 0, 64, 0.5)',
	                'rgba(140, 0, 125, 0.5)',
	                'rgba(153, 0, 102, 0.5)',
	                'rgba(64, 0, 191, 0.5)',
	                'rgba(25, 0, 230, 0.5)',
	                'rgba(89, 0, 166, 0.5)',
	                'rgba(166, 0, 89, 0.5)',
	                'rgba(125, 0, 140, 0.5)',
	                'rgba(25, 0, 230, 0.5)',
	                'rgba(50, 0, 205, 0.5)',
	                'rgba(0, 0, 255, 0.5)'
	            ],
	            borderColor: [
	                'rgba(102, 0, 153, 1)',
	                'rgba(191, 0, 64, 1)',
	                'rgba(140, 0, 125, 1)',
	                'rgba(153, 0, 102, 1)',
	                'rgba(64, 0, 191, 1)',
	                'rgba(25, 0, 230, 1)',
	                'rgba(89, 0, 166, 1)',
	                'rgba(166, 0, 89, 1)',
	                'rgba(125, 0, 140, 1)',
	                'rgba(25, 0, 230, 1)',
	                'rgba(50, 0, 205, 1)',
	                'rgba(0, 0, 255, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});

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

</script>

</body>
</html>