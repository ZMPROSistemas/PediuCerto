<style>
    md-checkbox.md-default-theme.md-checked .md-icon, 
    md-checkbox.md-checked .md-icon{
        background-color: #2957A4;
    }
</style>
<div class="modal fade" id="bairros" tabindex="-1" role="dialog" aria-labelledby="bairros" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="width:600px; align:center;">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black !important;">Bairros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<div class="form-row align-items-center"> -->
                <div class="form-row">
                    <!--<div class="col-auto" style="color:#000;"> -->
                    <div class="col-12" style="color:#000;">
                        <label>Pesquisar</label>
                    </div>

                    <div class="col-9">
                        <input type="text" value="" class="form-control form-control-sm" id="buscaBairros" ng-model="buscaBairros" placeholder="Todos os Bairros">                        
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-info" ng-click="addBairroBanco(buscaBairros)" ng-show="buscaBairros!=''">Adicionar Bairro</button>
                    </div>

                </div>

                <div class="table-responsive p-0 mb-0" style="max-height:350px; overflow-y: auto; margin-top:15px;">
                    <table class="table table-sm table-striped" style="background-color: #FFFFFFFF; color: black;">
                        <thead class="thead-dark">
                            <tr style="font-size: 1em !important;">
                                <th scope="col" style="font-weight: normal; text-align: left;">
                                    <!--md-checkbox ng-model="select" ng-click="selectAll(select)">
                                        Selecionar
                                    </md-checkbox-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" ng-value="select" ng-model="select" ng-click="selectAll(select)" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Selecionar
                                        </label>
                                    </div>
                                </th>
                                <th scope="col" style="font-weight: normal; text-align: left;" ng-click="ordenar('ba_nomebairro')">Bairro</th>
                                <th scope="col-1" style="font-weight: normal; text-align: center;" ng-click="ordenar('ba_taxa')">Taixa</th>
                                
                            </tr>
                        </thead>
                        <tbody style="line-height: 2em;">
                            <tr ng-repeat="bairro in bairro | filter:buscaBairros">
                                <td style=" font-weight: normal; text-align: left;">
                                    <md-checkbox ng-checked="bairro.br_select == true" ng-modal="selectBairro" ng-click="addBairroTemp(bairro)"></md-checkbox>
                                </td>
                                <td ng-bind="bairro.br_nome" style=" font-weight: normal; text-align: left;"></td>
                                <td style="font-weight: normal; text-align: left; width:120px;">
                                    <input type="text" class="form-control form-control-sm" id="regTaxa" ng-show="bairro.br_select == true" ng-value="bairro.br_taxa | currency: 'R$ '" ng-model="taxa" ng-blur="taxaValor(taxa, bairro)" style="text-align:right; border:none;" money-mask>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div> 

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" ng-click="salvarRegiao()">Salvar</button>                
            </div>
        </div>
    </div>
</div