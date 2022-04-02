<!--Modal confirmar adicional-->

<div class="modal fade" id="confirmarAdicionais" tabindex="-1" aria-labelledby="confirmarAdicionais" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:rgba(0,0,0, 0.8) !important;">
      <div class="modal-header">
        <!--h5 class="modal-title" id="confirmarAdicionais">Adicionais</h5-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center><h5>Cadastrar adicionais ao produto?</h5></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="alertaAdicionais('N')">Não</button>
        <button type="button" class="btn btn-primary" ng-click="alertaAdicionais('S')">Sim</button>
      </div>
    </div>
  </div>
</div>



<!--Fim-->
<form id="formProdutos" ng-submit="AdicionarProduto()" ng-repeat="produto in produto" autocomplete="off">
    <md-tabs md-selected="selectedIndex" md-dynamic-height md-border-bottom>

        <md-tab label="Principal">
            <md-content class="md-padding" style="background-color:rgba(0,0,0, .65) !important;">
                <div class="media">
                    <figure>
                        <p><img class="align-self-start mr-3" src="{{urlImage}}" alt="Imagem do Produto" type="button" width="240" height="240" data-toggle="modal" data-target="#ModalImagem">
                        <figcaption>Clique na Imagem para Alterar</figcaption>
                    </figure>
                    <input type="hidden" class="form-control" ng-value="produto.pd_foto_url" ng-model="pd_foto_url" value="{{urlImage}}">
                    <div class="media-body">
                        <div class="form-row">                       
                            <div class="form-group col-auto mr-3 align-self-center">
                            <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input pull-right" id="pd_lanca_site" ng-model="lancar_site" ng-disabled="campo" ng-change="alterar_lanca_site(lancar_site);">Cadastro Ativo
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-auto align-self-center">
                                <div class="form-check-inline" ng-show="ramo == 2">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="st" ng-value="produto.pd_st" ng-model="produto.pd_st" ng-disabled="campo">Produto com Substituição Tributaria
                                        
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
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label for="">Sub-Grupo </label>
                                <select class="form-control form-control-sm" ng-model="produto.pd_subgrupo" id="pd_subgrupo" ng-disabled="campo" value=""> 
                                    <option ng-repeat="sub in dadosSubGrupo" ng-value="sub.sbp_codigo" ng-selected="'produto.pd_subgrupo'">{{sub.sbp_descricao}}</option>
                                </select>
                            </div>

                            <div class="form-group col-2" ng-show="ramo == 2">
                                <label for="">Cód. Barras (EAN)</label>
                                <input type="text" class="form-control form-control-sm" id="pd_ean" ng_model="produto.pd_ean" ng-disabled="campo" onkeypress='return somenteNumeros(event)'>
                            </div>
                            <div class="form-group col-2" ng-show="ramo == 2">
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
                            <!--<div-- class="form-group col-3">
                                <label for="">Localização</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_localizacao" id="pd_localizacao" ng-disabled="campo">
                            </div-->
                            <div class="form-group col-2" ng-show="ramo == 2">
                                <label for="">NCM</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_ncm" id="pd_ncm" ng-disabled="campo">
                            </div>
                        
                            <!--div class="form-group col-1">
                                <label for="">CSOSN</label>
                                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_csosn" id="pd_csosn" ng-disabled="campo">
                            </div-->
                            <div class="form-group col-3" ng-show="ramo == 2">
                                <label for="">Custo do Produto</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-value="produto.pd_custo" ng-model="produto.pd_custo" id="pd_custo" ng-blur="markup(produto.pd_custo, produto.pd_vista, produto.pd_prazo)" required ng-disabled="campo" money-mask>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Preço a Vista</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-value="produto.pd_vista" ng-model="produto.pd_vista" id="pd_vista" ng-blur="markup(produto.pd_custo, produto.pd_vista, produto.pd_prazo)" required ng-disabled="campo" money-mask>
                            </div>
                            <!--<div class="form-group col-3">
                                <label for="">Preço a Prazo</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-model="produto.pd_prazo | currency: 'R$ '" id="pd_prazo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" ng-disabled="campo" money-mask>
                            </div>-->
                            <div class="form-group col-3" ng-show="ramo == 2">
                                <label for="">Mark-up %</label>
                                <input type="text" class="form-control form-control-sm text-right" ng-value="produto.pd_markup | currency: ''" ng-model="produto.pd_markup" id="pd_markup" required ng-disabled="true">
                            </div>

                            <div class="form-group col-3" style="margin-top:-80px">
                                <label for="">Composição</label>
                                <textarea class="form-control form-control-sm capoTexto" name="" id="" rows="5" ng-model="produto.pd_composicao" ng-bind="produto.pd_composicao"></textarea>
                            </div>
                        </div>
                        <button type="reset" class="btn btn-outline-danger" style="color: white;" ng-click="sairCadastro()"><i class="fas fa-window-close"></i> Cancelar</button>
                        <button type="submit" class="btn btn-outline-success" style="color: white;" ng-show="!campo"><i class="fas fa-save"></i> Salvar</button-->
                    </div>
                </div>
                </md-content>
        </md-tab>
<!--/form-->
        <?php
            if (base64_decode($em_ramo) != 1) {
                
        ?>
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

        <?php
            }
        ?>
        <md-tab label="Adicionais" ng-if="abaAdicional == true">
            <md-content class="md-padding" style="background-color:rgba(0,0,0, .65) !important;">

                <div class="form-row align-items-center p-0 m-0">
					<div class="col-auto">
                        <md-button class="btnInserir" style="border: none;" data-toggle="modal" data-target="#ModalExcecaoLista" ng-click="pesquisarExcecao()" style="color: white;">
                            <md-tooltip md-direction="top" md-visible="tooltipVisible"> Inserir Adicionais</md-tooltip>
                            <i class="fas fa fa-search" ></i> Inserir Adicionais ao Produto
                        </md-button>
                    </div>
                    <!--div class="ml-auto m-0 p-0">
                        <md-button class="btnPesquisar pull-right" style="border: none;" ng-click="cadastrarAdicional()" style="color: white;">
                            <md-tooltip md-direction="top" md-visible="tooltipVisible"> Cadastrar Adicional</md-tooltip>
                            <i class="fas fa-plus" ></i>  Cadastrar Adicional
                        </md-button>
                    </div-->
                </div>

                <div class="table-responsive p-0 mb-2" style="overflow: hidden;">
					<table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black; cursor: pointer;">
						<thead class="thead-dark">
							<tr style="font-size: 1em !important;">
                                <th scope="col" style=" font-weight: normal; text-align: left;">Código</th>
                                <th scope="col" style=" font-weight: normal; text-align: left;">Descricão</th>
                                <th scope="col" style=" font-weight: normal; text-align: right;">Valor</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;">Adicional / Exceção</th>
                                <th scope="col" style=" font-weight: normal; text-align: center;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="adicional in adicionalExcecao">
                                <td style="text-align: left">{{adicional.ex_cod}}</td>
                                <td style="text-align: left">{{adicional.ex_desc}}</td>
                                <td style="text-align: right">{{adicional.ex_valor | currency: 'R$ '}}</td>
                                <td style="text-align: center">{{adicional.ex_tipo}}</td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-outline-light p-0" style="border-width: 0; color: black;" ng-click="removerExcecaoProd(adicional)">
                                    <i class="fas fa-minus-circle"></i> Remover
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="reset" class="btn btn-outline-danger" style="color: white;" ng-click="sairCadastro()"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button type="submit" class="btn btn-outline-success" style="color: white;" ng-show="!campo"><i class="fas fa-save"></i> Salvar</button-->
                </div>
            </md-content>
        </md-tab>
    </md-tabs>

<form>
            <!--<img src="{{urlImage}}" alt="" style="float: left; margin-right:10px; border-radius: 10px; width:100px;">
            <input type="hidden" class="form-control"  ng-model="produto.pd_foto_url" value="{{urlImage}}">
            
            <div class="form-group col-1" ng-show="true">
                <label>Imagem</label>
                <button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
                    <i class="far fa fa-image"></i>
                </button>
            </div>

            <div class="form-group col-1">
                <label >Código</label>
                <input type="text" class="form-control form-control-sm" id="pd_cod" ng-model="produto.pd_cod" ng-disabled="true" onkeypress='return somenteNumeros(event)' autocomplete="off">
            </div>
            <div class="form-group col-3">
                <label for="">Cód. Barras (EAN)</label>
                <input type="text" class="form-control form-control-sm" id="pd_ean" ng_model="produto.pd_ean" ng-disabled="campo" onkeypress='return somenteNumeros(event)' autocomplete="off">
            </div>
            <div class="form-group col-3">
                <label for="">Cód. Interno</label>
                <!--input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-change="verificaCodigo('pd_codinterno', produto.pd_codinterno)" ng-model="produto.pd_codinterno" required ng-disabled="campo"
                <input type="text" class="form-control form-control-sm" id="pd_codinterno" ng-model="produto.pd_codinterno" ng-disabled="campo" onkeypress='return somenteNumeros(event)' autocomplete="off">
            </div>
            <div class="form-group col-2">
                <label for="">UN</label>
                <input type="text" class="form-control form-control-sm" id="pd_un" ng-model="produto.pd_un" required ng-disabled="campo">
            </div>
            <div class="col-4" style="margin-top:10px;">
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="pd_lanca_site" ng-model="produto.pd_lanca_site" ng-disabled="campo" ng-checked="produto.pd_lanca_site == 'S'">Ativo
                        <input type="checkbox" class="form-check-input" id="st" ng-model="produto.pd_st" ng-disabled="campo">Substituição Tributaria
                        <!--input type="checkbox" class="form-check-input" id="pd_lanca_site" ng-model="produto.pd_lanca_site" ng-disabled="campo">PDV
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <!--input type="checkbox" class="form-check-input" id="pd_disk" ng-model="produto.pd_disk" ng-disabled="campo">Online
                    </label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-8">
                <label for="">Descrição</label>
                <input type="text" class="form-control form-control-sm capoTexto" ng-model="produto.pd_desc" id="pd_desc" required ng-disabled="campo" autocomplete="off">
            </div>
            <div class="form-group col-2">
                <label for="">Sub-Grupo </label>
                <select class="form-control form-control-sm" ng-model="produto.pd_subgrupo" id="pd_subgrupo" ng-disabled="campo" value="">
                    
                    <option ng-repeat="sub in dadosSubGrupo" ng-value="sub.sbp_codigo" ng-selected="'produto.pd_subgrupo'">{{sub.sbp_descricao}}</option>
                </select>
            </div>
            <div class="form-group col-2">
                <label for="em_end">Marca</label>
                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_marca" id="pd_marca" ng-disabled="campo" autocomplete="off">
            </div>
        </div>

        <div layout="row" layout-xs="column">
            <div flex="">
                <div layout="row">
                    <div flex="">
                        <label for="">NCM</label>
                        <input type="text" class="form-control form-control-sm" ng-model="produto.pd_ncm" id="pd_ncm" ng-disabled="campo" autocomplete="off">
                    </div>
                    
                </div>

                <div layout="row">
                    <div flex="">
                        <label for="">Custo</label>
                        <input type="text" class="form-control form-control-sm" ng-model="produto.pd_custo" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" id="pd_custo" required ng-disabled="campo" money-mask style="text-align: right;" autocomplete="off">
                    </div>

                    <div flex="">
                        <label for="">Preço a Vista</label>
                        <input type="text" class="form-control form-control-sm" ng-model="produto.pd_vista" id="pd_vista" ng-blur="markup(produto.pd_custo,produto.pd_vista,produto.pd_prazo)" required ng-disabled="campo" money-mask style="text-align: right;" autocomplete="off">
                    </div>

                    <div flex="">
                        <label for="">Mark-up %</label>
                        <input type="text" class="form-control form-control-sm" ng-model="produto.pd_markup" id="pd_markup" required ng-disabled="true" style="text-align: right;" autocomplete="off">
                    </div>
                    
                </div>

            </div>

            <div flex="" style="margin-left:15px;">
                <label for="">Composição</label>
                <textarea class="form-control form-control-sm" name="" id="" cols="30" rows="4" ng-model="produto.pd_composicao" ng-bind="produto.pd_composicao"></textarea>
            </div>

        </div>
        <div class="form-row">
            
           

            <div class="form-group col-1">
                <!--label for="">Localização</label-->
                <input type="hidden" class="form-control form-control-sm" ng-model="produto.pd_localizacao" id="pd_localizacao" ng-disabled="campo" autocomplete="off">
           <!-- </div>
            div class="form-group col-1">
                <label for="">NCM</label>
                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_ncm" id="pd_ncm" ng-disabled="campo">
            </div>
            <!--div class="form-group col-1">
                <label for="">CSOSN</label>
                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_csosn" id="pd_csosn" ng-disabled="campo">
            </div>
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
            <!--div class="form-group col-11">
                <label for="">Observação</label>
                <input type="text" class="form-control form-control-sm" ng-model="produto.pd_observ" id="pd_observ" ng-disabled="campo">
            </!--div-->
            <!--div class="form-group col-1" ng-show="true">
                <label>Imagem</label>
                <button type="button" class="form-control form-control-sm btn btn-outline-light" data-toggle="modal" data-target="#ModalImagem">
                    <i class="far fa fa-image"></i>
                </button>
            </div
        </div>

        <button type="reset" class="btn btn-outline-danger" style="color: white;" ng-click="sairCadastro()"><i class="fas fa-window-close"></i> Cancelar</button>
        <button type="submit" class="btn btn-outline-success" style="color: white;" ng-show="!campo"><i class="fas fa-save"></i> Salvar</button>

        <?php

        //include 'Modal/ImagemProduto.php';

        ?>
    </div>
</form>-->