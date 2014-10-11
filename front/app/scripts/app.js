'use strict';

/**
 * @ngdoc overview
 * @name moeKanApp
 * @description
 * # moeKanApp
 *
 * Main module of the application.
 */
angular
  .module('moeKanApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }).run(function($rootScope){
      $rootScope.serverUrl = 'http://localhost/MoeKancolle';
  });
