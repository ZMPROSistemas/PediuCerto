<div class="modal" id="ModalTipoFechamento" tabindex="-1" role="dialog"  aria-hidden="true" aria-labelledby="TextoModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color: red !important; text-align: center;" class="modal-title" id="TextoModal">ATENÇÃO!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <h4 style="color: black !important; text-align: center;" >Manter estoque não contado</h4>
                <p style="color: black !important; text-align: center;" >Escolhendo esta opção, o estoque dos produtos não contados será mantido.</p>
                </b>
                <h4 style="color: black !important; text-align: center;" >Zerar estoque não contado</h4>
                <p style="color: black !important; text-align: center;" >Escolhendo esta opção, o estoque dos produtos não contados será zerado.</p>

            </div>
            <div class="modal-footer align-content-around" >
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="fecharBalancoNaoZerando(balanco)">MANTER ESTOQUE NÃO CONTADO</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="fecharBalancoZerando(balanco)">ZERAR ESTOQUE NÃO CONTADO</button>
            </div>
        </div>
    </div>
</div>
