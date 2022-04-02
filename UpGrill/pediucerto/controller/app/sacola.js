$scope.totalSacolaQtn=0;
$scope.totalSacolaValor=0;

var somarTotalSacola = function(){
    $scope.totalSacolaQtn=0;
    $scope.totalSacolaValor=0;

   

    for (i = 0; i < $scope.sacola.length; i++) {
        $scope.totalSacolaQtn += $scope.sacola[i].pd_quantidade;
        $scope.totalSacolaValor += $scope.sacola[i].pd_vista;
        
    }

    
}



var atualizarSacola = function(){

    //verifica os produtos que em na sacola e atualiza o array de produto
    for (i = 0; i <  $scope.produtos.length; i++) {
      
        for (j = 0; j < $scope.produtos[i].produto.length; j++) {

            //console.log($scope.produtos[i].produto[j].pd_id);
            $scope.produtos[i].produto[j].pd_quantidade = 0;

           for (s = 0; s < $scope.sacola.length; s++) {
           
            
                if ($scope.produtos[i].produto[j].pd_id === $scope.sacola[s].pd_id) {
                    
                   // console.log($scope.sacola[s].pd_desc);
                   
                   if ($scope.produtos[i].produto[j].pd_atualizast == 'N') {
                        $scope.produtos[i].produto[j].pd_quantidade = $scope.sacola[s].pd_quantidade;
                   }else{
                        
                      
                        $scope.produtos[i].produto[j].pd_quantidade += $scope.sacola[s].pd_quantidade;
                        
                        
                   }

                   
                }
           
               
           }
            
        }
   }

   $scope.totalSacolaValor = 0;
   somarTotalSacola();
}

$scope.sacola=[];

var verSacolaCache = function(){
    
    //verfica o que esta em cache e atualiza sacola
    var cache = $localStorage.get('sacola');
    var i=0;
   
    angular.forEach(cache, function(value, key){
        //console.log(cache[key]);

        $scope.sacola.push(cache[key]);
        
   });
   atualizarSacola();
    //console.log($scope.sacola);

}

//verSacolaCache();

$scope.addItemSacola = function(e){
    
    var item = Math.floor(Math.random() * 10000);
    
    var quantidade = 1;
    if (e.pd_atualizast === 'N') {
        
        var linhaSacola = $scope.sacola.find(item => item.pd_id === e.pd_id);

        if (linhaSacola != undefined) {
            for (i = 0; i < $scope.sacola.length; i++) {
                
                if($scope.sacola[i].pd_id === linhaSacola.pd_id){
                    $scope.sacola[i].pd_quantidade ++;
                    $scope.sacola[i].pd_vista = e.pd_vista * $scope.sacola[i].pd_quantidade;
                }
                
            }
        }else{
            $scope.sacola.push({
                item: item,
                pd_id: e.pd_id,
                pd_cod: e.pd_cod,
                pd_desc: e.pd_desc,
                pd_composicao: e.pd_composicao,
                pd_foto_url: e.pd_foto_url,
                pd_quantidade: quantidade,
                pd_vista: e.pd_vista,
                pd_atualizast: e.pd_atualizast,
                pd_vUnitario: e.pd_vista,
                pd_obs:''
            });
            
        }
    }else{

        $scope.sacola.push({
            item: item,
            pd_id: e.pd_id,
            pd_cod: e.pd_cod,
            pd_desc: e.pd_desc,
            pd_composicao: e.pd_composicao,
            pd_foto_url: e.pd_foto_url,
            pd_quantidade: quantidade,
            pd_vista: e.pd_vista,
            pd_atualizast:e.pd_atualizast,
            pd_vUnitario: e.pd_vista,
            pd_obs:''
        });

    }
    
    atualizarSacola();
    
    $localStorage.remove('sacola');
    $localStorage.put('sacola', $scope.sacola,30);

}

$scope.removItemSacola = function(e){

    var quantidade = 1;
    
    var linhaSacola = $scope.sacola.find(item => item.pd_id === e.pd_id);

    var index = $scope.sacola.indexOf(linhaSacola);
    
    if (e.pd_atualizast === 'N') {

        for (i = 0; i < $scope.sacola.length; i++) {
            if ($scope.sacola[i].pd_id === linhaSacola.pd_id) {
                $scope.sacola[i].pd_quantidade --;
                $scope.sacola[i].pd_vista = e.pd_vista * $scope.sacola[i].pd_quantidade;

                if ($scope.sacola[i].pd_quantidade === 0)    {
                    $scope.sacola.splice(index,1);
                }
            }
        }
    }else{
        $scope.sacola.splice(index,1);
        console.log(index);
    }
    
    atualizarSacola();
    $localStorage.remove('sacola');
    $localStorage.put('sacola', $scope.sacola,30);
}

$scope.addRemoveItemSacola = function(e,tipo){
    
    var linhaSacola = $scope.sacola.find(item => item.item === e.item);
    var index = $scope.sacola.indexOf(linhaSacola);
     console.log(index);
    if (tipo == 'ADD') {
        for (i = 0; i < $scope.sacola.length; i++) {
                
            if($scope.sacola[i].item === linhaSacola.item){
                $scope.sacola[i].pd_quantidade ++;
                $scope.sacola[i].pd_vista = e.pd_vUnitario * $scope.sacola[i].pd_quantidade;
            }
        
        }
    }
    else if(tipo == 'REMOVE'){
        for (i = 0; i < $scope.sacola.length; i++) {
                
            if($scope.sacola[i].item === linhaSacola.item){
                $scope.sacola[i].pd_quantidade --;
                $scope.sacola[i].pd_vista = e.pd_vUnitario * $scope.sacola[i].pd_quantidade;

                if ($scope.sacola[i].pd_quantidade === 0)    {
                    $scope.sacola.splice(index,1);
                }
            }
        
        }
    }

    $localStorage.remove('sacola');
    $localStorage.put('sacola', $scope.sacola,30);
    
}

$scope.verArrayIndex = function(e){

    var linhaSacola = $scope.sacola.find(item => item.pd_id === e.pd_id);
    //var index = $scope.sacola.valueOf(e);
    console.log(linhaSacola);
    var index;
    for(i=0; i<$scope.sacola.length; i++){

        if ($scope.sacola[i].pd_id === linhaSacola.pd_id) {
            index = i;
        }
    }
    console.log(index);
}

$scope.verArray = function(){
    console.log($scope.sacola);
    console.log($scope.produtos);
    
}



$scope.limpaCache= function(){
    $localStorage.empty();
}