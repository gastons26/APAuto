(function () {
  'use strict';

// Declare app level module which depends on views, and components
  angular.module('myApp', [
    'ngRoute',
    'module.about',
    'module.leasing',
	'component.navbar',
	'pascalprecht.translate',
	  'ngCookies'
  ]).config(['$locationProvider', '$routeProvider', '$translateProvider', function ($locationProvider, $routeProvider, $translateProvider) {
	  $locationProvider.hashPrefix('!');

	  $translateProvider.translations('en_EN', {});
	  $translateProvider.translations('lv_LV', {});
	  $translateProvider.translations('ru_RU', {});
	  $translateProvider.use('en_EN');
	  $translateProvider.useLocalStorage();// saves selected language to localStorage


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