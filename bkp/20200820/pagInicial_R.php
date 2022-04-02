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

	<div class="noPrint">
		<md-content class="md-padding">
			<div layout="row" layout-align="space-between center" style="position: absolute; right: 0; margin-right: 40px; top: 6px;">

				<div>
					<md-switch md-invert ng-model="statusCheck" ng-change="mudarStatus()">
					  <span>{{status[0].em_aberto}}</span>
					</md-switch>
				</div>

				<div style="width: 120px;">
					<span ng-show="status[0].em_aberto == 'Aberto'" style="margin-top:4px; margin-left: 40px;">Às: {{status[0].em_hora_abertura}}</span>
				</div>



			</div>

			<md-tabs md-selected="selectedIndex" md-border-bottom md-autoselect md-swipe-content md-left-tabs>
				 <md-tab label="Pedidos">

				 	<div layout="row">

				 		<div flex="">
				 			<div class="input-group col-12 pt-2">
								<input type="text" class="form-control form-control-sm" id="buscaRapida" ng-model="buscaRapida" placeholder="Pesquisa Rápida">
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
				 									 <span class="badge badge-light" style="margin-top: -15px; margin-left: 20px;">{{totalNovo}}</span>
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
				 									<span class="badge badge-light">{{totalPreparo}}</span>
				 								</div>

				 							</div>

				 						</form>
				 					</div>


				 					<div style="">
				 						<button class="btn" style="background-color: transparent; border: none" onclick=" em_preparo();">
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
				 									<span class="badge badge-light">{{totalTransito}}</span>
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
				 									<span class="badge badge-light">{{totalEntregue}}</span>
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

											<td  ng-if="pedido.ped_finalizado == 'S'">
												<span ng-if="pedido.ped_entregar == 'N'" class="badge badge-light" style="background-color:rgba(0, 143, 24,0.5); color:#fff;">Finalizado</span>
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
				 									<span class="badge badge-light">{{totalRetornado}}</span>
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
				 									<span class="badge badge-light">{{totalCancelado}}</span>
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
												<i ng-if="pedido.ped_pago =='S'" class="fas fa-dollar-sign" style="color:rgb(0,104,28)"></i>
											</td>

										</tr>

					 				</tbody>

					 			</table>
				 			</div>

				 		</div>

	  					<div flex="">

							<div class="row justify-content-center confirmarPedido" style="height: 100px; margin-left: 15px; margin-top: 50px; position:absolute" ng-if="pedidoDescricao[0].ped_confirmado == 'N'">
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


								<div layout="row" layout-align="space-between center">

									<div layout="column" layout-align="center start">
										
										<div layout="row" layout-align="start center" style="margin-top: 30px;">
											<div style="margin-left: 10px;"><b>{{pedidoDescricao[0].ped_doc | numberFixedLen:4}}</b></div>
											<div style="margin-left:15px;"><span>{{pedidoDescricao[0].ped_cliente_nome}}</span></div>
										</div>
										
										<div layout="column" layout-align="start start" style="margin-top: 10px;">
											<div style="margin-left: 10px;"><span>{{pedidoDescricao[0].ped_cliente_fone}}</span></div>
											<div style="margin-left: 10px;"><span>{{pedidoDescricao[0].ped_cliente_end_entrega}}, {{pedidoDescricao[0].ped_cliente_end_num}}</span></div>
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

								<div layout="column" layout-align="start start" style="margin-top: 30px; margin-left: 10px;">
									<b>Observações</b>
									<div>{{pedidoDescricao[0].ped_obs}}</div>
									<div ng-if="pedidoDescricao[0].ped_pago == 'S'">Pagamento Online.</div>
								</div>
								
								

								<div layout="row" layout-align="end center" style="margin-top: 30px;">

									<div ng-init="mudarStatusPed = pedidoDescricao[0].ped_status">

									<label>Status:</label>

										<select class="form-control form-control-sm" id="empresa" ng-model="mudarStatusPed" value="" ng-change="mudarStatusPedido(pedidoDescricao[0].ped_id, mudarStatusPed,edidoDescricao[0].ped_doc)" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'">
											<option value="Novo" ng-if="pedidoDescricao[0].ped_status == 'Novo'">Novo</option>
											<option value="Preparando" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando'">Preparando</option>
											<option value="Transito" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando' || pedidoDescricao[0].ped_status == 'Transito'">Em Transito</option>
											<option value="Entregue" ng-if="pedidoDescricao[0].ped_status == 'Novo' || pedidoDescricao[0].ped_status == 'Preparando' || pedidoDescricao[0].ped_status == 'Transito'">Entregue</option>
											<option value="Retornado">Retornado</option>
											<option value="Cancelado">Cancelado</option>
										</select>
 
									</div>
									<div style="margin-top:25px;">
										<md-button class="md-raised md-primary" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'" ng-click="imprimirCozinha()" ng-if="pedidoDescricao[0].ped_status != 'Entregue'">Imprimir Via Cozinha</md-button>
										<md-button class="md-raised md-confirm" ng-disabled="pedidoDescricao[0].ped_confirmado == 'N'" ng-click="finalizarPedido(pedidoDescricao)" ng-if="pedidoDescricao[0].ped_status == 'Entregue'">Finalizar Pedido</md-button>
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
												
												<td  class="linhaTable" ng-bind="itens.pdi_quantidade | number" style="text-align: center;"></td>
												<td  class="linhaTable" ng-bind="itens.pdi_descricao"></td>
												<td class="linhaTable"  ng-bind="itens.pdi_total" style="text-align: right;"></td>
											
											</tr>

										</tbody>
									
								</table>
							</div>
							
	  					</div>
				 	</div>
				 </md-tab>


				 <md-tab label="Dashboard">

				 </md-tab>


			</md-tabs>

		</md-content>


	</div>

	<div class="printCozinha print">

	</div>

	<div id="printEntrega print">

	</div>
</div>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

	<script src="js/angular-match-media.js"></script>
	<script src="js/angular-material.min.js"></script>
	<script src="js/angular-aria.min.js"></script>
	<script src="js/material-components-web.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/mCustomScrollbar.concat.min.js"></script>

    <script  id="INLINE_PEN_JS_ID">

		angular.module("ZMPro",['ngMessages','ngMatchMedia','ngMaterial']);
	    angular.module("ZMPro").controller("ZMProCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $mdDialog) {

	    	$scope.pedidosCliente=[];
	    	$scope.status = 'Fechado';
	    	$scope.statusCheck = false;
	    	$scope.statusData = '';
	    	$scope.statusHora = '';

	    	$scope.urlBase = 'services/';
	    	$scope.dataI = dataHoje();
    		$scope.dataF = dataHoje();

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
						alertPedNovo();
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
		//$scope.timeP = setInterval(ultimaAtualizacao, 6000);

		function timePed_novos_start(){
			$scope.timeP = setInterval(ultimaAtualizacao, 40000);
		}
		function timePed_novos_stop() {
			console.log('parou');
			clearInterval($scope.timeP);
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
		    		$scope.alertMsg = "Empresa possuem Pedidos Em Aberto";
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
					
				}

				else if(response.data == 0){
					$scope.tipoAlerta = "alert-danger";
		    		$scope.alertMsg = "Status Do Pedido "+ doc +" Não Alterado";
					chamarAlerta()
				}
	    	}).catch(function onError(response){
	    		
	    	});
		};
		
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
					url: $scope.urlBase+'finalizarPdido.php?ComunicaSistema=S&ped_id='+pedido[0].ped_id+'&empresa_matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>'
				<?php	}
				if ($dados_empresa['em_comunica_sistema'] == 'S') {?>
					url: $scope.urlBase+''	
				<?php
				}
				?>
				
			}).then(function onSuccess(response){
				if (response.data > 0) {
					verificaPedidosEntregue();
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
	});

</script>

<script type="text/javascript">

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

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
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



</script>

</body>
</html>