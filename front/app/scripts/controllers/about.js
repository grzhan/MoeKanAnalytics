'use strict';

/**
 * @ngdoc function
 * @name moeKanApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the moeKanApp
 */
angular.module('moeKanApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
