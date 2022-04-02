$scope.urlImage = 'https://zmsys.com.br/images/sem_imagem_foods.jpg'
$scope.upload = function(croppedDataUrl, picFile) {
    var fileImage = $scope.fileImage;
    console.log(croppedDataUrl + ' - ' + picFile);
    $http({
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        data: {
            image: croppedDataUrl,
            imageName: picFile,
            fileImage: fileImage
        },
        url: $scope.urlBase + 'uploadImage.php?us_id=<?=$us_id?>&matriz=<?=$empresa?>&filial=<?=$empresa_acesso?>&token=<?=$token?>'
    }).then(function onSuccess(response) {
        $scope.urlImage = response.data;
        $scope.produto[0].pd_foto_url = $scope.urlImage;
        $('#ModalImagem').modal('hide');
    }).catch(function onError() {

    });
}