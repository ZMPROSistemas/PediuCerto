<div class="modal fade" id="motivoCanc" tabindex="-1" role="dialog" aria-labelledby="motivoCanc{{pedidoDescricao[0].ped_id}}" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black !important;">Cancelar ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Motivo do cancelamento?</label>
                <textarea class="form-control" name="" id="mtCanc" cols="30" rows="5" ng-model="mtCanc">{{mtCanc}}</textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" ng-click="mudarStatusPedidoCanc(pedidoDescricao[0].ped_id, 'Cancelado', pedidoDescricao[0].ped_doc, mtCanc)">Cancelar Pedido</button>                
            </div>
        </div>
    </div>
</div>