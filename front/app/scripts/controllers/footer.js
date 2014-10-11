'use strict';

/**
 * @ngdoc function
 * @name moeKanApp.controller:FooterCtrl
 * @description
 * # FooterCtrl
 * Controller of the moeKanApp
 */
angular.module('moeKanApp')
  .controller('FooterCtrl', function ($scope,$http,$rootScope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    $scope.profile_ = {};

    $http.get($rootScope.serverUrl + '/profile').success(function(data,status,headers,config) {
        $scope.profile_.total = data.total;
        $scope.profile_.item = data.item;
        $scope.profile_.large = data.large;
        var timestamp = new Date(parseInt(data.timestamp) * 1000);
        $scope.profile_.timestamp = timestamp.toLocaleString();
        // $scope.profile_.timestamp = data.timestamp;
    }).error(function(data,status,headers,config){
        console.error("HTTP Error Occured: " + data);
    });

  });
