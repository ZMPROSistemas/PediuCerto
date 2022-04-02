var dadosEmpresa = function () {
					
    $http({
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        cache: false,
        data:JSON.stringify({
            id: "<?=$route['id']?>",
            token: "<?=$route['token']?>",
        }),
        url: '<?=$urlBase?>services/abrirEmpresa.php?dadosEmpresa=S'
    }).then(function onSuccess(response){
        $scope.empresa = response.data;
        $localStorage.remove('empresa');
        $localStorage.put('empresa', $scope.empresa);
    }).catch(function onError(response){

    });

    
}

var atualiza = function () {
   
    $scope.ID =  $localStorage.get('ID');

    if ($scope.ID != '<?=$route['id']?>') {
        $localStorage.empty();

        $localStorage.put('perfil', $scope.perfil);
    }

    if ($scope.ID == undefined) {
        $localStorage.put('ID', <?=$route['id']?>, 30);
        $scope.ID = $localStorage.get('ID');
    }
    

    $http({
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        cache: false,
        data:JSON.stringify({
            id: "<?=$route['id']?>",
            token: "<?=$route['token']?>",
            input: "empresa"
        }),
        url: '<?=$urlBase?>services/atualizaCache.php?verifica=S'
    }).then(function onSuccess(response){

        

        //informação da empresa
        if($scope.cacheEmp === response.data[0].ca_info){

            var empresa =  $localStorage.get('empresa');

            
            if(empresa == undefined){
                
                dadosEmpresa();
            }else{

                angular.forEach(empresa, function(value, key){
                    $scope.empresa.push(empresa[key]);
                });
            
            }
            
        }else{
            var cacheEmp = response.data[0].ca_info;
            $localStorage.remove('cacheEmp');
            $localStorage.put('cacheEmp', cacheEmp, 30);

            dadosEmpresa();
        }
       

        //informação subgrupo

        if($scope.cacheSubg === response.data[0].ca_subgrupo){
            var subgrupo =  $localStorage.get('subgrupo');

            
            if(subgrupo == undefined){
                
                subGrupoProd();
            }else{

                angular.forEach(subgrupo, function(value, key){
                    $scope.subGrupo.push(subgrupo[key]);
                });

                $scope.totalSubGupo = ($scope.subGrupo.length *140);
            
            }
            
        }else{
            var cacheSubg = response.data[0].ca_subgrupo;
            $localStorage.remove('cacheSubg');
            $localStorage.put('cacheSubg', cacheSubg, 30);

            subGrupoProd();
        }

        //informação Produto

        
        if($scope.cacheProduto === response.data[0].ca_produto){
            var produto =  $localStorage.get('produtos');
            
            
            if(produto == undefined){
                
                buscarProduto();
            }else{

                angular.forEach(produto, function(value, key){
                    $scope.produtos.push(produto[key]);
                });
                verSacolaCache();
                
            }
            
        }else{
            var cacheProduto = response.data[0].ca_produto;
            $localStorage.remove('cacheProduto');
            $localStorage.put('cacheProduto', cacheProduto, 30);
            buscarProduto();
            
        }

        
    
    }).catch(function onError(response){

    });
}

atualiza();

