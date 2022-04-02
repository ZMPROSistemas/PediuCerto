
$scope.telaLogin = function() {
    
    $('#selectLogin').modal('hide');

    $('#Login').modal('show');
}

$scope.telaCadastro = function() {
    
    $('#selectLogin').modal('hide');

    $('#cadastro').modal('show');
}

$scope.entrar = function(celularUser, senha){
    
    celularUser = celularUser.replace('(','');
    celularUser = celularUser.replace(')','');
    celularUser = celularUser.replace('-','');
    celularUser = celularUser.replace(' ','');
    $scope.aguardeTest = "Aguarde";
    $scope.disabled = true;
    
    $http({
        method:'POST',
        headers: {
            'Content-Type':'application/json'
        },
        cache: false,
        data:JSON.stringify({
            user:celularUser,
            pass: btoa(senha)
        }),
        url: '<?=$api?>login'
    }).then(function onSuccess(response){
        $scope.retorno = response.data;
        if($scope.retorno[0].return == 'ERROR'){
            
            swal({
                title: "ERROR",
                text: "Usuário E Senha Incorreto",
                icon: "warning",
                button: "OK"
            });
            $scope.disabled = false;
        }
        else if($scope.retorno[0].return == 'SUCCESS'){
            $scope.perfil = [];
            $scope.perfil.push($scope.retorno[1])
            $localStorage.remove('perfil');
            $localStorage.put('perfil', $scope.perfil);
            $scope.disabled = true;
            $('#Login').modal('hide');
            swal({
                title: "Sucesso",
                text: "Login Efetuado com sucesso",
                icon: "success",
                button: null
            });
            setTimeout(function(){
                window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site
            },1000);
        }
    }).catch(function onError(response){

    });
    
}