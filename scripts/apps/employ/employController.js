var employApps = angular.module('employApps', []);

employApps.controller('employListCtrl', function($scope, $http, $location) {

	// console.log($location);
	
	$http.get('http://localhost/diagonalley/index.php/employ/employ_json_action/getlist/1', null).then(
		function (response) {
			$scope.data = response.data;
		}
	);
	
	
});
