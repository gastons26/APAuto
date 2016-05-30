(function() {
	'use strict';
	
	var app = angular.module('component.navbar', []).directive('navbar', [function() {
		return {
			restrict: 'E',
			templateUrl: 'components/navbar/navbar.html',
			scope: {
				name: '@',
				activeTab: '@'
			},
			controller: ['$scope', function($scope) {
				
				$scope.isActive = function(tab_index) {
					return $scope.activeTab == tab_index;
				};
				
				$scope.setActive = function(tab_index) {
					$scope.activeTab = tab_index;
				};
				
			}]
		  };
	}]);
})();