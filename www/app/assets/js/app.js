(function () {
  'use strict';

// Declare app level module which depends on views, and components
  angular.module('myApp', [
    'ngRoute',
    'module.about',
    'module.leasing',
	'component.navbar'
  ]).config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
    $locationProvider.hashPrefix('!');

    $routeProvider.
		when('/about', {
			templateUrl: 'modules/about/index.html',
			controller: 'aboutCtrl'
		}).
		when('/leasing', {
			templateUrl: 'modules/leasing/index.html',
			controller: 'leasingCtrl'
		})
		.otherwise({redirectTo: '/'});
  }]);
})();