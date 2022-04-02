<md-tab label="CONTAS A PAGAR">
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
                    <input type="text" value="" class="form-control form-control-sm" id="buscaFornec" ng-model="buscaFornec" placeholder="Todos os Fornecedores">
                </div>

                <div class="col-auto"> 
                    <input type="text" value="" class="form-control form-control-sm" id="buscaDocto" ng-model="buscaDocto" placeholder="Todos os Documentos">
                </div>
                <div class="col-auto" ng-init="itensPagina = 10">
                    <select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
                        <option ng-value="10" ng-selected="true">10</option>
                        <option ng-value="20">20</option>
                        <option ng-value="50">50</option>
                    </select>
                </div>
                <div class="ml-auto m-0 p-0">
                    <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="contasPagarLista(empresa, buscaFornec, buscaDocto, itensPagina)" >
                        <md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                        <i class="fas fa fa-search" ></i> Pesquisar
                    </md-button>
                </div>
            </div>
        </form>

        <div class="table-responsive p-0" style="overflow: hidden;">
            <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                <thead class="thead-dark">
                    <tr style="font-size: 1em !important;">
                        <th scope="col" style=" font-weight: normal; text-align: left;">Docto</th>
                        <th scope="col" style=" font-weight: normal; text-align: center;">Parcela</th>
                        <th scope="col" style=" font-weight: normal; text-align: left;">Vencto</th>
                        <th scope="col" style=" font-weight: normal; text-align: left;">Fornecedor</th>
                        <th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
                        <th scope="col" style=" font-weight: normal; text-align: center;">Tipo Docto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="contas in contasPagar | orderBy:'sortKey' | itemsPerPage:pageSize" ng-class="contas.ct_vencto < dataI ? 'venc' : contas.ct_vencto == dataI ? 'vencH':''" pagination-id="tabela2">
                        <td style="text-align: left;" ng-bind="contas.ct_docto"></td>
                        <td style="text-align: center;" ng-bind="contas.ct_parc"></td>
                        <td style="text-align: left;" ng-bind="contas.ct_vencto | date : 'dd/MM/yyyy'"></td>
                        <td style="text-align: left;" ng-bind="contas.ct_nome"></td>
                        <td style="text-align: right;" ng-bind="contas.ct_valor | currency: 'R$ '"></td>
                        <td style="text-align: center;" ng-bind="contas.dc_sigla"></td>
                    </tr>
                </tbody>
            </table>

            <div ng-if="arrayNull == true">
                <div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
                    Aguarde... Pesquisando!
                </div>
            </div>
        </div>

        <div class="card-footer p-2 pt-0">
            <div class="form-row align-items-center">
                <div class="col-12" style="text-align: left;">
                    <!--
                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #de0000"></button>
                        <span class="col-auto">Vencidas: <b class="col-auto">{{valorVencido | currency: 'R$ '}}</b></span>
                    </div>

                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #0034cf"></button>
                        <span class="col-auto">Vencendo hoje: <b class="col-auto">{{valorHoje | currency: 'R$ '}}</b></span>
                    </div>

                    <div class="row justify-content-start">
                        <button type="button" class="btn btn-sm" style="background-color: #000"></button>
                        <span class="col-auto">A Vencer: <b class="col-auto">{{valorAVencer | currency: 'R$ '}}</b></span>
                    </div>-->
                </div>
            </div>
        </div>
    </md-content>
    <dir-pagination-controls pagination-id="tabela2" max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
</md-tab>
