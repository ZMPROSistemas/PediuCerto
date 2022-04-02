$scope.adicional = [];

var atualizarItemAdicional = function(){
   

    var cache = $localStorage.get('adicionais');
    var i=0;

    angular.forEach(cache, function(value, key){
        $scope.adicional.push(cache[key]);
    });

    if ($scope.adicional != null) {
       
        for (i = 0; i < $scope.adicionaisExecoes.length; i++){
            
            for (j = 0; j < $scope.adicional.length; j++){
                if ($scope.adicional[j].produto == $scope.item.item){
                    if ($scope.adicionaisExecoes[i].pde_id === $scope.adicional[j].pde_id) {
                        $scope.adicionaisExecoes[i].ex_qts= $scope.adicional[j].ex_qts;
                    }
                }
                
            }
        }
    }
    
}

//atualizarItemAdicional();

var removerItemZero = function(){

    for (i = 0; i < $scope.adicional.length; i++){
        if($scope.adicional[i].ex_qts == 0){
            $scope.adicional.splice(i,1);
        }
    }

    $localStorage.remove('adicionais');
    $localStorage.put('adicionais', $scope.adicional,30);
    
    

}

//removerItemZero();

$scope.total = 0;

var atualizarItemSacola = function(e){
   $localStorage.remove('sacola');
    
    var key = $scope.sacola.indexOf($scope.item);
    
    $scope.total=0;

    for (i =0; i < $scope.adicional.length; i++) {
        if ($scope.adicional[i].produto == $scope.item.item) {
            $scope.total += $scope.adicional[i].ex_total;
           
        }
    }
    
    $scope.sacola[key].v_adicional = $scope.total
    $scope.sacola[key].total_item =  $scope.sacola[key].v_adicional + $scope.sacola[key].pd_vUnitario;
    $scope.sacola[key].v_total = $scope.sacola[key].total_item * $scope.sacola[key].pd_quantidade;
    
    //console.log($scope.sacola);
    //console.log($scope.adicional);
    //$scope.sacola[key].pd_vista = $scope.sacola[key].pd_vUnitario + $scope.total;
    
    $localStorage.put('sacola', $scope.sacola,30);
   
    removerItemZero();
}

$scope.addAdicional = function(e){

    var item = Math.floor(Math.random() * 10000);
    var produto = $scope.item.item;
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

    var linhaAdicional = $scope.adicional.find(item => item.pde_id == e.pde_id);
    //console.log($scope.adicional);
    //console.log(linhaAdicional);
    //console.log(e);

    if (linhaAdicional == undefined) {
        $scope.adicional.push({
            'produto' : produto,
            'item' : item,
            'ex_desc': e.ex_desc,
            'ex_id': e.ex_id,
            'ex_qts': 1,
            'ex_tipo': e.ex_tipo,
            'ex_valor': e.ex_valor,
            'pde_id': e.pde_id,
            'pde_tipo': e.pde_tipo,
            'ex_total': e.ex_qts * e.ex_valor
        });

        
        atualizarItemSacola(e.ex_qts * e.ex_valor);
        
    }else{
        for (i = 0; i < $scope.adicional.length; i++) {
            if($scope.adicional[i].pde_id == linhaAdicional.pde_id){
                $scope.adicional[i].ex_qts = quantidade;
                $scope.adicional[i].ex_total =  $scope.adicional[i].ex_valor * quantidade;
                atualizarItemSacola($scope.adicional[i].ex_total);
            }
        }
    }

    $localStorage.remove('adicionais');
    $localStorage.put('adicionais', $scope.adicional,30);
    
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

    var linhaAdicional = $scope.adicional.find(item => item.pde_id === e.pde_id);

    if (linhaAdicional != undefined) {
      
        for (i = 0; i < $scope.adicional.length; i++) {
            if($scope.adicional[i].pde_id === linhaAdicional.pde_id){
                if ($scope.adicional[i].ex_qts != 0) {
                    $scope.adicional[i].ex_qts = quantidade;
                    $scope.adicional[i].ex_total =  $scope.adicional[i].ex_valor * quantidade;
                    atualizarItemSacola($scope.adicional[i].ex_total);

                }else{
                    $scope.adicional.splice(i,1);
                }
            }
        }
    }

    $localStorage.remove('adicionais');
    $localStorage.put('adicionais', $scope.adicional,30);

}

$scope.verArrayItem = function (){
    console.log($scope.adicional);
}
