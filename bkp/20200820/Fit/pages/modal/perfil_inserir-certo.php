                    <div class="modal fade" id="exampleModal{{linha.idperfil}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true"> 
                      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Inserir Perfil</h3>
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
                                  <input type="text" name="nome" class="form-control" placeholder="Descrição" required>
                                </div>
                              </div>
                              <div class="box-body">                              
                                <input type="checkbox" class="flat-red" name="dashboard" ng-model="linha.dashboard" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.dashboard}}" value="{{linha.dashboard}}"> DashBoard
                                          <!--
                                  <input type="checkbox" class="flat-green" name="entrada_livre" value="{{linha.livre}}" ng-checked="{{linha.livre}}"> Entrada livre para todos horário
                                  -->                                                           
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
                                                <input type="checkbox" class="flat-red" name="alunos_c" ng-model="linha.aluno_c" value="{{linha.aluno_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.aluno_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="alunos_i" ng-model="linha.aluno_i" value="{{linha.aluno_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.aluno_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="alunos_a" ng-model="linha.aluno_a" value="{{linha.aluno_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.aluno_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="alunos_e" ng-model="linha.aluno_e" value="{{linha.aluno_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.aluno_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="alunos_r" ng-model="linha.aluno_r" value="{{linha.aluno_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.aluno_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Visitantes</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="visitantes_c" ng-model="linha.visitantes_c" value="{{linha.visitantes_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.visitantes_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="visitantes_i" ng-model="linha.visitantes_i" value="{{linha.visitantes_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.visitantes_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="visitantes_a" ng-model="linha.visitantes_a" value="{{linha.visitantes_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.visitantes_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="visitantes_e" ng-model="linha.visitantes_e" value="{{linha.visitantes_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.visitantes_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="visitantes_r" ng-model="linha.visitantes_r" value="{{linha.visitantes_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.visitantes_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Turmas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="turma_c" ng-model="linha.turma_c" value="{{linha.turma_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.turma_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="turma_i" ng-model="linha.turma_i" value="{{linha.turma_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.turma_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="turma_a" ng-model="linha.turma_a" value="{{linha.turma_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.turma_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="turma_e" ng-model="linha.turma_e" value="{{linha.turma_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.turma_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="turma_r" ng-model="linha.turma_r" value="{{linha.turma_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.turma_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Planos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="plano_c" ng-model="linha.plano_c" value="{{linha.plano_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.plano_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="plano_i" ng-model="linha.plano_i" value="{{linha.plano_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.plano_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="plano_a" ng-model="linha.plano_a" value="{{linha.plano_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.plano_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="plano_e" ng-model="linha.plano_e" value="{{linha.plano_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.plano_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="plano_r" ng-model="linha.plano_r" value="{{linha.plano_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.plano_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Modalidades</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="modalidade_c" ng-model="linha.modalidade_c" value="{{linha.modalidade_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.modalidade_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="modalidade_i" ng-model="linha.modalidade_i" value="{{linha.modalidade_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.modalidade_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="modalidade_a" ng-model="linha.modalidade_a" value="{{linha.modalidade_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.modalidade_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="modalidade_e" ng-model="linha.modalidade_e" value="{{linha.modalidade_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.modalidade_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="modalidade_r" ng-model="linha.modalidade_r" value="{{linha.modalidade_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.modalidade_r}}"> Relatórios
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
                                                <input type="checkbox" class="flat-red" name="grupo_muscular_c" ng-model="linha.grupo_muscular_c" value="{{linha.grupo_muscular_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_muscular_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_muscular_i" ng-model="linha.grupo_muscular_i" value="{{linha.grupo_muscular_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_muscular_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_muscular_a" ng-model="linha.grupo_muscular_a" value="{{linha.grupo_muscular_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_muscular_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_muscular_e" ng-model="linha.grupo_muscular_e" value="{{linha.grupo_muscular_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_muscular_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_muscular_r" ng-model="linha.grupo_muscular_r" value="{{linha.grupo_muscular_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_muscular_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Exercícios</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="exercicios_c" ng-model="linha.exercicios_c" value="{{linha.exercicios_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.exercicios_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="exercicios_i" ng-model="linha.exercicios_i" value="{{linha.exercicios_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.exercicios_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="exercicios_a" ng-model="linha.exercicios_a" value="{{linha.exercicios_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.exercicios_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="exercicios_e" ng-model="linha.exercicios_e" value="{{linha.exercicios_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.exercicios_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="exercicios_r" ng-model="linha.exercicios_r" value="{{linha.exercicios_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.exercicios_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Treinos Padrão</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="treino_padrao_c" ng-model="linha.treino_padrao_c" value="{{linha.treino_padrao_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.treino_padrao_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="treino_padrao_i" ng-model="linha.treino_padrao_i" value="{{linha.treino_padrao_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.treino_padrao_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="treino_padrao_a" ng-model="linha.treino_padrao_a" value="{{linha.treino_padrao_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.treino_padrao_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="treino_padrao_e" ng-model="linha.treino_padrao_e" value="{{linha.treino_padrao_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.treino_padrao_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="treino_padrao_r" ng-model="linha.treino_padrao_r" value="{{linha.treino_padrao_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.treino_padrao_r}}"> Relatórios
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
                                                <input type="checkbox" class="flat-red" name="grupo_produto_c" ng-model="linha.grupo_produto_c" value="{{linha.grupo_produto_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_produto_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_produto_i" ng-model="linha.grupo_produto_i" value="{{linha.grupo_produto_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_produto_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_produto_a" ng-model="linha.grupo_produto_a" value="{{linha.grupo_produto_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_produto_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_produto_e" ng-model="linha.grupo_produto_e" value="{{linha.grupo_produto_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_produto_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="grupo_produto_r" ng-model="linha.grupo_produto_r" value="{{linha.grupo_produto_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.grupo_produto_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Produtos</label>  
                                              </td> 
                                              <td>
                                                <input type="checkbox" class="flat-red" name="produto_c" ng-model="linha.produto_c" value="{{linha.produto_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.produto_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="produto_i" ng-model="linha.produto_i" value="{{linha.produto_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.produto_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="produto_a" ng-model="linha.produto_a" value="{{linha.produto_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.produto_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="produto_e" ng-model="linha.produto_e" value="{{linha.produto_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.produto_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="produto_r" ng-model="linha.produto_r" value="{{linha.produto_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.produto_r}}"> Relatórios
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
                                              <td>
                                                <label>Alunos com APP</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_alunos_com_app" ng-model="linha.rel_alunos_com_app" value="{{linha.rel_alunos_com_app}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_alunos_com_app}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Situação do Aluno</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_sit_alunos" ng-model="linha.rel_sit_alunos" value="{{linha.rel_sit_alunos}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_sit_alunos}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Matrículas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_matriculas" ng-model="linha.rel_matriculas" value="{{linha.rel_matriculas}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_matriculas}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Sem entrada na Academia</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_alunos_sem_entrada" ng-model="linha.rel_alunos_sem_entrada" value="{{linha.rel_alunos_sem_entrada}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_alunos_sem_entrada}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Mensalidades Recebidas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_mens_rec" ng-model="linha.rel_mens_rec" value="{{linha.rel_mens_rec}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_mens_rec}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Contas (Financeiro)</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_contas" ng-model="linha.rel_contas" value="{{linha.rel_contas}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_contas}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Vendas</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_vendas" ng-model="linha.rel_vendas" value="{{linha.rel_vendas}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_vendas}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Débito Recorrente</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_recorrente" ng-model="linha.rel_recorrente" value="{{linha.rel_recorrente}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_recorrente}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Ligações a Fazer</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_ligacoes" ng-model="linha.rel_ligacoes" value="{{linha.rel_ligacoes}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_ligacoes}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Comissões</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_comiss" ng-model="linha.rel_comiss" value="{{linha.rel_comiss}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_comiss}}"> Emitir
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Estoque</label> 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rel_estoque" ng-model="linha.rel_estoque" value="{{linha.rel_estoque}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rel_estoque}}"> Emitir
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
                                                <input type="checkbox" class="flat-red" name="banco_c" ng-model="linha.banco_c" value="{{linha.banco_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.banco_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="banco_i" ng-model="linha.banco_i" value="{{linha.banco_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.banco_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="banco_a" ng-model="linha.banco_a" value="{{linha.banco_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.banco_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="banco_e" ng-model="linha.banco_e" value="{{linha.banco_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.banco_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="banco_r" ng-model="linha.banco_r" value="{{linha.banco_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.banco_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Cartões</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_c" ng-model="linha.cartao_c" value="{{linha.cartao_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_i" ng-model="linha.cartao_i" value="{{linha.cartao_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_a" ng-model="linha.cartao_a" value="{{linha.cartao_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_e" ng-model="linha.cartao_e" value="{{linha.cartao_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_r" ng-model="linha.cartao_r" value="{{linha.cartao_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Movimentações de Cartões</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_receber_c" ng-model="linha.cartao_receber_c" value="{{linha.cartao_receber_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_receber_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="cartao_receber_b" ng-model="linha.cartao_receber_b" value="{{linha.cartao_receber_b}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.cartao_receber_b}}"> Baixar
                                              </td>
                                              <td>
                                                
                                              </td>
                                              <td>
                                                
                                              </td>
                                              <td>
                                                
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Formas de Pagamento</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="forma_pagamento_c" ng-model="linha.forma_pagamento_c" value="{{linha.forma_pagamento_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.forma_pagamento_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="forma_pagamento_i" ng-model="linha.forma_pagamento_i" value="{{linha.forma_pagamento_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.forma_pagamento_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="forma_pagamento_a" ng-model="linha.forma_pagamento_a" value="{{linha.forma_pagamento_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.forma_pagamento_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="forma_pagamento_e" ng-model="linha.forma_pagamento_e" value="{{linha.forma_pagamento_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.forma_pagamento_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="forma_pagamento_r" ng-model="linha.forma_pagamento_r" value="{{linha.forma_pagamento_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.forma_pagamento_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Históricos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="historico_c" ng-model="linha.historico_c" value="{{linha.historico_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.historico_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="historico_i" ng-model="linha.historico_i" value="{{linha.historico_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.historico_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="historico_a" ng-model="linha.historico_a" value="{{linha.historico_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.historico_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="historico_e" ng-model="linha.historico_e" value="{{linha.historico_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.historico_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="historico_r" ng-model="linha.historico_r" value="{{linha.historico_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.historico_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Vendas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="venda_c" ng-model="linha.venda_c" value="{{linha.venda_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.venda_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="venda_i" ng-model="linha.venda_i" value="{{linha.venda_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.venda_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="venda_canc" ng-model="linha.venda_canc" value="{{linha.venda_canc}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.venda_canc}}"> Cancelar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="venda_e" ng-model="linha.venda_e" value="{{linha.venda_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.venda_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="venda_r" ng-model="linha.venda_r" value="{{linha.venda_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.venda_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Contas a Pagar</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="pagar_c" ng-model="linha.pagar_c" value="{{linha.pagar_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.pagar_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="pagar_i" ng-model="linha.pagar_i" value="{{linha.pagar_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.pagar_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="pagar_a" ng-model="linha.pagar_a" value="{{linha.pagar_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.pagar_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="pagar_e" ng-model="linha.pagar_e" value="{{linha.pagar_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.pagar_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="pagar_r" ng-model="linha.pagar_r" value="{{linha.pagar_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.pagar_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Movimentações de Caixa</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="movimento_caixa_c" ng-model="linha.movimento_caixa_c" value="{{linha.movimento_caixa_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.movimento_caixa_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="movimento_caixa_i" ng-model="linha.movimento_caixa_i" value="{{linha.movimento_caixa_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.movimento_caixa_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="movimento_caixa_a" ng-model="linha.movimento_caixa_a" value="{{linha.movimento_caixa_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.movimento_caixa_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="movimento_caixa_e" ng-model="linha.movimento_caixa_e" value="{{linha.movimento_caixa_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.movimento_caixa_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="movimento_caixa_r" ng-model="linha.movimento_caixa_r" value="{{linha.movimento_caixa_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.movimento_caixa_r}}"> Relatórios
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
                                                <input type="checkbox" class="flat-red" name="rec_inicio_c" ng-model="linha.rec_inicio_c" value="{{linha.rec_inicio_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_inicio_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_inicio_i" ng-model="linha.rec_inicio_i" value="{{linha.rec_inicio_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_inicio_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_inicio_a" ng-model="linha.rec_inicio_a" value="{{linha.rec_inicio_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_inicio_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_inicio_e" ng-model="linha.rec_inicio_e" value="{{linha.rec_inicio_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_inicio_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_inicio_r" ng-model="linha.rec_inicio_r" value="{{linha.rec_inicio_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_inicio_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Verificar Conta</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_verif_contas_c" ng-model="linha.rec_verif_contas_c" value="{{linha.rec_verif_contas_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_verif_contas_c}}"> Consultar 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_verif_contas_i" ng-model="linha.rec_verif_contas_i" value="{{linha.rec_verif_contas_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_verif_contas_i}}"> Incluir 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_verif_contas_a" ng-model="linha.rec_verif_contas_a" value="{{linha.rec_verif_contas_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_verif_contas_a}}"> Alterar 
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_verif_contas_e" ng-model="linha.rec_verif_contas_e" value="{{linha.rec_verif_contas_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_verif_contas_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_verif_contas_r" ng-model="linha.rec_verif_contas_r" value="{{linha.rec_verif_contas_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_verif_contas_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Clientes</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_clientes_c" ng-model="linha.rec_clientes_c" value="{{linha.rec_clientes_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_clientes_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_clientes_i" ng-model="linha.rec_clientes_i" value="{{linha.rec_clientes_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_clientes_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_clientes_a" ng-model="linha.rec_clientes_a" value="{{linha.rec_clientes_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_clientes_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_clientes_e" ng-model="linha.rec_clientes_e" value="{{linha.rec_clientes_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_clientes_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_clientes_r" ng-model="linha.rec_clientes_r" value="{{linha.rec_clientes_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_clientes_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Faturas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_faturas_c" ng-model="linha.rec_faturas_c" value="{{linha.rec_faturas_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_faturas_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_faturas_i" ng-model="linha.rec_faturas_i" value="{{linha.rec_faturas_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_faturas_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_faturas_a" ng-model="linha.rec_faturas_a" value="{{linha.rec_faturas_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_faturas_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_faturas_e" ng-model="linha.rec_faturas_e" value="{{linha.rec_faturas_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_faturas_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_faturas_r" ng-model="linha.rec_faturas_r" value="{{linha.rec_faturas_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_faturas_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Chargebacks</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_charge_c" ng-model="linha.rec_charge_c" value="{{linha.rec_charge_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_charge_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_charge_i" ng-model="linha.rec_charge_i" value="{{linha.rec_charge_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_charge_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_charge_a" ng-model="linha.rec_charge_a" value="{{linha.rec_charge_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_charge_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_charge_e" ng-model="linha.rec_charge_e" value="{{linha.rec_charge_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_charge_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_charge_r" ng-model="linha.rec_charge_r" value="{{linha.rec_charge_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_charge_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Assinaturas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_assin_c" ng-model="linha.rec_assin_c" value="{{linha.rec_assin_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_assin_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_assin_i" ng-model="linha.rec_assin_i" value="{{linha.rec_assin_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_assin_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_assin_a" ng-model="linha.rec_assin_a" value="{{linha.rec_assin_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_assin_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_assin_e" ng-model="linha.rec_assin_e" value="{{linha.rec_assin_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_assin_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_assin_r" ng-model="linha.rec_assin_r" value="{{linha.rec_assin_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_assin_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>Planos</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_planos_c" ng-model="linha.rec_planos_c" value="{{linha.rec_planos_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_planos_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_planos_i" ng-model="linha.rec_planos_i" value="{{linha.rec_planos_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_planos_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_planos_a" ng-model="linha.rec_planos_a" value="{{linha.rec_planos_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_planos_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_planos_e" ng-model="linha.rec_planos_e" value="{{linha.rec_planos_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_planos_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_planos_r" ng-model="linha.rec_planos_r" value="{{linha.rec_planos_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_planos_r}}"> Relatórios
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <label>SubConta</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_subconta_c" ng-model="linha.rec_subconta_c" value="{{linha.rec_subconta_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_subconta_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_subconta_i" ng-model="linha.rec_subconta_i" value="{{linha.rec_subconta_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_subconta_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_subconta_a" ng-model="linha.rec_subconta_a" value="{{linha.rec_subconta_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_subconta_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_subconta_e" ng-model="linha.rec_subconta_e" value="{{linha.rec_subconta_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_subconta_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="rec_subconta_r" ng-model="linha.rec_subconta_r" value="{{linha.rec_subconta_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.rec_subconta_r}}"> Relatórios
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
                                                <input type="checkbox" class="flat-red" name="equipe_c" ng-model="linha.equipe_c" value="{{linha.equipe_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.equipe_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="equipe_i" ng-model="linha.equipe_i" value="{{linha.equipe_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.equipe_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="equipe_a" ng-model="linha.equipe_a" value="{{linha.equipe_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.equipe_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="equipe_e" ng-model="linha.equipe_e" value="{{linha.equipe_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.equipe_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="equipe_r" ng-model="linha.equipe_r" value="{{linha.equipe_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.equipe_r}}"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Perfil</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="perfil_c" ng-model="linha.perfil_c" value="{{linha.perfil_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.perfil_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="perfil_i" ng-model="linha.perfil_i" value="{{linha.perfil_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.perfil_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="perfil_a" ng-model="linha.perfil_a" value="{{linha.perfil_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.perfil_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="perfil_e" ng-model="linha.perfil_e" value="{{linha.perfil_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.perfil_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="perfil_r" ng-model="linha.perfil_r" value="{{linha.perfil_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.perfil_r}}"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Controle de Entradas</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="contr_entr_c" ng-model="linha.contr_entr_c" value="{{linha.contr_entr_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.contr_entr_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="contr_entr_i" ng-model="linha.contr_entr_i" value="{{linha.contr_entr_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.contr_entr_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="contr_entr_a" ng-model="linha.contr_entr_a" value="{{linha.contr_entr_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.contr_entr_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="contr_entr_e" ng-model="linha.contr_entr_e" value="{{linha.contr_entr_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.contr_entr_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="contr_entr_r" ng-model="linha.contr_entr_r" value="{{linha.contr_entr_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.contr_entr_r}}"> Relatórios
                                              </td>
                                            </tr>   
                                            <tr>
                                              <td>
                                                <label>Registro de Atividades</label>  
                                              </td>                               
                                              <td>
                                                <input type="checkbox" class="flat-red" name="reg_atriv_c" ng-model="linha.reg_atriv_c" value="{{linha.reg_atriv_c}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.reg_atriv_c}}"> Consultar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="reg_atriv_i" ng-model="linha.reg_atriv_i" value="{{linha.reg_atriv_i}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.reg_atriv_i}}"> Incluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="reg_atriv_a" ng-model="linha.reg_atriv_a" value="{{linha.reg_atriv_a}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.reg_atriv_a}}"> Alterar
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="reg_atriv_e" ng-model="linha.reg_atriv_e" value="{{linha.reg_atriv_e}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.reg_atriv_e}}"> Excluir
                                              </td>
                                              <td>
                                                <input type="checkbox" class="flat-red" name="reg_atriv_r" ng-model="linha.reg_atriv_r" value="{{linha.reg_atriv_r}}" ng-true-value="'S'" ng-false-value="'N'" ng-checked="{{linha.reg_atriv_r}}"> Relatórios
                                              </td>
                                            </tr>   

                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <input type="hidden" name="idperfil" value="0">
                              <input type="hidden" name="usuario" value="<?=$usuario?>">
                              <input type="hidden" name="senha" value="<?=$senha?>">
                              <input type="hidden" name="modo_edicao" value="<?=$modo_edicao?>">
                              <input type="hidden" name="idacademia" value="<?=$idacademia?>">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancela</button>
                              <button type="submit" class="btn btn-primary"> Salvar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
