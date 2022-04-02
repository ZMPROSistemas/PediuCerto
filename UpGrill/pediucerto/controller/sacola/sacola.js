angular.module("PediuCerto",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.produtos=[];
    $scope.empresa = $localStorage.get('empresa');
    $scope.subGrupo = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.endereco = $localStorage.get('endereco');
    $scope.formaPagamento =  $sessionStorage.get('fPagamento');
    $scope.cpfCnpj =  $sessionStorage.get('cpfCnpj');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $urlBase = '<?=$urlBase?>'; 
    

    $scope.finalizarPedido = function(obs){
        atualiza();

        if($scope.endereco == null){
            swal({
                title: "Endereço",
                text: "Você precisa adicionar um endereço de entrega!",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site
            })  
        }
        else if($scope.formaPagamento == null){
            
            swal({
                title: "Pagamento",
                text: "Você precisa uma forma de pagamento!",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                $scope.showFormaDePagamento();
            })
        }
        else if($scope.perfil[0].pe_celular == null){
            swal({
                title: "Telefone",
                text: "Você precisa de um numero de telefone cadastrado!",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                window.location.href = '<?=$urlAssets?>verifica/'+ $scope.perfil[0].pe_site;
            })
        }
        else if($scope.empresa[0].em_aberto == 'N'){
           
            swal({
                title: "Estabelecimento Fechado",
                text: "Esse estabelecimento se encontra fechado no momento!",
                icon: "info",
                buttons: {
                    confirm:"OK",
                }
            }).then(confirm=>{
                window.location.href = "<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>"
            }) 
        }
        else{
            var empresa = $scope.empresa;
            var perfil = $scope.perfil;
            var endereco = $scope.endereco;
            var formaPagamento = $scope.formaPagamento;
            var cpfCnpj = $scope.cpfCnpj;
            var sacola = $scope.sacola;
            var totalSacolaValor = $scope.totalSacolaValor;
            $http({
                method:'POST',
                headers: {
                    'Content-Type':'application/json'
                },
                cache: false,
                data:JSON.stringify({
                    empresa:empresa,
                    perfil:perfil,
                    endereco:endereco,
                    formaPagamento:formaPagamento,
                    cpfCnpj:cpfCnpj,
                    sacola:sacola,
                    totalSacolaValor:totalSacolaValor,
                    obs:obs
                }),
                url: '<?=$urlAssets?>services/finalizar_pedido'
            }).then(function onSuccess(response){
                $scope.retorno = response.data;
                console.log($scope.retorno);

                if($scope.retorno[0].status == 'ABERTO'){
                    if($scope.retorno[0].return == 'SUCCESS'){
                        $localStorage.remove('sacola');
                        $localStorage.remove('formaPagamento');

                        swal({
                            title: "Pedido Realizado",
                            text: "Seu pedido foi realizado, aconpanhe o status do pedido em seu perfil!",
                            icon: "success",
                            buttons: {
                                confirm:"OK",
                            }
                        }).then(confirm=>{
                            window.location.href = "<?=$urlAssets?>meus_pedidos/"+$scope.perfil[0].pe_site;
                        }) 
                    }
                }
            }).catch(function onError(response){

            });
        }
    }

    
    var atualizaEndereco = function(){
        
        if($scope.perfil != null){

            if ($scope.endereco == null) {
                $localStorage.remove('endereco');
                $http({
                    method:'POST',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    cache: false,
                    data:JSON.stringify({

                    }),
                    url: '<?=$urlAssets?>services/endereco?user='+$scope.perfil[0].pe_id
                }).then(function onSuccess(response){

                    $scope.endereco = [{
                        'local': response.data[0].ul_local,
                        'pe_endereco': response.data[0].ul_endereco,
                        'pe_end_num' : response.data[0].ul_end_num,
                        'pe_bairro': response.data[0].ul_bairro,
                        'pe_cidade': response.data[0].ul_cidade,
                        'pe_uf' : response.data[0].ul_uf,
                        'pe_end_comp': response.data[0].ul_end_comp,
                    }];

                    $localStorage.put('endereco', $scope.endereco);
                }).catch(function onError(response){

                });
            }
        }
    }

    atualizaEndereco();

    <?php
        include_once('controller/app/sacola.js');
    ?>

    verSacolaCache();

    <?php
        include_once('api/cache.js');
    ?>

    $scope.showFormaDePagamento  = function() {
        //alert();
        $('#formaPagemento').modal('show');
      
        /*
        $mdBottomSheet.show({
            templateUrl: '<?=$urlAssets?>resources/modal/Formas_de_Pagamento.html',
            controller: 'PediuCertoCtrl',
            
        }).then(function() {
            
        }).catch(function() {
            
        });
        */
    }

    $scope.showPagamentoDinheiro = function() {
        $('#formaPagemento').modal('hide');
        $('#formaDinheiro').modal('show');
    }


    $scope.addFormaDePagamento = function(e,troco){
        $sessionStorage.remove('fPagamento');
        
        
        if (e == 'c') {
            $scope.formaPagamento = [{
                'tipo':'C',
                'forma' :'Cartão de Credito/Debito',
                'trocoP':"R$0,00"
            }];
            $('#formaPagemento').modal('hide');
        }
        else if(e == 'D'){
            $scope.formaPagamento = [{
                'tipo':'D',
                'forma' :'Dinheiro',
                'trocoP':troco
            }];
            $('#formaDinheiro').modal('hide');
           
        }
        
        $sessionStorage.put('fPagamento', $scope.formaPagamento,30);
        console.log($scope.formaPagamento);
        
        
    }

    $scope.modalcpf_cnpj  = function() {
       
        $('#cpf_cnpj').modal('show');

        /*
        $mdBottomSheet.show({
            templateUrl: '<?=$urlAssets?>resources/modal/cpf_cnpj.html',
            controller: 'PediuCertoCtrl',
            
        }).then(function() {
            
        }).catch(function() {
            
        });
        */
    }

    $scope.addCpfCnpj = function(cpfCnpj){
        $sessionStorage.remove('cpfCnpj');
        $scope.cpfCnpj = cpfCnpj;
        $sessionStorage.put('cpfCnpj',$scope.cpfCnpj,15);
        $mdBottomSheet.hide();
        $('#cpf_cnpj').modal('hide');
    }


})
