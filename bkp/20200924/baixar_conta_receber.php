<style>
.baixarContaReceber .modal-header{
    padding: 0.2rem;
}

.contasCliente{
    overflow: auto;
    height: 200px;
}
</style>
<div class="modal fade baixarContaReceber" id="baixarContaReceber" tabindex="-1" role="dialog" aria-labelledby="ModalLancarDespesas" aria-hidden="true" data-backdrop="static">
    
        <div class="modal-dialog modal-lg" role="document" style="color: black;">

            <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
                <div class="modal-header">
                    <h4 style="color: black !important;" >Baixar Conta Receber</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><br>
                    <div class="alert {{tipoAlerta}} buscaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                        {{alertMsg}}
                    </div>
                </div>

                <div class="modal-body">
                    <div layout="row" layout-xs="column">
                        <div flex="" style="border-right: 1px #b7b4b4ad solid; padding-right: 15PX;">
                            <div layout="row" layout-wrap="">
                                <div flex="30">
                                    <span>Cliente</span>
                                    <input type="text" class="form-control form-control-sm" id="codCliente" ng-model="codCliente" value="" ng-blur="seachClienteByCod(codCliente)" onkeypress="return somenteNumeros(event)" autocomplete="off">
                                </div>
                                <div flex="70">
                                    <span style="color: #fff;">.</span>
                                    <input type="text" class="form-control form-control-sm" id="nomeCliente" ng-model="nomeCliente" value=""  ng-enter="seachClienteByNome(nomeCliente)" autocomplete="off">
                                </div>
                            </div>

                            <div layout="row" layout-wrap="">
                            
                                <div flex="40" style="margin-right:15px;">
                                    <span>Pagto.</span>
                                    <input type="date" class="form-control form-control-sm" id="dataPagto" ng-model="dataPagto" value="{{dataPagto}}">
                                </div>

                                <div flex="55">
                                    <span>Caixa</span>
                                    <select class="form-control form-control-sm" name="caixa" id="caixa" ng-model="caixa">
                                        <option ng-repeat="caixa in caixas" value="{{caixa.bc_codigo}}" ng-if="caixa.bc_situacao == 'Aberto'">{{caixa.bc_descricao}}</option>
                                    </select>
                                </div>

                            </div>
                            
                            <div layout="row" layout-wrap="">
                                <div flex="45" style="margin-right:15px;">
                                    <span>Total Das Parcelas</span>
                                    <input type="text" class="form-control form-control-sm" id="totalParcela" ng-model="totalParcela" ng-value="totalParcela | currency :'R$'" ng-disabled="true">
                                </div>

                                <div flex="45" style="margin-right:15px;">
                                    <span>Saldo Devedor</span>
                                    <input type="text" class="form-control form-control-sm" id="saldoDevedor" ng-model="saldoDevedor" ng-value="saldoDevedor | currency: 'R$'" ng-disabled="true">
                                </div>
                            </div>

                            <div layout="row" layout-wrap="">
                                <div flex="45" style="margin-right:15px;">
                                    <span>Total De Juros</span>
                                    <input type="text" class="form-control form-control-sm" id="totalJuros" ng-model="totalJuros" value="{{totalJuros}}" ng-change="recalcular()" autocomplete="off">
                                </div>

                                <div flex="45" style="margin-right:15px;">
                                    <span>Descto</span>
                                    <input type="text" class="form-control form-control-sm" id="descto" ng-model="descto" ng-value="descto" ng-change="recalcular()" autocomplete="off">
                                </div>
                            </div>

                        </div>
                        
                        <div flex="" style="margin-left:15px;">

                            <div layout="row" layout-wrap="">
                                <div flex="45">
                                    <span>Total a pagar</span>
                                    <input type="text" class="form-control form-control-sm" id="totalPagar" ng-model="totalPagar" ng-value="totalPagar | currency: 'R$'" disabled>
                                </div>

                                <div flex="40" style="margin-left:15px;">
                                    <span>Total Pago</span>
                                    <input type="text" class="form-control form-control-sm" id="totalPago" ng-model="totalPago" ng-value="totalPago | currency: 'R$'" disabled>
                                </div>

                            </div>
                            <div layout="row" layout-wrap="">
                                <div flex="40" style="margin-right:15px;">
                                    <span>Valor Em Dinheiro</span>
                                    <!--input type="text" class="form-control form-control-sm" id="totalDinheiro" ng-model="totalDinheiro" value="" onkeypress="return moeda(this,'.','.',event)" autocomplete="off"-->
                                    <input type="text" class="form-control form-control-sm" id="totalDinheiro" ng-model="totalDinheiro" value="" autocomplete="off">
                                </div>
                                <div flex="45" style="margin-left:15px; margin-top:25px;" ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxDinheiro" ng-model="lancarCxDinheiro" ng-value="lancarCxDinheiro" ng-checked="lancarCxDinheiro">
                                    <label class="form-check-label">Lançar No Caixa/Banco</label>
                                </div>

                            </div>

                            <div layout="row" layout-wrap="">
                                <div flex="40" style="margin-right:15px;">
                                    <span>Valor Em Cartão</span>
                                    <input type="text" class="form-control form-control-sm" id="totalCartao" ng-model="totalCartao" value="" autocomplete="off">
                                </div>
                                <div flex="45" style="margin-left:15px; margin-top:25px;" ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxCartao" ng-model="lancarCxCartao" ng-value="lancarCxCartao" ng-checked="lancarCxCartao">
                                    <label class="form-check-label">Lançar No Caixa/Banco</label>
                                </div>

                            </div>

                            <div layout="row" layout-wrap="">
                                <div flex="40" style="margin-right:15px;">
                                    <span>Valor Em Cheque</span>  
                                    <input type="text" class="form-control form-control-sm" id="totalCheque" ng-model="totalCheque" ng-value="" autocomplete="off" >
                                </div>
                                <div flex="45" style="margin-left:15px; margin-top:25px;" ng-show="false">
                                    <input type="checkbox" class="form-check-input" id="lancarCxCheque" ng-model="lancarCxCheque" ng-value="lancarCxCheque" ng-checked="lancarCxCheque">
                                    <label class="form-check-label">Lançar No Caixa/Banco</label>
                                </div>

                            </div>

                            
                                
                        </div>

                    </div>
                    <hr>

                    <div layout="row" layout-xs="column" class="contasCliente">
                        <table class="table table-striped table-sm" style="background-color: #FFFFFFFF; color: black; margin-top:5px;">
                            <thead class="thead-dark">
                                <tr style="font-size: 1em !important;">
                                    <th scope="col" style="width:10px">Sel.</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_docto')">Docto.</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_parc')">Parcela</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_vencto')">Vencto.</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_valor')">Valor</th>
                                    <th scope="col" style=" font-weight: normal;">Juros</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_valor')">Saldo</th>
                                    <th scope="col" style=" font-weight: normal;" ng-click="ordenar('ct_tipdoc_sigla')">Tip. Docto.</th>
                                    <th scope="col" style=" font-weight: normal;">Loc. Cobrança</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="contasCliente in contasCliente | orderBy:'sortKey'">
                                    <td align="right">
                                        <input type="checkbox" id="selectConta" ng-model="selectConta" ng-change="selectContas(contasCliente,selectConta)">
                                    </td>
                                    <td align="center" ng-bind="contasCliente.ct_docto"></td>
                                    <td ng-bind="contasCliente.ct_parc"></td>
                                    <td ng-bind="contasCliente.ct_vencto | date : 'dd/MM/yyyy'"></td> 
                                    <td ng-bind="contasCliente.ct_valor | currency :'R$'"></td> 
                                    <td ng-bind="">0.00</td> 
                                    <td ng-bind="contasCliente.ct_valor | currency :'R$'"></td> 
                                    <td align="center" ng-bind="contasCliente.ct_tipdoc_sigla"></td> 
                                    <td></td> 

                                </tr>
                            
                            </tbody>
                        
                        </table>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				    <button type="button" class="btn btn-primary" ng-click="enviarBaixarContaReceber(totalDinheiro,totalCartao,totalCheque,lancarCxDinheiro,lancarCxCartao,lancarCxCheque,dataPagto  | date: 'yyyy-MM-dd',caixa,totalJuros,descto)">Baixar Contas</button>
                </div>
            
            </div>

        </div>
    
   
</div>
