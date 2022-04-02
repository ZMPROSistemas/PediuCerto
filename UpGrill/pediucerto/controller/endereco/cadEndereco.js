angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    $scope.produtos=[];
    $scope.empresa = $localStorage.get('empresa');
    $scope.subGrupo = [];
    $scope.retorno = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.page = $localStorage.get('page');
    
    //<?=$urlAssets?>sacola/'+$scope.empresa[0].em_cod+'/'+ $scope.empresa[0].em_token

    var atualizaPerfil = function(){
        $http({
            method:'GET',
            url:'<?=$urlAssets?>services/buscaPerfil?perfil=' + $scope.perfil[0].pe_site + '&ID=' + $scope.perfil[0].pe_id
        }).then(function onSuccess(response){

            $scope.perfil = response.data;
            $localStorage.remove('perfil');
            $localStorage.put('perfil',$scope.perfil);

            setTimeout(function(){
                if($scope.page == null){
                    window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod + "/"+empresa[0].em_token;
                }else{
                    window.location.href = $scope.page;
                }

            }, 3000);
            
        }).catch(function onError(response){

        });
    }


    var alert = function(){
        swal({
            title: "ERROR",
            text: "Todos campos com(*) são obrigatórios",
            icon: "warning",
            buttons: 'OK'
        })
    }
    
    $scope.salvarEnd = function(end){
        console.log(end);
        var perfil = $scope.perfil[0].pe_id

        if(end == undefined){
            alert();
        }
        else if(end != undefined){
        
            if (end.adress == undefined){
                alert();
            }
            if (end.bairro == undefined){
                alert();
            }
            if (end.cidade == undefined){
                alert();
            }
            if (end.numero == undefined){
                alert();
            }
            if (end.uf == undefined){
                alert();
            }else{
                
                $http({
                    method:'POST',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    cache: false,
                    data:JSON.stringify({
                        perfil : perfil,
                        endereco : end
                    }),
                    url: '<?=$urlAssets?>services/salvarEnd'
                }).then(function onSuccess(response){

                    $scope.retorno = response.data;

                    console.log($scope.retorno);

                    if($scope.retorno[0].return == "SUCCESS"){
                        atualizaPerfil();
                    }

                }).catch(function onError(response){

                });
            }
        }
        
        
    }

    $scope.navPage = function(){
        //console.log($scope.page)
        if($scope.page == null){
            window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod + "/"+empresa[0].em_token;
        }else{
            window.location.href = $scope.page;
        }
    }

});