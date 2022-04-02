

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
				//$scope.tipoGrupo = '';
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
				
			<?php
				  include_once('api/cache.js');
			?>

			$scope.addProd = function(item,tipo) {
				$localStorage.remove('itemProduto');
				$localStorage.put('itemProduto', item);

				//var getItem = $localStorage.get('itemProduto');
				
				console.log(tipo);
				if (tipo=='N'){
				  window.location.href ="<?=$urlAssets?>produto/<?=$route['id']?>/<?=$route['token']?>"
				} else if(tipo=='P'){
					window.location.href ="<?=$urlAssets?>produtoPizza/<?=$route['id']?>/<?=$route['token']?>"	
				}  
			}

		/*	$scope.installer= $localStorage.get('installer');

			if($scope.installer == undefined){
				
			}
*/
			$scope.navScroll = function(id){
				navScroll(id)
			}

		});

		//document.getElementById("life-in-job").addEventListener('click', function(){butEvent = 1;topFunction();});

		function navScroll(id){
			var grupo = document.getElementById(id);
			window.scrollTo({top: grupo.offsetTop, behavior: 'smooth'});
			
		}
		
		var bannerInstall;
		var btnBannerInstall = document.getElementById("btnAddApp");
		var divBannerInstall = document.getElementById("blocoApp");
		var divAppInstalado  = document.getElementById("msgAppInstalado");

	/*	
	var bannerInstall;
	var btnBannerInstall = document.getElementById("btnAddApp");
	var divAppInstalado  = document.getElementById("msgAppInstalado");
	
	
		window.addEventListener('beforeinstallprompt', (event) => {
			alert();
			event.preventDefault();
			
			bannerInstall = event;
	  
			btnBannerInstall.disabled = false;
			divBannerInstall.style.display = 'block';
			btnBannerInstall.disabled = false;
			//$('#app').modal('show');
			
				showBannerInstall();
				return false;
		  });
	
	
	/*
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
		
	});*/