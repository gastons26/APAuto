(function() {
	'use strict';
	
	var app = angular.module('apAuto.components', []).directive('navbar', ['$translate', '$route', function($translate, $route) {
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

				$scope.setLanguage = function ($lang) {
					$translate.use($lang);
					$route.reload();
					$scope.setActive($scope.activeTab);
				};

				$scope.getLanguage = function() {
					return $translate.use();
				};
			}]
		  };
	}]);
})();