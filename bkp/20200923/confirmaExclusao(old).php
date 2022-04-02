<div class="modal fade" id="modalExclusao" tabindex="-1" role="dialog" aria-labelledby="TextoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content">
            <div class="modal-body">
                <h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Tem certeza de que deseja excluir o item {{excluirProd}}?</h5>
            </div>
            <div class="modal-footer my-1 py-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="excluirItem()">Sim, tenho certeza</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmaSair" tabindex="-1" role="dialog" aria-labelledby="TextoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-0 pb-0" style="color: black !important; text-align: center;" >Todas as informações não salvas serão perdidas!</h3>
            </div>
            <div class="modal-body">
                <h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Tem certeza de que deseja cancelar?</h5>
            </div>
            <div class="modal-footer my-1 py-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="LimparTela()">Sim, tenho certeza</button>
            </div>
        </div>
    </div>
</div>