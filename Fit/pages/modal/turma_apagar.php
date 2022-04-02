<div class="modal fade" id="myModal3{{linha.id}}" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form action="turma_remove.php" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h3>Deseja excluir o aluno(a)</h3>
          <input type="hidden" name="id" value="{{linha.id}}">
          <input type="hidden" name="usuario" value="<?=$usuario?>">
          <input type="hidden" name="senha" value="<?=$senha?>">
          <input type="hidden" name="modo_edicao" value="<?=$modo_edicao?>">
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal"> Não</button>
          <button class="btn btn-danger"> Sim</button>
        </div>
      </form>
    </div>
  </div>
</div>
