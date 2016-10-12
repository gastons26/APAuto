(function() {
    var app = angular.module('modules').factory('aboutFactory', ['$http', '$q', function($http, $q) {

        var apiBaseUrl = '/APAuto/api/web/index.php/page/';

        return {
            getContent: function(lang)
            {
                var deferred = $q.defer();

                $http.get(apiBaseUrl + 'view?lang='+lang + '&alt_id=CONTACTS').success(function(data) {
                    deferred.resolve(data);
                });
                return deferred.promise;
            }
        }
    }]);
})();