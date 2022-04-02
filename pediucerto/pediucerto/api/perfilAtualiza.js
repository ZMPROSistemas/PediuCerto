var atualizaPerfil = function(){
    $http({
        method:'GET',
        url:'<?=$api?>buscaPerfil?perfil=' + $scope.perfil[0].pe_site + '&ID=' + $scope.perfil[0].pe_id
    }).then(function onSuccess(response){

        $scope.perfil = response.data;
        $localStorage.remove('perfil');
        $localStorage.put('perfil',$scope.perfil);

        setTimeout(function(){ 
            window.location.href = '<?=$urlAssets?>endereco/cadastrar/'+$scope.perfil[0].pe_site
        }, 3000);
        
    }).catch(function onError(response){

    });
}
