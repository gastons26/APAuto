(function() {
	'use strict';

	var app = angular.module('modules');

	app.controller('aboutCtrl', ['$scope', 'aboutFactory', '$sce', '$translate', function($scope, aboutFactory, $sce, $translate) {

        var key = 'AIzaSyAyU54zDVUSAbVdD6pNVxbeLjGgu_-vUug';

        $scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 8 };

        $scope.contactForm = {
            name: null,
            mail: null
        }

		aboutFactory.getContent($translate.use())
            .then(function(data) {
                $scope.content = $sce.trustAsHtml(data.content);
            });


	}]);
})();