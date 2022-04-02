angular.module('app', ['angular.viacep'])
  .controller('ctrl', function ctrl($scope) {
    $scope.address = {
        zipcode: null,
        street: null,
        neighborhood: null,
        uf: null,
        city: null,
        unit: null,
        ibge: null,
        gia: null,
    }
  });