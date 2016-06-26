(function() {
    var app = angular.module('modules').factory('indexFactory', ['$http', '$q', function($http, $q) {

        var apiBaseUrl = '/APAuto/api/web/index.php/page/';

        return {
            getContent: function(lang)
            {
                return 'Cars';
            }
        }
    }]);
})();