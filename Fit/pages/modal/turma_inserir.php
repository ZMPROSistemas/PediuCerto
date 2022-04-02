                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalLabel">Inserir Turma</h3>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          </button>
                        </div>
                        <form action="turma_adiciona.php" method="post">
                          <div class="modal-body">
                            <div class="box-body">
                              <label>Nome:</label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-dumbbell"></i>
                                </div>
                                <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                              </div>
                            </div>


                            




                            <div class="box-body">
                              <label>
                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Entrada livre para todos os horários
                              </label>
                            </div>

                            <hr>  <!-- Cria uma linha -->
                            
                            <div class="box-body">
                              <div class="col-md-4">
                                <label>Hora de início:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control timepicker" name="hora_inicio" value="">
                                  <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label>Hora de fim:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control timepicker" name="hora_fim" value="">
                                  <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label>Limite de alunos:</label>
                                <div class="input-group">
                                  <input type="number" class="form-control timepicker" name="qtd_aluno" value="0">
                                  <div class="input-group-addon">
                                    <i class="fa fa-users"></i>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="box-body">
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="segunda" value="1">
                                <label>Segunda</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="terca" value="1">
                                <label>Terça</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="quarta" value="1">
                                <label>Quarta</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="quinta" value="1">
                                <label>Quinta</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="sexta" value="1">
                                <label>Sexta</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="sabado" value="1">
                                <label>Sábado</label>
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="domingo" value="1">
                                <label>Domingo</label>
                              </div>
                            </div>
                            <input type="hidden" name="id" value="0">
                            <input type="hidden" name="idacademia" value="<?=$idacademia?>">
                            <input type="hidden" name="usuario" value="<?=$usuario?>">
                            <input type="hidden" name="senha" value="<?=$senha?>">
                            <input type="hidden" name="modo_edicao" value="<?=$modo_edicao?>">
                          </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancela</button>
                              <button type="submit" class="btn btn-primary"> Salvar</button>
                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
