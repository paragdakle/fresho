
var app = angular.module('settingsApp', []);

app.controller('settingsController', function($scope, $http, $compile) {
    $scope.admin = true;
	$scope.displayName = "parag.dakle@gmail.com";
	
	$http.get("/render/getUsers")
		.success(function(response) {
			var body_container = $("#body_container");
			body_container.html(response);
			$compile(body_container.contents())($scope);
		});

	$http.get("/settings/getUsers")
		.success(function(response) {
			if(response.status == 400) {
				$scope.table_items = false;
			}
			else if(response.status == 200) {
				$scope.table_items = response.users;
			}
		});
	
	$scope.showUsers = function() {
		$http.get("/render/getUsers")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getUsers")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.users;
				}
			});
			
		$scope.currentTab = "User";
	}
	
	$scope.showOrders = function() {
		$http.get("/render/getOrders")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getOrders")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.orders;
				}
			});
			
		$scope.currentTab = "Order";
	}
	
	$scope.showVendors = function() {
		$http.get("/render/getVendors")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getVendors")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.vendors;
				}
			});
			
		$scope.currentTab = "Vendor";
	}
	
	$scope.showFruits = function() {
		$http.get("/render/getFruits")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getFruits")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.fruits;
				}
			});
			
		$scope.currentTab = "Fruit";
	}
	
	$scope.showJuices = function() {
		$http.get("/render/getJuices")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getJuices")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.juices;
				}
			});
			
		$scope.currentTab = "Juice";
	}
	
	$scope.showSalads = function() {
		$http.get("/render/getSalads")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getSalads")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.salads;
				}
			});
			
		$scope.currentTab = "Salad";
	}
	
	$scope.showNutrients = function() {
		$http.get("/render/getNutrients")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getNutrients")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.nutrients;
				}
			});
			
		$scope.currentTab = "Nutrient";
	}
	
	$scope.showStatistics = function() {
		$http.get("/render/getStatistics")
			.success(function(response) {
				var body_container = $("#body_container");
				body_container.html(response);
				$compile(body_container.contents())($scope);
			});

		$http.get("/settings/getStatistics")
			.success(function(response) {
				if(response.status == 400) {
					$scope.table_items = false;
				}
				else if(response.status == 200) {
					$scope.table_items = response.statistics;
				}
			});
			
		$scope.currentTab = "Statistic";
	}
});