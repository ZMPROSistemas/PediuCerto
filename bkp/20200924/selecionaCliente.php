<style>

    .tabelaCliente thead tr {
        display: block;
        position: relative;
    }
   
    .tabelaCliente th:nth-child(1) .tabelaCliente td:nth-child(1) {
        width: 15%;
    }
    .tabelaCliente th:nth-child(2), .tabelaCliente td:nth-child(2) {
        width: 50%;
    }
    .tabelaCliente th:nth-child(3),
    .tabelaCliente td:nth-child(3) {
        width: 50%;
    }
    .tabelaCliente tbody {
        display: block;
        overflow: auto;
        width: 100%;
        height: 200px;
    } 

</style>
<div class="modal fade" id="selecionaCliente" tabindex="-1" role="dialog" aria-labelledby="ModalLancarDespesas" aria-hidden="true" data-backdrop="static">
    
        <div class="modal-dialog modal-lg" role="document" style="color: black;">

            <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
                <div class="modal-header">
                    <h4 style="color: black !important;" >Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><br>

                    <div class="alert {{tipoAlerta}} selecionaCliente col-lg-4" role="alert" style="right: 0; position: absolute; z-index: 999">
                        {{alertMsg}}
                    </div>

                </div>

                <div class="modal-body">
                    <span>Nome: </span>

                    <input type="text" class="form-control form-control-sm" id="pesquisaCliente" ng-model="pesquisaCliente" value="" autocomplete="nope">
                    
                    <div class="tabelaCliente">

                        <table class="table table-striped table-sm" style="background-color: #FFFFFFFF; color: black; margin-top:10px;">
                            <thead class="thead-dark">
                                <tr style="font-size: 1em !important;">
                                    <th style=" font-weight: normal;" ng-click="ordenar('pe_codigo')">Código</th>
                                    <th style=" font-weight: normal;" ng-click="ordenar('pe_nome')">Nome/Razão</th>
                                    <th style=" font-weight: normal;" ng-click="ordenar('pe_endereco')">Endereço</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--tr dir-paginate="cliente in buscaCliente | orderBy:'sortKey' | itemsPerPage:10 | filter:{pe_nome:pesquisaCliente}" pagination-id="selectCliente"  ng-click="selectCliente(buscaCliente)"-->
                                <tr ng-repeat="cliente in buscaCliente | orderBy:'sortKey' | filter:{pe_nome:pesquisaCliente}" ng-click="selectCliente(buscaCliente)" style="cursor:pointer;">
                                    <td ng-bind="cliente.pe_cod"></td>
                                    <td ng-bind="cliente.pe_nome"></td>
                                    <td ng-bind="cliente.pe_endereco"></td>
                                </tr>
                            
                            </tbody>
                        </table>

                    </div>
                    

                    <!--dir-pagination-controls max-size="5" boundary-links="true" class="ng-isolate-scope" pagination-id="selectCliente" style="background-color:#000;"></dir-pagination-controls-->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				    <button type="button" class="btn btn-primary" ng-click="selectClienteOK(clienteSelecionado)">Selecionar</button>
                </div>
            
            </div>

        </div>
    
   
</div>
