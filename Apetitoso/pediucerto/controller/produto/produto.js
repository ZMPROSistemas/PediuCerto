angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    
    $scope.produtos=[];
    $scope.page = $localStorage.get('page');
    $scope.empresa = $localStorage.get('empresa');
    $scope.subGrupo = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.endereco = $localStorage.get('endereco');
    $scope.formaPagamento =  $sessionStorage.get('fPagamento');
    $scope.cpfCnpj =  $sessionStorage.get('cpfCnpj');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $urlBase = '<?=$api?>';
    $scope.adicional = [];
    $scope.btnDisable = true;

    var atualizarItemAdicional = function(){
        var cache = $localStorage.get('adicionais');
        var i=0;

        angular.forEach(cache, function(value, key){
            $scope.adicional.push(cache[key]);
        });
    }

    atualizarItemAdicional();  // Busca adicionais no cache e guarda na variaval $scope.adicional
    
    $scope.totalSubGupo=0;

    $scope.IDitem = Math.floor(Math.random() * 10000);   // Todo adicional criado recebe um numero ramdomico para que se possa encontra-lo depois
    $scope.prodQts=1;
  
    <?php
        include_once('controller/app/sacola.js');
    ?>

    //verSacolaCache();

    <?php
        include_once('api/cache.js');
    ?>

    
    $scope.item = $localStorage.get('itemProduto');  // Recebe o id do produto vindo da tela anterior utilizado para mostrar os adicionais
  
    var adicionais_execoes = function(){
        if($scope.item != undefined){

            var item_id = $scope.item.pd_id;
            var token =  $scope.empresa[0].em_token;
           
            $http({
                method:'POST',
                headers: {
                    'Content-Type':'application/json'
                },
                cache: false,
                data:JSON.stringify({
                    item:item_id,
                    token:token
                }),
                url:'<?=$api?>itens'
            }).then(function onSuccess(response){
                $scope.adicionaisExecoes = response.data;
                
            }).catch(function onError(response){

            });
        }else{
            window.location.href = '<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>';
        }
        
    }

    adicionais_execoes();

    $scope.sacolaTemp = [];  // Cria uma sacola temporaria
    $scope.adicionalTemp = [];
    $scope.total=0;               

    var atualizarItemSacola = function(){
        $scope.total=0;

        for (i =0; i < $scope.adicionalTemp.length; i++) {
            $scope.total += $scope.adicionalTemp[i].ex_total;
        }
        $scope.sacolaTemp[0].v_adicional = $scope.total
        $scope.sacolaTemp[0].total_item =  $scope.sacolaTemp[0].v_adicional + $scope.sacolaTemp[0].pd_vUnitario;
        $scope.sacolaTemp[0].v_total = $scope.sacolaTemp[0].total_item * $scope.sacolaTemp[0].pd_quantidade;
        //console.log($scope.sacolaTemp[0].v_adicional);
    }

    var removerItemZero = function(){

        for (i = 0; i < $scope.adicional.length; i++){
            if($scope.adicional[i].ex_qts == 0){
                $scope.adicional.splice(i,1);
            }
        }
    
        $localStorage.remove('adicionais');
        $localStorage.put('adicionais', $scope.adicional,30);
    
    }


    $scope.addSacolaTemp = function(obs){
        var IDitem = $scope.IDitem;
        var quantidade = $scope.prodQts;
        var item = $scope.item;

        if($scope.sacolaTemp.length == 0){

            var v_adicional = 0;
            
            $scope.sacolaTemp.push({
                item: IDitem,
                pd_id: item.pd_id,
                pd_cod: item.pd_cod,
                pd_desc: item.pd_desc,
                pd_composicao: item.pd_composicao,
                pd_foto_url: item.pd_foto_url,
                pd_quantidade: quantidade,
                pd_atualizast: item.pd_atualizast,
                pd_vUnitario: item.pd_vista,
                v_adicional : v_adicional,
                total_item : v_adicional + item.pd_vista,
                v_total : item.pd_vista,
                pd_obs: null
            });
        }
        else{
            $scope.sacolaTemp[0].pd_quantidade =  $scope.prodQts;
            $scope.sacolaTemp[0].v_total = $scope.sacolaTemp[0].total_item * $scope.prodQts;
            $scope.sacolaTemp[0].pd_obs = obs;
            atualizarItemSacola();
        }

        
         //console.log($scope.sacolaTemp);
    }



    $scope.addAdicional = function(e){
        var IDitem = Math.floor(Math.random() * 10000);
        var produto = $scope.sacolaTemp[0].item;
        var quantidade = 1;

        var linhaAdicional = $scope.adicionaisExecoes.find(item => item.pde_id === e.pde_id);

        if (linhaAdicional != undefined) {
            for (i = 0; i < $scope.adicionaisExecoes.length; i++) {
                if($scope.adicionaisExecoes[i].pde_id === linhaAdicional.pde_id){
                    $scope.adicionaisExecoes[i].ex_qts ++;
                    quantidade =  $scope.adicionaisExecoes[i].ex_qts;
                }
            }
        }
        var linhaAdicional = $scope.adicionalTemp.find(item => item.pde_id == e.pde_id);

        if (linhaAdicional == undefined) {
            $scope.adicionalTemp.push({
                'produto' : produto,
                'item' : IDitem,
                'ex_desc': e.ex_desc,
                'ex_id': e.ex_id,
                'ex_qts': 1,
                'ex_tipo': e.ex_tipo,
                'ex_valor': e.ex_valor,
                'pde_id': e.pde_id,
                'pde_tipo': e.pde_tipo,
                'ex_total': e.ex_qts * e.ex_valor
            })
        }else{
            for (i = 0; i < $scope.adicionalTemp.length; i++) {
                if($scope.adicionalTemp[i].pde_id == linhaAdicional.pde_id){
                    $scope.adicionalTemp[i].ex_qts = quantidade;
                    $scope.adicionalTemp[i].ex_total =  $scope.adicionalTemp[i].ex_valor * quantidade;
                    
                }
            }

        }
        atualizarItemSacola();
        //console.log($scope.adicionalTemp);
    }

    $scope.removerAdicional = function(e){
        var quantidade = 1;
        var linhaAdicional = $scope.adicionaisExecoes.find(item => item.pde_id === e.pde_id);

        if (linhaAdicional != undefined) {
            for (i = 0; i < $scope.adicionaisExecoes.length; i++) {
                if($scope.adicionaisExecoes[i].pde_id === linhaAdicional.pde_id){
                    if ($scope.adicionaisExecoes[i].ex_qts != 0) {
                         $scope.adicionaisExecoes[i].ex_qts --;
                         quantidade =  $scope.adicionaisExecoes[i].ex_qts;
                        
                    }
                }
            }
        }

        var linhaAdicional = $scope.adicionalTemp.find(item => item.pde_id === e.pde_id);

        if (linhaAdicional != undefined) {
            
            for (i = 0; i < $scope.adicionalTemp.length; i++) {
                if($scope.adicionalTemp[i].pde_id === linhaAdicional.pde_id){
                    if ($scope.adicionalTemp[i].ex_qts != 0) {
                        $scope.adicionalTemp[i].ex_qts = quantidade;
                        $scope.adicionalTemp[i].ex_total =  $scope.adicionalTemp[i].ex_valor * quantidade;
                        //atualizarItemSacola($scope.adicional[i].ex_total);
    
                    }else{
                        $scope.adicionalTemp.splice(i,1);
                    }
                }
            }
        }

        atualizarItemSacola();
    }

    $scope.addSacolaTemp('');

    $scope.prodQtsAdd = function(obs){
        $scope.prodQts += 1;
        $scope.addSacolaTemp(obs);
    }

    $scope.prodQtsRemove = function(obs){
        if($scope.prodQts == 1){
            $scope.prodQts = 1;
        }else{
            $scope.prodQts -= 1;
        }
        $scope.addSacolaTemp(obs);
        
    }

    $scope.verArrayProd = function(){
        console.log($scope.item);
        console.log($scope.sacolaTemp);
        console.log($scope.adicionalTemp);
        console.log($scope.sacola);
    }

    $scope.addTempSacola = function(obs){
        $scope.btnDisable = false;
        var adicionalTemp = $scope.adicionalTemp;

        $localStorage.remove('sacola');
        $localStorage.remove('adicionais');

        $scope.sacola.push({
            item: $scope.sacolaTemp[0].item,
            pd_id: $scope.sacolaTemp[0].pd_id,
            pd_cod: $scope.sacolaTemp[0].pd_cod,
            pd_desc: $scope.sacolaTemp[0].pd_desc,
            pd_composicao: $scope.sacolaTemp[0].pd_composicao,
            pd_foto_url: $scope.sacolaTemp[0].pd_foto_url,
            pd_quantidade: $scope.sacolaTemp[0].pd_quantidade,
            pd_atualizast:$scope.sacolaTemp[0].pd_atualizast,
            pd_vUnitario: $scope.sacolaTemp[0].pd_vUnitario,
            v_adicional: $scope.sacolaTemp[0].v_adicional,
            total_item : $scope.sacolaTemp[0].total_item,
            v_total : $scope.sacolaTemp[0].v_total,
            pd_obs: obs
        })
        
        angular.forEach(adicionalTemp, function(value, key){
            $scope.adicional.push(adicionalTemp[key]);
        });

        //
        $localStorage.put('sacola', $scope.sacola,30);
        $localStorage.put('adicionais', $scope.adicional,30);

        removerItemZero();
        $localStorage.remove('itemProduto');
        swal({
            title: "OK",
            text: "Seu Pedido foi adicionado a sacola",
            icon: "success",
            button: null
        })

        setTimeout(function(){
            window.location.href = '<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>';
            //$scope.verArrayProd();
        }, 800);
    }

//<?=$urlAssets?>sacola/<?=$route['id']?>/<?=$route['token']?>

});