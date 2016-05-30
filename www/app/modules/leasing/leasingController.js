(function() {
    'use strict';

    angular.module('module.leasing', [])
        .controller('leasingCtrl', ['$scope', '$sce', 'leasingFactory', function ($scope, $sce, leasingFactory) {
            leasingFactory.getContent('lv_LV')
                .then(function(data) {
                    $scope.content = $sce.trustAsHtml(data.content);
                });
        }]);
})();