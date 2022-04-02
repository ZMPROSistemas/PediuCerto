<form id="formProdutos" ng-submit="AdicionarProduto()" ng-repeat="produto in produto">
							
    <md-tabs md-dynamic-height md-border-bottom>

        <md-tab label="Principal">
            <md-content class="md-padding">
                
                <div class="jumbotron p-3">

                        <div class="form-row"ng-ini>
                            
                            <img src="{{urlImage}}" alt="" style="float: left; margin-right:10px; border-radius: 10px; width:100px;">
                            <input type="hidden" class="form-control"  ng-model="produto.pd_foto_url" value="{{urlImage}}">

                            <div class="form-group col-1" ng-show="true">
                                <label>Imagem</label>
                                <button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
                                    <i class="far fa fa-image"></i>
                                </button>
                            </div>
                            
                            <div class="form-group col-2">
                                <label >Código</label>
                                <input type="text" class="form-control form-control-sm" id="pd_cod" ng-model="produto.pd_cod" ng-disabled="true" onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Cód. Barras (EAN)</label>
                                <input type="text" class="form-control form-control-sm" id="pd_ean" ng_model="produto.pd_ean" ng-disabled="campo" onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Cód. Interno</label>
                                <!--input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-change="verificaCodigo('pd_codinterno', produto.pd_codinterno)" ng-model="produto.pd_codinterno" required ng-disabled="campo"-->
                                <input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-model="produto.pd_codinterno" ng-disabled=" campo"onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-1">
                                <label for="">UN</label>
                                <input type="text" class="form-control form-control-sm" id="pd_un" ng-model="produto.pd_un" required ng-disabled="campo">
                            </div>
                            <div class="col-4" style="margin-top:10px;">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="pd_lanca_site" ng-model="produto.pd_lanca_site" ng-disabled="campo" ng-checked="produto.pd_lanca_site == 'S'">Ativo
                                        <input type="checkbox" class="form-check-input" id="st" ng-model="produto.pd_st" ng-disabled="campo">Substituição Tributaria
                                        <!--input type="checkbox" class="form-check-input" id="pd_lanca_site" ng-model="produto.pd_lanca_site" ng-disabled="campo">PDV-->
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <!--input type="checkbox" class="form-check-input" id="pd_disk" ng-model="produto.pd_disk" ng-disabled="campo">Online-->
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-8">
                                <label for="">Descrição</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_desc" id="pd_desc" required ng-disabled="campo">
                            </div>
                            <div class="form-group col-2">
                                <label for="">Sub-Grupo </label>
                                <select class="form-control form-control-sm" ng-model="produto.pd_subgrupo" id="pd_subgrupo" ng-disabled="campo" value="">
                                    
                                    <option ng-repeat="sub in dadosSubGrupo" ng-value="sub.sbp_codigo" ng-selected="'produto.pd_subgrupo'">{{sub.sbp_descricao}}</option>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label for="em_end">Marca</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_marca" id="pd_marca" ng-disabled="campo">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-1">
                                <label for="">Localização</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_localizacao" id="pd_localizacao" ng-disabled="campo">
                            </div>
                            <div class="form-group col-1">
                                <label for="">NCM</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_ncm" id="pd_ncm" ng-disabled="campo">
                            </div>
                            <!--div class="form-group col-1">
                                <label for="">CSOSN</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_csosn" id="pd_csosn" ng-disabled="campo">
                            </div-->
                            <div class="form-group col-2">
                                <label for="">Custo</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_custo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" id="pd_custo" required ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-2">
                                <label for="">Preço a Vista</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_vista" id="pd_vista" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" required ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-2">
                                <label for="">Preço a Prazo</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_prazo" id="pd_prazo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-2">
                                <label for="">Mark-up %</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_markup" id="pd_markup" required ng-disabled="true">
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
                        </div>
                        <div class="form-row">
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
                        </div>

                        <button type="reset" class="btn btn-outline-danger" style="color: white;" ng-click="sairCadastro()"><i class="fas fa-window-close"></i> Cancelar</button>
                        <button type="submit" class="btn btn-outline-success" style="color: white;" ng-show="!campo"><i class="fas fa-save"></i> Salvar</button>
                    
<?php

//include 'Modal/ImagemProduto.php';

?>
            </div>

        </md-content>
    </md-tab>

</form>
    <md-tab label="Estoque">


        <md-content class="md-padding">
            
            <div class="jumbotron p-3">
                    
                <div class="form-row">

                    <div class="table-responsive estoque-tabe px-0" style="overflow-y:auto ; overflow-x:hidden;">
                        <table class="table table-striped" style="background-color: #FFFFFFFF; color: black;">
                            <thead class="thead-dark">
                                <tr style="font-size: 1em !important;">
                                    <th scope="col" style=" font-weight: normal; text-align: center;" ng-click="ordenar('')">Empresa</th>
                                    <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('')">Est. Min.</th>
                                    <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('')">Est. Max</th>
                                    <th scope="col" style=" font-weight: normal; text-align: left;" ng-click="ordenar('')">Est. Real</th>
                                    <th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="estoque in estoque">
                                    <td>{{estoque.em_fanta}}</td>
                                    <td style="text-align: left">{{estoque.es_estmin}}</td>
                                    <td style="text-align: left">{{estoque.es_estmax}}</td>
                                    <td>{{estoque.es_est}}</td>
                                    <td style="text-align: center;">
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-outline-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0; color: black;">
                                            <i class="fas fa-ellipsis-v"></i> 
                                        </button>
                                        <div class="dropdown-menu">
                                        
                                            <a class="dropdown-item" data-toggle="modal" data-target="#movimentacao_cardex" ng-click="restMovEstoqueConsulta()">Movimentação De Estoque (CARDEX)</a>

                                        </div>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </md-content>

    </md-tab>
</md-tabs>