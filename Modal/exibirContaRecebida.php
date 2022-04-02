<div class="modal fade" id="verContaRecebida" tabindex="-1" role="dialog" aria-labelledby="ModalVerContaRecebida" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="color: black;" >
        <div class="modal-content">
            <div class="modal-header mb-0 pb-0">
                <h3 style="color: black !important;" >Detalhamento de Conta Recebida</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid mb-0 p-0">
                    <form>
                        <div class="form-row align-items-start">
                            <div class="form-group col-2 pt-0">
                                <label class="text-left">Documento</label>
                                <h5 style="color: black !important;">{{contaDoCliente[0].ct_docto}}</h5>
                            </div>

                            <div class="form-group col-10">
                                <label class="text-left">Cliente</label>
                                <h5 style="color: black !important;"> {{contaDoCliente[0].ct_cliente_forn_id}} - {{contaDoCliente[0].ct_nome}}</h5>
                            </div>

                            <div class="form-group col-4" >
                                <label class="text-left">Referente a Empresa</label> 
                                <input type="text" readonly class="form-control" ng-model="contaDoCliente[0].em_fanta">
                            </div>

                            <div class="form-group col-3">
                                <label class="text-left">Vendedor</label>
                                <input type="text" readonly class="form-control" ng-model="contaDoCliente[0].ct_vendedor">
                            </div>

                            <div class="form-group col-3" >
                                <label class="text-left">Tipo Recebimento</label> 
                                <input type="text" readonly class="form-control" ng-model="contaDoCliente[0].ct_tipdoc">
                            </div>

                            <div class="form-group col-2">
                                <label class="text-left">Parcela</label>
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_parc">
                            </div>

                            <div class="form-group col-2">
                                <label class="text-left">Emissão </label> 
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_emissao | date : 'dd/MM/yyyy'">
                            </div>

                            <div class="form-group col-2">
                                <label class="text-left">Vencimento </label> 
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_vencto | date : 'dd/MM/yyyy'">
                            </div>

                            <div class="form-group col-2">
                                <label class="text-left">Pagamento </label> 
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_pagto | date : 'dd/MM/yyyy'">
                            </div>

                            <div class="form-group col-3" >
                                <label class="text-left">Valor Original</label> 
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_valor | currency: 'R$ '">
                            </div>

                            <div class="form-group col-3" >
                                <label class="text-left" data-toggle="tooltip" data-placement="top" title="Informações adicionais no campo Observações">Valor Pago*</label> 
                                <input type="text" readonly class="form-control text-right" ng-model="contaDoCliente[0].ct_valorpago | currency: 'R$ '">
                            </div>

                            <div class="form-group col-12 mb-0">
                                <label class="text-left">Observações</label> 
                                <textarea class="form-control" type="text" rows="7" ng-model="observacao"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer my-1 py-1">
                <button type="button" data-dismiss="modal" class="btn btn-lg btn-secondary">Fechar</button>
                <!--button type="button" class="btn btn-lg btn-primary" ng-click="editarConta()">Editar Conta</button-->
            </div>
        </div>
    </div>
</div>
