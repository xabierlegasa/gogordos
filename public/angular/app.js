'use strict';
//
// // Declare app level module which depends on views, and components
// angular.module('myApp', [
//     'ngRoute',
//     'myApp.view1',
//     'myApp.signUp'
// ]).
// config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
//     $locationProvider.hashPrefix('!');
//
//     $routeProvider.otherwise({redirectTo: '/'});
// }]);


angular.module('myapp', [
    'ui.router'
])
    
    .config(function($stateProvider, $urlRouterProvider){

    // For any unmatched url, send to /state1
    $urlRouterProvider.otherwise("/state1")

    $stateProvider
        .state('state1', {
            url: "/state1",
            templateUrl: "state1.html"
        })
        .state('state1.list', {
            url: "/list",
            templateUrl: "state1.list.html",
            controller: function($scope){
                $scope.items = ["A", "List", "Of", "Items"];
            }
        })

        .state('state2', {
            url: "/state2",
            templateUrl: "state2.html"
        })
        .state('state2.list', {
            url: "/list",
            templateUrl: "state2.list.html",
            controller: function($scope){
                $scope.things = ["A", "Set", "Of", "Things"];
            }
        })
})


// // Declare app level module which depends on views, and components
// angular.module('myApp', [
//     'ui.router'
// ])
//
// .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
//
//     // For any unmatched url, redirect to /state1
//     $urlRouterProvider.otherwise("/state2");
//
//     $stateProvider
//         .state('/state1', {
//             url: "/state1",
//             templateUrl: "angular/state1/state1.html"
//         })
//         .state('state1.list', {
//            url: "/list",
//             templateUrl: "angular/state1/state1.list.html",
//             controller: function($scope) {
//                 $scope.items = ["A", "List", "Of", "Items"]
//             }
//         })
//         .state('/state2', {
//             url: "/state2",
//             templateUrl: "angular/state2/state2.html"
//         })
//         .state('state2.list', {
//             url: "/list",
//             templateUrl: "angular/state2/state2.list.html",
//             controller: function($scope) {
//                 $scope.items = ["A", "Set", "Of", "Things"]
//             }
//         });
// }]);