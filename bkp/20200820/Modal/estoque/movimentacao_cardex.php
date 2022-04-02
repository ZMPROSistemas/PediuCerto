<div class="modal fade" id="movimentacao_cardex" tabindex="-1" role="dialog" aria-labelledby="ModalMovimentacaoCardex" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document" style="color: black;">
        <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
            <div class="modal-header">
                <h4 style="color: black !important;" >Movimentação De Estoque</h4>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button><br>
                
            </div>
            <div class="modal-body">

            <p style="color: #000;">Produto: <b style="font-weight: bold"> {{produto[0].pd_cod}}-{{produto[0].pd_desc}}</b></p>
                <table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
                    <thead class="thead-dark">
                        <tr style="font-size: 1em !important;">
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Empresa</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Data</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Hora</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Histórico</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Est. Ant.</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Quant.</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Est. Atual</th>
                            <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Usuário</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="movEstoqueConsulta in movEstoqueConsulta">
                            <td style="text-align: center">{{movEstoqueConsulta.em_fanta}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_data | date: 'dd/MM/yyyy'}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_hora | date: 'HH:mm'}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_hist}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_estat}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_quant}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.sd_estat}}</td>
                            <td style="text-align: center">{{movEstoqueConsulta.usuario}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    
    </div>
</div>