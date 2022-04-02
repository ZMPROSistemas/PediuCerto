<div class="modal" id="ModalExcecao" tabindex="-1" role="dialog" aria-labelledby="ModalExcecao" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="color: black !important;">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black !important;">Cadastro de Adicionais / Exceções</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formExcecao">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="excecao.ex_desc">Descrição</label>
                            <input type="text" class="form-control" id="ex_desc" ng-model="excecao.ex_desc">
                        </div>
                        <div class="form-group col-6">
                            <label for="excecao.ex_valor">Valor</label>
                            <input type="text" class="form-control" id="ex_valor" ng-model="excecao.ex_valor" ng-value='0' money-mask>
                        </div>
                        <div class="form-group col-6">
                            <label for="excecao.ex_tipo">Tipo</label>
                            <select class="form-control" id="ex_tipo" ng-model="excecao.ex_tipo" ng-change="excecao.ex_tipo == 'E' ? excecao.ex_valor = 0 : ''">
                                <option value="">Selecione o Tipo</option>
                                <option value="A">Adicional</option>
                                <option value="E">Exceção</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secundary" data-dismiss="modal" >Fechar</a>
                <a class="btn btn-primary" ng-if="excecao.ex_valor && excecao.ex_tipo && excecao.ex_desc" ng-click="salvarExcecao(excecao)">Salvar</a>
                <a class="btn btn-primary" ng-if="produto[0].pd_cod && excecao.ex_valor && excecao.ex_tipo && excecao.ex_desc" ng-click="salvarExcecao(excecao, produto[0].pd_cod)">Salvar e Acrescentar ao Produto</a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ModalExcecaoLista" tabindex="-1" role="dialog" aria-labelledby="ModalExcecaoLista" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-lg" role="document">
        <div class="modal-content"  style="color: black !important;">
            <div class="modal-header">
                <h5 class="modal-title"  style="color: black !important;">Lista de Adicionais / Exceções</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <input type="hidden" class="form-control" id="produto.pd_cod" ng-model="produto.pd_cod" required>
                <input type="hidden" class="form-control" id="produto.pd_empr" ng-model="produto.pd_empr" required>
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label>Pesquisar</label>
                    </div>

                    <div class="col-auto">
                        <input type="text" value="" class="form-control form-control-sm" id="pesquisa" ng-model="pesquisa" placeholder="Pesquisar Adicionais">
                    </div>

                    <div class="col-auto">
                        <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="cadastrarAdicional()" style="color: white;">
                            <md-tooltip md-direction="top" md-visible="tooltipVisible"> Cadastrar Adicional</md-tooltip>
                            <i class="fas fa-plus" ></i>  Cadastrar Adicional
                        </md-button>
                    </div>
                </div>

                <div class="table-responsive p-0 m-0" style="max-height: 400px; overflow-x:auto;">
					<table class="table table-sm table-striped " style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
						<thead class="thead-dark">
							<tr style="font-size: 0.9em !important;">
                                <th scope="col" style=" font-weight: normal; text-align: left;">Cod</th>
                                <th scope="col" style=" font-weight: normal; text-align: left;">Descrição</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;">Tipo</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr ng-repeat="excecao in excecaoEmpresa | filter: pesquisa">
                                <td style="text-align: left">{{excecao.ex_cod}}</td>
                                <td style="text-align: left">{{excecao.ex_desc}}</td>
                                <td style="text-align: right">{{excecao.ex_valor | currency: 'R$ '}}</td>
                                <td style="text-align: center">{{excecao.ex_tipo}}</td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="adicionarExcecaoProd(excecao, produto[0].pd_cod)">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Fechar</button>
            </div>
        </div>
    </div>
</div>