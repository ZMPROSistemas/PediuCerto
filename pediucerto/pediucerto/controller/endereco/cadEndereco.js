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
    $scope.atualizaEndereco = [];
    $scope.aguardeTest = "Salvando aguarde";
    $scope.disabled = false;

    
    //<?=$urlAssets?>sacola/'+$scope.empresa[0].em_cod+'/'+ $scope.empresa[0].em_token

    console.log($scope.page);
    var atualizaPerfil = function(){
        $http({
            method:'GET',
            url:'<?=$api?>buscaPerfil?perfil=' + $scope.perfil[0].pe_site + '&ID=' + $scope.perfil[0].pe_id
        }).then(function onSuccess(response){

            $scope.perfil = response.data;
            $localStorage.remove('perfil');
            $localStorage.put('perfil',$scope.perfil);
            
            console.log($scope.page);
            setTimeout(function(){
                if($scope.page == undefined){
                   window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod + "/"+$scope.empresa[0].em_token;
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
        
       
        var perfil = $scope.perfil[0].pe_id;
        var token = $scope.empresa[0].em_token;

        if(end == undefined){
            //alert();
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
                $scope.disabled = true;
                //console.log('<?=$api?>salvarEnd');
                $http({
                    method:'POST',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    cache: false,
                    data:JSON.stringify({
                        perfil : perfil,
                        token : token,
                        endereco : end
                    }),
                    url: '<?=$api?>salvarEnd'
                }).then(function onSuccess(response){

                    $scope.retorno = response.data;

                    //console.log($scope.retorno);

                    if($scope.retorno[0].return == "SUCCESS"){
                            var endereco1 = end.adress;
                            var bairro1 = end.bairro;
                            var cidade1 = end.cidade;
                            var uf1 = end.uf;
                            

                            $localStorage.remove('endereco');
                            $sessionStorage.remove('selectEnd');
                            $scope.atualizaEndereco = [{
                                'local': end.local,
                                'pe_cep': end.cep,
                                'pe_endereco': endereco1.toLowerCase().replace(/(?:^|\s)(?!da|de|do)\S/g, l => l.toUpperCase()),
                                'pe_end_num' : end.numero,
                                'pe_bairro': bairro1.toLowerCase().replace(/(?:^|\s)(?!da|de|do)\S/g, l => l.toUpperCase()),
                                'pe_cidade': cidade1.toLowerCase().replace(/(?:^|\s)(?!da|de|do)\S/g, l => l.toUpperCase()),
                                'pe_uf' : uf1.toUpperCase(),
                                'pe_end_comp': end.comp,
                            }];
                            $localStorage.put('endereco', $scope.atualizaEndereco);
                            $sessionStorage.put('selectEnd', 'true');
                            console.log(end);
                        atualizaPerfil();
                    }else{
                        $scope.disabled = false;
                    }

                }).catch(function onError(response){
                    swal({
                        title: "ERROR",
                        text: "Há algo de errado com os dados digitados, Confira os campos por favor !!!",
                        icon: "warning",
                        buttons: 'OK'   
                    })
                });
            }
        }
        
        
    }

    $scope.logradouro;
    $scope.pesquisarCEP = function(cep){

        var cep = cep.replace(/\D/g, '');
        $http({
            method: 'GET',
            url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
        }).then(function onSuccess(response){

            $scope.logradouro = response.data;
            $scope.end.adress = $scope.logradouro.logradouro;
            $scope.end.bairro = $scope.logradouro.bairro;
            $scope.end.cidade = $scope.logradouro.localidade;
            $scope.end.uf = $scope.logradouro.uf;
           
           
        }).catch(function onError(response){

        });

    };

    $scope.navPage = function(){
        //console.log($scope.page)
        if($scope.page == null){
            window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod + "/"+empresa[0].em_token;
        }else{
            window.location.href = $scope.page;
        }
    }

}).directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});

$(document).ready(function(){
    
    var bairros =  [<?php 
        foreach ($listaBairrosAtendidos as $e){
            echo '"'.str_replace('ă','ã', $e['ba_nomebairro']).'",';
        }
    ?>]

    //console.log( bairros);
    // var bairros =[
    //     'Centro',
    //     'Jardim Europa',
    //     'Jardim Centauro',
    //     'Jardim Novo Centauro',
    //     'Vila Agari',
    //     'Vila Aparecida',
    //     'Nucleo Habitacional Joao Fiqueiredo',
    //     'Joao Paulo',
    //     'Nucleo Habitacional Joao Paulo',
    //     'Condominio Gran Residence'
    // ];
    $("#selectBairro").autocomplete({
        source:bairros
    });
});