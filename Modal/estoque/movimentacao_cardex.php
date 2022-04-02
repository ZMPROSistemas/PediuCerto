<div class="modal fade" id="movimentacao_cardex" tabindex="-1" role="dialog" aria-labelledby="ModalMovimentacaoCardex" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="color: black;">
        <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
            <div class="modal-header">
                <h4 style="color: black !important;" >Movimentação de Estoque - Produto <b style="font-weight: bold"> {{produto[0].pd_cod}} - {{produto[0].pd_desc}}</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button><br>
            </div>
            <div class="modal-body py-0">
                <div class="table-responsive p-0 m-0" style="overflow-y: auto; max-height: 360px;">
                    <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
                        <thead class="thead-dark">
                            <tr style="font-size: 0.8em !important;">
                                <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('')">Empresa</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('')">Data</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('')">Hora</th>
                                <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('')">Histórico</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('')">Est. Ant.</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('')">Quant.</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('')">Est. Atual</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Usuário</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="movEstoqueConsulta in movEstoqueConsulta | orderBy:'-sd_id'" style="font-size: 0.8em !important;">
                                <td style="text-align: left">{{movEstoqueConsulta.em_fanta}}</td>
                                <td style="text-align: right">{{movEstoqueConsulta.sd_data | date: 'dd/MM/yyyy'}}</td>
                                <td style="text-align: right">{{movEstoqueConsulta.sd_hora | date: 'HH:mm'}}</td>
                                <td style="text-align: left">{{movEstoqueConsulta.sd_hist}}</td>
                                <td style="text-align: right">{{movEstoqueConsulta.sd_estant | number}}</td>
                                <td style="text-align: right">{{movEstoqueConsulta.sd_quant | number}}</td>
                                <td style="text-align: right">{{movEstoqueConsulta.sd_estat | number}}</td>
                                <td style="text-align: center">{{movEstoqueConsulta.usuario}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    
    </div>
</div>