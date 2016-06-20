(function() {
	'use strict';

	var app = angular.module('module.about', []);

	app.controller('aboutCtrl', ['$scope', 'aboutFactory', '$sce', '$translate', function($scope, aboutFactory, $sce, $translate){
        
		alert($translate.use());
		aboutFactory.getContent('lv_LV')
            .then(function(data) {
                $scope.content = $sce.trustAsHtml(data.content);
            });


	}]);
})();