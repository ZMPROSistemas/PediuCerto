                  <div class="modal fade" id="myModal2{{linha.idperfil}}" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
	                  <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel2">Inserir Perfil</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <form action="perfil_adiciona.php" method="post">
                            <div class="modal-body">
                              <div class="box-body">
                                <label>Descrição:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-dumbbell"></i>
                                  </div>
                                  <input type="text" name="nome" class="form-control" placeholder="Descrição" value="{{linha.nome}}" required>                                                                 
                                </div>
                              </div>

                              <hr>

                            <!-- inicio tabs -->
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#tab_1" data-toggle="tab">Cadastros</a></li>
                                      <li><a href="#tab_2" data-toggle="tab">Treinos</a></li>                                    
                                      <li><a href="#tab_3" data-toggle="tab">Produtos</a></li>
                                      <li><a href="#tab_4" data-toggle="tab">Relatórios</a></li>
                                      <li><a href="#tab_5" data-toggle="tab">Financeiro</a></li>
                                      <li><a href="#tab_6" data-toggle="tab">Recorrente</a></li>
                                      <li><a href="#tab_7" data-toggle="tab">Administrativo</a></li>
                                    </ul>     
                                    <div class="tab-content">
                                  <!-- Cadastros -->     
                                      <div class="tab-pane active" id="tab_1">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Alunos</label>  
                                              </td> 
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                              <!--
                                              <td>	
                                              	<input type="checkbox" class="flat-red" name="aluno_consultar" ng-model="linha.aluno_c" value="{{linha.aluno_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="'{{linha.aluno_c}}'"> Consultar                                                
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="aluno_incluir" ng-model="linha.aluno_i" value="{{linha.aluno_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="'{{linha.aluno_i}}'"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="aluno_alterar" ng-model="linha.aluno_a" value="{{linha.aluno_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="'{{linha.aluno_a}}'"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="aluno_excluir" ng-model="linha.aluno_e" value="{{linha.aluno_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="'{{linha.aluno_e}}'"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="aluno_relatorio" ng-model="linha.aluno_r" value="{{linha.aluno_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="'{{linha.aluno_r}}'"> Relatórios
                                              </td>
                                          -->
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Visitantes</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Turmas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Planos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Modalidades</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>                                    
                                  <!-- Treinos -->     
                                      <div class="tab-pane" id="tab_2">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Grupo Muscular</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Exercícios</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Treinos Padrão</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                  <!-- Produtos -->     
                                      <div class="tab-pane" id="tab_3">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Grupo de Produtos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Produtos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                      </div>
                                  <!-- Relatórios -->     
                                      <div class="tab-pane" id="tab_4">
                                        <p>
                                        <table class="table table-bordered table-striped">
                                          <tbody>
                                            <tr>
                                              <td style="height: 5px !important;">
                                                <label>Alunos com APP</label> 
                                              </td>
                                              <td style="height: 5px !important;">
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Alunos</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Visitantes</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Modalidades</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Situação do Aluno</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Matrículas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Planos</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Sem entrada na Academia</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Mensalidades Recebidas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Contas (Financeiro)</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Vendas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Débito Recorrente</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Ligações a Fazer</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Comissões</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Estoque</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Emitir
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </p>
                                      </div>
                                  <!-- Financeiro -->     
                                      <div class="tab-pane" id="tab_5">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Caixas e Bancos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Cartões</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Movimentações de Cartões</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Formas de Pagamento</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Históricos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Vendas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Contas a Pagar</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Movimentações de Caixa</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                      </div>
                                  <!-- Recorrente -->     
                                      <div class="tab-pane" id="tab_6">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Início</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Verificar Conta</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Clientes</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Faturas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Chargebacks</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Assinaturas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Planos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>SubConta</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                      </div>
                                  <!-- Administrativo -->     
                                      <div class="tab-pane" id="tab_7">
                                        <table class="table table-bordered table-striped">                                          
                                          <tbody>
                                            <tr>
                                              <td>
                                                <label>Equipe</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Perfil</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Controle de Entradas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Registro de Atividades</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="entrada_livre" value="1"> Relatórios
                                              </td>
                                            </tr>   

                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
  							  <input type="hidden" name="id" value="{{linha.idperfil}}">
                              <input type="hidden" name="idacademia" value="{{linha.academia}}">
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
