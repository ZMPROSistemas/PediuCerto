<div class="modal fade" id="editarContaAPagar" tabindex="-1" role="dialog" aria-labelledby="ModalEditarContaPagar" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document" style="color: black;" >
        <div class="modal-content">
            <div class="modal-header mb-0">
                <h3 style="color: black !important;" >Editar Conta a Pagar</h3>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form name="form" id="form" novalidate>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label>Docto</label>
                                <h4 style="color: black !important;"> {{contas[0].ct_docto}} </h4>
                            </div>
                            <div class="form-group col-9">
                                <label>Despesa Referente a Empresa</label>
                                <select class="form-control form-control-sm" ng-model="contas[0].ct_empresa" ng-blur="verificaCampo(contas[0].ct_empresa)">
                                    <option value="">Selecione a Empresa</option>
                                    <option ng-repeat="empresa in dadosEmpresa" ng-value="empresa.em_cod" ng-selected="empresa.em_cod == contas[0].ct_empresa">{{empresa.em_fanta}}</option>
                                </select>
                            </div>
    
                            <div class="form-group col-12">
                                <label>Fornecedor</label>
                                <select class="form-control form-control-sm" ng-model="contas[0].ct_cliente_forn" ng-blur="verificaCampo(contas[0].ct_cliente_forn)">
                                    <option value="">Todos os Fornecedores</option>
                                    <option ng-repeat="dadosCliente in dadosFornecedores | filter:{pe_empresa:<?=base64_decode($empresa)?>}" ng-selected="dadosCliente.pe_cod == contas[0].ct_cliente_forn" ng-value="dadosCliente.pe_cod" >{{dadosCliente.pe_nome}} </option>
                                </select>
                            </div>
 
                            <div class="form-group col-3">
                                <label>Parcela</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="contas[0].ct_parc" ng-blur="verificaCampo(contas[0].ct_parc)" parcela-dir>
                            </div>

                            <div class="form-group col-5">
                                <label>Vencimento</label> 
                                <input type="date" class="form-control form-control-sm text-right" ng-model="contas[0].ct_vencto" value="{{dataVcto}}" id="dataVcto">
                            </div>

                            <div class="form-group col-4" >
                                <label>Valor</label> 
                                <input type="text" class="form-control form-control-sm text-right" ng-model="contas[0].ct_valor" ng-blur="verificaCampo(contas[0].ct_valor)" money-dir>
                            </div>

                            <div class="form-group col-12">
                                <label>Descrição </label> 
                                <input type="text" class="form-control form-control-sm" ng-model="contas[0].ct_obs" style="text-transform: capitalize">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-lg btn-secondary">Fechar</a>
                <button type="button" class="btn btn-lg btn-primary" ng-if="!form.$pristine" ng-click="editarConta()">Editar Despesa</button>
            </div>
        </div>
    </div>
</div>
