

		angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
	    angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
				
				

				//$scope.sacola= [$sessionStorage.get('sacola')];
				
				$scope.empresa = [];
				$scope.subGrupo = [];
				$scope.perfil = $localStorage.get('perfil');
				$scope.cacheEmp = $localStorage.get('cacheEmp');
				$scope.cacheSubg = $localStorage.get('cacheSubg');;
				$scope.cacheProduto = $localStorage.get('cacheProduto');
				$urlBase = '<?=$urlBase?>'; 
				//$urlBase ='http://sistema.zmpro.com.br/';

				

				$scope.totalSubGupo=0;
				
				var subGrupoProd = function () {
					$http({
						method: 'POST',
						headers: {
							'Content-Type':'application/json'
						  },
						data:{
							id: "<?=$route['id']?>",
							token: "<?=$route['token']?>"
						},
						url: $urlBase + 'services/subgrupo.php?subgrupoFoods=S'
					}).then(function onSuccess(response){
						$scope.subGrupo = response.data;
						$scope.totalSubGupo = ($scope.subGrupo.length *140);

						$localStorage.remove('subgrupo');
						$localStorage.put('subgrupo', $scope.subGrupo);

					}).catch(function onError(response){

		    		});
				}

				$scope.produtos = [];
				<?php
					include_once('controller/app/sacola.js');
				?>

				var buscarProduto = function() {
					$http({
						method:'POST',
						headers:{
							'Content-Type': 'application/json'
						},
						data:{
							id: "<?=$route['id']?>",
							token: "<?=$route['token']?>",
							subgrupo : 1
						},
						url :$urlBase + 'services/Produtos.php?buscarProdutosFoods=S'
					}).then(function onSuccess(response){
						$scope.produtos = response.data;
						$localStorage.remove('produtos');
						$localStorage.put('produtos', $scope.produtos)

						verSacolaCache();
					}).catch(function onError(response){

		    		});

				}
				//dadosEmpresa();
				//subGrupoProd();
				//buscarProduto();
				
				
				$scope.detalhesDoItem = function() {
				
					$mdBottomSheet.show({
					  templateUrl: '<?=$urlAssets?>resources/views/Detalhes_Produts.html',
					  controller: 'PediuCertoCtrl',
					  
					}).then(function() {
					  
					}).catch(function(error) {
					  // User clicked outside or hit escape
					});
				  };
			<?php
				  include_once('api/cache.js');
			?>

				 
		});
		

	var bannerInstall;
	var btnBannerInstall = document.getElementById("btnAddApp");
	var divAppInstalado  = document.getElementById("msgAppInstalado");

	window.addEventListener('beforeinstallprompt', (event) => {
		
		event.preventDefault();
		
		bannerInstall = event;
  
		//btnBannerInstall.disabled = false;
		//divBannerInstall.style.display = 'block';
		btnBannerInstall.disabled = false;
		//$('#app').modal('show');
		swal({
			title: 'App',
			text: 'Instale o aplicativo do Apetitoso lanches',
			icon: 'info',
			buttons:{
				cancel: "cancelar",
				catch:{
					text: "Instalar Aplicativo",
					value: "app"
				},
			}
		}).then((value) =>{
			
			if (value == 'app'){
				//alert(value);
				showBannerInstall();
				swal.close();
			}
			
		});
  
		return false;
	  });

	  function showBannerInstall(){
        if(bannerInstall){
            //exibindo o banner
            bannerInstall.prompt();
            //verificando a escolha do usuario
            bannerInstall.userChoice.then(function(choiceResult) {
              if (choiceResult.outcome === 'accepted') {
              //console.log('Usuario aceitou a instalacao');
              } else {
                //console.log('Usuario cancelou a instalacao');
              }
            });
        }

        bannerInstall = null;
    }

	btnBannerInstall.addEventListener('click', showBannerInstall);
		
	window.addEventListener('appinstalled', (e) => {
		btnBannerInstall.disabled = true;
		//$('#app').modal('hide');

		divAppInstalado.style.display = 'block';
		swal.close();
	});