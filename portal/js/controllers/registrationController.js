
var app = angular.module('registrationApp', []);

app.controller('registrationController', function($scope, $http) {
    
	$scope.register = function() {
		if($scope.username == "") {
			alert("Username cannot be empty");
			return false;
		}
		if($scope.password == "") {
			alert("Password cannot be empty");
			return false;
		}
		if($scope.confirm_password == "") {
			alert("Confirm password cannot be empty");
			return false;
		}
		if($scope.confirm_password != $scope.password) {
			alert("Passwords do not match");
			return false;
		}
		
		$http.post("/register/" + encodeURIComponent($scope.username) + "/" + encodeURIComponent(btoa($scope.password)))
			.success(function(response) {
				var data = JSON.parse(response);
				if(data.error == 400) {
					alert(data.message);
				}
				else if(data.error == 200) {
					$("#register-tab").removeClass("active");
					$("#verify-tab").addClass("active");
				}
			});
	}
});