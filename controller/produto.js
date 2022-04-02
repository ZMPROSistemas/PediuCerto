$scope.alterar_lanca_site = function(lancar) {

    if(lancar == true){
        $scope.produto[0].pd_lanca_site = 'S';
    }else if(lancar == false){
        $scope.produto[0].pd_lanca_site = 'N';
    }else{
        console.log('erro')
    }
    console.log(lancar);
    console.log($scope.produto[0].pd_lanca_site);

}

//Amarrado com buscarEstoque

var buscarExcecoes = function(pd_cod){
    $scope.adicionalExcecao = '';
    //alert(pd_cod);
    $http({
        method: 'GET',
        url: $scope.urlBase+'srvcExcecoes.php?listaExcecoesProd=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod
    }).then(function onSuccess(response){
        $scope.adicionalExcecao = response.data.result[0];
        
    }).catch(function onError(response){

    });
}


//Amarrado com visualizarProduto
var buscarEstoque = function(pd_cod){
    
    $http({
        method: 'GET',
        url: $scope.urlBase+'Estoque.php?estoqueSimplificado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod
    }).then(function onSuccess(response){
        $scope.estoque = response.data.result[0];
        buscarExcecoes($scope.produto[0].pd_cod);
       
    }).catch(function onError(response){

    });
}



//Amarrado com visualizarProduto
/*
var buscarEstoque = function(pd_cod){
    
    $http({
        method: 'GET',
        url: $scope.urlBase+'Estoque.php?estoqueSimplificado=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_cod='+pd_cod
    }).then(function onSuccess(response){
        $scope.estoque = response.data.result[0];
        buscarExcecoes($scope.produto[0].pd_cod);
    }).catch(function onError(response){

    });
}
*/

// 19-11-2020
$scope.visualizarProduto = function(prod, tipo, modo){
    
    MudarVisibilidade2(tipo, modo);
    $http({
        method: 'GET',
        url: $scope.urlBase+'Produtos.php?visualizarProdutos=S&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&pd_id='+prod.pd_id
        }).then(function onSuccess(response){
            $scope.produto = response.data.result[0];
            if ($scope.produto[0].pd_foto_url == null || $scope.produto[0].pd_foto_url == "" || $scope.produto[0].pd_foto_url == undefined){
                //alert($scope.produto[0].pd_foto_url);
                $scope.produto[0].pd_foto_url =	$scope.urlImage ;
                
                

            } else {
                $scope.urlImage = $scope.produto[0].pd_foto_url;
            }

            //verifica campo lancar site
            if($scope.produto[0].pd_lanca_site == 'S'){
                $scope.lancar_site = true;
            }else if($scope.produto[0].pd_lanca_site == 'N'){
                $scope.lancar_site = false;
            }

            $scope.alterar_lanca_site($scope.lancar_site);
            console.log($scope.produto);
            buscarEstoque($scope.produto[0].pd_cod);
            
        }).catch(function onError(response){
            
    });
};

$scope.AdicionarProduto = function(prod) {
    //console.log($scope.produto);
    
    SalvarProdutos(prod);
};

//Apagar 19-11-2020 amarrado com AdicionarProduto
var SalvarProdutos = function (item) {

    //alert("entrou");
    
    var prod = $scope.produto;

    $http({
        
        method: 'POST',
            headers: {
            'Content-Type':'application/json'
            },
            data: {
            prod:prod,
            },
            url: $scope.urlBase+'SalvaProdutos.php?SalvarProduto=S&us_id=<?=$us_id?>&e=<?=$empresa?>&eA=<?=$empresa_acesso?>&cadastrar_alterar='+$scope.cadastrar_alterar

    }).then(function onSuccess(response){
        
        $scope.retStatus = response.data.result[0];

         
        if ($scope.retStatus[0].status == "SUCCESS") {
            
            $scope.cadastrar_alterar = 'E';

            if($scope.abaAdicional == false){
                
                $scope.produto[0].pd_cod = $scope.retStatus[0].pd_cod;
                $scope.produto[0].pd_id = $scope.retStatus[0].pd_id;
                buscarExcecoes($scope.produto[0].pd_cod);
                $('#confirmarAdicionais').modal('show');
            }else{
                
                $scope.urlImage = 'https://zmsys.com.br/images/produto.jpg';

                $scope.tipoAlerta = "alert-success";
                $scope.alertMsg = "Produto adicionada com sucesso!";

                $scope.lista = !$scope.lista;
                $scope.ficha = !$scope.ficha;

                $scope.produto = [{
                    pd_cod:'',
                    pd_ean:'',
                    pd_codinterno:'',
                    pd_un:'',
                    pd_lanca_site:'S',
                    pd_disk:'',
                    pd_desc:'',
                    pd_subgrupo:'',
                    pd_marca:'',
                    pd_localizacao:'',
                    pd_cst:'',
                    pd_ncm:'',
                    pd_csosn:'',
                    pd_custo:'',
                    pd_vista:'',
                    pd_markup:'',
                    pd_grade:'',
                    pd_foto_url:'',
                    pd_observ:'',
                    es_est:'',
                    pd_ativo: '',
                    pd_composicao:'',
                    pd_st:false,
                }];
            }
            //dadosProdutosSimplificado($scope.empresa);
            buscarProdutos()
            chamarAlerta();
                        

        } else if ($scope.retStatus[0].status == 'ERROR') {						
            $scope.tipoAlerta = "alert-danger";
            $scope.alertMsg = "Erro ao adicionar produto!";
            //dadosProdutosSimplificado($scope.empresa);
            buscarProdutos();
            chamarAlerta();
            $scope.urlImage = 'https://zmsys.com.br/images/produto.jpg';
        }
       // window.reload();						
    }).catch(function onError(response){
        //dadosProdutosSimplificado($scope.empresa);
        buscarProdutos();
        //alert();
            /*
            $scope.tipoAlerta = "alert-danger";
            $scope.alertMsg = "Erro ao adicionar produto conexão banco!";
            chamarAlerta();
            */
    });

};

$scope.alertaAdicionais = function(e){
    if (e == 'S') {
        $scope.abaAdicional = true;
        
        $('#confirmarAdicionais').modal('hide');
        $scope.selectedIndex = 1;
    }
    else if (e == 'N'){
        $('#confirmarAdicionais').modal('hide');

        $scope.urlImage = 'https://zmsys.com.br/images/produto.jpg';

        $scope.tipoAlerta = "alert-success";
        $scope.alertMsg = "Produto adicionada com sucesso!";

        $scope.lista = !$scope.lista;
        $scope.ficha = !$scope.ficha;

        $scope.produto = [{
            pd_cod:'',
            pd_ean:'',
            pd_codinterno:'',
            pd_un:'',
            pd_lanca_site:'S',
            pd_disk:'',
            pd_desc:'',
            pd_subgrupo:'',
            pd_marca:'',
            pd_localizacao:'',
            pd_cst:'',
            pd_ncm:'',
            pd_csosn:'',
            pd_custo:'',
            pd_vista:'',
            pd_markup:'',
            pd_grade:'',
            pd_foto_url:'',
            pd_observ:'',
            es_est:'',
            pd_ativo: '',
            pd_composicao:'',
            pd_st:false,
        }];
    }
}


