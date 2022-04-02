

<!--div class="modal fade" id="ModalLancarDespesas" tabindex="-1" role="dialog" aria-labelledby="ModalLancarDespesas" aria-hidden="true" data-backdrop="static"-->
<div>
  <div class="modal-dialog modal-lg" role="document" style="color: black;" >
    <div class="modal-content" style="box-shadow: -0.5em 0.5em 0.5em rgba(0,0,0,0.5);">
      <div class="modal-header">
        <h3 class="mb-0" style="color: black !important;" >Lançamento Rápido de Despesas</h3>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="formConta">
            <div class="row">
              <div class="form-group col-2" >
                <label for="numDocumento">Documento</label>
                <input type="text" class="form-control" id="numDocumento" ng-model="despesa.ct_docto">
                <!--<input type="hidden" class="form-control" ng-value="empresa" ng-model="despesa.ct_empresa">-->
                <input type="hidden" class="form-control" id="numDocumento" ng-model="despesa.ct_matriz">
              </div>
              <div class="form-group col-md-4">
                <label for="ct_emissao">Data Emissão</label>
                <input type="date" class="form-control" id="ct_emissao" value="{{ct_emissao}}" ng-model="despesa.ct_emissao">
              </div>
              <div class="form-group col-md-6" >
                <label for="formaPagto">Forma de Pagamento</label>
                <select class="form-control" id="formaPagto" ng-model="despesa.ct_tipdoc" ng-change="ConsultaCaixa(despesa.ct_tipdoc)" ng-blur="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)">
                  <option value="">Selecione a Forma de Pagamento</option>
                  <option ng-repeat="forma in dadosFormaPagto" ng-value="forma.dc_codigo">{{forma.dc_descricao}} </option>
                </select>
              </div>
              <div class="form-group col-4" >
                <label for="selectEmpresa">Despesa Referente a Empresa</label>
                <select class="form-control" id="selectEmpresa" ng-model="despesa.ct_empresa" name="select-simples-empresa" ng-disabled="despesa.ct_rateia">
                  <option value="">Selecione a Empresa</option>
                  <option ng-repeat="empresa in dadosEmpresa" ng-value="empresa.em_cod">{{empresa.em_fanta}}</option>
                </select>
              </div> 
              <div class="form-group col-2 text-center" >
                <label for="checkRatear">Ratear?</label>
                <div class="form-check">
                  <input class="form-check-input text-center" type="checkbox" value="" id="checkRatear" ng-model="despesa.ct_rateia" ng-disabled="despesa.ct_empresa">
                  <!-- FALTA DECIDIR COMO A DESPESA SERÁ RATEADA -->
                </div>
              </div>
              <div class="form-group col-6">
                <label for="selectFornecedor">Fornecedor</label>
                <div class="input-group">
                  <select class="form-control" id="selectFornecedor" ng-model="despesa.ct_cliente_forn" name="select-simples-grande">
                    <option value="">Selecione o Fornecedor</option>
                    <option ng-repeat="fornecedor in dadosFornecedores | filter:{pe_empresa:<?=base64_decode($empresa)?>}" ng-value="fornecedor.pe_id">{{fornecedor.pe_nome}}</option>
                  </select>
                  
                  <input type="hidden" class="form-control" id="inputFornecedor" ng-value="fornecedor.pe_nome" ng-model="despesa.ct_nome">
                  <div class="input-group-btn">
                    <a href="CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>" class="btn btn-outline-light" style="color: black;" data-toggle="tooltip" data-placement="top" title="Adicionar Fornecedor" ng-click="goPagina()">
                      <i class="fas fa fa-plus"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-12" >
                <label for="histPagto">Descrição da Despesa</label>
                <input type="text" class="form-control" id="descHistorico" ng-model="despesa.ct_obs" onKeyUp="tabenter(event,getElementById('inputValor'))" style="text-transform: capitalize">
              </div>
              <div class="form-group col-md-4">
                <label for="inputValor">Valor Principal</label>
                <input type="text" class="form-control" id="inputValor" ng-model="despesa.inputValor" onKeyUp="tabenter(event,getElementById('histPagto'))" money-dir>
              </div>
              <div class="form-group col-md-6" >
                <label for="histPagto">Histórico Pagamento</label>
                <select class="form-control" id="histPagto" ng-model="despesa.ct_historico" ng-change="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" value="" onKeyUp="tabenter(event,getElementById('qtdParcelas'))">
                  <option value="">Selecione o Histórico</option>
                  <option ng-repeat="historico in dadosHistorico | filter:{ht_empresa:<?=base64_decode($empresa)?>}" value="{{historico.ht_id}}" ng-if="historico.ht_dc == 'D'" >{{historico.ht_descricao}} </option>
                </select>

              </div>
              <div class="form-group col-md-2" ng-init="qtdParcelas = 1">
                <label for="qtdParcelas">Qtde. Parcelas</label>
                <input type="number" class="form-control" id="qtdParcelas" value = "1" ng-model="qtdParcelas" ng-blur="numParcelasNota(dataI | date :'yyyy-MM-dd', despesa.inputValor, qtdParcelas, despesa.ct_tipdoc)" onKeyUp="tabenter(event,getElementById('dataVencto'))">
              </div>
            </div>

            <div class="row" ng-show="dinheiro">
              <div class="col-4 mt-0" >
                <md-switch ng-model="selecionarCaixa" class="fa-pull-right" ng-disabled="qtdParcelas != 1">
                Lançar no Caixa
                </md-switch>
              </div>
              <div class="col-8" ng-show="selecionarCaixa">
                <select class="form-control" id="caixa" ng-model="bc_codigo" >
                  <option value="">Selecione o Caixa</option>
                  <option ng-repeat="caixa in CaixasAbertos | filter:{bc_cod_func:'<?=base64_decode($us_cod)?>'}" ng-value="caixa.bc_codigo">{{caixa.bc_descricao}} </option>
                </select>
              </div>
            </div>

            <div class="row" ng-repeat="parc in notaParcelas" ng-if="despesa.ct_historico">
              <div class="form-group col-md-2" >
                <label for="numParcela">Parcela</label>
                <input type="text" class="form-control" id="numParcela" ng-model="parc.vezes" readonly>
              </div>
              <div class="form-group col-md-5" >
                <label for="dataVencto">Vencimento</label>
                <input type="date" class="form-control" id="dataVencto" value="{{parc.vencimento | date :'yyyy-MM-dd'}}" ng-model="vencimento" ng-change="parcelaData(parc,vencimento | date :'yyyy-MM-dd')">
              </div>
              <div class="form-group col-md-5" >
                <label for="valParcela">Valor por Parcela</label>
                <input type="text" class="form-control" id="valParcela" ng-value="parc.parcela | currency: 'R$ '" ng-model="parcela" readonly>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-lg btn-secondary" ng-click="LimpaItens()">Cancelar</button>
        <button type="button" class="btn btn-lg btn-primary" ng-click="AdicionarDespesa(despesa, selecionarCaixa, bc_codigo, vencimento | date: 'yyyy-MM-dd')" ng-if="despesa.ct_docto && despesa.ct_tipdoc && despesa.ct_empresa && despesa.ct_historico && notaParcelas[0].vezes && despesa.ct_cliente_forn">Lançar Despesa</button>

      </div>
    </div>
  </div>
</div>
