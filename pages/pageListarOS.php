<md-tab label="ORDENS DE SERVIÇO">
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
                <!--div class="col-auto ml-2">
                    <label for="dataI">Período </label>
                </!--div>
                <div-- class="col-auto">
                    <input date-range-picker id="daterange2" name="daterange2" class="form-control form-control-sm date-picker" type="text"	min="'2001-01-01'" max="'2100-12-31'" ng-model="date" required/>
                    <md-tooltip md-direction="top" md-visible="tooltipData">Clique em Pesquisar</md-tooltip>
                </div-->
                <div class="col-auto"> 
                    <input type="text" value="" class="form-control form-control-sm" id="buscaCliente" ng-model="buscaCliente" placeholder="Todos os Clientes">
                </div>

                <div class="col-auto"> 
                    <input type="text" value="" class="form-control form-control-sm" id="buscaPedido" ng-model="buscaPedido" placeholder="Todos os Pedidos">
                </div>

                <div class="col-auto" ng-init="situacaoOS = 1">
                    <select class="form-control form-control-sm" id="situacaoOS" ng-model="situacaoOS">
                        <!-- <option ng-value="0">Todas as O.S.</option> -->
                        <option ng-value="1">Somente Abertas</option>
                        <!--<option ng-value="2">Fechadas Sem Faturar</option>
                        <option ng-value="3">Faturadas</option>
                        <option ng-value="4">Atrasadas</option> -->
                    </select>
                </div>

                <div class="col-auto" ng-init="itensPagina = 10">
                    <select class="custom-select custom-select-sm" id="itensPagina" ng-model="itensPagina">
                        <option ng-value="10" ng-selected="true">10</option>
                        <option ng-value="20">20</option>
                        <option ng-value="50">50</option>
                    </select>
                </div>
                <div class="ml-auto m-0 ">
                    <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="modificaBusca(empresa, buscaCliente, buscaPedido, situacaoOS, itensPagina)" style="color: white;">
                        <md-tooltip md-direction="top" md-visible="tooltipVisible">Pesquisar</md-tooltip>
                        <i class="fas fa fa-search" ></i> Pesquisar
                    </md-button>
                </div>
            </div>
        </form>

        <div class="table-responsive p-0" style="overflow: hidden;">
            <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                <thead class="thead-dark" >
                    <tr>
                        <th scope="col" style="font-weight: normal; text-align: left; vertical-align: middle !important;" ng-click="ordenar('os_num')">Número</th>
                        <th scope="col" style="font-weight: normal; text-align: left; vertical-align: middle !important;" ng-click="ordenar('os_voltagem')">Num Pedido</th>
                        <th scope="col" style="font-weight: normal; text-align: left; vertical-align: middle !important;" ng-click="ordenar('os_data')">Emissão</th>
                        <!--th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('os_cliente')">Cliente</!--th-->
                        <th scope="col" style="font-weight: normal; text-align: left; vertical-align: middle !important;" ng-click="ordenar('os_nome')">Nome</th>
                        <th scope="col" style="font-weight: normal; text-align: right; vertical-align: middle !important;" ng-click="ordenar('os_total')">Valor Total</th>
                        <th scope="col" style="font-weight: normal; text-align: center;"> Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="os in ordemServico | orderBy:'sortKey':reverse | itemsPerPage:pageSize" ng-class="os.situacao == 'Aberta' ? 'aberta' : os.quitado == 'S' ? 'quitada' : (os.bloq != '' && os.bloq != 'null') ? 'faturado' : os.atrasado == 'SIM' ? 'atrasado' : 'faturado'" ng-dblclick="(os.situacao == 'Fechada' && os.quitado == 'N') ? abrirConta(os) : ''" pagination-id="tabela1">
                        <td style="text-align: left;" ng-bind="os.os_num"></td>
                        <td style="text-align: left;" ng-bind="os.os_voltagem"></td>
                        <td style="text-align: left;" ng-bind="os.os_data | date: 'dd/MM/yyyy'"></td>
                        <!--td style="max-width: 180px;" ng-bind="os.os_cliente" class="d-inline-block text-truncate"></!--td-->
                        <td style="max-width: 350px;" ng-bind="os.os_nome" class="d-inline-block text-truncate"></td>
                        <td style="text-align: right;" ng-bind="os.os_total | currency:'R$ '"></td>
                        <td style="text-align: center;" ng-bind="(os.situacao) + (os.situacao == 'Aberta' ? '' : os.quitado == 'S' ? ' / Quitada' : (os.bloq != '' && os.bloq != 'null') ? ' / Faturada' : os.atrasado == 'SIM' ? ' / Atrasada' : ' / Não Faturada')"></td>
                    </tr >
                </tbody>
            </table>

            <div ng-if="arrayNull == true">
                <div class="alert-conta alert-primary col-lg-4" role="alert" style="width:100% !important;">
                    <h4 style="color: black !important;"> Aguarde! Pesquisando...</h4>
                </div>
            </div>
        </div>
        <div class="card-footer p-0">
            <div class="form-row align-items-center">
                <div class="col-9 pl-0" style="text-align: left;">
                    <!--
                    <div class="row justify-content-start pt-0">
                        <span class="col-auto" style="color: gray;">Legendas</span>
                    </div>
                    <div class="row justify-content-start pt-0 pb-2">
                        <div class="col-4">
                            <button type="button" class="btn btn-sm" style="background-color: red"></button><span class="col-auto" style="color: gray;"> O.S. Faturada e Atrasada</span>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-sm" style="background-color: black"></button><span class="col-auto" style="color: gray;"> O.S. Fechada</span>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-sm" style="background-color: green"></button><span class="col-auto" style="color: gray;"> O.S. Aberta</span>
                        </div>
                    </div>-->
                </div>
                <div class="col-3" style="text-align: right;" ng-if="situacaoOS == ''">
                    <span style="color: gray;">Registros: <b>{{ordemServico.length}}{{situacaoOS}}</b></span>
                </div>
            </div>
        </div>
    </md-content>
    <dir-pagination-controls pagination-id="tabela1" max-size="5" boundary-links="true" class="ng-isolate-scope"></dir-pagination-controls>
</md-tab>