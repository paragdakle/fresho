
var app = angular.module('settingsApp', []);

app.controller('settingsController', function($scope, $http, $compile) {
    $scope.admin = true;
	$scope.displayName = "parag.dakle@gmail.com";
	
	$http.get("/settings/getUsers")
		.success(function(response) {
			var body_container = $("#body_container");
			body_container.html(response);
			$compile(body_container.contents())($scope);
		});

	$http.get("/settings/getUsers")
		.success(function(response) {
			if(response.status == 400) {
				$scope.users = false;
			}
			else if(response.status == 200) {
				$scope.users = response.users;
			}
		});
});