(function() {
    'use strict';

    var app = angular.module('modules');

    app.$inject = ['$scope', '$sce', 'leasingFactory', '$translate'];

    function leasingCtrl($scope, $sce, leasingFactory, $translate) {
        leasingFactory.getContent($translate.use())
            .then(function(data) {
                $scope.content = $sce.trustAsHtml(data.content);
            });
    }

    app.controller('leasingCtrl', leasingCtrl);
})();