<div class="modal fade" id="InfoCliente" tabindex="-1" role="dialog" aria-labelledby="InfoCliente" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" style="max-width: 1040px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">

                        <div class="form-group" style="max-height: 400px; overflow-y: auto; color: #000;">
                            <div class="form-group col-auto mr-3 align-self-center">
                                <p>Dados Pessoais</p>
                                <div class="form-row">
                                    <div class="form-group col-2">
                                        <label >Código</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_cod" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                    <div class="form-group col-7">
                                        <label for="">Nome</label>
                                        <input type="text" class="form-control form-control-sm capoTexto" ng-value="infoCliente[0].pe_nome" id="pd_desc" ng-disabled="true" ng-disabled="campo">
                                    </div>
                                    <div class="form-group col-3">
                                        <label >Celular</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_celular" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                </div>

                                <hr>
                                <p>Endereço Residencial</p>
                                
                                <div class="form-row" style="margin-top:-10px;">
                                    <div class="form-group col-3">
                                        <label >CEP</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_cep" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-7">
                                        <label for="">Endereço</label>
                                        <input type="text" class="form-control form-control-sm capoTexto" ng-value="infoCliente[0].pe_endereco" ng-disabled="true" id="pd_desc" required ng-disabled="campo">
                                    </div>

                                    <div class="form-group col-2">
                                        <label >Numero</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_end_num" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-5">
                                        <label >Bairro</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_bairro" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-5">
                                        <label >Cidade</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_cidade" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-2">
                                        <label >UF</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_uf" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label >Complemento</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_end_comp" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                </div>

                                <hr>
                                <p>Endereço Comercial</p>
                                
                                <div class="form-row" style="margin-top:-10px;">
                                    <div class="form-group col-3">
                                        <label >CEP</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_cep_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-7">
                                        <label for="">Endereço</label>
                                        <input type="text" class="form-control form-control-sm capoTexto" ng-value="infoCliente[0].pe_endtrab" ng-disabled="true" id="pd_desc" required ng-disabled="campo">
                                    </div>

                                    <div class="form-group col-2">
                                        <label >Numero</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_end_num_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-5">
                                        <label >Bairro</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_bairro_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-5">
                                        <label >Cidade</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_end_cid_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>

                                    <div class="form-group col-2">
                                        <label >UF</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_uf_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label >Complemento</label>
                                        <input type="text" class="form-control form-control-sm" id="pd_cod" ng-value="infoCliente[0].pe_end_comp_trab" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-6" style="color:#000">
                        <span>Total de pedidos realizados {{infoCliente[1].Totalpedidos}}</span>
                        <div class="table-responsive p-0 mb-0" style="max-height:200px; overflow-y:auto;">
                            <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                                <thead class="thead-dark">
                                    <tr style="font-size: 1em !important;">
                                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('pe_cod')">Código</th>
                                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Empresa</th>
                                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Emissão</th>
                                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('em_fanta')">Finalizado</th>

                                    </tr>
                                </thead>
                                <tbody style="line-height: 2em;">
                                   
                                    <tr ng-repeat="pedido in infoCliente[1].pedidos" ng-click="pedidoDescricaoItensBusca(pedido)">
                                        <td style="font-weight: normal; text-align: left;" >{{pedido.ped_doc}}</td>
                                        <td style="font-weight: normal; text-align: left;" >{{pedido.em_fanta}}</td>
                                        <td style="font-weight: normal; text-align: left;" >{{pedido.ped_hora_entrada}}</td>
                                        <td style="font-weight: normal; text-align: left;" >{{pedido.ped_hora_entrega}}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        
                        <hr>
                        
                        <div ng-if="detalheItens == true" style="max-height:200px; overflow-y: auto;">
                        
                            <div layout="row" layout-align="space-between center" style="margin-top: -5px padding-left:15px; padding-right:15px;">
                                
                                <div layout="column" layout-align="center start">
										
                                    <div layout="row" layout-align="start center">
                                        <div style="margin-left: 10px;">Doc. <b>{{ped.ped_doc | numberFixedLen:4}}</b></div>
                                    </div>
                                    
                                    <div layout="column" layout-align="start start" style="margin-top: 10px;">
                                        <b style="margin-left: 10px;">Endereço de Entrega</b>
                                        <div style="margin-left: 10px;"><span>{{ped.ped_cliente_fone}}</span></div>
                                        <div style="margin-left: 10px;"><span>{{ped.ped_cliente_end_entrega}}, {{ped.ped_cliente_end_num_entrega}}</span></div>
                                        <div style="margin-left: 10px;"><span>{{ped.ped_cliente_bairro_entrega}}, {{ped.ped_cliente_cid_entrega}}</span></div>
                                        <div style="margin-left: 10px;"><span ng-if="pedi.ped_cliente_compl_entrega != ''">Referência: </span><span> {{ped.ped_cliente_compl_entrega}}</span></div>
                                    </div>
                                
                                </div>


                                <div layout="column" layout-align="end end" style="margin-top: 10px;">
                                    
                                        <div layout="row" layout-align="start center">
											<div style="text-align:left; width:90px;"> SUBTOTAL</div>
											<div style="">{{ped.ped_valor | currency : 'R$ '}}</div>
										</div>

										<div layout="row" layout-align="start center" ng-if="pedidoDescricao[0].ped_val_entrega != '0.00' || pedidoDescricao[0].ped_val_entrega != null">
											<div style="text-align:left; width:152px;">TAXA DE ENTREGA </div>
											<div style="">{{ped.ped_val_entrega | currency : 'R$ '}} </div>
										</div>

										<div layout="row" layout-align="start center">
											<div style="text-align:left; width:100px;">DESCONTO </div>
											<div ng-if="ped.ped_val_desc != null">{{ped.ped_val_desc | currency : 'R$ '}} </div>
											<div ng-if="ped.ped_val_desc == null"> - </div>
										</div>
										
										<div layout="row" layout-align="start center">

											<div style="text-align:left; width:65px;"> TOTAL </div> 
											<div style="">{{ped.ped_total | currency : 'R$ '}}</div>
										
										</div>

										<div layout="row" layout-align="start center" ng-if="ped.ped_troco_para != '0.00'">

											<div style="text-align:left; width:100px;;"> Troco Para </div> 
											<div style="">{{ped.ped_troco_para | currency : 'R$ '}}</div>
										
										</div>
                                </div>

                            </div>

                            <div layout="column" layout-align="start start" style="margin-top: 30px; margin-left: 10px; padding-left:15px; padding-right:15px;">
                                <b>Observações</b>
                                <div>{{ped.ped_obs}}</div>
                                <div ng-if="ped.ped_pago == 'S'">Pagamento Online.</div>
                            </div>

                            <md-divider style="margin-top:10px;"></md-divider>

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
                                            <td class="linhaTable" style="text-align: right;">{{itens.pdi_total | currency : 'R$ '}}</td>
                                        
                                        </tr>

                                    </tbody>

                                </table>
                        
                        </div>

                    </div>  

                </div>
               

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
               
            </div>
        </div>
    </div>
</div>