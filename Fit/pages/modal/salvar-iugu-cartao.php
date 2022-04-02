 <div class="modal fade" id="salvar-cartao-iugu" tabindex="-1" role="dialog" aria-labelledby="ativarAlunoModal" aria-hidden="true">

    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="modal-title" id="exampleModalLabel">Cadastro de Cartão</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
    		
      <div class="modal-body">

        <div class="row">

          <div class="col-md-1">
            <img src="imagens/card.png" alt="" style="width: 50px;">
          </div>
          <div class="col-md-10">
            <h3>Cadastro de Cartões</h3>
          </div>

        </div>

         <div class="row">
            <div class="col-md-8">

              <div class="box-header with-border">
                <h5>Você não possuí métodos de pagamento cadastrados</h5>

              </div>
            </div>
            <div class="col-md-4">
              <a class="btn btn btn-primary pull-right" data-toggle="modal" data-target="#iugu"><i class="fa fa-plus"></i></a>
            </div>

         </div>


         <div class="row">
            <div class="col-md-12">

             <table class="table table-bordered table-striped">
              <thead>
                <th>Marca</th>
                <th>Número</th>
                <th>Vencimento</th>
                <th>#</th>
              </thead>
                <tbody ng-repeat="linha in cartao_iugu">
                  <td ng-bind="linha.numeroCard"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tbody>

              </table>

            </div>

         </div>

      </div>
		{{cartao_iugu}}
		<div class="modal-footer">
             <a type="button" class="btn btn-secondary" data-dismiss="modal"> Cancela</a>
            <button type="submit" class="btn btn btn-primary pull-right" id="payment-form"> Salvar</button>
         </div>

      </div>
		
      </div>

</div>