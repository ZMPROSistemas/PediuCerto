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
    $scope.cacheSubg = $localStorage.get('cacheSubg');
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.selectEnd =  $sessionStorage.get('selectEnd');
    $scope.disabled = false;
    $scope.page = $localStorage.remove('page');
    $urlBase = '<?=$api?>';
     
    $scope.taxa = [];

    //console.log($scope.selectEnd);

    var buscaTaxa =  function(){

        if($scope.endereco != undefined && $scope.endereco[0].local != "Retirar No Estabelecimento"){
            var bairro = $scope.endereco[0].pe_bairro;
            var token = $scope.empresa[0].em_token;
            $http({
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    bairro: bairro,
                    token : token
                }),
                url: '<?=$api?>taxa'
            }).then(function onSuccess(response){
                $scope.taxa = response.data;

                if($scope.taxa == undefined){
                    
                }
                
                if($scope.taxa.length == 0 || $scope.endereco[0].pe_cidade != $scope.empresa[0].em_cid){
                    swal({
                        title: "Aviso",
                        text: "Não entregamos nesse endereço, retirar no local ou mudar o endereço !",
                        //text: "Cidade: "+$scope.endereco[0].pe_cidade+' != '+$scope.empresa[0].em_cid+' '+$scope.taxa.length+'==0',
                        icon: "info",
                        buttons: {
                            cancel: "Retirar no local",
                            catch: {
                                text: "Mudar Endereço",
                                value: "mudar",
                            },
                            //confirm:"Mudar Endereço",
                        }
                    }).then((value) =>{
                        console.log(value);
                        if(value == 'mudar'){
                            window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site
                        }else{
                            console.log($scope.endereco);
                            $scope.endereco = [];
                            $localStorage.remove('endereco');
                            $scope.endereco.push({
                                'local':'Retirar No Estabelecimento',
                            });

                            $localStorage.put('endereco', $scope.endereco);
                            $sessionStorage.put('selectEnd', 'true')
                            location.reload();
                        }
                        
                    })
                }
                console.log($scope.taxa);
            }).catch(function onError(response){

            })
        }
        
    }

    buscaTaxa();
    
    $scope.confirmarPedido = function(){
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
        }else{
            $('#confirmar').modal('show');
            
        }
        
    }

    $scope.btnDisable = false;
    $scope.disabledPed = false;

    $scope.formatarMoeda =function(valor){
        // alert('oi');

        // var elemento = document.getElementById('valor');
        // var valor = elemento.value;

        // valor = valor + '';
        // valor = parseInt(valor.replace(/[\D]+/g, ''));
        // valor = valor + '';
        // valor = valor.replace(/([0-9]{2})$/g, ",$1");

        // if (valor.length > 6) {
        //     valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        // }

        // elemento.value = valor;
        // if(valor == 'NaN') elemento.value = '';
    }

    $scope.finalizarPedido = function(obs){
        //atualiza();
        $scope.btnDisable = true;

        $scope.aguardeTest = "Finalizando seu pedido aguarde";
        $scope.disabledPed = true;
        if($scope.endereco == null){
            swal({
                title: "Endereço",
                text: "Você precisa adicionar um endereço de entrega !",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site
            })  
            $scope.btnDisable = false;
        }
        else if($scope.formaPagamento == null){
            
            swal({
                title: "Pagamento",
                text: "Você precisa uma forma de pagamento !",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                $scope.showFormaDePagamento();
            })
            $scope.btnDisable = false;
        }
        else if($scope.perfil[0].pe_celular == null){
            swal({
                title: "Telefone",
                text: "Você precisa de um numero de telefone cadastrado !",
                icon: "info",
                buttons: {
                    confirm:"Adcionar agora!",
                }
            }).then(confirm=>{
                window.location.href = '<?=$urlAssets?>verifica/'+ $scope.perfil[0].pe_site;
            })
            $scope.btnDisable = false;
        }
        else if($scope.empresa[0].em_aberto == 'N'){
           
            swal({
                title: "Estabelecimento Fechado",
                text: "Esse estabelecimento se encontra fechado no momento !",
                icon: "info",
                buttons: {
                    confirm:"OK",
                }
            }).then(confirm=>{
                window.location.href = "<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>"
            }) 
        }
        else{
            $scope.disabledPed = true;
            var empresa = $scope.empresa;
            var perfil = $scope.perfil;
            var endereco = $scope.endereco;
            var formaPagamento = $scope.formaPagamento;
            var cpfCnpj = $scope.cpfCnpj;
            var sacola = $scope.sacola;
            var totalSacolaValor = $scope.totalSacolaValor;
            var adicionais = $scope.adicional;
            //var valorEntrega = 0;
            //console.log($scope.taxa);
            if ($scope.taxa.length==0){
                var valorEntrega = 0;
            } else {
                var valorEntrega = $scope.taxa[0].ba_taxa;
            }
            // try {
            //     var valorEntrega = $scope.taxa[0].ba_taxa;
            // } catch (Exception $e){
            //     var valorEntrega = 0;
            // }
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
                    valorEntrega:valorEntrega,
                    adicionais:adicionais,
                    obs:obs
                }),
                url: '<?=$api?>finalizar_pedido'
            }).then(function onSuccess(response){
                $scope.retorno = response.data;
                console.log($scope.retorno);

                if($scope.retorno[0].status == 'ABERTO'){
                    if($scope.retorno[0].return == 'SUCCESS'){
                        $localStorage.remove('sacola');
                        $localStorage.remove('formaPagamento');
                        $localStorage.remove('adicionais');
                        $sessionStorage.remove('fPagamento');
                        $sessionStorage.remove('numero');
                        $sessionStorage.remove('countNew');
                        $scope.disabled = false;
                        swal({
                            title: "Pedido Realizado",
                            text: "Seu pedido foi realizado, acompanhe o status do pedido em seu perfil !",
                            icon: "success",
                            buttons: {
                                confirm:"OK",
                            }
                        }).then(confirm=>{
                           window.location.href = "<?=$urlAssets?>meus_pedidos/"+$scope.perfil[0].pe_site;
                        })
                        
                        $('#confirmar').modal('hide');
                    }
                }else{

                    $scope.btnDisable = false;
                    $scope.disabledPed = false;
                    swal({
                        title: "Endereço Inválido",
                        text: "Seu endereço não está correto, altere-o para realizar seu pedido !",
                        icon: "info",
                        buttons: {
                            confirm:"Alterar",
                        }
                    }).then(confirm=>{
                       window.location.href = "<?=$urlAssets?>endereco/cadastrar/perfil/"+$scope.perfil[0].pe_site;
                    })
                    
                    //$('#confirmar').modal('hide');                    
                }
            }).catch(function onError(response){


                swal({
                    title: "Algo deu Errado",
                    text: "Esse estabelecimento se encontra fechado no momento !",
                    icon: "info",
                    buttons: {
                        confirm:"OK",
                    }
                }).then(confirm=>{
                    window.location.href = "<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>"
                }) 

                $scope.retorno = response.data;
                console.log($scope.retorno);
                console.log("<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>");
                //$scope.disabled = false;
                // swal({
                //     title: "Algo deu Errado",
                //     text: "Alguma informação do seu cadastro está errada !",
                //     icon: "info",
                //     buttons: {
                //         confirm:"OK",
                //     }
                // }).then(confirm=>{
                //     window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site;
                // })
                $scope.btnDisable = false;
                $scope.disabledPed = false;
                window.location.href = "<?=$urlAssets?>estabelecimento/<?=$route['id']?>/<?=$route['token']?>";
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
                    url: '<?=$api?>endereco?user='+$scope.perfil[0].pe_id
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

    //verSacolaCache();

    <?php
        include_once('api/cache.js');
    ?>

    
    $scope.adicional = [];
    
    var atualizarItemAdicional = function(){
        var cache = $localStorage.get('adicionais');
        var i=0;

        angular.forEach(cache, function(value, key){
            $scope.adicional.push(cache[key]);
        });

    }
    atualizarItemAdicional();

    $scope.showFormaDePagamento  = function() {
        //alert();
        $('#formaPagemento').modal('show');
      
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

            var troco = troco.replace('R','');
            troco = troco.replace('$','');
            troco = troco.replace(',','.');
            

            $scope.formaPagamento = [{
                'tipo':'D',
                'forma' :'Dinheiro',
                'trocoP':troco
            }];
            $('#formaDinheiro').modal('hide');
           
        }
        
        $scope.confirmarPedido();

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

    if($scope.selectEnd != undefined){
        if($scope.formaPagamento == undefined){
            $scope.showFormaDePagamento();
        }
        if($scope.formaPagamento != undefined){
            $scope.confirmarPedido();
        }
        
        $sessionStorage.remove('selectEnd');
    }

    $scope.removerItemSacola = function(e){
        
        $localStorage.remove('sacola');
        $localStorage.remove('adicionais');

        var key = $scope.sacola.indexOf(e);
        $scope.sacola.splice(key,1);

        for (i = 0; i < $scope.adicional.length; i++){
            if($scope.adicional[i].produto == e.item){
                $scope.adicional.splice(i,1);
            }
        }

        $localStorage.put('sacola', $scope.sacola,30);
        $localStorage.put('adicionais', $scope.adicional,30);

        somarTotalSacola();
    }

    $scope.mostrarAdd = function(item){
        $('#item'+item).toggle("slow");
        
    }

    $scope.mostrarAdd_confirmar = function(item){
        $('#item_confirmar'+item).toggle("slow");
        
    }

    <?php
        include_once('controller/app/login.js');
    ?>

    <?php
        include_once('controller/app/send-sms.js');
    ?>

    <?php
        include_once('controller/app/criar-conta.js');
    ?>
    <?php
        include_once('controller/app/alterar-senha.js');
    ?>



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
})
