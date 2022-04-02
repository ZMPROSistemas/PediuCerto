<div class="modal fade" id="modalExclusaoCusto" tabindex="-1" role="dialog" aria-labelledby="TextoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content">
            <div class="modal-body">
                <h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Tem certeza de que deseja excluir o item {{custo.cf_nome}}?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="excluirItem(custo.cf_id)">Sim</button>
            </div>
        </div>
    </div>
</div>