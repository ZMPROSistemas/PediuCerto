
<script type="text/javascript">

	if (screen.width > 768) {
	     window.location = "https://www.zmfit.com.br/";
	}

</script>


<?php

include 'services/conecta.php';
include 'services/alunos.php';

$idaluno = "538";
$dadosAluno = dadosAluno($conexao, $idaluno);


?>

<!DOCTYPE html>

<html lang="pt-br" ng-app="ZMFit">

	<head>

		<title>ZM Fit - Cliente</title>

	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">

	    <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="32x32" />
	    <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="192x192" />  
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script type="text/javascript" src="js/angular.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script>

			angular.module("ZMFit",[]);
			angular.module("ZMFit").controller("ZMFitCtrl", function ($scope, $http) {
				
				var state='C';
      			var ativo="S";

				$scope.appname = "ZM Fit - Cliente";
				$scope.urlBase="services/";
				$scope.dados=[];
				$scope.actve=1;
      			$scope.dadosAluno = [];

				$scope.categorias = [
					{id: 1, nome: 'aluno-treino.php', ordem: 1, imagem: "png/01.png" },
					{id: 2, nome: 'aluno-avaliacao.php', ordem: 2, imagem: "png/02.png" },
					{id: 3, nome: 'aluno-agenda.php', ordem: 3, imagem: "png/03.png" },
					{id: 4, nome: 'aluno-financeiro.php', ordem: 4, imagem: "png/04.png" },
					{id: 5, nome: 'aluno-mensagens.php', ordem: 5, imagem: "png/05.png" },
				];

 
				var dadosAluno = function (){
					$http({
					  method: 'GET',
					  url: $scope.urlBase+'alunos.php?dadosAluno=S&idaluno='+<?=$idaluno?>
					}).then(function onSuccess(response){
					  $scope.dadosAluno=response.data.result[0];
					//          alert("entrou");
					  
					 }).catch(function onError(response){
					  $scope.resultado=response.data;
					  alert("Erro ao carregar seus treinos. Caso este erro persista, contate o suporte.");              
					//        alert("idtreinoAluno");
					});
				
				};  

				dadosAluno();    

			});

		</script>




		<style type="text/css">
			
	       @media only screen and (max-width: 768px) {
	           html { 
	            right: 0;
	            top: 0;
	            bottom: 0;
	            left: 0;
	            overflow: auto;
	            scroll-behavior: smooth;
	          }	          
	        }

		    body {
				margin: 0;
    			padding: 0;
			}		
		
			.mt-n3 {
 				margin-top: -1rem !important;
			}

			.rounded-circle {

				border-width: 0.3em;
				border-style: solid;
				border-color: #f0e22a;
			}

			.container {

				max-width: 768px;
				background-image: url('png/fundoTreino.jpg');
			    background-repeat: no-repeat;
			    background-size: 100% ;
			    margin: 0 auto;
			    bottom: 0;
			    color: black;
			    left: 0;
			    overflow: auto;
			    padding: 3em;
			    right: 0;
			    top: 0;
			}

		</style>

	</head>

	<body style="background-color: transparent; text-align: right; " ng-controller="ZMFitCtrl">
		<div class="container">
			<div class="row">
		    	<div class="col-12 align-self-center" ng-repeat="dadosAluno in dadosAluno">
		    		
		    		<?php if ($dadosAluno[0]['imagem'] == null){?>
		    	
		    		<div class="col-11 align-self-center">
						<img class="rounded-circle" width="50%" src="images/imgpadrao.jpeg" data-toggle="modal" onclick="loadCamera()" data-target="#camera">
					</div>

				<?php } else{?>

		    		<div  class="col-11 align-self-center">
						<img class="rounded-circle" width="50%" src="../AcademiaNova/images_alunos/<?=$dadosAluno[0]['academia']?>/<?=$dadosAluno[0]['imagem']?>" data-toggle="modal" onclick="loadCamera()" data-target="#camera">
					</div>

				<?php } ?>
				    <!--Modal Foto-->
				    <div class="modal fade" id="camera" role="dialog" aria-labelledby="Câmera" aria-hidden="true">
				      	<div class="modal-dialog modal-sm" role="document">
				        	<div class="modal-content">
				          		<div class="modal-header">
				            		<h5 class="modal-title" id="exampleModalLabel">Alterar Foto de Perfil</h5>
				            		<button type="button" class="close" data-dismiss="modal" onclick="loadCamera()" aria-label="Close">X</button>
				          		</div>
								<div class="modal-body">
									<video autoplay="true" id="webCamera"></video>
									<textarea  type="text" id="base_img" name="base_img" ng-show="false"></textarea>
								</div>

				            		<!--<textarea  type="text" id="base_img" name="base_img"></textarea>
					            <!--<button type="button" class="btn btn-primary" onclick="takeSnapShot()"><i class="fa fa-camera"></i> Tirar foto e salvar</button>-->
				         		<div class="modal-footer">
				            		<button class="btn btn-secondary" data-dismiss="modal" onclick="takeSnapShot()"><i class="fa fa-camera"></i>Tirar foto e salvar</button>
				          		</div>
				        	</div>
				      	</div>
				    </div>
				</div>

				<div class="col-12 align-self-center">
					<ul class="list-unstyled " >
						<li class="media" ng-repeat="linha in categorias">
							<a href="{{linha.nome}}"><img class="ml-5" width="85%" src={{linha.imagem}} ></a>
							<p> </p>
						</li>
						<a href="avaliacao-fisica.php"><img class="mx-auto mb-4" width="50%" src="png/06.png"></a>
					</ul>
				</div>
			</div>
		</div>
		<script src="js/jquery-3.4.1.slim.min.js"></script>
		<script src="js/popper.min.js" ></script>
		<script src="js/bootstrap.min.js"></script>
	</body>


</html>

<script>
	
function loadCamera(){
	//Captura elemento de vídeo

	var video = document.querySelector("#webCamera");
	//As opções abaixo são necessárias para o funcionamento correto no iOS
	video.setAttribute('autoplay', '');
	video.setAttribute('muted', '');
	video.setAttribute('playsinline', '');
	//--

	//Verifica se o navegador pode capturar mídia
	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'user'}})
		.then( function(stream) {
		//Definir o elemento víde a carregar o capturado pela webcam
		video.srcObject = stream;
		})
		.catch(function(error) {

		});
	}
};

function takeSnapShot(){

	//Captura elemento de vídeo
	var video = document.querySelector("#webCamera");

	//Criando um canvas que vai guardar a imagem temporariamente
	var canvas = document.createElement('canvas');
	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;
	var ctx = canvas.getContext('2d');

	//Desnehando e convertendo as minensões
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

	//Criando o JPG
	var dataURL = canvas.toDataURL('image/jpeg'); //O resultado é um BASE64 de uma imagem.
	document.querySelector("#base_img").value = dataURL;

	sendSnapShot(dataURL); //Gerar Imagem e Salvar Caminho no Banco
	desligarCamera();

};

function sendSnapShot(base64){

	var request = new XMLHttpRequest();
	request.open('POST', 'salvar_foto.php?idacad='+<?=$idacademia?>+'&matri='+<?=$matricula?>, true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	request.onload = function() {
		var shutter = new Audio();
		shutter.autoplay = false;
		console.log(request);

		if (request.status >= 200 && request.status < 400) {
			//Colocar o caminho da imagem no SRC
			var data = JSON.parse(request.responseText);

			//verificar se houve erro
			if(data.error){
			alert(data.error);
			return false;
			}

			//Mostrar informações
			//document.querySelector("#imagemConvertida").setAttribute("src", data.img);
			//document.querySelector("#caminhoImagem").getAttribute("input[name='caminhoImagem']", data.img).value;
			//document.querySelector("#caminhoImagem a").innerHTML = data.img.split("/")[1];
			document.getElementById("imagemConvertida").innerHTML =
			'<img src="images_alunos/<?=$idacademia?>/'+data.img+'.png"/>'+
			'<input type="hidden" name="caminhoimagem" value="'+(data.img)+'.png">';

			document.getElementById("#caminhoimagem").setAttribute("href", data.img);

		} else {
			alert( "Erro ao salvar. Tipo:" + request.status );
			}
		};

	request.onerror = function() {
	alert("Erro ao salvar. Back-End inacessível.");
	}

	request.send("base_img="+base64); // Enviar dados
};

function desligarCamera(){

  navigator.getUserMedia({audio: false, video: true},
      function(stream) {
           
          var track = stream.getTracks()[0];  
          track.stop();
      },

      function(error){
          console.log('getUserMedia() error', error);
      });
 };


</script>

