

		angular.module("PediuCerto",['ngMessages','ngMaterial']);
	    angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll) {
				
				$scope.empresa = [];
				$scope.subGrupo = [];
				$urlBase = '<?=$urlBase?>'; 
				//$urlBase ='http://sistema.zmpro.com.br/';
				

				var dadosEmpresa = function () {
					$http({
						method: 'POST',
						headers: {
							'Content-Type':'application/json'
						  },
						cache: false,
						data:JSON.stringify({
							id: "<?=$route['id']?>",
							token: "<?=$route['token']?>"
						}),
						url: $urlBase + 'services/abrirEmpresa.php?dadosEmpresa=S'
					}).then(function onSuccess(response){
						$scope.empresa = response.data;
					}).catch(function onError(response){

		    		});
				}

				dadosEmpresa();
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
					}).catch(function onError(response){

		    		});
				}

				subGrupoProd();

				$scope.produtos = [];

				var buscarProduto = function(subgrupo) {
					$http({
						method:'POST',
						headers:{
							'Content-Type': 'application/json'
						},
						data:{
							id: "<?=$route['id']?>",
							token: "<?=$route['token']?>",
							subgrupo : subgrupo
						},
						url :$urlBase + 'services/Produtos.php?buscarProdutosFoods=S'
					}).then(function onSuccess(response){
						$scope.produtos = response.data;
					}).catch(function onError(response){

		    		});

				}

				buscarProduto(1);
				

		});
		
		