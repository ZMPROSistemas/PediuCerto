<style>

</style>

<div class="modal fade reciboContasBaixadas" id="reciboContasBaixadas" tabindex="-1" role="dialog" aria-labelledby="reciboContasBaixadas" aria-hidden="true" data-backdrop="static">
    
    <div class="modal-dialog modal-sm" role="document" style="color: black;">
        <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
            <div class="modal-header">
                <!--h4 style="color: black !important;" >Imprimir Recibo</h4-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button><br>

                <div class="alert {{tipoAlerta}} reciboContBaixadas col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                    {{alertMsg}}
                </div>

            </div>
            <div class="modal-body">

                <div layout="row">
                    <div flex="60" style="">Total De Parcelas:</div>
                    <div flex="40" style="text-align: right">{{totalPagar | currency: 'R$'}}</div>
                </div>
                
                <div layout="row">
                    <div flex="60" style="">Total Pago:</div>
                    <div flex="40" style="text-align: right">{{totalPago | currency: 'R$'}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Juros Pago:</div>
                    <div flex="40" style="text-align: right">{{totalJuros}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Desconto:</div>
                    <div flex="40" style="text-align: right">{{descto}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Dinheiro:</div>
                    <div flex="40" style="text-align: right">{{totalDinheiro}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Cartão:</div>
                    <div flex="40" style="text-align: right">{{totalCartao}}</div>
                </div>

                <div layout="row">
                    <div flex="60" style="">Cheque:</div>
                    <div flex="40" style="text-align: right">{{totalCheque}}</div>
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

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                                 
    			<button type="button" class="btn btn-primary" ng-click="imprimirRecibo()">Sim</button>
                
            </div>
        
        </div>
    </div>

</div>
