(function() {
	'use strict';

	var app = angular.module('module.about', []);

	app.controller('aboutCtrl', ['$scope', 'aboutFactory', '$sce', function($scope, aboutFactory, $sce) {
        aboutFactory.getContent('lv_LV')
            .then(function(data) {
                $scope.content = $sce.trustAsHtml(data.content);
            });
	}]);
})();