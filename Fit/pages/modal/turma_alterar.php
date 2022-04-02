                  <div class="modal fade" id="myModal2{{linha.id}}" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalLabel2">Alterar Turma</h3>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="turma_adiciona.php" method="post">
                          <div class="modal-body">
                            <div class="box-body">
                              <label>Nome:</label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-dumbbell"></i>
                                </div>
                                <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{linha.nome}}">
                              </div>
                            </div>
                            <div class="box-body">
                              <label>
                                <input type="checkbox" class="flat-red" name="entrada_livre" ng-model="linha.livre" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.livre}}" value="{{linha.livre}}"> Entrada livre para todos os horários
                                          <!--
                                  <input type="checkbox" class="flat-green" name="entrada_livre" value="{{linha.livre}}" ng-checked="{{linha.livre}}"> Entrada livre para todos horário
                                  -->
                                  
                              </label>
                            </div>
                            <hr>
                            <div class="box-body">
                              <div class="col-md-4">
                                <label>Hora de início:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control timepicker" name="hora_inicio" value="{{linha.hora_inicio}}">
                                  <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label>Hora de fim:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control timepicker" name="hora_fim" value="{{linha.hora_fim}}">
                                  <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label>Limite de alunos:</label>
                                <div class="input-group">
                                  <input type="number" class="form-control timepicker" name="qtd_aluno" value="{{linha.qtd_alunos}}">
                                  <div class="input-group-addon">
                                    <i class="fa fa-users"></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="box-body">
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="segunda" ng-model="linha.segunda" value="{{linha.segunda}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.segunda}}">
                                <label>Segunda</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="segunda" value="{{linha.segunda}}" ng-checked="{{linha.segunda}}">
                              -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="terca" ng-model="linha.terca" value="{{linha.terca}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.terca}}">
                                <label>Terça</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="terca" value="{{linha.terca}}" ng-checked="{{linha.terca}}"> -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="quarta" ng-model="linha.quarta" value="{{linha.quarta}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.quarta}}">
                                <label>Quarta</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="quarta" value="{{linha.quarta}}" ng-checked="{{linha.quarta}}"> -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="quinta" ng-model="linha.quinta" value="{{linha.quinta}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.quinta}}">
                                <label>Quinta</label>
                                <!--
                                <input type="checkbox" class="flat-red" value="{{linha.quinta}}" ng-checked="{{linha.quinta}}"> -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="sexta" ng-model="linha.sexta" value="{{linha.sexta}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.sexta}}">
                                <label>Sexta</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="sexta" value="{{linha.sexta}}" ng-checked="{{linha.sexta}}"> -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="sabado" ng-model="linha.sabado" value="{{linha.sabado}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.sabado}}">
                                <label>Sábado</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="sabado" value="{{linha.sabado}}" ng-checked="{{linha.sabado}}"> -->
                              </div>
                              <div class="col-md-4">
                                <input type="checkbox" class="flat-red" name="domingo" ng-model="linha.domingo" value="{{linha.domingo}}" ng-true-value="1" ng-false-value="0" ng-checked="{{linha.domingo}}">
                                <label>Domingo</label>
                                <!--
                                <input type="checkbox" class="flat-red" name="domingo" value="{{linha.domingo}}" ng-checked="{{linha.domingo}}"> -->
                              </div>
                            </div>
                            <input type="hidden" name="id" value="{{linha.id}}">
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
