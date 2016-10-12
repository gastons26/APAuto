(function() {
	'use strict';

	var app = angular.module('modules');

	app.controller('aboutCtrl', ['$scope', 'aboutFactory', '$sce', '$translate', function($scope, aboutFactory, $sce, $translate){

		aboutFactory.getContent($translate.use())
            .then(function(data) {
                $scope.content = $sce.trustAsHtml(data.content);
            });


	}]);
})();