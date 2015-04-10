
var app = angular.module('settingsApp', []);

app.controller('settingsController', function($scope, $http) {
    $scope.admin = true;
	$scope.displayName = "parag.dakle@gmail.com";
});