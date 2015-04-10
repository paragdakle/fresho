
var app = angular.module('profileApp', []);

app.controller('profileController', function($scope, $http) {
    $scope.admin = false;
	$scope.displayName = "parag.dakle@gmail.com";
});