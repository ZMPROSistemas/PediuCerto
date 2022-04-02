<style>

.contasCliente{
    overflow: auto;
    max-height: 200px;
}

input{ 
    text-align: right;
}


</style>
    <div class="modal fade bd-example-modal-xl" id="baixarContaReceber" tabindex="-1" role="dialog" aria-labelledby="ModalLancarDespesas" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="color: black;">
            <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
                <div class="modal-header">
                    <h3 class="mb-0 pb-0" style="color: black !important;" >Detalhamento de Conta Recebida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                        {{alertMsg}}
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row " style="font-size: 0.9em !important">
	    				<div class="col-12 p-0 m-0">
                            <div class="form-group row mb-2">
                                <label class="col-1 col-form-label px-0">Cliente</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm text-left" id="nomeCliente" ng-model="nomeCliente" value="" autocomplete="off" placeholder="Digite o Nome do Cliente">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-1 col-form-label px-0">Pagto</label>
                                <div class="col">
                                    <input type="date" class="form-control form-control-sm text-center" id="dataPagto" ng-model="dataPagto" value="{{dataPagto}}" onKeyUp="tabenter(event,getElementById('caixa'))" >
                                </div>
                                <label class="col-flex col-form-label">Caixa</label>
                                <div class="col"> 
                                    <select class="form-control form-control-sm" name="caixa" id="caixa" ng-model="caixa">
                                        <option ng-repeat="caixa in caixas" value="{{caixa.bc_codigo}}" ng-if="caixa.bc_situacao == 'Aberto'">{{caixa.bc_descricao}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-1 col-form-label px-0">Juros</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm" id="totalJuros" ng-model="totalJuros" value="" ng-blur="validarJuros()" autocomplete="off" onKeyUp="tabenter(event,getElementById('descto'))"  money-dir>
                                </div>
                               <label class="col-flex col-form-label">Desc</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm" id="descto" ng-model="descto" value="" ng-blur="validarDescto()" autocomplete="off" onKeyUp="tabenter(event,getElementById('Dinheiro'))"  money-dir>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-2">
                                <label class="col-2 col-form-label px-0">Total Selec</label>
                                <div class="col-4 pr-2">
                                    <input type="text" class="form-control form-control-sm" id="totalParcela" ng-model="totalParcela" ng-value="totalParcela | currency :'R$ '" ng-disabled="true">
                                </div>
                                <label class="col-2 col-form-label pl-2 pr-0">Total A Pagar</label>
                                <div class="col-4">
                                    <input type="text" class="form-control form-control-sm" id="totalAPagar" ng-model="totalAPagar" ng-value="totalAPagar | currency: 'R$ '" ng-disabled="true">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-2 col-form-label px-0" style="color: white;">T</label>
                                <div class="col-4 pr-2">
                                    <input type="hidden" class="form-control form-control-sm" >
                                </div>
                                <label class="col-2 col-form-label pl-2 pr-0">Saldo Dev</label>
                                <div class="col-4">
                                    <input type="text" class="form-control form-control-sm" id="saldoDevedor" ng-model="saldoDevedor" ng-value="saldoDevedor | currency: 'R$ '" ng-disabled="true">
                                </div>
                            </div>

                        </div>
 
                        <div class="col-4 p-0 m-0">
                            <div class="form-group row mb-2">
                                <label class="col-4 col-form-label px-0 text-right">Dinheiro</label>
                                <div class="col-8 pr-0">
                                    <!--input type="text" class="form-control form-control-sm" id="totalDinheiro" ng-model="totalDinheiro" value="" onkeypress="return moeda(this,'.','.',event)" autocomplete="off"-->
                                    <input type="text" class="form-control form-control-sm" id="Dinheiro" ng-model="Dinheiro" value="" autocomplete="off" ng-blur="validarDinheiro()" onKeyUp="tabenter(event,getElementById('Cartao'))"  money-dir>
                                </div>
                                <div ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxDinheiro" ng-model="lancarCxDinheiro" ng-value="lancarCxDinheiro" ng-checked="lancarCxDinheiro" money-dir>
                                    <label class="form-check-label">Lançar no Caixa/Banco</label>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-4 col-form-label px-0 text-right">Cartão</label>
                                <div class="col-8 pr-0">
                                    <input type="text" class="form-control form-control-sm" id="Cartao" ng-model="Cartao" value="" ng-blur="validarCartao()" autocomplete="off" onKeyUp="tabenter(event,getElementById('Cheque'))" money-dir>
                                </div>
                                <div ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxCartao" ng-model="lancarCxCartao" ng-value="lancarCxCartao" ng-checked="lancarCxCartao">
                                    <label class="form-check-label">Lançar no Caixa/Banco</label>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-4 col-form-label px-0 text-right">Cheque</label>
                                <div class="col-8 pr-0">
                                    <input type="text" class="form-control form-control-sm" id="Cheque" ng-model="Cheque" value="" ng-blur="validarCheque()" autocomplete="off" onKeyUp="tabenter(event,getElementById('btnBxContas'))"  money-dir>
                                </div>
                                <div ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxCheque" ng-model="lancarCxCheque" ng-value="lancarCxCheque" ng-checked="lancarCxCheque">
                                    <label class="form-check-label">Lançar no Caixa/Banco</label>
                                </div>
                            </div>
                    
                            <div class="form-group row mb-2">
                                <label class="col-4 col-form-label px-0 text-right">Total Pago</label>
                                <div class="col col-8 pr-0">
                                    <input type="text" class="form-control form-control-sm" id="totalPago" ng-model="totalPago" ng-value="totalPago | currency: 'R$ '" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-4 col-form-label px-0 text-right">Troco</label>
                                <div class="col-8 pr-0">
                                    <input type="text" class="form-control form-control-sm" id="troco" ng-model="troco" ng-value="troco | currency: 'R$ '" disabled>
                                </div>
                                <!--input type="hidden" class="form-control form-control-sm" id="totalPagar" ng-model="totalPagar" ng-value="totalPagar | currency: 'R$ '" disabled-->
                            </div>
                        </div>
                    </div>

                    <span class="row py-0 my-0">Contas a Receber deste Cliente</span>
                    <div class="table-responsive col-12 p-0" style="overflow: auto; max-height: 260px">
                        <table class="table table-striped table-sm col-12" style="background-color: #FFFFFFFF; color: black; ">
                            <thead class="thead-dark">
                                <tr style="font-size: 1em !important;">
                                    <th scope="col" style=" font-weight: normal; text-align: center;">Sel</th>
                                    <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_docto')">Docto.</th>
                                    <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parcela</th>
                                    <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_vencto')">Vencto</th>
                                    <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Valor</th>
                                    <th scope="col" style=" font-weight: normal; text-align: right;">Juros</th>
                                    <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Saldo</th>
                                    <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_tipdoc_sigla')">Tipo Docto</th>
                                    <th scope="col" style=" font-weight: normal; text-align: left;">Loc. Cobrança</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="contasCliente in contasCliente | orderBy:'sortKey'" ng-class="contasCliente.ct_vencto < dataPagto ? 'venc' : contasCliente.ct_vencto == dataPagto ? 'vencH':''">
                                    <td align="center">
                                        <input type="checkbox" id="selectConta" ng-model="selectConta" ng-change="selectContas(contasCliente,selectConta)">
                                    </td>
                                    <td align="left" ng-bind="contasCliente.ct_docto"></td>
                                    <td align="center" ng-bind="contasCliente.ct_parc"></td>
                                    <td align="right" ng-bind="contasCliente.ct_vencto | date : 'dd/MM/yyyy'"></td> 
                                    <td align="right" >{{contasCliente.ct_valor | currency :'R$ '}}</td> 
                                    <td align="right" ng-bind="">0.00</td> 
                                    <td align="right" >{{contasCliente.ct_valor | currency :'R$ '}}</td> 
                                    <td align="center" ng-bind="contasCliente.dc_sigla"></td> 
                                    <td align="left" ng-bind="contasCliente.em_fanta | limitTo:20" class="d-inline-block text-truncate"></td> 
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="LimparBaixa()">Cancelar</button>
				    <button type="button" class="btn btn-primary" ng-if="totalParcela > '0' && totalPago > '0'" id="btnBxContas" ng-click="enviarBaixarContaReceber(Dinheiro, Cartao, Cheque,lancarCxDinheiro,lancarCxCartao,lancarCxCheque,dataPagto  | date: 'yyyy-MM-dd',caixa,totalJuros,descto)">Baixar Contas</button>
                </div>
            
            </div>
        </div>
    </div>
