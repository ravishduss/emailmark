 var app1 = angular.module('app1', []);


 app1.controller('MyControl',function ($scope){

    $scope.message = "Hello World";
 });

 app1.directive('nav1', function(){

    return {
        
        templateUrl : 'html/navbar.html'     
    };
 });