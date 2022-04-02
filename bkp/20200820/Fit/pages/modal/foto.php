
    <!--Foto-->

    <div class="modal fade" id="camera" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Camêra</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
          </div>
          <div class="modal-body">

            <video autoplay="true" id="webCamera">
            </video>

            <textarea  type="text" id="base_img" name="base_img"></textarea>

            <!--<button type="button" class="btn btn-primary" onclick="takeSnapShot()"><i class="fa fa-camera"></i> Tirar foto e salvar</button>-->


          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal" onclick="takeSnapShot()"><i class="fa fa-camera"></i>Tirar foto e salvar</button>
            <!--<button class="btn btn-primary"> SIM</button>-->

          </div>
        </div>
      </div>
    </div>


