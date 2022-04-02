<style>

#corpoModal.input{ 
    
    text-align: right;

}

</style>

<div class="modal fade reciboContasBaixadas" id="reciboContasBaixadas" tabindex="-1" role="dialog" aria-labelledby="reciboContasBaixadas" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-centered modal" role="document" style="color: black;">
        <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
            <div class="modal-header">
                <h3 class="mb-0 pb-0" style="color: black !important;">Recibo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="alert {{tipoAlerta}} reciboContBaixadas col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>
            </div>
            <div class="modal-body" id="corpoModal">
                <form>
                    <div class="form-group row">
                        <label class="col-6 col-form-label px-0" style="font-size: 1.1em !important; font-weight:bold;">Valor das Parcelas</label>
                        <div class="col-6">
                            <input type="text" style="font-size: 1.1em !important; font-weight:bold;" class="form-control form-control-sm" id="totalParcela" ng-model="totalParcela | currency: 'R$ '" value="" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-6 col-form-label px-0">Juros Cobrados</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm" id="totalJuros" ng-model="totalJuros | currency: 'R$ '" value="" readonly>
                        </div>
                        <label class="col-6 col-form-label px-0">Descontos Concedidos</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm" id="descto" ng-model="descto | currency: 'R$ '" value="" readonly>
                        </div>
                        <label class="col-6 col-form-label px-0" style="font-size: 1.1em !important; font-weight:bold;">Total a Pagar</label>
                        <div class="col-6">
                            <input type="text" style="font-size: 1.1em !important; font-weight:bold;" class="form-control form-control-sm" id="totalAPagar" ng-model="totalAPagar | currency: 'R$ '" value="" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-6 col-form-label px-0">Recebimento em Dinheiro</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm" id="Dinheiro" ng-model="Dinheiro | currency: 'R$ '" value="" readonly>
                        </div>
                        <label class="col-6 col-form-label px-0">Recebimento em Cartao</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm" id="Dinheiro" ng-model="Cartao | currency: 'R$ '" value="" readonly>
                        </div>
                        <label class="col-6 col-form-label px-0">Recebimento em Cheque</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm" id="Dinheiro" ng-model="Cheque | currency: 'R$ '" value="" readonly>
                        </div>
                        <label class="col-6 col-form-label px-0" style="font-size: 1.1em !important; font-weight:bold;">Total Recebido</label>
                        <div class="col-6">
                            <input type="text" style="font-size: 1.1em !important; font-weight:bold;" class="form-control form-control-sm" id="totalPago" ng-model="totalPago | currency: 'R$ '" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row" ng-if="troco > 0" style="font-size: 1.1em !important; font-weight:bold;">
                        <hr>
                        <label class="col-6 col-form-label px-0">Troco</label>
                        <div class="col-6">
                            <input type="text" style="font-size: 1.1em !important; font-weight:bold;" class="form-control form-control-sm" id="troco" ng-model="troco | currency: 'R$ '" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row" ng-if="troco < 0" style="font-size: 1.1em !important; font-weight:bold; color:red;">
                        <hr>
                        <label class="col-6 col-form-label px-0">Saldo Devedor</label>
                        <div class="col-6">
                            <input type="text" style="font-size: 1.1em !important; font-weight:bold; color:red;" class="form-control form-control-sm" id="saldoDevedor" ng-model="saldoDevedor | currency: 'R$ '" value="" readonly>
                        </div>
                        <hr>
                    </div>
                </form>
               
                <!--div layout="row">
                    <div flex="60" style="">Total Pago:</div>
                    <div flex="40" style="text-align: right">{{totalPago | currency: 'R$'}}</div>
                </!--div>

                <div layout="row">
                    <div flex="60" style="">Juros Pago:</div>
                    <div flex="40" style="text-align: right">{{totalJuros | currency: 'R$'}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Desconto:</div>
                    <div flex="40" style="text-align: right">{{descto | currency: 'R$'}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Dinheiro:</div>
                    <div flex="40" style="text-align: right">{{totalDinheiro | currency: 'R$'}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Cartão:</div>
                    <div flex="40" style="text-align: right">{{totalCartao | currency: 'R$'}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Cheque:</div>
                    <div flex="40" style="text-align: right">{{totalCheque | currency: 'R$'}}</div>
                </div>
                <hr>
               
                <div layout="row" ng-if="troco >= 0">
                    <div flex="60" style="">Total Troco</div>
                    <div flex="40" style="text-align: right">{{troco | currency: 'R$'}}</div>
                </div>

                <div layout="row" ng-if="troco < 0">
                    <div flex="60" style="">Saldo Devedor</div>
                    <div flex="40" style="text-align: right">{{troco | currency: 'R$'}}</div>
                </div>
                <hr-->
                
            </div>
            <!-- Div de Impressão -->
            <div ng-show="false">

                <div id="reciboContaReceber">
                    <div style="text-align:center; margin-bottom:10px;"><b>RECIBO</b></div>
                    <hr>
                    <div style="text-align: center;"><b>{{dadosEmpresa.em_fanta}}</b></div>
                    <div style="text-align: center;"><b>{{dadosEmpresa.em_end}}, {{dadosEmpresa.em_end_num}}</b></div>
                    <div style="text-align: center;"><b>{{dadosEmpresa.em_fone}} {{dadosEmpresa.em_cid}} - {{dadosEmpresa.em_uf}}</b></div>
                    <hr>
                    <div style="text-align: left;">Recebi(emos) de: <b>{{nomeCliente}}</b></div>
                    <div style="text-align: left;">Código do Cliente: <b>{{codCliente}}</b></div>
                    <div style="text-align: left;">Valor: <b>{{totalPago | currency: 'R$ '}} {{valorPorExtenso}}</b></div>
                    <div style="text-align: left;">Referente a(s) seguinte(s) parcela(s):</div>
                
                    <table style="margin-top:15px; width:100%;">
                        <thead class="thead-dark" border="1">
                            <tr style="font-size: 0.9em !important;">
                                <th scope="col" style="text-align: left;">Docto</th>
                                <th scope="col" style="text-align: center;">Parcela</th>
                                <th scope="col" style="text-align: center;">Vencto</th>
                                <th scope="col" style="text-align: right;">Valor</th>
                                <th scope="col" style="text-align: center;">Pagto</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.7em">
                            <tr ng-repeat="conta in contasReceberSelect">
                                <td style="text-align: left;">{{conta.ct_docto}}</td>
                                <td style="text-align: center;">{{conta.ct_parc}}</td>
                                <td style="text-align: center;">{{conta.ct_vencto | date: 'dd/MM/yyyy'}}</td>
                                <td style="text-align: right;">{{conta.ct_valor | currency: ' '}}</td>
                                <td style="text-align: center;">{{conta.ct_pagto | date: 'dd/MM/yyyy'}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="margin-top:15px; margin-right:10px;" align="right">
                        <tbody style="font-size: 0.7em">

                            <tr>
                                <td style="width:100px;">Valor Principal: </td>
                                <td style="text-align: right;"><b>{{totalParcela | currency: 'R$ '}}</b></td>
                            </tr>

                            <tr>
                                <td>Desconto: </td>
                                <td style="text-align: right;">(-) {{descto | currency: ' '}}</td>
                            </tr>

                            <tr>
                            <td>Juros: </td>
                                <td style="text-align: right;">{{totalJuros | currency: ' '}}</td>
                            </tr>

                            <tr>
                                <td>Subtotal: </td>
                                <td style="text-align: right;"><b>{{totalAPagar | currency: 'R$ '}}</b></td>
                            </tr>

                            <tr>
                                <td>Dinheiro: </td>
                                <td style="text-align: right;">{{Dinheiro | currency: ' '}}</td>
                            </tr>

                            <tr>
                                <td>Cartão: </td>
                                <td style="text-align: right;">{{Cartao | currency: ' '}}</td>
                            </tr>

                            <tr>
                                <td>Cheque: </td>
                                <td style="text-align: right;">{{Cheque | currency: ' '}}</td>
                            </tr>

                            <tr>
                                <td><b>Total Pago: </b></td>
                                <td style="text-align: right;"><b>{{totalPago | currency: 'R$ '}}</b></td>
                            </tr>


                            <tr ng-if="saldoDevedor > 0">
                                <td>Saldo Devedor: </td>
                                <td style="text-align: right;"><b>{{saldoDevedor | currency: 'R$ '}}</b></td>
                            </tr>

                            <tr ng-if="troco > 0">
                                <td>Troco: </td>
                                <td style="text-align: right;"><b>{{troco | currency: 'R$ '}}</b></td>
                            </tr>

                        </tbody>
                    </table>
                    <br>
                    <hr>
                    <div style="text-align: center; margin-top: 200px;">Para maior clareza, firmo o presente. </div>
                    <div style="text-align: center;">{{dadosEmpresa.em_cid}}</div>

                    <p></p>

                    <div style="text-align: center; margin-top: 30px;">_______________________________</div>
                    <div style="text-align: center;"><b>{{dadosEmpresa.em_razao}}</b></div>
                </div>

            </div>

            <div class="modal-footer">
                <h5 class="pull-left" style="color: black !important;" >Deseja imprimir?</h5>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="LimparBaixa()">Não</button>
                <button type="button" class="btn btn-primary" ng-click="imprimirRecibo()">Sim</button>
            </div> 
        </div>
    </div>
</div>
