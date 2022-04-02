<style>
	md-tabs.md-default-theme .md-tab.md-active, md-tabs .md-tab.md-active, md-tabs.md-default-theme .md-tab.md-active md-icon, md-tabs .md-tab.md-active md-icon, md-tabs.md-default-theme .md-tab.md-focused, md-tabs .md-tab.md-focused, md-tabs.md-default-theme .md-tab.md-focused md-icon, md-tabs .md-tab.md-focused md-icon {

		color: rgb(0, 0, 0);
	    background-color: rgba(255, 255, 255, 1);
	    border-radius: 15px 15px 0 0;
	    box-shadow: 5px 1px 1px 0 rgba(0,0,0,0.5);
	    margin-left: 15px;
	    margin-top: 5px;
	}


	md-tabs-canvas {background-color: rgba(0,0,0,0.5) !important;}

	md-tabs.md-default-theme .md-tab, md-tabs .md-tab {
		    color: rgba(255,255,255,1);
	}

	md-tabs:not(.md-no-tab-content):not(.md-dynamic-height){
		min-height: 50rem;
	}
	md-tabs.md-default-theme md-ink-bar, md-tabs md-ink-bar {
		background: transparent;
	}

	.linhaTable{
		line-height: 10px;
		cursor:pointer;
	}
	md-switch.md-default-theme .md-thumb, md-switch .md-thumb {
    	background-color: rgb(228, 146, 146);
    	width: 25px;
    	height: 25px;
    	top: -1.5px;
	}
	md-switch .md-bar {
    left: 5px;
    width: 54px;
    top: 1px;
    height: 24px;
    border-radius: 18px;
    position: absolute;
	}
	md-switch.md-default-theme .md-bar, md-switch .md-bar {
	    background-color: rgb(228, 146, 146);
	}
	md-switch .md-thumb-container {
		width: 40px;
	}
	md-switch.md-default-theme.md-checked:not([disabled]) .md-bar, md-switch.md-checked:not([disabled]) .md-bar {
    	background-color: rgba(24, 107, 0, 0.5);
	}
	md-switch.md-default-theme.md-checked:not([disabled]) .md-thumb, md-switch.md-checked:not([disabled]) .md-thumb {
    	background-color: rgb(24, 107, 0);
	}
	md-switch{

	}
	.semConfirmar{
		color:#d00c0c;

	}
	.md-confirm {
		color: rgb(250, 250, 250) !important;
		background-color: rgb(125, 197, 137) !important;
	}

	.statusToolbarNovo{
		background-color: rgba(91,91,91,1) !important;
	}

	.statusToolbarPreparando{
		background-color: rgba(209, 105, 0,0.5) !important;
	}

	.statusToolbarTransito{
		background-color: rgba(121, 170, 239,0.5) !important;
	}

	.statusToolbarEntregue{
		background-color: rgba(0, 143, 24,0.5) !important;
	}

	.statusToolbarRetornado{
		background-color: rgba(90, 90, 90,0.5) !important;
	}

	.statusToolbarCancelado{
		background-color: rgba(176, 0, 5,0.5) !important;
	}

	.box{
		color: #fff;
		margin-top:2px;
		padding: 10px;

	}
	.box-info{
		background-color:#2E4DD4;
	}

</style>
<!--
<p>Count numbers: <output id="result"></output></p>

<button onclick="startWorker()">Start Worker</button>
<button onclick="stopWorker()">Stop Worker</button>
-->

<div ng-controller="ZMProCtrl">

	<nav aria-label="breadcrumb" class="noPrint">
		<ol class="breadcrumb p-0">
			<li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page">Pedidos</li>
	<!--						<button type="" ng-click="verarray()" style="display:none">ver array</button> -->
		</ol>
	</nav>

	<div class="alert {{tipoAlerta}} col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
			{{alertMsg}}
	</div>

	<?php
		include_once "Modal/impressora/imprimirConzinha.php";
		include_once "Modal/impressora/imprimirEntrega.php";
		include_once "Modal/pedido/motivo_canc.php";
	?>
	<div class="noPrint">
		<audio id="notificacao" preload="auto">
			<source src="http://soundbible.com/grab.php?id=2154&type=mp3" type="audio/mpeg">
		</audio>
		<md-content class="md-padding">

			<div layout="row" layout-align="space-around center" style="width: 80%; position: absolute; right: 0; margin-right: 40px; top: 10px; z-index: 999;">
				
				<!--div flex-gt-sm="23" flex-md="35" style="color:#fff;">
					<a class="btn" data-toggle="collapse" href="#taxa" role="button" aria-expanded="false" aria-controls="taxa" style="text-align: left;"> 	
						<i class="fas fa-dollar-sign"></i> Taxa Entrega {{dadosEmp[0].em_taxa_entrega | currency : 'R$ '}}
					</a>
				</div-->
				
				<div flex-gt-sm="31" flex-md="15" style="color:#fff;">
					<a class="btn" style="text-align: left;" data-toggle="collapse" href="#tempo" role="button" aria-expanded="false" aria-controls="tempo"> 
						<i class="fas fa-stopwatch"></i> Tempo De Entrega {{dadosEmp[0].em_entrega1}} à  {{dadosEmp[0].em_entrega2}}<small></small>
						<span style="margin-left: 10px;"></span><br>
						<i class="fas fa-stopwatch"></i> Tempo Retirada {{dadosEmp[0].em_retira}}<small></small>
					</a>
				</div>

				<div layout="row" layout-align="space-between center" style="color:#fff;">
					<div>
						<md-switch md-invert ng-model="statusCheck" ng-change="mudarStatus()">
						<span>{{status[0].em_aberto}}</span>
						</md-switch>
					</div>

					<div>
						<span ng-show="status[0].em_aberto == 'Aberto'" style="margin-top:4px; margin-left: 40px;">Às: {{status[0].em_hora_abertura}}</span>
					</div>
				</div>
				

			</div>
			

			<md-tabs md-selected="selectedIndex" md-border-bottom md-autoselect md-swipe-content md-left-tabs>
				 <md-tab label="Pedidos">

					<div class="row" style="width:300px; left:20%; position:absolute; z-index: 999;">
					
						<div class="col">
							<div class="collapse multi-collapse" id="taxa">
								<div class="card card-body">
									<div class="row">
										<input type="text" class="form-control form-control-sm" id="taxaEntrega" ng-value="dadosEmp[0].em_taxa_entrega | currency : 'R$ '" ng-model="taxa" style="text-align:right;" money-mask>
									</div>

									<div class="row" style="margin-top:10px;">
										<md-button class="btn btn-block btn-primary" ng-click="alterarTaxa(taxa)">Alterar</md-button>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="row" style="width:300px; left:45%; position:absolute; z-index: 999;">
					
						<div class="col">
							<div class="collapse multi-collapse" id="tempo">
								<div class="card card-body">
									<div class="row">
										<label for="">Tempo De Entrega</label>
										<div class="form-row">
											
											<div class="col">
												<input type="time" class="form-control form-control-sm" min="00:00" max="09:00" ng-value="dadosEmp[0].em_entrega1 | date : 'HH:mm'" ng-model="hora1" style="text-align:right;">
											</div>
											<div class="col">
												<input type="time" class="form-control form-control-sm" ng-value="dadosEmp[0].em_entrega2 | date : 'HH:mm'" ng-model="hora2" style="text-align:right;">
											</div>
											
										</div>
										
									</div>
										
									<div class="row">
										<label for="">Tempo Para Retirar</label>
										<div class="form-row">
											<div class="col">
												<input type="time" class="form-control" ng-value="dadosEmp[0].em_retira | date : 'HH:mm'" ng-model="retirar" style="text-align:right;">
											</div>
										</div>
									</div>

									<div class="row" style="margin-top:10px;">
										<md-button class="btn btn-block btn-primary" ng-click="tempo(hora1 | date : 'HH:mm', hora2 | date : 'HH:mm', retirar | date : 'HH:mm')">Alterar</md-button>
									</div>
								</div>
							</div>
						</div>

					</div>


				 	<div layout="row">

				 		<div flex="">
				 			<div class="input-group col-12 pt-2">
								<input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida" autocomplete="off">
								<div class="input-group-btn">
									<button type="button" class="btn btn-outline-dark" style="border:none;">
										<i class="fas fa fa-search"></i>
									</button>
								</div>
							</div>
				 			<div layout="row" layout-align="space-between center" style="background-color: rgba(91,91,91,1) !important;">
				 				<div style="margin-top: 5px;">
				 					<form class="col-12">

				 						<div layout="row" layout-align="space-around center">
											<div style="width: 150px;">
												<h5>Pedidos Novos!</h5>
											</div>

											<div>
													<span class="badge badge-light" style="margin-top: -15px; margin-left: 20px;">{{pedidoNovo.length}}</span>
											</div>

				 						</div>
				 					</form>
				 				</div>

				 			</div>

				 			<div>

					 			<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

					 				<tbody>
					 					<tr class="linhaTable" ng-repeat="pedido in pedidoNovo" ng-click="pedidoDescricaoBusca(pedido.ped_id)" ng-class="pedido.ped_confirmado =='N' ? 'semConfirmar': ''">
					 						<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
					 						<td ng-bind="pedido.ped_cliente_nome"></td>
					 						<td>
					 							<span>{{pedido.ped_hora_entrada}}</span>

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>

											<td>
											<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>
											
											 <td>
											 	<i ng-if="pedido.ped_confirmado =='S'" class="fas fa-check" style="color:rgb(0,104,28)"></i>
												<i ng-if="pedido.ped_confirmado =='N'" class="fas fa-check" style="color:rgb(204,201,201)"></i>
											</td>
											
					 					</tr>
					 				</tbody>

					 			</table>

				 			</div>


				 			<div class="" style="background-color: rgba(209, 105, 0,0.5) !important;">
				 				<div layout="row" layout-align="space-between center">
				 					<div style="margin-top: 5px;">
				 						<form class="col-12" style="float: left;">

				 							<div layout="row" layout-align="space-around center">
				 								<div style="width: 150px;">
				 									<h5>Em Preparo </h5>
				 								</div>

				 								<div>
				 									<span class="badge badge-light">{{pedidoPreparo.length}}</span>
				 								</div>

				 							</div>

				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" style="background-color: transparent; border: none" onclick="em_preparo();">
				 						<i class="fas fa-sort-down"></i>
				 					</button>
				 					</div>

				 				</div>

				 			</div>

				 			<div class="em_preparo" style="display: none;">
					 			<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

					 				<tbody>
									 <tr class="linhaTable" ng-repeat="pedido in pedidoPreparo" ng-click="pedidoDescricaoBusca(pedido.ped_id)">
					 						<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
					 						<td ng-bind="pedido.ped_cliente_nome"></td>
					 						<td>
					 							<span style="margin-right: 5px;">{{pedido.ped_hora_entrada}}</span><i class="fas fa-caret-right"></i>
												 <span style="margin-right: 5px; color: rgba(209, 105, 0,1)">{{pedido.ped_hora_preparo}}</span>
												

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>

											<td>
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>
											
											
					 					</tr>

					 				</tbody>

					 			</table>
				 			</div>

				 			<div class="" style="background-color: rgba(121, 170, 239,0.5) !important;">
				 				<div layout="row" layout-align="space-between center">
				 					<div>
				 						<form class="col-12" style="float: left;">

				 							<div layout="row" layout-align="space-around center">
				 								<div style="width: 150px;">
				 									<h5>Em Transito</h5>
				 								</div>

				 								<div>
				 									<span class="badge badge-light">{{pedidoTransito.length}}</span>
				 								</div>

				 							</div>


				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" onclick="em_transito();"  style="background-color: transparent; border: none">
				 						<i class="fas fa-sort-down"></i>
				 					</button>
				 					</div>

				 				</div>

				 			</div>

				 			<div class="em_transito" style="display: none;">
							 <table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

									<tbody>

										<tr class="linhaTable" ng-repeat="pedido in pedidoTransito" ng-click="pedidoDescricaoBusca(pedido.ped_id)">

											<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
					 						<td ng-bind="pedido.ped_cliente_nome"></td>
					 						<td>
					 							<span style="margin-right: 5px;">{{pedido.ped_hora_entrada}}</span><i class="fas fa-caret-right"></i>
												
												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo != ''">
													{{pedido.ped_hora_preparo}}
												</span>
												
												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo == ''">
													--:--
												</span>

												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(121, 170, 239,1)">{{pedido.ped_hora_saida}}</span>

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>

											<td>
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>
											
										</tr>

					 				</tbody>

					 			</table>

				 			</div>

				 			<div class="" style="background-color: rgba(0, 143, 24,0.5) !important;">
				 				<div layout="row" layout-align="space-between center">
				 					<div>
				 						<form class="col-12" style="float: left;">

				 							<div layout="row" layout-align="space-around center">
				 								<div  style="width: 150px;">
				 									<h5>Entregue</h5>
				 								</div>

				 								<div>
				 									<span class="badge badge-light">{{pedidoEntregue.length}}</span>
				 								</div>

				 							</div>


				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" onclick="entregue();" style="background-color: transparent; border: none">
				 						<i class="fas fa-sort-down"></i>
				 					</button>
				 					</div>

				 				</div>

				 			</div>

				 			<div class="entregue" style="display: none;">

					 			<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

					 				<tbody>

										<tr class="linhaTable" ng-repeat="pedido in pedidoEntregue" ng-click="pedidoDescricaoBusca(pedido.ped_id)">

											<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
											<td ng-bind="pedido.ped_cliente_nome"></td>
											<td>
												<span style="margin-right: 5px;">{{pedido.ped_hora_entrada}}</span><i class="fas fa-caret-right"></i>
												
												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo != ''">
													{{pedido.ped_hora_preparo}}
												</span>
												
												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo == ''">
													--:--
												</span>

												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(121, 170, 239,1)" ng-if="pedido.ped_hora_saida != ''">
													{{pedido.ped_hora_saida}}
												</span>

												<span style="margin-right: 5px; color: rgba(121, 170, 239,1)" ng-if="pedido.ped_hora_saida == ''">
													--:--
												</span>
												
												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(0, 143, 24,1)">{{pedido.ped_hora_entrega}}</span>

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>

											<td>
												<span ng-if="pedido.ped_finalizado == 'S'" class="badge badge-light" style="background-color:rgba(0, 143, 24,0.5); color:#fff;">Finalizado</span>
											</td>

											<!--td>
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td-->

										</tr>
					 					

					 				</tbody>

					 			</table>

				 			</div>

				 			<div class="" style="background-color: rgba(90, 90, 90,0.5) !important;">
				 				<div layout="row" layout-align="space-between center">
				 					<div>
				 						<form class="col-12">
				 							<div layout="row" layout-align="space-around center">
				 								<div style="width: 150px;">
				 									<h5>Retornado</h5>
				 								</div>

				 								<div>
				 									<span class="badge badge-light">{{pedidoRetornado.length}}</span>
				 								</div>

				 							</div>


				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" onclick="retornado();" style="background-color: transparent; border: none">
				 						<i class="fas fa-sort-down"></i>
				 					</button>
				 					</div>

				 				</div>

				 			</div>

				 			<div class="retornado" style="display: none;">
					 			<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

					 				<tbody>
										<tr class="linhaTable" ng-repeat="pedido in pedidoRetornado" ng-click="pedidoDescricaoBusca(pedido.ped_id)">

											<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
											<td ng-bind="pedido.ped_cliente_nome"></td>
											<td>
												<span style="margin-right: 5px;">{{pedido.ped_hora_entrada}}</span><i class="fas fa-caret-right"></i>
												
												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo != ''">
													{{pedido.ped_hora_preparo}}
												</span>

												<span style="margin-right: 5px; color: rgba(209, 105, 0,1)" ng-if="pedido.ped_hora_preparo == ''">
													--:--
												</span>

												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(121, 170, 239,1)" ng-if="pedido.ped_hora_saida != ''">
													{{pedido.ped_hora_saida}}
												</span>

												<span style="margin-right: 5px; color: rgba(121, 170, 239,1)" ng-if="pedido.ped_hora_saida == ''">
													--:--
												</span>
												
												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(0, 143, 24,1)" ng-if="pedido.ped_hora_entrega != ''">
													{{pedido.ped_hora_entrega}}
												</span>

												<span style="margin-right: 5px; color: rgba(0, 143, 24,1)" ng-if="pedido.ped_hora_entrega == ''">
													--:--
												</span>
												
												<i class="fas fa-caret-right"></i>

												<span style="margin-right: 5px; color: rgba(90, 90, 90,1)">
													{{pedido.ped_hora_retornado}}
												</span>

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>

											<td>
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>

										</tr>

					 				</tbody>

					 			</table>
				 			</div>


				 			<div class="" style="background-color: rgba(176, 0, 5,0.5) !important;">
				 				<div layout="row" layout-align="space-between center">
				 					<div>
				 						<form class="col-12">
				 							<div layout="row" layout-align="space-around center">
				 								<div style="width: 150px;">
				 									<h5>Cancelados</h5>
				 								</div>

				 								<div>
				 									<span class="badge badge-light">{{pedidoCancelado.length}}</span>
				 								</div>

				 							</div>


				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" onclick="cancelado();" style="background-color: transparent; border: none">
				 						<i class="fas fa-sort-down"></i>
				 					</button>
				 					</div>

				 				</div>

				 			</div>

				 			<div class="cancelado" style="display: none;">
					 			<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

					 				<tbody>
										<tr class="linhaTable" ng-repeat="pedido in pedidoCancelado" ng-click="pedidoDescricaoBusca(pedido.ped_id)">

											<td ng-bind="pedido.ped_doc | numberFixedLen:4"></td>
											<td ng-bind="pedido.ped_cliente_nome"></td>
											<td>
												<span style="margin-right: 5px;">{{pedido.ped_hora_entrada}}</span><i class="fas fa-caret-right"></i>
												<span style="margin-right: 5px; color: rgba(176, 0, 5,1)">{{pedido.ped_hora_cancel}}</span>
												

											</td>

											<td>
												<span ng-if="pedido.ped_entregar == 'S'" class="badge badge-light" style="background-color:rgb(145, 144, 144); color:#fff;">Entregar</span>
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(213,125, 128); color:#fff;">A Retirar</span>
											</td>
											
											<td>
												<span ng-if="pedido.ped_finalizado == 'S'" class="badge badge-light" style="background-color:rgba(0, 143, 24,0.5); color:#fff;">Finalizado</span>
											</td>

											<td>
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>

										</tr>

					 				</tbody>

					 			</table>
				 			</div>

				 		</div>

	  					<div flex="">

							<div class="row justify-content-center confirmarPedido" style="height: 100px; margin-left: 15px; margin-top: 90px; position:absolute" ng-if="pedidoDescricao[0].ped_confirmado == 'N'">
								<div class="card border-dark mb-3" style="width: 25rem; background-color:rgba(91,91,91,1);">
									<div class="card-header">
										<form>
											<div class="form-row justify-content-center">
												<div class="form-group">
													<span style="color:#fff; margin-right:10px;">Confirmar Pedido?</span>

													<a type="submit" class="btn btn-outline-danger" style="color: white;" onclick="confirmarPedido();">
														Não
													</a>

													<button  type="submit" class="btn btn-outline-success" ng-click="confirmarPedido(pedidoDescricao[0].ped_id, pedidoDescricao[0].ped_doc)">
														Sim
													</button>

												</div>
											</div>
									
										</form>
									</div>
								</div>
							</div>


							<div ng-if="pedidoDescricao[0].ped_id != null">

								<md-toolbar class="md-warn" ng-class="
									pedidoDescricao[0].ped_status == 'Novo' ? 'statusToolbarNovo' : 
									pedidoDescricao[0].ped_status == 'Preparando' ? 'statusToolbarPreparando' : 
									pedidoDescricao[0].ped_status == 'Transito' ? 'statusToolbarTransito' : 
									pedidoDescricao[0].ped_status == 'Entregue' ? 'statusToolbarEntregue' : 
									pedidoDescricao[0].ped_status == 'Retornado' ? 'statusToolbarRetornado' : 
									pedidoDescricao[0].ped_status == 'Cancelado' ? 'statusToolbarCancelado' : '' "
									ng-if="pedidoDescricao[0].ped_finalizado == 'N'">
									<div class="md-toolbar-tools">
										<span>Status atual do pedido 
											<span ng-if="pedidoDescricao[0].ped_status == 'Transito'"> Em </span>
											<span ng-if="pedidoDescricao[0].ped_status != 'Preparando'">{{pedidoDescricao[0].ped_status}}</span>
											<span ng-if="pedidoDescricao[0].ped_status == 'Preparando'"> Em Preparo</span>
										</span>
									</div>
								</md-toolbar>
								
								<md-toolbar class="md-warn statusToolbarEntregue" ng-if="pedidoDescricao[0].ped_finalizado == 'S'">
									<div class="md-toolbar-tools">
										<span>Pedido foi finalizado</span>
									</div>
								</md-toolbar>

								<div layout="row" layout-align="space-between center" style="margin-top: -5px padding-left:15px; padding-right:15px;">
									
									<div layout="column" layout-align="center start">
										
										<div layout="row" layout-align="start center">
											<div style="margin-left: 10px;"><b>{{pedidoDescricao[0].ped_doc | numberFixedLen:4}}</b></div>
											<div style="margin-left:15px;"><span>{{pedidoDescricao[0].ped_cliente_nome}}</span></div>
										</div>
										
										<div layout="column" layout-align="start start" style="margin-top: 10px;">
											<div style="margin-left: 10px;"><span>{{pedidoDescricao[0].ped_cliente_fone}}</span></div>
											<div style="margin-left: 10px;"><span>{{pedidoDescricao[0].ped_cliente_end_entrega}}, {{pedidoDescricao[0].ped_cliente_end_num_entrega}}</span></div>
											<div style="margin-left: 10px;"><span>{{pedidoDescricao[0].ped_cliente_bairro_entrega}}, {{pedidoDescricao[0].ped_cliente_cid_entrega}}</span></div>
											<div style="margin-left: 10px;"><span ng-if="pedidoDescricao[0].ped_cliente_compl_entrega != ''">Referência: </span><span> {{pedidoDescricao[0].ped_cliente_compl_entrega}}</span></div>
										</div>
									
									</div>


									<div layout="column" layout-align="end end" style="margin-top: 30px;">

										<div layout="row" layout-align="start center">
											<div style="text-align:left; width:90px;"> SUBTOTAL</div>
											<div style="">{{pedidoDescricao[0].ped_valor | currency : 'R$ '}}</div>
										</div>

										<div layout="row" layout-align="start center" ng-if="pedidoDescricao[0].ped_val_entrega != '0.00' || pedidoDescricao[0].ped_val_entrega != null">
											<div style="text-align:left; width:152px;">TAXA DE ENTREGA </div>
											<div style="">{{pedidoDescricao[0].ped_val_entrega | currency : 'R$ '}} </div>
										</div>

										<div layout="row" layout-align="start center">
											<div style="text-align:left; width:100px;">DESCONTO </div>
											<div ng-if="pedidoDescricao[0].ped_val_desc != null">{{pedidoDescricao[0].ped_val_desc | currency : 'R$ '}} </div>
											<div ng-if="pedidoDescricao[0].ped_val_desc == null"> - </div>
										</div>
										
										<div layout="row" layout-align="start center">

											<div style="text-align:left; width:65px;"> TOTAL </div> 
											<div style="">{{pedidoDescricao[0].ped_total | currency : 'R$ '}}</div>
										
										</div>

										<div layout="row" layout-align="start center" ng-if="pedidoDescricao[0].ped_troco_para != '0.00'">

											<div style="text-align:left; width:100px;;"> Troco Para </div> 
											<div style="">{{pedidoDescricao[0].ped_troco_para | currency : 'R$ '}}</div>
										
										</div>
									
											

																				
									</div>

									
								</div>

								<div layout="column" layout-align="start start" style="margin-top: 30px; margin-left: 10px; padding-left:15px; padding-right:15px;">
									<b>Observações</b>
									<div>{{pedidoDescricao[0].ped_obs}}</div>
									<div ng-if="pedidoDescricao[0].ped_pago == 'S'">Pagamento Online.</div>
								</div>
								
								<md-divider style="margin-top:10px;"></md-divider>
								
								<div ng-init="mudarStatusPed = pedidoDescricao[0].ped_status" ng-if="pedidoDescricao[0].ped_finalizado == 'N'" style="margin-top: 10px; padding-left:15px; padding-right:15px;">
									
									<label>Trocar status do pedido:</label>

									<div layout="row" layout-align="space-around center" ng-if="pedidoDescricao[0].ped_confirmado == 'S'">
										
										<md-button class="md-raised md-accent" ng-if="pedidoDescricao[0].ped_status != 'Novo'" ng-click="retornarStatusPedido(pedidoDescricao[0].ped_id, pedidoDescricao[0].ped_status , pedidoDescricao[0].ped_doc)"><i class="fa fa-reply"></i> Retornar anterior</md-button>
										
										<md-button class="md-raised md-primary" ng-click="mudarStatusPedido(pedidoDescricao[0].ped_id, 'Preparando',pedidoDescricao[0].ped_doc)" 
											ng-if="pedidoDescricao[0].ped_status == 'Novo'
											&& pedidoDescricao[0].ped_status != 'Cancelado'">Preparando</md-button>
										
										<md-button ng-model="mudarStatusTr" ng-click="mudarStatusPedido(pedidoDescricao[0].ped_id, 'Transito', pedidoDescricao[0].ped_doc)" class="md-raised md-primary"
										ng-if="pedidoDescricao[0].ped_status == 'Novo' 
										|| pedidoDescricao[0].ped_status == 'Preparando'
										|| (pedidoDescricao[0].ped_status != 'Entregue' 
										&& pedidoDescricao[0].ped_status != 'Transito'
										&& pedidoDescricao[0].ped_status != 'Cancelado')">Em Transito</md-button>

										<md-button class="md-raised md-primary" ng-click="mudarStatusPedido(pedidoDescricao[0].ped_id, 'Entregue', pedidoDescricao[0].ped_doc)"
										ng-if="pedidoDescricao[0].ped_status == 'Novo'
										|| pedidoDescricao[0].ped_status == 'Preparando'
										|| pedidoDescricao[0].ped_status == 'Transito'
										|| (pedidoDescricao[0].ped_status != 'Entregue'
										&& pedidoDescricao[0].ped_status != 'Cancelado')">Entregue</md-button>

										<md-button class="md-raised md-primary"ng-click="mudarStatusPedido(pedidoDescricao[0].ped_id, 'Retornado', pedidoDescricao[0].ped_doc)"
										ng-if="pedidoDescricao[0].ped_status == 'Entregue'
										|| (pedidoDescricao[0].ped_status != 'Retornado'
										&& pedidoDescricao[0].ped_status != 'Cancelado')">Retornado</md-button>
										
										<md-button class="md-raised md-primary" ng-click="ModalCancPedido(pedidoDescricao, 'Cancelado')">Cancelado</md-button>

									</div>
									
									
								</div>

								<md-divider style="margin-top:10px;"></md-divider>

								<div layout="row" layout-align="space-around center" style="margin-top: 10px;">

									<!--div ng-init="mudarStatusPed = pedidoDescricao[0].ped_status">

										<select class="form-control form-control-sm" id="empresa" ng-model="mudarStatusPed" value="" ng-change="mudarStatusPedido(pedidoDescricao[0].ped_id, mudarStatusPed,edidoDescricao[0].ped_doc)" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'">
											<option value="Novo" ng-if="pedidoDescricao[0].ped_status == 'Novo'">Novo</option>
											<option value="Preparando" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando'">Preparando</option>
											<option value="Transito" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando' || pedidoDescricao[0].ped_status == 'Transito'">Em Transito</option>
											<option value="Entregue" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando' || pedidoDescricao[0].ped_status == 'Transito'">Entregue</option>
											<option value="Retornado">Retornado</option>
											<option value="Cancelado">Cancelado</option>
										</select>
 
									</div-->
								
									<div style="margin-top:25px;">
										<md-button class="md-raised md-primary" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'" ng-click="imprimirCozinha()" ng-if="pedidoDescricao[0].ped_status != 'Entregue'">Imprimir Via Cozinha</md-button>
										<md-button class="md-raised md-confirm" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'" ng-click="finalizarPedido(pedidoDescricao[0].ped_id)" ng-if="pedidoDescricao[0].ped_status == 'Entregue' && pedidoDescricao[0].ped_finalizado == 'N'">Finalizar Pedido</md-button>
									</div>
									<div style="margin-top:25px;">
									<md-button class="md-raised md-primary" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'" ng-click="imprimirEntrega()">Imprimir Via Entrega</md-button>
									</div>

								</div>

							</div>

							<div ng-if="pedidoDescricao[0].ped_id != null" style="max-height: 200px; overflow-y: scroll;">

								<table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">

									<thead>
										<tr>
											<th style="text-align: center;">QTD</th>
											<th>ITEM</th>
											<th style="text-align: right;">Valor</th>
										</tr>
									</thead>
									
										<tbody>
											
											<tr ng-repeat="itens in pedidoDescricaoItens">
												
												<td  class="linhaTable" ng-bind="itens.pdi_quantidade | number" style="text-align: center;">
													
												</td>
												<td  class="linhaTable">

													{{itens.pdi_descricao}}<p></p>
													<small>{{itens.pdi_obs}}</small>

												</td>
												<td class="linhaTable"  ng-bind="itens.pdi_total" style="text-align: right;"></td>
											
											</tr>

										</tbody>
									
								</table>
							</div>
							
	  					</div>
				 	</div>
				 </md-tab>


				 <!--md-tab label="Dashboard">

				 </md-tab-->


			</md-tabs>

		</md-content>


	</div>

	<div class="printCozinha print">

	</div>

	<div id="printEntrega print">

	</div>
</div>
<script src="js/jquery-3.4.1.slim.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	
	<script src="js/mCustomScrollbar.concat.min.js"></script>
	
   	<script src="js/angular-locale_pt-br.js"></script>
	<script src="js/mask/angular-money-mask.js"></script>
	<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia', 'ngMaterial','money-mask']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $mdDialog) {

	    	$scope.pedidosCliente=[];
	    	$scope.status = 'Fechado';
	    	$scope.statusCheck = false;
	    	$scope.statusData = '';
	    	$scope.statusHora = '';

	    	$scope.urlBase = 'services/';
	    	$scope.dataI = dataHoje();
			$scope.dataF = dataHoje();
			
			$scope.dadosEmp = [];

    		$scope.pedidoNovo=[];
			$scope.pedidoPreparo=[];
			$scope.pedidoTransito=[];
			$scope.pedidoEntregue=[];
			$scope.pedidoRetornado=[];
			$scope.pedidoCancelado=[];

			$scope.pedidoDescricao=[];
			$scope.pedidoDescricaoItens=[];

	    var originatorEv;

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

	    $scope.openMenu = function($mdMenu, ev) {
	      originatorEv = ev;
	      $mdMenu.open(ev);
	    };

	    var statusAbertoFechado = function(){
	    	$http({
	    		method: 'GET',
	    		url: $scope.urlBase+ 'abrirEmpresa.php?verificaStatus=S&token=<?=$token?>'
	    	}).then(function onSuccess(response){

	    		$scope.status = response.data.result[0];
	    		$scope.statusCheck = $scope.status[0].statusCheck;
	    		//alert($scope.statusCheck);
				startEventStatus();
				
	    	}).catch(function onError(response){

	    	});
		}
		
		statusAbertoFechado();

		var dadosTaxaEntrega = function(){
			$http({
				method:'POST',
				headers: {
            		'Content-Type':'application/json'
				},
				cache: false,
				data:JSON.stringify({
					id: 0,
					token: "<?=$token?>",
				}),
				url: $scope.urlBase+ 'abrirEmpresa.php?dadosEmpresa=S'
			}).then(function onSuccess(response){
				$scope.dadosEmp = response.data;
			}).catch(function onError(){

			})
		}

		dadosTaxaEntrega();

		$scope.alterarTaxa = function(taxa){

			var taxa = taxa.replace('R','');
			taxa = taxa.replace('$','');
			taxa = taxa.replace(',','.');

			if($scope.dadosEmp[0].em_taxa_entrega != taxa){
				
				$http({
					method: 'POST',
					headers:{
						'Content-Type': 'application/json'
					},
					cache:false,
					data:JSON.stringify({
						tabela : 'taxa',
						taxa: taxa,
						token: '<?=$token?>',
						us : '<?=$us?>',
						us_id : '<?=$us_id?>',
						matriz : '<?=$empresa?>',
						filial : '<?=$empresa_acesso?>'
					}),
					url: $scope.urlBase+ 'taxaEntrega.php'
				}).then(function onSuccess(response){
					
					if (response.data[0].return == 'SUCCESS') {
						$('#taxa').collapse('hide');
						dadosTaxaEntrega();
					}
					
				}).catch(function onError(){

				});
			}
				$('#taxa').collapse('hide');
		}

		$scope.tempo = function(hora1, hora2, retira){
			
			if(hora1 == undefined){
				hora1 = $scope.dadosEmp[0].em_entrega1
			}
			if(hora2 == undefined){
				hora2 = $scope.dadosEmp[0].em_entrega2
			}
			if(retira == undefined){
				retira = $scope.dadosEmp[0].em_retira
			}

			$http({
				method: 'POST',
				headers:{
					'Content-Type': 'application/json'
				},
				cache:false,
				data:JSON.stringify({
					tabela : 'tempo',
					hora1 : hora1,
					hora2 : hora2,
					retira: retira,
					token: '<?=$token?>',
					us : '<?=$us?>',
					us_id : '<?=$us_id?>',
					matriz : '<?=$empresa?>',
					filial : '<?=$empresa_acesso?>'
				}),
				url: $scope.urlBase+ 'taxaEntrega.php'
			}).then(function onSuccess(response){
				
				if (response.data[0].return == 'SUCCESS') {
					$('#tempo').collapse('hide');
					dadosTaxaEntrega();
				}
				
			}).catch(function onError(){

			});
		
			$('#tempo').collapse('hide');
			
		}

	    var verificaPedidosNovos = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosNovos=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoNovo=response.data.result[0];
				for (i=0; i < $scope.pedidoNovo.length; i++){
					$scope.totalNovo = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}
		
		var verificaPedidosPreparo = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosPreparo=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoPreparo=response.data.result[0];
				for (i=0; i < $scope.pedidoPreparo.length; i++){
					$scope.totalPreparo = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}

		var verificaPedidosTransito = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosTransito=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoTransito=response.data.result[0];
				for (i=0; i < $scope.pedidoTransito.length; i++){
					$scope.totalTransito = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}

		var verificaPedidosEntregue = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosEntregue=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoEntregue=response.data.result[0];
				for (i=0; i < $scope.pedidoEntregue.length; i++){
					$scope.totalEntregue = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}

		var verificaPedidosRetornado = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosRetornado=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoRetornado=response.data.result[0];
				for (i=0; i < $scope.pedidoRetornado.length; i++){
					$scope.totalRetornado = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}

		var verificaPedidosCancelado = function(){
	    	$http({
	    		method:'GET',
	    		url:$scope.urlBase+ 'pedidos.php?vericaPedidos=S&pedidosCancelado=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
	    		$scope.pedidoCancelado=response.data.result[0];
				for (i=0; i < $scope.pedidoCancelado.length; i++){
					$scope.totalCancelado = i+1;
				}
	    	}).catch(function onError(response){

	    	});
		}
		$scope.ultimaID = 0;
		var ultimaAtualizacao = function(){
			
			timePed_novos_stop();
			$http({
				method: 'GET',
				url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&ultimaAtualizacao=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto+'&dataAbertura='+$scope.status[0].em_data_abertura
			}).then(function onSuccess(response){
				
				//console.log('ultimoPedido = '+ $scope.ultimaID + ' ID atual = ' + response.data);
				
				if(response.data != null){
					if ($scope.ultimaID != response.data) {
						verificaPedidosNovos();
						$scope.ultimaID = response.data;
						//alertPedNovo();
						
						//console.log('entrou');
					}
				}

				else {
					console.log('Não à atualização');	
				}
				timePed_novos_start()
				
			}).catch(function onError(response){
				timePed_novos_start()
			});
		}
	
		var alertPedido_nao_visualizado = function(){
			timePed_novos_stop();
			for(i = 0; i < $scope.pedidoNovo.length; i++){
				if($scope.pedidoNovo[i].ped_confirmado == 'N'){
					//alertPedNovo();
					alertPedNovo_nao_visualizado();
					break;
				}
			}
			timePed_novos_stop();
			
		}

		$scope.timeP = setInterval(ultimaAtualizacao, 6000);
		$scope.pedido_nao_conf = setInterval(alertPedido_nao_visualizado, 6000);

		function timePed_novos_start(){
			$scope.timeP = setInterval(ultimaAtualizacao, 40000);
			$scope.pedido_nao_conf = setInterval(alertPedido_nao_visualizado, 40000);
		}
		function timePed_novos_stop() {
			//console.log('parou');
			clearInterval($scope.timeP);
			clearInterval($scope.pedido_nao_conf);
		}

		

		const startEventStatus = function(){
			if ($scope.statusCheck == true) {
				
				verificaPedidosNovos();
				verificaPedidosPreparo();
				verificaPedidosTransito();
				verificaPedidosEntregue();
				verificaPedidosRetornado();
				verificaPedidosCancelado();
				timePed_novos_start();
				
			}
			else if ($scope.statusCheck == false) {
				timePed_novos_stop();
				
			}
		}
				
		var pedidoDescricaoItensBusca = function(ped_doc){
			$http({
				method:'GET',
				url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&descricaoItens=S&ped_doc='+ped_doc+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
			}).then(function onSuccess(response){
				$scope.pedidoDescricaoItens=response.data.result[0];
				console.log($scope.pedidoDescricaoItens);
			}).catch(function onError(response){
				//$scope.pedidoDescricaoItens=response.data.result[0];
			})
		};

		$scope.mudarStatus = function(){
	    	$http({
	    		method:'POST',
	    		url: $scope.urlBase+ 'abrirEmpresa.php?mudarStatusEmp=S&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&cod_emp=<?=$em_cod?>&token=<?=$token?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto
	    	}).then(function onSuccess(response){
				if (response.data == 0) {
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Empresa não Pode Ser Fechada !, Se O Erro Persistir Entre Em Contato Com Suporte (ERROR: 0001_EMP)";
					chamarAlerta()
				}
				if (response.data == 1) {
					$scope.tipoAlerta = "alert-success";
		    		$scope.alertMsg = "Status Mudado Com Sucesso!";
					chamarAlerta()
				}

				if (response.data == 2) {
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Empresa possuem Pedidos Não Visualizados";
					chamarAlerta()
				}

				statusAbertoFechado();
	    	}).catch(function onError(response){
	    		statusAbertoFechado();
	    	});
	    };
		
	    $scope.pedidoDescricaoBusca = function(ped_id){
			$http({
				method:'GET',
				url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&descricao=S&id='+ped_id+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
			}).then(function onSuccess(response){
				$scope.pedidoDescricao=response.data.result[0];
				pedidoDescricaoItensBusca($scope.pedidoDescricao[0].ped_doc);
			}).catch(function onError(response){
				//$scope.pedidoDescricao=response.data.result[0];
			})
		};

		$scope.confirmarPedido = function(id, doc){
			$http({
				method:'GET',
				url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&confirmarPedido=S&id='+id+ '&ped_doc='+doc+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
			}).then(function onSuccess(response){
				
				if(response.data == 1){
					$scope.tipoAlerta = "alert-success";
		    		$scope.alertMsg = "Pedido "+ doc +" Confirmado";
					chamarAlerta()
					$scope.pedidoDescricaoBusca(id);
				}

				if(response.data == 0){
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Pedido "+ doc +" Não Confirmado";
					chamarAlerta()
				}
				confirmarPedido();
				verificaPedidosNovos();
			}).catch(function onError(response){
				$scope.pedidoDescricao=response.data.result[0];
			})
		}

		$scope.mudarStatusPedido = function(id,status,doc){
			/*console.log(id);
			console.log(status);
			console.log(doc);*/

			if (status == 'Preparando') {
				$("#imprimirCozinha").modal();
			}
			else if(status == 'Transito'){
				$("#imprimirEntrega").modal();
			}

	    	$http({
	    		method:'GET',
	    		url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&mudarStatusPedido=S&id='+id+'&ped_doc='+doc+'&mudarStatus='+status+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
				if(response.data == 1){
					verificaPedidosNovos();
					verificaPedidosPreparo();
					verificaPedidosTransito();
					verificaPedidosEntregue();
					verificaPedidosRetornado();
					verificaPedidosCancelado();
					$scope.pedidoDescricaoBusca(id);

					$scope.tipoAlerta = "alert-success";
		    		$scope.alertMsg = "Status Do Pedido "+ doc +" Alterado Para "+ status;
					chamarAlerta();

					if(status == 'Entregue'){
						$scope.finalizarPedido(id);
						
					}
									
				}

				else if(response.data == 0){
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Status Do Pedido "+ doc +" Não Alterado";
					chamarAlerta()
				}
	    	}).catch(function onError(response){
	    		
	    	});
			
		};
		$scope.ModalCancPedido = function (pedidoDescricao, status){
			$('#motivoCanc').modal('show');
		}

		$scope.mudarStatusPedidoCanc = function(id,status,doc, mtCanc){
			console.log(id + ' - ' + status + ' - ' + doc + ' - ' + mtCanc);

			if(mtCanc == undefined){
				$scope.tipoAlerta = "alert-danger";
				$scope.alertMsg = "Qual motivo do cancelamento";
				chamarAlerta()
			}
			else if(mtCanc == ""){
				$scope.tipoAlerta = "alert-danger";
				$scope.alertMsg = "Qual motivo do cancelamento";
				chamarAlerta()
			}else{

				$http({
				method:'POST',
				data:{
					motivo : mtCanc
				},
				url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&mudarStatusPedido=S&id='+id+'&ped_doc='+doc+'&mudarStatus='+status+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
				}).then(function onSuccess(response){
					if(response.data == 1){
						verificaPedidosNovos();
						verificaPedidosPreparo();
						verificaPedidosTransito();
						verificaPedidosEntregue();
						verificaPedidosRetornado();
						verificaPedidosCancelado();
						$scope.pedidoDescricaoBusca(id);

						$('#motivoCanc').modal('hide');
						$('#mtCanc').val('');
						$scope.tipoAlerta = "alert-success";
						$scope.alertMsg = "Status Do Pedido "+ doc +" Alterado Para "+ status;
						chamarAlerta();

						$scope.finalizarPedido(id);
					}
				}).catch(function onError(response){
	    		
	    		});
			}
		}

		$scope.retornarStatusPedido = function(id,statusAtual,doc){
			/*console.log(id);
			console.log(statusAtual);
			console.log(doc);
*/
			var status;

			if (statusAtual == 'Preparando') {
				status = 'Novo';
			}
			else if (statusAtual == 'Transito') {
				status = 'Preparando';
			}
			else if (statusAtual == 'Entregue') {
				status = 'Transito';
			}
			else if (statusAtual == 'Retornado') {
				status = 'Entregue';
			}
			else if (statusAtual == 'Cancelado') {
				status = 'Novo';
			}

			//console.log(status);
			$http({
	    		method:'GET',
	    		url: $scope.urlBase+ 'pedidos.php?vericaPedidos=S&mudarStatusPedido=S&id='+id+'&ped_doc='+doc+'&mudarStatus='+status+'&us=<?=$us?>&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&nomeEmp=<?=$nomeEmpFanta?>&status='+ $scope.status[0].em_aberto + '&dataAbertura='+$scope.status[0].em_data_abertura
	    	}).then(function onSuccess(response){
				if(response.data == 1){
					verificaPedidosNovos();
					verificaPedidosPreparo();
					verificaPedidosTransito();
					verificaPedidosEntregue();
					verificaPedidosRetornado();
					verificaPedidosCancelado();
					$scope.pedidoDescricaoBusca(id);

					$scope.tipoAlerta = "alert-success";
		    		$scope.alertMsg = "Status Do Pedido "+ doc +" Alterado Para "+ status;
					chamarAlerta()
					
				}

				else if(response.data == 0){
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Status Do Pedido "+ doc +" Não Alterado";
					chamarAlerta()
				}
	    	}).catch(function onError(response){
	    		
	    	});
			


		}
		
		$scope.imprimirCozinha = function(){
			window.open('./pages/printerCozinha.php?cliente='+$scope.pedidoDescricao[0].ped_cliente_nome +'&endCliente='+$scope.pedidoDescricao[0].ped_cliente_end_entrega+'&pedidoTipo='+$scope.pedidoDescricao[0].ped_entregar+'&pedidoN='+$scope.pedidoDescricao[0].ped_doc+'&dataPedido='+$scope.pedidoDescricao[0].ped_emis+'&horaPedido='+$scope.pedidoDescricao[0].ped_hora_entrada+'&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>');
		}

		$scope.imprimirEntrega = function(){
			window.open('./pages/printerEntrega.php?pd_id='+ btoa($scope.pedidoDescricao[0].ped_id) +'&cliente='+$scope.pedidoDescricao[0].ped_cliente_nome +'&endCliente='+$scope.pedidoDescricao[0].ped_cliente_end_entrega+'&pedidoTipo='+$scope.pedidoDescricao[0].ped_entregar+'&pedidoN='+$scope.pedidoDescricao[0].ped_doc+'&dataPedido='+$scope.pedidoDescricao[0].ped_emis+'&horaPedido='+$scope.pedidoDescricao[0].ped_hora_entrada+'&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>');
		}

		$scope.finalizarPedido = function(pedido){
			$http({
				method:'POST',
				<?php
					if ($dados_empresa['em_comunica_sistema'] == 'N') { ?>
					url: $scope.urlBase+'finalizarPdido.php?ComunicaSistema=S&ped_id='+pedido+'&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>'
				<?php	}
				if ($dados_empresa['em_comunica_sistema'] == 'S') {?>
					url: $scope.urlBase+'finalizarPdido.php?ComunicaSistema=S&ped_id='+pedido+'&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>'
				<?php
				}
				?>
				
			}).then(function onSuccess(response){
				
				if (response.data > 0) {
					
					verificaPedidosNovos();
					verificaPedidosPreparo();
					verificaPedidosTransito();
					verificaPedidosEntregue();
					verificaPedidosRetornado();
					verificaPedidosCancelado();
					$scope.pedidoDescricaoBusca(pedido);

					$scope.tipoAlerta = "alert-success";
					$scope.alertMsg = "Pedido "+$scope.pedidoDescricao[0].ped_doc+" Confirmado";
					chamarAlerta()
				}
				else{
					$scope.tipoAlerta = "alert-danger";
					$scope.alertMsg = "Pedido "+$scope.pedidoDescricao[0].ped_doc+" Não Confirmado";
					chamarAlerta()
				}

			}).catch(function onError(response){

			});

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
	})

	function tocar(){

		// Definir playlist
		var playlist = [{
			artist: 'Daft Punk',
			title: 'Technologic',
			mp3: 'songs/technologic.mp3'
		}, {
			artist: 'Daft Punk',
			title: 'Human After All',
			mp3: 'http://soundbible.com/grab.php?id=2154&type=mp3'
		}];
	}
   

	
function em_preparo(){

	$('.em_preparo').animate({
		height: 'toggle'
	});
};

 function em_transito(){
 	$('.em_transito').animate({
 		height: 'toggle'
 	});
 };

 function entregue() {
 	$('.entregue').animate({
 		height: 'toggle'
 	});
 };

  function retornado(){
 	$('.retornado').animate({
 		height: 'toggle'
 	})
 }

 function cancelado(){
 	$('.cancelado').animate({
 		height: 'toggle'
 	})
 }

 function confirmarPedido(){
	 $('.confirmarPedido').toggle("slow");
 }

 function chamarAlerta(){
	$('.alert').toggle("slow");
	setTimeout( function() {
		$('.alert').toggle("slow");
	},3000);
};

    $(document).ready(function () {
		
		

        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });
		
		$('#sidebar, #content').toggleClass('active');
		$('.collapse.in').toggleClass('in');
		$('a[aria-expanded=true]').attr('aria-expanded', 'false');

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});
		
		/*$("#taxaEntrega").keydown(function(){
			$("#taxaEntrega").mask('R$ 9.999.99');
		});*/
		
	});
	
	


var w;

function startWorker(i) {
	//criar o web worker
	
    if(typeof(Worker) !== "undefined") {
        if(typeof(w) == "undefined") {
			
			w = new Worker("./workers/demo_workers.js");
		}
		w.postMessage({'url':i});
        w.onmessage = function(event) {
            document.getElementById("result").innerHTML = event.data;
        };
    } else {
        document.getElementById("result").innerHTML = "Você não possui suporte ao Web Worker.";
	}
	
}

function stopWorker() {
    //finalizando e resetando o web worker
    w.terminate();
    w = undefined;
}

const stopButton4 = document.querySelector('#stopButton4');

let context,
	oscillator,
  contextGain,
  x = 1,
  type = '';

function start(){
	context = new AudioContext();
	oscillator = context.createOscillator();
  contextGain = context.createGain();
  
  oscillator.type = type;
  oscillator.connect(contextGain);
	contextGain.connect(context.destination);
	oscillator.start(0);
}

function stop(){
  start();
  contextGain.gain.exponentialRampToValueAtTime(
  	0.00001, context.currentTime + x
	)
}


function alertPedNovo(){
	type = 'sawtooth';
  stop();
};

function alertPedNovo_nao_visualizado(){
	//$("#notificacao").play();

	var audio = new Audio('bib.mp3');
	audio.play();
	
};

</script>

</body>
</html>