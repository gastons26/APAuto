(function() {
    'use strict';

    var app = angular.module('modules', []);

    app.$inject = ['$scope', '$sce'];

    function indexCtrl($scope, $sce) {
        $scope.content = $sce.trustAsHtml("TODOO");
    }

    
    app.controller('indexCtrl', indexCtrl);
})();