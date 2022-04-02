$scope.urlImage = 'http://sistema.zmpro.com.br/images/produto.jpg'
$scope.upload = function(croppedDataUrl, picFile){
    var fileImage = $scope.fileImage;
    console.log(croppedDataUrl + ' - ' + picFile);
    $http({
        method: 'POST',
        headers:{
            'Content-Type':'application/json'
        },
        data:{
            image:croppedDataUrl,
            imageName:picFile,
            fileImage: fileImage
        },
        url: $scope.urlBase + 'uploadImage.php?us_id=<?=$us_id?>&matriz=<?=$empresa?>&filial=<?=$empresa_acesso?>&token=<?=$token?>'
    }).then(function onSuccess(response){
        $scope.urlImage = response.data;
        $scope.selecionaSubGrupo[0].sbp_imagem = $scope.urlImage;
        $('#ModalImagem').modal('hide');
    }).catch(function onError(){

    });
}