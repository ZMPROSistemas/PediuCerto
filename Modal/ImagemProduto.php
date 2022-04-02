<div class="modal fade" id="ModalImagem" tabindex="-1" role="dialog" aria-labelledby="ModalImagem" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header py-1">
        <h4 class="modal-title" id="TituloModalCentralizado" style="color: black;">Imagem do Produto</h4>
      </div>
      <div class="modal-body mx-auto py-1">
        <div class="container fluid">
          <div class="row align-items-center">
            <div class="col-8">
              <h6 style="color: black;">Escolha a imagem e faça os ajustes necessários</h6>
            </div>
            <div class="col-4 mb-2">
              <button type="button" class="btn btn-primary" ngf-select ng-model="picFile" accept="image/*">Escolher Imagem</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div ngf-drop ng-model="picFile" ngf-pattern="image/*" class="cropArea">
                <img-crop image="picFile  | ngfDataUrl" area-type="square"
                          result-image="croppedDataUrl" ng-init="croppedDataUrl=''">
                </img-crop>
              </div>
            </div>
          </div>
          <div class="row align-items-center mt-2">
            <div class="col-12">
              <img ng-src="{{croppedDataUrl}}"/>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" ng-click="upload(croppedDataUrl, picFile.name)" data-dismiss="modal">Salvar mudanças</button>
      </div>
    </div>
  </div>
</div>