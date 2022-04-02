<div class="modal fade" id="treino" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Treino</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <div class="row">
                          <div class="col-md-6">
                            <strong>Tipo: </strong>
                          </div>

                          <div class="col-md-6">

                            
                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Letra" ng-click="tipo(1)">
                              <label class="form-check-label" for="exampleRadios1">Letra</label><br>

                             <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="semana" ng-click="tipo(2)">
                            <label class="form-check-label" for="exampleRadios1">Semana</label><br>

                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="dia" ng-click="tipo(3)">
                            <label class="form-check-label" for="exampleRadios1">Dia</label><br>

                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="livre" ng-click="tipo(4)">
                            <label class="form-check-label" for="exampleRadios1">Livre</label><br>
                            
                          </div>
                        
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <strong>Nome: </strong>
                        </div>

                        <div class="col-md-8">
                         
                          <select class="form-control" ng-model="Letra" id="Letra" ng-if="checkedLetra==true" value="">
                            <option ng-repeat="linha in selectLetra" value={{linha.letra}}>{{linha.letra}}</option>                                                    
                          </select>
                       
                         <!--
                        <select class="form-control" id="Letra" ng-if="checkedLetra==true" value="">
                          <option value="A" selected>A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                          <option value="E">E</option>
                          <option value="F">F</option>
                          <option value="G">G</option>
                          <option value="H">H</option>
                          <option value="I">I</option>
                          <option value="J">J</option>
                          <option value="K">K</option>
                          <option value="L">M</option>
                          <option value="M">M</option>
                          <option value="N">N</option>
                          <option value="O">O</option>
                          <option value="P">P</option>
                          <option value="Q">Q</option>
                          <option value="R">R</option>
                          <option value="S">S</option>
                          <option value="T">T</option>
                          <option value="U">U</option>
                          <option value="V">V</option>
                          <option value="W">W</option>
                          <option value="X">X</option>
                          <option value="Y">Y</option>
                          <option value="Z">Z</option>

                        </select>
                           -->
                          {{treino.Letra}}
                          <select class="form-control" ng-model="Semana" id="Semana" ng-if="checkedSemana==true">
                            <option ng-repeat="linha in selectSemana" value={{linha.value}}>{{linha.semana}}</option>                                                    
                          </select>

                          <input type="date" class="form-control" name="dia" ng-if="checkedDia==true" ng-model="dia" id="dia">                                               
                          
                          <input type="text" class="form-control" name="livre" ng-if="checkedLivre==true" ng-model="livre" id="livre">  

                          {{livre}} {{dia}}
                        </div>

                        
                      </div>

                      <div class="row" style="margin-top: 15px;">

                        <div class="col-md-6">
                          <strong>Ordem: </strong>
                          
                        </div>

                        <div class="col-md-6">
                          
                          <input type="number" class="form-control" ng-model="ordem" id="ordem" name="ordem">   
                          
                        </div>
                        
                      </div>

                        

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       <!-- <button type="button" class="btn btn-primary" ng-click="criarTreino(dataI|date:'yyyy-MM-dd',nomeTreino,prof,qtsemanas,qtsessoes,nivel,velocidade,tipoTreino,AvR,Letra,Semana,dia|date:'yyyy-MM-dd',livre,ordem)" data-dismiss="modal">Salvar</button>-->
                       <button type="button" class="btn btn-primary" onclick="treino()" ng-click="criarTreino()" data-dismiss="modal">Salvar</button>
                      </div>
                    </div>
                  </div>
                </div>