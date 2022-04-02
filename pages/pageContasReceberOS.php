<md-tab label="CONTAS A RECEBER">
    <md-content class="md-padding" style="background-color:rgba(0,0,0, .65) !important; padding-top:0px;">
        <form class="my-0 py-0">
            <div class="form-row justify-content-between align-items-center pt-0">

<?php if (base64_decode($empresa_acesso) == 0) {?>
                <div class="col-auto ml-2 pt-2">
                    <label>Filtros</label>
                </div>
                <div class="col-2 ml-2">
                    <select class="form-control form-control-sm" id="empresa" ng-model="empresa">
                        <option value="">Todas as Empresas</option>
                        <option ng-repeat="emp in dadosEmpresa" value="{{emp.em_cod}}">{{emp.em_fanta}} </option>
                    </select>
                </div>
<?php } else {
//echo $dados_empresa["em_fanta"]; ?>
                <div class="col-auto ml-2 pt-2">
                    <label>Filtrar por </label>
                </div>
<?php }?>
                <div class="col-auto"> 
                    <input type="text" value="" class="form-control form-control-sm" id="buscaCliente" ng-model="buscaFornec" placeholder="Todos os Clientes">
                </div>

                <div class="col-auto">
                    <label for="itensPagina">Linhas</label>
                </div>
                <div class="col-auto" ng-init="itensPagina = 10">
                    <select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
                        <option ng-value="10" ng-selected="true">10</option>
                        <option ng-value="20">20</option>
                        <option ng-value="50">50</option>
                    </select>
                </div>
                <div class="ml-auto m-0 p-0">
                    <md-button class="btnPesquisar pull-left" style="border: none;" ng-click="contasReceberLista(empresa, buscaFornec, itensPagina)" style="color: white;">
                        <md-tooltip md-direction="top" md-visible="tooltipPesquisar">Pesquisar</md-tooltip>
                        <i class="fas fa fa-search" ></i> Pesquisar
                    </md-button>
                </div>
            </div>
        </form>

        <div class="table-responsive p-0 mb-2" style="overflow: hidden;">
            <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                <thead class="thead-dark">
                    <tr style="font-size: 1em !important;">
                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_docto')">Docto</th>
                        <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_parc')">Parcela</th>
                        <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('ct_nome')">Cliente</th>
                        <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_vencto')">Vencto</th>
                        <th scope="col" style=" font-weight: normal; text-align: right;" ng-click="ordenar('ct_valor')">Valor</th>
                        <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('ct_tipdoc')">Tipo Docto</th>
                    </tr>
                </thead>
                <tbody >
                    <tr dir-paginate="contasReceber in contasReceber | orderBy:'sortKey' | itemsPerPage:pageSize" ng-class="contasReceber.ct_vencto < dataH ? 'atrasado' : contasReceber.ct_vencto == dataH ? 'vencendo':''" pagination-id="tabela3">
                        <td align="left" ng-bind="contasReceber.ct_docto"></td>
                        <td align="center" ng-bind="contasReceber.ct_parc"></td>
                        <td align="left" ng-bind="contasReceber.ct_nome | limitTo:25"></td>
                        <td align="right" ng-bind="contasReceber.ct_vencto | date : 'dd/MM/yyyy'"></td>
                        <td align="right" ng-bind="contasReceber.ct_valor | currency: 'R$ '"></td>
                        <td align="center" ng-bind="contasReceber.ct_tipdoc"></td>
                    </tr>
                </tbody>
            </table>
            <div ng-if="arrayNull == true">
                <div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
                    Aguarde... Pesquisando!
                </div>
            </div>
        </div>

        <div class="card-footer p-2">
            <div class="form-row align-items-center">
                <div class="col-4" style="text-align: left;">
                    <!--
                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #de0000"></button>
                        <span style="color: white;" class="col-auto">Atrasadas: <b class="col-auto">{{totalcontasReceber[0].vencidas | currency: 'R$ '}}</b></span>
                    </div>

                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #0034cf"></button>
                        <span style="color: white;" class="col-auto">Vencendo hoje: <b class="col-auto">{{totalcontasReceber[0].vencendo | currency: 'R$ '}}</b></span>
                    </div>

                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #000"></button>
                        <span style="color: white;" class="col-auto">A Receber: <b class="col-auto">{{totalcontasReceber[0].a_vencer | currency: 'R$ '}}</b></span>
                    </div>
                    -->
                </div>
                <div class="col-8" style="text-align: right;">
                    <span style="color: grey;">Registros: <b>{{contasReceber.length}}</b></span>
                </div>
            </div>
        </div>
    </md-content>
    <dir-pagination-controls pagination-id="tabela3" max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
</md-tab>