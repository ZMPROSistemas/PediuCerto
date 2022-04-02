<form id="formProdutos" ng-submit="AdicionarProduto()" ng-repeat="produto in produto">
							
    <md-tabs md-dynamic-height md-border-bottom>

        <md-tab label="Principal">
            <md-content class="md-padding" style="background-color:rgba(0,0,0, .65) !important;">
                <div class="media">
                    <figure>
                        <p><img class="align-self-start mr-3" src="{{urlImage}}" alt="Imagem do Produto" type="button" width="240" height="240" data-toggle="modal" data-target="#ModalImagem">
                        <figcaption>Clique na Imagem para Alterar</figcaption>
                    </figure>
                    <input type="hidden" class="form-control"  ng-model="produto.pd_foto_url" value="{{urlImage}}">
                    <div class="media-body">
                        <div class="form-row">                       
                            <div class="form-group col-auto mr-3 align-self-center">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input pull-right" id="pd_lanca_site" ng-model="pd_lanca_site" ng-disabled="campo" ng-change="alterar_lanca_site(lancar_site);">Cadastro Ativo
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-auto align-self-center">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="st" ng-model="produto.pd_st" ng-disabled="campo">Produto com Substituição Tributaria
                                        <!--input type="checkbox" class="form-check-input" id="pd_lanca_site" ng-model="produto.pd_lanca_site" ng-disabled="campo">PDV-->
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label >Código</label>
                                <input type="text" class="form-control form-control-sm" id="pd_cod" ng-model="produto.pd_cod" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-7">
                                <label for="">Descrição</label>
                                <input type="text" class="form-control form-control-sm capoTexto" ng-model="produto.pd_desc" id="pd_desc" required ng-disabled="campo">
                            </div>
                            <div class="form-group col-3">
                                <label for="">Sub-Grupo </label>
                                <select class="form-control form-control-sm" ng-model="produto.pd_subgrupo" id="pd_subgrupo" ng-disabled="campo" required >
                                    <option value="">Selecione um SubGrupo</option>
                                    <option ng-repeat="sub in dadosSubGrupo" ng-value="sub.sbp_codigo" ng-selected="'produto.pd_subgrupo'">{{sub.sbp_descricao}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label for="">Cód. Barras (EAN)</label>
                                <input type="text" class="form-control form-control-sm" id="pd_ean" ng_model="produto.pd_ean" ng-disabled="campo" onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-2">
                                <label for="">Cód. Interno</label>
                                <!--input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-change="verificaCodigo('pd_codinterno', produto.pd_codinterno)" ng-model="produto.pd_codinterno" required ng-disabled="campo"-->
                                <input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-model="produto.pd_codinterno" ng-disabled=" campo"onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-1">
                                <label for="">UN</label>
                                <input type="text" class="form-control form-control-sm capoTexto" id="pd_un" ng-model="produto.pd_un" required ng-disabled="campo">
                            </div>
                            <div class="form-group col-2">
                                <label for="em_end">Marca</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_marca" id="pd_marca" ng-disabled="campo">
                            </div>
                            <div class="form-group col-3">
                                <label for="">Localização</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_localizacao" id="pd_localizacao" ng-disabled="campo">
                            </div>
                            <div class="form-group col-2">
                                <label for="">NCM</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_ncm" id="pd_ncm" ng-disabled="campo">
                            </div>
                        </div>
                        <div class="form-row">
                            <!--div class="form-group col-1">
                                <label for="">CSOSN</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_csosn" id="pd_csosn" ng-disabled="campo">
                            </div-->
                            <div class="form-group col-3">
                                <label for="">Custo do Produto</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="produto.pd_custo" id="pd_custo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" required ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Preço a Vista</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="produto.pd_vista" id="pd_vista" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" required ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Preço a Prazo</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="produto.pd_prazo" id="pd_prazo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Mark-up %</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="produto.pd_markup" id="pd_markup" required ng-disabled="true">
                            </div>
                        </div>
                            <!--div class="form-group col-1">
                                <label for="">Estoque</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.es_est" id="es_est" ng-disabled="campo">
                            </!--div>
                            <div-- class="form-group col-1">
                                <label for="">Grade</label>
                                <input type="text" class="form-control form-control-sm" vng-model="produto.pd_grade" id="pd_grade" ng-disabled="campo">
                            </div-->
                            <!--div class="form-group col-1" ng-show="true">
                                <label>Imagem</label>
                                <button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
                                    <i class="far fa fa-image"></i>
                                </button>
                            </div-->
                            <!--div class="form-group col-11">
                                <label for="">Observação</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_observ" id="pd_observ" ng-disabled="campo">
                            </!--div-->
                            <!--div class="form-group col-1" ng-show="true">
                                <label>Imagem</label>
                                <button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
                                    <i class="far fa fa-image"></i>
                                </button>
                            </div-->
 
                        <button type="reset" class="btn btn-outline-danger" style="color: white;" ng-click="sairCadastro()"><i class="fas fa-window-close"></i> Cancelar</button>
                        <button type="submit" class="btn btn-outline-success" style="color: white;" ng-show="!campo && produto.pd_subgrupo != undefined && produto.pd_subgrupo != ''"><i class="fas fa-save"></i> Salvar</button>
                    </div>
                </div>
<?php

//include 'Modal/ImagemProduto.php';

?>
            </md-content>
        </md-tab>
</form>
        <md-tab label="Estoque">
            <md-content class="md-padding" style="background-color:rgba(0,0,0, .65) !important;">
                <div class="table-responsive p-0 mb-2" style="overflow: hidden;">
					<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
						<thead class="thead-dark">
							<tr style="font-size: 1em !important;">
                                <th scope="col" style=" font-weight: normal; text-align: left;">Empresa</th>
                                <!--<th scope="col" style=" font-weight: normal; text-align: right;">Estoque Mínimo</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;">Estoque Máximo</th>-->
                                <th scope="col" style=" font-weight: normal; text-align: right;">Estoque Atual</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="estoque in estoque">
                                <td style="text-align: left">{{estoque.em_fanta}}</td>
                                <!--<td style="text-align: right">{{estoque.es_estmin | number}}</td>
                                <td style="text-align: right">{{estoque.es_estmax | number}}</td>-->
                                <td style="text-align: right">{{estoque.es_est | number}}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
                                            <i class="fas fa-ellipsis-v"></i> 
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#movimentacao_cardex" ng-click="restMovEstoqueConsulta(estoque)">Movimentação de Estoque (CARDEX)</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </md-content>
        </md-tab>
    </md-tabs>