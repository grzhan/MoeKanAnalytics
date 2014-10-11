'use strict';

/**
 * @ngdoc function
 * @name moeKanApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the moeKanApp
 */
angular.module('moeKanApp')
  .controller('MainCtrl', function ($http,$scope,$rootScope) {

    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    $scope.kanname = undefined;
    $scope.knames = [];
    $scope.knameIndex = [];
    $scope.hotkans = ['长门', '大和', '瑞凤', '岛风', '雪风', 
    '大凤','铃谷','熊野','伊58','伊168','伊8','翔鹤','瑞鹤','苍龙','飞龙'];

    $http.get($rootScope.serverUrl + '/kan/names')
    .success(function(data,status,headers,config) {
    	for (var i=0;i<data.length;i++) {
    		$scope.knameIndex[data[i]['ship_name_sim']] = parseInt(data[i]['ship_id']);
    		$scope.knameIndex[data[i]['ship_name']] = parseInt(data[i]['ship_id']);
    		$scope.knames.push(data[i]['ship_name_sim']);
    	}
    	console.log($scope.knames);
    }).error(function(data,status,headers,config) {
    	console.error('HTTP Error Occured: ' + data);
    });

    $scope.setInputKan = function(kname) {
    	$scope.kanname = kname;
    }
});
