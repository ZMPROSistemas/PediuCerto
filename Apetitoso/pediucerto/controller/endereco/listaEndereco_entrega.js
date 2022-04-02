angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $mdDialog, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    $scope.produtos=[];
    $scope.empresa = $localStorage.get('empresa');
    $scope.subGrupo = [];
    $scope.page = $localStorage.get('page');
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.atualizaEndereco = [];

    
    var addLocalEntrega = function(){
        var endereco =  $scope.atualizaEndereco;
        var perfil = $scope.perfil[0].pe_site;
        var ID = $scope.perfil[0].pe_id;
        $http({
            method : 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            cache: false,
            data:JSON.stringify({
                ID:ID,
                perfil:perfil,
                endereco:endereco
            }),
            url:"<?=$api?>addLocal"
        }).then(function onSuccess(response){

            $scope.retorno = response.data;
            //console.log($scope.retorno);
            if($scope.retorno[0].retorno == 'SUCCESS'){
                $sessionStorage.put('selectEnd', true);
                window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod+"/"+$scope.empresa[0].em_token
            }

        }).catch(function onError(response){

        });
    }

    var aviso = function(){

        if($scope.atualizaEndereco[0].local != 'Retirar No Estabelecimento'){

            swal({
                title: "Confirmar",
                text: "Confirmar endereço de entrega: \n"+$scope.atualizaEndereco[0].pe_endereco+ ", " +$scope.atualizaEndereco[0].pe_end_num+
                " - "+$scope.atualizaEndereco[0].pe_bairro+ ", "+$scope.atualizaEndereco[0].pe_cidade+"",
                icon: "info",
                buttons: {
                    cancel: "cancelar",
                    catch: {
                        text: "Confirmar",
                        value: "Confirmar",
                    },
                    
                },
                
            }).then((value) =>{
                if(value == "Confirmar"){
                    addLocalEntrega()
                    //window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod+"/"+$scope.empresa[0].em_token
                }else{
                    $scope.atualizaEndereco = [];
                    $localStorage.remove('endereco');
                }
            })
        }else{
            swal({
                title: "Confirmar",
                text: "Confirmar retirada no estabelecimento",
                icon: "info",
                buttons: {
                    cancel: "cancelar",
                    catch: {
                        text: "Confirmar",
                        value: "Confirmar",
                    },
                    
                },
                
            }).then((value) =>{
                if(value == "Confirmar"){
                    $sessionStorage.put('selectEnd', 'true');
                    //addLocalEntrega()
                   window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod+"/"+$scope.empresa[0].em_token
                }else{
                    $scope.atualizaEndereco = [];
                    $localStorage.remove('endereco');
                }
            })
        }
    }

    var selecionadoEnd = function(end){
        
        $scope.atualizaEndereco = [];
            $localStorage.remove('endereco');

            if(end == 'Casa'){
                $scope.atualizaEndereco = [{
                    'local':'Casa',
                    'pe_cep': $scope.perfil[0].pe_cep,
                    'pe_endereco': $scope.perfil[0].pe_endereco,
                    'pe_end_num' : $scope.perfil[0].pe_end_num,
                    'pe_bairro': $scope.perfil[0].pe_bairro,
                    'pe_cidade': $scope.perfil[0].pe_cidade,
                    'pe_uf' : $scope.perfil[0].pe_uf,
                    'pe_end_comp': $scope.perfil[0].pe_end_comp,
                }];
                
            }

            else if(end == 'Trabalho'){
                $scope.atualizaEndereco = [{
                    'local':'Trabalho',
                    'pe_cep': $scope.perfil[0].pe_cep_trab,
                    'pe_endereco': $scope.perfil[0].pe_endtrab,
                    'pe_end_num' : $scope.perfil[0].pe_end_num_trab,
                    'pe_bairro': $scope.perfil[0].pe_bairro_trab,
                    'pe_cidade': $scope.perfil[0].pe_end_cid_trab,
                    'pe_uf' : $scope.perfil[0].pe_uf_trab,
                    'pe_end_comp' : $scope.perfil[0].pe_end_comp_trab,
                }];
            }
            else if(end == 'retirar'){
                
                $scope.atualizaEndereco = [{
                    'local':'Retirar No Estabelecimento',
                }];
            }
            else{
                $scope.atualizaEndereco = [{
                    'local':'Local Atual',
                    'pe_cep': end.cep,
                    'pe_endereco': end.adress,
                    'pe_end_num' : end.numero,
                    'pe_bairro': end.bairro,
                    'pe_cidade': end.cidade,
                    'pe_uf' : end.uf,
                    'pe_end_comp': end.comp,
                }];
            }

            $localStorage.put('endereco', $scope.atualizaEndereco);
            aviso();
    }

    $scope.selecionarEndereco = function(end){
        
/*
        if ($scope.perfil[0].pe_endereco == "") {
            $localStorage.remove('page');
        
            $localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);

            window.location.href = "<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
        }
*/
        if (end == 'Casa') {
            if($scope.perfil[0].pe_endereco == undefined){
                $localStorage.remove('page');
            
                //$localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);

                window.location.href = "<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
            }
            else if($scope.perfil[0].pe_end_num == undefined){
                $localStorage.remove('page');
            
                //$localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);
                window.location.href ="<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
            }else{
                selecionadoEnd(end);
            }
        }  

        else if(end == 'Trabalho') {

            if ($scope.perfil[0].pe_endtrab == "") {
                $localStorage.remove('page');
            
                //$localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);

                window.location.href = "<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
            }
           
            else if($scope.perfil[0].pe_endtrab == undefined){
                $localStorage.remove('page');
            
                //$localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);

                window.location.href = "<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
            }
            else if($scope.perfil[0].pe_end_num == undefined){
                $localStorage.remove('page');
            
                //$localStorage.put('page','<?=$urlAssets?>endereco/local_entrega/'+$scope.perfil[0].pe_site);
                window.location.href ="<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
            }else{
                selecionadoEnd(end);
            }
        }

        else if(end == 'retirar'){
            
            selecionadoEnd(end);
        }else{
            selecionadoEnd(end);
        }
        
        
    }

    $scope.nextPageCadEnd = function(){
        $localStorage.remove('page');
        
        $localStorage.put('page','<?=$urlAssets?>sacola/'+$scope.empresa[0].em_cod + '/'+$scope.empresa[0].em_token);

        window.location.href = "<?=$urlAssets?>endereco/cadastrar/"+$scope.perfil[0].pe_site
        
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
           console.log($scope.logradouro);
           
        }).catch(function onError(response){

        });

    };
});