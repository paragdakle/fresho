
var app = angular.module('settingsApp', []);

app.controller('settingsController', function($scope, $http) {
    $scope.admin = true;
	$scope.displayName = "parag.dakle@gmail.com";
	
	$http.get("/render/getUsers")
		.success(function(response) {
			$scope.body_container_content = response;
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