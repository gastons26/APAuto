(function () {
  'use strict';

// Declare app level module which depends on views, and components
  angular.module('apAuto', [
	  'ngRoute',
	  'modules',
	  'apAuto.components',
	  'pascalprecht.translate',
	  'ngCookies'
  ]).config(['$locationProvider', '$routeProvider', '$translateProvider', function ($locationProvider, $routeProvider, $translateProvider) {
	  //$locationProvider.hashPrefix('!');

	  $translateProvider.translations('en_EN', {
		  'E-pasts' : 'Mail',
		  'telefons' : 'phone',
		  'Auto parks': 'Auto park',
		  'Līzings': 'Leasing',
		  'Kontakti': 'Contacts'
	  });
	  

	  $translateProvider.translations('ru_RU', {
		  'E-pasts' : 'Эл. почта',
		  'telefons' : 'телефон',
		  'Auto parks': 'Автопарк',
		  'Līzings': 'Лизинг',
		  'Kontakti': 'Контакты'
	  });

	  $translateProvider.preferredLanguage('lv_LV');
	  $translateProvider.useLocalStorage();


	  $routeProvider.
	  	when('/about', {
			templateUrl: 'modules/about/about.html',
			controller: 'aboutCtrl'
		}).
		when('/leasing', {
			templateUrl: 'modules/leasing/leasing.html',
			controller: 'leasingCtrl',

		}).
	  	when('/', {
		  templateUrl: 'modules/index/index.html',
		  controller: 'indexCtrl',
	  }).otherwise({redirectTo: '/'});
  }]);
})();