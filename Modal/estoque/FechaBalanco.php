<div class="modal fade" id="ModalTemCerteza" tabindex="-1" role="dialog" aria-labelledby="TextoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 style="color: black !important; text-align: center;" class="modal-title" id="TextoModal">Tem certeza de que deseja fechar este balanço {{balanço.ce_id}}?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="tipoFechaBalanco(balanco)">Sim, continuar!</button>
            </div>
        </div>
    </div>
</div>