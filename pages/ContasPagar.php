<div show-on-desktop>
    <div class="jumbotron p-3">

    <!--div class="card border-dark" style="background-color:rgba(0,0,0, .65); ">
        <div-- class="card-header">
        </div-->
        <h5>Lançar Conta a Pagar </h5>
        <form id="formConta">
    		<!--div class="card-body py-0 px-2 m-0"-->
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="numDocumento">Documento</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="proximoDocto" ng-model="proximoDocto" style="text-align:right;" onKeyUp="tabenter(event,getElementById('ct_emissao'))" ng-blur="despesa.ct_docto = proximoDocto">
                        <div class="input-group-append">
                            <a class="btn btn-outline-light btn-sm" style="color: white; border: none;" data-toggle="tooltip" data-placement="top" title="Gerar Próximo Número" ng-click="buscarProximoDocto()"><i class="fas fa-redo-alt"></i></a>
                        </div>
                        <input type="hidden" class="form-control form-control-sm" ng-value="empresa" ng-model="despesa.ct_empresa">
                        <input type="hidden" class="form-control form-control-sm" id="numMatriz" ng-model="despesa.ct_matriz">
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="ct_emissao">Data Emissão</label>
                    <input type="date" class="form-control form-control-sm" id="ct_emissao" value="{{ct_emissao}}" ng-model="ct_emissao" onKeyUp="tabenter(event,getElementById('selectFornecedor'))">
                </div>
                <div class="form-group col-md-5">
                    <label for="selectFornecedor">Fornecedor</label>
                    <div class="input-group">
                        <select class="form-control form-control-sm" id="selectFornecedor" ng-model="despesa.ct_cliente_forn" name="select-simples-grande" onKeyUp="tabenter(event,getElementById('formaPagto'))">
                            <option value="">Selecione o Fornecedor</option>
                            <option ng-repeat="fornecedor in dadosFornecedores" ng-value="fornecedor.pe_cod">{{fornecedor.pe_nome}}</option>
                        </select>
                        <input type="hidden" class="form-control form-control-sm" id="inputFornecedor" ng-value="fornecedor.pe_nome" ng-model="despesa.ct_nome">
                        <div class="input-group-btn">
                            <a href="CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>" class="btn btn-outline-light btn-sm" style="color: white; border: none;" data-toggle="tooltip" data-placement="top" title="Adicionar Fornecedor" ng-click="goPagina()">
                            <i class="fas fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3" >
                    <label for="formaPagto">Forma de Pagamento {{despesa.ct_tipdoc}}</label>
                    <select class="form-control form-control-sm" id="formaPagto" ng-model="despesa.ct_tipdoc" ng-change="ConsultaCaixa(despesa.ct_tipdoc)" ng-blur="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" onKeyUp="tabenter(event,getElementById('histPagto'))">
                        <option value="">Selecione a Forma de Pagamento</option>
                        <option ng-repeat="forma in dadosFormaPagto" ng-value="forma.dc_codigo">{{forma.dc_descricao}} </option>
                    </select>
                </div>
                <div class="form-group col-md-3" >
                    <label for="histPagto">Histórico Pagamento</label>
                    <select class="form-control form-control-sm" id="histPagto" ng-model="despesa.ct_historico" ng-change="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" value="" onKeyUp="tabenter(event,getElementById('descHistorico'))">
                        <option value="">Selecione o Histórico</option>
                        <option ng-repeat="historico in dadosHistorico | filter:{ht_empresa:<?=base64_decode($empresa)?>}" value="{{historico.ht_id}}" ng-if="historico.ht_dc == 'D'" >{{historico.ht_descricao}} </option>
                    </select>
                </div>
                <div class="form-group col-md-7" >
                    <label for="histPagto">Descrição da Despesa</label>
                    <input type="text" class="form-control form-control-sm" id="descHistorico" ng-model="despesa.ct_obs" onKeyUp="tabenter(event,getElementById('inputValor'))" style="text-transform: capitalize">
                </div>
                <div class="form-group col-md-2">
                    <label for="inputValor">Valor Principal</label>
                    <input type="text" class="form-control form-control-sm" style="text-align:right;" id="inputValor" ng-model="despesa.inputValor" onKeyUp="tabenter(event,getElementById('qtdParcelas'))" ng-blur="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" money-dir>
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col-auto">
                    <label for="qtdParcelas">Qtde. Parcelas</label>
                    <input type="number" class="form-control form-control-sm" style="text-align:center;" id="qtdParcelas" ng-model="qtdParcelas" ng-change="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" onKeyUp="tabenter(event,getElementById('dataVencto'))">
                </div>
                <div class="col-8 ml-auto" ng-repeat="parc in notaParcelas" ng-if="despesa.ct_historico">
                    <div class="form-row">
                        <div class="form-group col-2" >
                            <label for="numParcela">Parcela</label>
                            <h5 id="numParcela" ng-model="parc.vezes" style="text-align:center;">{{parc.vezes}}</h5>
                            <input type="hidden" class="form-control form-control-sm" id="numParcela" ng-model="parc.vezes" style="text-align:right;" readonly>
                        </div>
                        <div class="form-group col-5" >
                            <label for="dataVencto">Vencimento</label>
                            <input type="date" class="form-control form-control-sm" id="dataVencto" value="{{parc.vencimento | date :'yyyy-MM-dd'}}" ng-model="vencimento" ng-change="parcelaData(parc,vencimento | date :'yyyy-MM-dd')" onKeyUp="tabenter(event,getElementById('ct_rateia'))">
                        </div>
                        <div class="form-group col-5" >
                            <label for="valParcela">Valor por Parcela</label>
                            <input type="text" class="form-control form-control-sm" id="valParcela" ng-value="parc.parcela | currency: 'R$ '" style="text-align:right;" ng-model="parcela" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div>
            <div class="row"> 
                <div class="form-group col-md-12" >
                    <md-input-container>
                        <md-select ng-model="selectedEmpresas" md-on-close="clearSearchTerm()" multiple>
                            <md-select-header class="demo-select-header">
                            <input ng-model="searchTerm" aria-label="Vegetable filter"
                                    type="search" placeholder="Empresas"
                                    class="demo-header-searchbox md-text">
                            </md-select-header>
                            <md-optgroup label="empresa.em_cod">
                            <md-option ng-value="empresa.em_cod" ng-repeat="empresa in dadosEmpresa ">
                                {{empresa.em_fanta}}
                            </md-option>
                            </md-optgroup>
                        </md-select>
                    </md-input-container>
                </div>
            </div-->
            <hr class="tracejado" ng-if="listaPRC[0]"></hr>
            <div class="form-row" ng-if="listaPRC[0]"> <!-- FAZER NG-IF SE HÁ FILIAIS 
                <div class="form-group col-md-12" >-->
                <div class="form-group col-4">
                    <label for="despesa.ct_rateia">Ratear Conta?</label>
                    <select class="form-control form-control-sm" id="ct_rateia" ng-model="despesa.ct_rateia" name="despesa.ct_rateia" data-toggle="tooltip" data-placement="top" title="Informe se esta conta deverá ser dividida entre as filiais." onKeyUp="tabenter(event,getElementById('lancarCaixa'))">
                        <option value="">Selecione uma opção</option>
                        <option value="S">Sim, vou ratear esta conta entre várias Filiais</option>
                        <option value="N">Não. Esta conta se refere a apenas 1 empresa ou loja</option>
                    </select>
                </div>
                <div class="col-8 mr-auto" ng-show="despesa.ct_rateia == 'N'">
                    <div class="form-row col-auto">
                        <label for="selectEmpresa">Conta Referente a qual Empresa?</label>
                        <select class="form-control form-control-sm" id="selectEmpresa" ng-model="despesa.ct_empresa" name="select-simples-empresa">
                            <option value="">Selecione a Empresa</option>
                            <option ng-repeat="empresa in dadosEmpresa" ng-value="empresa.em_cod">{{empresa.em_fanta}}</option>
                        </select>
                    </div>
                </div>
            <!--/div-->
                <!--    NG-REPEAT COM AS EMPRESAS QUE ESTÃO NA TABELA 
                        PERC_RATEIO_CONTAS UTILIZANDO O PERCENTUAL CALCULADO ALI -->
                <div class="col-8 ml-auto" ng-show="despesa.ct_rateia == 'S'" ng-repeat="rateia in listaPRC">
                    <div class="form-row">
                        <div class="form-group col-4" >
                            <label for="prcEmpresa">Empresa</label>
                            <input type="text" class="form-control form-control-sm" id="prcEmpresa" value="{{rateia.em_fanta}}" disabled>
                        </div>
                        <div class="form-group col-4">
                            <label for="prcPercentual">Percentual</label>
                            <input type="text" class="form-control form-control-sm" id="prcPercentual" style="text-align:right;" value="{{rateia.prc_percentual | number: 2}}%" disabled>
                        </div>
                        <div class="form-group col-4">
                            <label for="prcValorEmpresa">Valor por Empresa</label>
                            <input type="text" class="form-control form-control-sm" id="prcValorEmpresa" style="text-align:right;" value="{{(rateia.prc_percentual * (valorConta / 100)) | number:2}}" disabled>
                        </div>
                        <!--div class="ml-auto m-0 p-0 align-self-center">
                            <md-button class="btnExcluir pull-right" style="border: 1px solid red; border-radius: 5px;" ng-click="removerLinhaEmpresa()">
                                <md-tooltip md-direction="top" md-visible="tooltipVisible">Remover esta Filial do Rateio</md-tooltip>
                                <i class="fas fa-trash" ></i> Remover
                            </md-button>
                        </!--div-->
                    </div>
                </div>
            </div>
            <hr class="tracejado" ng-show="dinheiro && qtdParcelas == 1"></hr>
            <div class="form-row">
                <div class="form-group col-md-4" ng-if="false">
                    <label for="lancarCaixa">Esta conta já está quitada?</label>
                    <select class="form-control form-control-sm" id="lancarCaixa" ng-model="lancarCaixa" onKeyUp="tabenter(event,getElementById('caixa'))">
                        <option value="">Escolha uma Opção</option>
                        <option value="false">Não. Apenas lançar no Contas a Pagar</option>
                        <option value="true">Sim. Quero aproveitar e dar baixa na conta agora</option>
                    </select>
                </div>
                <div class="form-group col-md-2" ng-show="dinheiro && qtdParcelas == 1">
                    <label for="lancarCaixa">Dar baixa por qual caixa?</label>
                    <select class="form-control form-control-sm" id="caixa" ng-model="bc_codigo" onKeyUp="tabenter(event,getElementById('dataPagto'))">
                        <option value="">Selecione o Caixa</option>
                        <option ng-repeat="caixa in CaixasAbertos" ng-value="caixa.bc_codigo">{{caixa.bc_descricao}} </option>
                    </select>
                </div>
                <div class="form-group col-md-3" ng-show="bc_codigo">
                    <label for="dataPagto">Data do Pagamento</label>
                    <input type="date" class="form-control form-control-sm" id="dataPagto" value="{{dataBaixa}}" ng-model="dataBaixa" onKeyUp="tabenter(event,getElementById('valorPago'))">
                </div>
                <!--div class="form-group col-md-3">
                    <label for="valorPago">Valor Pago</label>
                    <input type="text" class="form-control form-control-sm" id="valorPago" value="{{despesa.inputValor}}" ng-model="valorPago" onKeyUp="tabenter(event,getElementById('btnSalvar'))" money-dir>
                </!--div>
            </div-->
            </div>
            <div class="form-row">
                <md-button class="btnCancelar" onclick="window.location.reload()" style="border: 1px solid red; border-radius: 5px;"><i class="fas fa-window-close"></i> Cancelar</md-button>
                <md-button class="btnSalvar" style="border: 1px solid green; border-radius: 5px;" id="btnSalvar" ng-click="AdicionarDespesa(despesa, bc_codigo, dataBaixa | date: 'yyyy-MM-dd')" ng-if="despesa.ct_docto && despesa.ct_tipdoc && (!dinheiro || bc_codigo) && despesa.ct_historico && notaParcelas[0].vezes && despesa.ct_cliente_forn"><i class="fas fa-save"></i> Lançar Conta</md-button>
            </div>
        </form>
    </div>
</div>
 