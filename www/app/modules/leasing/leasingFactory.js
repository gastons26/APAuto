(function() {
    var app = angular.module('module.about').factory('leasingFactory', ['$http', '$q', function($http, $q) {

        var apiBaseUrl = '/APAuto/api/web/index.php/page/';

        return {
            getContent: function(lang)
            {
                var deferred = $q.defer();

                var content = 'ERROR';

                $http.get(apiBaseUrl + 'view?lang='+lang + '&alt_id=LEASING').success(function(data) {
                    deferred.resolve(data);
                });
                return deferred.promise;
            }
        }
    }]);
})();